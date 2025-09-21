<?php
require_once 'config.php';

$conn = getDBConnection();
$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Менеджер контактов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="wrapper">
        <header class="header-gradient py-4 mb-4 text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bold"><i class="bi bi-person-lines-fill me-3"></i>Список контактов</h1>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="add.php" class="btn btn-light btn-lg rounded-pill px-4">
                            <i class="bi bi-plus-circle me-2"></i>Добавить контакт
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="container">
            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo escape($_GET['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($contact = $result->fetch_assoc()): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 <?php echo $contact['status'] == 'архивный' ? 'archived' : ''; ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title fw-bold text-truncate">
                                            <?php echo escape($contact['name']); ?>
                                        </h5>
                                        <span class="badge <?php echo $contact['status'] == 'активный' ? 'bg-success' : 'bg-secondary'; ?> status-badge">
                                            <?php echo escape($contact['status']); ?>
                                        </span>
                                    </div>

                                    <div class="contact-info mb-3">
                                        <?php if (!empty($contact['phone'])): ?>
                                            <p class="mb-2">
                                                <i class="bi bi-telephone-fill text-primary me-2"></i>
                                                <a href="tel:<?php echo escape($contact['phone']); ?>" class="text-decoration-none">
                                                    <?php echo formatPhone($contact['phone']); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (!empty($contact['email'])): ?>
                                            <p class="mb-2">
                                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                                <a href="mailto:<?php echo escape($contact['email']); ?>" class="text-decoration-none">
                                                    <?php echo ($contact['email']); ?>
                                                </a>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (!empty($contact['address'])): ?>
                                            <p class="mb-2">
                                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                                <span class="small"><?php echo escape($contact['address']); ?></span>
                                            </p>
                                        <?php endif; ?>

                                        <?php if (!empty($contact['notes'])): ?>
                                            <p class="mb-0 text-muted small">
                                                <i class="bi bi-chat-text me-2"></i>
                                                <?php echo nl2br(escape($contact['notes'])); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="contact-actions d-flex justify-content-between pt-3 border-top">
                                        <small class="text-muted">
                                            <?php echo date('d.m.Y H:i', strtotime($contact['created_at'])); ?>
                                        </small>
                                        <div class="btn-group">
                                            <?php if ($contact['status'] == 'активный'): ?>
                                                <a href="update_status.php?id=<?php echo $contact['id']; ?>&status=архивный"
                                                    class="btn btn-outline-secondary btn-sm" title="В архив">
                                                    <i class="bi bi-archive"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="update_status.php?id=<?php echo $contact['id']; ?>&status=активный"
                                                    class="btn btn-outline-success btn-sm" title="Восстановить">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            <?php endif; ?>
                                            <a href="edit.php?id=<?php echo $contact['id']; ?>"
                                                class="btn btn-outline-primary btn-sm" title="Редактировать">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete.php?id=<?php echo $contact['id']; ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Удалить этот контакт?')"
                                                title="Удалить">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-person-x display-1 text-muted"></i>
                            <h3 class="text-muted mt-3">Контактов пока нет</h3>
                            <p class="text-muted">Добавьте первый контакт, чтобы начать работу</p>
                            <a href="add.php" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-plus-circle me-2"></i>Добавить контакт
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>

        <footer class="bg-dark text-white py-4 mt-5">
            <div class="container text-center">
                <p class="mb-0">&copy; 2025 Менеджер контактов. Иванов, 220602. Все права защищены.</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>