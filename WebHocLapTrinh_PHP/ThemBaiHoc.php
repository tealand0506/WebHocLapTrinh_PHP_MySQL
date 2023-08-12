<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<title>Thêm bài học</title>
</head>
<?php
    $MaKH=$_GET['id'];
    $TenKH = urldecode($_GET['name']);
?>
<body>
<form id="frmThemBH" name="frmThemBH" method="post">
  <table width="542" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
      <tr>
        <td height="40" colspan="4" align="center" bgcolor="#0C1645" style="font-size: 36px; color: #FFFFFF;">THÊM BÀI HỌC</td>
      </tr>
      <tr>
        <td width="87" height="35" bgcolor="#949BE9">Mã KH: </td>
        <td width="200" bgcolor="#949BE9"><input name="MaKH" type="text" id="MaKH" readonly="readonly" value="<?php echo $MaKH?>"></td>
        <td width="72" bgcolor="#949BE9">Tên KH:</td>
        <td width="155" bgcolor="#949BE9"><input name="TenKH" type="text" id="TenKH" readonly="readonly" value="<?php echo $TenKH?>"></td>
      </tr>
      <tr>
        <td bgcolor="#949BE9" height="35">Tên bài học:</td>
        <td bgcolor="#949BE9"><input type="text" name="TenBH" id="TenBH"></td>
        <td colspan="2" align="center" bgcolor="#949BE9"><button type='submit' name='btnThemBH' id='btnThemBH'><i class='fas fa-plus'></i></button></td>
      </tr>
    </tbody>
  </table>
  <?php
    if(isset($_POST['btnThemBH']))
    {   
        $TenBH = $_POST['TenBH'];
        $SQL_ThemBH = "INSERT INTO `baihoc`( `MaKhoaHoc`,  `TenBaiHoc`, `DiaChi`) VALUES ('".$MaKH."','".$TenBH."',null)";
        $query=mysqli_query($conn,$SQL_ThemBH);
    }
  ?>
</form>
</body>
</html>