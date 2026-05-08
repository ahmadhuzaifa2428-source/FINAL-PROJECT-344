<?php
// Load session settings
require_once 'config/config.php';

// Clear current session
session_unset();
session_destroy();

// Return to homepage
header('Location: index.php');
exit;
?>
