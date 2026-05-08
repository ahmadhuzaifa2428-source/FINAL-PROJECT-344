<?php

/* Start session if not already started */
if (session_status() === PHP_SESSION_NONE) {

    session_start();
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Real Estate Agency Portal</title>

    <!-- Main stylesheet -->
    <link
        rel="stylesheet"
        href="assets/style.css"
    >

</head>

<body>

<!-- Website header -->
<header>

    <!-- Website title -->
    <h1>Real Estate Agency Portal</h1>

    <!-- Navigation bar -->
    <nav>

        <!-- Homepage link -->
        <a href="index.php">
            Home
        </a>

        <!-- Properties link -->
        <a href="properties.php">
            Properties
        </a>

        <!-- Favorites link -->
        <a href="favorites.php">
            Favorites
        </a>

        <?php if (isset($_SESSION['user'])): ?>

            <!-- Dashboard link -->
            <a href="dashboard.php">
                Dashboard
            </a>

            <!-- Logout link -->
            <a href="logout.php">
                Logout
            </a>

        <?php else: ?>

            <!-- Login link -->
            <a href="login.php">
                Login
            </a>

            <!-- Register link -->
            <a href="register.php">
                Register
            </a>

        <?php endif; ?>

    </nav>

</header>

<!-- Main page content -->
<main>