<?php
$servername="localhost:81";
$username="root";
$password="";
$conn=new mysqli("localhost","root","","quanlyweblaptrinh");
if($conn->connect_error){
    die("Kết nối thất bại:".$conn->connect_error);

}?>