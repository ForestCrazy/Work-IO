<?php
if ((!isset($_SESSION["user_id"]) or !isset($_SESSION["username"]) or !isset($_SESSION["usergroup"]))) {
?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
    <?php
} else {
    if ($_SESSION["usergroup"] == "admin") {
        if (isset($_GET["action"])) {
            if ($_GET["action"] == "new") {
    ?>
    <h3>เพิ่มบัญชี </h3>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="Password">Password</label>
                            <input type="text" id="Password" name="password" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="FirstName">FirstName</label>
                            <input type="text" id="FirstName" name="firstname" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="LastName">LastName</label>
                            <input type="text" id="LastName" name="lastname" class="form-control">
                        </div>
                        <div class="col-sm-12 form-group">
                            <label for="Group">Group</label>
                            <select class="form-control" name="group">
                                <option value="member">member</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <input type="hidden" name="submit_create_user">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success w-100">เพิ่มบัญชีผู้ใช้</button>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST["submit_create_user"])) {
                    $sql_insert_user = 'INSERT INTO account (`username`, `password`, `firstname`, `lastname`, `group`) VALUES ("' . mysqli_real_escape_string($connect, $_POST["username"]) . '", "' . mysqli_real_escape_string($connect, hash('sha256', $_POST["password"])) . '", "' . mysqli_real_escape_string($connect, $_POST["firstname"]) . '", "' . mysqli_real_escape_string($connect, $_POST["lastname"]) . '", "' . mysqli_real_escape_string($connect, $_POST["group"]) . '")';
                    $res_insert_user = mysqli_query($connect, $sql_insert_user);
                    if ($res_insert_user) {
                        $msg_title = 'สำเร็จ';
                        $msg = 'เพิ่มบัญชีผู้ใช้สำเร็จ';
                        $msg_icon = 'success';
                    } else {
                        $msg_title = 'ผิดพลาด';
                        $msg = $sql_insert_user;
                        $msg_icon = 'error';
                    }
                ?>
                    <script>
                        Swal.fire(
                            '<?php echo $msg_title ?>',
                            '<?php echo $msg ?>',
                            '<?php echo $msg_icon ?>'
                        ).then((value) => {
                            window.location.href = window.location;
                        });
                    </script>
                <?php
                }
            } else {
                $sql_user_info = 'SELECT * FROM account WHERE user_id = "' . mysqli_real_escape_string($connect, $_GET["action"]) . '"';
                $res_user_info = mysqli_query($connect, $sql_user_info);
                $fetch_user_info = mysqli_fetch_assoc($res_user_info);
                ?>
                <h3>แก้ไขข้อมูลบัญชี </h3>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo $fetch_user_info['username']; ?>" class="form-control" disabled>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="FirstName">FirstName</label>
                            <input type="text" id="FirstName" name="firstname" value="<?php echo $fetch_user_info["firstname"]; ?>" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="LastName">LastName</label>
                            <input type="text" id="LastName" name="lastname" value="<?php echo $fetch_user_info["lastname"]; ?>" class="form-control">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="Group">Group</label>
                            <select class="form-control" name="group">
                                <option value="member" <?php if ($fetch_user_info["group"] == "member") {
                                                            echo 'selected';
                                                        } ?>>member</option>
                                <option value="admin" <?php if ($fetch_user_info["group"] == "admin") {
                                                            echo 'selected';
                                                        } ?>>admin</option>
                            </select>
                        </div>
                        <input type="hidden" name="submit_create_user">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success w-100">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST["submit_create_user"])) {
                    $sql_insert_user = 'UPDATE account SET `firstname` = "' . mysqli_real_escape_string($connect, $_POST["firstname"]) . '", `lastname` = "' . mysqli_real_escape_string($connect, $_POST["lastname"]) . '", `group` = "' . mysqli_real_escape_string($connect, $_POST["group"]) . '" WHERE user_id = "' . $fetch_user_info['user_id'] . '"';
                    $res_insert_user = mysqli_query($connect, $sql_insert_user);
                    if ($res_insert_user) {
                        $msg_title = 'สำเร็จ';
                        $msg = 'เพิ่มบัญชีผู้ใช้สำเร็จ';
                        $msg_icon = 'success';
                    } else {
                        $msg_title = 'ผิดพลาด';
                        $msg = $sql_insert_user;
                        $msg_icon = 'error';
                    }
                ?>
                    <script>
                        Swal.fire(
                            '<?php echo $msg_title ?>',
                            '<?php echo $msg ?>',
                            '<?php echo $msg_icon ?>'
                        ).then((value) => {
                            window.location.href = window.location;
                        });
                    </script>
            <?php
                }
            }
        } else {
            ?>
            <h3>จัดการบัญชี</h3>
            <div class="d-flex justify-content-end">
                <a href="?page=manageuser&action=new"><button type="button" class="btn btn-success">+</button></a>
            </div>
            <br>
            <table class="table">
                <thead class="thead-dark">
                    <tr align="center">
                        <th scope="col">#</th>
                        <th scope="col">ชื่อผู้ใช้</th>
                        <th scope="col">ชื่อ - สกุล</th>
                        <th scope="col">สถานะ</th>
                    </tr>
                </thead>
                <tbody align="center">
                    <?php
                    $query_user_list = 'SELECT * FROM account';
                    $result_user_list = mysqli_query($connect, $query_user_list);
                    if (mysqli_num_rows($result_user_list) == 0) {
                    ?>
                        <td colspan="7" align="center">ไม่พบข้อมูล</td>
                        <?php
                    } else {
                        while ($fetch_user_list = mysqli_fetch_assoc($result_user_list)) {
                        ?>
                            <tr>
                                <th scope="row"><a href="?page=manageuser&action=<?php echo $fetch_user_list["user_id"]; ?>"><?php echo $fetch_user_list["user_id"]; ?></th></a>
                                <td><a href="?page=manageuser&action=<?php echo $fetch_user_list["user_id"]; ?>"><?php echo $fetch_user_list["username"]; ?></td></a>
                                <td><?php echo $fetch_user_list["firstname"] . " " . $fetch_user_list["lastname"]; ?></td>
                                <td><?php echo $fetch_user_list["group"]; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        <?php
        }
    } else {
        ?>
        <script langquage='javascript'>
            window.location = "?page=dashboard";
        </script>
<?php
    }
}
?>