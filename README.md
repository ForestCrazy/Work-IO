# Work-IO
ระบบบันทึกเวลาการเข้า-ออกงาน

## ความต้องการของระบบ
  * PHP 5.3 ขึ้นไป
  * Mysql

## การติดตั้ง
  1. อัพโหลดโค้ดที่ดาวน์โหลดทั้งหมดขึ้นไปที่ server
  2. สร้าง database และ import ไฟล์ sql ทั้งหมดในโฟลเดอร์ sql
  3. แก้ไขชื่อ database ให้ตรงกับ database ที่สร้างในไฟล์ /system/connect.php
  
## การใช้งาน
  * insert username และ password(password เก็บข้อมูลแบบ sha256) เข้าใน table account
  * ล็อกอินเข้าใช้งาน
  
#### Create By ForestCrazy
