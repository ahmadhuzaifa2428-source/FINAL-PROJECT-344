<?php
// Load required files
require_once 'config/config.php';
require_once 'includes/auth.php';
require_once 'classes/RealEstateDatabase.php';

// Allow agents only
requireRole(['agent']);

$message = '';

// Handle property form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new RealEstateDatabase();

    // Collect property information
    $title = trim($_POST['title'] ?? '');
    $propertyType = trim($_POST['propertyType'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $status = $_POST['status'] ?? 'available';
    $agentId = (int)$_SESSION['user']['userId'];

    // Validate property fields
    if ($title && $propertyType && $address && $city && $price > 0) {
        try {
            // Add listing to database
            $db->addProperty($title, $propertyType, $address, $city, $price, $status, $agentId);
            $message = 'Property added successfully.';
        } catch (Throwable $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    } else {
        $message = 'Please complete all required fields.';
    }
}
?>
<?php
// Show page header
include 'includes/header.php';
?>

<!-- Add property page title -->
<h2>Add Property</h2>

<!-- Add property status message -->
<?php if ($message): ?>
    <p class="<?= str_contains($message, 'successfully') ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<!-- New property form -->
<form method="POST">
    <label>Title</label>
    <input type="text" name="title" required>

    <label>Property Type</label>
    <input type="text" name="propertyType" placeholder="Apartment, House, Condo" required>

    <label>Address</label>
    <input type="text" name="address" required>

    <label>City</label>
    <input type="text" name="city" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price" required>

    <label>Status</label>
    <select name="status">
        <option value="available">available</option>
        <option value="sold">sold</option>
        <option value="rented">rented</option>
    </select>

    <button type="submit">Add Property</button>
</form>

<?php
// Show page footer
include 'includes/footer.php';
?>
