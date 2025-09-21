<?php
require_once 'config.php';

$name = $phone = $email = $address = $notes = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($_POST['name']);
    $phone = escape($_POST['phone']);
    $email = escape($_POST['email']);
    $address = escape($_POST['address']);
    $notes = escape($_POST['notes']);

    // Валидация
    if (empty($name) || empty($phone)) {
        $error = 'Имя и телефон обязательны для заполнения';
    } elseif (!isValidBelarusPhone($phone)) {
        $error = 'Пожалуйста, введите корректный белорусский номер телефона';
    } elseif (!isPhoneUnique($phone)) {
        $error = 'Контакт с таким номером телефона уже существует';
    } else {
        $normalized_phone = normalizePhone($phone);
        $conn = getDBConnection();

        $sql = "INSERT INTO contacts (name, phone, email, address, notes) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $normalized_phone, $email, $address, $notes);

        if ($stmt->execute()) {
            header("Location: index.php?message=Контакт успешно добавлен");
            exit();
        } else {
            if ($conn->errno == 1062) {
                $error = 'Контакт с таким номером телефона уже существует';
            } else {
                $error = "Ошибка при добавлении контакта: " . $conn->error;
            }
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить контакт - Менеджер контактов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold"><i class="bi bi-person-plus me-2"></i>Добавить новый контакт</h2>
                        <p class="text-muted">Заполните информацию о контакте</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="" id="contactForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Имя *</label>
                                <input type="text" class="form-control rounded-3" name="name"
                                    value="<?php echo $name; ?>" required maxlength="255"
                                    placeholder="Введите имя">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Телефон *</label>
                                <input type="tel" class="form-control rounded-3" name="phone"
                                    value="<?php echo $phone; ?>" required
                                    placeholder="+375 (29) 123-45-67"
                                    pattern="^(\+375|80)(\s?\(?\d{2}\)?\s?)?\d{3}(\s?\-?\d{2}){2}$">
                                <div class="form-text">
                                    Форматы: +375291234567, +375 (29) 123-45-67, 80291234567
                                </div>
                                <div class="form-text">
                                    Коды операторов: 17, 25, 29, 33, 44
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control rounded-3" name="email"
                                value="<?php echo $email; ?>" maxlength="255"
                                placeholder="email@example.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Адрес</label>
                            <textarea class="form-control rounded-3" name="address"
                                rows="2" placeholder="Введите адрес"><?php echo $address; ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Заметки</label>
                            <textarea class="form-control rounded-3" name="notes"
                                rows="3" placeholder="Дополнительная информация"><?php echo $notes; ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="bi bi-arrow-left me-2"></i>Назад
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-check-circle me-2"></i>Добавить контакт
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Маска для телефона
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.startsWith('80')) {
                value = value.substring(2);
                value = '+375' + value;
            } else if (value.startsWith('375')) {
                value = '+' + value;
            }

            // Форматирование: +375 (XX) XXX-XX-XX
            if (value.startsWith('+375') && value.length > 4) {
                let formatted = '+375 (';
                let numbers = value.substring(4).replace(/\D/g, '');

                if (numbers.length > 0) {
                    formatted += numbers.substring(0, 2);
                }
                if (numbers.length > 2) {
                    formatted += ') ' + numbers.substring(2, 5);
                }
                if (numbers.length > 5) {
                    formatted += '-' + numbers.substring(5, 7);
                }
                if (numbers.length > 7) {
                    formatted += '-' + numbers.substring(7, 9);
                }

                e.target.value = formatted;
            }
        });

        // Валидация телефона при отправке формы
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const phoneInput = document.querySelector('input[name="phone"]');
            let phoneValue = phoneInput.value.replace(/\D/g, '');

            // Нормализация номера
            if (phoneValue.startsWith('80')) {
                phoneValue = '+375' + phoneValue.substring(2);
            } else if (phoneValue.startsWith('375')) {
                phoneValue = '+' + phoneValue;
            } else if (phoneValue.length === 9) {
                phoneValue = '+375' + phoneValue;
            }

            // Проверка формата белорусского номера
            const phoneRegex = /^\+375(17|25|29|33|44)\d{7}$/;

            if (!phoneRegex.test(phoneValue)) {
                e.preventDefault();
                alert('Пожалуйста, введите корректный белорусский номер телефона.\nПример: +375 (29) 123-45-67');
                phoneInput.focus();
            }
        });
    </script>
</body>

</html>