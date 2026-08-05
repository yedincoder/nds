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

echo '=== downloads schema ===' . PHP_EOL;
$result = $conn->query('DESCRIBE downloads');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' | ' . $row['Type'] . PHP_EOL;
    }
} else {
    echo 'ERROR: ' . $conn->error . PHP_EOL;
}

echo PHP_EOL . '=== sample downloads ===' . PHP_EOL;
$result = $conn->query('SELECT * FROM downloads LIMIT 5');
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row) . PHP_EOL;
    }
} else {
    echo 'No downloads found. ERROR: ' . $conn->error . PHP_EOL;
}

$conn->close();