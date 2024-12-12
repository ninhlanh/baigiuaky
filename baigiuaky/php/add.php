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

// file: add_student.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $lever = $_POST['lever'];
    $group = $_POST['group'];



    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Thêm dữ liệu vào bảng
    $sql = "INSERT INTO table_students (fullname, dob, gender, hometown, lever, group_id) 
            VALUES ('$fullname', '$dob', '$gender', '$hometown', '$lever', '$group')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sinh viên thành công!";
        header("Location: index.php"); // Quay lại danh sách sinh viên
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
    <style>
        /* Reset một số thuộc tính mặc định */
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
    padding: 20px;
}

/* Tiêu đề trang */
h1 {
    text-align: center;
    color: #4CAF50;
    font-size: 2rem;
    margin-bottom: 20px;
}

/* Form sửa thông tin sinh viên */
form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Các label */
label {
    font-size: 1rem;
    margin-bottom: 8px;
    display: block;
    color: #333;
}

/* Các trường input và select */
input[type="text"], input[type="date"], input[type="number"], select {
    width: 100%;
    padding: 8px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

/* Các nút radio (Giới tính) */
input[type="radio"] {
    margin-right: 8px;
}

/* Nút submit */
button[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    width: 100%;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Khoảng cách giữa các phần tử */
br {
    margin-bottom: 12px;
}

/* Định dạng cho thông báo lỗi thành công */
.success-message, .error-message {
    text-align: center;
    font-size: 1.2rem;
    margin-top: 20px;
}

.success-message {
    color: #4CAF50;
}

.error-message {
    color: #f44336;
}

    </style>
</head>
<body>
    <h1>Thêm mới sinh viên</h1>
    <form  method="POST">
        <label for="fullname">Họ và tên:</label>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="dob">Ngày sinh:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label>Giới tính:</label>
        <input type="radio" id="male" name="gender" value="1" checked><label for="male">Nam</label>
        <input type="radio" id="female" name="gender" value="0"><label for="female">Nữ</label><br><br>

        <label for="hometown">Quê quán:</label>
        <input type="text" id="hometown" name="hometown"><br><br>

        <label for="lever">Trình độ học vấn:</label>
        <select id="lever" name="lever">
            <option value="0">Tiến sĩ</option>
            <option value="1">Thạc sĩ</option>
            <option value="2">Kỹ sư</option>
            <option value="3">Khác</option>
        </select><br><br>

        <label for="group">Nhóm:</label>
        <input type="number" id="group" name="group" min="1" required><br><br>

        <button type="submit">Lưu</button>
    </form>
</body>
</html>