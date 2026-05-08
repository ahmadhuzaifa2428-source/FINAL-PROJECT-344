<?php

/* Load config */
require_once 'config/config.php';

/* Load auth file */
require_once 'includes/auth.php';

/* Load database class */
require_once 'classes/RealEstateDatabase.php';

/* Require login */
requireLogin();

/* Current user */
$user = $_SESSION['user'];

/* Create database object */
$db = new RealEstateDatabase();

/* Get database connection */
$conn = $db->getConnection();

/* Get current user's inquiries */
$stmt = $conn->prepare(
    "SELECT 
        i.inquiryId,
        i.message,
        i.inquiryDate,
        p.title,
        p.city,
        p.price
    FROM Inquiries i
    JOIN Properties p
    ON i.propertyId = p.propertyId
    WHERE i.userId = ?
    ORDER BY i.inquiryDate DESC"
);

$stmt->execute([
    $user['userId']
]);

$inquiries = $stmt->fetchAll();

?>

<?php include 'includes/header.php'; ?>

<!-- Dashboard heading -->
<h2>Dashboard</h2>

<!-- User information -->
<div class="card">
    <p><strong>Welcome:</strong> <?= htmlspecialchars($user['userName']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars($user['userType']) ?></p>
</div>

<!-- Agent actions -->
<?php if ($user['userType'] === 'agent'): ?>

    <div class="card">
        <h3>Agent Actions</h3>

        <a class="btn" href="add_property.php">
            Add Property
        </a>
    </div>

<?php endif; ?>

<!-- Common actions -->
<div class="card">
    <h3>Common Actions</h3>

    <a class="btn" href="properties.php">
        Browse Properties
    </a>

    <?php if (in_array($user['userType'], ['buyer', 'renter'], true)): ?>

        <a class="btn" href="favorites.php">
            View Favorites
        </a>

    <?php endif; ?>
</div>

<!-- Buyer/renter inquiries -->
<?php if (in_array($user['userType'], ['buyer', 'renter'], true)): ?>

    <h3>Your Inquiries</h3>

    <?php if (!$inquiries): ?>

        <div class="card">
            <p>You have not submitted any inquiries yet.</p>
        </div>

    <?php else: ?>

        <?php foreach ($inquiries as $inquiry): ?>

            <div class="card">
                <h4><?= htmlspecialchars($inquiry['title']) ?></h4>

                <p>
                    <strong>City:</strong>
                    <?= htmlspecialchars($inquiry['city']) ?>
                </p>

                <p>
                    <strong>Price:</strong>
                    $<?= htmlspecialchars($inquiry['price']) ?>
                </p>

                <p>
                    <strong>Your Message:</strong>
                    <?= htmlspecialchars($inquiry['message']) ?>
                </p>

                <p>
                    <strong>Date:</strong>
                    <?= htmlspecialchars($inquiry['inquiryDate']) ?>
                </p>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>