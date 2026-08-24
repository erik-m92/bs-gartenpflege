<?php
/**
 * Einmalige Einrichtung: legt das Admin-Konto an.
 * Sobald data/users.php existiert, ist diese Seite gesperrt.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

panel_session_start();

if (!panel_needs_setup()) {
    http_response_code(403);
    panel_header('Einrichtung abgeschlossen', false);
    echo '<div class="auth-wrap"><div class="auth-card">'
        . '<h1>Einrichtung bereits erfolgt</h1>'
        . '<p class="sub">Es existiert bereits ein Admin-Konto. Diese Seite ist deshalb gesperrt.</p>'
        . '<p class="sub">Passwort vergessen? Melden Sie sich bei ihrem Admin</p>'
        . '<a class="btn btn-dark" href="login.php">Zum Login</a>'
        . '</div></div>';
    panel_footer();
    exit;
}

$errors = [];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    panel_csrf_verify();

    $username = trim((string) ($_POST['username'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $confirm  = (string) ($_POST['password_confirm'] ?? '');

    if (!preg_match('/^[A-Za-z0-9._-]{3,32}$/', $username)) {
        $errors[] = 'Der Benutzername muss 3–32 Zeichen lang sein (Buchstaben, Ziffern, Punkt, Bindestrich, Unterstrich).';
    }
    if (strlen($password) < 12) {
        $errors[] = 'Das Passwort muss mindestens 12 Zeichen lang sein.';
    }
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = 'Das Passwort muss Buchstaben und Ziffern enthalten.';
    }
    if (!hash_equals($password, $confirm)) {
        $errors[] = 'Die beiden Passwörter stimmen nicht überein.';
    }

    if (!$errors) {
        if (!panel_store_user($username, $password)) {
            $errors[] = 'Die Zugangsdaten konnten nicht gespeichert werden. Bitte die Schreibrechte des Ordners data/ prüfen.';
        } else {
            session_regenerate_id(true);
            $_SESSION['user']        = $username;
            $_SESSION['login_time']  = time();
            $_SESSION['last_seen']   = time();
            $_SESSION['fingerprint'] = panel_fingerprint();
            panel_flash('ok', 'Konto angelegt. Willkommen im Admin-Panel!');
            panel_redirect('index.php');
            exit;
        }
    }
}

panel_header('Einrichtung', false);
?>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo" aria-hidden="true">
      <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#143a1f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"/><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"/><path d="M12 22V8"/></svg>
    </div>
    <h1>Admin-Konto anlegen</h1>
    <p class="sub">Einmalige Einrichtung. Danach ist diese Seite automatisch gesperrt.</p>

    <?php if ($errors): ?>
      <div class="flash flash-error" role="alert">
        Bitte korrigieren:
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= e($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
      <?= panel_csrf_field() ?>
      <div class="field">
        <label for="username">Benutzername</label>
        <input type="text" id="username" name="username" required autofocus
               value="<?= e((string) ($_POST['username'] ?? '')) ?>">
      </div>
      <div class="field">
        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required autocomplete="new-password">
        <p class="hint">Mindestens 12 Zeichen, Buchstaben und Ziffern. Am besten aus einem Passwort-Manager.</p>
      </div>
      <div class="field">
        <label for="password_confirm">Passwort wiederholen</label>
        <input type="password" id="password_confirm" name="password_confirm" required autocomplete="new-password">
      </div>
      <button type="submit" class="btn btn-dark">Konto anlegen</button>
    </form>
    <p class="auth-foot">Die Zugangsdaten landen verschlüsselt in <code>data/users.php</code>.</p>
  </div>
</div>
<?php panel_footer(); ?>
