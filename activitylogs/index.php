<?php 
require_once 'core/dbConfig.php'; // Include database connection
require_once 'core/models.php';    // Include models (if needed, but not for loginUser)
require_once 'core/auth.php';      // Include authentication logic (this is where loginUser should be)
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="css/styles.css">
</head>

<?php
// Check if the form was submitted and process the registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insertUserBtn'])) {
    $username = $_POST['username'];

    // Check if username already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        // If the username already exists, show an error message and skip registration
        $error = "Username already exists. Please choose another one.";
    } else {
        // Proceed with registration if username doesn't exist
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password

        $data = [
            $username, // New username field
            $password, // New password field
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['birth_date'],
            $_POST['gender'],
            $_POST['email_address'],
            $_POST['phone_number'],
            $_POST['applied_position'],
            $_POST['start_date'],
            $_POST['address'],
            $_POST['nationality']
        ];

        // Insert new user into the database
        $insertUser = createApplicant($pdo, $data); 

        if ($insertUser) {
            $_SESSION['message'] = "Successfully registered! Please log in.";
            header("Location: login.php"); // Redirect to login page
            exit;
        } else {
            $error = "Failed to register.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Nursing Application Registration Form</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php elseif (!empty($_SESSION['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br>

        <label for="birth_date">Birth Date:</label>
        <input type="date" id="birth_date" name="birth_date" required>
        <br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <br>

        <label for="email_address">Email Address:</label>
        <input type="email" id="email_address" name="email_address" required>
        <br>

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" required>
        <br>

        <label for="applied_position">Applied Position:</label>
        <input type="text" id="applied_position" name="applied_position" required>
        <br>

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>
        <br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <br>

        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" required>
        <br>

        <button type="submit" name="insertUserBtn">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>