<style>
    .width-cus {
        width: 16px;
    }
</style>
<h3>แจ้งลางาน <small>วันที่ <?php echo date('d-m-Y'); ?></small></h3>
<br>
<div class="col-12">
    <form action="" method="POST">
        <div class="d-flex justify-content-start">
            <div>ประเภทการลา</div>
            <div class="width-cus"></div>
            <div class="form-group">
                <select class="form-control" name="leave_type" id="leave_type" required>
                    <option value="casual" selected>ลางาน</option>
                    <option value="sick">ล่าป่วย</option>
                </select>
            </div>
        </div>
        <div id="date-picker-start-leave" class="md-form md-outline input-with-post-icon datepicker" inline="true">
            <label for="leave_date_start">ตั้งแต่วันที่</label>
            <input placeholder="Select date" type="date" id="leave_date_start" name="leave_date_start" class="form-control">
            <i class="fas fa-calendar input-prefix"></i>
        </div>
        <div id="date-picker-end-leave" class="md-form md-outline input-with-post-icon datepicker" inline="true">
            <label for="leave_date_end">ถึงวันที่</label>
            <input placeholder="Select date" type="date" id="leave_date_end" name="leave_date_end" class="form-control">
            <i class="fas fa-calendar input-prefix"></i>
        </div>
        <div class="form-group">
            <label for="reason">เหตุผลการลา</label>
            <textarea class="form-control" id="reason" name="leave_reason" rows="5" required></textarea>
        </div>
        <input type="hidden" name="submit_leave">
        <button type="submit" class="btn btn-success w-100">ส่งคำขอลางาน</button>
    </form>
</div>
<?php
if (isset($_POST["submit_leave"])) {
    $sql_leave = 'INSERT INTO leave_list (user_id, leave_type, reason, leave_date_start, leave_date_end) VALUES ("' . $_SESSION["user_id"] . '", "' . mysqli_real_escape_string($connect, $_POST["leave_type"]) . '", "' . mysqli_real_escape_string($connect, $_POST["leave_reason"]) . '", "' . mysqli_real_escape_string($connect, $_POST["leave_date_start"]) . '", "' . mysqli_real_escape_string($connect, $_POST["leave_date_end"]) . '")';
    $res_leave = mysqli_query($connect, $sql_leave);
    if ($res_leave) {
        $msg_title = 'สำเร็จ!';
        $msg = 'ส่งคำขอการลางานสำเร็จ';
        $msg_icon = 'success';
    } else {
        $msg_title = 'ผิดพลาด!';
        $msg = 'เกิดข้อผิดพลาดในการส่งคำขอการลางาน';
        $msg_icon = 'error';
    }
?>
    <script>
        Swal.fire(
            '<?php echo $msg_title ?>',
            '<?php echo $msg ?>',
            '<?php echo $msg_icon ?>'
        ).then((value) => {
            window.location.href = "?page=leavehistory";
        });
    </script>
<?php
}
