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
        
        // Kiểm tra xem khóa học đã bookmark chưa
        $SQLstr_bm = "SELECT * FROM Bookmarks_KH WHERE ID_USER='$userId' AND ID_KH='$courseId';";
        $query_bm = mysqli_query($conn, $SQLstr_bm);
        if(mysqli_num_rows($query_bm) == 0){
            // Nếu chưa bookmark, thêm vào cơ sở dữ liệu
            $SQLstr_insert = "INSERT INTO Bookmarks_KH (ID_USER, ID_KH) VALUES ('$userId', '$courseId');";
            mysqli_query($conn, $SQLstr_insert);
        }
        else{
            echo "huy bookmarks";
        }
    }
    else{
        echo "Không tìm thấy khóa học";
    }
}
else{
    echo "Bạn hãy đăng nhập";
}
?>
