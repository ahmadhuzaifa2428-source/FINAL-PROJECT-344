<?php

/* Start session */
session_start();

/* Load database class */
require_once 'classes/RealEstateDatabase.php';

/* Create database object */
$db = new RealEstateDatabase();

/* Get selected property ID */
$propertyId = isset($_GET['id'])
    ? (int)$_GET['id']
    : 0;

/* Get property details */
$property = $db->getPropertyById($propertyId);

?>

<?php include 'includes/header.php'; ?>

<!-- Property details heading -->
<h2>Property Details</h2>

<?php if (!$property): ?>

    <p class="error">
        Property not found.
    </p>

<?php else: ?>

    <div class="card">

        <!-- Property image -->
        <img
            class="property-img"
            src="<?= htmlspecialchars($property['imagePath'] ?? 'assets/images/property1.jpg') ?>"
            alt="Property Image"
        >

        <!-- Property title -->
        <h3>
            <?= htmlspecialchars($property['title']) ?>
        </h3>

        <!-- Property details -->
        <p>
            <strong>Type:</strong>
            <?= htmlspecialchars($property['propertyType']) ?>
        </p>

        <p>
            <strong>Address:</strong>
            <?= htmlspecialchars($property['address']) ?>
        </p>

        <p>
            <strong>City:</strong>
            <?= htmlspecialchars($property['city']) ?>
        </p>

        <p>
            <strong>Price:</strong>
            $<?= htmlspecialchars($property['price']) ?>
        </p>

        <p>
            <strong>Status:</strong>
            <?= htmlspecialchars($property['status']) ?>
        </p>

        <p>
            <strong>Agent:</strong>
            <?= htmlspecialchars($property['agentName']) ?>
        </p>

        <!-- Buyer and renter actions -->
        <?php if (
            isset($_SESSION['user']) &&
            in_array(
                $_SESSION['user']['userType'],
                ['buyer', 'renter'],
                true
            )
        ): ?>

            <!-- Inquiry button -->
            <a
                class="btn"
                href="submit_inquiry.php?propertyId=<?= (int)$property['propertyId'] ?>"
            >
                Submit Inquiry
            </a>

            <!-- Save favorite button -->
            <a
                class="btn"
                href="save_favorite.php?propertyId=<?= (int)$property['propertyId'] ?>"
            >
                Save Favorite
            </a>

        <?php endif; ?>

    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>