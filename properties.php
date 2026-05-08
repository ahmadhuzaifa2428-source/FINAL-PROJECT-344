<?php

/* Load database class */
require_once 'classes/RealEstateDatabase.php';

/* Create database object */
$db = new RealEstateDatabase();

/* Get all properties */
$properties = $db->getAllProperties();

?>

<?php include 'includes/header.php'; ?>

<!-- Listings heading -->
<h2>Property Listings</h2>

<?php if (!$properties): ?>
    <p>No properties found.</p>
<?php endif; ?>

<!-- Property card layout -->
<div class="property-grid">

<?php foreach ($properties as $property): ?>

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

        <p>
            <strong>Status:</strong>
            <?= htmlspecialchars($property['status']) ?>
        </p>

        <p>
            <strong>Agent:</strong>
            <?= htmlspecialchars($property['agentName']) ?>
        </p>

        <!-- Details button -->
        <a
            class="btn"
            href="property_details.php?id=<?= (int)$property['propertyId'] ?>"
        >
            View Details
        </a>

    </div>

<?php endforeach; ?>

</div>

<?php include 'includes/footer.php'; ?>