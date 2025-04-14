<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"));

$sql = "UPDATE users SET first_name=?, last_name=?, email=?, role=?, status=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $data->first_name, $data->last_name, $data->email, $data->role, $data->status, $data->id);

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
