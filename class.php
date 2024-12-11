<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="student.css">
    <title>AdminHub</title>
    <style>
        /* Table Styles */
        .class-management-table table {
            border: none;
            width: 100%;
            margin-top: 20px;
        }

        .class-management-table th,
        .class-management-table td {
            text-align: center;
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        .class-management-table th {
            background-color: #007bff;
            color: white;
        }

        .class-management-table td {
            background-color: #fff;
        }

        .class-management-table tr:hover {
            background-color: #f1f1f1;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Modal styling */
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
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
                <img src="https://i.ytimg.com/vi/JhVPJ2J0sz8/maxresdefault.jpg" alt="profile-image">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>


            </div>

            <div class="head-title">
                <div class="left">
                    <h1>Class Management</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Class Management</a></li>
                    </ul>
                </div>
            </div>
            <!-- Filter Section -->
            <div class="filter-section">
                <label for="semesterSelect">Select Semester:</label>
                <select id="semesterSelect" class="form-select" onchange="filterClasses()">
                    <option value="">All Semesters</option>
                    <option value="Spring 2024">Spring 2024</option>
                    <option value="Fall 2024">Fall 2024</option>
                </select>

                <label for="subjectSelect">Select Subject:</label>
                <select id="subjectSelect" class="form-select" onchange="filterClasses()">
                    <option value="">All Subjects</option>
                    <option value="Mathematics">Mathematics</option>
                    <option value="Physics">Physics</option>
                </select>
            </div>

            
            <!-- Class Management Table -->
            <div class="class-management-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class ID</th>
                            <th>Class Code</th>
                            <th>Subject</th>
                            <th>Instructor</th>
                            <th>Start Date</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classTableBody"">
                        <tr>
                            <td>101</td>
                            <td><button class=" btn btn-link" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="loadClassDetails(101)">SE06302</button></td>
                        <td>Mathematics</td>
                        <td>John Doe</td>
                        <td>2024-01-15</td>
                        <td>Spring 2024</td>
                        <td>Active</td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal" onclick="loadClassDetails(101)">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </td>
                        </tr>
                        <tr>
                            <td>102</td>
                            <td><button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="loadClassDetails(102)">SE06303</button></td>
                            <td>Physics</td>
                            <td>Jane Smith</td>
                            <td>2024-02-01</td>
                            <td>Spring 2024</td>
                            <td>Active</td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal" onclick="loadClassDetails(102)">Edit</button>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- Modal for Students List -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Students in Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="studentList">
                        <!-- Student list will be dynamically loaded here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Class Details -->
    <div class="modal fade" id="classModal" tabindex="-1" aria-labelledby="classModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="classModalLabel">Class Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="classDetails">
                        <!-- Class details will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load students based on class code
        function loadStudents(classCode) {
            let studentList = {
                'SE06302': ['Alice', 'Bob', 'Charlie'],
                'SE06303': ['David', 'Eve', 'Frank']
            };

            let students = studentList[classCode] || [];
            let listHTML = '';
            students.forEach(student => {
                listHTML += `<li>${student}</li>`;
            });
            document.getElementById('studentList').innerHTML = listHTML;
        }

        // Load class details
        function loadClassDetails(classId) {
            let classDetails = {
                101: {
                    subject: 'Mathematics',
                    instructor: 'John Doe',
                    startDate: '2024-01-15',
                    semester: 'Spring 2024',
                    status: 'Active'
                },
                102: {
                    subject: 'Physics',
                    instructor: 'Jane Smith',
                    startDate: '2024-02-01',
                    semester: 'Spring 2024',
                    status: 'Active'
                }
            };

            let details = classDetails[classId];
            let detailsHTML = `
                <p><strong>Subject:</strong> ${details.subject}</p>
                <p><strong>Instructor:</strong> ${details.instructor}</p>
                <p><strong>Start Date:</strong> ${details.startDate}</p>
                <p><strong>Semester:</strong> ${details.semester}</p>
                <p><strong>Status:</strong> ${details.status}</p>
            `;
            document.getElementById('classDetails').innerHTML = detailsHTML;
        }
        // Sample class data
        const classes = [{
                id: 101,
                classCode: 'SE06302',
                subject: 'Mathematics',
                instructor: 'John Doe',
                startDate: '2024-01-15',
                semester: 'Spring 2024',
                status: 'Active'
            },
            {
                id: 102,
                classCode: 'SE06303',
                subject: 'Physics',
                instructor: 'Jane Smith',
                startDate: '2024-02-01',
                semester: 'Spring 2024',
                status: 'Active'
            },
            {
                id: 103,
                classCode: 'SE06304',
                subject: 'Mathematics',
                instructor: 'Alice Johnson',
                startDate: '2024-08-15',
                semester: 'Fall 2024',
                status: 'Active'
            },
            {
                id: 104,
                classCode: 'SE06305',
                subject: 'Physics',
                instructor: 'Bob Brown',
                startDate: '2024-09-01',
                semester: 'Fall 2024',
                status: 'Inactive'
            },
        ];

        // Function to filter and display classes based on selected filters
        function filterClasses() {
            const semester = document.getElementById('semesterSelect').value;
            const subject = document.getElementById('subjectSelect').value;

            const filteredClasses = classes.filter(classItem => {
                const matchesSemester = !semester || classItem.semester === semester;
                const matchesSubject = !subject || classItem.subject === subject;
                return matchesSemester && matchesSubject;
            });

            displayClasses(filteredClasses);
        }

        // Function to display classes in the table
        function displayClasses(classList) {
            const tableBody = document.getElementById('classTableBody');
            tableBody.innerHTML = ''; // Clear previous rows

            classList.forEach(classItem => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${classItem.id}</td>
                    <td>
                    <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#studentModal" onclick="loadStudents('${classItem.classCode}')">${classItem.classCode}</button></td>
                    <td>${classItem.subject}</td>
                    <td>${classItem.instructor}</td>
                    <td>${classItem.startDate}</td>
                    <td>${classItem.semester}</td>
                    <td>${classItem.status}</td>
                    <td> <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal" onclick="loadClassDetails(101)">Edit</button>
                            <button class="btn btn-danger">Delete</button></td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Function to load students in a specific class
        function loadStudents(classCode) {
            const studentList = {
                'SE06302': ['Alice', 'Bob', 'Charlie'],
                'SE06303': ['David', 'Eve', 'Frank'],
                'SE06304': ['George', 'Hannah', 'Ivy'],
                'SE06305': ['Jack', 'Karen', 'Liam'],
            };

            const students = studentList[classCode] || [];
            let listHTML = '';
            students.forEach(student => {
                listHTML += `<li>${student}</li>`;
            });

            document.getElementById('studentList').innerHTML = listHTML;
        }

        filterClasses();
    </script>

</body>

</html>