<?php
/**
 * Gemeinsame Projekt-Datenschicht.
 *
 * Wird sowohl von den öffentlichen Seiten (index.php, projekte.php) als auch
 * vom Admin-Panel benutzt. Speicherort der Daten ist data/projects.json.
 */

declare(strict_types=1);

require_once __DIR__ . '/compat.php';

const PROJECTS_ROOT      = __DIR__ . '/..';
const PROJECTS_FILE      = PROJECTS_ROOT . '/data/projects.json';
const PROJECTS_UPLOADDIR = PROJECTS_ROOT . '/images/projekte';
const PROJECTS_UPLOADURL = 'images/projekte';

/** Dekorative Icons für die Projekt-Reihen auf der Startseite. */
function project_icons(): array
{
    return [
        'sprout'   => ['label' => 'Setzling', 'path' => '<circle cx="12" cy="8" r="2"/><path d="M12 10v12"/><path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z"/><path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z"/><path d="M12 5a3 3 0 1 1 3 3"/><path d="M12 5a3 3 0 1 0-3 3"/>'],
        'building' => ['label' => 'Gebäude', 'path' => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>'],
        'tree'     => ['label' => 'Baum', 'path' => '<path d="m17 14 3 3.3a1 1 0 0 1-.7 1.7H4.7a1 1 0 0 1-.7-1.7L7 14h-.3a1 1 0 0 1-.7-1.7L9 9h-.2A1 1 0 0 1 8 7.3L12 3l4 4.3a1 1 0 0 1-.8 1.7H15l3 3.3a1 1 0 0 1-.7 1.7H17Z"/><path d="M12 22v-3"/>'],
        'plant'    => ['label' => 'Pflanze', 'path' => '<path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 0-1.1 4c1.9-.1 3.3-.6 4.3-1.4 1-1 1.6-2.3 1.7-4.6-2.7.1-4 1-4.9 2z"/>'],
        'shovel'   => ['label' => 'Schaufel', 'path' => '<path d="M2 22v-5l5-5 5 5-5 5z"/><path d="M9.5 14.5 16 8"/><path d="m17 2 5 5-2.5 2.5-5-5z"/>'],
        'water'    => ['label' => 'Wasser', 'path' => '<path d="M12 2.7 6.3 8.4a8 8 0 1 0 11.4 0z"/>'],
    ];
}

/** Gibt das SVG-Innere für einen Icon-Key zurück (mit Fallback). */
function project_icon_svg(string $key): string
{
    $icons = project_icons();
    return $icons[$key]['path'] ?? $icons['sprout']['path'];
}

/** Standardwerte eines leeren Projekts. */
function project_defaults(): array
{
    return [
        'id'               => '',
        'title'            => '',
        'category'         => '',
        'description'      => '',
        'home_description' => '',
        'image'            => '',
        'image_alt'        => '',
        'icon'             => 'sprout',
        'featured'         => false,
        'published'        => true,
    ];
}

/** Sorgt dafür, dass ein Datensatz alle erwarteten Felder mit sauberen Typen hat. */
function project_normalize(array $project): array
{
    $clean = project_defaults();
    foreach ($clean as $key => $default) {
        if (!array_key_exists($key, $project)) {
            continue;
        }
        $clean[$key] = is_bool($default) ? (bool) $project[$key] : (string) $project[$key];
    }
    if (!isset(project_icons()[$clean['icon']])) {
        $clean['icon'] = 'sprout';
    }
    return $clean;
}

/**
 * Lädt alle Projekte in gespeicherter Reihenfolge.
 *
 * @param bool $onlyPublished Nur veröffentlichte Projekte zurückgeben.
 * @return array<int, array<string, mixed>>
 */
function projects_load(bool $onlyPublished = false): array
{
    if (!is_readable(PROJECTS_FILE)) {
        return [];
    }
    $raw  = file_get_contents(PROJECTS_FILE);
    $data = json_decode((string) $raw, true);
    if (!is_array($data) || !isset($data['projects']) || !is_array($data['projects'])) {
        return [];
    }

    $projects = array_map('project_normalize', $data['projects']);
    if ($onlyPublished) {
        $projects = array_values(array_filter($projects, static fn(array $p): bool => $p['published']));
    }
    return $projects;
}

/** Nur die auf der Startseite hervorgehobenen Projekte. */
function projects_featured(int $limit = 4): array
{
    $featured = array_values(array_filter(
        projects_load(true),
        static fn(array $p): bool => $p['featured']
    ));
    return array_slice($featured, 0, $limit);
}

/** Ein einzelnes Projekt anhand seiner ID. */
function projects_find(string $id): ?array
{
    foreach (projects_load() as $project) {
        if ($project['id'] === $id) {
            return $project;
        }
    }
    return null;
}

/**
 * Schreibt die Projektliste atomar zurück (temporäre Datei + rename),
 * damit ein Abbruch mitten im Schreiben die Daten nicht zerstört.
 */
function projects_save(array $projects): bool
{
    $payload = [
        'updated'  => date('c'),
        'projects' => array_map('project_normalize', array_values($projects)),
    ];
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    $dir = dirname(PROJECTS_FILE);
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        return false;
    }

    $tmp = tempnam($dir, 'proj');
    if ($tmp === false) {
        return false;
    }
    if (file_put_contents($tmp, $json . "\n", LOCK_EX) === false) {
        @unlink($tmp);
        return false;
    }
    @chmod($tmp, 0640);
    if (!rename($tmp, PROJECTS_FILE)) {
        @unlink($tmp);
        return false;
    }
    return true;
}

/**
 * Erzeugt aus einem Titel eine eindeutige, sprechende ID (Slug).
 *
 * @param array<int, array<string, mixed>> $existing Bereits vergebene Projekte
 */
function projects_make_id(string $title, array $existing): string
{
    $map  = ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'Ä' => 'ae', 'Ö' => 'oe', 'Ü' => 'ue', 'ß' => 'ss'];
    $slug = strtr(mb_strtolower($title), $map);
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? '';
    $slug = trim($slug, '-');
    if ($slug === '') {
        $slug = 'projekt';
    }
    $slug = 'p-' . mb_substr($slug, 0, 48);

    $taken = array_column($existing, 'id');
    $final = $slug;
    $n     = 2;
    while (in_array($final, $taken, true)) {
        $final = $slug . '-' . $n++;
    }
    return $final;
}

/** Kurzschreibweise für htmlspecialchars mit sicheren Defaults. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
