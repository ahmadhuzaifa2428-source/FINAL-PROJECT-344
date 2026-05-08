<?php
// Require logged in user
function requireLogin(): void {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}

// Require correct user role
function requireRole(array $roles): void {
    requireLogin();

    if (!in_array($_SESSION['user']['userType'], $roles, true)) {
        die('Access denied. You do not have permission to view this page.');
    }
}
?>
