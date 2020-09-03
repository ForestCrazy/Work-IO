<?php
if (isset($_SESSION["username"]) or isset($_SESSION["usergroup"])) {
    ?>
    <script langquage='javascript'>
        window.location="?page=dashboard";
    </script>
    <?php
} else {
?>
    <div class="col-12">
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">รหัสพนักงาน</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="ชื่อผู้ใช้" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required>
            </div>
            <button type="submit" name="submit_login" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
    <?php
    if (isset($_POST["submit_login"])) {
        $username = mysqli_real_escape_string($connect, $_POST["username"]);
        $password = mysqli_real_escape_string($connect, hash('sha256', $_POST["password"]));
        $sql_login = 'SELECT * FROM account WHERE username = "' . $username . '"';
        $res_login = mysqli_query($connect, $sql_login);
        $fetch_login = mysqli_fetch_assoc($res_login);
        if ($res_login) {
            if (mysqli_num_rows($res_login) == 1) {
                if ($fetch_login["password"] == $password) {
                    $msg_alert = 'ล็อกอินสำเร็จ';
                    $msg = 'ทำการล็อกอินสำเร็จ';
                    $msg_icon = 'success';

                    $_SESSION["username"] = $username;
                    $_SESSION["usergroup"] = $fetch_login["group"];
                } else {
                    $msg_alert = 'ล็อกอินไม่สำเร็จ';
                    $msg = 'รหัสผ่านไม่ถูกต้อง';
                    $msg_icon = 'error';
                }
            } else {
                $msg_alert = 'ล็อกอินไม่สำเร็จ';
                $msg = 'ไม่พบชื่อผู้ใช้นี้ในระบบ';
                $msg_icon = 'error';
            }
        } else {
            $msg_alert = 'ล็อกอินไม่สำเร็จ';
            $msg = 'เกิดข้อผิดพลาดในการล็อกอิน';
            $msg_icon = 'error';
        }
    ?>
        <script>
            Swal.fire(
                '<?php echo $msg_alert ?>',
                '<?php echo $msg ?>',
                '<?php echo $msg_icon ?>'
            ).then((value) => {
                window.location.href = "?page=dashboard";
            });
        </script>
<?php
    }
}
?>