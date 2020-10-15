<?php
require('config.php');
$connect = new mysqli($config['mysql_host'],$config['mysql_username'],$config['mysql_password'],$config['mysql_dbname']);
$connect->query('SET names utf8');
if($connect->connect_errno) {
    exit("Error-> ".$connect->connect_error);
}
date_default_timezone_set("Asia/Bangkok");