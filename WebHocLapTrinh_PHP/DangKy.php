<!DOCTYPE html>
<html>
<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="style_DangKy.css" rel="stylesheet">
	<title>Đăng ký</title>

</head>

<?php
session_start();
include 'connect/config.php';
	if(isset($_POST['DangKy']))
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		 // Thực hiện truy vấn INSERT để lưu thông tin đăng ký vào cơ sở dữ liệu
		$sql = "INSERT INTO Account VALUES (NULL, '$username', '$password','$email')";
		$sql_Ktra_Email="SELECT * FROM Account WHERE email = '".$email."'";
		$result_KQ=mysqli_query($conn, $sql_Ktra_Email);

		if ($num_rows = mysqli_num_rows($result_KQ)>0) {
			echo "<script>
			alert ('Email này đã tồn tại!');
			</script>";
		}
		else if (mysqli_query($conn, $sql)) {		
			
			$_SESSION['username'] = $username;
			$_SESSION['ID_USERS'] = mysqli_insert_id($conn);
			$_SESSION['TrangThaiDangNhap']= true;
          	header('Location:TrangChu.php');
			exit;
		}
		else 
		{
			 echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
		}
	 
		 // Đóng kết nối
		 mysqli_close($conn);
	
	}
?>

<body>
	<p>CODE PRO</p>
	<div class="login-box">
	<form name="DangKy" id="DangKy" method="post">
		<h2 align="center">ĐĂNG KÝ</h2>
	<div class="user-box">	
		<input type="email" id="email" name="email" required>
		<label>Email:</label>
	</div>

	<div class="user-box">	
		<input type="text" id="username" name="username" required>
		<label>Tên đăng nhập:</label>
	</div>

	<div class="user-box">
		<input type="password" name="password" id="password" required>
		<label>Password:</label>
	</div>
	<br>
		<button name="DangKy" id="DangKy" type="submit">Đăng ký</button>
	</form>
	<br>
    <a href="DangNhap.php">Bạn đã có tài khoản?</a>
	</div>
</body>
</html>
