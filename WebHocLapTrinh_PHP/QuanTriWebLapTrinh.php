<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<title>QUẢN LÝ KHÓA HỌC</title>
<style>
  input[type="file"] + label {
    display: none;
}
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

.DSKhoaHoc a {
  color:#000;
}
form table{
  margin-top:50px
}
	</style>
</head>

<?php
class Page{
    function FindStart($limit)//Tìm mãu tin bắt đầu trang
    {
        if(!isset($_GET['page']) || $_GET['page']=="1")
        {
            $start=0;
            $_GET['page'] = 1;
        }
        else{
            $start=($_GET['page']-1) * $limit;
        }
        
        return $start;
    }

    function FindPages($count,$limit)//tinh so luong trang
    {
        $page = (($count % $limit) == 0) ? $count/$limit : floor($count/$limit) +1;
        return $page;
    }

    function PageList($curPage,$page)
    {
        $page_list = "";
        if(($curpage != 1) && ($curpage))
        {
            $page_list .="<a href=\"".$_SERVER['PHP_SELF']."?page=1\" title=\"Trang đầu\"><<</a>";
        }
        if(($curpage-1 )> 0 )
        {
            $page_list .="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\" title=\"Về trang trước\"><</a>";
        }
        for($i=1;$i<=$pages;$i++)
        {
            if($i == $curpage)
            {
                $page_list .="<b>".$i."</b>";
            }
            else{
                $page_list .="<a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\" title=\"Trang".$i."\">".$i."</a>";
            }
            $page_list .= " ";
        }
        if(($curpage+1) <= $pages)
        {
            $page_list .="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\" title=\"Đến trang sau\">></a>";
        }
        if(($curpage != $pages) && ($pages != 0))
        {
            $page_list .="<a href=\"".$_SERVER['PHP_SELF']."?page=".$pages."\" title=\"Trang cuối\">>></a>";
       
        }
        $page_list .= "</td>\n";
        return $page_list;
    }
    function nextPrev($curpage,$pages)
    {
        $next_prev = "";
        if(($curpage-1) <=0)
        {
            $next_prev .="Về trang trước";
        }
        else{
            $next_prev .="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage-1)."\">Về trang trước</a>";
        }
        $next_prev .=" | ";
        if(($curpage+1) > $pages)
        {
            $next_prev .="Đến trang sau";
        }
        else{
            $next_prev .="<a href=\"".$_SERVER['PHP_SELF']."?page=".($curpage+1)."\">Đến trang sau</a>";
        }
        return $next_prev;
    }
}
?>


<body>
<header class="header" >
	 <table width="100%" border="0" cellspacing=0, cellpadding=0 align="center" > 
		 <tr>
      <td colspan="9" align="center" bgcolor="#0A105B"><H1 align="center" style="color: #32F8E2">QUẢN LÝ KHÓA HỌC</H1></td>
      </tr>
	  </table>
  </header>
<form id="frmDanhMucKH" name="frmDanhMucKH" method="post" action="QuanTriWebLapTrinh.php">


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" id="DSKhoaHoc" >
  <tbody>
    <tr>
      <td colspan="6" align="center" height="30px">DANH MỤC KHÓA HỌC</td>
      <td colspan="3" align="center"><input type="text" name="txtsearch" id="textfitxtsearcheld" placeholder="Nhập từ khóa để tìm kiếm" >
<button type="submit" name="btnsearch" id="btnsearch"><i class="fas fa-search"></i></button></td>
    </tr>
    <tr>
      <td width="auto" align="center">Mã khóa học</td>
      <td width="auto" align="center">Tên khóa học</td>
      <td width="auto" align="center">Ngôn ngữ</td>
      <td width="auto" align="center">Số bài học</td>
      <td width="auto" align="center">Số tham gia</td>
      <td width="auto" align="center">Số Bookmarks</td>
      <td width="auto" align="center">Hình ảnh</td>
      <td width="auto" align="center">Sửa</td>
    </tr>
