<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once 'core/models.php';

// Get user details from the database
$username = $_SESSION['username'];
$userInfo = getUserInfo($pdo, $username);  // Assuming this function fetches user info

$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'logout') {
    session_destroy();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Display First Name -->
    <h1>Welcome, <?php echo isset($userInfo['first_name']) && !empty($userInfo['first_name']) ? $userInfo['first_name'] : ''; ?>!</h1>

    <a href="?action=logout">Logout</a>

    <p><a href="addApplicant.php">Add New Applicant</a></p>
    <p><a href="activityLogs.php">View Activity Logs</a></p>
    <p><a href="search.php">Search Applicants</a></p>

    <!-- Table to display all applicants -->
    <h2>Applicant List</h2>
    <table border="1" style="width:100%; margin-top: 20px;">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Applied Position</th>
            <th>Start Date</th>
            <th>Address</th>
            <th>Nationality</th>
            <th>Action</th>
        </tr>

        <?php
        // Fetch all applicants
        $allApplicants = getAllApplicants($pdo);

        if ($allApplicants) {
            foreach ($allApplicants as $row) {
        ?>
                <tr>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['birth_date']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['email_address']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['applied_position']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['nationality']; ?></td>
                    <td>
                        <a href="editApplicant.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="deleteApplicant.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
        <?php 
            }
        } else { 
        ?>
            <tr><td colspan="11">No applicants found.</td></tr>
        <?php } ?>
    </table>
</body>
</html>