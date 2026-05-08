<?php
// Load required files
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'classes/RealEstateDatabase.php';

// Allow buyers and renters
requireRole(['buyer', 'renter']);

$db = new RealEstateDatabase();
$message = '';

// Get selected property ID
$propertyId = isset($_GET['propertyId']) ? (int)$_GET['propertyId'] : (int)($_POST['propertyId'] ?? 0);

// Handle inquiry form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = (int)$_SESSION['user']['userId'];
    $messageText = trim($_POST['message'] ?? '');

    // Validate inquiry message
    if ($propertyId > 0 && $messageText !== '') {
        try {
            // Save inquiry to database
            $db->addInquiry($userId, $propertyId, $messageText);
            $message = 'Inquiry submitted successfully.';
        } catch (Throwable $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    } else {
        $message = 'Please enter a message.';
    }
}
?>
<?php
// Show page header
include 'includes/header.php';
?>

<!-- Inquiry page title -->
<h2>Submit Inquiry</h2>

<!-- Inquiry status message -->
<?php if ($message): ?>
    <p class="<?= str_contains($message, 'successfully') ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<!-- Property inquiry form -->
<form method="POST">
    <input type="hidden" name="propertyId" value="<?= (int)$propertyId ?>">

    <label>Message</label>
    <textarea name="message" rows="6" required></textarea>

    <button type="submit">Send Inquiry</button>
</form>

<?php
// Show page footer
include 'includes/footer.php';
?>
