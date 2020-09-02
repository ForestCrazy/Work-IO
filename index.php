<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I/O Working</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>
    <div class="container">
        <h1 class="text-center">Work IO ระบบบันทึกเวลาทำงาน</h1>
        <br>
        <div class="row">
            <div class="col-sm-3">
                <div class="col-12">
                    <img src="data/employee.png" alt="" class="img-fluid h-100 w-100">
                    <span class="badge badge-secondary">หัวหน้าฝ่ายไอที</span>
                </div>
                <br>
                <div>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="">แดชบอร์ด</a></li>
                        <li class="list-group-item"><a href="">ลางาน</a></li>
                    </ul>
                </div>
            </div>
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
                } elseif ($_GET['page'] == "login") {
                    include_once __DIR__ . '/page/login.php';
                } elseif ($_GET['page'] == "logout") {
                    include_once __DIR__ . '/page/logout.php';
                } else {
                    echo '<br>';
                    echo '<div class="container"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> ไม่พบหน้าที่ท่านร้องขอ กำลังพาท่านกลับไปหน้าหลัก...</div></div>';
                    echo '<meta http-equiv="refresh" content="3;URL=?page=dashboard"';
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