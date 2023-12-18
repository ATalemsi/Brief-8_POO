<?php
session_start();
include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE ProjectID = ?");
    $stmt->execute([$id]);
    header("Location: project.php");
    exit();

     } else {
    echo "Invalid request";
}
?>