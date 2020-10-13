<?php
function leave_type($value)
{
    if ($value == "casual") {
        return "ลากิจ";
    } elseif ($value == "sick") {
        return "ลาป่วย";
    } else {
        return "เกิดข้อผิดพลาด";
    }
}