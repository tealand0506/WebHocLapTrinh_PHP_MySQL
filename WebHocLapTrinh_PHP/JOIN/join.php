<?php

session_start();
$servername="localhost:81";
$username="root";
$password="";
$conn=new mysqli("localhost","root","","quanlyweblaptrinh");
if($conn->connect_error){
    die("Kết nối thất bại:".$conn->connect_error);
}

if(isset($_SESSION["ID_USERS"])){
    // Kết nối cơ sở dữ liệu
    $userId = $_SESSION["ID_USERS"];
    if(isset($_POST['courseId'])){
        $courseId = strval($_POST['courseId']);
            $SQLstr_insert = "INSERT INTO ThamGia (ID_USER_TG, ID_KH_TG) VALUES ('$userId', '$courseId');";
            mysqli_query($conn, $SQLstr_insert);
      
    }
    else{
        echo "Không tìm thấy khóa học";
    }
}
else{
    echo "Bạn hãy đăng nhập";
}
?>
