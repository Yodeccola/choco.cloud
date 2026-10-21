<?php
require_once 'config.php';

// Memeriksa status kesehatan koneksi database
if (isset($conn) && !$conn->connect_error) {
    http_response_code(200);
    echo "OK";
} else {
    http_response_code(500);
    echo "ERROR: Database connection unstable";
}
?>
