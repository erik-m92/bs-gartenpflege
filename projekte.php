<?php
/**
 * Projektübersicht.
 *
 * Die Projekte kommen aus data/projects.json und werden im Admin-Panel
 * unter panel/ gepflegt. Änderungen dort sind hier sofort sichtbar.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/projects.php';

$projects = projects_load(true);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projekte &amp; Referenzen – BS-Gartenpflege Reutlingen</title>
  <meta name="description" content="Ausgewählte Projekte von BS-Gartenpflege: Gartenneugestaltungen, Außenanlagenpflege und Objektbetreuung in Reutlingen und Umgebung.">
  <meta property="og:title" content="Projekte &amp; Referenzen – BS-Gartenpflege Reutlingen">
  <meta property="og:description" content="Ausgewählte Projekte von BS-Gartenpflege: Gartenneugestaltungen, Außenanlagenpflege und Objektbetreuung in Reutlingen und Umgebung.">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="de_DE">
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%231e4f2b'/%3E%3Cpath d='M32 50c-10-8-14-18-8-28 12 2 20 12 18 26-3 2-7 3-10 2z' fill='%23b9e353'/%3E%3C/svg%3E">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <a class="skip-link" href="#main">Zum Inhalt springen</a>

  <!-- ================= Header ================= -->
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" class="logo" aria-label="BS-Gartenpflege – zur Startseite">
        <span class="logo-mark" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
        </span>
        <span>BS-<em>Gartenpflege</em></span>
      </a>

      <nav class="main-nav" aria-label="Hauptnavigation">
        <ul>
          <li><a href="index.php">Start</a></li>
          <li class="has-sub">
            <a href="leistungen.html" class="nav-toggle-sub">Leistungen
              <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
            </a>
            <div class="sub-menu">
              <a href="leistungen.html">Alle Leistungen</a>
              <a href="leistungen.html#privat">Privatgärten</a>
              <a href="leistungen.html#gewerbe">Gewerbe &amp; Objekte</a>
            </div>
          </li>
          <li><a href="projekte.php">Projekte</a></li>
          <li><a href="preise.html">Preise</a></li>
          <li class="has-sub">
            <a href="ueber-uns.html" class="nav-toggle-sub">Unternehmen
              <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
            </a>
            <div class="sub-menu">
              <a href="ueber-uns.html">Über uns</a>
              <a href="faq.html">Häufige Fragen</a>
            </div>
          </li>
          <li><a href="kontakt.html">Kontakt</a></li>
        </ul>
      </nav>

      <div class="header-cta">
        <a href="kontakt.html" class="btn btn-lime">Angebot anfordern
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
        <button class="burger" aria-label="Menü öffnen" aria-expanded="false" aria-controls="mobile-menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile-Menü -->
  <div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-label="Navigationsmenü">
    <div class="mobile-menu-head">
      <a href="index.php" class="logo">
        <span class="logo-mark" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
        </span>
        <span>BS-<em>Gartenpflege</em></span>
      </a>
      <button class="mobile-close" aria-label="Menü schließen">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </div>
    <nav class="mobile-nav" aria-label="Mobile Navigation">
      <a href="index.php">Start</a>
      <a href="leistungen.html">Leistungen</a>
      <a href="leistungen.html#privat" class="sub-link">→ Privatgärten</a>
      <a href="leistungen.html#gewerbe" class="sub-link">→ Gewerbe &amp; Objekte</a>
      <a href="projekte.php">Projekte</a>
      <a href="preise.html">Preise</a>
      <a href="ueber-uns.html">Über uns</a>
      <a href="faq.html">Häufige Fragen</a>
      <a href="kontakt.html">Kontakt</a>
    </nav>
    <a href="kontakt.html" class="btn btn-lime">Kostenloses Angebot anfordern</a>
  </div>

  <main id="main">

    <!-- Page-Hero -->
    <div class="page-hero">
      <div class="container">
        <nav class="breadcrumb" aria-label="Brotkrumen-Navigation">
          <a href="index.php">Start</a>
          <span aria-hidden="true">/</span>
          <span class="current">Projekte</span>
        </nav>
        <h1>Projekte &amp; Referenzen</h1>
        <p class="lead">Eine Auswahl unserer Arbeiten aus Reutlingen und Umgebung – vom privaten Hausgarten bis zur ganzjährig betreuten Außenanlage. (Beispielprojekte – echte Referenzen &amp; Fotos folgen.)</p>
      </div>
    </div>

    <!-- Projektliste -->
    <section aria-label="Projektübersicht">
      <div class="container">
        <?php if ($projects === []): ?>
          <p class="lead">Zurzeit sind keine Projekte veröffentlicht. Schauen Sie bald wieder vorbei.</p>
        <?php else: ?>
        <div class="projects-grid">
          <?php foreach ($projects as $index => $project): ?>
          <article class="project-card reveal">
            <div class="project-media">
              <?php if ($project['category'] !== ''): ?>
              <span class="project-tag"><?= e($project['category']) ?></span>
              <?php endif; ?>
              <?php if ($project['image'] !== ''): ?>
              <img src="<?= e($project['image']) ?>" alt="<?= e($project['image_alt']) ?>" width="800" height="600">
              <?php endif; ?>
            </div>
            <div class="project-body">
              <div class="project-num"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></div>
              <h3><?= e($project['title']) ?></h3>
              <p><?= e($project['description']) ?></p>
              <a href="kontakt.html" class="arrow-link">Ähnliches Projekt anfragen
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </a>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta-banner" aria-label="Projekt anfragen">
      <div class="container">
        <div class="cta-card reveal">
          <div>
            <h2>Ihr Projekt könnte das nächste sein.</h2>
            <p>Erzählen Sie uns von Ihrem Garten oder Ihrer Außenanlage – wir melden uns innerhalb von 24 Stunden.</p>
          </div>
          <div class="cta-right">
            <a href="kontakt.html" class="btn btn-lime">
              Projekt anfragen
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- ================= Footer ================= -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="index.php" class="logo">
            <span class="logo-mark" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
            </span>
            <span>BS-<em>Gartenpflege</em></span>
          </a>
          <p>Ihr zuverlässiger Partner für Gartenpflege und Grünanlagenbetreuung in Reutlingen und Umgebung.</p>
          <div class="socials">
            <a href="#" aria-label="Instagram (Link folgt)">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
            </a>
            <a href="#" aria-label="Facebook (Link folgt)">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            </a>
          </div>
        </div>
        <div>
          <h4>Leistungen</h4>
          <ul class="footer-links">
            <li><a href="leistungen.html#privat">Rasenpflege</a></li>
            <li><a href="leistungen.html#privat">Hecken- &amp; Formschnitt</a></li>
            <li><a href="leistungen.html#privat">Baum- &amp; Gehölzpflege</a></li>
            <li><a href="leistungen.html#gewerbe">Grünanlagenpflege</a></li>
            <li><a href="leistungen.html#gewerbe">Winterdienst</a></li>
          </ul>
        </div>
        <div>
          <h4>Unternehmen</h4>
          <ul class="footer-links">
            <li><a href="ueber-uns.html">Über uns</a></li>
            <li><a href="projekte.php">Projekte</a></li>
            <li><a href="preise.html">Preise</a></li>
            <li><a href="faq.html">Häufige Fragen</a></li>
          </ul>
        </div>
        <div>
          <h4>Kontakt</h4>
          <ul class="footer-contact">
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <a href="tel:+4971210000000">07121 / 00 00 00</a>
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
              <a href="mailto:info@bs-gartenpflege.de">info@bs-gartenpflege.de</a>
            </li>
            <li>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Musterstraße 12<br>72764 Reutlingen</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© <span data-year>2026</span> BS-Gartenpflege, Reutlingen. Alle Rechte vorbehalten.</p>
        <div class="footer-legal">
          <a href="impressum.html">Impressum</a>
          <a href="datenschutz.html">Datenschutz</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="js/main.js"></script>
</body>
</html>
