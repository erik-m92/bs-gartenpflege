<?php
/**
 * Basis-Konfiguration des Admin-Panels.
 * Enthält bewusst keine Zugangsdaten – die liegen in data/users.php (nicht im Repo).
 */

declare(strict_types=1);

require_once __DIR__ . '/../../includes/projects.php';

const PANEL_USERS_FILE    = PROJECTS_ROOT . '/data/users.php';
const PANEL_ATTEMPTS_FILE = PROJECTS_ROOT . '/data/login-attempts.json';

/** Nach so vielen Fehlversuchen pro IP wird gesperrt. */
const PANEL_MAX_ATTEMPTS = 5;
/** Dauer der Sperre in Sekunden. */
const PANEL_LOCKOUT_SECONDS = 900;      // 15 Minuten
/** Automatischer Logout nach Inaktivität. */
const PANEL_IDLE_TIMEOUT = 3600;        // 60 Minuten
/** Spätestens danach ist jede Sitzung ungültig, auch bei Aktivität. */
const PANEL_ABSOLUTE_TIMEOUT = 43200;   // 12 Stunden

/** Gewünschtes Upload-Limit. Der Server kann strenger sein – siehe panel_upload_limit_bytes(). */
const PANEL_UPLOAD_MAX_BYTES = 5242880; // 5 MB
const PANEL_UPLOAD_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

/** Wandelt PHP-Größenangaben wie "8M" oder "512K" in Bytes um. */
function panel_ini_bytes(string $value): int
{
    $value = trim($value);
    if ($value === '') {
        return 0;
    }
    $number = (float) $value;
    switch (strtolower($value[strlen($value) - 1])) {
        case 'g': $number *= 1024 * 1024 * 1024; break;
        case 'm': $number *= 1024 * 1024; break;
        case 'k': $number *= 1024; break;
    }
    return (int) $number;
}

/**
 * Was wirklich durchgeht: das Minimum aus dem Wunschlimit und dem, was PHP über
 * upload_max_filesize bzw. post_max_size zulässt. Ohne diese Prüfung verspricht
 * das Formular 5 MB, während der Server schon bei 2 MB abbricht.
 */
function panel_upload_limit_bytes(): int
{
    $limit  = PANEL_UPLOAD_MAX_BYTES;
    $upload = panel_ini_bytes((string) ini_get('upload_max_filesize'));
    if ($upload > 0) {
        $limit = min($limit, $upload);
    }
    // Im POST stecken neben der Datei noch die Formularfelder – dafür etwas Platz lassen.
    $post = panel_ini_bytes((string) ini_get('post_max_size'));
    if ($post > 0) {
        $limit = min($limit, max(0, $post - 65536));
    }
    return $limit;
}

/** Ist der Server strenger als PANEL_UPLOAD_MAX_BYTES? */
function panel_upload_limit_is_capped(): bool
{
    return panel_upload_limit_bytes() < PANEL_UPLOAD_MAX_BYTES;
}

/** Größenangabe für die Anzeige, z. B. "5 MB" oder "1,9 MB". */
function panel_format_bytes(int $bytes): string
{
    if ($bytes >= 1048576) {
        $decimals = $bytes % 1048576 === 0 ? 0 : 1;
        return number_format($bytes / 1048576, $decimals, ',', '.') . ' MB';
    }
    return max(1, (int) round($bytes / 1024)) . ' KB';
}

/** Einheitlicher Text für „Datei zu groß“, inklusive Hinweis auf ein strengeres Serverlimit. */
function panel_upload_too_large_message(): string
{
    $message = 'Die Datei ist zu groß (maximal ' . panel_format_bytes(panel_upload_limit_bytes()) . ').';
    if (panel_upload_limit_is_capped()) {
        $message .= ' Der Server lässt momentan nicht mehr zu (upload_max_filesize = '
            . (string) ini_get('upload_max_filesize')
            . ', post_max_size = ' . (string) ini_get('post_max_size')
            . '). Die vorgesehenen Werte stehen in panel/.user.ini bzw. panel/.htaccess.';
    }
    return $message;
}

/**
 * Wurde post_max_size überschritten? Dann verwirft PHP den kompletten Request-Body:
 * $_POST und $_FILES sind leer, obwohl der Browser Daten geschickt hat. Ohne diese
 * Erkennung landet man in der CSRF-Prüfung und sieht nur „Ungültiges Formular-Token“.
 */
function panel_post_exceeded_limit(): bool
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        return false;
    }
    if ($_POST !== [] || $_FILES !== []) {
        return false;
    }
    return (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0;
}

/** Läuft die Anfrage über HTTPS (auch hinter einem Reverse-Proxy)? */
function panel_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    if (($_SERVER['SERVER_PORT'] ?? '') === '443') {
        return true;
    }
    $proto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '';
    return strtolower((string) $proto) === 'https';
}

/** Basispfad des Panels für Cookies und Redirects, z. B. /panel */
function panel_base_path(): string
{
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/panel/index.php'));
    $dir    = rtrim(dirname($script), '/');
    return $dir === '' ? '/' : $dir;
}

/** Schickt Sicherheits-Header, die für alle Panel-Seiten gelten. */
function panel_security_headers(): void
{
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: no-referrer');
    header('X-Robots-Tag: noindex, nofollow');
    // blob: wird für die Sofort-Vorschau hochgeladener Bilder gebraucht.
    header("Content-Security-Policy: default-src 'self'; img-src 'self' data: blob:; style-src 'self'; script-src 'self'; form-action 'self'; frame-ancestors 'none'; base-uri 'self'");
    header('Cache-Control: no-store, no-cache, must-revalidate');
    if (panel_is_https()) {
        header('Strict-Transport-Security: max-age=31536000');
    }
}

/** Weiterleitung innerhalb des Panels. */
function panel_redirect(string $target): void
{
    header('Location: ' . panel_base_path() . '/' . ltrim($target, '/'));
    exit;
}
