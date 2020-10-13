<?php
require('system/connect.php');
require('system/func.php');
session_start();
if ((isset($_SESSION["user_id"])) && (isset($_SESSION["username"]))) {
    $query_user = 'SELECT * FROM account WHERE username = "' . $_SESSION["username"] . '" AND user_id = "' . $_SESSION["user_id"] . '"';
    $result_user = mysqli_query($connect, $query_user);
    if (mysqli_num_rows($result_user) == 1) {
        $fetch_user = mysqli_fetch_assoc($result_user);
    } else {
        session_destroy();
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I/O Working</title>
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.14.0/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center"><b>Work IO ระบบบันทึกเวลาทำงาน</b></h1>
        <br>
        <div class="row d-flex justify-content-center">
            <?php
            if (isset($_SESSION["usergroup"])) {
            ?>
                <div class="col-sm-3">
                    <div class="col-12">
                        <img src="data/employee.png" alt="" class="img-fluid h-100 w-100">
                    </div>
                    <br>
                    <div>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="?page=dashboard">แดชบอร์ด</a></li>
                            <li class="list-group-item"><a href="?page=leave">ลางาน</a></li>
                            <li class="list-group-item"><a href="?page=leavehistory">ประวัติการลางาน</a></li>
                            <?php
                            if ($_SESSION["usergroup"] == "admin") {
                            ?>
                                <li class="list-group-item"><a href="?page=manageleave">จัดการการลางาน</a></li>
                                <li class="list-group-item"><a href="?page=manageuser">จัดการบัญชี</a></li>
                            <?php
                            }
                            ?>
                            <li class="list-group-item"><a href="?page=logout">ออกจากระบบ</a></li>
                        </ul>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="col-sm-9">
                <?php
                if (!$_GET) {
                    $_GET["page"] = 'dashboard';
                }
                if (!$_GET["page"]) {
                    $_GET["page"] = "dashboard";
                }
                if ($_GET["page"] == "dashboard") {
                    include_once __DIR__ . '/page/dashboard.php';
                } elseif ($_GET['page'] == "leave") {
                    include_once __DIR__ . '/page/leave.php';
                } elseif ($_GET['page'] == "leavehistory") {
                    include_once __DIR__ . '/page/leavehistory.php';
                } elseif ($_GET['page'] == "manageleave") {
                    include_once __DIR__ . '/page/manageleave.php';
                } elseif ($_GET['page'] == "manageuser") {
                    include_once __DIR__ . '/page/manageuser.php';
                } elseif ($_GET['page'] == "login") {
                    include_once __DIR__ . '/page/login.php';
                } elseif ($_GET['page'] == "logout") {
                    if (isset($_SESSION["user_id"]) || isset($_SESSION["username"]) || isset($_SESSION["usergroup"])) {
                        session_destroy();
                        echo '<meta http-equiv="refresh" content="0;URL=?page=login">';
                    } else {
                        echo '<br>';
                        echo '<div class="container"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> ไม่พบหน้าที่ท่านร้องขอ กำลังพาท่านกลับไปหน้าหลัก...</div></div>';
                        echo '<meta http-equiv="refresh" content="3;URL=?page=dashboard">';
                    }
                } else {
                    echo '<br>';
                    echo '<div class="container"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> ไม่พบหน้าที่ท่านร้องขอ กำลังพาท่านกลับไปหน้าหลัก...</div></div>';
                    echo '<meta http-equiv="refresh" content="3;URL=?page=dashboard">';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>