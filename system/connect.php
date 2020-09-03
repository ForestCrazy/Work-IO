<?php
$connect = new mysqli("localhost","root","","working-io");
$connect->query('SET names utf8');
if($connect->connect_errno) {
    exit("Error-> ".$connect->connect_error);
}
date_default_timezone_set("Asia/Bangkok");