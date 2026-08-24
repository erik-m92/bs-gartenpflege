<?php
/**
 * Bild-Uploads für Projekte: strenge Prüfung, zufälliger Dateiname,
 * Ablage in images/projekte/ (dort ist PHP-Ausführung per .htaccess gesperrt).
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Verarbeitet eine hochgeladene Datei.
 *
 * @return array{ok: bool, path?: string, error?: string}
 */
function panel_handle_upload(array $file): array
{
    $code = $file['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($code === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'error' => 'Keine Datei ausgewählt.'];
    }
    if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) {
        return ['ok' => false, 'error' => panel_upload_too_large_message()];
    }
    if ($code !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => panel_upload_error_message((int) $code)];
    }

    $tmp = (string) ($file['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return ['ok' => false, 'error' => 'Ungültiger Upload.'];
    }
    if (($file['size'] ?? 0) > panel_upload_limit_bytes()) {
        return ['ok' => false, 'error' => panel_upload_too_large_message()];
    }

    // Typ nicht aus dem Dateinamen oder den Browser-Angaben ableiten, sondern aus dem Inhalt.
    $info = @getimagesize($tmp);
    if ($info === false || empty($info['mime'])) {
        return ['ok' => false, 'error' => 'Die Datei ist kein gültiges Bild.'];
    }
    $mime = panel_normalize_mime((string) $info['mime']);
    if ($mime === null) {
        return ['ok' => false, 'error' => 'Nur JPG-, PNG- oder WebP-Bilder sind erlaubt.'];
    }
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo !== false) {
            $detected = (string) finfo_file($finfo, $tmp);
            finfo_close($finfo);
            // Beide Verfahren müssen denselben erlaubten Typ ergeben. Ein reiner
            // String-Vergleich war zu streng: manche libmagic-Versionen melden
            // z. B. image/pjpeg statt image/jpeg und verwarfen gültige Bilder.
            if (panel_normalize_mime($detected) !== $mime) {
                return ['ok' => false, 'error' => 'Der Dateityp konnte nicht eindeutig bestimmt werden.'];
            }
        }
    }

    if (!is_dir(PROJECTS_UPLOADDIR) && !mkdir(PROJECTS_UPLOADDIR, 0755, true) && !is_dir(PROJECTS_UPLOADDIR)) {
        return ['ok' => false, 'error' => 'Das Upload-Verzeichnis konnte nicht angelegt werden.'];
    }
    panel_protect_upload_dir();

    $name   = date('Ymd') . '-' . bin2hex(random_bytes(8)) . '.' . PANEL_UPLOAD_TYPES[$mime];
    $target = PROJECTS_UPLOADDIR . '/' . $name;
    if (!move_uploaded_file($tmp, $target)) {
        return ['ok' => false, 'error' => 'Die Datei konnte nicht gespeichert werden. Schreibrechte prüfen.'];
    }
    @chmod($target, 0644);

    return ['ok' => true, 'path' => PROJECTS_UPLOADURL . '/' . $name];
}

/**
 * Führt bekannte Schreibweisen auf einen erlaubten Typ zurück.
 * Gibt null zurück, wenn der Typ nicht erlaubt ist.
 */
function panel_normalize_mime(string $mime): ?string
{
    $mime = strtolower(trim($mime));
    $aliases = [
        'image/pjpeg' => 'image/jpeg',
        'image/jpg'   => 'image/jpeg',
        'image/x-png' => 'image/png',
    ];
    $mime = $aliases[$mime] ?? $mime;
    return isset(PANEL_UPLOAD_TYPES[$mime]) ? $mime : null;
}

