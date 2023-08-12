<!doctype html>
<html lang="en">
<head>
  <title>Đăng nhập</title>
  <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles_DangNhap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<?php
  session_start();
  include 'connect/config.php';
  if(isset($_POST["TenDN"]) && isset($_POST["Pass"]))
  {
      $TenDN=$_POST["TenDN"];
      $Pass=$_POST["Pass"];
      if(isset($_POST['DangNhap']))
      {
          $SQLstr="SELECT * FROM account WHERE TenDN='".$TenDN."' AND Password='".$Pass."'";//cau lenh truy van dang chuoi
          $MauTin= mysqli_query($conn,$SQLstr);//thuc hien ketnoi va truy van sau do tra ve tap cac mautin
          $row=$MauTin->fetch_assoc();
          if(mysqli_num_rows($MauTin)==1)
          {
              $_SESSION['username'] = $TenDN;
              $_SESSION['ID_USERS'] = $row['ID'];
              $_SESSION['TrangThaiDangNhap']= true;
              header('Location:TrangChu.php');
              exit;
          }
          else if($TenDN=='')
          {
            echo '<script>';
            echo 'alert("Vui lòng nhập tên đăng nhập!")';
            echo '</script>';
          }
          else if($Pass=='')
          {
            echo '<script language="javascript">';
            echo 'alert("Vui lòng nhập mật khẩu!")';
            echo '</script>';
          }
          else
          {
              echo '<script language="javascript">';
              echo 'alert("Tên đăng nhập hoặc Mật khẩu không chính xác!")';
              echo '</script>';
          }
    }
  }
  else{
    $TenDN="";
    $Pass="";
  }
?>
<body>
  <p>CODE PRO</p>
  <div class="login-box">
    <h2>Login</h2> 
     
    <form name="frmDangNhap" id="frmDangNhap" method="post">
    <?php if (isset($error)) { echo '<p>' . $error . '</p>'; } ?>
      <div class="user-box">
        <input type="text" name="TenDN" id="TenDN" required="" value="<?php echo $TenDN;?>">
        <label>Username</label>
      </div>
      <div class="user-box">
          <input type="password" name="Pass" id="Pass" required="" value="<?php echo $Pass;?>">
          <label>Password</label>
      </div> 
  <button type="submit" name="DangNhap" id="DangNhap" value="Đăng nhập">Đăng nhập</button>
    </form>
    <br>
    <a href="DangKy.php">Tạo tài khoản?</a>
  </div>
</body>
</html>
