<?php
$mysqlHost = 'roundhouse.proxy.rlwy.net';
$mysqlUsername = 'root';
$mysqlPassword = 'ac32d242-cAahg2fggE6ghaD35Ce6eAc';
$mysqlDatabase = 'railway';
$mysqli = new mysqli($mysqlHost, $mysqlUsername, $mysqlPassword, $mysqlDatabase, 27340);
if ($mysqli->connect_error) {
    die("MySQL Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $checkStmt = $mysqli->prepare("SELECT password FROM user WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->bind_result($storedPassword);
    $checkStmt->fetch();
    $checkStmt->close();
    if ($storedPassword && $password === $storedPassword) {
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
$mysqli->close();
?>
