<?php
/**
 * Abmelden. Nur per POST mit gültigem CSRF-Token, damit niemand
 * per Link-Klick fremde Sitzungen beenden kann.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

panel_session_start();

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    panel_csrf_verify();
    panel_logout();
}

panel_redirect('login.php');