<?php
  $p = new Page();

  // Giới hạn dòng của 1 trang
  $limit = 5;

  // Tìm dòng được đưa vào trong trang (khai báo nếu chưa có giá trị)
  $start = $p->findStart($limit);
     // Tìm số trang dựa trên số dòng vừa có và giới hạn cho 1 trang
  
	  include 'connect/config.php';
	 if(isset($_POST['btnsearch']))//nếu nút tìm kiếm được bấm
   {
      if(!empty($_POST['txtsearch']))//nếu tên khóa học được nhập
      {
        $TuKhoa = $_POST['txtsearch'];
      }
      if(empty($_POST['txtsearch'])){//nếu chưa nhập từ khoas tìm kiếm
        $TuKhoa = "";
        echo "<script>
        alert('Bạn chưa nhập từ khóa để tìm kiếm');
        </script>";
      }
   }
   else{
    $TuKhoa = "";
   }    
    $sql_KH="SELECT kh.MaKH, kh.TenKH, kh.NgonNgu,kh.HinhAnhKH,
    (select count(makhoahoc) from baihoc where baihoc.makhoahoc=kh.makh) as SL_BaiHoc,
    (select count(ID_KH) from bookmarks_kh where bookmarks_kh.ID_KH=kh.makh) as SL_Bookmarks,
    (select count(ID_KH_TG) from thamgia where thamgia.ID_KH_TG=kh.MaKH) as SL_ThamGia
    from khoahoc as KH
    where kh.MaKH like '%".$TuKhoa."%' or kh.TenKH like '%".$TuKhoa."%' or kh.NgonNgu like '%".$TuKhoa."%' or kh.HinhAnhKH
    LIMIT ".$start.",".$limit."
    ";
	  $query_KH= mysqli_query($conn, $sql_KH);
    $count = mysqli_num_rows(mysqli_query($conn, "select * from KhoaHoc"));

    $pages = $p->findPages($count, $limit); 

    if($query_KH->num_rows==0)
    {
      echo "<tr>
        <td colspan=9 align = center> KHÔNG CÓ KHÓA HỌC NÀO!</td>
      </tr>";
    }
	  while($KhoaHoc = $query_KH->fetch_array())
	  {
?>
  
	    <tr>
	      <td width="auto" align="center"><?php echo $KhoaHoc['MaKH'];?></td>
	      <td width="auto" align="center"><?php echo $KhoaHoc['TenKH'];?></td>
	      <td width="auto" align="center"><?php echo $KhoaHoc['NgonNgu'];?></td>
	      <td width="auto" align="center"><?php echo $KhoaHoc['SL_BaiHoc'];?></td>
	      <td width="auto" align="center"><?php echo $KhoaHoc['SL_ThamGia'];?></td>
	      <td width="auto" align="center"><?php echo $KhoaHoc['SL_Bookmarks'];?></td>
        <td width="auto" align="center"><img src="images/<?php echo $KhoaHoc['HinhAnhKH'];?>" width=50px height=40px></td>
	      <td width="auto" align="center"><a href="QuanTriWebLapTrinh.php?id=<?php echo $KhoaHoc['MaKH'];?>"><i class="fas fa-edit"></i></a></td>
    </tr>
	    <?php
	  }
       
  
?>
  </tbody>
</table>	

<?php
  $next_prev = $p->nextPrev(isset($_GET['page']) ? $_GET['page'] : 1, $pages);
  echo "<p align='center'>".$next_prev."</p>";
?>
  
<?php
    if(isset($_GET['id']))
    {
      $MaKH=$_GET['id'];
      $SQL_KhoaHoc="select * from khoahoc where MaKH='$MaKH'";
      $result_KH=mysqli_query($conn, $SQL_KhoaHoc);
      $row=$result_KH->fetch_assoc();
      $TenKH=$row['TenKH'];
      $DiaChi=$row['DiaChi'];
      $HinhAnh=$row['HinhAnhKH'];
      $NgonNgu = $row['NgonNgu'];
      $MoTa=$row['MoTa'];
    }
    else
    {
      $MoTa="";
      $TenKH="";
      $DiaChi="";
      $HinhAnh="";
      $NgonNgu ="";
    $MaKH="";
    }
