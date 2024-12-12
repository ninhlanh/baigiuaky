
<?php
// Kết nối đến cơ sở dữ liệu MySQL
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

// Khai báo biến tìm kiếm
$search_name = '';
$search_hometown = '';

// Kiểm tra nếu có yêu cầu tìm kiếm
if (isset($_POST['search'])) {
    $search_name = $_POST['search_name'];
    $search_hometown = $_POST['search_hometown'];
}

// Tạo câu truy vấn tìm kiếm
$sql = "SELECT * FROM table_students WHERE fullname LIKE '%$search_name%' AND hometown LIKE '%$search_hometown%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sinh viên</title>
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
<body>

<h1>Danh sách Sinh viên</h1>

<!-- Form tìm kiếm -->
<!-- Form tìm kiếm và nút thêm sinh viên -->
<form method="POST" action="" class="search-form">
    <input type="text" name="search_name" placeholder="Tìm theo tên" value="<?php echo $search_name; ?>">
    <input type="text" name="search_hometown" placeholder="Tìm theo quê quán" value="<?php echo $search_hometown; ?>">
    <button type="submit" name="search">Tìm kiếm</button>
    <a href="add.php" class="btn-add">Thêm sinh viên</a>
</form>

<?php
// Kiểm tra nếu có dữ liệu sinh viên
if ($result->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Quê quán</th>
                    <th>Trình độ học vấn</th>
                    <th>Nhóm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>";

    $index = 1;
    // Lặp qua các sinh viên và hiển thị thông tin
    while($row = $result->fetch_assoc()) {
        // Chuyển đổi giá trị giới tính
        $gender = ($row['gender'] == 1) ? 'Nam' : 'Nữ';

        // Chuyển đổi trình độ học vấn
        switch ($row['lever']) {
            case 0:
                $lever = "Tiến sĩ";
                break;
            case 1:
                $lever = "Thạc sĩ";
                break;
            case 2:
                $lever = "Kỹ sư";
                break;
            default:
                $lever = "Khác";
                break;
        }

        // Hiển thị dữ liệu sinh viên
        echo "<tr>
                <td>" . $index++ . "</td>
                <td>" . htmlspecialchars($row['fullname']) . "</td>
                <td>" . htmlspecialchars($row['dob']) . "</td>
                <td>" . htmlspecialchars($gender) . "</td>
                <td>" . htmlspecialchars($row['hometown']) . "</td>
                <td>" . htmlspecialchars($lever) . "</td>
                <td>" . htmlspecialchars($row['group_id']) . "</td>
                <td>
                    <a href='sua.php?id=" . $row['id'] . "' class='button edit'>Sửa</a>
                    <a href='delete.php?id=" . $row['id'] . "' class='button delete'>Xóa</a>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p class='no-data'>Không có sinh viên nào!</p>";
}

// Đóng kết nối
$conn->close();
?>

</body>
</html>
