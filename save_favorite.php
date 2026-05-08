<?php

/* Start session */
session_start();

/* Load database */
require_once 'classes/RealEstateDatabase.php';

/* Require login */
if (!isset($_SESSION['user'])) {

    header('Location: login.php');
    exit();
}

/* Get current user */
$user = $_SESSION['user'];

/* Only buyers and renters allowed */
if (
    !in_array(
        $user['userType'],
        ['buyer', 'renter'],
        true
    )
) {

    die('Only buyers and renters can save favorites.');
}

/* Get property ID */
$propertyId = isset($_GET['propertyId'])
    ? (int)$_GET['propertyId']
    : 0;

/* Validate property */
if ($propertyId <= 0) {

    die('Invalid property.');
}

/* Create database object */
$db = new RealEstateDatabase();

/* Get connection */
$conn = $db->getConnection();

/* Check if already favorited */
$checkStmt = $conn->prepare(

    "SELECT *
    FROM Favorites

    WHERE userId = ?
    AND propertyId = ?"

);

$checkStmt->execute([
    $user['userId'],
    $propertyId
]);

$existingFavorite = $checkStmt->fetch();

/* If favorite already exists */
if ($existingFavorite) {

    header('Location: favorites.php');
    exit();
}

/* Insert favorite */
$stmt = $conn->prepare(

    "INSERT INTO Favorites
    (
        userId,
        propertyId,
        savedDate
    )

    VALUES (?, ?, NOW())"

);

$stmt->execute([
    $user['userId'],
    $propertyId
]);

/* Redirect */
header('Location: favorites.php');
exit();