<?php



// Kết nối cơ sở dữ liệu
$conn = mysqli_connect('localhost', 'root', '', 'AttendanceSystem');

// Kiểm tra kết nối
if (!$conn) {
    echo "<script>alert('Kết nối thất bại: " . mysqli_connect_error() . "');</script>";
    exit; // Dừng script nếu kết nối thất bại
}

// Lấy danh sách sinh viên
$queryStudents = "
    SELECT a.*
    FROM Account a
    INNER JOIN user_roles ur ON a.AccountID = ur.AccountID
    INNER JOIN roles r ON ur.RoleID = r.RoleID
    WHERE r.RoleName = 'Student';
";
$students = mysqli_query($conn, $queryStudents);

// Kiểm tra xem truy vấn sinh viên có thành công không
if (!$students) {
    echo "<script>alert('Lỗi truy vấn sinh viên: " . mysqli_error($conn) . "');</script>";
    exit;
}

// Kiểm tra nếu không có sinh viên nào
if (mysqli_num_rows($students) == 0) {
    echo "<script>alert('Không có sinh viên nào trong hệ thống.');</script>";
}

// Lấy thông tin sinh viên cần sửa
$editStudent = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    // Truy vấn sinh viên theo AccountID
    $queryEditStudent = "SELECT * FROM Account WHERE AccountID = $id";
    $result = mysqli_query($conn, $queryEditStudent);

    // Kiểm tra xem truy vấn có thành công không
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $editStudent = mysqli_fetch_assoc($result);
        } else {
            // Nếu không tìm thấy sinh viên, hiển thị thông báo lỗi
            echo "<script>alert('Không tìm thấy sinh viên với ID: $id');</script>";
        }
    } else {
        // Nếu có lỗi trong truy vấn, hiển thị thông báo lỗi
        echo "<script>alert('Lỗi truy vấn sinh viên: " . mysqli_error($conn) . "');</script>";
    }
}

// Đóng kết nối sau khi hoàn thành
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <!-- My CSS -->
    <link rel="stylesheet" href="student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">

    <title>Admin</title>
</head>

<body>


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Admin</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="home.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="studentmanagement.php">
                    <i class='bx bxs-shopping-bag-alt'></i>
                    <span class="text">User Management</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Class Management</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-message-dots'></i>
                    <span class="text">Attendance Management</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Team</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="https://i.ytimg.com/vi/JhVPJ2J0sz8/maxresdefault.jpg">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Student Management</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-4" style="width:300px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Search by name or email..."
                    onkeyup="searchTable()">
            </div>
            <div class="card position-relative">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <span>Student List</span>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="student-list-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th> <!-- Changed column header to "Name" -->
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Major</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($students) > 0) {
                                while ($row = mysqli_fetch_assoc($students)): ?>
                                    <tr>
                                        <td><?= $row['AccountID'] ?></td>
                                        <td><?= $row['FirstName'] . ' ' . $row['LastName'] ?></td>
                                        <!-- Combine LastName and FirstName -->
                                        <td><?= $row['Email'] ?></td>
                                        <td><?= $row['Phone'] ?></td>
                                        <td><?= $row['Major'] ?></td>
                                        <td><?= $row['Address'] ?></td>
                                        <td>
                                            <!-- Edit Button -->
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editStudentModal" data-id="<?= $row['AccountID'] ?>"
                                                data-firstname="<?= $row['FirstName'] ?>" data-lastname="<?= $row['LastName'] ?>"
                                                data-email="<?= $row['Email'] ?>" data-phone="<?= $row['Phone'] ?>"
                                                data-dob="<?= $row['DateOfBirth'] ?>" data-major="<?= $row['Major'] ?>"
                                                data-address="<?= $row['Address'] ?>">Edit</button>

                                            <!-- Delete Button -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteStudentModal"
                                                data-id="<?= $row['AccountID'] ?>">Delete</button>
                                        </td>
                                    </tr>
                            <?php endwhile;
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No students found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>


            <!-- Modal Thêm Sinh Viên -->
            <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"> <!-- Thêm lớp modal-dialog-centered -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="process.php?action=add_student">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dateOfBirth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="major" class="form-label">Major</label>
                                        <input type="text" class="form-control" id="major" name="major">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Student</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Sửa Sinh Viên -->
            <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="process.php?action=update">
                                <input type="hidden" id="editStudentId" name="id">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editFirstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="editFirstName" name="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editLastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="editLastName" name="lastName" required>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-9 mb-3">
                                        <label for="editEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="editEmail" name="email" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editPhone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="editPhone" name="phone">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editDateOfBirth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="editDateOfBirth" name="dateOfBirth">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editMajor" class="form-label">Major</label>
                                        <input type="text" class="form-control" id="editMajor" name="major">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="editAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="editAddress" name="address">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Student</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal Xóa Sinh Viên -->
            <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteStudentModalLabel">Delete Student</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this student?</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="process.php?action=delete">
                                <input type="hidden" id="deleteStudentId" name="id">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


    <script src="script.js"></script>
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("student-list-table");
            tr = table.getElementsByTagName("tr");

            // Kiểm tra nếu input trống
            if (filter === "") {
                for (i = 1; i < tr.length; i++) {
                    tr[i].style.display = "";
                }
                return;
            }

            // Duyệt qua từng hàng trong bảng
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none"; // Ẩn tất cả các hàng
                td = tr[i].getElementsByTagName("td");

                // Chỉ tìm kiếm trong cột Email và Name
                for (j = 0; j < td.length; j++) {
                    // Kiểm tra chỉ tìm kiếm trong cột Name và Email (giả sử cột 1 là Name và cột 2 là Email)
                    if (j == 1 || j == 2) {
                        if (td[j]) {
                            txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                tr[i].style.display = ""; // Hiển thị hàng nếu tìm thấy
                                break;
                            }
                        }
                    }
                }
            }
        }


        // Set data for Edit modal
        var editModal = document.getElementById('editStudentModal')
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var firstName = button.getAttribute('data-firstname');
            var lastName = button.getAttribute('data-lastname');
            var email = button.getAttribute('data-email');
            var phone = button.getAttribute('data-phone');
            var dob = button.getAttribute('data-dob');
            var major = button.getAttribute('data-major');
            var address = button.getAttribute('data-address');
            var id = button.getAttribute('data-id');

            var modalFirstName = editModal.querySelector('#editFirstName');
            var modalLastName = editModal.querySelector('#editLastName');
            var modalEmail = editModal.querySelector('#editEmail');
            var modalPhone = editModal.querySelector('#editPhone');
            var modalDob = editModal.querySelector('#editDateOfBirth');
            var modalMajor = editModal.querySelector('#editMajor');
            var modalAddress = editModal.querySelector('#editAddress');
            var modalId = editModal.querySelector('#editStudentId');

            modalFirstName.value = firstName;
            modalLastName.value = lastName;
            modalEmail.value = email;
            modalPhone.value = phone;
            modalDob.value = dob;
            modalMajor.value = major;
            modalAddress.value = address;
            modalId.value = id;
        });

        // Set data for Delete modal
        var deleteModal = document.getElementById('deleteStudentModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var modalId = deleteModal.querySelector('#deleteStudentId');
            modalId.value = id;
        });
    </script>
</body>

</html>