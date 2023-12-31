<?php
include_once('../mongo_connection.php');
$postData = file_get_contents("php://input");
if (!empty($postData)) {
    $jsonData = json_decode($postData, true);
    $username = $jsonData['username'];
    $field = $jsonData['field'];
    $value = $jsonData['value'];
    $filter = ['username' => $username];
    $update = ['$set' => [$field => $value]];
    $result = $users->updateOne($filter, $update,['upsert'=>true]);
    if ($result->getModifiedCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Document updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update document']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
?>
