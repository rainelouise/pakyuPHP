<?php
// Start session to manage user data
session_start();

// Include necessary files (adjust the paths as needed)
require_once 'core/dbConfig.php'; // Database connection
require_once 'core/auth.php';      // Authentication logic

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Call the loginUser function to validate the user credentials
    $user = loginUser($pdo, $username, $password);
    
    if ($user) {
        // If login is successful, store username in session and redirect to dashboard
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        // If login fails, show an error message
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <!-- Display error message if login fails -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <h1>Login</h1>

    <!-- Login form -->
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password" required>
        <br>

        <button type="submit" name="loginBtn">Login</button>
    </form>

</body>
</html>