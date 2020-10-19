<?php
$sql_where_array = array();
$query_io_list = 'SELECT * FROM work_io LEFT JOIN (SELECT user_id, username FROM account) AS account ON account.user_id = work_io.user_id';
if (isset($_GET["username"])) {
    if ($_GET["username"] != "") {
        $sql_search_user = 'SELECT user_id FROM account WHERE username = "' . mysqli_real_escape_string($connect, $_GET["username"]) . '"';
        $res_search_user = mysqli_query($connect, $sql_search_user);
        if ($res_search_user) {
            if (mysqli_num_rows($res_search_user) >= 1) {
                array_push($sql_where_array, " work_io.user_id = '" . mysqli_fetch_assoc($res_search_user)["user_id"] . "' ");
            } else {
                array_push($sql_where_array, " work_io.user_id = " . "''");
            }
        }
    }
}
if (isset($_GET["datefrom"])) {
    if ($_GET["datefrom"] != "") {
        array_push($sql_where_array, " work_io.workdate >= '" . mysqli_real_escape_string($connect, $_GET["datefrom"]) . "' ");
    }
}

if (isset($_GET["dateend"])) {
    if ($_GET["dateend"] != "") {
        array_push($sql_where_array, " work_io.workdate <= '" . mysqli_real_escape_string($connect, $_GET["dateend"]) . "' ");
    }
}

if (count($sql_where_array) > 0) {
    $query_io_list = $query_io_list . " WHERE ";
    $loop_round = 0;
    foreach ($sql_where_array as &$cmd) {
        $loop_round++;
        $query_io_list = $query_io_list . $cmd;
        if ($loop_round != count($sql_where_array)) {
            $query_io_list = $query_io_list . "AND";
        }
    }
    unset($value);
}
if (isset($_GET["action"])) {
    $sql_io_info = 'SELECT * FROM work_io LEFT JOIN (SELECT user_id, username FROM account) AS account ON account.user_id = work_io.user_id WHERE work_io.io_id = "' . mysqli_real_escape_string($connect, $_GET["action"]) . '"';
    $res_io_info = mysqli_query($connect, $sql_io_info);
    $fetch_io_info = mysqli_fetch_assoc($res_io_info);
?>
    <h3>แก้ไขข้อมูลการ เข้า - ออก งาน </h3>
    <form action="" method="POST">
        <div class="row">
            <div class="col-sm-6 form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $fetch_io_info['username']; ?>" class="form-control" disabled readonly>
            </div>
            <div class="col-sm-6 form-group">
                <label for="workdate">ข้อมูลของวันที่</label>
                <input type="birthday" id="workdate" name="workdate" value="<?php echo date("d-m-Y", strtotime($fetch_io_info["workdate"])); ?>" class="form-control" disabled readonly>
            </div>
            <div class="col-sm-6 form-group">
                <label for="workin">Work In</label>
                <input type="time" id="workin" name="workin" value="<?php echo $fetch_io_info["workin"]; ?>" class="form-control" oninput='document.getElementById("workout").min = this.value;'>
            </div>
            <div class="col-sm-6 form-group">
                <label for="workout">Work Out</label>
                <input type="time" id="workout" name="workout" value="<?php echo $fetch_io_info["workout"]; ?>" class="form-control" oninput='document.getElementById("workin").max = this.value;'>
            </div>
            <div class="col-12 form-group">
                            <label for="type">Type</label>
                            <select class="form-control" name="type">
                                <option value="work" <?php if ($fetch_io_info["type"] == "work") {
                                                            echo 'selected';
                                                        } ?>>work</option>
                                <option value="leave" <?php if ($fetch_io_info["type"] == "leave") {
                                                            echo 'selected';
                                                        } ?>>leave</option>
                            </select>
                        </div>
            <input type="hidden" name="submit_edit_io">
            <div class="col-12">
                <button type="submit" class="btn btn-success w-100">บันทึกข้อมูล</button>
            </div>
        </div>
    </form>
    <?php
    if (isset($_POST["submit_edit_io"])) {
        $sql_update_io = 'UPDATE work_io SET `workin` = "' . mysqli_real_escape_string($connect, $_POST["workin"]) . '", `workout` = "' . mysqli_real_escape_string($connect, $_POST["workout"]) . '", `type` = "' . mysqli_real_escape_string($connect, $_POST["type"]) . '" WHERE io_id = "' . $fetch_io_info['io_id'] . '" AND user_id = "' . $fetch_io_info['user_id'] . '"';
        $res_update_io = mysqli_query($connect, $sql_update_io);
        if ($res_update_io) {
            $msg_title = 'สำเร็จ';
            $msg = 'แก้ไขข้อมูลสำเร็จ';
            $msg_icon = 'success';
        } else {
            $msg_title = 'ผิดพลาด';
            $msg = 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล';
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
    ?>
    <div class="d-flex justify-content-between">
        <h3>ประวัติการลงชื่อ เข้า-ออก งานทั้งหมด </h3>
        <div></div>
        <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsesearchoption" aria-expanded="false" aria-controls="collapsesearchoption">
                คัดกรอง
            </button>
        </p>
    </div>
    <div class="collapse" id="collapsesearchoption">
        <form action="" method="GET">
            <input type="hidden" name="page" value="iolist">
            <div class="col-12 form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" value="<?php if (isset($_GET["username"])) { echo $_GET["username"]; } ?>" class="form-control">
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="datefrom">ตั้งแต่วันที่</label>
                        <input type="date" id="datefrom" name="datefrom" value="<?php if (isset($_GET["datefrom"])) { echo $_GET["datefrom"]; } ?>" class="form-control">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="dateend">จนถึงวันที่</label>
                        <input type="date" id="dateend" name="dateend" value="<?php if (isset($_GET["dateend"])) { echo $_GET["dateend"]; } ?>" class="form-control">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success w-100">ค้นหา</button>
        </form>
    </div>
    <br>
    <table class="table">
        <thead class="thead-dark">
            <tr align="center">
                <th scope="col">#</th>
                <th scope="col">username</th>
                <th scope="col">workdate</th>
                <th scope="col">workin</th>
                <th scope="col">workout</th>
            </tr>
        </thead>
        <tbody align="center">
            <?php
            $result_io_list = mysqli_query($connect, $query_io_list);
            if (mysqli_num_rows($result_io_list) == 0) {
            ?>
                <td colspan="5" align="center">ไม่พบข้อมูล</td>
                <?php
            } else {
                while ($fetch_io_list = mysqli_fetch_assoc($result_io_list)) {
                ?>
                    <tr>
                        <th scope="row"><a href="?page=iolist&action=<?php echo $fetch_io_list["io_id"]; ?>"><?php echo $fetch_io_list["io_id"]; ?></th></a>
                        <td><a href="?page=iolist&action=<?php echo $fetch_io_list["io_id"]; ?>"><?php echo $fetch_io_list["username"]; ?></td></a>
                        <td><a href="?page=iolist&action=<?php echo $fetch_io_list["io_id"]; ?>"><?php echo $fetch_io_list["workdate"]; ?></td></a>
                        <td><?php echo $fetch_io_list["workin"]; ?></td>
                        <td><?php echo $fetch_io_list["workout"]; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
<?php } ?>