?>

  <table width="auto" border="1" align="center" cellpadding="2" cellspacing="0" margin-top=50px>
  <tbody>
    <tr>
      <td colspan=2 align="center">THÔNG TIN KHÓA HỌC</td>
      <td  align="center">Danh mục bài học</td>
    </tr>
    <tr>
      <td width="88" height="35" align="center" >Mã  khóa học:
      <input type='text' id="MaKH" name="MaKH" value="<?php echo $MaKH;?>" size="10"></td>
      <td width="182" align="left">Ngôn ngữ:
      <input type="text" name="NgonNgu" id="NgonNgu"  value="<?php echo $NgonNgu;?>"></td>
      <td width="auto" rowspan="5" align="center" id="DsBaiHoc">
      <input type="text" id="txtSearchBaiHoc" name="txtSearchBaiHoc" placeholder="Nhập từ khóa để tìm kiếm">
      <button type="submit" id="btnSearchBaiHoc" name="btnSearchBaiHoc"><i class="fas fa-search"></i></button>
      <ul class="dsBaiHoc">
        <?php

        if(isset($MaKH))
        {        
          if(isset($_POST["btnSearchBaiHoc"]))
          {
            if(isset($_POST["txtSearchBaiHoc"]))
            {
              $TuKhoa=$_POST["txtSearchBaiHoc"];
            }
            else
            {
              $TuKhoa="";
              $echo = "<script>
              alert('CHƯA NHẬP TỪ KHÓA ĐỂ TÌM KIẾM!!!');
              </script>";
            }
          }
          else{   
            $TuKhoa="";
          }
          $sql_DSBaiHoc="select MaBaiHoc,TenBaiHoc from baihoc where MaKhoaHoc like'%".$MaKH."%' and  (MaBaiHoc like '%".$TuKhoa."%' or TenBaiHoc like '%".$TuKhoa."%')";
          $result_BaiHoc=mysqli_query($conn,$sql_DSBaiHoc);
          if(mysqli_num_rows($result_BaiHoc)>0)
          {
            while($rows=mysqli_fetch_array($result_BaiHoc))
            {
              echo "<li>
              <a href='QLBaiHoc.php?id=".$rows['MaBaiHoc']."'>".$rows['TenBaiHoc']."</a>
              </li>";
            } 
          }
          else{
            echo "KHÔNG CÓ BÀI HỌC NÀO!";
          }
        }
        else{
          echo "<li>KHÔNG TÌM THẤY MÃ KHÓA HỌC!</li>";
        }
        ?>
      </ul>
	</td>
    </tr>
    <tr>
      <td height="33" align="center">Tên khóa học:</td>
      <td align="center"><input type='text' size="30" maxlength="200" id='TenKH' name='TenKH' value="<?php echo $TenKH;?>">
      </tr>
    <tr>
      <td height="41" align="center">Hình ảnh:</td>
      <td align="center"><input type='file' id='HinhAnh' name='HinhAnh' value="<?php echo $HinhAnh;?>">
 
      </td>
      </tr>
    <tr>
      <td height="45" align="center">Địa chỉ:</td>
      <td height="45" align="center"><input type="file"id="DiaChi" name='DiaChi' value="<?php echo $DiaChi;?>"></td>
    </tr>
    <tr>
      <td height="71" colspan="2" align="center" valign="middle">
          <textarea name="MoTa" cols="55" rows="5" id="MoTa" ><?php echo $MoTa;?></textarea>
      </td>
    </tr>
    <tr>
      <td height="39" colspan="1" align="center"><button type = "submit" id='btnReset'>Reset</button></td>
      <td height="39" align="center">
        <button type = "submit" id='btnThem'name="btnThem">Thêm</button>
        <button type = "submit" id='btnXoa' name="btnXoa">Xóa</button>
        <button type = "submit" id='btnSua' name="btnSua">Sửa</button>
      </td>
      <td height="39" align="center">
<?php
  if(isset($_GET['id']))
  {
    $id=$_GET['id'];
    echo "<a href='ThemBaiHoc.php?id=".$id."&name=".$TenKH."'><i class='fas fa-plus'></i></a>";
  }
  if(!isset($_GET['id'])){
    echo "Chọn 1 khóa học để them bài học!";
  }
?>
    </td>
    </tr>
  </tbody>
</table>
     
