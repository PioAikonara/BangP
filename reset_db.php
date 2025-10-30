<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('DROP DATABASE IF EXISTS bangp');
    $pdo->exec('CREATE DATABASE bangp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    echo "✓ Database 'bangp' berhasil dibuat ulang!\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
