<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CẬP NHẬT KHÓA HỌC</title>
	<style>
	.dsBaiHoc{
	  width:200px;
		height:250px;
		margin: 0% 0%;
		padding: 0 0 0 30px;
	  overflow-y: scroll ;
}
		.dsBaiHoc li{
			list-style:decimal;
			text-align:left;
			margin:0%
		}
		.dsBaiHoc li:nth-child(even) {
  background-color:#C0C0C0
}

.dsBaiHoc li:nth-child(odd) {
  background-color: #ffffff;
}
	</style>
</head>
	
	<?php
	include 'connect/config.php';
	if(isset($_GET['id']))
	{
		$MaKH = $_GET['id'];
		echo $MaKH;
	}
	?>
	
<body>
	<form method="post" enctype="multipart/form-data" name="frmThongTinKH" id="frmThongTinKH">
	<table width="auto" border="1" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td colspan=3 align="center">THÔNG TIN KHÓA HỌC</td>
    </tr>
    <tr>
      <td width="88" height="35" align="center">Mã  khóa học:</td>
      <td width="182" align="left"><input type='text' readonly="true" id="MaKH" value="<?php echo $MaKH;?>"> </td>
      <td width="auto" rowspan="5" align="center" >
		<ul class="dsBaiHoc">
		  <?php
		  $sql_DABaiHoc="select MaBaiHoc,TenBaiHoc from baihoc where MaKhoaHoc='".$MaKH."'";
		  $query=mysqli_query($conn,$sql_DABaiHoc);
		  while($rows=mysqli_fetch_array($query))
		  {
			  echo "<li id='".$rows['MaBaiHoc']."'>
			  ".$rows['TenBaiHoc']."</li>";
		  }
		  ?>
		 </ul>
	</td>
    </tr>
    <tr>
      <td height="33" align="center">Tên khóa học:</td>
      <td align="center"><input type='text' size="50" maxlength="200" ></td>
      </tr>
    <tr>
      <td height="41" align="center">Hình ảnh:</td>
      <td align="center"><input type='file'></td>
      </tr>
    <tr>
      <td height="45" align="center">Địa chỉ:</td>
      <td height="45" align="center"><input type="file" name="fileField" id="fileField"></td>
    </tr>
    <tr>
      <td height="71" colspan="2" align="left">Mô tả:
        <textarea name="textarea" cols="50" rows="5" id="textarea"></textarea></td>
    </tr>
    <tr>
      <td height="39" colspan="3" align="center">&nbsp;</td>
    </tr>
  </tbody>
</table>

</form>

</body>
</html>