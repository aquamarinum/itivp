<?php
$api_key = "test-key-123";
$hashed_key = password_hash($api_key, PASSWORD_DEFAULT);
echo "Original: " . $api_key . "\n";
echo "Hashed: " . $hashed_key . "\n";
