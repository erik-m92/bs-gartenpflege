<?php
/**
 * Login, Sessions, CSRF-Schutz und Brute-Force-Bremse für das Admin-Panel.
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

/** Startet die Session mit gehärteten Cookie-Einstellungen. */
function panel_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_name('bsgp_panel');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => panel_base_path() . '/',
        'domain'   => '',
        'secure'   => panel_is_https(),
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

/** Lädt die hinterlegten Zugangsdaten oder null, wenn noch kein Konto existiert. */
function panel_load_user(): ?array
{
    if (!is_readable(PANEL_USERS_FILE)) {
        return null;
    }
    $user = require PANEL_USERS_FILE;
    if (!is_array($user) || empty($user['username']) || empty($user['password_hash'])) {
        return null;
    }
    return $user;
}

/** Schreibt Benutzername + Passwort-Hash nach data/users.php. */
function panel_store_user(string $username, string $password): bool
{
    $record = [
        'username'      => $username,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'created'       => date('c'),
    ];

    $php = "<?php\n"
        . "// Zugangsdaten des Admin-Panels. Nicht ins Repository committen!\n"
        . "// Passwort zuruecksetzen: Datei loeschen und panel/setup.php erneut aufrufen.\n"
        . "return " . var_export($record, true) . ";\n";

    $dir = dirname(PANEL_USERS_FILE);
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return false;
    }
    if (file_put_contents(PANEL_USERS_FILE, $php, LOCK_EX) === false) {
        return false;
    }
    @chmod(PANEL_USERS_FILE, 0640);
    return true;
}

/** Ist überhaupt schon ein Konto eingerichtet? */
function panel_needs_setup(): bool
{
    return panel_load_user() === null;
}

/* ------------------------------------------------------------------ *
 * Brute-Force-Bremse
 * ------------------------------------------------------------------ */

function panel_client_ip(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    return substr(hash('sha256', $ip), 0, 32);
}

function panel_attempts_read(): array
{
    if (!is_readable(PANEL_ATTEMPTS_FILE)) {
        return [];
    }
    $data = json_decode((string) file_get_contents(PANEL_ATTEMPTS_FILE), true);
    return is_array($data) ? $data : [];
}

function panel_attempts_write(array $data): void
{
    $now = time();
    // Abgelaufene Einträge aufräumen, damit die Datei nicht unbegrenzt wächst.
    foreach ($data as $key => $entry) {
        if (($entry['last'] ?? 0) + PANEL_LOCKOUT_SECONDS < $now) {
            unset($data[$key]);
        }
    }
    $dir = dirname(PANEL_ATTEMPTS_FILE);
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return;
    }
    file_put_contents(PANEL_ATTEMPTS_FILE, json_encode($data), LOCK_EX);
    @chmod(PANEL_ATTEMPTS_FILE, 0640);
}

/** Verbleibende Sperrzeit in Sekunden (0 = nicht gesperrt). */
function panel_lockout_remaining(): int
{
    $entry = panel_attempts_read()[panel_client_ip()] ?? null;
    if ($entry === null || ($entry['count'] ?? 0) < PANEL_MAX_ATTEMPTS) {
        return 0;
    }
    $remaining = ($entry['last'] ?? 0) + PANEL_LOCKOUT_SECONDS - time();
    return max(0, $remaining);
}

function panel_register_failure(): void
{
    $data  = panel_attempts_read();
    $key   = panel_client_ip();
    $entry = $data[$key] ?? ['count' => 0, 'last' => 0];
    // Nach Ablauf der Sperre beginnt die Zählung von vorn.
    if (($entry['last'] + PANEL_LOCKOUT_SECONDS) < time()) {
        $entry['count'] = 0;
    }
    $entry['count']++;
    $entry['last'] = time();
    $data[$key]    = $entry;
    panel_attempts_write($data);
}

function panel_clear_failures(): void
{
    $data = panel_attempts_read();
    unset($data[panel_client_ip()]);
    panel_attempts_write($data);
}

/* ------------------------------------------------------------------ *
 * Login / Logout / Zugriffsschutz
 * ------------------------------------------------------------------ */

/** Fingerabdruck des Clients, um geklaute Session-Cookies zu erschweren. */
function panel_fingerprint(): string
{
    return hash('sha256', (string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
}

/**
 * Prüft die Zugangsdaten und legt bei Erfolg die Session an.
 * Gibt eine Fehlermeldung zurück oder null bei Erfolg.
 */
function panel_login(string $username, string $password): ?string
{
    if (panel_lockout_remaining() > 0) {
        return 'Zu viele Fehlversuche. Bitte in ' . ceil(panel_lockout_remaining() / 60) . ' Minuten erneut versuchen.';
    }

    $user = panel_load_user();
    // Auch ohne passenden Benutzer einen Hash prüfen, damit die Antwortzeit nichts verrät.
    $hash = $user['password_hash'] ?? '$2y$12$usedonlyfortimingusedonlyfortimingusedonlyfortimingusedonly';
    $userOk = $user !== null && hash_equals((string) $user['username'], $username);
    $passOk = password_verify($password, $hash);

    if (!$userOk || !$passOk) {
        panel_register_failure();
        usleep(random_int(200000, 400000));
        return 'Benutzername oder Passwort ist falsch.';
    }

    // Hash bei Bedarf auf ein neueres Verfahren heben.
    if (password_needs_rehash((string) $user['password_hash'], PASSWORD_DEFAULT)) {
        panel_store_user($username, $password);
    }

    panel_clear_failures();
    session_regenerate_id(true);
    $_SESSION['user']        = $username;
    $_SESSION['login_time']  = time();
    $_SESSION['last_seen']   = time();
    $_SESSION['fingerprint'] = panel_fingerprint();
    return null;
}

function panel_logout(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => 'Strict',
        ]);
    }
    session_destroy();
}

/** Ist die aktuelle Session gültig? */
function panel_is_logged_in(): bool
{
    if (empty($_SESSION['user'])) {
        return false;
    }
    if (!hash_equals((string) ($_SESSION['fingerprint'] ?? ''), panel_fingerprint())) {
        return false;
    }
    $now = time();
    if ($now - (int) ($_SESSION['last_seen'] ?? 0) > PANEL_IDLE_TIMEOUT) {
        return false;
    }
    if ($now - (int) ($_SESSION['login_time'] ?? 0) > PANEL_ABSOLUTE_TIMEOUT) {
        return false;
    }
    return true;
}

/** Bricht ab und leitet zum Login, wenn keine gültige Sitzung besteht. */
function panel_require_login(): void
{
    panel_session_start();
    if (panel_needs_setup()) {
        panel_redirect('setup.php');
    }
    if (!panel_is_logged_in()) {
        panel_logout();
        panel_session_start();
        panel_redirect('login.php?expired=1');
    }
    $_SESSION['last_seen'] = time();
}

/* ------------------------------------------------------------------ *
 * CSRF
 * ------------------------------------------------------------------ */

function panel_csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return (string) $_SESSION['csrf'];
}

function panel_csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(panel_csrf_token()) . '">';
}

/** Beendet die Anfrage, wenn das CSRF-Token fehlt oder nicht passt. */
function panel_csrf_verify(): void
{
    $token = (string) ($_POST['csrf'] ?? '');
    if ($token === '' || !hash_equals((string) ($_SESSION['csrf'] ?? ''), $token)) {
        http_response_code(400);
        exit('Ungültiges Formular-Token. Bitte die Seite neu laden und noch einmal versuchen.');
    }
}
