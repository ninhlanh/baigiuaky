<?php
// file: update_student.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $hometown = $_POST['hometown'];
    $lever = $_POST['lever']; // Đảm bảo tên cột đúng
    $group = $_POST['group'];

    // Kết nối tới CSDL
    $conn = new mysqli("localhost", "root", "", "qlsv_ninhthilanh");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Sử dụng Prepared Statements để tránh SQL Injection
    $stmt = $conn->prepare("UPDATE table_students SET fullname=?, dob=?, gender=?, hometown=?, lever=?, group_id=? WHERE id=?");
    $stmt->bind_param("ssssssi", $fullname, $dob, $gender, $hometown, $lever, $group, $id); // Gán các tham số vào Prepared Statement

    if ($stmt->execute()) {
        echo "Cập nhật sinh viên thành công!";
        header("Location: index.php"); // Quay lại danh sách sinh viên
        exit(); // Đảm bảo không có lỗi tiếp theo sau header
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
} else {
    // Lấy thông tin sinh viên từ cơ sở dữ liệu khi mở form
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Kết nối tới cơ sở dữ liệu
        $conn = new mysqli("localhost", "root", "", "qlsv_ninhthilanh");

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Lấy thông tin sinh viên từ cơ sở dữ liệu
        $stmt = $conn->prepare("SELECT * FROM table_students WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
        } else {
            echo "Không tìm thấy sinh viên!";
            exit();
        }

        // Đóng kết nối
        $stmt->close();
        $conn->close();
    } else {
        echo "ID sinh viên không được xác định!";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sinh viên</title>
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
    <h1>Sửa thông tin sinh viên</h1>
    <form method="POST">
        <!-- ID của sinh viên sẽ được truyền qua URL hoặc từ cơ sở dữ liệu -->
        <input type="hidden" name="id" value="<?php echo isset($student['id']) ? $student['id'] : ''; ?>">

        <label for="fullname">Họ và tên:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo isset($student['fullname']) ? $student['fullname'] : ''; ?>" required><br><br>

        <label for="dob">Ngày sinh:</label>
        <input type="date" id="dob" name="dob" value="<?php echo isset($student['dob']) ? $student['dob'] : ''; ?>" required><br><br>

        <label>Giới tính:</label>
        <input type="radio" id="male" name="gender" value="1" <?php echo (isset($student['gender']) && $student['gender'] == 1) ? 'checked' : ''; ?>><label for="male">Nam</label>
        <input type="radio" id="female" name="gender" value="0" <?php echo (isset($student['gender']) && $student['gender'] == 0) ? 'checked' : ''; ?>><label for="female">Nữ</label><br><br>

        <label for="hometown">Quê quán:</label>
        <input type="text" id="hometown" name="hometown" value="<?php echo isset($student['hometown']) ? $student['hometown'] : ''; ?>"><br><br>

        <label for="lever">Trình độ học vấn:</label>
        <select id="lever" name="lever">
            <option value="0" <?php echo (isset($student['lever']) && $student['lever'] == 0) ? 'selected' : ''; ?>>Tiến sĩ</option>
            <option value="1" <?php echo (isset($student['lever']) && $student['lever'] == 1) ? 'selected' : ''; ?>>Thạc sĩ</option>
            <option value="2" <?php echo (isset($student['lever']) && $student['lever'] == 2) ? 'selected' : ''; ?>>Kỹ sư</option>
            <option value="3" <?php echo (isset($student['lever']) && $student['lever'] == 3) ? 'selected' : ''; ?>>Khác</option>
        </select><br><br>

        <label for="group">Nhóm:</label>
        <input type="number" id="group" name="group" min="1" value="<?php echo isset($student['group_id']) ? $student['group_id'] : ''; ?>" required><br><br>

        <button type="submit">Lưu</button>
    </form>
</body>
</html>
