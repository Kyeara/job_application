<?php
require_once "core/dbConfig.php"; // Include DB connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch data from the form
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contactInfo = $_POST['contact_info'];

    // Prepare SQL query to insert new applicant
    $query = "INSERT INTO applicant (first_name, last_name, age, gender, email, contact_info) VALUES (:first_name, :last_name, :age, :gender, :email, :contact_info)";
    $stmt = $pdo->prepare($query);

    // Bind parameters to prevent SQL injection
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':contact_info', $contactInfo);

    try {
        // Execute query to insert data
        $stmt->execute();
        // Redirect to the main page after a successful submission
        header('Location: index.php'); // Change 'index.php' to the actual path of your main page
        exit(); // Exit to prevent further execution of the script
    } catch (PDOException $e) {
        // Handle the exception if the query fails
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Applicant</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin: 30px 0;
        }

        form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #2ecc71;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .message {
            text-align: center;
            color: green;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Insert New Applicant</h1>

    <div class="form-container">
        <!-- Insert Applicant Form -->
        <form action="insertApplicant.php" method="POST">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="age">Age</label>
            <input type="number" name="age" id="age" required>

            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>

            <label for="contact_info">Contact Number</label>
            <input type="text" name="contact_info" id="contact_info" required>

            <input type="submit" value="Submit Applicant">
        </form>

        <!-- Display success message if form is submitted successfully -->
        <?php if (isset($successMessage)) { ?>
            <div class="message"><?php echo $successMessage; ?></div>
        <?php } ?>
    </div>
</body>
</html>
