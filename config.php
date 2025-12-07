<?php
// Basic environment loader and config defaults for the app.
function loadEnv(string $path): void
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || strpos($trimmed, '#') === 0) {
            continue;
        }

        [$rawKey, $rawValue] = array_pad(explode('=', $line, 2), 2, '');
        $key = trim($rawKey);
        $value = trim($rawValue, " \t\n\r\0\x0B\"' ");
        if ($key !== '') {
            putenv($key . '=' . $value);
        }
    }
}

loadEnv(__DIR__ . '/.env');

return [
    'db_host' => getenv('DB_HOST') ?: '127.0.0.1',
    'db_port' => getenv('DB_PORT') ?: '3306',
    'db_name' => getenv('DB_DATABASE') ?: 'dev_museum',
    'db_user' => getenv('DB_USERNAME') ?: 'root',
    'db_pass' => getenv('DB_PASSWORD') ?: '',
];
