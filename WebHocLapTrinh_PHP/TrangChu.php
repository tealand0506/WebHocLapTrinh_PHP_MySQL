<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code pro</title>
    <link rel="stylesheet" href="styles_TrangChu.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<?php
    session_start();
    include 'connect/config.php';
?>

<body>
	<form name='frmTrangChu' id='frmTrangChu' method='post'>
    <div class="header" >
        <img src="images/logo2.png" >
        <div class="name" >CODE PRO</div>
        <div class="nav">
            <ul>
                <li >
                    <a href="TrangChu.php" class="active">Home</a>
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
                        echo " <a href='Profile.php' >
                        <i class='fas fa-user-circle'></i>
                        <span>".$_SESSION['username']."</span>
                        </a>
					    <ul class='sup-menu1'>  
                      <a name='HoSo' id='HoSo' href='Profile.php'><i class='fas fa-id-card'></i> <span> Hồ sơ</span></a>
                        <br>
                      <button type='submit' name='DangXuat' id='DangXuat'><i class='fa fa-sign-out'></i><span> Đăng xuất </span></button>
                      
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
                        echo "<meta http-equiv='refresh' content='0'>"; 
                        exit();
                    }    
                ?>
                </li>
            </ul>
        </div>
    </div>
    
    <script>
   
   $(document).ready(function(){
       $(document).on("click", ".join", function(){   // Xử lý sự kiện click vào nút "Bookmarked" trên trang web
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
   $(document).on("click", ".joined", function(){   // Xử lý sự kiện click vào nút "Bookmarked" trên trang web
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
});
</script>

<div class="gioithieu">
        <div class="slogan" width="100%" height="90%">
       
            <div class="box">
                <h1 class="text">"Đầu tư vào tri thức đem lại lợi nhuận cao nhất". -Benjamin Franklin</h1>
            </div>
            <i class="fa-light fa-arrow-down-to-dotted-line"></i>
            <img src="images/flatage.gif" width="100%" height="650px">
        </div>

        <div class="row giatri">
            <h1>SỨ MỆNH</h1>
            <div class="col">
                <div class="box-gt">
                    <div class="content-gt">
                        <img src="images/bg3.jpg" width="200px" height="200px">
                        <h3>Đầu tư cho tương lai</h3><br>
                        Trang bị những kiến thức, tư duy, kỹ năng số quan trọng để bắt kịp với cuộc Cách mạng Công nghệ 4.0 đang diễn ra mạnh mẽ trên khắp hành tinh.<br>
                        Nuôi dưỡng ước mơ và hứng thú với lĩnh vực công nghệ, trở thành nhà lãnh đạo công nghệ tương lai.<br>
                        An tâm theo đuổi đam mê công nghệ mà không phải lo lắng về chi phí với hình thức học.</div>
                </div>

      

            </div>
            <div class="col">
                <div class="box-gt">  
                    <div class="content-gt">
                        <img src="images/bg_1.jpg" width="200px" height="200px">
                        <h3>Thực chiến</h3><br>
                        Bài học đi kèm với bài tập thực chiến.<br>
                        Chủ đề dự án đa dạng. Bài giải và hướng dẫn cách tư duy, cách giải quyết vấn đề theo hướng mở. <br>
                        Cho người học cảm giác gặt hái được thành quả cảu học tập, cảm giác khám phá thành công điều gì đó bằng chính kiến thức mình học được.<br>
                        Đào tạo toàn diện các kỹ năng chuyên nghiệp như làm việc nhóm, tư duy sản phẩm, quy trình làm việc, v.v...></div>
                </div>
            </div>
            <div class="col">
                <div class="box-gt">
                    <div class="content-gt">
                        <img src="images/bg.jpg" width="200px" height="200px">
                        <h3>Nguồn tài liệu</h3><br>
                        Tham khảo đúc kết và chọn lọc những mấu chốt, ngắn gọn, dễ hiểu, sát thực tế.<br>
                        Đảm bảo nguồn thông tin uy tín như "CODE GYM" "CODE LEARN" "MINDX" "VIET JACK".<br>
                        Bên cạnh sứ mệnh đem đến nguồn tài nguyên học tập phong phú. CODEPRO còn chia sẻ những "BLOG", phần nào giúp bạn trog việc lựa chọn ngành nghề và hướng đi phù hợp.
                    </div>
                </div>
            </div>
        </div>





    <div class="baner-khoahoc">
         <div class="row nd"> 
            <h5 width=>Lộ trình học giúp bạn chạm tới ước mơ!<br>
                Khai phá giới hạn của bản thân<br>
                & bắt đầu sự nghiệp rực rỡ của bạn sau khi hoàn thành.</h5><br>
                <div class="cards">
                <?php
                include 'connect/config.php';
                $SQLstr_kh="Select kh.MaKH,kh.TenKH, kh.MoTa, 
                (select count(baihoc.MaKhoaHoc) from Baihoc where baihoc.MaKhoaHoc=kh.MaKH) as SL_BaiHoc,
                (select count(TG.ID_KH_TG) from ThamGia as TG where TG.ID_KH_TG=kh.MaKH) as SL_ThamGia,
                HinhAnhKH FROM KhoaHoc as kh 
                GROUP BY kh.MaKH, kh.TenKH, kh.MoTa, kh.HinhAnhKH
                ORDER BY SL_ThamGia DESC
                LIMIT 3;";//truy van 3 khoahoc co luot tham gia lon nhat -> khoa hoc noi bat
                $query_kh=mysqli_query($conn,$SQLstr_kh);
                 if(isset($_SESSION['ID_USERS']))// danh sach khoa hoc cua nguoi dung -> khi da dang nhap
                {
                    while($row_kh=mysqli_fetch_array($query_kh))
                    {
                        $SQLstr_BMed="select * from Bookmarks_KH where ID_USER=".$_SESSION['ID_USERS']." and ID_KH='".$row_kh['MaKH']."'";
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
           </div>
            <img src="images/card.jpg" width="100%" style="object-position: cover; padding: 0">
        </div>
  

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
