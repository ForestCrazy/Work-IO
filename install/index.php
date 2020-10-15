<?php
if (is_file('../system/config.php')) {
    header('Location: ../');
} else {
?>
    <!DOCTYPE html>
    <html lang="th">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>I/O Working Installer</title>
        <!-- Bootstrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.14.0/dist/sweetalert2.all.min.js"></script>
    </head>

    <body>
        <div class="container">
            <h1 class="text-center"><b>ติดตั้ง Work IO ระบบบันทึกเวลาทำงาน</b></h1>
            <br>
            <div class="d-flex justify-content-center">
                <div class="col-sm-9">
                    <form action="" class="col-12" method="POST">
                        <div class="form-group">
                            <label for="db_host">Database Server IP</label>
                            <input type="text" id="db_host" name="db_host" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="db_username">Database Username</label>
                            <input type="text" id="db_username" name="db_username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="db_password">Database Password</label>
                            <input type="text" id="db_password" name="db_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="db_name">Database Name</label>
                            <input type="text" id="db_name" name="db_name" class="form-control">
                        </div>
                        <input type="hidden" name="submit_install">
                        <button type="submit" class="btn btn-success col-12">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- JS -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </body>

    </html>
    <?php
    if (isset($_POST["submit_install"])) {
        if (isset($_POST["db_host"])) {
            if (isset($_POST["db_username"])) {
                if (isset($_POST["db_password"])) {
                    if (isset($_POST["db_name"])) {
                        $configfile = fopen("../system/config.php", "w") or die("Unable to open file!");
                        $txt =
                            '
<?php
$config["mysql_host"] = "' . $_POST["db_host"] . '";
$config["mysql_username"] = "' . $_POST["db_username"] . '";
$config["mysql_password"] = "' . $_POST["db_password"] . '";
$config["mysql_dbname"] = "' . $_POST["db_name"] . '";
?>
';
                        if (fwrite($configfile, $txt)) {
                            require('../system/config.php');
                            require('../system/connect.php');
                            $query = '';
                            $sqlScript = file('database.sql');
                            foreach ($sqlScript as $line)	{
                                $startWith = substr(trim($line), 0 ,2);
                                $endWith = substr(trim($line), -1 ,1);
                                
                                if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                                    continue;
                                }
                                    
                                $query = $query . $line;
                                if ($endWith == ';') {
                                    mysqli_query($connect, $query) or die('<div class="container"><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-triangle"></i> Problem in executing the SQL query ' . $query. '</div></div>');
                                    $query= '';		
                                }
                            }
                            $msg_title = 'install success';
                            $msg = 'install successfully';
                            $msg_icon = 'success';
                        } else {
                            $msg_title = 'install failed';
                            $msg = 'writing file failed #ErrInstall01';
                            $msg_icon = 'error';
                        }
                        fclose($configfile);
                    } else {
                        $msg_title = 'install failed';
                        $msg = 'error post data #ErrInstall02';
                        $msg_icon = 'error';
                    }
                } else {
                    $msg_title = 'install failed';
                    $msg = 'error post data #ErrInstall03';
                    $msg_icon = 'error';
                }
            } else {
                $msg_title = 'install failed';
                $msg = 'error post data #ErrInstall04';
                $msg_icon = 'error';
            }
        } else {
            $msg_title = 'install failed';
            $msg = 'error post data #ErrInstall05';
            $msg_icon = 'error';
        }
    ?>
        <script>
            Swal.fire(
                '<?php echo $msg_title ?>',
                '<?php echo $msg ?>',
                '<?php echo $msg_icon ?>'
            ).then((value) => {
                window.location.href = "../";
            });
        </script>
<?php
    }
}
?>