<?php
$conn = new mysqli('localhost', 'root', '', 'AttendanceSystem');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm sinh viên
if ($_GET['action'] == 'add_student') {
    // Lấy dữ liệu từ POST
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dateOfBirth'];
    $major = $_POST['major'];
    $address = $_POST['address'];
    $password = $_POST['password']; // Lấy mật khẩu từ form

    // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashedPassword = hash('sha256', $password);

    // Truy vấn SQL để thêm sinh viên vào bảng Account
    $sql = "INSERT INTO Account (FirstName, LastName, Email, Phone, DateOfBirth, Major, Address, PasswordSHA256)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$dob', '$major', '$address', '$hashedPassword')";

    if (mysqli_query($conn, $sql)) {
        // Lấy ID của sinh viên vừa thêm vào
        $accountID = mysqli_insert_id($conn);

        // Thêm sinh viên vào bảng user_roles với RoleID = 3 (Student)
        $roleID = 3; // Giả sử ID của role "Student" là 3
        $sql_roles = "INSERT INTO user_roles (AccountID, RoleID) VALUES ('$accountID', '$roleID')";

        if (mysqli_query($conn, $sql_roles)) {
            // Nếu thêm thành công, chuyển hướng về trang studentmanagement.php
            header('Location: studentmanagement.php');
        } else {
            // In ra lỗi nếu không thể thêm vào bảng user_roles
            echo "Error assigning role: " . mysqli_error($conn);
        }
    } else {
        // In ra lỗi nếu không thể thêm vào bảng Account
        echo "Error: " . mysqli_error($conn);
    }
}
// Xử lý sửa sinh viên
if ($_GET['action'] == 'update') {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dateOfBirth'];
    $major = $_POST['major'];
    $address = $_POST['address'];

    $sql = "UPDATE Account SET 
            FirstName='$firstName', 
            LastName='$lastName', 
            Email='$email', 
            Phone='$phone', 
            DateOfBirth='$dob', 
            Major='$major', 
            Address='$address' 
            WHERE AccountID=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: studentmanagement.php'); // Redirect after updating
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // In case of error
    }
}

// Xử lý xóa sinh viên
if ($_GET['action'] == 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM Account WHERE AccountID = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: studentmanagement.php'); // Redirect after deleting
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // In case of error
    }
}
?>
