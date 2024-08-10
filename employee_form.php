<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection variables
$servername = "192.168.56.102";
$username = "root";
$password = "nihar123";
$dbname = "organization";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $department = $_POST["department"];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO employees (employee_id, name, department) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $employee_id, $name, $department);

    if ($stmt->execute()) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Form</title>
</head>
<body>
    <h2>Employee Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Employee ID: <input type="text" name="employee_id" required><br><br>
        Name: <input type="text" name="name" required><br><br>
        Department: <input type="text" name="department" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
