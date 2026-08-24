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

/** Erlaubte Bild-Uploads. */
const PANEL_UPLOAD_MAX_BYTES = 5242880; // 5 MB
const PANEL_UPLOAD_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp',
];

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
