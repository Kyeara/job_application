<?php
// Enable error reporting for debugging (add this for debugging purposes)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include necessary files
require_once "core/dbConfig.php";  // Ensure the dbConfig.php is included to initialize the $pdo object
require_once "core/models.php";     // Ensure models.php is included to use database functions

// Check if the $pdo connection is established
if (!$pdo) {
    die("Database connection failed.");
}

// Check if we have the applicant ID from the URL (get it from the query string)
if (isset($_GET['applicantID'])) {
    $applicantID = $_GET['applicantID'];

    // Fetch the applicant's current details to populate the form
    $query = "SELECT * FROM applicant WHERE applicantID = :applicantID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':applicantID', $applicantID);
    $stmt->execute();
    $applicant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$applicant) {
        // If the applicant doesn't exist, redirect to the index page
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect if no applicantID is provided
    header("Location: index.php");
    exit();
}

// Handle form submission and update the applicant details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contactInfo = $_POST['contact_info'];

    // Prepare SQL update query
    $sql = "UPDATE applicant SET 
            first_name = :first_name, 
            last_name = :last_name, 
            age = :age, 
            gender = :gender, 
            email = :email, 
            contact_info = :contact_info 
            WHERE applicantID = :applicantID";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);
    
    // Bind the parameters
    $stmt->bindParam(':applicantID', $applicantID);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact_info', $contactInfo);

    // Execute the statement
    if ($stmt->execute()) {
        // Success message and redirect to the main page
        $_SESSION['message'] = "Applicant updated successfully.";
        header("Location: index.php");
        exit();
    } else {
        // Failure message
        $_SESSION['message'] = "Failed to update applicant.";
    }
}
?>

<html>
<head>
    <title>Edit Applicant</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<h2>Edit Applicant</h2>

<!-- Display message if it exists -->
<?php if (isset($_SESSION['message'])) { ?>
    <h3 class="message"><?php echo $_SESSION['message']; ?></h3>
<?php } unset($_SESSION['message']); ?>

<!-- Form to update applicant details -->
<form action="editApplicant.php?applicantID=<?php echo $applicantID; ?>" method="POST">
    <p>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($applicant['first_name']); ?>" required>
    </p>
    <p>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($applicant['last_name']); ?>" required>
    </p>
    <p>
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" value="<?php echo $applicant['age']; ?>" required>
    </p>
    <p>
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="Male" <?php if ($applicant['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($applicant['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($applicant['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($applicant['email']); ?>" required>
    </p>
    <p>
        <label for="contact_info">Contact Info:</label>
        <input type="text" name="contact_info" id="contact_info" value="<?php echo htmlspecialchars($applicant['contact_info']); ?>" required>
    </p>
    <p>
        <input type="submit" name="submit" value="Update Applicant">
    </p>
</form>

</body>
</html>
