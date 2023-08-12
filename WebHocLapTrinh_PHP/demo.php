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

<body>
<div class="header" >
        <img src="images/logo2.png" width="50px" height="50px">
        <div class="name">CODE PRO</div>
        <div class="nav">
            <ul>
                <li >
                    <a href="TrangChu.php" class="active">Home</a>

                <li>
                    <a href="Learn.php">Learn</a> 
                    <ul class="sup-menu1">
                    
                        <?php
                        include 'connect/config.php';
                            $select_NgonNgu = "SELECT DISTINCT(NgonNgu) FROM KhoaHoc";
                            $result_NgonNgu = mysqli_query($conn, $select_NgonNgu);
                            while ($rows_NgonNgu = $result_NgonNgu->fetch_assoc()) {
                                echo "<div class='dropdown dropend' ><button type='button' align='center' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown'>
                                ".$rows_NgonNgu['NgonNgu']."
                              </button>
                                        <ul class='dropdown-menu sup-menu2'>";
                                        $select_KhoaHoc = "SELECT TenKH FROM KhoaHoc WHERE NgonNgu='" . $rows_NgonNgu['NgonNgu'] . "'";
                                        $result_KhoaHoc = mysqli_query($conn, $select_KhoaHoc);
                                        while ($rows_KhoaHoc = $result_KhoaHoc->fetch_assoc()) 
                                        {
                                            echo "<li><a href='#'>".$rows_KhoaHoc['TenKH']."</a></li>";
                                        }
                                echo "</ul></div>";
                            }
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="news.html">News</a>
                </li>
				<li >
                <a href="Profile.php" >
                    <i class="fas fa-user-tie"></i>
                    <span><?php session_start(); echo $_SESSION['username'];?></span>
                </a>
					<ul class="sup-menu1">
                        <li class="c1"><a href="DangNhap.php">Đăng nhập</a></li>
                        <div class="dropdown-divider"></div>
                        <li class="c2"><a href="DangKy.php">Đăng ký</a></li>
                    </ul>
                </li> 
            </ul>
        </div>
    </div>
    <div class="cards">
            <?php
                include 'connect/config.php';
                $SQLstr_kh="Select MaKH,TenKH, MoTa, SL_ThamGia, SL_BaiHoc, HinhAnhKH FROM KhoaHoc;";
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
                                    <img src="images/khoahoc_cs.jpg" alt="Ảnh 2" height="200px">
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
                                <img src="images/khoahoc_cs.jpg" alt="Ảnh 2" height="200px">
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
</body>
</html>