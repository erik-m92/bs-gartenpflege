<?php
/**
 * Gemeinsames Grundgerüst aller Panel-Seiten.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

/**
 * @param string $title       Seitentitel
 * @param bool   $chrome      Kopfzeile mit Navigation anzeigen (im Login/Setup aus)
 */
function panel_header(string $title, bool $chrome = true): void
{
    panel_security_headers();
    $base = panel_base_path();
    ?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title><?= e($title) ?> – BS-Gartenpflege Admin</title>
  <link rel="stylesheet" href="<?= e($base) ?>/assets/panel.css">
</head>
<body>
<?php if ($chrome): ?>
  <header class="panel-header">
    <div class="inner">
      <a class="panel-brand" href="<?= e($base) ?>/index.php">
        <span class="dot" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"/><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"/><path d="M12 22V8"/></svg>
        </span>
        <span>BS-Gartenpflege<small>Admin-Panel</small></span>
      </a>
      <nav>
        <span class="panel-user">Angemeldet als <strong><?= e((string) ($_SESSION['user'] ?? '')) ?></strong></span>
        <a class="btn btn-ghost btn-sm" href="<?= e(rtrim(dirname($base), '/')) ?>/projekte.php" target="_blank" rel="noopener">Website ansehen</a>
        <form method="post" action="<?= e($base) ?>/logout.php" class="inline-form">
          <?= panel_csrf_field() ?>
          <button type="submit" class="btn btn-dark btn-sm">Abmelden</button>
        </form>
      </nav>
    </div>
  </header>
<?php endif; ?>
    <?php
}

function panel_footer(): void
{
    ?>
</body>
</html>
    <?php
}

/** Meldung für die nächste Seite in der Session ablegen (Post/Redirect/Get). */
function panel_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/** Abgelegte Meldung ausgeben und löschen. */
function panel_render_flash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    $class = ($flash['type'] ?? '') === 'error' ? 'flash-error' : 'flash-ok';
    echo '<div class="flash ' . $class . '" role="status">' . e((string) $flash['message']) . '</div>';
}
