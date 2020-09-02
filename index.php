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
        <h1 class="text-center">Work I-O ระบบบันทึกเวลาทำงาน</h1>
        <div class="row">
            <div class="col-sm-3">
                img
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
                } elseif ($_GET['page'] == "announce") {
                    include_once __DIR__ . '/page/announce.php';
                } elseif ($_GET['page'] == "task") {
                    include_once __DIR__ . '/page/task.php';
                } elseif ($_GET['page'] == "leave") {
                    include_once __DIR__ . '/page/leave.php';
                } elseif ($_GET['page'] == "note") {
                    include_once __DIR__ . '/page/note.php';
                } elseif ($_GET['page'] == "result") {
                    include_once __DIR__ . '/page/result.php';
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