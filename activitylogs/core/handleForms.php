<?php
require_once 'dbConfig.php';
require_once 'models.php';
require_once 'auth.php';

session_start(); // Ensure session is started

// Insert new user
if (isset($_POST['insertUserBtn'])) {
    $insertUser = insertNewUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['birth_date'], $_POST['gender'], $_POST['email_address'], $_POST['phone_number'], $_POST['applied_position'], $_POST['start_date'], $_POST['address'], $_POST['nationality']);
    if ($insertUser) {
        // Log the activity after successful insert
        $username = $_SESSION['username']; // Get the logged-in user
        logActivity($pdo, $username, 'Insert', "Added applicant: {$_POST['first_name']} {$_POST['last_name']}");
        
        // Set a success message
        $_SESSION['message'] = "Successfully inserted!";
        
        // Redirect to dashboard
        header("Location: ../dashboard.php");
        exit();
    } else {
        // Error message
        $_SESSION['message'] = "Failed to insert applicant!";
        header("Location: ../addApplicant.php"); // Redirect back to form if there's an error
        exit();
    }
}

// Edit existing user
if (isset($_POST['editUserBtn'])) {
    $editUser = editUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['birth_date'], $_POST['gender'], $_POST['email_address'], $_POST['phone_number'], $_POST['applied_position'], $_POST['start_date'], $_POST['address'], $_POST['nationality'], $_GET['id']);
    if ($editUser) {
        $_SESSION['message'] = "Successfully edited!";
        header("Location: ../dashboard.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to edit applicant!";
        header("Location: ../editApplicant.php?id=" . $_GET['id']); // Redirect back to edit form if there's an error
        exit();
    }
}

// Delete user
if (isset($_POST['deleteUserBtn'])) {
    $deleteUser = deleteUser($pdo, $_GET['id']);
    if ($deleteUser) {
        $_SESSION['message'] = "Successfully deleted!";
        header("Location: ../dashboard.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to delete applicant!";
        header("Location: ../dashboard.php"); // Redirect back to dashboard if there's an error
        exit();
    }
}

// Search for users
if (isset($_GET['searchBtn'])) {
    $searchInput = $_GET['searchInput'];
    $sql = "SELECT * FROM search_users_data WHERE first_name LIKE :searchInput OR last_name LIKE :searchInput";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['searchInput' => '%' . $searchInput . '%']);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display search results or a message if no results
    if ($results) {
        foreach ($results as $row) {
            echo "<tr> 
                    <td>{$row['id']}</td>
                    <td>{$row['first_name']}</td>
                    <td>{$row['last_name']}</td>
                    <td>{$row['email_address']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['applied_position']}</td>
                    <td>{$row['nationality']}</td>
                  </tr>";
        }
    } else {
        echo "No results found.";
    }
}
?>
