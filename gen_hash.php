<?php
$pw = password_hash('admin123', PASSWORD_BCRYPT);
file_put_contents(__DIR__ . '/hash.txt', $pw);
echo "Hash generated and saved to hash.txt\n";
echo $pw . "\n";