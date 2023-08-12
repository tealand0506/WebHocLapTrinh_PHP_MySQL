<!-- Để người học có thể xem lại lịch sử tham gia của họ, bạn cần lưu trữ thông tin về các khóa học mà họ đã tham gia và các hoạt động của họ trong từng khóa học đó. Bạn có thể xử lý cơ sở dữ liệu bằng cách tạo các bảng sau đây:

Bảng "Users" (Người dùng): Lưu trữ thông tin về người dùng như tên, email, mật khẩu, v.v.

Bảng "Courses" (Khóa học): Lưu trữ thông tin về các khóa học như tên, mô tả, giảng viên, v.v.

Bảng "Enrollments" (Đăng ký): Lưu trữ thông tin về việc đăng ký của người dùng vào các khóa học, bao gồm người dùng đã đăng ký khóa học nào và thời gian đăng ký.

Bảng "CourseProgress" (Tiến độ khóa học): Lưu trữ thông tin về tiến độ của người dùng trong mỗi khóa học, bao gồm các bài tập đã hoàn thành, thời gian bắt đầu và hoàn thành mỗi bài tập, v.v.

Sau khi có các bảng trên, người dùng có thể xem lịch sử tham gia của họ bằng cách truy cập vào trang cá nhân của họ trên trang web của bạn, với thông tin về các khóa học đã đăng ký và tiến độ hoàn thành của họ trong từng khóa học. -->

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code pro</title>
    <link rel="stylesheet" href="styles_Profile.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<?php
    session_start();
    include 'connect/config.php';
?>

