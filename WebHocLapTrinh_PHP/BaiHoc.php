<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code pro</title>
    <link rel="stylesheet" href="style_BaiHoc.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<?php
include 'connect/config.php';
session_start();
?>
<body>
<form name="frmBaiHoc" id="frmBaiHoc" method="post">
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

    <div class="container-fluid khoahoc">
        <div class="row">
            <div class="col-lg-3">
                <div class="mucluc" >
                    <div class="container-1" align='center'>
                        <input type="text" id="txtSearchBaiHoc" name = 'txtSearchBaiHoc' placeholder="Search..." />
                        <button type="submit" class="btnSearchBaiHoc" name='btnSearchBaiHoc' id='btnSearchBaiHoc'><i class="fa fa-search"></i></button>
                        
                    </div>
                    <ul>
                        <?php

                        if(isset($_GET['id']))
                        {        
                        $MaKH=$_GET['id'];
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
                        $sql_DSBaiHoc="select TenBaiHoc from baihoc where MaKhoaHoc='".$MaKH."' and TenBaiHoc like '%".$TuKhoa."%'";
                        $result_BaiHoc=mysqli_query($conn,$sql_DSBaiHoc);
                        if(mysqli_num_rows($result_BaiHoc)>0)
                        {
                            while($rows=mysqli_fetch_array($result_BaiHoc))
                            {
                            echo "<li>
                            <a href='#'>- ".$rows['TenBaiHoc']."</a>
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
                </div>
            </div>
            <div class='col-lg-9'>
                <p>
                    MÔ TẢ KHÓA HỌC:
                    <?php
                    $SQL_MoTa = "SELECT MoTa from KhoaHoc where MaKH = '$MaKH';";
                    $query = mysqli_query($conn,$SQL_MoTa);
                    $result=$query->fetch_assoc();
                    echo $result['MoTa'];
                    ?>
                </p>
            </div>
        </div>
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
