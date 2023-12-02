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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkStmt = $mysqli->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();
    if ($count > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    } else {
        $insertStmt = $mysqli->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $insertStmt->bind_param("sss", $username, $email, $password);
        if ($insertStmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
        }
        $insertStmt->close();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
$mysqli->close();
?>
