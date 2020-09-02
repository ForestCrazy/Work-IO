<h3>ลงเวลาเข้า-ออกงานประจำวันที่ <?php echo date('d-m-Y'); ?></h3>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label for="id">รหัสพนักงาน</label>
            <input type="text" class="form-control" name="id" id="id" value="" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="in-working">เวลาเข้างาน</label>
            <input type="text" class="form-control" name="in-working" id="in-working" value="" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="out-working">เวลาออกงาน</label>
            <input type="text" class="form-control" name="out-working" id="out-working" value="" readonly>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label for="save-working">ลงเวลา</label>
            <button type="submit" class="form-control btn btn-outline-success" name="save-working" id="save-working">บันทึกเวลา</button>
        </div>
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
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
    </tbody>
</table>