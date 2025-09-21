<?php
require_once 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$title = $description = '';
$error = '';

$conn = getDBConnection();
$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$task = $result->fetch_assoc();
$title = $task['title'];
$description = $task['description'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = escape($_POST['title']);
    $description = escape($_POST['description']);
    
    if (empty($title)) {
        $error = 'Название задачи обязательно для заполнения';
    } else {
        $update_sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $title, $description, $id);
        
        if ($update_stmt->execute()) {
            header("Location: index.php?message=Задача успешно обновлена");
            exit();
        } else {
            $error = "Ошибка при обновлении задачи: " . $conn->error;
        }
        
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать задачу - Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Редактировать задачу</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="title" class="form-label">Название задачи *</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($title); ?>" required maxlength="255">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание задачи</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="4"><?php echo htmlspecialchars($description); ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">Назад к списку</a>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>