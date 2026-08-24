<?php
/**
 * Login-Seite des Admin-Panels.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';

panel_session_start();

if (panel_needs_setup()) {
    panel_redirect('setup.php');
    exit;
}
if (panel_is_logged_in()) {
    panel_redirect('index.php');
    exit;
}

$error  = null;
$notice = isset($_GET['expired']) ? 'Die Sitzung ist abgelaufen. Bitte erneut anmelden.' : null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    panel_csrf_verify();
    $error = panel_login(
        trim((string) ($_POST['username'] ?? '')),
        (string) ($_POST['password'] ?? '')
    );
    if ($error === null) {
        panel_redirect('index.php');
        exit;
    }
    $notice = null;
}

$lockout = panel_lockout_remaining();

panel_header('Login', false);
?>
<div class="auth-wrap">
  <div class="auth-card">
    <div class="auth-logo" aria-hidden="true">
      <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#143a1f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"/><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"/><path d="M12 22V8"/></svg>
    </div>
    <h1>Anmelden</h1>
    <p class="sub">Verwaltung der Projekte auf bs-gartenpflege.de</p>

    <?php if ($error): ?>
      <div class="flash flash-error" role="alert"><?= e($error) ?></div>
    <?php elseif ($notice): ?>
      <div class="flash flash-ok" role="status"><?= e($notice) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
      <?= panel_csrf_field() ?>
      <div class="field">
        <label for="username">Benutzername</label>
        <input type="text" id="username" name="username" required autofocus
               autocomplete="username" <?= $lockout > 0 ? 'disabled' : '' ?>>
      </div>
      <div class="field">
        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required
               autocomplete="current-password" <?= $lockout > 0 ? 'disabled' : '' ?>>
      </div>
      <button type="submit" class="btn btn-dark" <?= $lockout > 0 ? 'disabled' : '' ?>>Anmelden</button>
    </form>
    <p class="auth-foot">
      <?php if ($lockout > 0): ?>
        Gesperrt für noch <?= (int) ceil($lockout / 60) ?> Minute(n).
      <?php else: ?>
        Nach <?= PANEL_MAX_ATTEMPTS ?> Fehlversuchen wird der Zugang für 15 Minuten gesperrt.
      <?php endif; ?>
    </p>
  </div>
</div>
<?php panel_footer(); ?>
