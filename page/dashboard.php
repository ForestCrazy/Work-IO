<?php
if (!isset($_SESSION["username"]) or !isset($_SESSION["usergroup"])) {
?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
<?php
} else {
    $query_user = 'SELECT * FROM account WHERE username = "' . $_SESSION["username"] . '"';
    $result_user = mysqli_query($connect, $query_user);
    $fetch_user = mysqli_fetch_assoc($result_user);

    $query_time = 'SELECT * FROM work_io WHERE m_id = "' . $fetch_user["id"] . '" ORDER BY id DESC';
    $result_time = mysqli_query($connect, $query_time);
    $fetch_time = mysqli_fetch_assoc($result_time);
?>
    <h3>ลงเวลาเข้า-ออกงานประจำวันที่ <?php echo date('d-m-Y'); ?></h3>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="id">รหัสพนักงาน</label>
                <input type="text" class="form-control" name="id" id="id" value="<?php echo $fetch_user['id']; ?>" readonly>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="in-working">เวลาเข้างาน</label>
                <input type="text" class="form-control" name="in-working" id="in-working" 
                <?php
                if (isset($fetch_time['workin']) && isset($fetch_time["type"])) {
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
                <input type="text" class="form-control" name="out-working" id="out-working" 
                <?php
                if (isset($fetch_time['workout']) && isset($fetch_time["type"])) {
                    if ($fetch_time["type"] == "work") {
                        echo 'value="' . $fetch_time['workout'] . '"';
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
            $result_time = mysqli_query($connect, $query_time);
            if (mysqli_num_rows($result_time) == 0) {
            ?>
                <td colspan="4" align="center">ไม่พบข้อมูล</td>
                <?php
            } else {
                while ($fetch_timelist = mysqli_fetch_assoc($result_time)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $fetch_timelist["id"]; ?></th>
                        <td><?php echo date("d/m/Y", strtotime($fetch_timelist["workdate"])); ?></td>
                        <td><?php echo $fetch_timelist["workin"]; ?></td>
                        <td><?php echo $fetch_timelist["workout"]; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <?php
    if (isset($_POST["save-working"])) {
        if (!isset($fetch_time['workout']) && isset($fetch_time['workin'])) {
            $query_save = 'UPDATE work_io SET workout = "' . date('H:i:s') . '" WHERE m_id = "' . $fetch_user["id"] . '" AND workdate = "' . date('Y-m-d') . '"';
        } else if (!isset($fetch_time['workin'])) {
            $query_save = 'INSERT INTO work_io (m_id, workin) VALUES ("' . $fetch_user["id"] . '","' . date('H:i:s') . '")';
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
        } ?>
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