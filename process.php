<?php
// Подключаем конфигурацию БД
require_once 'config.php';

// Инициализируем переменные для ошибок и данных
$errors = [];
$device_type = $device_model = $problem_description = $desired_date = '';

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Получаем и очищаем данные
  $device_type = trim($_POST['device_type'] ?? '');
  $device_model = trim($_POST['device_model'] ?? '');
  $problem_description = trim($_POST['problem_description'] ?? '');
  $desired_date = $_POST['desired_date'] ?? '';

  // Валидация данных
  if (empty($device_type)) {
    $errors[] = "Поле 'Тип устройства' обязательно для заполнения.";
  } elseif (!in_array($device_type, ['Ноутбук', 'Смартфон', 'Планшет', 'Настольный компьютер', 'Монитор', 'Принтер', 'Сканер', 'Игровая консоль', 'Другое'])) {
    $errors[] = "Выбран недопустимый тип устройства.";
  }

  if (empty($device_model)) {
    $errors[] = "Поле 'Модель устройства' обязательно для заполнения.";
  } elseif (strlen($device_model) > 100) {
    $errors[] = "Модель устройства не должна превышать 100 символов.";
  }

  if (empty($problem_description)) {
    $errors[] = "Поле 'Описание проблемы' обязательно для заполнения.";
  } elseif (strlen($problem_description) > 1000) {
    $errors[] = "Описание проблемы не должно превышать 1000 символов.";
  }

  if (empty($desired_date)) {
    $errors[] = "Поле 'Желаемая дата приема' обязательно для заполнения.";
  } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $desired_date)) {
    $errors[] = "Неверный формат даты.";
  } else {
    $selected_date = strtotime($desired_date);
    $tomorrow = strtotime('+1 day');
    $one_year_later = strtotime('+1 year');

    if ($selected_date < $tomorrow) {
      $errors[] = "Дата приема не может быть сегодня или в прошлом.";
    } elseif ($selected_date > $one_year_later) {
      $errors[] = "Запись возможна не более чем на год вперед.";
    }
  }

  // Если ошибок нет, сохраняем в БД
  if (empty($errors)) {
    $connection = connectDB();

    // Подготовленный запрос для защиты от SQL-инъекций
    $query = "INSERT INTO service_requests (device_type, device_model, problem_description, desired_date) 
                  VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
      mysqli_stmt_bind_param($stmt, "ssss", $device_type, $device_model, $problem_description, $desired_date);

      if (mysqli_stmt_execute($stmt)) {
        // Перенаправляем на форму с сообщением об успехе
        header('Location: form.html?success=1');
        exit;
      } else {
        $errors[] = "Ошибка при сохранении данных: " . mysqli_error($connection);
      }

      mysqli_stmt_close($stmt);
    } else {
      $errors[] = "Ошибка подготовки запроса: " . mysqli_error($connection);
    }

    mysqli_close($connection);
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Результат обработки</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Результат обработки заявки</h1>

    <?php if (!empty($errors)): ?>
      <div class="error-list">
        <h3>Обнаружены ошибки:</h3>
        <?php foreach ($errors as $error): ?>
          <div class="error-item">• <?php echo htmlspecialchars($error); ?></div>
        <?php endforeach; ?>
      </div>
      <a href="form.html" class="btn">Вернуться к форме</a>
    <?php else: ?>
      <div class="success">
        ✓ Данные успешно прошли валидацию!
      </div>
      <div class="data-preview">
        <h3>Введенные данные:</h3>
        <div class="data-item">
          <span class="data-label">Тип устройства:</span>
          <?php echo htmlspecialchars($device_type); ?>
        </div>
        <div class="data-item">
          <span class="data-label">Модель устройства:</span>
          <?php echo htmlspecialchars($device_model); ?>
        </div>
        <div class="data-item">
          <span class="data-label">Описание проблемы:</span>
          <?php echo nl2br(htmlspecialchars($problem_description)); ?>
        </div>
        <div class="data-item">
          <span class="data-label">Желаемая дата:</span>
          <?php echo htmlspecialchars(date('d.m.Y', strtotime($desired_date))); ?>
        </div>
      </div>
      <a href="form.html" class="btn">Вернуться к форме</a>
    <?php endif; ?>
  </div>
</body>

</html>