<?php
if (!isset($_SESSION["user_id"]) or !isset($_SESSION["username"]) or !isset($_SESSION["usergroup"])) {
?>
    <script langquage='javascript'>
        window.location = "?page=login";
    </script>
<?php
} else { ?>
    <h3>ประวัติการลางาน</h3>
    <br>
    <table class="table">
        <thead class="thead-dark">
            <tr align="center">
                <th scope="col">#</th>
                <th scope="col">ประเภทการลา</th>
                <th scope="col">ตั้งแต่</th>
                <th scope="col">จนถึง</th>
                <th scope="col">เหตุผล</th>
                <th scope="col">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query_leave_list = 'SELECT * FROM leave_list WHERE user_id = "' . $_SESSION["user_id"] . '"';
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
                        <td><?php echo leave_type($fetch_leave_list["leave_type"]) ?></td>
                        <td><?php echo date("d/m/Y", strtotime($fetch_leave_list["leave_date_start"])); ?></td>
                        <td><?php echo date("d/m/Y", strtotime($fetch_leave_list["leave_date_end"])); ?></td>
                        <td><?php echo $fetch_leave_list["reason"]; ?></td>
                        <td align="center">
                            <?php
                            if ($fetch_leave_list["leave_status"] == "accepted") {
                                echo '<button type="button" class="btn btn-success">อนุมัติ</button>';
                            } elseif ($fetch_leave_list["leave_status"] == "pending") {
                                echo '<button type="button" class="btn btn-info">รออนุมัติ</button>';
                            } else {
                                echo '<button type="button" class="btn btn-danger">ปฏิเสธ</button>';
                            }
                            ?>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
<?php
}
?>