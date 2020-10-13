<?php
if (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"]) or !isset($_SESSION["usergroup"])) {
?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
<?php
} else {
    $query_time = 'SELECT * FROM work_io WHERE user_id = "' . $_SESSION["user_id"] . '" AND workdate = "' . date("Y-m-d") . '"';
    $result_time = mysqli_query($connect, $query_time);
    $fetch_time = mysqli_fetch_assoc($result_time);
?>
    <h3>ลงเวลาเข้า-ออกงานประจำวันที่ <?php echo date('d-m-Y'); ?></h3>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="id">รหัสพนักงาน</label>
                <input type="text" class="form-control" name="id" id="id" value="<?php echo $fetch_user['user_id']; ?>" readonly>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="in-working">เวลาเข้างาน</label>
                <input type="text" class="form-control" name="in-working" id="in-working" <?php
                                                                                            if (mysqli_num_rows($result_time) == 1) {
                                                                                                if ($fetch_time["type"] == "work") {
                                                                                                    echo 'value="' . $fetch_time['workin'] . '"';
                                                                                                } else {
                                                                                                    echo 'value="ลางาน"';
                                                                                                }
                                                                                            } else {
                                                                                                echo 'value="ยังไม่ได้ลงเวลา"';
                                                                                            }
                                                                                            ?> readonly>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="out-working">เวลาออกงาน</label>
                <input type="text" class="form-control" name="out-working" id="out-working" <?php
                                                                                            if (isset($fetch_time['type'])) {
                                                                                                if ($fetch_time["type"] == "work") {
                                                                                                    if ($fetch_time['workout'] != "") {
                                                                                                        echo 'value="' . $fetch_time['workout'] . '"';
                                                                                                    } else {
                                                                                                        echo 'value="ยังไม่ได้ลงเวลา"';
                                                                                                    }
                                                                                                } else {
                                                                                                    echo 'value="ลางาน"';
                                                                                                }
                                                                                            } else {
                                                                                                echo 'value="ยังไม่ได้ลงเวลา"';
                                                                                            }
                                                                                            ?> readonly>
            </div>
        </div>
        <div class="col-sm-3">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="save-working">ลงเวลา</label>
                    <button type="submit" class="form-control btn btn-outline-success" name="save-working" id="save-working">บันทึกเวลา</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">วันที่</th>
                <th scope="col">เวลาเข้างาน</th>
                <th scope="col">เวลาออกงาน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query_time = 'SELECT * FROM work_io WHERE user_id = "' . $_SESSION["user_id"] . '" ORDER BY io_id DESC';
            $result_time = mysqli_query($connect, $query_time);
            if (mysqli_num_rows($result_time) == 0) {
            ?>
                <td colspan="4" align="center">ไม่พบข้อมูล</td>
                <?php
            } else {
                while ($fetch_timelist = mysqli_fetch_assoc($result_time)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $fetch_timelist["io_id"]; ?></th>
                        <td><?php echo date("d/m/Y", strtotime($fetch_timelist["workdate"])); ?></td>
                        <td><?php if ($fetch_timelist["workin"] != "") {
                                echo $fetch_timelist["workin"];
                            } else {
                                echo 'ลางาน';
                            } ?></td>
                        <td><?php if ($fetch_timelist["workout"] != "") {
                                echo $fetch_timelist["workout"];
                            } else {
                                echo 'ลางาน';
                            } ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_POST["save-working"])) {
        if (isset($fetch_time["type"])) {
            if ($fetch_time["type"] === "work") {
                if (isset($fetch_time["workin"]) && !(isset($fetch_time["workout"]))) {
                    $query_save = 'UPDATE work_io SET workout = "' . date('H:i:s') . '" WHERE user_id = "' . $fetch_user["user_id"] . '" AND workdate = "' . date('Y-m-d') . '"';
                }
                if (isset($query_save)) {
                    $result_save = mysqli_query($connect, $query_save);
                    if ($result_save) {
                        $msg_alert = 'ลงเวลาสำเร็จ';
                        $msg = 'ทำการลงเวลาสำเร็จ';
                        $msg_icon = 'success';
                    } else {
                        $msg_alert = 'เกิดข้อผิดพลาด';
                        $msg = 'เกิดข้อผิดพลาดในการลงเวลา';
                        $msg_icon = 'error';
                    }
                } else {
                    $msg_alert = 'เกิดข้อผิดพลาด';
                    $msg = 'ลงเวลาเข้า-ออกงานครบแล้ว';
                    $msg_icon = 'error';
                }
            } else {
                $msg_alert = 'เกิดข้อผิดพลาด';
                $msg = 'วันนี้คุณได้ทำการลางานแล้ว ไม่สามารถลงเวลาเข้า-ออกงานได้';
                $msg_icon = 'error';
            }
        } else {
            $query_save = 'INSERT INTO work_io (user_id, workin) VALUES ("' . $_SESSION["user_id"] . '","' . date('H:i:s') . '")';
            $result_save = mysqli_query($connect, $query_save);
            if ($result_save) {
                $msg_alert = 'ลงเวลาสำเร็จ';
                $msg = 'ทำการลงเวลาสำเร็จ';
                $msg_icon = 'success';
            } else {
                $msg_alert = 'เกิดข้อผิดพลาด';
                $msg = 'เกิดข้อผิดพลาดในการลงเวลา';
                $msg_icon = 'error';
            }
        }
    ?>
        <script>
            Swal.fire(
                '<?php echo $msg_alert ?>',
                '<?php echo $msg ?>',
                '<?php echo $msg_icon ?>'
            ).then((value) => {
                window.location.href = window.location.href;
            });
        </script>
<?php
    }
}
?>