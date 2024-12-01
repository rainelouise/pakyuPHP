<?php
require_once 'dbConfig.php';

function createApplicant($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO applicants (username, password, first_name, last_name, birth_date, gender, email_address, phone_number, applied_position, start_date, address, nationality) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute($data); // The data array now contains 12 elements, matching the number of placeholders
}

function getAllApplicants($pdo) {
    $query = "SELECT * FROM search_users_data"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateApplicant($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE applicants SET first_name = ?, last_name = ?, birth_date = ?, gender = ?, email_address = ?, phone_number = ?, applied_position = ?, start_date = ?, address = ?, nationality = ? WHERE id = ?");
    return $stmt->execute([...$data, $id]);
}

function deleteApplicant($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM applicants WHERE id = ?");
    return $stmt->execute([$id]);
}

function searchApplicants($pdo, $keyword) {
    $stmt = $pdo->prepare("SELECT * FROM applicants WHERE first_name LIKE ? OR last_name LIKE ?");
    $stmt->execute(["%$keyword%", "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to login a user
function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers($pdo) {
    $stmt = $pdo->query("SELECT * FROM search_users_data");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchForAUser($pdo, $searchInput) {
    $stmt = $pdo->prepare("SELECT * FROM search_users_data WHERE first_name LIKE ? OR last_name LIKE ? OR email_address LIKE ?");
    $searchQuery = "%$searchInput%";
    $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserInfo($pdo, $username) {
    $query = "SELECT * FROM users WHERE username = :username"; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        return false; 
    }
    
    return $user;
}
?>
