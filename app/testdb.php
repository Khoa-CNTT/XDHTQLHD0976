<?php
$servername = getenv('DB_HOST');  // Lấy giá trị DB_HOST từ env
$username = getenv('DB_USERNAME'); // Lấy giá trị DB_USERNAME từ env
$password = getenv('DB_PASSWORD'); // Lấy giá trị DB_PASSWORD từ env
$dbname = getenv('DB_DATABASE');   // Lấy giá trị DB_DATABASE từ env

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
} else {
    echo "Kết nối MySQL thành công!";
}

$conn->close();
?>
