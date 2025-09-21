<?php
require_once 'config.php';

$conn = getDBConnection();
$sql = "SELECT * FROM tasks ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управления задачами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .completed {
            text-decoration: line-through;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Система управления задачами</h1>
        
        <div class="d-flex justify-content-center mb-3">
            <a href="add.php" class="btn btn-primary">Добавить новую задачу</a>
        </div>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo escape($_GET['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Статус</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="<?php echo $row['status'] == 'выполнена' ? 'completed' : ''; ?>">
                                    <?php echo escape($row['title']); ?>
                                </td>
                                <td class="<?php echo $row['status'] == 'выполнена' ? 'completed' : ''; ?>">
                                    <?php echo escape($row['description']); ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $row['status'] == 'выполнена' ? 'success' : 'warning'; ?>">
                                        <?php echo escape($row['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <?php if ($row['status'] == 'не выполнена'): ?>
                                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=выполнена" 
                                               class="btn btn-success btn-sm" title="Отметить выполненной">
                                                check
                                            </a>
                                        <?php else: ?>
                                            <a href="update_status.php?id=<?php echo $row['id']; ?>&status=не выполнена" 
                                               class="btn btn-warning btn-sm" title="Вернуть в работу">
                                                uncheck
                                            </a>
                                        <?php endif; ?>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-info btn-sm" title="Редактировать">
                                            ✎
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Вы уверены, что хотите удалить эту задачу?')" 
                                           title="Удалить">
                                            ×
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Задачи не найдены. Добавьте первую задачу!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>