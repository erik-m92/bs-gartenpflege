<?php
/**
 * Startseite.
 *
 * Die hervorgehobenen Projekte kommen aus data/projects.json und werden im
 * Admin-Panel unter panel/ gepflegt (Häkchen „Auf der Startseite zeigen“).
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/projects.php';

$featured = projects_featured(4);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BS-Gartenpflege Reutlingen – Professionelle Gartenpflege &amp; Grünanlagenpflege</title>
  <meta name="description" content="BS-Gartenpflege aus Reutlingen: zuverlässige Gartenpflege, Heckenschnitt, Rasenpflege und Grünanlagenbetreuung für Privatgärten, Wohnanlagen und Gewerbeobjekte.">
  <meta property="og:title" content="BS-Gartenpflege Reutlingen – Ihr Garten in den besten Händen">
  <meta property="og:description" content="Zuverlässige Gartenpflege für Privat und Gewerbe in Reutlingen und Umgebung. Jetzt kostenlose Beratung anfragen.">
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
          <li><a href="index.php" aria-current="page">Start</a></li>
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

    <!-- ================= Hero ================= -->
    <section class="hero" aria-label="Intro">
      <div class="container">
        <div class="hero-shell">
          <img class="hero-bg" src="images/hero-aerial.svg" alt="Luftaufnahme eines professionell gepflegten Gartens" width="1600" height="900">
          <div class="hero-content reveal">
            <h1>Professionelle Gartenpflege in Reutlingen</h1>
            <p class="lead">Wir betreuen Privatgärten, Wohnanlagen und Gewerbeobjekte – mit durchdachter Planung, sauberer Ausführung und langfristiger Pflege.</p>
            <a href="projekte.php" class="btn btn-lime">
              Unsere Projekte ansehen
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </div>

          <aside class="hero-review" aria-label="Kundenbewertung">
            <div class="hr-top">
              <div class="hr-avatars" aria-hidden="true">
                <span>SM</span><span>TB</span><span>ML</span>
              </div>
              <small>Basierend auf verifizierten Kundenbewertungen</small>
            </div>
            <p class="hr-quote">„Unser Garten sah nie besser aus – professionell, gründlich und immer pünktlich."</p>
            <div class="hr-score">
              <span class="num" data-count="4.9" data-decimals="1">0</span>
              <span class="hr-star" aria-hidden="true">★</span>
              <span class="hr-label">Durchschnittliche Kundenbewertung</span>
            </div>
          </aside>

          <div class="hero-tags">
            <span class="ht-label">Beliebte Themen</span>
            <span class="pill">Gartenplanung</span>
            <span class="pill">Grundstückspflege</span>
            <span class="pill">Außenanlagen</span>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= Stats ================= -->
    <section aria-label="Zahlen und Fakten">
      <div class="container">
        <div class="stats-head">
          <div class="reveal">
            <span class="eyebrow">Zahlen &amp; Fakten</span>
            <h2>Leistung, auf die Sie sich verlassen können.</h2>
          </div>
          <p class="stats-quote reveal">„Wir pflegen nicht nur Gärten – wir schaffen Außenanlagen, die mit jeder Saison schöner werden. Vom Privatgarten bis zum großen Gewerbeobjekt sprechen unsere Ergebnisse und langjährigen Kundenbeziehungen für sich."</p>
        </div>
        <div class="stats-grid">
          <div class="stat-card reveal">
            <div class="stat-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
            </div>
            <div class="stat-value" data-count="15" data-suffix="+">0</div>
            <div class="stat-label">Jahre Erfahrung</div>
            <p>Professionelle Gartenpflege mit gleichbleibender Qualität und einem geschulten Blick fürs Detail.</p>
          </div>
          <div class="stat-card reveal">
            <div class="stat-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
            </div>
            <div class="stat-value" data-count="350" data-suffix="+">0</div>
            <div class="stat-label">Abgeschlossene Projekte</div>
            <p>Privatgärten, Gewerbeflächen und öffentliche Anlagen – geplant, gepflegt und präzise umgesetzt.</p>
          </div>
          <div class="stat-card reveal">
            <div class="stat-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2a3.13 3.13 0 0 1 3 3.88Z"/></svg>
            </div>
            <div class="stat-value" data-count="98" data-suffix="%">0</div>
            <div class="stat-label">Kundenzufriedenheit</div>
            <p>Unsere Kundinnen und Kunden bleiben, weil wir pünktlich sind, klar kommunizieren und halten, was wir versprechen.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= Services (Slider) ================= -->
    <section aria-label="Unsere Leistungen">
      <div class="container">
        <div class="svc-shell">
          <div class="section-head center reveal">
            <span class="eyebrow">Komplette Gartenpflege für jedes Grundstück</span>
            <h2>Professionelle Leistungen für Privat &amp; Gewerbe.</h2>
          </div>

          <div class="tabs" role="tablist" aria-label="Leistungsbereiche">
            <button class="tab-btn" role="tab" id="tab-privat" aria-controls="panel-privat" aria-selected="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
              Privatgärten
            </button>
            <button class="tab-btn" role="tab" id="tab-gewerbe" aria-controls="panel-gewerbe" aria-selected="false" tabindex="-1">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
              Gewerbe &amp; Objekte
            </button>
          </div>

          <!-- Panel: Privat -->
          <div class="tab-panel" id="panel-privat" role="tabpanel" aria-labelledby="tab-privat">
            <div class="svc-carousel" data-carousel>
              <button class="svc-nav prev" data-car-prev aria-label="Vorherige Leistungen">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
              </button>
              <div class="svc-track">
                <article class="svc-card">
                  <img src="images/project-1.svg" alt="Sattgrüner, frisch gemähter Rasen" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zur Rasenpflege">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/></svg></span>
                      <h3>Rasenpflege</h3>
                    </div>
                    <p>Mähen, Vertikutieren, Düngen und Nachsäen – für einen dichten, gesunden Rasen das ganze Jahr.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/blog-2.svg" alt="Präzise geschnittene Hecke" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zum Heckenschnitt">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><path d="M8.12 8.12 12 12"/><path d="M20 4 8.12 15.88"/><circle cx="6" cy="18" r="3"/><path d="M14.8 14.8 20 20"/></svg></span>
                      <h3>Hecken- &amp; Formschnitt</h3>
                    </div>
                    <p>Fachgerechter Schnitt zum richtigen Zeitpunkt – inklusive Abtransport des Schnittguts.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/project-3.svg" alt="Gepflegte Bäume und Sträucher" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zur Baumpflege">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m17 14 3 3.3a1 1 0 0 1-.7 1.7H4.7a1 1 0 0 1-.7-1.7L7 14h-.3a1 1 0 0 1-.7-1.7L9 9h-.2A1 1 0 0 1 8 7.3L12 3l4 4.3a1 1 0 0 1-.8 1.7H15l3 3.3a1 1 0 0 1-.7 1.7H17Z"/><path d="M12 22v-3"/></svg></span>
                      <h3>Baum- &amp; Gehölzpflege</h3>
                    </div>
                    <p>Schonender Rückschnitt für gesundes Wachstum, Sicherheit und eine gepflegte Optik.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/blog-1.svg" alt="Frisch bepflanztes Staudenbeet" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zur Beetpflege">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="2"/><path d="M12 10v12"/><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"/><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"/><path d="M12 5a3 3 0 1 1 3 3"/><path d="M12 5a3 3 0 1 0-3 3"/></svg></span>
                      <h3>Beetpflege &amp; Bepflanzung</h3>
                    </div>
                    <p>Standortgerechte, pflegeleichte Bepflanzung – passend zu jeder Jahreszeit.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/project-4.svg" alt="Gereinigte Terrasse mit Pflasterfläche" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zur Terrassenpflege">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg></span>
                      <h3>Terrassen- &amp; Wegepflege</h3>
                    </div>
                    <p>Reinigung von Pflasterflächen, Entfernen von Wildwuchs und kleine Ausbesserungen.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/blog-3.svg" alt="Herbstlicher Garten bei der Laubaktion" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#privat" aria-label="Mehr zur saisonalen Gartenreinigung">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg></span>
                      <h3>Saisonale Gartenreinigung</h3>
                    </div>
                    <p>Frühjahrsputz und Herbst-Laubaktion – inklusive Grünschnitt-Entsorgung.</p>
                  </div>
                </article>
              </div>
              <button class="svc-nav next" data-car-next aria-label="Weitere Leistungen">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
              </button>
              <div class="svc-dots" role="group" aria-label="Leistung auswählen"></div>
            </div>
          </div>

          <!-- Panel: Gewerbe -->
          <div class="tab-panel" id="panel-gewerbe" role="tabpanel" aria-labelledby="tab-gewerbe" hidden>
            <div class="svc-carousel" data-carousel>
              <button class="svc-nav prev" data-car-prev aria-label="Vorherige Leistungen">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
              </button>
              <div class="svc-track">
                <article class="svc-card">
                  <img src="images/project-2.svg" alt="Außenanlage eines Bürogebäudes" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zur Grünanlagenpflege">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg></span>
                      <h3>Grünanlagenpflege</h3>
                    </div>
                    <p>Ganzjährige Pflege von Firmengeländen, Wohnanlagen und öffentlichen Flächen.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/hero-2.svg" alt="Objektbetreuung einer Wohnanlage" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zur Objektbetreuung">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg></span>
                      <h3>Objektbetreuung</h3>
                    </div>
                    <p>Fester Ansprechpartner und dokumentierte Einsätze für Hausverwaltungen.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/blog-2.svg" alt="Strauchschnitt an einer großen Heckenanlage" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zum Gehölzschnitt">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="6" cy="6" r="3"/><path d="M8.12 8.12 12 12"/><path d="M20 4 8.12 15.88"/><circle cx="6" cy="18" r="3"/><path d="M14.8 14.8 20 20"/></svg></span>
                      <h3>Gehölz- &amp; Strauchschnitt</h3>
                    </div>
                    <p>Termingerechter Schnitt großer Bestände inklusive vollständiger Entsorgung.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/hero-3.svg" alt="Geräumtes Grundstück" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zur Grundstücksräumung">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg></span>
                      <h3>Grundstücksräumung</h3>
                    </div>
                    <p>Roden, räumen, entsorgen – wir übergeben eine saubere, nutzbare Fläche.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/hero-1.svg" alt="Automatische Gartenbewässerung" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zu Bewässerungslösungen">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 16.3c2.2 0 4-1.83 4-4.05 0-1.16-.57-2.26-1.71-3.19S7.29 6.75 7 5.3c-.29 1.45-1.14 2.84-2.29 3.76S3 11.1 3 12.25c0 2.22 1.8 4.05 4 4.05z"/><path d="M12.56 6.6A10.97 10.97 0 0 0 14 3.02c.5 2.5 2 4.9 4 6.5s3 3.5 3 5.5a6.98 6.98 0 0 1-11.91 4.97"/></svg></span>
                      <h3>Bewässerungslösungen</h3>
                    </div>
                    <p>Beratung, Installation und Wartung automatischer Bewässerungssysteme.</p>
                  </div>
                </article>
                <article class="svc-card">
                  <img src="images/about-2.svg" alt="Winterdienst auf einem Firmengelände" width="800" height="600">
                  <a class="svc-arrow" href="leistungen.html#gewerbe" aria-label="Mehr zum Winterdienst">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                  </a>
                  <div class="svc-info">
                    <div class="svc-head">
                      <span class="svc-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="2" x2="22" y1="12" y2="12"/><line x1="12" x2="12" y1="2" y2="22"/><path d="m20 16-4-4 4-4"/><path d="m4 8 4 4-4 4"/><path d="m16 4-4 4-4-4"/><path d="m8 20 4-4 4 4"/></svg></span>
                      <h3>Winterdienst</h3>
                    </div>
                    <p>Räumen und Streuen nach Plan – dokumentiert und verkehrssicher.</p>
                  </div>
                </article>
              </div>
              <button class="svc-nav next" data-car-next aria-label="Weitere Leistungen">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
              </button>
              <div class="svc-dots" role="group" aria-label="Leistung auswählen"></div>
            </div>
          </div>

          <div class="services-cta reveal">
            <a href="kontakt.html" class="btn btn-lime">
              Kostenlose Beratung sichern
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= Wer wir sind ================= -->
    <section aria-label="Über uns">
      <div class="container wwa-grid">
        <div class="wwa-imgs reveal reveal-left">
          <div class="wwa-badge" aria-hidden="true">
            <svg class="badge-spin" viewBox="0 0 120 120">
              <defs>
                <path id="badge-circle" d="M60,60 m-46,0 a46,46 0 1,1 92,0 a46,46 0 1,1 -92,0"/>
              </defs>
              <text><textPath href="#badge-circle">Präzision · Erfahrung · Zuverlässigkeit ·</textPath></text>
            </svg>
            <span class="badge-leaf">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
            </span>
          </div>
          <div class="wwa-img w1"><img src="images/about-1.svg" alt="Gärtnerin bei der Pflanzenpflege" width="600" height="800"></div>
          <div class="wwa-img w2"><img src="images/about-2.svg" alt="Team bei der Beetbepflanzung" width="600" height="800"></div>
        </div>
        <div class="reveal">
          <span class="eyebrow">Wer wir sind</span>
          <h2>Gartenpflege mit Erfahrung &amp; Sorgfalt.</h2>
          <p style="margin-top:1rem">Eine gepflegte Außenanlage entsteht nicht zufällig. Sie braucht Planung, Verlässlichkeit und ein Team, das versteht, wie Gärten wachsen und sich im Lauf der Jahreszeiten verändern.</p>
          <div class="wwa-acc">
            <details class="wwa-item" open>
              <summary>
                <span class="wwa-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                Erfahrenes Team
              </summary>
              <div class="wwa-body"><p>Ausgebildete Gärtner, die Pflanzengesundheit, Bodenverhältnisse und langfristige Gartenplanung verstehen – und ihr Handwerk lieben.</p></div>
            </details>
            <details class="wwa-item">
              <summary>
                <span class="wwa-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                Verlässliche Termine
              </summary>
              <div class="wwa-body"><p>Wir kommen, wenn wir es sagen – mit festen Pflegeintervallen oder flexiblen Einsätzen, ganz wie es zu Ihnen passt.</p></div>
            </details>
            <details class="wwa-item">
              <summary>
                <span class="wwa-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                Sorgfalt im Detail
              </summary>
              <div class="wwa-body"><p>Saubere Kanten, aufgeräumte Flächen, ordentlich entsorgtes Schnittgut – wir gehen erst, wenn alles stimmt.</p></div>
            </details>
            <details class="wwa-item">
              <summary>
                <span class="wwa-check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg></span>
                Privat- &amp; Gewerbe-Expertise
              </summary>
              <div class="wwa-body"><p>Vom Reihenhausgarten bis zur großen Außenanlage mit mehreren Gebäuden – wir kennen die Anforderungen beider Welten.</p></div>
            </details>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= Bild-Banner ================= -->
    <section aria-hidden="true">
      <div class="container">
        <div class="video-banner reveal">
          <img src="images/hero-aerial.svg" alt="" width="1600" height="900">
          <span class="vb-btn">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><rect x="7" y="5" width="3.5" height="14" rx="1"/><rect x="13.5" y="5" width="3.5" height="14" rx="1"/></svg>
          </span>
        </div>
      </div>
    </section>

    <!-- ================= Präzision / Prozess ================= -->
    <section aria-label="So arbeiten wir">
      <div class="container">
        <div class="prec-shell">
          <div class="prec-top">
            <div class="reveal">
              <span class="eyebrow">Ein höherer Anspruch an Gartenpflege</span>
              <h2>Wo Präzision auf dauerhafte Qualität trifft.</h2>
            </div>
            <div class="prec-img reveal"><img src="images/team-2.svg" alt="Gärtnerin mit frisch bepflanzter Pflanzkiste" width="600" height="600"></div>
            <div class="prec-txt reveal">
              <p>Wir setzen auf Struktur, Disziplin und saubere Handwerksarbeit – damit Ihre Außenanlage auf jedem Niveau Professionalität ausstrahlt.</p>
              <a href="projekte.php" class="btn btn-lime">
                Unsere Projekte ansehen
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </a>
            </div>
          </div>
          <div class="prec-steps">
            <div class="prec-col">
              <div class="prec-step reveal">
                <span class="prec-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                  <span class="pn">01</span>
                </span>
                <div>
                  <h3>Strategische Planung</h3>
                  <p>Jedes Projekt beginnt mit einem klaren, durchdachten Plan und einer Analyse vor Ort.</p>
                </div>
              </div>
              <div class="prec-step reveal">
                <span class="prec-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                  <span class="pn">02</span>
                </span>
                <div>
                  <h3>Präzise Ausführung</h3>
                  <p>Saubere Kanten, ausgewogene Flächen und sorgfältig gepflegtes Grün prägen unsere Arbeit.</p>
                </div>
              </div>
            </div>
            <div class="prec-center-wrap">
              <div class="prec-center reveal"><img src="images/process.svg" alt="Detailaufnahme gepflegter Pflanzen" width="600" height="800"></div>
            </div>
            <div class="prec-col">
              <div class="prec-step reveal">
                <span class="prec-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                  <span class="pn">03</span>
                </span>
                <div>
                  <h3>Verlässliche Termine</h3>
                  <p>Unsere organisierten Pflegepläne halten Ihr Grundstück dauerhaft in Bestform.</p>
                </div>
              </div>
              <div class="prec-step reveal">
                <span class="prec-check" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                  <span class="pn">04</span>
                </span>
                <div>
                  <h3>Skalierbare Betreuung</h3>
                  <p>Vom Privatgarten bis zum Gewerbeareal – unser Team wächst mit Ihren Anforderungen.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= Projekte ================= -->
    <?php if ($featured !== []): ?>
    <section aria-label="Ausgewählte Projekte">
      <div class="container">
        <div class="section-head center reveal">
          <span class="eyebrow">Ausgewählte Arbeiten</span>
          <h2>Gärten, die überzeugen &amp; Anlagen, die funktionieren.</h2>
        </div>
        <div class="proj-stack">
          <?php foreach ($featured as $index => $project): ?>
          <article class="proj-row">
            <div class="proj-side">
              <span class="proj-num"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <?php if ($project['category'] !== ''): ?>
              <span class="proj-cat"><?= e($project['category']) ?></span>
              <?php endif; ?>
            </div>
            <div class="proj-img">
              <?php if ($project['image'] !== ''): ?>
              <img src="<?= e($project['image']) ?>" alt="<?= e($project['image_alt']) ?>" width="800" height="600">
              <?php endif; ?>
            </div>
            <div class="proj-info">
              <?php /* Feste Icon-Vorlage aus project_icons() – bewusst nicht escaped. */ ?>
              <span class="proj-ic" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><?= project_icon_svg($project['icon']) ?></svg></span>
              <h3><?= e($project['title']) ?></h3>
              <p><?= e($project['home_description'] !== '' ? $project['home_description'] : $project['description']) ?></p>
            </div>
            <a href="projekte.php" class="proj-go" aria-label="Projekt ansehen">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
            </a>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ================= Testimonials ================= -->
    <section aria-label="Kundenstimmen">
      <div class="container testi-grid">
        <div class="testi-left reveal reveal-left">
          <div class="g-badge">
            <span class="g-logo" aria-hidden="true">G</span>
            <div>
              <strong>4,9</strong><span class="stars" aria-hidden="true">★★★★★</span>
              <small>Google-Bewertungen</small>
            </div>
          </div>
          <div class="testi-img"><img src="images/about-1.svg" alt="Gärtner beim Rasenmähen zwischen Sträuchern" width="600" height="800"></div>
        </div>
        <div class="reveal">
          <span class="eyebrow">Kundenstimmen</span>
          <h2>Vertrauen von Eigentümern &amp; Hausverwaltungen.</h2>
          <p style="margin-top:1rem;margin-bottom:1.8rem">Von privaten Gärten bis zu großen Gewerbeflächen: Wir bauen auf langfristige Partnerschaften – mit Verlässlichkeit, klarer Kommunikation und konstanten Ergebnissen.</p>
          <div class="slider" aria-label="Bewertungen unserer Kunden">
            <div class="slide active">
              <div class="slide-top">
                <span class="role"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/></svg>Gartenbesitzerin</span>
                <span class="stars" aria-hidden="true">★★★★★</span>
              </div>
              <blockquote>„Wir wollten einen Garten, der gepflegt aussieht, ohne ständige Arbeit zu machen. Genau das hat das Team geliefert – pünktlich, freundlich und absolut ordentlich."</blockquote>
              <div class="slide-person">
                <div class="avatar" aria-hidden="true">SM</div>
                <div>
                  <strong>Sabine M.</strong>
                  <span>Reutlingen</span>
                </div>
              </div>
              <span class="quote-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 8c-3.3 0-6 2.7-6 6v2h5v-6H6.5C6.8 8.9 8.2 8 10 8Zm10 0c-3.3 0-6 2.7-6 6v2h5v-6h-2.5c.3-1.1 1.7-2 3.5-2Z"/></svg></span>
            </div>
            <div class="slide">
              <div class="slide-top">
                <span class="role"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>Hausverwaltung</span>
                <span class="stars" aria-hidden="true">★★★★★</span>
              </div>
              <blockquote>„Als Hausverwaltung brauchen wir einen Partner, auf den wir uns verlassen können. Die Einsätze werden sauber dokumentiert, Absprachen werden eingehalten. So muss das sein."</blockquote>
              <div class="slide-person">
                <div class="avatar" aria-hidden="true">TB</div>
                <div>
                  <strong>Thomas B.</strong>
                  <span>Tübingen</span>
                </div>
              </div>
              <span class="quote-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 8c-3.3 0-6 2.7-6 6v2h5v-6H6.5C6.8 8.9 8.2 8 10 8Zm10 0c-3.3 0-6 2.7-6 6v2h5v-6h-2.5c.3-1.1 1.7-2 3.5-2Z"/></svg></span>
            </div>
            <div class="slide">
              <div class="slide-top">
                <span class="role"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Eigenheimbesitzer</span>
                <span class="stars" aria-hidden="true">★★★★★</span>
              </div>
              <blockquote>„Unser Außenbereich ist wie verwandelt. Die Struktur stimmt, die Pflanzen sind gesund und alles wirkt durchdacht gestaltet. Genau der professionelle Look, den wir uns gewünscht haben."</blockquote>
              <div class="slide-person">
                <div class="avatar" aria-hidden="true">FK</div>
                <div>
                  <strong>Familie K.</strong>
                  <span>Pfullingen</span>
                </div>
              </div>
              <span class="quote-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 8c-3.3 0-6 2.7-6 6v2h5v-6H6.5C6.8 8.9 8.2 8 10 8Zm10 0c-3.3 0-6 2.7-6 6v2h5v-6h-2.5c.3-1.1 1.7-2 3.5-2Z"/></svg></span>
            </div>
            <div class="slide">
              <div class="slide-top">
                <span class="role"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>Facility Manager</span>
                <span class="stars" aria-hidden="true">★★★★★</span>
              </div>
              <blockquote>„Unser Firmengelände wird ganzjährig gepflegt – inklusive Winterdienst. Ein Ansprechpartner, faire Preise, null Ärger. Genau das haben wir lange gesucht."</blockquote>
              <div class="slide-person">
                <div class="avatar" aria-hidden="true">ML</div>
                <div>
                  <strong>Markus L.</strong>
                  <span>Metzingen</span>
                </div>
              </div>
              <span class="quote-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 8c-3.3 0-6 2.7-6 6v2h5v-6H6.5C6.8 8.9 8.2 8 10 8Zm10 0c-3.3 0-6 2.7-6 6v2h5v-6h-2.5c.3-1.1 1.7-2 3.5-2Z"/></svg></span>
            </div>
          </div>
          <div class="slider-nav">
            <button class="slider-btn" data-slide="prev" aria-label="Vorherige Bewertung">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg>
            </button>
            <div class="slider-dots" role="group" aria-label="Bewertung auswählen"></div>
            <button class="slider-btn" data-slide="next" aria-label="Nächste Bewertung">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ================= CTA-Banner ================= -->
    <section class="cta-banner" aria-label="Kontakt aufnehmen">
      <div class="container">
        <div class="cta-card reveal">
          <div class="cta-left">
            <h2>Bereit für einen rundum gepflegten Garten?</h2>
            <p>Ob Gewerbeobjekt oder privater Garten: Wir gestalten und pflegen Außenanlagen, die professionell aussehen und das ganze Jahr überzeugen.</p>
            <a href="kontakt.html" class="btn btn-lime">
              Kostenlose Beratung anfragen
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
            <div class="cta-follow">
              <span>Folgen Sie uns:</span>
              <div class="socials">
                <a href="#" aria-label="Instagram (Link folgt)">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                </a>
                <a href="#" aria-label="Facebook (Link folgt)">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" aria-label="WhatsApp (Link folgt)">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </a>
              </div>
            </div>
          </div>
          <div class="cta-img"><img src="images/hero-2.svg" alt="Zwei Gärtner mit Pflanzen an einem Verkaufsstand" width="800" height="600"></div>
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
