<?php
if (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"]) or !isset($_SESSION["usergroup"])) {
?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
    <?php
} else {
    if ($_SESSION["usergroup"] == "admin") {
        // Function to get all the dates in given range 
        function getDatesFromRange($start, $end, $format = 'Y-m-d')
        {

            // Declare an empty array 
            $array = array();

            // Variable that store the date interval 
            // of period 1 day 
            $interval = new DateInterval('P1D');

            $realEnd = new DateTime($end);
            $realEnd->add($interval);

            $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

            // Use loop to store date into array 
            foreach ($period as $date) {
                $array[] = $date->format($format);
            }

            // Return the array elements 
            return $array;
        }
    ?>
        <h3>จัดการการลางาน</h3>
        <br>
        <table class="table">
            <thead class="thead-dark">
                <tr align="center">
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">ประเภทการลา</th>
                    <th scope="col">ตั้งแต่</th>
                    <th scope="col">จนถึง</th>
                    <th scope="col">เหตุผล</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="POST">
                    <?php
                    $query_leave_list = 'SELECT * FROM leave_list LEFT JOIN (SELECT user_id, firstname, lastname FROM account) AS account ON leave_list.user_id = account.user_id WHERE leave_status = "pending"';
                    $result_leave_list = mysqli_query($connect, $query_leave_list);
                    if (mysqli_num_rows($result_leave_list) == 0) {
                    ?>
                        <td colspan="7" align="center">ไม่พบข้อมูล</td>
                        <?php
                    } else {
                        while ($fetch_leave_list = mysqli_fetch_assoc($result_leave_list)) {
                        ?>
                            <tr>
                                <th scope="row"><?php echo $fetch_leave_list["leave_id"]; ?></th>
                                <td><?php echo $fetch_leave_list["firstname"] . " " . $fetch_leave_list["lastname"]; ?></td>
                                <td><?php echo leave_type($fetch_leave_list["leave_type"]) ?></td>
                                <td><?php echo date("d/m/Y", strtotime($fetch_leave_list["leave_date_start"])); ?></td>
                                <td><?php echo date("d/m/Y", strtotime($fetch_leave_list["leave_date_end"])); ?></td>
                                <td><?php echo $fetch_leave_list["reason"]; ?></td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <button type="submit" class="btn btn-success" name="leave_accept" value="<?php echo $fetch_leave_list["leave_id"]; ?>">อนุมัติ</button>
                                        &emsp;
                                        <button type="submit" class="btn btn-danger" name="leave_reject" value="<?php echo $fetch_leave_list["leave_id"]; ?>">ปฏิเสธ</button>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </form>
            </tbody>
        </table>
        <?php
        if (isset($_POST["leave_accept"]) || isset($_POST["leave_reject"])) {
            if (isset($_POST["leave_accept"])) {
                $sql_update_leave = 'UPDATE leave_list SET leave_status = "accepted" WHERE leave_id = "' . mysqli_real_escape_string($connect, $_POST["leave_accept"]) . '"';
                $res_update_leave = mysqli_query($connect, $sql_update_leave);
                if ($res_update_leave) {
                    $sql_get_info = 'SELECT user_id, leave_date_start, leave_date_end FROM leave_list WHERE leave_id = "' . mysqli_real_escape_string($connect, $_POST["leave_accept"]) . '"';
                    $res_get_info = mysqli_query($connect, $sql_get_info);
                    $fetch_get_info = mysqli_fetch_assoc($res_get_info);
                    $datePeriod = getDatesFromRange($fetch_get_info["leave_date_start"], $fetch_get_info["leave_date_end"]);
                    foreach ($datePeriod as $date) {
                        $workdate_leave = $date;
                        $sql_insert_workio = 'INSERT INTO work_io (user_id, workdate, type) VALUES ("' . $fetch_get_info["user_id"] . '", "' . $workdate_leave . '", "leave")';
                        $res_insert_workio = mysqli_query($connect, $sql_insert_workio);
                    }
                    if ($res_insert_workio) {
                        $msg_title = 'สำเร็จ';
                        $msg = 'ทำการอนุมัติการลาสำเร็จ';
                        $msg_icon = 'success';
                    } else {
                        $msg_title = 'ผิดพลาด';
                        $msg = 'เกิดข้อผิดพลาดในการกำหนดเวลาการลา #ErrLeaveManage01';
                        $msg_icon = 'error';
                    }
                } else {
                    $msg_title = 'ผิดพลาด';
                    $msg = 'เกิดข้อผิดพลาดในการอัพเดทสถานะการลา #ErrLeaveManage02';
                    $msg_icon = 'error';
                }
            } elseif (isset($_POST["leave_reject"])) {
                $sql_update_leave = 'UPDATE leave_list SET leave_status = "rejected" WHERE leave_id = "' . mysqli_real_escape_string($connect, $_POST["leave_reject"]) . '"';
                $res_update_leave = mysqli_query($connect, $sql_update_leave);
                if ($res_update_leave) {
                    $msg_title = 'สำเร็จ';
                    $msg = 'ทำการปฏิเสธการขอลาสำเร็จ';
                    $msg_icon = 'success';
                } else {
                    $msg_title = 'ผิดพลาด';
                    $msg = 'เกิดข้อผิดพลาดในการปฏิเสธการขอลา #ErrLeaveManage03';
                    $msg_icon = 'error';
                }
            } else {
                $msg_title = 'ผิดพลาด';
                $msg = ' #ErrLeaveManage04';
                $msg_icon = 'error';
            }
        ?>
            <script>
                Swal.fire(
                    '<?php echo $msg_title ?>',
                    '<?php echo $msg ?>',
                    '<?php echo $msg_icon ?>'
                ).then((value) => {
                    window.location.href = "?page=manageleave";
                });
            </script>
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