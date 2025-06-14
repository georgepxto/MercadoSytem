<?php

// Suprimir completamente avisos de deprecation
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

// Executar o servidor Artisan
$command = 'php artisan serve --host=127.0.0.1 --port=8000';
system($command);
