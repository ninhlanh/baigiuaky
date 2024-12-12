<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "qlsv_ninhthilanh"; 

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// file: delete_student.php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli("localhost", "root", "", "qlsv_ninhthilanh");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "DELETE FROM table_students WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa sinh viên thành công!";
        header("Location: index.php"); // Quay lại danh sách sinh viên
    } else {
        echo "Lỗi: " . $conn->error;
    }

    $conn->close();
}
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên</title>
    <style>
        /* Reset một số thuộc tính mặc định của trình duyệt */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Cài đặt phông chữ toàn trang */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
}

/* Tiêu đề trang */
h1 {
    text-align: center;
    padding: 20px;
    background-color: #4CAF50;
    color: white;
}

/* Form tìm kiếm */
.search-form {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 20px 0;
}

/* Các trường input trong form */
.search-form input[type="text"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 200px;
}

/* Nút tìm kiếm */
.search-form button {
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.search-form button:hover {
    background-color: #45a049;
}

/* Nút thêm sinh viên */
.search-form .btn-add {
    padding: 8px 16px;
    background-color: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.search-form .btn-add:hover {
    background-color: #1976D2;
}

/* Bảng danh sách sinh viên */
table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
}

/* Tiêu đề cột */
table th {
    background-color: #4CAF50;
    color: white;
}

/* Các hàng trong bảng */
table tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Các nút thao tác (Sửa, Xóa) */
.button {
    padding: 6px 12px;
    border-radius: 4px;
    color: white;
    text-decoration: none;
}

.button.edit {
    background-color: #ffa500;
}

.button.delete {
    background-color: #f44336;
}

.button:hover {
    opacity: 0.8;
}

/* Thông báo khi không có dữ liệu */
.no-data {
    text-align: center;
    color: #888;
    font-size: 18px;
}

    </style>
</head>