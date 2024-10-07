<?php
require './config.php'; // Adjust the path as necessary

// Fetch the img_url where id = 1
$stmt = $pdo->prepare("SELECT img_url FROM upload_image WHERE id = 1");
$stmt->execute();
$image = $stmt->fetch(PDO::FETCH_ASSOC);

if ($image) {
    echo json_encode(['img_url' => $image['img_url']]);
} else {
    echo json_encode(['img_url' => null]);
}
?>
