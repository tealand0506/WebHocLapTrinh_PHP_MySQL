<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code pro</title>
    <link rel="stylesheet" href="styles_KhoaHoc.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<?php
include "connect/config.php";
session_start();

?>
<body>
    <form name="frmLearn" id="frmLearn" method="post">
<div class="header" >
        <img src="images/logo2.png" >
        <div class="name" >CODE PRO</div>
        <div class="nav">
            <ul>
                <li >
                    <a href="TrangChu.php" >Home</a>
                </li>
                <li>
                <a href="Learn.php" class="active">Learn</a> 
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
                        echo " <a href='Profile.php' >
                        <i class='fas fa-user-circle'></i>
                        <span>".$_SESSION['username']."</span>
                        </a>
					    <ul class='sup-menu1'>  
                      <a name='HoSo' id='HoSo' href='Profile.php'><i class='fas fa-id-card'></i> <span> Hồ sơ</span></a>
                        <br>
                      <button type='submit' name='DangXuat' id='DangXuat' ><i class='fa fa-sign-out'arria-hidden='false'></i><span> Đăng xuất </span></button>
                       </ul>";
                    }
                    else
                    {
                        echo " <a href='DangNhap.php' >
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
                            unset($_SESSION['ID_USERS']);
                            echo "<meta http-equiv='refresh' content='0'>"; 
                            exit();
                        }
                ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="cards">
            <?php
                include 'connect/config.php';
                $SQLstr_kh="Select kh.MaKH,kh.TenKH, kh.MoTa, 
                (select count(baihoc.MaKhoaHoc) from Baihoc where baihoc.MaKhoaHoc=kh.MaKH) as SL_BaiHoc,
                (select count(TG.ID_KH_TG) from ThamGia as TG where TG.ID_KH_TG=kh.MaKH) as SL_ThamGia,
                HinhAnhKH FROM KhoaHoc as kh;";
                $query_kh=mysqli_query($conn,$SQLstr_kh);
                if(isset($_SESSION['TrangThaiDangNhap']) && $_SESSION['TrangThaiDangNhap']== true)// danh sach khoa hoc cua nguoi dung -> khi da dang nhap
                {
                    
                    while($row_kh=mysqli_fetch_array($query_kh))
                    {
                        $SQLstr_BMed="select * from Bookmarks_KH where ID_USER='".$_SESSION['ID_USERS']." 'and ID_KH='".$row_kh['MaKH']."'";
                        $query_BMed=mysqli_query($conn,$SQLstr_BMed);
                        $SQLstr_TGed="SELECT * FROM `thamgia` WHERE `ID_KH_TG`='".$row_kh['MaKH']."' and `ID_USER_TG`='".$_SESSION['ID_USERS']."'";
                        $query_TGed=mysqli_query($conn,$SQLstr_TGed);
            ?>

                            <div class="card">
                                <div class="container">
                                    <img src="images/<?php echo $row_kh['HinhAnhKH']?>" alt="Ảnh 2" height="200px">
                                </div>
                                <div class="noi-dung">
                                    <h3><?php echo $row_kh['TenKH'];?></h3>
                                    <p>Bài học: <?php echo $row_kh['SL_BaiHoc'];?></p>
                                    <p>Lượt xem: <?php echo $row_kh['SL_ThamGia'];?></p>
                                    <?php
                                    if(mysqli_num_rows($query_TGed) == 0)
                                    {
                                        echo "<button  data-id=".$row_kh['MaKH']." class='join' name='join' id='join' type='Summit'>JOIN</button> ";
                                    }
                                    else
                                    {
                                        echo "<button  data-id=".$row_kh['MaKH']." class='joined' name='joined' id='joined' type='Summit'>JOINED</button> ";
                                    }
                                    if(mysqli_num_rows($query_BMed) == 0)
                                    {
                                        echo "<a  class='bookmark' data-id=".$row_kh['MaKH']." id='bookmark'>
                                        <i class='fa fa-bookmark'></i>
                                    </a>";
                                    }
                                    else
                                    {
                                        echo "<a  class='bookmarked' data-id=".$row_kh['MaKH']." id='bookmarked'>
                                        <i class='fa fa-bookmark'></i>
                                    </a>";
                                    }
                                    ?>
                                </div>
                            </div>
                                    <?php
                    }
                }
                else//DANH SACH NGUOI DUNG CHUA DANG NHAP
                {
                    while($row_kh=mysqli_fetch_array($query_kh))
                    {
                        ?>
                        <div class="card">
                            <div class="container">
                                <img src="images/<?php echo $row_kh['HinhAnhKH']?>" alt="Ảnh 2" height="200px">
                            </div>
                            <div class="noi-dung">
                                <h3><?php echo $row_kh['TenKH'];?></h3>
                                <p>Bài học: <?php echo $row_kh['SL_BaiHoc'];?></p>
                                <p>Lượt xem: <?php echo $row_kh['SL_ThamGia'];?></p>
                                <button class='ChuaDN' type='hide'>JOIN</button>
                                <a  class='ChuaDN' href="#"><i class='fa fa-bookmark'></i></a>
                            </div>
                        </div>
                            <?php
                    }
                }   
                ?>

        </div>
        
