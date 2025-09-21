<?php
require_once 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

$conn = getDBConnection();
$sql = "DELETE FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?message=Задача успешно удалена");
} else {
    header("Location: index.php?message=Ошибка при удалении задачи");
}

$stmt->close();
$conn->close();
exit();
?>