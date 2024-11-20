<?php

require_once 'dbConfig.php';

// Get all applicants
function getAllApplicant($pdo) {
    $sql = "SELECT * FROM applicant ORDER BY applicantID ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "querySet" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to get applicants!"
        ];
    }
}

// Get a single applicant by ID
function getApplicantByID($pdo, $applicantID) {
    $sql = "SELECT * FROM applicant WHERE applicantID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicantID]);

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "querySet" => $stmt->fetch(PDO::FETCH_ASSOC)
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to get applicant with ID " . $applicantID
        ];
    }
}

// Search for applicants by query
function searchForApplicant($pdo, $searchQuery) {
    $sql = "SELECT * FROM applicant WHERE CONCAT(first_name, last_name, age, gender, email, contact_info, date_added) LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%" . $searchQuery . "%"]);

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "querySet" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to search applicants!"
        ];
    }
}

// Edit an applicant's details
function editApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info, $applicantID) {
    $query = "UPDATE applicant SET first_name = ?, last_name = ?, age = ?, gender = ?, email = ?, contact_info = ? WHERE applicantID = ?";
    $stmt = $pdo->prepare($query);
    $executeQuery = $stmt->execute([$first_name, $last_name, $age, $gender, $email, $contact_info, $applicantID]);

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "message" => "Applicant " . $applicantID . " edited successfully!"
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to edit applicant " . $applicantID . "!"
        ];
    }
}

// Delete an applicant by ID
function deleteApplicantByID($pdo, $applicantID) {
    $sql = "DELETE FROM applicant WHERE applicantID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$applicantID]);

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "message" => "Applicant " . $applicantID . " has been deleted!"
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to delete applicant " . $applicantID . "!"
        ];
    }
}

// Add a new applicant
function addApplicant($pdo, $first_name, $last_name, $age, $gender, $email, $contact_info) {
    $query = "INSERT INTO applicant (first_name, last_name, age, gender, email, contact_info) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $executeQuery = $stmt->execute([$first_name, $last_name, $age, $gender, $email, $contact_info]);

    if ($executeQuery) {
        return [
            "statusCode" => 200,
            "message" => "Application submitted successfully!"
        ];
    } else {
        return [
            "statusCode" => 400,
            "message" => "Failed to submit application!"
        ];
    }
}
?>