<script>
    $(document).ready(function(){
        $(document).on("click", ".join", function(){   // Xử lý sự kiện click vào nút "JOIN" trên trang web
        var courseId=($(this).attr('data-id'));
        var JOIN = $(this);
        $.ajax({
            url: "JOIN/join.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
                JOIN.text("JOINED");
                JOIN.removeClass("join");
                    JOIN.addClass("joined");
                    JOIN.removeAttr("id");
                    JOIN.attr("id", "joined"); 
            },
            error: function(){
                // Xử lý lỗi
            }
        });
        return false;
    });
    $(document).on("click", ".joined", function(){   // Xử lý sự kiện click vào nút "JOINED" trên trang web
        var courseId=($(this).attr('data-id'));
        var JOINed = $(this);
        $.ajax({
            url: "JOIN/joined.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
                JOINed.text("JOIN");
                JOINed.removeClass("joined");
                    JOINed.addClass("join");
                    JOINed.removeAttr("id");
                    JOINed.attr("id", "join"); 
            },
            error: function(){
                // Xử lý lỗi
            }
        });
        return false;
    });
        $(document).on("click", ".bookmark", function(){   // Xử lý sự kiện click vào nút "Bookmark" trên trang web
        var courseId=($(this).attr('data-id'));
        var bookmarkLink = $(this);
        $.ajax({
            url: "Bookmarks/Bookmarks.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
                if (bookmarkLink.length > 0) {
                    bookmarkLink.removeClass("bookmark");
                    bookmarkLink.addClass("bookmarked");
                    bookmarkLink.removeAttr("id");
                    bookmarkLink.attr("id", "bookmarked"); // Thay đổi lớp CSS và id của đối tượng
                    
                }
            },
            error: function(){
                // Xử lý lỗi
            }
        });
        if (typeof sessionStorage !== 'undefined') {
            sessionStorage.setItem('courseId', courseId); // Lưu courseId vào session
        }
        return false;
    });
    $(document).on("click", ".bookmarked", function(){   // Xử lý sự kiện click vào nút "Bookmarked" trên trang web
        var courseId=($(this).attr('data-id'));
        var bookmarkLink = $(this);
        $.ajax({
            url: "Bookmarks/Bookmarked.php",
            type: "POST",
            data:{"courseId":courseId},
            success: function(result){
                bookmarkLink.removeClass("bookmarked");
                    bookmarkLink.addClass("bookmark");
                    bookmarkLink.removeAttr("id");
                    bookmarkLink.attr("id", "bookmark"); 
            },
            error: function(){
                // Xử lý lỗi
            }
        });
        return false;
    });
    $(document).on("click", ".ChuaDN", function(){   // Xử lý sự kiện click vào nút "JOIN" trên trang web
        alert ('Bạn phải đăng nhập để thực hiện thao tác này?');
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
