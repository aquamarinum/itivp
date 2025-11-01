<?php
// test_autoload.php
require_once 'vendor/autoload.php';

use Ipr3\URLHelper;

echo "Autoload test: ";
if (class_exists('Ipr3\URLHelper')) {
  echo "SUCCESS - URLHelper class loaded\n";
} else {
  echo "FAILED - URLHelper class not found\n";
}
