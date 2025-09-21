<?php
require_once 'config.php';

if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['status'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$status = escape($_GET['status']);

$allowed_statuses = ['не выполнена', 'выполнена'];
if (!in_array($status, $allowed_statuses)) {
    header("Location: index.php");
    exit();
}

$conn = getDBConnection();
$sql = "UPDATE tasks SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    header("Location: index.php?message=Статус задачи успешно обновлен");
} else {
    header("Location: index.php?message=Ошибка при обновлении статуса задачи");
}

$stmt->close();
$conn->close();
exit();
?>