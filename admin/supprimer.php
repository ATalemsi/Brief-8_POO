<?php
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE ID_User = ?");
    $stmt->execute([$id]);

    header("Location: users.php");
    exit();
} else {
    echo "Invalid request";
}
?>