<body>
	<form name='frmProfile' id='frmProfile' method='post'>
    <div class="header" >
        <img src="images/logo2.png" >
        <div class="name" >CODE PRO</div>
        <div class="nav">
            <ul>
                <li >
                    <a href="TrangChu.php" >Home</a>
                </li>
                <li>
                <a href="Learn.php">Learn</a> 
                    <ul class="sup-menu1">
                    
                        <?php
                            $select_NgonNgu = "SELECT DISTINCT(NgonNgu) FROM KhoaHoc";
                            $result_NgonNgu = mysqli_query($conn, $select_NgonNgu);
                            while ($rows_NgonNgu = $result_NgonNgu->fetch_assoc()) {
                                echo "<li>  <div class='dropdown dropend' ><button type='button' align='center' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown'>
                                ".$rows_NgonNgu['NgonNgu']."
                              </button>
                                        <ul class='dropdown-menu sup-menu2'>";
                                        $select_KhoaHoc = "SELECT TenKH FROM KhoaHoc WHERE NgonNgu='" . $rows_NgonNgu['NgonNgu'] . "'";
                                        $result_KhoaHoc = mysqli_query($conn, $select_KhoaHoc);
                                        while ($rows_KhoaHoc = $result_KhoaHoc->fetch_assoc()) 
                                        {
                                            echo "<li><a href='#'>".$rows_KhoaHoc['TenKH']."</a></li>";
                                        }
                                echo "</ul></div></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="news.html">News</a>
                </li>
				<li class="DangNhap">
                <?php
                    if(isset($_SESSION['TrangThaiDangNhap']) && $_SESSION['TrangThaiDangNhap']== true)
                    {
                        echo " <a href='Profile.php' class='active'>
                        <i class='fas fa-user-circle'></i>
                        <span>".$_SESSION['username']."</span>
                        </a>
					    <ul class='sup-menu1'>  
                        <a name='HoSo' id='HoSo' href='ThongTinNguoiDung.php'><i class='fas fa-id-card'></i> <span> Hồ sơ</span></a>
                        <br>
                      <button type='submit' name='DangXuat' id='DangXuat'><i class='fa fa-sign-out'></i><span> Đăng xuất </span></button>
                      
                       </ul>";
                    }
                    else
                    {
                        echo " <a href='DangNhap.php' class='active'>
                    <i class='fas fa-user-circle'></i>
                    <span>Đăng nhập</span>
                </a>
					<ul class='sup-menu1'>
                        <li><a href='DangNhap.php'><i class='fas fa-sign-in-alt'></i><span> Đăng nhập</span></a></li>
                        <div class='dropdown-divider'></div>
                        <li><a href='DangKy.php'><i class='	fa fa-user-plus'></i><span> Đăng ký</span></a></li>
                    </ul>";
                    }
                    if(isset($_POST['DangXuat']))
                        {
                            $_SESSION['TrangThaiDangNhap'] = false;
                            unset($_SESSION['username']);
                            header('Location: TrangChu.php');
                            exit();
                        }
                ?>
                </li>
            </ul>
        </div>
    </div>
<div class='ThongTin'>
    
<?php
$sql_ThongTin = "select * from  ThongTinNguoiHoc where ID_USER = '".$_SESSION['ID_USERS']."'";
$query = mysqli_query($conn, $sql_ThongTin);
$row = mysqli_fetch_assoc($query);
if(mysqli_num_rows($query) > 0)
{
?>
<table width="100%" border="0" cellsapcing=0 celpadding=0>
    <tbody>
      <tr>
        <td colspan="2"><div>
          <h5>THÔNG TIN NGƯỜI DÙNG <a href='ThongTinNguoiDung.php'><i class='fas fa-edit'></i></a></h5>
        </div></td>
      </tr>
      <tr>
        <td width="50">Họ tên:   <?php echo $row['HoTen'];?></td>
        <td >Ngày sinh:   <?php echo $row['NgaySinh'];?></td>
      </tr>
      <tr>
        <td>Nghề nghiệp:   <?php echo $row['NgheNghiep'];?></td>
        <td>Số SDT:    <?php echo $row['SoDT'];?></td>
      </tr>
      <tr>
        <td calsapn=2>Địa chỉ:    <?php echo $row['DiaChi'];?></td>
      </tr>
    </tbody>
  </table>
<?php    
}
else{
?>
<a href="ThongtinNguoiDung.php">Bạn có muốn thêm thông tin?</a>
<?php
}
?>
   
</div>
        <div class="container DanhMuc" >
            <div class='row'>
                <div class="col-md-4 col-lg-3">
                <table>
                <tr height="35px">
                            <td>Bộ lọc</td>
                        </tr>
                    <tr height="35px">
                        <td><label><input  type="radio" name="BoLoc" value="Bookmark" checked>Đã đánh dấu</label></td>
                    </tr>
                    <tr height="35px">
                        <td><label><input  type="radio" name="BoLoc" value="ThamGia">Đã tham gia</label></td>
                    </tr>
                    <!-- <tr height="35px">
                        <td><label><input class='BaiHocrad' type="radio" name="BoLoc_Bookmarks" value="BaiHoc">Chỉ bài học</label></td>
                    </tr> -->
                </table>

                </div>
                <div class="col-md-8 col-lg-9">
                <table class='Bookmark' id="Bookmark" >
                    <tr height='35px'>
                        <td>ĐÃ ĐÁNH DẤU:</td>
                    </tr>
                    <?php
                    $SQLstr_KhoaHoc="SELECT kh.MaKH, kh.TenKH, kh.NgonNgu FROM bookmarks_kh as bm, khoahoc as kh WHERE bm.ID_User='".$_SESSION['ID_USERS']."' and kh.MaKH = bm.ID_KH;";
                    $query_sql=mysqli_query($conn,$SQLstr_KhoaHoc);
                    if($query_sql -> num_rows == 0)
                    {
                        echo "<tr height='35px'>
                                <td>Bạn chưa đánh dấu khóa học nào!</td>
                            </tr>";
                    }
                    else
                    {  
                        while($row = $query_sql->fetch_array())
                        {
                            echo "<tr height='35px' id='MauTin'>
                            <td width='auto'><a href='BaiHoc.php?id=".$row['MaKH']."'><i class='fas fa-book-open'></i></a>  ".$row['TenKH']."</td>
                            <td>".$row['NgonNgu']."</td>
                            <td><a href='#' class='XoaBookmark' data-id=".$row['MaKH']."><i class='fas fa-trash'></i></a></td>
                        </tr>";
                        }
                    }
                    ?>
                </table>              
<script>
  $(document).ready(function(){
    $(document).on("click", ".XoaBookmark", function(){   // Xử lý sự kiện click vào nút "Bookmark" trên trang web
        var courseId=($(this).attr('data-id'));
        var bookmarkLink = $(this);
        var MauTin = document.getElementById("MauTin");
        $.ajax({
            url: "Bookmarks/Bookmarked.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
            MauTin.remove();
            },
        });
        if (typeof sessionStorage !== 'undefined') {
            sessionStorage.setItem('courseId', courseId); // Lưu courseId vào session
        }
        return false;
    });
});
</script>
                       
                    
<table class='ThamGia' id='ThamGia' >
    <tr height='35px'>
                    <td>ĐÃ THAM GIA:</td>
                </tr>
        <?php
        $sqlstr="select  * from khoahoc as kh, ThamGia as tg where tg.ID_KH_TG=kh.MaKH and tg.ID_USER_TG='".$_SESSION['ID_USERS']."'";
        $query_sql=mysqli_query($conn,$sqlstr);
        $countrows = $query_sql->num_rows;
        if($countrows == 0)
        {
            echo "<tr height='35px'>
                    <td>Bạn chưa tham gia một khóa học nào!</td>
                </tr>";
        }
        else{                  
            while($row = $query_sql->fetch_array())
            {
                echo "<tr height='35px' id='MauTin'>
                <td width='auto'><a href='BaiHoc.php?id=".$row['MaKH']."'><i class='fas fa-book-open'></i></a> ".$row['TenKH']."</td>
                <td>".$row['NgonNgu']."</td>
                <td><a href='#' class='XoaThamGia' data-id='".$row['MaKH']."'><i class='fas fa-trash'></i></a></td>
            </tr>";
            }
        }
        ?>
        
