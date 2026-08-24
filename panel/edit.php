<?php
/**
 * Projekt anlegen oder bearbeiten.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/layout.php';
require_once __DIR__ . '/includes/upload.php';

panel_require_login();

$id       = (string) ($_GET['id'] ?? '');
$isNew    = $id === '';
$projects = projects_load();

$project = project_defaults();
if (!$isNew) {
    $existing = null;
    foreach ($projects as $candidate) {
        if ($candidate['id'] === $id) {
            $existing = $candidate;
            break;
        }
    }
    if ($existing === null) {
        panel_flash('error', 'Dieses Projekt existiert nicht (mehr).');
        panel_redirect('index.php');
        exit;
    }
    $project = $existing;
}

$errors = [];

if (panel_post_exceeded_limit()) {
    // PHP hat den kompletten Request verworfen – es gibt weder $_POST noch $_FILES.
    $errors[] = 'Das Formular konnte nicht gesendet werden, weil die Daten zusammen zu groß waren'
        . ' (Serverlimit post_max_size = ' . (string) ini_get('post_max_size') . ').'
        . ' Bitte ein kleineres Bild wählen. Die zuletzt eingegebenen Texte mussten leider verworfen werden.';
} elseif (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    panel_csrf_verify();

    $project['title']            = trim((string) ($_POST['title'] ?? ''));
    $project['category']         = trim((string) ($_POST['category'] ?? ''));
    $project['description']      = trim((string) ($_POST['description'] ?? ''));
    $project['home_description'] = trim((string) ($_POST['home_description'] ?? ''));
    $project['image_alt']        = trim((string) ($_POST['image_alt'] ?? ''));
    $project['icon']             = (string) ($_POST['icon'] ?? 'sprout');
    $project['featured']         = isset($_POST['featured']);
    $project['published']        = isset($_POST['published']);

    if ($project['title'] === '') {
        $errors[] = 'Bitte einen Titel angeben.';
    }
    if (mb_strlen($project['title']) > 120) {
        $errors[] = 'Der Titel darf höchstens 120 Zeichen lang sein.';
    }
    if (mb_strlen($project['category']) > 60) {
        $errors[] = 'Die Kategorie darf höchstens 60 Zeichen lang sein.';
    }
    if ($project['description'] === '') {
        $errors[] = 'Bitte eine Beschreibung für die Projektseite angeben.';
    }
    if (mb_strlen($project['description']) > 600) {
        $errors[] = 'Die Beschreibung darf höchstens 600 Zeichen lang sein.';
    }
    if (mb_strlen($project['home_description']) > 400) {
        $errors[] = 'Der Startseiten-Text darf höchstens 400 Zeichen lang sein.';
    }
    if (mb_strlen($project['image_alt']) > 200) {
        $errors[] = 'Der Bild-Alternativtext darf höchstens 200 Zeichen lang sein.';
    }
    if (!isset(project_icons()[$project['icon']])) {
        $errors[] = 'Unbekanntes Icon ausgewählt.';
        $project['icon'] = 'sprout';
    }

    // Bild: entweder Upload, oder ausgewähltes/eingetragenes vorhandenes Bild.
    $previousImage = $isNew ? '' : ($existing['image'] ?? '');
    $newImage      = $previousImage;
    $uploadedNow   = false;

    $hasUpload = isset($_FILES['image_file']) && ($_FILES['image_file']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    if ($hasUpload) {
        $result = panel_handle_upload($_FILES['image_file']);
        if ($result['ok']) {
            $newImage    = (string) $result['path'];
            $uploadedNow = true;
        } else {
            $errors[] = (string) $result['error'];
        }
    } else {
        $picked = (string) ($_POST['image'] ?? '');
        $check  = panel_validate_image_path($picked);
        if ($check['ok']) {
            $newImage = (string) $check['path'];
        } else {
            $errors[] = (string) $check['error'];
        }
    }
    $project['image'] = $newImage;

    if ($project['image'] !== '' && $project['image_alt'] === '') {
        $errors[] = 'Bitte einen Alternativtext für das Bild angeben (wichtig für Barrierefreiheit und Suchmaschinen).';
    }

    if (!$errors) {
        if ($isNew) {
            $project['id'] = projects_make_id($project['title'], $projects);
            $projects[]    = $project;
            $message       = 'Projekt „' . $project['title'] . '“ wurde angelegt.';
        } else {
            foreach ($projects as $i => $candidate) {
                if ($candidate['id'] === $id) {
                    $projects[$i] = $project;
                    break;
                }
            }
            $message = 'Änderungen an „' . $project['title'] . '“ gespeichert.';
        }

        if (projects_save($projects)) {
            // Ein ersetztes eigenes Upload-Bild aufräumen.
            if ($uploadedNow && $previousImage !== '' && $previousImage !== $project['image']) {
                panel_delete_upload($previousImage);
            }
            panel_flash('ok', $message);
            panel_redirect('index.php');
            exit;
        }
        $errors[] = 'Speichern fehlgeschlagen. Bitte die Schreibrechte für data/projects.json prüfen.';
    }
}

$images      = panel_available_images();
$uploadLimit = panel_upload_limit_bytes();
$limitLabel  = panel_format_bytes($uploadLimit);

panel_header($isNew ? 'Neues Projekt' : 'Projekt bearbeiten');
?>
<main class="panel-main">
  <div class="page-title">
    <div>
      <h1><?= $isNew ? 'Neues Projekt' : 'Projekt bearbeiten' ?></h1>
      <p><?= $isNew
            ? 'Erscheint nach dem Speichern unten in der Projektliste.'
            : 'Änderungen sind sofort auf der Website sichtbar.' ?></p>
    </div>
    <a class="btn btn-ghost" href="index.php">Zurück zur Übersicht</a>
  </div>

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

  <form method="post" enctype="multipart/form-data">
    <?= panel_csrf_field() ?>
    <?php /* Muss vor dem Datei-Feld stehen – PHP bricht damit zu große Uploads sauber ab. */ ?>
    <input type="hidden" name="MAX_FILE_SIZE" value="<?= (int) $uploadLimit ?>">

    <div class="card">
      <div class="form-grid two">
        <div class="field">
          <label for="title">Titel *</label>
          <input type="text" id="title" name="title" required maxlength="120"
                 value="<?= e($project['title']) ?>">
        </div>

        <div class="field">
          <label for="category">Kategorie</label>
          <input type="text" id="category" name="category" maxlength="60"
                 value="<?= e($project['category']) ?>"
                 list="category-suggestions">
          <datalist id="category-suggestions">
            <?php foreach (array_unique(array_column($projects, 'category')) as $suggestion): ?>
              <?php if ($suggestion !== ''): ?>
                <option value="<?= e($suggestion) ?>"></option>
              <?php endif; ?>
            <?php endforeach; ?>
          </datalist>
          <p class="hint">Steht als Label über dem Bild, z. B. „Privatgarten“.</p>
        </div>

        <div class="field full">
          <label for="description">Beschreibung (Projektseite) *</label>
          <textarea id="description" name="description" required maxlength="600"><?= e($project['description']) ?></textarea>
          <p class="hint">Erscheint auf projekte.php in der Projektkarte.</p>
        </div>

        <div class="field full">
          <label for="home_description">Kurztext für die Startseite</label>
          <textarea id="home_description" name="home_description" maxlength="400"><?= e($project['home_description']) ?></textarea>
          <p class="hint">Optional. Bleibt das Feld leer, wird die Beschreibung von oben verwendet.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <h2 class="card-title">Bild</h2>
      <div class="form-grid two">
        <div class="field">
          <label for="image_file">Neues Bild hochladen</label>
          <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp"
                 data-max-bytes="<?= (int) $uploadLimit ?>" data-max-label="<?= e($limitLabel) ?>">
          <p class="hint field-error" id="image_file_error" role="alert" hidden></p>
          <p class="hint">JPG, PNG oder WebP, maximal <?= e($limitLabel) ?>. Empfohlen: 1200 × 900 Pixel (Verhältnis 4:3).</p>
          <?php if (panel_upload_limit_is_capped()): ?>
            <p class="hint field-error">
              Hinweis: Der Server erlaubt derzeit nur <?= e($limitLabel) ?> statt der vorgesehenen
              <?= e(panel_format_bytes(PANEL_UPLOAD_MAX_BYTES)) ?>
              (upload_max_filesize = <?= e((string) ini_get('upload_max_filesize')) ?>,
              post_max_size = <?= e((string) ini_get('post_max_size')) ?>).
              Die Werte stehen in <code>panel/.user.ini</code> bzw. <code>panel/.htaccess</code> –
              greifen sie nicht, sperrt der Hoster das Überschreiben und muss die Limits selbst anheben.
            </p>
          <?php endif; ?>
        </div>

        <div class="field">
          <label for="image">…oder vorhandenes Bild wählen</label>
          <select id="image" name="image">
            <option value="">– kein Bild –</option>
            <?php foreach ($images as $path): ?>
              <option value="<?= e($path) ?>" <?= $path === $project['image'] ? 'selected' : '' ?>>
                <?= e($path) ?>
              </option>
            <?php endforeach; ?>
            <?php if ($project['image'] !== '' && !in_array($project['image'], $images, true)): ?>
              <option value="<?= e($project['image']) ?>" selected><?= e($project['image']) ?> (fehlt)</option>
            <?php endif; ?>
          </select>
          <p class="hint">Ein Upload hat immer Vorrang vor dieser Auswahl.</p>
        </div>

        <div class="field full">
          <label for="image_alt">Bildbeschreibung (Alt-Text)</label>
          <input type="text" id="image_alt" name="image_alt" maxlength="200"
                 value="<?= e($project['image_alt']) ?>">
          <p class="hint">Kurz beschreiben, was zu sehen ist – für Screenreader und Google.</p>
        </div>

        <div class="field full">
          <div class="image-preview" id="image-preview">
            <?php if ($project['image'] !== '' && is_file(PROJECTS_ROOT . '/' . $project['image'])): ?>
              <img src="../<?= e($project['image']) ?>" alt="">
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <h2 class="card-title">Anzeige</h2>
      <div class="form-grid two">
        <div class="field">
          <label for="icon">Icon für die Startseite</label>
          <select id="icon" name="icon">
            <?php foreach (project_icons() as $key => $icon): ?>
              <option value="<?= e($key) ?>" <?= $key === $project['icon'] ? 'selected' : '' ?>>
                <?= e($icon['label']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="hint">Kleines Symbol neben der Überschrift in der Startseiten-Reihe.</p>
        </div>

        <div class="field">
          <div class="check">
            <input type="checkbox" id="published" name="published" value="1" <?= $project['published'] ? 'checked' : '' ?>>
            <div>
              <label for="published">Veröffentlicht</label>
              <p class="hint">Nur veröffentlichte Projekte sind auf der Website sichtbar.</p>
            </div>
          </div>
          <div class="check check-stacked">
            <input type="checkbox" id="featured" name="featured" value="1" <?= $project['featured'] ? 'checked' : '' ?>>
            <div>
              <label for="featured">Auf der Startseite zeigen</label>
              <p class="hint">Die Startseite zeigt die obersten 4 hervorgehobenen Projekte.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-dark">
          <?= $isNew ? 'Projekt anlegen' : 'Änderungen speichern' ?>
        </button>
        <a class="btn btn-ghost" href="index.php">Abbrechen</a>
      </div>
    </div>
  </form>
</main>
<script src="assets/panel.js"></script>
<?php panel_footer(); ?>
