<?php

/* Start session */
session_start();

/* Require login */
if (!isset($_SESSION['user'])) {

    header('Location: login.php');
    exit();
}

/* Load database */
require_once 'classes/RealEstateDatabase.php';

/* Get current user */
$user = $_SESSION['user'];

/* Create database object */
$db = new RealEstateDatabase();

/* Get PDO connection */
$conn = $db->getConnection();

/* Get favorite properties */
$stmt = $conn->prepare(

    "SELECT
        p.*
    FROM Favorites f

    JOIN Properties p
    ON f.propertyId = p.propertyId

    WHERE f.userId = ?"

);

$stmt->execute([
    $user['userId']
]);

$favorites = $stmt->fetchAll();

?>

<?php include 'includes/header.php'; ?>

<!-- Page heading -->
<h2>My Favorite Properties</h2>

<?php if (!$favorites): ?>

    <p>No favorite properties yet.</p>

<?php else: ?>

    <div class="property-grid">

    <?php foreach ($favorites as $property): ?>

        <div class="card">

            <!-- Property image -->
            <img
                class="property-img"
                src="<?= htmlspecialchars($property['imagePath']) ?>"
                alt="Property Image"
            >

            <!-- Property title -->
            <h3>
                <?= htmlspecialchars($property['title']) ?>
            </h3>

            <!-- Property information -->
            <p>
                <strong>Type:</strong>
                <?= htmlspecialchars($property['propertyType']) ?>
            </p>

            <p>
                <strong>City:</strong>
                <?= htmlspecialchars($property['city']) ?>
            </p>

            <p>
                <strong>Price:</strong>
                $<?= htmlspecialchars($property['price']) ?>
            </p>

        </div>

    <?php endforeach; ?>

    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>