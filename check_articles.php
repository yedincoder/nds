<?php
$host = '127.0.0.1';
$db = 'ngappid';
$user = 'root';
$pass = '';
$port = 3307;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo '=== articles schema ===' . PHP_EOL;
$result = $conn->query('DESCRIBE articles');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' | ' . $row['Type'] . PHP_EOL;
    }
} else {
    echo 'ERROR: ' . $conn->error . PHP_EOL;
}

echo PHP_EOL . '=== sample article ===' . PHP_EOL;
$result = $conn->query("SELECT id, title, slug, status, published_at FROM articles LIMIT 3");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo 'ID=' . $row['id'] . ' | ' . $row['title'] . ' | slug=' . $row['slug'] . ' | ' . $row['status'] . PHP_EOL;
    }
} else {
    echo 'No articles found' . PHP_EOL;
}

$conn->close();
