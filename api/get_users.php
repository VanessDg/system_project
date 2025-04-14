<?php
include 'db.php';

$sql = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
  $users[] = $row;
}

echo json_encode($users);
?>