<?php
          
          if(isset($_POST['btnReset']))
          {
            echo "<meta http-equiv='refresh' content='0'>";         
            exit();
          }
          if(isset($_POST['btnThem']))
          {
            $MaKH=$_POST['MaKH'];
            $MoTa=$_POST['MoTa'];
            $TenKH=$_POST['TenKH'];
            $DiaChi=$_POST['DiaChi'];
            $HinhAnh=$_POST['HinhAnh'];
            $NgonNgu =$_POST['NgonNgu'];
            $SQL_KTRA_MAKH="SELECT TenKH FROM KhoaHoc where MaKH='$MaKH' or TenKH='$TenKH'";//TRUY VẤN MÃ KHÓA HỌC TRƯỚC KHI THEM 1 KHÓA HỌC MỚI, TRÁNH LỖI TRÙNG KHOA KHÓA CHÍNH.
            $resultKtraMaKH=mysqli_query($conn,$SQL_KTRA_MAKH);
            if(mysqli_num_rows($resultKtraMaKH) == 0)//nếu không tình được mã khóa học nào đã tồn tại -> thực hiện ADD
            {
              $SQL_INSERT_KHOAHOC="INSERT INTO `khoahoc` (`MaKH`, `TenKH`, `DiaChi`, `MoTa`, `HinhAnhKH`, `NgonNgu`) VALUES ('$MaKH','$TenKH','$DiaChi','$MoTa',ifnull('$HinhAnh','logo2.png'),'$NgonNgu')";
              $result=mysqli_query($conn,$SQL_INSERT_KHOAHOC);
              if(mysqli_affected_rows($conn)>0)
              {
                echo "<meta http-equiv='refresh' content='0'>"; 
                exit();
              }
            }
            else
            {
              echo "
              <script>
              alert('Tên Khóa học hoặc Mã khóa học này đã tồn tại!');
              </script>
              ";
            }

          }
          if(isset($_POST['btnSua']))
          {
            $MaKH=$_POST['MaKH']; 
            $MoTa=$_POST['MoTa'];
            $TenKH=$_POST['TenKH'];
            $DiaChi=$_POST['DiaChi'];
            $HinhAnh=$_POST['HinhAnh'];
            $NgonNgu =$_POST['NgonNgu'];

            $SQL_UPDATE_KHOAHOC="UPDATE `khoahoc` SET `TenKH`='$TenKH',`DiaChi`='$DiaChi',`MoTa`='$MoTa',`HinhAnhKH`=ifnull('$HinhAnh','logo2.png') WHERE MaKH='$MaKH'";
            $result=mysqli_query($conn,$SQL_UPDATE_KHOAHOC);
            if(mysqli_affected_rows($conn)>0)
            {
              echo "<meta http-equiv='refresh' content='0'>"; 
              exit();
            }
          }
          if(isset($_POST['btnXoa']))
          {
            $MaKH=$_POST['MaKH'];
            $SQL_DEL_KHOAHOC="DELETE FROM `khoahoc` WHERE MaKH='$MaKH'";// ON DELETE CASCADE -> KHI THUC HIEN XOA KHOA HOC -> CAC BANG CHUA KHOA HOC CUNG BI XOA  
            $result=mysqli_query($conn,$SQL_DEL_KHOAHOC);
            if(mysqli_affected_rows($conn)>0)
            {
              echo "<meta http-equiv='refresh' content='0'>"; 
              exit();
            }
            if (!$result) {
              printf("Error: %s\n", mysqli_error($conn));
              exit();
            }
          }
          // if(isset($_POST['btnTimKiemKhoaHoc']))
          // {
          //   $TenKH=$_POST['TenKH'];
          //   $SQL_SEARCH_KhoaHoc="select * from KhoaHoc where TenKH like '%".$TenKH."%'";
          //   $result_KH=mysqli_query($conn, $SQL_SEARCH_KhoaHoc);
          //   $row=$result_KH->fetch_assoc();
          //   $_POST["TenKH"]=$row['TenKH'];
          //   $_POST["DiaChi"]=$row['DiaChi'];
          //   $_POST["HinhAnh"]=$row['HinhAnhKH'];
          //   $_POST['NgonNgu'] = $row['NgonNgu'];
          //   $_POST["MoTa"]=$row['MoTa'];
          //   $_POST["MaKH"]=$row['MaKH'];
          // }
        ?>
<form>
</body>
</html>