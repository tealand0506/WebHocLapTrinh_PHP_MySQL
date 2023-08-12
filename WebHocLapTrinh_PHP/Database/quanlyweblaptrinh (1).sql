-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2023 at 04:59 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlyweblaptrinh`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ID` int(11) NOT NULL,
  `TenDN` varchar(20) NOT NULL,
  `Password` char(10) NOT NULL,
  `Email` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`ID`, `TenDN`, `Password`, `Email`) VALUES
(1, 'admin', '123123', 'tealand0506@gmail.com'),
(2, 'aaa', '123123', 'aaa@gmail.com'),
(3, 'bbb', '123321', 'bbb@gmail.com'),
(4, 'abc', '123321', 'abc@gmail.com'),
(5, 'cba', '123321', 'cba@gmail.com'),
(6, 'aabbcc', '123321', 'aabbcc@gmail.com'),
(7, 'vanA', '123321', 'vanA@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `baihoc`
--

CREATE TABLE `baihoc` (
  `ID` int(11) NOT NULL,
  `MaKhoaHoc` varchar(10) NOT NULL,
  `MaBaiHoc` varchar(10) NOT NULL,
  `TenBaiHoc` varchar(255) NOT NULL,
  `DiaChi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `baihoc`
--

INSERT INTO `baihoc` (`ID`, `MaKhoaHoc`, `MaBaiHoc`, `TenBaiHoc`, `DiaChi`) VALUES
(1, 'CPP', 'CPP1', 'Giới thiệu C++', 'CPP1.php'),
(2, 'CPP', 'CPP2', 'Cài đặt môi trường phát triển (IDE) Visual studio ', 'CPP2.php'),
(3, 'CPP', 'CPP3', 'Xây dựng chương trình C++ đầu tiên với Visual Studio 2015', 'CPP3.php'),
(4, 'CPP', 'CPP4', 'Cấu trúc một chương trình C++ (Structure of a program)', 'CPP4.php'),
(5, 'CPP', 'CPP5', 'Cấu trúc một chương trình C++ (Structure of a program)', 'CPP5.php'),
(6, 'CPP', 'CPP6', 'Biến trong C++ (Variables in C++)', 'CPP6.php'),
(7, 'CPP', 'CPP7', 'Số tự nhiên và Số chấm động trong C++ (Integer, Floating point)', 'CPP7.php'),
(8, 'CPP', 'CPP8', 'Kiểu ký tự trong C++ (Character)', 'CPP8.php'),
(9, 'CPP', 'CPP9', 'Kiểu luận lý và cơ bản về Câu điều kiện If (Boolean and If statements)', 'CPP9.php'),
(10, 'CPP', 'CPP10', 'Nhập, Xuất và Định dạng dữ liệu trong C++ (Input and Output)', 'CPP10.php');

--
-- Triggers `baihoc`
--
DELIMITER $$
CREATE TRIGGER `trg_BaiHoc_Insert` BEFORE INSERT ON `baihoc` FOR EACH ROW BEGIN
    DECLARE maxMaBaiHoc VARCHAR(10);
    SELECT MAX(MaBaiHoc) INTO maxMaBaiHoc FROM BaiHoc WHERE MaKhoaHoc = NEW.MaKhoaHoc;
    IF (maxMaBaiHoc IS NULL) THEN
        SET NEW.MaBaiHoc = CONCAT(NEW.MaKhoaHoc, '1');
    ELSE
        SET NEW.MaBaiHoc = CONCAT(NEW.MaKhoaHoc, CAST(SUBSTRING(maxMaBaiHoc, LENGTH(NEW.MaKhoaHoc) + 1) AS UNSIGNED) + 1);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks_kh`
--

CREATE TABLE `bookmarks_kh` (
  `ID_KH` char(5) NOT NULL,
  `ID_User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bookmarks_kh`
--

INSERT INTO `bookmarks_kh` (`ID_KH`, `ID_User`) VALUES
('CPP', 1),
('CPP', 2),
('CPP', 3),
('CTDL', 1),
('CTDL', 2),
('CTDL', 3),
('WPF', 2);

-- --------------------------------------------------------

--
-- Table structure for table `khoahoc`
--

CREATE TABLE `khoahoc` (
  `MaKH` char(5) NOT NULL,
  `TenKH` char(50) NOT NULL,
  `DiaChi` char(20) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `HinhAnhKH` text NOT NULL,
  `NgonNgu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `khoahoc`
--

INSERT INTO `khoahoc` (`MaKH`, `TenKH`, `DiaChi`, `MoTa`, `HinhAnhKH`, `NgonNgu`) VALUES
('CPP', 'Lập trình C++ cơ bản', '', '- Bài hướng dẫn học C++ cơ bản và nâng cao này sẽ cung cấp chi tiết khái niệm về C++ từ cơ bản tới nâng cao, kèm theo các ví dụ thực hành trực tuyến đa dạng giúp bạn thích thú bài học và hiểu sâu hơn các khái niệm đã được đề cập.', 'KH_CPP2.jpg', 'Lập trình C++'),
('CS', 'Lập trình C# cơ bản', '', '- Ngôn ngữ C# là một ngôn ngữ mới, cấu trúc rõ ràng, dễ hiểu và dễ học. C# thừa hưởng những ưu việt từ ngôn ngữ Java, C, C++ cũng như khắc phục được những hạn chế của các ngôn ngữ này. C# là ngôn ngữ lập trình hướng đối tượng được phát triển bởi Microsoft, được xây dựng dựa trên C++ và Java.', 'khoahoc_cs.jpg', 'Lập trình C#'),
('CTDL', 'Cấu trúc dữ liệu & Giải thuật.', '', '- Bạn đã từng đau đầu với các cấu trúc stack, queue,.. hoặc cảm thấy cực kỳ khó khăn với các thuật toán sắp xếp, tìm kiếm được sử dụng trong lập trình. Đừng lo lắng! Trong khoá học này, chúng ta sẽ cùng nhau tìm hiểu một cách đơn giản nhất về cấu trúc dữ liệu và giải thuật, cũng như giúp bạn nắm rõ hơn về các kiến thức này.', 'KH_CTDL3.jpg', 'Lập trình C++'),
('PY', 'Lập trình Python cơ bản', '', '- Thông qua khóa học LẬP TRÌNH PYTHON CƠ BẢN, Kteam sẽ hướng dẫn các bạn kiến thức cơ bản của Python. Để từ đó, có được nền tảng cho phép bạn tiếp tục tìm hiểu những kiến thức tuyệt vời khác của Python hoặc là một ngôn ngữ khác.\r\n\r\nCụ thể trong khóa học này, Kteam sẽ giới thiệu với các bạn Python ở phiên bản Python 3.X (3.10)', 'KH_Python.png', 'Lập trình Python'),
('SQL', 'Học SQL cơ bản', '', '- SQL là viết tắt của Structured Query Language, là ngôn ngữ truy vấn mang tính cấu trúc.\r\n- Nó được thiết kế để quản lý dữ liệu trong một hệ thống quản lý cơ sở dữ liệu quan hệ (RDBMS).\r\n- SQL là ngôn ngữ cơ sở dữ liệu, được sử dụng để tạo, xóa trong cơ sở dữ liệu, lấy các hàng và sửa đổi các hàng', 'KH_SQL.png', 'Lập trình SQL'),
('WPF', 'Lập trình giao diện', '', '- Megaman X4 là một tựa game rất thú vị gắn bó với mình một thời gian dài qua điện tử bấm, khi mà máy tính hay lập trình còn là gì đó vô cùng xa vời. Mình còn nhớ nguyên mấy tháng mùa hè dí đầu dí cổ vào game để luyện tay qua màn, mãi mà không phá đảo được. Giờ vẫn còn cay! Vậy nên để thử thách bản thân, mình đã tạo ra một giải pháp giúp mình chinh phục \"giấc mơ tuổi thơ này\". Đó chính là TOOL CHEAT GAME MEGAMAN X4.', 'KH_WPF.jpg', 'Lập trình C#');

-- --------------------------------------------------------

--
-- Table structure for table `thamgia`
--

CREATE TABLE `thamgia` (
  `ID_KH_TG` char(5) NOT NULL,
  `ID_USER_TG` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `thamgia`
--

INSERT INTO `thamgia` (`ID_KH_TG`, `ID_USER_TG`) VALUES
('CPP', 1),
('CS', 2),
('CS', 3),
('CTDL', 3),
('PY', 1),
('PY', 2),
('PY', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `baihoc`
--
ALTER TABLE `baihoc`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UC_MaKhoaHoc_MaBaiHoc` (`MaKhoaHoc`,`MaBaiHoc`);

--
-- Indexes for table `bookmarks_kh`
--
ALTER TABLE `bookmarks_kh`
  ADD PRIMARY KEY (`ID_KH`,`ID_User`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `khoahoc`
--
ALTER TABLE `khoahoc`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `TenKH` (`TenKH`);

--
-- Indexes for table `thamgia`
--
ALTER TABLE `thamgia`
  ADD PRIMARY KEY (`ID_KH_TG`,`ID_USER_TG`),
  ADD KEY `ID_USER_TG` (`ID_USER_TG`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `baihoc`
--
ALTER TABLE `baihoc`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baihoc`
--
ALTER TABLE `baihoc`
  ADD CONSTRAINT `baihoc_ibfk_1` FOREIGN KEY (`MaKhoaHoc`) REFERENCES `khoahoc` (`MaKH`);

--
-- Constraints for table `bookmarks_kh`
--
ALTER TABLE `bookmarks_kh`
  ADD CONSTRAINT `bookmarks_kh_ibfk_1` FOREIGN KEY (`ID_KH`) REFERENCES `khoahoc` (`MaKH`),
  ADD CONSTRAINT `bookmarks_kh_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `account` (`ID`);

--
-- Constraints for table `thamgia`
--
ALTER TABLE `thamgia`
  ADD CONSTRAINT `thamgia_ibfk_1` FOREIGN KEY (`ID_KH_TG`) REFERENCES `khoahoc` (`MaKH`),
  ADD CONSTRAINT `thamgia_ibfk_2` FOREIGN KEY (`ID_KH_TG`) REFERENCES `khoahoc` (`MaKH`),
  ADD CONSTRAINT `thamgia_ibfk_3` FOREIGN KEY (`ID_USER_TG`) REFERENCES `account` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
