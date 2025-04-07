<?php
require 'db1.php';

header('Content-Type: application/json');

try {
    if (
        isset($_POST['location_name'], $_POST['description'], $_POST['category'],
              $_POST['latitude'], $_POST['longitude']) && isset($_FILES['image_path'])
    ) {
        $location_name = $_POST['location_name'];
        $age = $_POST['age'] ?? '';
        $description = $_POST['description'];
        $category = $_POST['category'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        // Handle image upload
        $image = $_FILES['image_path'];
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = time() . '_' . basename($image['name']);
        $imagePath = $uploadDir . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Image upload failed or you need to upload an image.']);
            exit;
        }

        // Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO map_editor
            (location_name, age, description, category, latitude, longitude, image_path) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $location_name, $age, $description, $category,
            $latitude, $longitude, $imagePath
        ]);

        echo json_encode([
            'success' => true,
            'location_name' => $location_name,
            'category' => $category,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incomplete form submission.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
