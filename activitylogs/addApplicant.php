<?php
require_once 'core/handleForms.php';  // Handle form submissions
require_once 'core/models.php';        // Include models for database interactions
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Applicant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Add New Applicant</h1>

    <!-- Form to insert a new applicant -->
    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="first_name">First Name</label> 
            <input type="text" name="first_name" required>
        </p>
        <p>
            <label for="last_name">Last Name</label> 
            <input type="text" name="last_name" required>
        </p>
        <p>
            <label for="birth_date">Date of Birth</label> 
            <input type="date" name="birth_date" required>
        </p>
        <p>
            <label for="gender">Gender</label> 
            <input type="text" name="gender" required>
        </p>
        <p>
            <label for="email_address">Email Address</label> 
            <input type="email" name="email_address" required>
        </p>
        <p>
            <label for="phone_number">Phone Number</label> 
            <input type="text" name="phone_number" required>
        </p>
        <p>
            <label for="applied_position">Applied Position</label> 
            <input type="text" name="applied_position" required>
        </p>
        <p>
            <label for="start_date">Start Date</label> 
            <input type="date" name="start_date" required>
        </p>
        <p>
            <label for="address">Address</label> 
            <input type="text" name="address" required>
        </p>
        <p>
            <label for="nationality">Nationality</label> 
            <input type="text" name="nationality" required>
        </p>

        <p>
            <input type="submit" name="insertApplicantBtn" value="Add Applicant">
        </p>
    </form>

</body>
</html>
