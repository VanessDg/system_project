<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$sql = "INSERT INTO users (first_name, last_name, email, role, status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $data->first_name, $data->last_name, $data->email, $data->role, $data->status);

if ($stmt->execute()) {
  echo json_encode(["success" => true, "id" => $stmt->insert_id]);
} else {
  echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
