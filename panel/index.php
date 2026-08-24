<?php
/**
 * Übersicht aller Projekte: Reihenfolge ändern, sichtbar schalten,
 * auf der Startseite hervorheben, löschen.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/upload.php';

panel_require_login();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    panel_csrf_verify();

    $action   = (string) ($_POST['action'] ?? '');
    $id       = (string) ($_POST['id'] ?? '');
    $projects = projects_load();
    $index    = null;
    foreach ($projects as $i => $project) {
        if ($project['id'] === $id) {
            $index = $i;
            break;
        }
    }

    if ($index === null) {
        panel_flash('error', 'Das Projekt wurde nicht gefunden – vermutlich zwischenzeitlich gelöscht.');
        panel_redirect('index.php');
        exit;
    }

    $title = $projects[$index]['title'];

    switch ($action) {
        case 'up':
        case 'down':
            $target = $action === 'up' ? $index - 1 : $index + 1;
            if ($target >= 0 && $target < count($projects)) {
                [$projects[$index], $projects[$target]] = [$projects[$target], $projects[$index]];
                projects_save($projects)
                    ? panel_flash('ok', 'Reihenfolge geändert.')
                    : panel_flash('error', 'Die Reihenfolge konnte nicht gespeichert werden.');
            }
            break;

        case 'toggle_published':
            $projects[$index]['published'] = !$projects[$index]['published'];
            $state = $projects[$index]['published'] ? 'ist jetzt sichtbar' : 'ist jetzt versteckt';
            projects_save($projects)
                ? panel_flash('ok', '„' . $title . '“ ' . $state . '.')
                : panel_flash('error', 'Die Änderung konnte nicht gespeichert werden.');
            break;

        case 'toggle_featured':
            $projects[$index]['featured'] = !$projects[$index]['featured'];
            $state = $projects[$index]['featured'] ? 'erscheint jetzt auf der Startseite' : 'erscheint nicht mehr auf der Startseite';
            projects_save($projects)
                ? panel_flash('ok', '„' . $title . '“ ' . $state . '.')
                : panel_flash('error', 'Die Änderung konnte nicht gespeichert werden.');
            break;

        case 'delete':
            $image = $projects[$index]['image'];
            array_splice($projects, $index, 1);
            if (projects_save($projects)) {
                panel_delete_upload($image);
                panel_flash('ok', '„' . $title . '“ wurde gelöscht.');
            } else {
                panel_flash('error', 'Das Projekt konnte nicht gelöscht werden.');
            }
            break;

        default:
            panel_flash('error', 'Unbekannte Aktion.');
    }

    panel_redirect('index.php');
    exit;
}

$projects     = projects_load();
$count        = count($projects);
$featuredList = array_values(array_filter($projects, static fn(array $p): bool => $p['featured'] && $p['published']));
$featuredMax  = 4;

panel_header('Projekte');
?>
<main class="panel-main">
  <?php panel_render_flash(); ?>

  <div class="page-title">
    <div>
      <h1>Projekte</h1>
      <p><?= $count ?> Projekt<?= $count === 1 ? '' : 'e' ?> – die Reihenfolge hier entspricht der Reihenfolge auf der Website.</p>
    </div>
    <a class="btn" href="edit.php">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
      Neues Projekt
    </a>
  </div>

  <?php if (count($featuredList) > $featuredMax): ?>
    <div class="flash flash-error" role="status">
      Auf der Startseite ist Platz für <?= $featuredMax ?> Projekte, aktuell sind <?= count($featuredList) ?> hervorgehoben.
      Angezeigt werden die obersten <?= $featuredMax ?> dieser Liste.
    </div>
  <?php endif; ?>

  <?php if (!$projects): ?>
    <div class="card empty">
      <p>Noch keine Projekte angelegt.</p>
      <p class="empty-cta"><a class="btn" href="edit.php">Erstes Projekt anlegen</a></p>
    </div>
  <?php else: ?>
    <div class="project-list">
      <?php foreach ($projects as $i => $project): ?>
        <article class="project-item<?= $project['published'] ? '' : ' is-hidden' ?>">
          <div class="project-thumb">
            <?php if ($project['image'] !== '' && is_file(PROJECTS_ROOT . '/' . $project['image'])): ?>
              <img src="../<?= e($project['image']) ?>" alt="" loading="lazy">
            <?php else: ?>
              <span>kein Bild</span>
            <?php endif; ?>
          </div>

          <div class="project-meta">
            <h3><?= e($project['title']) ?></h3>
            <p><?= e($project['description']) ?></p>
            <div class="badges">
              <?php if ($project['category'] !== ''): ?>
                <span class="badge"><?= e($project['category']) ?></span>
              <?php endif; ?>
              <?php if ($project['featured']): ?>
                <span class="badge badge-lime">Startseite</span>
              <?php endif; ?>
              <?php if (!$project['published']): ?>
                <span class="badge badge-warn">versteckt</span>
              <?php endif; ?>
            </div>
          </div>

          <div class="project-actions">
            <div class="order-controls">
              <form method="post">
                <?= panel_csrf_field() ?>
                <input type="hidden" name="id" value="<?= e($project['id']) ?>">
                <input type="hidden" name="action" value="up">
                <button class="btn btn-icon" type="submit" title="Nach oben" aria-label="<?= e($project['title']) ?> nach oben verschieben" <?= $i === 0 ? 'disabled' : '' ?>>
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
                </button>
              </form>
              <form method="post">
                <?= panel_csrf_field() ?>
                <input type="hidden" name="id" value="<?= e($project['id']) ?>">
                <input type="hidden" name="action" value="down">
                <button class="btn btn-icon" type="submit" title="Nach unten" aria-label="<?= e($project['title']) ?> nach unten verschieben" <?= $i === $count - 1 ? 'disabled' : '' ?>>
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
              </form>
            </div>

            <form method="post">
              <?= panel_csrf_field() ?>
              <input type="hidden" name="id" value="<?= e($project['id']) ?>">
              <input type="hidden" name="action" value="toggle_featured">
              <button class="btn btn-ghost btn-sm" type="submit">
                <?= $project['featured'] ? 'Von Startseite nehmen' : 'Auf Startseite zeigen' ?>
              </button>
            </form>

            <form method="post">
              <?= panel_csrf_field() ?>
              <input type="hidden" name="id" value="<?= e($project['id']) ?>">
              <input type="hidden" name="action" value="toggle_published">
              <button class="btn btn-ghost btn-sm" type="submit">
                <?= $project['published'] ? 'Verstecken' : 'Veröffentlichen' ?>
              </button>
            </form>

            <a class="btn btn-sm" href="edit.php?id=<?= urlencode($project['id']) ?>">Bearbeiten</a>

            <form method="post" data-confirm="Soll das Projekt &bdquo;<?= e($project['title']) ?>&ldquo; wirklich gelöscht werden? Das lässt sich nicht rückgängig machen.">
              <?= panel_csrf_field() ?>
              <input type="hidden" name="id" value="<?= e($project['id']) ?>">
              <input type="hidden" name="action" value="delete">
              <button class="btn btn-danger btn-sm" type="submit">Löschen</button>
            </form>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
<script src="assets/panel.js"></script>
<?php panel_footer(); ?>
