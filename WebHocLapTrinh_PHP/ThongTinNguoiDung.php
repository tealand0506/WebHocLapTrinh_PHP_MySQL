<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code pro</title>
    <link rel="stylesheet" href="style_UserInfor.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<?php
include 'connect/config.php';
session_start();

$ID_USER =$_SESSION['ID_USERS'];

$sql_TT = "select DATE_FORMAT(NgaySinh, '%d/%m/%Y') as NgaySinh, HoTen, DiaChi, SoDT, NgheNghiep from ThongTinNguoiHoc where ID_USER = '".$ID_USER."'";
$query = mysqli_query($conn,$sql_TT);
$result = mysqli_fetch_assoc($query);

if($result > 0)
{
	$HoTen = $result['HoTen'];
	$DiaChi= $result['DiaChi'];
	$NgaySinh = $result['NgaySinh'];
	$SDT = $result['SoDT'];
	$NgheNghiep = $result['NgheNghiep'];
}
else{
	$HoTen ="";
	$DiaChi= "";
	$NgaySinh = "";
	$SDT = "";
	$NgheNghiep = "";
}

?>
<body>
	<form name="frmThongTinNguoiDung" id="frmThongTinNguoiDung" method="post">
		<table border="1" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td colspan=2 align="center" height='60px'><p>THÔNG TIN NGƯỜI DÙNG</p></td>
			</tr>
			<tr>
				<td width="120" height="35" align="center">Họ và tên: </td>
				<td width="189" height="35" align="center">
              <input type="text" name="HoTen" id="HoTen" value="<?php echo $HoTen;?>"></td>
		  </tr>
			<tr>
				<td height="35" align="center">Ngày sinh:</td>
			  <td height="35" align="center"><input type="type" name="NgaySinh" id="NgaySinh" placeholder="dd/mm/yyyy" value = "<?php echo $NgaySinh;?>"></td>
		  </tr>
			<tr>
				<td height="35" align="center">Nghề nghiệp:</td>
			  <td height="35" align="center"><input type="text" name="NgheNghiep" id="NgheNghiep" value = "<?php echo $NgheNghiep;?>"></td>
		  </tr>
			<tr>
				<td height="35" align="center">Địa chỉ:</td>
			  <td height="35" align="center"><input type="text" name="DiaChi" id="DiaChi" value = "<?php echo $DiaChi;?>"></td>
		  </tr>
			<tr>
				<td height="35" align="center">Số điện thoại:</td>
			  <td height="35" align="center"><input type="text" name="SDT" id="SDT" value = "<?php echo $SDT ;?>"></td>
		  </tr>
			<tr>
				<td colspan=2 align='center' height='60px'> 
					
					<button type='submit' name='btnSua' id='btnSua'>Cập nhật</button>
					<button type='submit' class='btnXoaTK'>Xóa tài khoản</button>
				</td>
			</tr>
			<script>
				$(document).on("click", ".btnXoaTK", function(event){  
				event.preventDefault();
				if(confirm("Bạn muốn xóa tài khoản này?"))
				{
					window.location.href = "http://localhost:81/web/XoaTK.php";
				}
				else{
					return 0;
				}
				});		
			</script>
			<?php

				if(isset($_POST['btnSua']))
				{
					$HoTen = $_POST['HoTen'];
					$DiaChi= $_POST['DiaChi'];
					$NgaySinh = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['NgaySinh'])));//Dinh dang kieu date
					$SDT = $_POST['SDT'];
					$NgheNghiep = $_POST['NgheNghiep'];
					
					$sql_ktra_TT = "select * from ThongTinNguoiHoc where ID_USER = '".$ID_USER."'";
					$query_KT = mysqli_query($conn, $sql_ktra_TT);
					if(mysqli_affected_rows($conn)==0)//ktra da co thong tin chua
					{
						$SQL_Them_TT="INSERT INTO `thongtinnguoihoc`(`HoTen`, `NgaySinh`, `SoDT`, `NgheNghiep`, `DiaChi`,`ID_User`) VALUES ('$HoTen','$NgaySinh','$SDT','$NgheNghiep','$DiaChi','$ID_USER');";
						$query = mysqli_query($conn, $SQL_Them_TT);
						if(mysqli_affected_rows($conn))
						{
							header('Location:Profile.php');
							exit();
						}
						else if(mysqli_affected_rows($conn)==0){
							echo "Them t that bai ";
						}
					}
					else{
						$sql_Sua_TT="UPDATE `thongtinnguoihoc` SET `HoTen`='$HoTen',`NgaySinh`='$NgaySinh',`SoDT`='$SDT',`NgheNghiep`='$NgheNghiep',`DiaChi`='$DiaChi' WHERE ID_USER = '".$ID_USER."'";
						$query = mysqli_query($conn, $sql_Sua_TT);
						if(mysqli_affected_rows($conn))
						{
							header('Location:Profile.php');
							exit();
						}
						else{
							echo "Them t that bai ";
						}
						}
				}
			?>
		</table>
</form>
</body>
</html>