</table>
<script>
  $(document).ready(function(){
    $(document).on("click", ".XoaThamGia", function(){   // Xử lý sự kiện click vào nút "Bookmark" trên trang web
        var courseId=($(this).attr('data-id'));
        var JOIN = $(this);
        var MauTin = document.getElementById("MauTin");
        $.ajax({
            url: "JOIN/joined.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
            MauTin.remove();
            },
        });
        if (typeof sessionStorage !== 'undefined') {
            sessionStorage.setItem('courseId', courseId); // Lưu courseId vào session
        }
        return false;
    });
});
</script>
             
                </div>
            </div>
        </div>
        
<script>

$('.ThamGia').hide();
$(document).ready(function() {
  // Bắt sự kiện click vào radio button
  $('input[type=radio][name=BoLoc]').change(function() {
    // Lấy giá trị của radio button được chọn
    var value = $(this).val();// lấy giá trị của Radio
    
    if (value === 'Bookmark') {
    if($('.ThamGia').is(':visible')) $('.ThamGia').hide();
    $('.Bookmark').show();
    } 
    else if (value === 'ThamGia') {
    if($('.Bookmark').is(':visible')) $('.Bookmark').hide();
    $('.ThamGia').show();
    } 
    // else if (value === 'KhoaHoc') {
    // if($('.BaiHoc').is(':visible')) $('.BaiHoc').hide();
    // if($('.TatCa').is(':visible')) $('.TatCa').hide();
    // $('.KhoaHoc').show();
// }
  });
});
</script>


    <div class="container-fluid footer">
        <div class="row" style="color:#b8b8b8">
            <div class="col-lg-2 col-md-6 col-xs-12">
                <img src="images/logo2.png" width="100px" height="100px">
                <div class="name" style="margin:-10px">CODE PRO</div></div>
            <div class="col-lg-5 col-md-6 col-xs-12 borde" style="border-right: 1px solid white">
                <div id="social-platforms">
                    <h1>Liên kết mạng xã hội</h1>

                    <a class="btn btn-icon btn-facebook" href="https://www.facebook.com/CDLTT"><i class="fa fa-facebook"></i><span>Facebook</span></a>
                    <a class="btn btn-icon btn-googleplus" href="https://www.lttc.edu.vn/"><i class="fa fa-google-plus"></i><span>Google+</span></a>
                    <a class="btn btn-icon btn-youtube" href="https://www.youtube.com/c/LyTuTrongHCMC"><i class="fa fa-youtube-play"></i><span>YouTube</span></a>
                </div>
             </div>
             <div class="col-lg-5 col-md-6 col-xs-12" style="margin-top:20px">
                <p>Địa chỉ: 390 Hoàng Văn Thụ, phường 4, quận Tân Bình, TP.HCM</p>
                <p>Hot line: (028) 3811.0521, (028) 3811.8676</p><br><br><br>
                <h5>Đây là website độc quyền được xây dựng hoàn toàn bởi nhóm CODEPRO</h5>
             </div>
        </div>
    </div>
    </form>
</body>
</html>
