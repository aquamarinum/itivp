# run-tests.sh - Основной скрипт для запуска тестов проекта ipr3
echo "==========================================="
echo "Запуск тестов проекта ipr3"
echo "==========================================="

# Проверяем установлен ли Composer
if [ ! -f "composer.json" ]; then
    echo "❌ Ошибка: composer.json не найден!"
    exit 1
fi

# Проверяем установлены ли зависимости
if [ ! -d "vendor" ]; then
    echo "📦 Установка зависимостей Composer..."
    php composer.phar install
fi

# Обновляем автозагрузку
echo "🔄 Обновление автозагрузки..."
php composer.phar dump-autoload

# Запускаем все тесты
echo "🚀 Запуск всех тестов..."
./vendor/bin/phpunit

# Сохраняем код возврата
TEST_EXIT_CODE=$?

echo "==========================================="
if [ $TEST_EXIT_CODE -eq 0 ]; then
    echo "✅ Все тесты прошли успешно!"
else
    echo "❌ Некоторые тесты не прошли"
fi
echo "==========================================="

exit $TEST_EXIT_CODE