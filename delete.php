<?php
include 'config.php';

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header("Location: index1.php?msg=deleted");
exit;
?>