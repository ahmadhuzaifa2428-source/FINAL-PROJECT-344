<?php
// Load database class
require_once 'classes/RealEstateDatabase.php';
$message = '';

// Handle registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new RealEstateDatabase();

    // Collect form information
    $userName = trim($_POST['userName'] ?? '');
    $contactInfo = trim($_POST['contactInfo'] ?? '');
    $password = $_POST['password'] ?? '';
    $userType = $_POST['userType'] ?? '';

    // Check required fields
    if ($userName && $contactInfo && $password && $userType) {
        // Securely hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Add new user account
            $db->addUser($userName, $contactInfo, $passwordHash, $userType);
            $message = 'Registration successful. You may now log in.';
        } catch (Throwable $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    } else {
        $message = 'Please fill in all fields.';
    }
}
?>
<?php
// Show page header
include 'includes/header.php';
?>

<!-- Registration page title -->
<h2>Register</h2>

<!-- Registration status message -->
<?php if ($message): ?>
    <p class="<?= str_contains($message, 'successful') ? 'success' : 'error' ?>"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<!-- User registration form -->
<form method="POST">
    <label>Username</label>
    <input type="text" name="userName" required>

    <label>Contact Info</label>
    <input type="text" name="contactInfo" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>User Type</label>
    <select name="userType" required>
        <option value="">Select role</option>
        <option value="agent">Agent</option>
        <option value="buyer">Buyer</option>
        <option value="renter">Renter</option>
    </select>

    <button type="submit">Register</button>
</form>

<?php
// Show page footer
include 'includes/footer.php';
?>
