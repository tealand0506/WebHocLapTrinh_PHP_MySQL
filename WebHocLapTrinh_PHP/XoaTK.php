<?php
include 'connect/config.php';
session_start();
$id_user = $_SESSION['ID_USERS'];

$Sql_Xoa_TK = "Delete from Account where ID = '".$id_user."'";
$Query=mysqli_query($conn,$Sql_Xoa_TK);
if(mysqli_affected_rows($conn))
{
    $_SESSION['TrangThaiDangNhap'] = false;
    unset($_SESSION['username']);
    unset($_SESSION['ID_USERS']);
    header('Location:TrangChu.php');
    exit();
}
else{
    echo "<script>
    alert('xoa tai khoan khong thanh cong!');
    </script>";
}
?>