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
  
## หน้าตาโปรแกรมเบื้องต้น

#### แดชบอร์ด
![dashboard](https://media.discordapp.net/attachments/736481607371718699/765581914693566484/unknown.png?width=1432&height=671)

#### ลางาน
![leave](https://media.discordapp.net/attachments/736481607371718699/765582638710259732/unknown.png?width=1432&height=671)

#### ประวัติการลางาน
![leavehistory](https://media.discordapp.net/attachments/736481607371718699/765583294250352701/unknown.png?width=1432&height=671)

#### จัดการการลางาน
![leavemanagement](https://media.discordapp.net/attachments/736481607371718699/765583294250352701/unknown.png?width=1432&height=671)

#### จัดการบัญชี
![usermanagementmain](https://media.discordapp.net/attachments/736481607371718699/765583930811220008/unknown.png?width=1432&height=672)
![usermanagementedit](https://media.discordapp.net/attachments/736481607371718699/765586555603386418/unknown.png?width=1432&height=672)
![usermanagementcreate](https://media.discordapp.net/attachments/736481607371718699/765586003083264020/unknown.png?width=1432&height=672)
  
#### Create By ForestCrazy