/** Verständlicher Text zu einem PHP-Upload-Fehlercode. */
function panel_upload_error_message(int $code): string
{
    switch ($code) {
        case UPLOAD_ERR_PARTIAL:
            return 'Die Datei wurde nur teilweise übertragen. Bitte noch einmal versuchen.';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Auf dem Server fehlt das temporäre Upload-Verzeichnis (PHP-Einstellung upload_tmp_dir).';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Der Server konnte die Datei nicht auf die Festplatte schreiben (Schreibrechte prüfen).';
        case UPLOAD_ERR_EXTENSION:
            return 'Eine PHP-Erweiterung hat den Upload abgebrochen.';
        default:
            return 'Der Upload ist fehlgeschlagen (Fehlercode ' . $code . ').';
    }
}

/** Legt im Upload-Ordner eine .htaccess an, die Skriptausführung unterbindet. */
function panel_protect_upload_dir(): void
{
    $htaccess = PROJECTS_UPLOADDIR . '/.htaccess';
    if (is_file($htaccess)) {
        return;
    }
    $rules = <<<'HTACCESS'
# Hochgeladene Dateien duerfen niemals als Skript ausgefuehrt werden.
php_flag engine off
<IfModule mod_php.c>
  php_admin_flag engine off
</IfModule>
<FilesMatch "\.(php|php\d|phtml|phar|cgi|pl|py|sh|htaccess)$">
  <IfModule mod_authz_core.c>
    Require all denied
  </IfModule>
  <IfModule !mod_authz_core.c>
    Deny from all
  </IfModule>
</FilesMatch>
Options -ExecCGI -Indexes
AddType text/plain .php .phtml .phar

HTACCESS;
    @file_put_contents($htaccess, $rules);
}

/**
 * Löscht ein früher hochgeladenes Bild – aber nur innerhalb von images/projekte/,
 * damit die mitgelieferten Beispielbilder unangetastet bleiben.
 */
function panel_delete_upload(string $relativePath): void
{
    $relativePath = trim($relativePath);
    if ($relativePath === '' || strpos($relativePath, PROJECTS_UPLOADURL . '/') !== 0) {
        return;
    }
    if (strpos($relativePath, '..') !== false) {
        return;
    }
    $absolute = PROJECTS_ROOT . '/' . $relativePath;
    $real     = realpath($absolute);
    $base     = realpath(PROJECTS_UPLOADDIR);
    if ($real === false || $base === false || strpos($real, $base) !== 0) {
        return;
    }
    @unlink($real);
}

/**
 * Prüft einen manuell eingetragenen Bildpfad (relativ, im Projekt, Bilddatei).
 *
 * @return array{ok: bool, path?: string, error?: string}
 */
function panel_validate_image_path(string $path): array
{
    $path = trim(str_replace('\\', '/', $path));
    if ($path === '') {
        return ['ok' => true, 'path' => ''];
    }
    if (preg_match('#^[a-z]+://#i', $path) || strpos($path, '..') !== false || $path[0] === '/') {
        return ['ok' => false, 'error' => 'Bitte einen relativen Pfad innerhalb der Website angeben, z. B. images/project-1.svg'];
    }
    if (!preg_match('/\.(jpe?g|png|webp|svg|gif)$/i', $path)) {
        return ['ok' => false, 'error' => 'Der Pfad muss auf eine Bilddatei zeigen (jpg, png, webp, svg, gif).'];
    }
    if (!is_file(PROJECTS_ROOT . '/' . $path)) {
        return ['ok' => false, 'error' => 'Unter diesem Pfad liegt keine Datei: ' . $path];
    }
    return ['ok' => true, 'path' => $path];
}

/** Listet bereits vorhandene Bilder aus images/ und images/projekte/ auf. */
function panel_available_images(): array
{
    $found = [];
    foreach (['images', PROJECTS_UPLOADURL] as $dir) {
        $abs = PROJECTS_ROOT . '/' . $dir;
        if (!is_dir($abs)) {
            continue;
        }
        foreach ((array) glob($abs . '/*.{jpg,jpeg,png,webp,svg,gif}', GLOB_BRACE) as $file) {
            $found[] = $dir . '/' . basename((string) $file);
        }
    }
    sort($found);
    return $found;
}
