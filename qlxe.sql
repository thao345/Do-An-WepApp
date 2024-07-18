-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2024 at 08:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlxe`
--

-- --------------------------------------------------------

--
-- Table structure for table `chiphivantai`
--

CREATE TABLE `chiphivantai` (
  `id_cpvt` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `phicauduong` decimal(10,0) DEFAULT 0,
  `tienanca` decimal(10,0) DEFAULT 0,
  `luongchuyen` decimal(10,0) DEFAULT 0,
  `luongchunhat` decimal(10,0) DEFAULT 0,
  `tienthuexengoai` decimal(10,0) DEFAULT 0,
  `tongchiphi` decimal(10,0) DEFAULT 0,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chiphivantai`
--

INSERT INTO `chiphivantai` (`id_cpvt`, `id_donhang`, `phicauduong`, `tienanca`, `luongchuyen`, `luongchunhat`, `tienthuexengoai`, `tongchiphi`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(4, 29, 50000, 60000, 320000, 0, 1200000, 15836250, '', '2024-05-03 21:49:10', 5, '2024-05-29 19:27:20', 5),
(5, 3, 0, 60000, 0, 420000, 1000000, 13411250, '', '2024-05-08 21:05:31', 5, '2024-05-09 23:41:32', 3),
(6, 4, 0, 60000, 320000, 0, 3200000, 12726188, '', '2024-05-08 21:07:50', 5, '2024-05-09 23:41:53', 3),
(7, 30, 30000, 30000, 160000, 0, 0, 9762500, '', '2024-05-08 21:08:59', 5, '2024-05-09 23:41:50', 3),
(9, 33, 30000, 30000, 320000, 0, 0, 7172500, '', '2024-03-14 23:38:19', 5, '2024-05-11 23:38:41', NULL),
(12, 2, 35000, 60000, 320000, 0, 0, 6995938, 'ko có ghi chú', '2024-05-21 20:15:08', 5, '2024-05-29 20:09:46', 5),
(13, 42, 20000, 20000, 20000, 20000, 20000, 7457188, 'ko', '2024-05-23 21:21:18', 5, '2024-05-23 21:52:40', 5),
(14, 43, 20000, 60000, 320000, 0, 0, 7146188, 'ko', '2024-05-24 09:30:05', 5, '2024-05-29 19:24:06', 5),
(15, 47, 50000, 60000, 320000, 0, 0, 11676188, '', '2024-06-03 20:30:43', 5, NULL, NULL),
(16, 58, 20000, 60000, 320000, 0, 0, 12146188, '', '2024-06-09 15:54:34', 5, NULL, NULL),
(17, 57, 0, 60000, 0, 420000, 120000, 5560938, '', '2024-06-09 15:55:17', 5, NULL, NULL),
(18, 56, 70000, 60000, 320000, 0, 1200000, 8842500, '', '2024-06-09 15:55:53', 5, NULL, NULL),
(19, 55, 20000, 60000, 320000, 0, 1200000, 16781250, '', '2024-06-09 15:56:22', 5, NULL, NULL),
(20, 54, 30000, 60000, 320000, 0, 0, 6683000, '', '2024-06-09 15:56:37', 5, NULL, NULL),
(21, 53, 40000, 60000, 320000, 0, 0, 5546750, '', '2024-06-09 15:57:05', 5, NULL, NULL),
(22, 52, 60000, 60000, 320000, 0, 0, 12213000, '', '2024-06-09 15:57:18', 5, NULL, NULL),
(23, 51, 60000, 60000, 0, 420000, 0, 7100938, '', '2024-06-09 15:57:33', 5, NULL, NULL),
(24, 50, 20000, 60000, 320000, 0, 2300000, 13946188, '', '2024-06-09 15:58:12', 5, NULL, NULL),
(25, 49, 0, 60000, 320000, 0, 0, 5506750, '', '2024-06-09 15:58:32', 5, NULL, NULL),
(26, 48, 90000, 60000, 0, 420000, 0, 8362500, '', '2024-06-09 15:58:57', 5, NULL, NULL);

--
-- Triggers `chiphivantai`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_chiphivantai` AFTER DELETE ON `chiphivantai` FOR EACH ROW BEGIN
  DECLARE noidung VARCHAR(255);
 DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa chi phí vận tải:\n',
                       'Mã cpvt: ', OLD.id_cpvt, '\n',
                       'Mã đơn hàng: ', OLD.id_donhang, '\n',
                       'Phí cầu đường: ', OLD.phicauduong, '\n',
                       'Tiền ăn ca: ', OLD.tienanca,'\n',
                       'Lương chuyến: ', OLD.luongchuyen,'\n',
                       'Lương chủ nhật: ', OLD.luongchunhat,'\n',
                       'Tiền thuê xe ngoài: ', OLD.tienthuexengoai,'\n',
                       'Tổng chi phí: ', OLD.tongchiphi,'\n',
                       'Ghi chú: ', OLD.ghichu,'\n'
                       
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_chiphivantai` AFTER INSERT ON `chiphivantai` FOR EACH ROW BEGIN
  DECLARE noidung VARCHAR(255);
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm chi phí vận tải:\n',
                       'Mã cpvt: ', NEW.id_cpvt, '\n',
                       'Mã đơn hàng: ', NEW.id_donhang, '\n',
                       'Phí cầu đường: ', NEW.phicauduong, '\n',
                       'Tiền ăn ca: ', NEW.tienanca,'\n',
                       'Lương chuyến: ', NEW.luongchuyen,'\n',
                       'Lương chủ nhật: ', NEW.luongchunhat,'\n',
                       'Tiền thuê xe ngoài: ', NEW.tienthuexengoai,'\n',
                       'Tổng chi phí: ', NEW.tongchiphi,'\n',
                       'Ghi chú: ', NEW.ghichu,'\n'
                       
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_chiphivantai` AFTER UPDATE ON `chiphivantai` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
    
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

  IF OLD.id_donhang != NEW.id_donhang THEN
    SET old_values = CONCAT('\nMã đơn hàng: ', OLD.id_donhang);
    SET new_values = CONCAT('\nMã đơn hàng: ', NEW.id_donhang);
  END IF;
  
  IF OLD.phicauduong != NEW.phicauduong THEN
    SET old_values = CONCAT(old_values, '\nPhí cầu đường: ', OLD.phicauduong);
    SET new_values = CONCAT(new_values, '\nPhí cầu đường: ', NEW.phicauduong);
  END IF;
  
  IF OLD.tienanca != NEW.tienanca THEN
    SET old_values = CONCAT(old_values, '\nTiền ăn ca: ', OLD.tienanca);
    SET new_values = CONCAT(new_values, '\nTiền ăn ca: ', NEW.tienanca);
  END IF;
  
  IF OLD.luongchuyen != NEW.luongchuyen THEN
    SET old_values = CONCAT(old_values, '\nLương chuyến: ', OLD.luongchuyen);
    SET new_values = CONCAT(new_values, '\nLương chuyến: ', NEW.luongchuyen);
  END IF;
  
  IF OLD.luongchunhat != NEW.luongchunhat THEN
    SET old_values = CONCAT(old_values, '\nLương chủ nhật: ', OLD.luongchunhat);
    SET new_values = CONCAT(new_values, '\nLương chủ nhật: ', NEW.luongchunhat);
  END IF;
  
  IF OLD.tienthuexengoai != NEW.tienthuexengoai THEN
    SET old_values = CONCAT(old_values, '\nTiền thuê xe ngoài: ', OLD.tienthuexengoai);
    SET new_values = CONCAT(new_values, '\nTiền thuê xe ngoài: ', NEW.tienthuexengoai);
  END IF;
  
  IF OLD.tongchiphi != NEW.tongchiphi THEN
    SET old_values = CONCAT(old_values, '\nTổng chi phí: ', OLD.tongchiphi);
    SET new_values = CONCAT(new_values, '\nTổng chi phí: ', NEW.tongchiphi);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;
 
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chitietdonhangtamung`
--

CREATE TABLE `chitietdonhangtamung` (
  `id_ctdhtu` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `ngaytamung` date NOT NULL,
  `id_nhansu` int(11) NOT NULL,
  `tiencuocvo` decimal(10,0) DEFAULT 0,
  `tienhaiquan` decimal(10,0) DEFAULT 0,
  `tiennangha` decimal(10,0) DEFAULT 0,
  `tienkhac` decimal(10,0) DEFAULT 0,
  `ngaythanhtoan` date DEFAULT NULL,
  `giothanhtoan` time DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `anh1` varchar(255) DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chitietdonhangtamung`
--

INSERT INTO `chitietdonhangtamung` (`id_ctdhtu`, `id_donhang`, `ngaytamung`, `id_nhansu`, `tiencuocvo`, `tienhaiquan`, `tiennangha`, `tienkhac`, `ngaythanhtoan`, `giothanhtoan`, `ghichu`, `anh1`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(6, 2, '2024-05-17', 1, 0, 1200000, 0, 320000, '2024-05-20', '00:00:00', '                  ', 'anhhoanung1.jpg', '2024-05-20 18:30:45', 5, '2024-05-08 15:37:17', 3),
(7, 4, '2024-03-15', 3, 1000000, 0, 1400000, 0, '2024-03-20', '00:00:00', '  ', 'anhhoanung2.jpg', '2024-03-19 20:52:53', 5, '2024-05-08 15:10:23', 3),
(9, 29, '2024-03-23', 3, 0, 0, 2300000, 450000, '2024-03-29', '00:00:00', '', 'anhhoanung2.jpg', '2024-03-28 14:32:29', 5, '2024-05-08 15:10:34', NULL),
(10, 3, '2024-05-08', 1, 1000000, 700000, 1200000, 350000, '2024-05-17', '00:00:00', '  Xe bị hỏng giữa đường', 'anhhoanung1.jpg', '2024-05-17 14:39:13', 5, '2024-05-08 15:36:50', 3),
(12, 33, '2024-03-14', 1, 0, 0, 0, 1500000, '2024-03-17', NULL, NULL, NULL, '2024-03-15 23:28:14', 5, '2024-05-12 00:30:11', NULL),
(13, 30, '2024-05-08', 3, 2300000, 0, 1200000, 0, '0000-00-00', '12:07:00', 'ko có ', 'anhhoanung1.jpg', '2024-05-17 23:07:25', 7, NULL, NULL),
(14, 42, '2024-05-23', 31, 400000, 300000, 200000, 100000, '2024-05-23', '00:00:00', ' ko', 'anhhoanung2.jpg', '2024-05-23 20:54:04', 5, '2024-05-23 21:00:01', 5),
(15, 43, '2024-05-24', 1, 0, 0, 1500000, 0, '2024-05-25', '00:00:00', ' ', 'anhhoanung2.jpg', '2024-05-24 09:34:21', 5, '2024-05-24 09:34:45', 5),
(17, 47, '2024-06-03', 1, 0, 0, 1500000, 0, '0000-00-00', '00:00:00', '', '', '2024-06-03 22:32:11', 5, NULL, NULL),
(18, 58, '2024-06-09', 34, 0, 0, 1500000, 0, '2024-06-15', '00:00:00', '', 'anhhoanung1.jpg', '2024-06-09 15:40:17', 5, NULL, NULL),
(19, 57, '2024-06-10', 1, 0, 0, 0, 400000, '2024-06-14', '00:00:00', '', 'anhhoanung2.jpg', '2024-06-09 15:40:54', 5, NULL, NULL),
(20, 56, '2024-06-09', 33, 400000, 0, 1500000, 0, '2024-06-09', '00:00:00', '', 'anhhoanung1.jpg', '2024-06-09 15:41:45', 5, NULL, NULL),
(21, 55, '2024-06-09', 3, 1000000, 0, 1500000, 0, '2024-06-09', '00:00:00', '', 'anhhoanung2.jpg', '2024-06-09 15:42:16', 5, NULL, NULL),
(22, 52, '2024-06-09', 31, 0, 1000000, 1500000, 0, '2024-06-09', '15:45:00', ' ', 'anhhoanung2.jpg', '2024-06-09 15:43:01', 5, '2024-06-09 15:59:56', 5);

--
-- Triggers `chitietdonhangtamung`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_chitietdonhangtamung` AFTER DELETE ON `chitietdonhangtamung` FOR EACH ROW BEGIN
  DECLARE noidung VARCHAR(255);
 
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa tạm ứng:\n',
                       'Mã tạm ứng: ', OLD.id_ctdhtu, '\n',
                       'Mã đơn hàng: ', OLD.id_donhang, '\n',
                       'Ngày tạm ứng: ', OLD.ngaytamung, '\n',
                       'Mã nhân sự tạm ứng: ', OLD.id_nhansu,'\n',
                       'Tiền cước vỏ: ', OLD.tiencuocvo,'\n',
                       'Tiền hải quan: ', OLD.tienhaiquan,'\n',
                       'Tiền nâng hạ: ', OLD.tiennangha,'\n',
                       'Tiền khác: ', OLD.tienkhac,'\n',
                       'Ngày thanh toán: ', OLD.ngaythanhtoan,'\n',
                       'Giờ thanh toán: ', OLD.giothanhtoan,'\n',
                       'Ghi chú: ', OLD.ghichu,
                       'Ảnh: ', OLD.anh1
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_chitietdonhangtamung` AFTER INSERT ON `chitietdonhangtamung` FOR EACH ROW BEGIN
  DECLARE noidung VARCHAR(255);
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

   SET noidung = CONCAT('Thêm tạm ứng:\n',
                       'Mã tạm ứng: ', NEW.id_ctdhtu, '\n',
                       'Mã đơn hàng: ', NEW.id_donhang, '\n',
                       'Ngày tạm ứng: ', NEW.ngaytamung, '\n',
                       'Mã nhân sự tạm ứng: ', NEW.id_nhansu,'\n',
                       'Tiền cước vỏ: ', NEW.tiencuocvo,'\n',
                       'Tiền hải quan: ', NEW.tienhaiquan,'\n',
                       'Tiền nâng hạ: ', NEW.tiennangha,'\n',
                       'Tiền khác: ', NEW.tienkhac,'\n',
                       'Ngày thanh toán: ', NEW.ngaythanhtoan,'\n',
                       'Giờ thanh toán: ', NEW.giothanhtoan,'\n',
                       'Ghi chú: ', NEW.ghichu,
                       'Ảnh: ', NEW.anh1
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_chitietdonhangtamung` AFTER UPDATE ON `chitietdonhangtamung` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
   
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

  IF OLD.id_donhang != NEW.id_donhang THEN
    SET old_values = CONCAT('\nMã đơn hàng: ', OLD.id_donhang);
    SET new_values = CONCAT('\nMã đơn hàng: ', NEW.id_donhang);
  END IF;
  
  IF OLD.ngaytamung != NEW.ngaytamung THEN
    SET old_values = CONCAT(old_values, '\nNgày tạm ứng: ', OLD.ngaytamung);
    SET new_values = CONCAT(new_values, '\nNgày tạm ứng: ', NEW.ngaytamung);
  END IF;
  
  IF OLD.id_nhansu != NEW.id_nhansu THEN
    SET old_values = CONCAT(old_values, '\nMã nhân sự: ', OLD.id_nhansu);
    SET new_values = CONCAT(new_values, '\nMã nhân sự: ', NEW.id_nhansu);
  END IF;
  
  IF OLD.tiencuocvo != NEW.tiencuocvo THEN
    SET old_values = CONCAT(old_values, '\nTiền cước vỏ: ', OLD.tiencuocvo);
    SET new_values = CONCAT(new_values, '\nTiền cước vỏ: ', NEW.tiencuocvo);
  END IF;
  
  IF OLD.tienhaiquan != NEW.tienhaiquan THEN
    SET old_values = CONCAT(old_values, '\nTiền hải quan: ', OLD.tienhaiquan);
    SET new_values = CONCAT(new_values, '\nTiền hải quan: ', NEW.tienhaiquan);
  END IF;
  
  IF OLD.tiennangha != NEW.tiennangha THEN
    SET old_values = CONCAT(old_values, '\nTiền nâng hạ: ', OLD.tiennangha);
    SET new_values = CONCAT(new_values, '\nTiền nâng hạ: ', NEW.tiennangha);
  END IF;
  
  IF OLD.tienkhac != NEW.tienkhac THEN
    SET old_values = CONCAT(old_values, '\nTiền khác: ', OLD.tienkhac);
    SET new_values = CONCAT(new_values, '\nTiền khác: ', NEW.tienkhac);
  END IF;
  
  IF OLD.ngaythanhtoan != NEW.ngaythanhtoan THEN
    SET old_values = CONCAT(old_values, '\nNgày thanh toán: ', OLD.ngaythanhtoan);
    SET new_values = CONCAT(new_values, '\nNgày thanh toán: ', NEW.ngaythanhtoan);
  END IF;
  
  IF OLD.giothanhtoan != NEW.giothanhtoan THEN
    SET old_values = CONCAT(old_values, '\nGiờ thanh toán: ', OLD.giothanhtoan);
    SET new_values = CONCAT(new_values, '\nGiờ thanh toán: ', NEW.giothanhtoan);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;

   IF OLD.anh1 != NEW.anh1 THEN
    SET old_values = CONCAT(old_values, '\nẢnh: ', OLD.anh1);
    SET new_values = CONCAT(new_values, '\nẢnh: ', NEW.anh1);
  END IF;
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `chucnang`
--

CREATE TABLE `chucnang` (
  `id_chucnang` int(11) NOT NULL,
  `tenchucnang` varchar(50) NOT NULL,
  `trangthai` enum('true','false') NOT NULL DEFAULT 'true',
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chucnang`
--

INSERT INTO `chucnang` (`id_chucnang`, `tenchucnang`, `trangthai`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(4, 'donhang', 'true', '2024-03-11 13:56:32', 3, '2024-03-11 13:56:46', 2),
(5, 'dieuvan', 'true', '2024-05-15 20:09:33', 5, NULL, NULL),
(6, 'baocaothongke', 'true', '2024-05-15 20:09:37', 5, NULL, NULL),
(8, 'dashboard', 'true', '2024-05-17 18:18:54', 5, NULL, NULL),
(9, 'hethong', 'true', '2024-05-17 18:19:00', 5, NULL, NULL),
(10, 'danhmucdulieu', 'true', '2024-05-17 18:19:08', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dieuhanh`
--

CREATE TABLE `dieuhanh` (
  `id_dieuhanh` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `id_thauphu` varchar(255) NOT NULL,
  `masothue` varchar(255) NOT NULL,
  `tenthauphu` varchar(255) NOT NULL,
  `id_xe` int(11) NOT NULL,
  `id_taixe` varchar(255) NOT NULL,
  `dienthoai` int(11) NOT NULL,
  `tinhtrangdonhang` enum('Đơn','Kết hợp') NOT NULL,
  `sodonkethop` int(11) DEFAULT 0,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dieuhanh`
--

INSERT INTO `dieuhanh` (`id_dieuhanh`, `id_donhang`, `id_thauphu`, `masothue`, `tenthauphu`, `id_xe`, `id_taixe`, `dienthoai`, `tinhtrangdonhang`, `sodonkethop`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(2, 29, 'GPT-F', '0201255664', ' Công ty CP Vận tải Đối tác Toàn Cầu', 5, 'NgocDoan', 1299825, 'Kết hợp', 1, '', '2024-05-25 20:11:25', 5, '2024-05-08 20:33:28', 3),
(4, 4, 'GPT-F', '0201255664', ' Công ty CP Vận tải Đối tác Toàn Cầu', 5, 'QuocDanh', 321456, 'Kết hợp', 1, '', '2024-05-28 19:15:11', 5, '2024-05-28 19:25:00', 3),
(6, 3, 'GPT-F', '0201255664', 'Công ty CP Vận tải Đối tác Toàn Cầu', 5, 'QuocDanh', 321456, 'Kết hợp', 1, '', '2024-05-08 20:33:05', 5, NULL, NULL),
(7, 33, 'PLJ-L', '0201249276', ' Công ty CP Tiếp vận Thái Bình Dương', 3, 'AnhSon', 123456, 'Đơn', 0, NULL, '2024-03-14 23:32:34', 5, NULL, NULL),
(10, 2, 'PLJ-L', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 6, 'DoVuong', 1234569999, 'Đơn', 0, 'Vận chuyển trước ngày 15/04/2024', '2024-05-17 23:29:01', 7, NULL, NULL),
(11, 30, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 2, 'HoangBao', 2147483647, 'Đơn', 0, 'ko', '2024-05-21 20:32:16', 5, NULL, NULL),
(13, 42, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'HoangBao', 2147483647, 'Đơn', 0, '', '2024-05-22 21:10:45', 5, '2024-05-22 21:15:57', 5),
(14, 43, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 2, 'HoangBao', 2147483647, 'Đơn', 0, 'kkkk', '2024-05-24 09:24:36', 5, '2024-05-24 09:37:09', 5),
(15, 47, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'BuiChien', 2147483647, 'Đơn', 0, '', '2024-06-03 20:29:34', 5, NULL, NULL),
(16, 58, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'HoangBao', 335124471, 'Đơn', 0, 'Hạ lạch huyện trước ngày 15/6', '2024-06-09 15:35:41', 5, NULL, NULL),
(17, 57, 'CTY-L', '0201734748', 'Công ty CP City Delivery ', 11, 'NhatBao', 123456779, 'Kết hợp', 1, '', '2024-06-09 15:36:44', 5, NULL, NULL),
(18, 56, 'GPT-F', '0201255664', 'Công ty CP Vận tải Đối tác Toàn Cầu', 5, 'NgocDoan', 339527171, 'Kết hợp', 1, '', '2024-06-09 15:37:13', 5, NULL, NULL),
(19, 55, 'GPT-F', '0201255664', 'Công ty CP Vận tải Đối tác Toàn Cầu', 5, 'NgocDoan', 339527171, 'Kết hợp', 1, '', '2024-06-09 15:37:31', 5, NULL, NULL),
(20, 54, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'BuiChien', 331247891, 'Đơn', 0, '', '2024-06-09 15:37:48', 5, NULL, NULL),
(21, 53, 'PLJ-L', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 6, 'DoVuong', 339527143, 'Đơn', 0, '', '2024-06-09 15:38:03', 5, NULL, NULL),
(22, 52, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'HoangBao', 335124471, 'Đơn', 0, '', '2024-06-09 15:38:21', 5, NULL, NULL),
(23, 51, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'BuiChien', 331247891, 'Đơn', 0, '', '2024-06-09 15:38:42', 5, NULL, NULL),
(24, 50, 'GPT-F', '0201255664', 'Công ty CP Vận tải Đối tác Toàn Cầu', 1, 'QuocDanh', 339452748, 'Kết hợp', 1, '', '2024-06-09 15:39:10', 5, NULL, NULL),
(25, 49, 'PLJ-L', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 6, 'DoVuong', 339527143, 'Đơn', 0, '', '2024-06-09 15:39:29', 5, NULL, NULL),
(26, 48, 'PLJ-F', '0201249276', 'Công ty CP Tiếp vận Thái Bình Dương', 4, 'HoangBao', 335124471, 'Đơn', 0, '', '2024-06-09 15:39:45', 5, NULL, NULL);

--
-- Triggers `dieuhanh`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_dieuvan` AFTER DELETE ON `dieuhanh` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
 
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa điều vận:\n',
                       'Mã điều vận: ', OLD.id_dieuhanh, '\n',
                       'Mã đơn hàng: ', OLD.id_donhang, '\n',
                       'Mã thầu phụ: ', OLD.id_thauphu, '\n',
                       'Mã số thuế: ', OLD.masothue,'\n',
                       'Tên thầu phụ: ', OLD.tenthauphu,'\n',
                       'Mã xe: ', OLD.id_xe,'\n',
                       'Mã tài xế: ', OLD.id_taixe,'\n',
                       'Điện thoại tài xế: ', OLD.dienthoai,'\n',
                       'Tình trạng đơn hàng: ', OLD.tinhtrangdonhang,'\n',
                       'Số đơn kết hợp: ', OLD.sodonkethop,'\n'
                     
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_dieuvan` AFTER INSERT ON `dieuhanh` FOR EACH ROW BEGIN

  DECLARE noidung TEXT DEFAULT '';
 
  DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm điều vận:\n',
                       'Mã điều vận: ', NEW.id_dieuhanh, '\n',
                       'Mã đơn hàng: ', NEW.id_donhang, '\n',
                       'Mã thầu phụ: ', NEW.id_thauphu, '\n',
                       'Mã số thuế: ', NEW.masothue,'\n',
                       'Tên thầu phụ: ', NEW.tenthauphu,'\n',
                       'Mã xe: ', NEW.id_xe,'\n',
                       'Mã tài xế: ', NEW.id_taixe,'\n',
                       'Điện thoại tài xế: ', NEW.dienthoai,'\n',
                       'Tình trạng đơn hàng: ', NEW.tinhtrangdonhang,'\n',
                       'Số đơn kết hợp: ', NEW.sodonkethop,'\n'
                     
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_dieuhanh` AFTER UPDATE ON `dieuhanh` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
   
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

  IF OLD.id_donhang != NEW.id_donhang THEN
    SET old_values = CONCAT('\nMã đơn hàng: ', OLD.id_donhang);
    SET new_values = CONCAT('\nMã đơn hàng: ', NEW.id_donhang);
  END IF;
  
  IF OLD.id_thauphu != NEW.id_thauphu THEN
    SET old_values = CONCAT(old_values, '\nMã thầu phụ: ', OLD.id_thauphu);
    SET new_values = CONCAT(new_values, '\nMã thầu phụ: ', NEW.id_thauphu);
  END IF;
  
  IF OLD.masothue != NEW.masothue THEN
    SET old_values = CONCAT(old_values, '\nMã số thuế: ', OLD.masothue);
    SET new_values = CONCAT(new_values, '\nMã số thuế: ', NEW.masothue);
  END IF;
  
  IF OLD.tenthauphu != NEW.tenthauphu THEN
    SET old_values = CONCAT(old_values, '\nTên thầu phụ: ', OLD.tenthauphu);
    SET new_values = CONCAT(new_values, '\nTên thầu phụ: ', NEW.tenthauphu);
  END IF;
  
  IF OLD.id_xe != NEW.id_xe THEN
    SET old_values = CONCAT(old_values, '\nMã xe: ', OLD.id_xe);
    SET new_values = CONCAT(new_values, '\nMã xe: ', NEW.id_xe);
  END IF;
  
  IF OLD.id_taixe != NEW.id_taixe THEN
    SET old_values = CONCAT(old_values, '\nMã tài xế: ', OLD.id_taixe);
    SET new_values = CONCAT(new_values, '\nMã tài xế: ', NEW.id_taixe);
  END IF;
  
  IF OLD.dienthoai != NEW.dienthoai THEN
    SET old_values = CONCAT(old_values, '\nĐiện thoại tài xế: ', OLD.dienthoai);
    SET new_values = CONCAT(new_values, '\nĐiện thoại tài xế: ', NEW.dienthoai);
  END IF;
  
  IF OLD.tinhtrangdonhang != NEW.tinhtrangdonhang THEN
    SET old_values = CONCAT(old_values, '\nTình trạng đơn hàng: ', OLD.tinhtrangdonhang);
    SET new_values = CONCAT(new_values, '\nTình trạng đơn hàng: ', NEW.tinhtrangdonhang);
  END IF;
  
  IF OLD.sodonkethop != NEW.sodonkethop THEN
    SET old_values = CONCAT(old_values, '\nSố đơn kết hợp: ', OLD.sodonkethop);
    SET new_values = CONCAT(new_values, '\nSố đơn kết hợp: ', NEW.sodonkethop);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin điều vận:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `id_donhang` int(11) NOT NULL,
  `id_sales` int(11) NOT NULL,
  `id_khachhang` varchar(255) NOT NULL,
  `masothue` varchar(255) NOT NULL,
  `booking` varchar(255) NOT NULL,
  `loaihang` enum('1','2','3') NOT NULL,
  `id_hangtau` varchar(255) DEFAULT NULL,
  `id_nhomhanghoa` varchar(255) NOT NULL,
  `id_hanghoa` varchar(255) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 1,
  `sokg` float NOT NULL,
  `trangthai` enum('Hủy','Hoàn thành') DEFAULT NULL,
  `ngaydongcontainer` date NOT NULL,
  `giodongcontainer` time DEFAULT NULL,
  `id_tuyenvantai` varchar(255) NOT NULL,
  `culy` float NOT NULL,
  `dautieuthu` float NOT NULL,
  `ngaycatmang` date NOT NULL,
  `giocatmang` time DEFAULT NULL,
  `nguoigiaonhan` varchar(255) NOT NULL,
  `dienthoai` varchar(255) NOT NULL,
  `giacuoc` decimal(10,0) DEFAULT NULL,
  `thuthutuc` decimal(10,0) DEFAULT NULL,
  `thukhac` decimal(10,0) DEFAULT NULL,
  `hanthanhtoan` date NOT NULL,
  `ghichu` text DEFAULT NULL,
  `anh1` varchar(255) DEFAULT NULL,
  `anh2` varchar(255) DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`id_donhang`, `id_sales`, `id_khachhang`, `masothue`, `booking`, `loaihang`, `id_hangtau`, `id_nhomhanghoa`, `id_hanghoa`, `soluong`, `sokg`, `trangthai`, `ngaydongcontainer`, `giodongcontainer`, `id_tuyenvantai`, `culy`, `dautieuthu`, `ngaycatmang`, `giocatmang`, `nguoigiaonhan`, `dienthoai`, `giacuoc`, `thuthutuc`, `thukhac`, `hanthanhtoan`, `ghichu`, `anh1`, `anh2`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(2, 3, 'GLS', '0304995011-001', 'bk11', '3', '', 'LCL', '1.5T', 1, 10000, 'Hoàn thành', '2024-04-05', '20:08:35', 'ADHP', 25, 3.125, '2024-04-05', '20:22:53', 'ngọc', '097766', 0, 200000, 0, '2024-04-05', 'ko có', '', '', '2024-05-05 12:29:34', 5, '2024-05-17 23:47:24', 3),
(3, 3, 'APL', '0304675075', 'bk133', '2', '', 'FCL', '20RF', 1, 12000, 'Hoàn thành', '2024-04-05', '20:08:35', 'ANBD', 1100, 137.5, '2024-04-05', '20:22:53', 'vân', '097766', 0, 340000, 30000, '2024-04-05', '', '', '', '2024-05-14 12:29:34', 5, '2024-05-17 23:47:19', 3),
(4, 1, 'APT', '0202169016', 'BK78NMN12', '2', 'Evergreen', 'FCL', '40HC', 1, 13000, 'Hoàn thành', '2024-04-12', '09:05:00', 'VPHN', 101, 12.625, '2024-04-15', '12:06:00', 'Đỗ Khải Hoàn', '0123965881-0339685441 ', 0, 220000, 100000, '2024-04-15', '', 'số booking.jpg', 'Screenshot 2024-03-18 144222.png', '2024-05-12 20:18:24', 5, '2024-05-22 23:01:01', 3),
(17, 1, 'EXP', '0312545104-001', 'BK980EXP', '2', '', 'FCL', '40HC', 1, 8600, 'Hủy', '2024-04-14', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Nguyễn Khang', '0156988522', 0, 350000, 120000, '2024-04-18', '', '', '', '2024-05-22 19:46:42', 5, '2024-05-21 20:29:19', 5),
(29, 1, 'APT', '0202169016', 'BK78NMNZZZZZ', '2', '', 'FCL', '20RF', 1, 13500, 'Hoàn thành', '2024-04-24', '06:02:00', 'ANBD', 1100, 137.5, '0000-00-00', '00:03:00', 'Trần Quốc Chung', '0126664889', 0, 120000, 0, '2024-05-04', 'ko', 'hóa đơn dịch vụ gia tăng.png', 'biên lai thu tiền phí.png', '2024-05-24 21:38:07', 5, '2024-05-18 00:27:27', 7),
(30, 1, 'EXP', '0312545104-001', 'BK980EXP', '1', NULL, 'FCL', '20RF', 1, 11500, 'Hoàn thành', '2024-05-08', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Nguyễn Khang', '0156988522', 0, 120000, 0, '2024-05-11', '', '', '', '2024-05-08 19:46:42', 5, '2024-05-08 15:20:23', NULL),
(32, 31, 'EXP', '0312545104-001', 'BK980EXP', '3', '', 'LCL', '2.5T', 1, 5600, 'Hủy', '2024-04-14', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Nguyễn Khang', '0156988522', 0, 240000, 100000, '2024-04-18', '', '', '', '2024-05-22 19:46:42', 5, '2024-05-21 19:37:50', 5),
(33, 3, 'EXP', '0312545104-001', 'BK980EXP', '3', '', 'LCL', '2.5T', 1, 10000, 'Hoàn thành', '2024-03-14', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Nguyễn Khang', '0156988522', 0, 240000, 100000, '2024-03-16', '', '', '', '2024-03-13 19:46:42', 5, '2024-05-23 22:40:10', NULL),
(42, 3, 'GLS', '0304995011-001', 'FNBK98', '2', 'Evergreen', 'FCL', '40HC', 1, 12222, 'Hoàn thành', '2024-05-22', '00:00:00', 'VPHN', 101, 12.625, '2024-05-24', '00:00:00', 'ddd', '012444442', 0, 123332, 123333, '2024-05-22', 'đ', 'booking notice.jpg', 'logo-rm.png', '2024-05-22 11:28:14', 5, '2024-05-23 22:40:30', 5),
(43, 3, 'APT', '0202169016', 'CN5555', '2', '', 'FCL', '40HC', 1, 10000, 'Hoàn thành', '2024-05-24', '00:00:00', 'VPHN', 101, 12.625, '2024-05-24', '00:00:00', 'gggg', '011111', 0, 11111, 222222, '2024-05-28', 'ko', '', '', '2024-05-24 09:20:35', 5, '2024-05-24 09:36:37', 5),
(47, 1, 'GLS', '0304995011-001', 'BKONCE134', '2', '', 'FCL', '40HC', 1, 20000, 'Hoàn thành', '2024-06-03', '00:00:00', 'VPHN', 101, 12.625, '2024-06-07', '00:00:00', 'Trần Quốc Chung', '0123336544', 0, 0, 0, '2024-06-20', '', 'booking notice.jpg', '', '2024-06-03 20:29:11', 5, '2024-06-03 21:01:27', 5),
(48, 33, 'HXC-L', '0200727995', 'BK1239N4', '2', 'Evergreen', 'FCL', '20RF', 1, 15000, 'Hoàn thành', '2024-06-09', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Hoàng Huy', '0339521547', 0, 100000, 150000, '2024-06-14', '', '', '', '2024-06-09 15:05:50', 5, NULL, NULL),
(49, 31, 'ANT', '0109193913', 'BK76FB', '3', '', 'LCL', '2.5T', 1, 10000, 'Hoàn thành', '2024-06-01', '00:00:00', 'CHPNS', 52, 6.5, '0000-00-00', '00:00:00', 'Trần Quốc Chung', '0126664889', 0, 0, 200000, '2024-06-23', '', '', '', '2024-06-09 15:08:06', 5, NULL, NULL),
(50, 3, 'EXP', '0312545104-001', 'Bk864GHD', '1', '', 'FCL', '40HC', 1, 22000, 'Hoàn thành', '2024-06-06', '15:14:00', 'VPHN', 101, 12.625, '2024-06-09', '00:00:00', 'Đỗ Khải Hoàn', '', 0, 120000, 0, '2024-06-27', '', '', '', '2024-06-09 15:12:53', 5, NULL, NULL),
(51, 1, 'APT', '0202169016', 'BKND96765F', '3', '', 'FCL', '20RF', 1, 13000, 'Hoàn thành', '2024-06-09', '00:00:00', 'ADHP', 25, 3.125, '2024-06-09', '00:00:00', 'Nguyễn Khang', '0126664889', 0, 0, 100000, '2024-06-29', '', '', '', '2024-06-09 15:15:14', 5, NULL, NULL),
(52, 1, 'APT', '0202169016', 'HANA07129400', '2', 'HMM', 'FCL', '40HC', 1, 20000, 'Hoàn thành', '2024-06-09', '00:00:00', 'BDHP', 112, 14, '2024-06-09', '00:00:00', 'Ngọc Đinh', '0129857444', 0, 100000, 0, '2024-06-28', '', 'booking notice.jpg', 'phiếu giao nhận container điện tử.jpg', '2024-06-09 15:23:11', 5, NULL, NULL),
(53, 1, 'HXC-L', '0200727995', 'BK78NMN12NN', '3', '', 'LCL', '1.5T', 1, 10000, 'Hoàn thành', '2024-06-09', '00:00:00', 'CHPNS', 52, 6.5, '2024-06-09', '00:00:00', 'Hoàng Thiên', '0339527489', 0, 0, 210000, '2024-06-29', '', '', '', '2024-06-09 15:24:29', 5, NULL, NULL),
(54, 34, 'DKC', '0201861009', 'BK980EXPAA', '1', '', 'FCL', '20RF', 1, 12000, 'Hoàn thành', '2024-06-08', '00:00:00', 'BDHP', 112, 14, '2024-06-09', '00:00:00', 'Đỗ Khải Hoàn', '0126664889', 0, 120000, 0, '2024-06-30', '', '', '', '2024-06-09 15:25:43', 5, NULL, NULL),
(55, 33, 'EXP', '0312545104-001', 'BK78NMNZ', '2', 'Maersk', 'FCL', '40HC', 1, 20000, 'Hoàn thành', '2024-06-01', '00:00:00', 'ANBD', 1100, 137.5, '2024-06-09', '00:00:00', 'Nguyễn Khang', '0126664889', 0, 122000, 210000, '2024-06-30', '', '', '', '2024-06-09 15:27:06', 5, NULL, NULL),
(56, 3, 'NCC00399', '27007413', 'BK56PL', '1', '', 'FCL', '20RF', 1, 10000, 'Hoàn thành', '2024-06-01', '00:00:00', 'ĐĐHN', 120, 15, '2024-06-05', '00:00:00', 'Vũ Văn Chiến', '0126664889', 0, 0, 410000, '2024-06-21', '', '', '', '2024-06-09 15:28:23', 5, NULL, NULL),
(57, 33, 'DKC', '0201861009', 'BK78NMNS', '3', '', 'LCL', '2.5T', 1, 9000, 'Hoàn thành', '2024-06-09', '18:28:00', 'ADHP', 25, 3.125, '2024-06-09', '22:32:00', 'Đỗ Khải Hoàn', '0126664889', 0, 0, 100000, '2024-06-29', '', '', '', '2024-06-09 15:29:34', 5, NULL, NULL),
(58, 3, 'HHH', '0304948188-001', 'BK56PL22', '1', '', 'FCL', '40HC', 1, 20000, 'Hoàn thành', '2024-06-01', '00:00:00', 'VPHN', 101, 12.625, '2024-06-05', '15:32:00', 'Trần Quốc', '0126664889', 0, 0, 210000, '2024-06-30', '', '', '', '2024-06-09 15:30:38', 5, NULL, NULL),
(59, 34, 'DKC', '0201861009', 'BK56PL', '3', '', 'LCL', '2.5T', 1, 10000, 'Hủy', '2024-06-09', '00:00:00', 'ĐĐHN', 120, 15, '0000-00-00', '00:00:00', 'Trần Quốc Chung', '', 0, 0, 0, '2024-06-29', '', '', '', '2024-06-09 16:51:52', 5, '2024-06-09 16:51:58', 5);

--
-- Triggers `donhang`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_donhang` AFTER DELETE ON `donhang` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa đơn hàng:\n',
  
                        'Mã đơn hàng: ', OLD.id_donhang, '\n',
                       'Mã nhân viên sale: ', OLD.id_sales, '\n',
                       'Mã khách hàng: ', OLD.id_khachhang, '\n',
                       'Mã số thuế: ', OLD.masothue,'\n',
                       'Tên khách hàng: ', OLD.booking,'\n',
                       'Loại hàng: ', OLD.loaihang,'\n',
                       'Hãng tàu: ', OLD.id_hangtau,'\n',
                       'Nhóm hàng hóa: ', OLD.id_nhomhanghoa,'\n',
                       'Hàng hóa: ', OLD.id_hanghoa,'\n',
                       'Số lượng: ', OLD.soluong,'\n',
                       'Số kg: ', OLD.sokg,'\n',
                       'Trạng thái: ', OLD.trangthai,'\n',
                       'Ngày đóng cont: ', OLD.ngaydongcontainer,'\n',
                       'Giờ đóng cont: ', OLD.giodongcontainer,'\n',
                       'Mã tuyến vận tải: ', OLD.id_tuyenvantai,'\n',
                       'Cự ly: ', OLD.culy,'\n',
                       'Dầu tiêu thụ: ', OLD.dautieuthu,'\n',
                        'Ngày cắt máng: ', OLD.ngaycatmang,'\n',
                       'Giờ cắt máng: ', OLD.giocatmang,'\n',
                       'Người giao nhận: ', OLD.nguoigiaonhan,'\n',
                       'Điện thoại: ', OLD.dienthoai,'\n',
                       'Thu thủ tục: ', OLD.thuthutuc,'\n',
                       'Thu khác: ', OLD.thukhac,'\n',
                       'Hạn thanh toán: ', OLD.hanthanhtoan,'\n',
                       'Ảnh 1: ', OLD.anh1,'\n',
                       'Ảnh 2: ', OLD.anh2
                       
                       
                      
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_donhang` AFTER INSERT ON `donhang` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm đơn hàng:\n',
  
                        'Mã đơn hàng: ', NEW.id_donhang, '\n',
                       'Mã nhân viên sale: ', NEW.id_sales, '\n',
                       'Mã khách hàng: ', NEW.id_khachhang, '\n',
                       'Mã số thuế: ', NEW.masothue,'\n',
                       'Tên khách hàng: ', NEW.booking,'\n',
                       'Loại hàng: ', NEW.loaihang,'\n',
                       'Hãng tàu: ', NEW.id_hangtau,'\n',
                       'Nhóm hàng hóa: ', NEW.id_nhomhanghoa,'\n',
                       'Hàng hóa: ', NEW.id_hanghoa,'\n',
                       'Số lượng: ', NEW.soluong,'\n',
                       'Số kg: ', NEW.sokg,'\n',
                       'Trạng thái: ', NEW.trangthai,'\n',
                       'Ngày đóng cont: ', NEW.ngaydongcontainer,'\n',
                       'Giờ đóng cont: ', NEW.giodongcontainer,'\n',
                       'Mã tuyến vận tải: ', NEW.id_tuyenvantai,'\n',
                       'Cự ly: ', NEW.culy,'\n',
                       'Dầu tiêu thụ: ', NEW.dautieuthu,'\n',
                        'Ngày cắt máng: ', NEW.ngaycatmang,'\n',
                       'Giờ cắt máng: ', NEW.giocatmang,'\n',
                       'Người giao nhận: ', NEW.nguoigiaonhan,'\n',
                       'Điện thoại: ', NEW.dienthoai,'\n',
                       'Thu thủ tục: ', NEW.thuthutuc,'\n',
                       'Thu khác: ', NEW.thukhac,'\n',
                       'Hạn thanh toán: ', NEW.hanthanhtoan,'\n',
                       'Ảnh 1: ', NEW.anh1,'\n',
                       'Ảnh 2: ', NEW.anh2
                       
                      
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_donhang` AFTER UPDATE ON `donhang` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
    -- Lấy thông tin về người sửa từ bảng nhansu
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

  IF OLD.id_sales != NEW.id_sales THEN
    SET old_values = CONCAT('\nMã nhân viên sale: ', OLD.id_sales);
    SET new_values = CONCAT('\nMã nhân viên sale: ', NEW.id_sales);
  END IF;
  
  IF OLD.id_khachhang != NEW.id_khachhang THEN
    SET old_values = CONCAT(old_values, '\nMã  khách hàng: ', OLD.id_khachhang);
    SET new_values = CONCAT(new_values, '\nMã  khách hàng: ', NEW.id_khachhang);
  END IF;
  
  IF OLD.masothue != NEW.masothue THEN
    SET old_values = CONCAT(old_values, '\nMã số thuế: ', OLD.masothue);
    SET new_values = CONCAT(new_values, '\nMã số thuế: ', NEW.masothue);
  END IF;
  
  IF OLD.booking != NEW.booking THEN
    SET old_values = CONCAT(old_values, '\nSố booking: ', OLD.booking);
    SET new_values = CONCAT(new_values, '\nSố booking: ', NEW.booking);
  END IF;
  
  IF OLD.loaihang != NEW.loaihang THEN
    SET old_values = CONCAT(old_values, '\nLoại hàng: ', OLD.loaihang);
    SET new_values = CONCAT(new_values, '\nLoại hàng: ', NEW.loaihang);
  END IF;
  
  IF OLD.id_hangtau != NEW.id_hangtau THEN
    SET old_values = CONCAT(old_values, '\nHãng tàu: ', OLD.id_hangtau);
    SET new_values = CONCAT(new_values, '\nHãng tàu: ', NEW.id_hangtau);
  END IF;
  
  IF OLD.id_nhomhanghoa != NEW.id_nhomhanghoa THEN
    SET old_values = CONCAT(old_values, '\nNhóm hàng hóa: ', OLD.id_nhomhanghoa);
    SET new_values = CONCAT(new_values, '\nNhóm hàng hóa: ', NEW.id_nhomhanghoa);
  END IF;
 
 IF OLD.id_hanghoa != NEW.id_hanghoa THEN
    SET old_values = CONCAT(old_values, '\nHàng hóa: ', OLD.id_hanghoa);
    SET new_values = CONCAT(new_values, '\nHàng hóa: ', NEW.id_hanghoa);
  END IF;
  
 IF OLD.soluong != NEW.soluong THEN
    SET old_values = CONCAT(old_values, '\nSố lượng: ', OLD.soluong);
    SET new_values = CONCAT(new_values, '\nSố lượng: ', NEW.soluong);
  END IF;

   IF OLD.sokg != NEW.sokg THEN
    SET old_values = CONCAT(old_values, '\nSố kg: ', OLD.sokg);
    SET new_values = CONCAT(new_values, '\nSố kg: ', NEW.sokg);
  END IF;

  IF OLD.trangthai != NEW.trangthai THEN
    SET old_values = CONCAT(old_values, '\nTrạng thái: ', OLD.trangthai);
    SET new_values = CONCAT(new_values, '\nTrạng thái: ', NEW.trangthai);
  END IF;

  IF OLD.ngaydongcontainer != NEW.ngaydongcontainer THEN
    SET old_values = CONCAT(old_values, '\nNgày đóng cont: ', OLD.ngaydongcontainer);
    SET new_values = CONCAT(new_values, '\nNgày đóng cont: ', NEW.ngaydongcontainer);
  END IF;

  IF OLD.giodongcontainer != NEW.giodongcontainer THEN
    SET old_values = CONCAT(old_values, '\nGiờ đóng cont: ', OLD.giodongcontainer);
    SET new_values = CONCAT(new_values, '\nGiờ đóng cont: ', NEW.giodongcontainer);
  END IF;

  IF OLD.id_tuyenvantai != NEW.id_tuyenvantai THEN
    SET old_values = CONCAT(old_values, '\nMã tuyến vận tải: ', OLD.id_tuyenvantai);
    SET new_values = CONCAT(new_values, '\nMã tuyến vận tải: ', NEW.id_tuyenvantai);
  END IF;

  IF OLD.culy != NEW.culy THEN
    SET old_values = CONCAT(old_values, '\nCự ly: ', OLD.culy);
    SET new_values = CONCAT(new_values, '\nCự ly: ', NEW.culy);
  END IF;

  IF OLD.dautieuthu != NEW.dautieuthu THEN
    SET old_values = CONCAT(old_values, '\nDầu tiêu thụ: ', OLD.dautieuthu);
    SET new_values = CONCAT(new_values, '\nDầu tiêu thụ: ', NEW.dautieuthu);
  END IF;

  IF OLD.ngaycatmang != NEW.ngaycatmang THEN
    SET old_values = CONCAT(old_values, '\nNgày cắt máng: ', OLD.ngaycatmang);
    SET new_values = CONCAT(new_values, '\nNgày cắt máng: ', NEW.ngaycatmang);
  END IF;

  IF OLD.giocatmang != NEW.giocatmang THEN
    SET old_values = CONCAT(old_values, '\nGiờ cắt máng: ', OLD.giocatmang);
    SET new_values = CONCAT(new_values, '\nGiờ cắt máng: ', NEW.giocatmang);
  END IF;

  IF OLD.nguoigiaonhan != NEW.nguoigiaonhan THEN
    SET old_values = CONCAT(old_values, '\nNgười giao nhận: ', OLD.nguoigiaonhan);
    SET new_values = CONCAT(new_values, '\nNgười giao nhận: ', NEW.nguoigiaonhan);
  END IF;

  IF OLD.dienthoai != NEW.dienthoai THEN
    SET old_values = CONCAT(old_values, '\nĐiện thoại giao nhận: ', OLD.dienthoai);
    SET new_values = CONCAT(new_values, '\nĐiện thoại giao nhận: ', NEW.dienthoai);
  END IF;

  IF OLD.giacuoc != NEW.giacuoc THEN
    SET old_values = CONCAT(old_values, '\nGiá cước: ', OLD.giacuoc);
    SET new_values = CONCAT(new_values, '\nGiá cước: ', NEW.giacuoc);
  END IF;

  IF OLD.thuthutuc != NEW.thuthutuc THEN
    SET old_values = CONCAT(old_values, '\nThu thủ tục: ', OLD.thuthutuc);
    SET new_values = CONCAT(new_values, '\nThu thủ tục: ', NEW.thuthutuc);
  END IF;

  IF OLD.thukhac != NEW.thukhac THEN
    SET old_values = CONCAT(old_values, '\nThu khác: ', OLD.thukhac);
    SET new_values = CONCAT(new_values, '\nThu khác: ', NEW.thukhac);
  END IF;

  IF OLD.hanthanhtoan != NEW.hanthanhtoan THEN
    SET old_values = CONCAT(old_values, '\nHạn thanh toán: ', OLD.hanthanhtoan);
    SET new_values = CONCAT(new_values, '\nHạn thanh toán: ', NEW.hanthanhtoan);
  END IF;

  IF OLD.anh1 != NEW.anh1 THEN
    SET old_values = CONCAT(old_values, '\nẢnh: ', OLD.anh1);
    SET new_values = CONCAT(new_values, '\nẢnh: ', NEW.anh1);
  END IF;

  IF OLD.anh2 != NEW.anh2 THEN
    SET old_values = CONCAT(old_values, '\nẢnh 2: ', OLD.anh2);
    SET new_values = CONCAT(new_values, '\nẢnh 2: ', NEW.anh2);
  END IF;
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donvicungcapdau`
--

CREATE TABLE `donvicungcapdau` (
  `id_donviccdau` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donvicungcapdau`
--

INSERT INTO `donvicungcapdau` (`id_donviccdau`, `ten`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('HFC', 'CÔNG TY CỔ PHẦN XĂNG DẦU HFC HẢI PHÒNG', '2024-03-11 16:08:33', 3, NULL, NULL),
('KVNS', 'CÔNG TY TNHH THƯƠNG MẠI VÀ KHO VẬN NĂM SAO', '2024-03-11 16:08:33', 3, '2024-04-08 16:24:52', NULL);

--
-- Triggers `donvicungcapdau`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_dvccd` AFTER DELETE ON `donvicungcapdau` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa đơn vị cung cấp dầu:\n',
  
                        'Mã ĐVCCD: ', OLD.id_donviccdau, '\n',
                       'Tên: ', OLD.ten, '\n'
                      
                      );

 INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_dvccd` AFTER INSERT ON `donvicungcapdau` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm đơn vị cung cấp dầu:\n',
  
                        'Mã ĐVCCD: ', NEW.id_donviccdau, '\n',
                       'Tên: ', NEW.ten, '\n'
                      
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_dvccd` AFTER UPDATE ON `donvicungcapdau` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên DVCCD: ', OLD.ten);
    SET new_values = CONCAT('\nTên DVCCD: ', NEW.ten);
  END IF;
  
  
  

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin DVCCD:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hanghoa`
--

CREATE TABLE `hanghoa` (
  `id_hanghoa` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `id_nhomhanghoa` varchar(255) NOT NULL,
  `kichthuoc` decimal(10,1) DEFAULT NULL,
  `donvitinh` varchar(255) DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hanghoa`
--

INSERT INTO `hanghoa` (`id_hanghoa`, `ten`, `id_nhomhanghoa`, `kichthuoc`, `donvitinh`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('1.5T', 'Truck 1.5T', 'LCL', NULL, NULL, NULL, '2024-03-11 15:39:57', 3, NULL, NULL),
('2.5T', 'Truck 2.5T', 'LCL', NULL, NULL, NULL, '2024-03-11 15:39:57', 3, NULL, NULL),
('20RF', 'Cont 20RF', 'FCL', NULL, NULL, NULL, '2024-03-11 15:39:57', 3, NULL, NULL),
('40HC', 'Cont 40HC', 'FCL', NULL, NULL, NULL, '2024-03-11 15:39:57', 3, NULL, NULL);

--
-- Triggers `hanghoa`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_hanghoa` AFTER DELETE ON `hanghoa` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa hàng hóa:\n',
  
                        'Mã hàng hóa: ', OLD.id_hanghoa, '\n',
                       'Tên hàng hóa: ', OLD.ten, '\n',
                       'Mã nhóm hàng hóa: ', OLD.id_nhomhanghoa, '\n',
                       'Kích thước: ', OLD.kichthuoc,'\n',
                       'Đơn vị tính: ', OLD.donvitinh,'\n',
                       'Ghi chú: ', OLD.ghichu,'\n'
                       
                      );
INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_hanghoa` AFTER INSERT ON `hanghoa` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm hàng hóa:\n',
  
                        'Mã hàng hóa: ', NEW.id_hanghoa, '\n',
                       'Tên hàng hóa: ', NEW.ten, '\n',
                       'Mã nhóm hàng hóa: ', NEW.id_nhomhanghoa, '\n',
                       'Kích thước: ', NEW.kichthuoc,'\n',
                       'Đơn vị tính: ', NEW.donvitinh,'\n',
                       'Ghi chú: ', NEW.ghichu,'\n'
                       
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_hanghoa` AFTER UPDATE ON `hanghoa` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên hàng hóa: ', OLD.ten);
    SET new_values = CONCAT('\nTên hàng hóa: ', NEW.ten);
  END IF;
  
  IF OLD.id_nhomhanghoa != NEW.id_nhomhanghoa THEN
    SET old_values = CONCAT(old_values, '\nMã nhóm hàng hóa: ', OLD.id_nhomhanghoa);
    SET new_values = CONCAT(new_values, '\nMã nhóm hàng hóa: ', NEW.id_nhomhanghoa);
  END IF;
  
  IF OLD.kichthuoc != NEW.kichthuoc THEN
    SET old_values = CONCAT(old_values, '\nKích thước: ', OLD.kichthuoc);
    SET new_values = CONCAT(new_values, '\nKích thước: ', NEW.kichthuoc);
  END IF;
  
  IF OLD.donvitinh != NEW.donvitinh THEN
    SET old_values = CONCAT(old_values, '\nĐơn vị tính: ', OLD.donvitinh);
    SET new_values = CONCAT(new_values, '\nĐơn vị tính: ', NEW.donvitinh);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;

  
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin hàng hóa:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hangtau`
--

CREATE TABLE `hangtau` (
  `id_hangtau` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hangtau`
--

INSERT INTO `hangtau` (`id_hangtau`, `ten`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('Apectrans', 'Apectrans', '2024-06-09 15:19:57', 5, NULL, NULL),
('CMA-CGM', 'CMA-CGM', '2024-06-09 15:19:07', 5, NULL, NULL),
('COSCO', 'COSCO', '2024-05-03 19:55:05', 2, NULL, NULL),
('Evergreen', 'Evergreen', '2024-03-26 16:49:29', 3, NULL, NULL),
('Hải An', 'Hải An', '2024-06-09 15:19:43', 5, NULL, NULL),
('HMM', 'HMM', '2024-06-09 15:20:44', 5, NULL, NULL),
('Macs', 'Macs', '2024-06-09 15:19:31', 5, NULL, NULL),
('Maersk', 'Maersk', '2024-06-09 15:17:42', 5, NULL, NULL),
('OOCL', 'OOCL', '2024-06-09 15:18:51', 5, NULL, NULL),
('Tân Cảng SG', 'Tân Cảng SG', '2024-06-09 15:19:19', 5, NULL, NULL);

--
-- Triggers `hangtau`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_hangtau` AFTER DELETE ON `hangtau` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa hãng tàu:\n',
  
                        'Mã hãng tàu: ', OLD.id_hangtau, '\n',
                       'Tên hãng tàu: ', OLD.ten, '\n'
                      
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_hangtau` AFTER INSERT ON `hangtau` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm hãng tàu:\n',
  
                        'Mã hãng tàu: ', NEW.id_hangtau, '\n',
                       'Tên hãng tàu: ', NEW.ten, '\n'
                      
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_hangtau` AFTER UPDATE ON `hangtau` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên hãng tàu: ', OLD.ten);
    SET new_values = CONCAT('\nTên hãng tàu: ', NEW.ten);
  END IF;
  
 

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin hãng tàu:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `id_khachhang` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodienthoai` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `masothue` varchar(255) NOT NULL,
  `tennganhang` varchar(255) DEFAULT NULL,
  `stk` varchar(255) DEFAULT NULL,
  `nguoidaidien` varchar(255) NOT NULL,
  `sđtgiaonhan` varchar(255) DEFAULT NULL,
  `id_tuyenvantai` varchar(255) DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`id_khachhang`, `ten`, `diachi`, `sodienthoai`, `email`, `masothue`, `tennganhang`, `stk`, `nguoidaidien`, `sđtgiaonhan`, `id_tuyenvantai`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('ANT', 'CÔNG TY CỔ PHẦN CHUYỂN HÀNG NHANH ANTS', 'Số 8 ngõ 309 đường Nguyễn Đức Thuận, Thị trấn Trâu Quỳ, Huyện Gia Lâm, TP. Hà Nội, Việt Nam', '', '', '0109193913', 'Ngân hàng BIDV- Chi nhánh Từ Liêm', '21710000664353', 'Ông Hoàng Cao Thế', '', 'ADHP', '2024-06-09 14:46:41', 5, NULL, NULL),
('APL', 'Công ty TNHH APL Logistics Việt Nam', 'P709, nhà D5C- Ð.Nguyễn Phong Sắc(kéo dài)- P.Dịch Vọng Hậu- Hà Đông-Hà Nội', '0304675075', NULL, '0304675075', 'Ngân hàng Agribank CN Tây Hà Nội.', '1480 201 013 088', 'Đỗ Nhật Bảo', NULL, 'VPHN', '2024-04-03 10:31:27', 5, '2024-04-12 11:19:02', NULL),
('APT', 'CÔNG TY TNHH GIAO NHẬN VẬN TẢI VÀ THƯƠNG MẠI QUỐC TẾ AN PHÁT', 'Số 11A9/64/476 Chợ Hàng, Phường Dư Hàng Kênh, Quận Lê Chân, Thành phố', '', NULL, '0202169016', NULL, NULL, '', NULL, 'ADHP', '2024-04-12 11:06:58', 5, NULL, NULL),
('DKC', 'Công Ty TNHH và Giao Nhận Vận tải Đức Khánh', 'số 135+136 lô 9 tái định cư,Phường Đằng Hải, Hải An ,HP', '', '', '0201861009', '', '', 'Mr Khánh', '', 'ADHP', '2024-06-09 14:47:13', 5, NULL, NULL),
('EXP', '  Chi nhánh Công ty TNHH Expeditors Việt Nam - CN Hà Nội', 'Tầng 10, tòa nhà TNR Tower, số 54A, đường Nguyễn Chí Thanh, Phường Láng Thượng, Quận Đống Đa, Hà Nội', '08-39621968', '', '0312545104-001', '', '', 'Ngô Ngọc Vân', '0996587566', 'ĐĐHN', '2024-04-22 19:43:39', 5, '2024-05-23 22:32:52', 5),
('GLS', 'CN CÔNG TY TNHH DỊCH VỤ TIẾP VẬN TOÀN CẦU', 'Số 67 đường Ngô Quyền, Phường Máy Chai, Quận Ngô Quyền, TP. Hải Phòng, Việt Nam', '(028) 6264 8989', NULL, '0304995011-001', 'Tại Ngân Hàng TMCP Phương Đông, SGD Tp. HCM', '0100.1000.3206.4002 ', 'Trần Văn Thưởng', NULL, 'ADHP', '2024-04-03 10:31:27', 5, NULL, NULL),
('HHH', 'CHI NHÁNH CÔNG TY CỔ PHẦN HÀNG HẢI TIÊU ĐIỂM TẠI HÀ NỘI', 'Số 1A-A1 Phố Thái Thịnh, Phường Láng Hạ, Quận Đống Đa, Thành phố Hà Nội, Việt Nam', '', '', '0304948188-001', '', '', 'Bà Nhật Anh', '', 'VPHN', '2024-06-09 14:48:13', 5, NULL, NULL),
('HXC-L', 'Công ty CP Thương mại Hoàng Xuân', 'Số 16 lô E ngõ tập thể 19/5 đường Lê Thánh Tông, Phường Máy Tơ, Quận Ngô Quyền, Hải Phòng', '', '', '0200727995', '', '', 'Ông Bùi Việt Hoàn', '', 'ADHP', '2024-06-09 14:49:03', 5, NULL, NULL),
('NCC00399', 'CÔNG TY TNHH VẬN TẢI HOÀNG BẢO HUY', '106 Tuệ Tĩnh, Phường Nam Thành, TP Ninh Bình, Tỉnh Ninh Bình, Việt Nam', '', '', '27007413', 'Ngân hàng TM CP Ngoại thương Việt Nam- Chi Nhánh Ninh Bình', '0221000014389', 'Mr Tiến Trễ', '', 'ANBD', '2024-06-09 14:49:59', 5, NULL, NULL);

--
-- Triggers `khachhang`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_khachhang` AFTER DELETE ON `khachhang` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa khách hàng:\n',
  
                        'Mã đơn hàng: ', OLD.id_khachhang, '\n',
                       'Mã nhân viên sale: ', OLD.ten, '\n',
                       'Mã khách hàng: ', OLD.diachi, '\n',
                       'Mã số thuế: ', OLD.sodienthoai,'\n',
                       'Tên khách hàng: ', OLD.email,'\n',
                       'Loại hàng: ', OLD.masothue,'\n',
                       'Hãng tàu: ', OLD.tennganhang,'\n',
                       'Nhóm hàng hóa: ', OLD.stk ,'\n',
                       'Hàng hóa: ', OLD.nguoidaidien,'\n',
                       'Số lượng: ', OLD.sđtgiaonhan,'\n',
                       'Số kg: ', OLD.id_tuyenvantai
                      
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_khachhang` BEFORE INSERT ON `khachhang` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm khách hàng:\n',
  
                        'Mã đơn hàng: ', NEW.id_khachhang, '\n',
                       'Mã nhân viên sale: ', NEW.ten, '\n',
                       'Mã khách hàng: ', NEW.diachi, '\n',
                       'Mã số thuế: ', NEW.sodienthoai,'\n',
                       'Tên khách hàng: ', NEW.email,'\n',
                       'Loại hàng: ', NEW.masothue,'\n',
                       'Hãng tàu: ', NEW.tennganhang,'\n',
                       'Nhóm hàng hóa: ', NEW.stk ,'\n',
                       'Hàng hóa: ', NEW.nguoidaidien,'\n',
                       'Số lượng: ', NEW.sđtgiaonhan,'\n',
                       'Số kg: ', NEW.id_tuyenvantai
                      
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_khachhang` AFTER UPDATE ON `khachhang` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên khách hàng: ', OLD.ten);
    SET new_values = CONCAT('\nTên khách hàng: ', NEW.ten);
  END IF;
  
  IF OLD.diachi != NEW.diachi THEN
    SET old_values = CONCAT(old_values, '\nĐịa chỉ: ', OLD.diachi);
    SET new_values = CONCAT(new_values, '\nĐịa chỉ: ', NEW.diachi);
  END IF;
  
  IF OLD.sodienthoai != NEW.sodienthoai THEN
    SET old_values = CONCAT(old_values, '\nSố đt: ', OLD.sodienthoai);
    SET new_values = CONCAT(new_values, '\nSố đt: ', NEW.sodienthoai);
  END IF;
  
  IF OLD.email != NEW.email THEN
    SET old_values = CONCAT(old_values, '\nEmail: ', OLD.email);
    SET new_values = CONCAT(new_values, '\nEmail: ', NEW.email);
  END IF;
  
  IF OLD.masothue != NEW.masothue THEN
    SET old_values = CONCAT(old_values, '\nMã số thuế: ', OLD.masothue);
    SET new_values = CONCAT(new_values, '\nMã số thuế: ', NEW.masothue);
  END IF;
  
  IF OLD.tennganhang != NEW.tennganhang THEN
    SET old_values = CONCAT(old_values, '\nTên ngân hàng: ', OLD.tennganhang);
    SET new_values = CONCAT(new_values, '\nTên ngân hàng: ', NEW.tennganhang);
  END IF;
  
  IF OLD.stk != NEW.stk THEN
    SET old_values = CONCAT(old_values, '\nSố tài khoản: ', OLD.stk);
    SET new_values = CONCAT(new_values, '\nSố tài khoản: ', NEW.stk);
  END IF;
  
  IF OLD.nguoidaidien != NEW.nguoidaidien THEN
    SET old_values = CONCAT(old_values, '\nNgười địa diện: ', OLD.nguoidaidien);
    SET new_values = CONCAT(new_values, '\nNgười địa diện: ', NEW.nguoidaidien);
  END IF;
  
  IF OLD.sđtgiaonhan != NEW.sđtgiaonhan THEN
    SET old_values = CONCAT(old_values, '\nSđt giao nhận: ', OLD.sđtgiaonhan);
    SET new_values = CONCAT(new_values, '\nSđt giao nhận: ', NEW.sđtgiaonhan);
  END IF;
  
  IF OLD.id_tuyenvantai != NEW.id_tuyenvantai THEN
    SET old_values = CONCAT(old_values, '\nMã tuyến vận tải: ', OLD.id_tuyenvantai);
    SET new_values = CONCAT(new_values, '\nMã tuyến vận tải: ', NEW.id_tuyenvantai);
  END IF;

   

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin khách hàng:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lichtrinh`
--

CREATE TABLE `lichtrinh` (
  `id_lichtrinh` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `loaihang` enum('1','2','3') NOT NULL,
  `id_nhomhanghoa` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichtrinh`
--

INSERT INTO `lichtrinh` (`id_lichtrinh`, `ten`, `loaihang`, `id_nhomhanghoa`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('01-FCL-01', 'Vào cảng', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-02', 'Lấy cont', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-03', 'Rời cảng', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-04', 'Vào nhà máy', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-05', 'Trả hàng', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-06', 'Rời nhà máy', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-07', 'Vào cảng/bãi', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-08', 'Hạ cont', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-FCL-09', 'Rời cảng/bãi', '1', 'FCL', '2024-03-11 16:53:15', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-01', 'Vào kho', '1', 'LCL', '2024-03-11 16:27:13', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-02', 'Lấy hàng', '1', 'LCL', '2024-03-11 16:27:13', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-03', 'Rời kho', '1', 'LCL', '2024-03-11 16:46:06', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-04', 'Vào nhà máy', '1', 'LCL', '2024-03-11 16:46:06', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-05', 'Trả hàng', '1', 'LCL', '2024-03-11 16:49:41', 3, '2024-03-12 14:47:02', NULL),
('01-LCL-06', 'Rời nhà máy', '1', 'LCL', '2024-03-11 16:49:41', 3, '2024-03-12 14:47:02', NULL),
('02-FCL-01', 'Vào cảng/bãi', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:49:37', NULL),
('02-FCL-02', 'Lấy cont', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-03', 'Rời cảng/bãi', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-05-06 22:24:11', NULL),
('02-FCL-04', 'Vào nhà máy', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-05', 'Đóng hàng', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-06', 'Rời nhà máy', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-07', 'Vào cảng/bãi', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-08', 'Hạ cont', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-FCL-09', 'Rời cảng/bãi', '2', 'FCL', '2024-03-12 14:36:07', 3, '2024-03-12 14:50:15', NULL),
('02-LCL-01', 'Vào nhà máy', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:47:02', NULL),
('02-LCL-02', 'Lấy hàng', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:47:02', NULL),
('02-LCL-03', 'Rời nhà máy', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:47:02', NULL),
('02-LCL-04', 'Vào kho', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:47:02', NULL),
('02-LCL-05', 'Trả hàng', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:47:02', NULL),
('02-LCL-06', 'Rời kho', '2', 'LCL', '2024-03-11 16:58:12', 3, '2024-03-12 14:49:13', NULL),
('03-FCL-01', 'Đến nơi lấy cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-FCL-02', 'Lấy cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-FCL-03', 'Rời nơi lấy cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-FCL-04', 'Đến nơi hạ cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-FCL-05', 'Hạ cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-FCL-06', 'Rời nơi hạ cont', '3', 'FCL', '2024-03-12 14:41:20', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-01', 'Đến nơi lấy hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-02', 'Lấy hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-03', 'Rời nơi lấy hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-04', 'Đến nơi trả hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-05', 'Trả hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL),
('03-LCL-06', 'Rời nơi trả hàng', '3', 'LCL', '2024-03-12 14:39:12', 3, '2024-03-12 14:50:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id_nguoidung` int(11) NOT NULL,
  `tendangnhap` varchar(50) NOT NULL,
  `matkhau` varchar(50) NOT NULL,
  `trangthai` enum('true','false') NOT NULL DEFAULT 'true',
  `isadmin` enum('true','false') NOT NULL DEFAULT 'false',
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`id_nguoidung`, `tendangnhap`, `matkhau`, `trangthai`, `isadmin`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(2, 'hoang.long123', '1234', 'true', 'false', '2024-03-05 14:54:30', 3, '2024-03-28 14:36:32', NULL),
(3, 'sales.ngocvan', '123', 'true', 'false', '2024-03-05 15:09:42', 3, '2024-05-17 19:17:03', 3),
(5, 'admin', '123', 'true', 'true', '2024-03-13 15:20:35', 3, '2024-05-17 18:07:57', 3),
(7, 'ktoan.ngocthu', '1234', 'true', 'false', '2024-05-15 20:10:44', 5, '2024-05-20 19:23:52', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nhansu`
--

CREATE TABLE `nhansu` (
  `id_auto_increment` int(11) NOT NULL,
  `id_nhansu` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `tenphongban` varchar(255) NOT NULL,
  `chucvu` varchar(255) NOT NULL,
  `nguyenquan` varchar(255) DEFAULT NULL,
  `diachithuongtru` varchar(255) DEFAULT NULL,
  `ngaysinh` date DEFAULT NULL,
  `cmnd` varchar(255) DEFAULT NULL,
  `sđt` varchar(255) NOT NULL,
  `stk` varchar(255) NOT NULL,
  `tennganhang` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhansu`
--

INSERT INTO `nhansu` (`id_auto_increment`, `id_nhansu`, `ten`, `tenphongban`, `chucvu`, `nguyenquan`, `diachithuongtru`, `ngaysinh`, `cmnd`, `sđt`, `stk`, `tennganhang`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(1, '01.ktoan.LinhThuy', 'Đoàn Linh Thùy', 'Phòng kế toán', 'Kế toán', NULL, 'Hoà Nghĩa, Dương Kinh, Hải Phòng', NULL, NULL, '01234566', '1008282133', 'Sacombank', '2024-03-11 16:20:19', 3, '2024-04-04 18:44:56', NULL),
(2, '02.LX0002', 'Nguyễn Văn Sáng', 'Lái xe container', 'LXC', 'Tam Kỳ, Kim Thành, Hải Dương', 'Đa Phúc - Dương Kinh', '2024-04-25', '01233435445', '012345555', '1009113638', 'vietinbank', '2024-03-11 16:20:19', 3, '2024-04-09 09:43:38', 3),
(3, '03.sales.ngocvan', 'Ngọc Vân', 'Phòng chăm sóc khách hàng', 'Chăm sóc khách hàng', NULL, NULL, NULL, NULL, '0122364', '11236544', 'Vietcombank', '2024-03-13 10:08:14', 3, '2024-04-04 18:44:56', NULL),
(31, '31.sales.Hthao', 'Hoàng Văn Thảo', 'Chăm sóc khách hàng', 'Sales', 'Đông Lãm, Đa Phúc, Dương Kinh', 'Đông Lãm, Đa Phúc, Dương Kinh', '1999-08-23', '01233435445', '01233435445', '01233435445', 'techcombank', '2024-04-23 10:10:37', 5, NULL, NULL),
(33, '33.sales.DangAnh', 'Đặng Châu Anh', 'Phòng Chăm sóc khách hàng', 'Chăm sóc khách hàng', 'Thanh Oai, Hà Nội', 'Số 4 Lạch Tray, Lạch Tray, Ngô Quyền, Hải Phòng', '1998-06-09', '031198001512', '0799219368', '8623800464', 'sacombank', '2024-06-09 14:53:27', 5, NULL, NULL),
(34, '34.ktoan.HaPhuong', 'Phạm Thị Hà Phương', 'phòng kế toán', 'kế toán', 'Đông Hưng, Thái Bình', '16/727 Ngô Gia Tự, Phường Đằng lâm, Quận Hải An, HP', '1999-12-09', '031193000760', '0338968584', '8407485842', 'techcombank', '2024-06-09 14:54:45', 5, NULL, NULL);

--
-- Triggers `nhansu`
--
DELIMITER $$
CREATE TRIGGER `nhansu_uniqueMaNS_insert` BEFORE INSERT ON `nhansu` FOR EACH ROW BEGIN
    DECLARE auto_increment_val INT;
    SET auto_increment_val = (SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'nhansu');
    SET NEW.id_nhansu = CONCAT(LPAD(auto_increment_val, 2, '0'), '.', NEW.id_nhansu);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_delete_nhansu` AFTER DELETE ON `nhansu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  -- Lấy thông tin về người sửa từ bảng nhansu
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa nhân sự:\n',
                       'Mã nhân sự: ', OLD.id_nhansu, '\n',
                       'Tên: ', OLD.ten, '\n',
                       'Phòng ban: ', OLD.tenphongban, '\n',
                       'Chức vụ: ', OLD.chucvu,'\n',
                       'Nguyên quán: ', OLD.nguyenquan,'\n',
                       'Địa chỉ thường trú: ', OLD.diachithuongtru,'\n',
                       'Ngày sinh: ', OLD.ngaysinh,'\n',
                       'CMND: ', OLD.cmnd,'\n',
                       'SĐT: ', OLD.sđt,'\n',
                       'STK: ', OLD.stk,'\n',
                       'Tên NH: ', OLD.tennganhang
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_nhansu` AFTER INSERT ON `nhansu` FOR EACH ROW BEGIN
  DECLARE noidung VARCHAR(255);
  -- Lấy thông tin về người tạo từ bảng nhansu
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm nhân sự:\n',
                       'Mã nhân sự: ', NEW.id_nhansu, '\n',
                       'Tên: ', NEW.ten, '\n',
                       'Phòng ban: ', NEW.tenphongban, '\n',
                       'Chức vụ: ', NEW.chucvu,'\n',
                       'Nguyên quán: ', NEW.nguyenquan,'\n',
                       'Địa chỉ thường trú: ', NEW.diachithuongtru,'\n',
                       'Ngày sinh: ', NEW.ngaysinh,'\n',
                       'CMND: ', NEW.cmnd,'\n',
                       'SĐT: ', NEW.sđt,'\n',
                       'STK: ', NEW.stk,'\n',
                       'Tên NH: ', NEW.tennganhang
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_nhansu` AFTER UPDATE ON `nhansu` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
    -- Lấy thông tin về người sửa từ bảng nhansu
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

  IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên: ', OLD.ten);
    SET new_values = CONCAT('\nTên: ', NEW.ten);
  END IF;
  
  IF OLD.tenphongban != NEW.tenphongban THEN
    SET old_values = CONCAT(old_values, '\nTên phòng ban: ', OLD.tenphongban);
    SET new_values = CONCAT(new_values, '\nTên phòng ban: ', NEW.tenphongban);
  END IF;
  
  IF OLD.chucvu != NEW.chucvu THEN
    SET old_values = CONCAT(old_values, '\nChức vụ: ', OLD.chucvu);
    SET new_values = CONCAT(new_values, '\nChức vụ: ', NEW.chucvu);
  END IF;
  
  IF OLD.nguyenquan != NEW.nguyenquan THEN
    SET old_values = CONCAT(old_values, '\nNguyên quán: ', OLD.nguyenquan);
    SET new_values = CONCAT(new_values, '\nNguyên quán: ', NEW.nguyenquan);
  END IF;
  
  IF OLD.diachithuongtru != NEW.diachithuongtru THEN
    SET old_values = CONCAT(old_values, '\nĐịa chỉ thường trú: ', OLD.diachithuongtru);
    SET new_values = CONCAT(new_values, '\nĐịa chỉ thường trú: ', NEW.diachithuongtru);
  END IF;
  
  IF OLD.ngaysinh != NEW.ngaysinh THEN
    SET old_values = CONCAT(old_values, '\nNgày sinh: ', OLD.ngaysinh);
    SET new_values = CONCAT(new_values, '\nNgày sinh: ', NEW.ngaysinh);
  END IF;
  
  IF OLD.cmnd != NEW.cmnd THEN
    SET old_values = CONCAT(old_values, '\nCMND: ', OLD.cmnd);
    SET new_values = CONCAT(new_values, '\nCMND: ', NEW.cmnd);
  END IF;
  
  IF OLD.sđt != NEW.sđt THEN
    SET old_values = CONCAT(old_values, '\nSĐT: ', OLD.sđt);
    SET new_values = CONCAT(new_values, '\nSĐT: ', NEW.sđt);
  END IF;
  
  IF OLD.stk != NEW.stk THEN
    SET old_values = CONCAT(old_values, '\nSTK: ', OLD.stk);
    SET new_values = CONCAT(new_values, '\nSTK: ', NEW.stk);
  END IF;
  
  IF OLD.tennganhang != NEW.tennganhang THEN
    SET old_values = CONCAT(old_values, '\nTên NH: ', OLD.tennganhang);
    SET new_values = CONCAT(new_values, '\nTên NH: ', NEW.tennganhang);
  END IF;
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin nhân sự:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `nhatky`
--

CREATE TABLE `nhatky` (
  `id_nhatky` int(11) NOT NULL,
  `id_nguoidung` int(11) NOT NULL,
  `thoigian` datetime NOT NULL,
  `noidung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhatky`
--

INSERT INTO `nhatky` (`id_nhatky`, `id_nguoidung`, `thoigian`, `noidung`) VALUES
(43, 2, '2024-04-04 23:21:55', 'Xóa nhân sự:\nMã nhân sự: 19.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1566\nĐịa chỉ thường trú: 12333\nNgày sinh: 2024-05-18\nCMND: 1322\nSĐT: 12\nSTK: 123\nTên NH: 1'),
(44, 2, '2024-04-04 23:22:21', 'Thêm nhân sự:\nMã nhân sự: 20.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-19\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(45, 2, '2024-04-04 23:22:46', 'Sửa thông tin nhân sự:\n\nGiá trị cũ:\nTên: 1\nĐịa chỉ thường trú: 1\n\nGiá trị mới:\nTên: 14\nĐịa chỉ thường trú: 14'),
(46, 2, '2024-04-04 23:23:06', 'Xóa nhân sự:\nMã nhân sự: 20.1\nTên: 14\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 14\nNgày sinh: 2024-04-19\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(47, 2, '2024-04-04 23:31:20', 'Thêm nhân sự:\nMã nhân sự: 21.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-17\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(48, 2, '2024-04-04 23:32:03', 'Sửa thông tin nhân sự:\n\nGiá trị cũ:\nTên: 1\nTên phòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-17\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1\n\nGiá trị mới:\nTên: 12\nTên phòng ban: 12\nChức vụ: 12\nNguyên quán: 12\nĐịa chỉ thường trú: 12\nNgày sinh: 2024-04-20\nCMND: 12\nSĐT: 12\nSTK: 12\nTên NH: 12'),
(49, 2, '2024-04-05 12:38:15', 'Xóa nhân sự:\nMã nhân sự: 21.1\nTên: 12\nPhòng ban: 12\nChức vụ: 12\nNguyên quán: 12\nĐịa chỉ thường trú: 12\nNgày sinh: 2024-04-20\nCMND: 12\nSĐT: 12\nSTK: 12\nTên NH: 12'),
(50, 3, '2024-04-05 15:08:47', 'Thêm nhân sự:\nMã nhân sự: 22.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-27\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(51, 2, '2024-04-05 15:09:34', 'Xóa nhân sự:\nMã nhân sự: 22.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-27\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(52, 5, '2024-04-05 15:09:45', 'Thêm nhân sự:\nMã nhân sự: 23.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-11\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(53, 5, '2024-04-05 15:13:55', 'Sửa thông tin nhân sự:\n\nGiá trị cũ:\nSĐT: 1\nSTK: 1\n\nGiá trị mới:\nSĐT: 13\nSTK: 13'),
(54, 3, '2024-04-05 15:14:20', 'Sửa thông tin nhân sự:\n\nGiá trị cũ:\nTên NH: 1\n\nGiá trị mới:\nTên NH: 12'),
(55, 3, '2024-04-05 15:28:07', 'Xóa nhân sự:\nMã nhân sự: 23.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-11\nCMND: 1\nSĐT: 13\nSTK: 13\nTên NH: 12'),
(56, 5, '2024-04-05 15:29:45', 'Thêm nhân sự:\nMã nhân sự: 24.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-02\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(57, 3, '2024-04-05 15:31:25', 'Sửa thông tin nhân sự:\n\nGiá trị cũ:\nSĐT: 1\n\nGiá trị mới:\nSĐT: 12'),
(58, 2, '2024-04-05 15:31:45', 'Xóa nhân sự:\nMã nhân sự: 24.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-02\nCMND: 1\nSĐT: 12\nSTK: 1\nTên NH: 1'),
(59, 5, '2024-04-06 22:22:00', 'Thêm nhân sự:\nMã nhân sự: 26.123\nTên: 111\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-19\nCMND: 12\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(60, 2, '2024-04-06 22:22:32', 'Xóa nhân sự:\nMã nhân sự: 26.123\nTên: 111\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-19\nCMND: 12\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(61, 5, '2024-04-15 22:29:47', 'Thêm nhân sự:\nMã nhân sự: 27.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-10\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(62, 2, '2024-04-15 22:30:10', 'Xóa nhân sự:\nMã nhân sự: 27.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-10\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(63, 5, '2024-04-17 15:53:05', 'Thêm nhân sự:\nMã nhân sự: 28.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-04\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(64, 2, '2024-04-17 15:56:13', 'Xóa nhân sự:\nMã nhân sự: 28.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-04\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(65, 5, '2024-04-17 15:58:41', 'Thêm nhân sự:\nMã nhân sự: 29.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-04\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(66, 2, '2024-04-17 15:58:49', 'Xóa nhân sự:\nMã nhân sự: 29.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-04\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(67, 5, '2024-04-17 16:18:31', 'Thêm nhân sự:\nMã nhân sự: 30.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-01\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(68, 2, '2024-04-23 10:09:11', 'Xóa nhân sự:\nMã nhân sự: 30.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-04-01\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(69, 5, '2024-04-23 10:10:37', 'Thêm nhân sự:\nMã nhân sự: 31.sales.Hthao\nTên: Hoàng Văn Thảo\nPhòng ban: Chăm sóc khách hàng\nChức vụ: Sales\nNguyên quán: Đông Lãm, Đa Phúc, Dương Kinh\nĐịa chỉ thường trú: Đông Lãm, Đa Phúc, Dương Kinh\nNgày sinh: 1999-08-23\nCMND: 01233435445\nSĐT: 0123343544'),
(70, 5, '2024-05-15 21:16:20', 'Thêm nhân sự:\nMã nhân sự: 32.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-26\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(71, 3, '2024-04-15 21:16:58', 'Xóa nhân sự:\nMã nhân sự: 32.1\nTên: 1\nPhòng ban: 1\nChức vụ: 1\nNguyên quán: 1\nĐịa chỉ thường trú: 1\nNgày sinh: 2024-05-26\nCMND: 1\nSĐT: 1\nSTK: 1\nTên NH: 1'),
(72, 7, '2024-05-17 22:42:32', 'Thêm chi phí vận tải:\nMã cpvt: 8\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: \n'),
(73, 7, '2024-05-17 22:45:08', 'Thêm chi phí vận tải:\nMã cpvt: 10\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có\n'),
(74, 7, '2024-05-17 22:45:46', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có\n\nGiá trị mới:\nPhí cầu đường: 350001\nTiền ăn ca: 600001\nLương chuyến: 3200001\nLương chủ nhật: 1\nTiền thuê xe ngoài: 1\nTổng chi phí: 10730943\nGhi chú: không có1'),
(75, 7, '2024-05-17 22:46:14', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nLương chủ nhật: 1\nTổng chi phí: 10730943\n\nGiá trị mới:\nLương chủ nhật: 0\nTổng chi phí: 10730942'),
(76, 7, '2024-05-17 22:46:48', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nPhí cầu đường: 350001\nTiền ăn ca: 600001\nLương chuyến: 3200001\nTiền thuê xe ngoài: 1\nTổng chi phí: 10730942\nGhi chú: không có1\n\nGiá trị mới:\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có'),
(77, 7, '2024-05-17 22:47:20', 'Xóa chi phí vận tải:\nMã cpvt: 10\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có\n'),
(78, 7, '2024-05-17 22:47:56', 'Thêm chi phí vận tải:\nMã cpvt: 11\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có ghi chú\n'),
(79, 7, '2024-05-17 22:56:07', 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:\nNgày tạm ứng: 2024-05-08\nMã nhân sự: 3\nTiền cước vỏ: 2300000\nTiền hải quan: 0\nTiền nâng hạ: 1200000\nTiền khác: 0\nGiờ thanh toán: 00:00:00\nGhi chú:  \nẢnh: anhhoanung2.jpg\n\nGiá trị mới:\nNgày tạm ứng: 2024-05-09\nMã nhân sự: 1\nTiền cước vỏ: 23000001\nTiền hải quan: 1\nTiền nâng hạ: 12000001\nTiền khác: 1\nGiờ thanh toán: 01:00:00\nGhi chú:   ko\nẢnh: anhhoanung1.jpg'),
(80, 7, '2024-05-17 22:56:48', 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:\nNgày thanh toán: 0000-00-00\nGhi chú:   ko\n\nGiá trị mới:\nNgày thanh toán: 2024-05-16\nGhi chú:    ko'),
(81, 7, '2024-05-17 23:02:15', 'Xóa tạm ứng:\nMã tạm ứng: 11\nMã đơn hàng: 30\nNgày tạm ứng: 2024-05-09\nMã nhân sự tạm ứng: 1\nTiền cước vỏ: 23000001\nTiền hải quan: 1\nTiền nâng hạ: 12000001\nTiền khác: 1\nNgày thanh toán: 2024-05-16\nGiờ thanh toán: 01:00:00\nGhi chú:    koẢnh: anhhoanung1.jpg'),
(82, 7, '2024-05-17 23:07:25', 'Thêm tạm ứng:\nMã tạm ứng: 13\nMã đơn hàng: 30\nNgày tạm ứng: 2024-05-08\nMã nhân sự tạm ứng: 3\nTiền cước vỏ: 2300000\nTiền hải quan: 0\nTiền nâng hạ: 1200000\nTiền khác: 0\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 12:07:00\nGhi chú: ko có Ảnh: anhhoanung1.jpg'),
(83, 7, '2024-05-17 23:13:05', 'Sửa thông tin điều vận:\n\nGiá trị cũ:\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ:  Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 3\nMã tài xế: AnhSon\nĐiện thoại tài xế: 123456\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\nGhi chú: Vận chuyển trước ngày 15/04/2024\n\nGiá trị mới:\nMã thầu phụ: CTY-L\nMã số thuế: 0201734748\nTên thầu phụ: Công ty CP City Delivery \nMã xe: 11\nMã tài xế: NhatBao\nĐiện thoại tài xế: 1234567777\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\nGhi chú: Vận chuyển trước ngày 15/04/2024 ok'),
(84, 7, '2024-05-17 23:13:34', 'Sửa thông tin điều vận:\n\nGiá trị cũ:\nTên thầu phụ: Công ty CP City Delivery \nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n\nGiá trị mới:\nTên thầu phụ:  Công ty CP City Delivery \nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0'),
(85, 7, '2024-05-17 23:18:21', 'Xóa điều vận:\nMã điều vận: 1\nMã đơn hàng: 2\nMã thầu phụ: CTY-L\nMã số thuế: 0201734748\nTên thầu phụ:  Công ty CP City Delivery \nMã xe: 11\nMã tài xế: NhatBao\nĐiện thoại tài xế: 1234567777\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\nGhi chú: Vận chuyển trước '),
(86, 7, '2024-05-17 23:21:42', 'Thêm điều vận:\nMã điều vận: 8\nMã đơn hàng: 2\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 3\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\nGhi chú: Vận chuy'),
(87, 7, '2024-05-17 23:23:01', 'Sửa thông tin điều vận:\n\nGiá trị cũ:\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nGhi chú: Vận chuyển trước ngày 15/04/2024\n\nGiá trị mới:\nTên thầu phụ:  Công ty CP Tiếp vận Thái Bình Dương\nGhi chú: Vận chuyển trước ngày 15/04/2024 rr'),
(88, 7, '2024-05-17 23:26:52', 'Xóa điều vận:\nMã điều vận: 8\nMã đơn hàng: 2\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ:  Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 3\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\nGhi chú: Vận chuy'),
(89, 7, '2024-05-17 23:27:16', 'Thêm điều vận:\nMã điều vận: 9\nMã đơn hàng: 2\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 3\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\nGhi chú: Vận chuy'),
(90, 7, '2024-05-17 23:28:35', 'Xóa điều vận:\nMã điều vận: 9\nMã đơn hàng: 2\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 3\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(91, 7, '2024-05-17 23:29:01', 'Thêm điều vận:\nMã điều vận: 10\nMã đơn hàng: 2\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 6\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(92, 7, '2024-05-18 00:05:27', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nMã nhân viên sale: 1\nMã  khách hàng: APT\nMã số thuế: 0202169016\nSố booking: BK78NMNZZZZZ\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 13500\nNgày đóng cont: 2024-04-24\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ANBD\nCự ly: 1100\nDầu tiêu thụ: 137.5\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại giao nhận: 0126664889\nThu thủ tục: 120000\nThu khác: 0\nHạn thanh toán: 2024-05-04\nẢnh: \nẢnh 2: \n\nGiá trị mới:\nMã nhân viên sale: 3\nMã  khách hàng: EXP\nMã số thuế: 0312545104-001\nSố booking: BK78NMNZZZZZ11111\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 2\nSố kg: 135001\nNgày đóng cont: 2024-04-25\nGiờ đóng cont: 00:02:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-19\nGiờ cắt máng: 00:03:00\nNgười giao nhận: Trần Quốc Chung1\nĐiện thoại giao nhận: 01266648891\nThu thủ tục: 1200001\nThu khác: 1\nHạn thanh toán: 2024-05-05\nẢnh: hóa đơn dịch vụ gia tăng.png\nẢnh 2: biên lai thu tiền phí.png'),
(93, 7, '2024-05-18 00:07:37', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nMã nhân viên sale: 3\nMã  khách hàng: EXP\nMã số thuế: 0312545104-001\nSố booking: BK78NMNZZZZZ11111\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 2\nSố kg: 135001\nNgày đóng cont: 2024-04-25\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-19\nNgười giao nhận: Trần Quốc Chung1\nĐiện thoại giao nhận: 01266648891\nThu thủ tục: 1200001\nThu khác: 1\nHạn thanh toán: 2024-05-05\n\nGiá trị mới:\nMã nhân viên sale: 1\nMã  khách hàng: APT\nMã số thuế: 0202169016\nSố booking: BK78NMNZZZZZ\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 13500\nNgày đóng cont: 2024-04-24\nMã tuyến vận tải: ANBD\nCự ly: 1100\nDầu tiêu thụ: 137.5\nNgày cắt máng: 0000-00-00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại giao nhận: 0126664889\nThu thủ tục: 120000\nThu khác: 0\nHạn thanh toán: 2024-05-04'),
(94, 7, '2024-05-18 00:15:25', 'Thêm đơn hàng:\nMã đơn hàng: 35\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: ss1\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 111Trạng thái: Hoàn thànhNgày đóng cont: 2024-05-24Giờ'),
(95, 7, '2024-05-18 00:26:31', 'Thêm đơn hàng:\nMã đơn hàng: 36\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: s\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 1\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-17\nGiờ đóng'),
(96, 7, '2024-05-18 00:27:09', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nHãng tàu: COSCO\nGiờ đóng cont: 00:02:00\n\nGiá trị mới:\nHãng tàu: \nGiờ đóng cont: 06:02:00'),
(97, 7, '2024-05-18 00:28:18', 'Thêm đơn hàng:\nMã đơn hàng: 37\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 123\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 1\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nGi'),
(98, 7, '2024-05-18 00:29:33', 'Thêm đơn hàng:\nMã đơn hàng: 38\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 1\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 1\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nMã tuyến'),
(99, 7, '2024-05-18 00:32:28', 'Thêm đơn hàng:\nMã đơn hàng: 38\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 1\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 1\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nGiờ đóng'),
(100, 7, '2024-05-18 00:32:35', 'Thêm đơn hàng:\nMã đơn hàng: 37\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 123\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 1\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nGi'),
(101, 7, '2024-05-18 00:34:22', 'Thêm đơn hàng:\nMã đơn hàng: 39\nMã nhân viên sale: 3\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 11\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 11\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nMã tuyến vận'),
(102, 7, '2024-05-18 00:37:47', 'Thêm đơn hàng:\nMã đơn hàng: 39\nMã nhân viên sale: 3\nMã khách hàng: APT\nMã số thuế: 0202169016\nSố booking: 11\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 11\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-19\nGiờ đóng cont: 0'),
(103, 7, '2024-05-18 00:38:52', 'Thêm đơn hàng:\nMã đơn hàng: 40\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nSố booking: bk2222\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 1234\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\n'),
(104, 7, '2024-05-18 00:42:10', 'Thêm đơn hàng:\nMã đơn hàng: 40\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nSố booking: bk2222\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 1234\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\n'),
(105, 7, '2024-05-18 00:42:50', 'Thêm đơn hàng:\nMã đơn hàng: 41\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nSố booking: sssssss\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 112222\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-26\nMã tvt: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-21\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại: 1111\nThu thủ tục: 1\nThu khác: 1\nHạn thanh toán: 2024-05-17\nẢnh 1: phiếu giao nhận container điện tử.jpg\nẢnh 2: hóa đơn dịch vụ gia tăng.png'),
(106, 7, '2024-05-18 00:47:11', 'Xóa đơn hàng:\nMã đơn hàng: 41\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: sssssss\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 112222\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-26\nGiờ đóng cont: 00:45:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-21\nGiờ cắt máng: 00:45:00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại: 1111\nThu thủ tục: 1\nThu khác: 1\nHạn thanh toán: 2024-05-17\nẢnh 1: phiếu giao nhận container điện tử.jpg\nẢnh 2: hóa đơn dịch vụ gia tăng.png'),
(107, 7, '2024-05-19 20:17:24', 'Thêm đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 1\n'),
(108, 7, '2024-05-19 20:21:58', 'Xóa đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 1\n'),
(109, 7, '2024-05-19 20:22:09', 'Thêm đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 2\n'),
(110, 7, '2024-05-19 20:24:01', 'Sửa thông tin DVCCD:\n\nGiá trị cũ:\nTên DVCCD: 2\n\nGiá trị mới:\nTên DVCCD: 2gfshdhfd'),
(111, 7, '2024-05-19 20:27:05', 'Thêm hàng hóa:\nMã hàng hóa: rew\nTên hàng hóa: fg\nMã nhóm hàng hóa: LCL\nKích thước: 0.0\nĐơn vị tính: \nGhi chú: \n'),
(112, 7, '2024-05-19 20:28:03', 'Xóa hàng hóa:\nMã hàng hóa: rew\nTên hàng hóa: fg\nMã nhóm hàng hóa: LCL\nKích thước: 0.0\nĐơn vị tính: \nGhi chú: \n'),
(113, 7, '2024-05-19 20:28:20', 'Thêm hàng hóa:\nMã hàng hóa: 123\nTên hàng hóa: 123\nMã nhóm hàng hóa: FCL\nKích thước: 657.0\nĐơn vị tính: ghdf\nGhi chú: dgh\n'),
(114, 7, '2024-05-19 20:31:45', 'Sửa thông tin hàng hóa:\n\nGiá trị cũ:\nTên hàng hóa: 123\nMã nhóm hàng hóa: FCL\nĐơn vị tính: ghdf\nGhi chú: dgh\n\nGiá trị mới:\nTên hàng hóa: 1234\nMã nhóm hàng hóa: LCL\nĐơn vị tính: ghdf11\nGhi chú: dgh1'),
(115, 7, '2024-05-19 20:31:57', 'Xóa hàng hóa:\nMã hàng hóa: 123\nTên hàng hóa: 1234\nMã nhóm hàng hóa: LCL\nKích thước: 657.0\nĐơn vị tính: ghdf11\nGhi chú: dgh1\n'),
(116, 7, '2024-05-19 20:33:20', 'Thêm hãng tàu:\nMã hãng tàu: 123\nTên hãng tàu: 123\n'),
(117, 7, '2024-05-19 20:35:51', 'Xóa hãng tàu:\nMã hãng tàu: 123\nTên hãng tàu: 123\n'),
(118, 7, '2024-05-19 20:36:00', 'Thêm hãng tàu:\nMã hãng tàu: 1\nTên hãng tàu: 1\n'),
(119, 7, '2024-05-19 20:37:46', 'Sửa thông tin hãng tàu:\n\nGiá trị cũ:\nTên hãng tàu: 1\n\nGiá trị mới:\nTên hãng tàu: 12ff'),
(120, 7, '2024-05-19 20:37:51', 'Xóa hãng tàu:\nMã hãng tàu: 1\nTên hãng tàu: 12ff\n'),
(121, 7, '2024-05-19 20:40:02', 'Thêm khách hàng:\nMã đơn hàng: 1\nMã nhân viên sale: 1\nMã khách hàng: 1\nMã số thuế: 1\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: 1\nNhóm hàng hóa: 1\nHàng hóa: 1\nSố lượng: 1\nSố kg: ANBD'),
(122, 7, '2024-05-19 20:40:47', 'Xóa khách hàng:\nMã đơn hàng: 1\nMã nhân viên sale: 1\nMã khách hàng: 1\nMã số thuế: 1\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: 1\nNhóm hàng hóa: 1\nHàng hóa: 1\nSố lượng: 1\nSố kg: ANBD'),
(123, 7, '2024-05-19 20:44:51', 'Thêm khách hàng:\nMã đơn hàng: 1\nMã nhân viên sale: 1\nMã khách hàng: 1\nMã số thuế: 1\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: 1\nNhóm hàng hóa: 1\nHàng hóa: 1\nSố lượng: 1\nSố kg: ANBD'),
(124, 7, '2024-05-19 20:45:02', 'Sửa thông tin khách hàng:\n\nGiá trị cũ:\nTên khách hàng: 1\nĐịa chỉ: 1\nSố đt: 1\nEmail: 1\nMã số thuế: 1\nTên ngân hàng: 1\nSố tài khoản: 1\nNgười địa diện: 1\nSđt giao nhận: 1\nMã tuyến vận tải: ANBD\n\nGiá trị mới:\nTên khách hàng:  12\nĐịa chỉ: 12\nSố đt: 12\nEmail: 12\nMã số thuế: 12\nTên ngân hàng: 12\nSố tài khoản: 12\nNgười địa diện: 12\nSđt giao nhận: 12\nMã tuyến vận tải: ADHP'),
(125, 7, '2024-05-19 21:35:37', 'Thêm nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-19\nĐơn giá sau thuế: 4335'),
(126, 7, '2024-05-19 21:36:45', 'Xóa nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-19\nĐơn giá sau thuế: 4335'),
(127, 7, '2024-05-19 21:38:07', 'Thêm nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-19\nĐơn giá sau thuế: 1'),
(128, 7, '2024-05-19 21:40:24', 'Sửa thông tin nhiên liệu:\n\nGiá trị cũ:\nTên nhiên liệu: 12\nNgày áp dụng: 2024-05-26\nĐơn giá sau thuế: 12\n\nGiá trị mới:\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-19\nĐơn giá sau thuế: 1'),
(129, 7, '2024-05-19 21:40:32', 'Xóa nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-19\nĐơn giá sau thuế: 1'),
(130, 7, '2024-05-19 21:45:00', 'Thêm nhóm hàng hóa:\nMã nhóm hàng hóa: 1\nTên nhóm hàng hóa: 1'),
(131, 7, '2024-05-19 21:45:53', 'Xóa nhóm hàng hóa:\nMã nhóm hàng hóa: 1\nTên nhóm hàng hóa: 1'),
(132, 7, '2024-05-19 21:46:33', 'Thêm nhóm hàng hóa:\nMã nhóm hàng hóa: 1\nTên nhóm hàng hóa: 1'),
(133, 7, '2024-05-19 21:47:10', 'Sửa thông tin nhóm hàng hóa:\n\nGiá trị cũ:\nTên nhóm hàng hóa: 1\n\nGiá trị mới:\nTên nhóm hàng hóa: 12'),
(134, 7, '2024-05-19 21:48:13', 'Thêm nhóm xe:\nMã đơn hàng: 1\nMã nhân viên sale: 1'),
(135, 7, '2024-05-19 21:49:10', 'Xóa nhóm xe:\nMã đơn hàng: 1\nMã nhân viên sale: 1'),
(136, 7, '2024-05-19 21:49:18', 'Thêm nhóm xe:\nMã đơn hàng: 1\nMã nhân viên sale: 1'),
(137, 7, '2024-05-19 21:50:12', 'Sửa thông tin nhóm xe:\n\nGiá trị cũ:\nTên nhóm xe: 1\n\nGiá trị mới:\nTên nhóm xe: 12222'),
(138, 7, '2024-05-19 21:53:14', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 12\nMã đơn hàng: 4\nNgày đổ nhiên liệu: 2024-05-19\nMã đơn vị cung cấp dầu: 1\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: booking notice.jpg\nThành tiền: 246188\nGhi chú: sss'),
(139, 7, '2024-05-19 21:54:06', 'Xóa phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 12\nMã đơn hàng: 4\nNgày đổ nhiên liệu: 2024-05-19\nMã đơn vị cung cấp dầu: 1\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: booking notice.jpg\nThành tiền: 246188\nGhi chú: sss'),
(140, 7, '2024-05-19 21:54:21', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 13\nMã đơn hàng: 4\nNgày đổ nhiên liệu: 2024-05-19\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: phiếu đổ dầu.jpg\nThành tiền: 246188\nGhi chú: 11'),
(141, 7, '2024-05-19 21:58:03', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nNgày đổ nhiên liệu: 2024-05-19\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nẢnh 1: phiếu đổ dầu.jpg\nThành tiền: 246188\nGhi chú: 11\n\nGiá trị mới:\nNgày đổ nhiên liệu: 2024-05-26\nMã đơn vị cung cấp dầu: 1\nSố lượng nhiên liệu: 12.6258\nẢnh 1: anhhoanung1.jpg\nThành tiền: 246202\nGhi chú: 11222'),
(142, 7, '2024-05-19 21:58:18', 'Xóa phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 13\nMã đơn hàng: 4\nNgày đổ nhiên liệu: 2024-05-26\nMã đơn vị cung cấp dầu: 1\nSố lượng nhiên liệu: 12.6258\nMã nhiên liệu: DO\nẢnh 1: anhhoanung1.jpg\nThành tiền: 246202\nGhi chú: 11222'),
(143, 7, '2024-05-19 22:01:44', 'Thêm sửa chữa:\nMã sửa chữa: 9\nMã xe: 3\nNgày sửa chữa: 2024-05-19 00:00:00\nSố km đồng hồ: 1\nNội dung sửa chữa: 1111\nĐơn giá vật tư: 111\nTiền nhân công: 1\nSố lượng: 1\nNgười sửa chữa: 1\nThời gian bảo hành: 2024-06-02\nTổng tiền: 112\nẢnh 1: booking notice.jpg\nGhi chú: 11'),
(144, 7, '2024-05-19 22:02:34', 'Xóa sửa chữa:\nMã sửa chữa: 9\nMã xe: 3\nNgày sửa chữa: 2024-05-19 00:00:00\nSố km đồng hồ: 1\nNội dung sửa chữa: 1111\nĐơn giá vật tư: 111\nTiền nhân công: 1\nSố lượng: 1\nNgười sửa chữa: 1\nThời gian bảo hành: 2024-06-02\nTổng tiền: 112\nẢnh 1: booking notice.jpg\nGhi chú: 11'),
(145, 7, '2024-05-19 22:05:54', 'Thêm sửa chữa:\nMã sửa chữa: 10\nMã xe: 3\nNgày sửa chữa: 2024-05-19 00:00:00\nSố km đồng hồ: 1\nNội dung sửa chữa: 1\nĐơn giá vật tư: 1\nTiền nhân công: 1\nSố lượng: 1\nNgười sửa chữa: 1\nThời gian bảo hành: 2024-05-19\nTổng tiền: 2\nẢnh 1: phiếu đổ dầu.jpg\nGhi chú: 1'),
(146, 7, '2024-05-19 22:06:16', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nNgày sửa chữa: 2024-05-19 00:00:00\nSố km đồng hồ: 1\nNội dung sửa chữa: 1\nĐơn giá vật tư: 1\nTiền nhân công: 1\nSố lượng: 1\nNgười sửa chữa: 1\nThời gian bảo hành: 2024-05-19\nTổng tiền: 2\nẢnh 1: phiếu đổ dầu.jpg\nGhi chú: 1\n\nGiá trị mới:\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 12\nNội dung sửa chữa: 12\nĐơn giá vật tư: 12\nTiền nhân công: 12\nSố lượng: 12\nNgười sửa chữa: 12\nThời gian bảo hành: 2024-06-09\nTổng tiền: 156\nẢnh 1: booking notice.jpg\nGhi chú: 12'),
(147, 7, '2024-05-19 22:06:47', 'Xóa sửa chữa:\nMã sửa chữa: 10\nMã xe: 3\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 12\nNội dung sửa chữa: 12\nĐơn giá vật tư: 12\nTiền nhân công: 12\nSố lượng: 12\nNgười sửa chữa: 12\nThời gian bảo hành: 2024-06-09\nTổng tiền: 156\nẢnh 1: booking notice.jpg\nGhi chú: 12'),
(148, 7, '2024-05-19 22:08:19', 'Thêm tài xế:\nMã đơn hàng: 1\nMã nhân viên sale: 1\nMã khách hàng: 1\nMã số thuế: 1\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: CTY-L'),
(149, 7, '2024-05-19 22:10:12', 'Xóa tài xế:\nMã tài xế: 1\nTên tài xế: 1\nSđt: 1\nĐịa chỉ: 1\nCMND: 1\nSố bằng lái: 1\nMã thầu phụ: CTY-L'),
(150, 7, '2024-05-19 22:10:25', 'Thêm tài xế:\nMã tài xế: 1\nTên tài xế: 1\nSđt: 1\nĐịa chỉ: 1\nCMND: 1\nSố bằng lái: 1\nMã thầu phụ: PLJ-F'),
(151, 7, '2024-05-19 22:12:19', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nTên tài xế: 1\nSố đt: 1\nĐịa chỉ: 1\nCMND: 1\nSố bằng lái: 1\nMã thầu phụ: PLJ-F\n\nGiá trị mới:\nTên tài xế: 12\nSố đt: 12\nĐịa chỉ: 12\nCMND: 12\nSố bằng lái: 12\nMã thầu phụ: GPT-F'),
(152, 7, '2024-05-19 22:14:50', 'Thêm thầu phụ:\nMã thầu phụ: 1\nTên: 1\nĐịa chỉ: 1\nSố điện thoại: 1\nMã số thuế: 1\nNhóm hàng vận chuyển: FCL'),
(153, 7, '2024-05-19 22:15:38', 'Xóa thầu phụ:\nMã thầu phụ: 1\nTên: 1\nĐịa chỉ: 1\nSố điện thoại: 1\nMã số thuế: 1\nNhóm hàng vận chuyển: FCL'),
(154, 7, '2024-05-19 22:15:46', 'Thêm thầu phụ:\nMã thầu phụ: 1\nTên: 1\nĐịa chỉ: 1\nSố điện thoại: 1\nMã số thuế: 1\nNhóm hàng vận chuyển: FCL'),
(155, 7, '2024-05-19 22:17:27', 'Sửa thông tin thầu phụ:\n\nGiá trị cũ:\nTên thầu phụ: 1\nĐịa chỉ: 1\nSđt: 1\nMã số thuế: 1\nMã nhóm hàng vận chuyển: FCL\n\nGiá trị mới:\nTên thầu phụ: 12\nĐịa chỉ: 12\nSđt: 12\nMã số thuế: 12\nMã nhóm hàng vận chuyển: 1'),
(156, 7, '2024-05-19 22:17:59', 'Sửa thông tin thầu phụ:\n\nGiá trị cũ:\nMã nhóm hàng vận chuyển: 1\n\nGiá trị mới:\nMã nhóm hàng vận chuyển: LCL'),
(157, 7, '2024-05-19 22:18:11', 'Xóa nhóm hàng hóa:\nMã nhóm hàng hóa: 1\nTên nhóm hàng hóa: 12'),
(158, 7, '2024-05-19 22:18:15', 'Xóa nhóm xe:\nMã đơn hàng: 1\nMã nhân viên sale: 12222'),
(159, 7, '2024-05-19 22:19:23', 'Thêm tỉnh thành:\nMã tỉnh thành: 1\ntên: 1'),
(160, 7, '2024-05-19 22:20:29', 'Xóa tỉnh thành:\nMã tỉnh thành: 1\ntên: 1'),
(161, 7, '2024-05-19 22:20:34', 'Thêm tỉnh thành:\nMã tỉnh thành: 1\ntên: 1'),
(162, 7, '2024-05-19 22:21:30', 'Sửa thông tin tỉnh thành:\n\nGiá trị cũ:\nTên tỉnh thành: 1\n\nGiá trị mới:\nTên tỉnh thành: 12222'),
(163, 7, '2024-05-19 22:23:52', 'Thêm tỉnh thành:\nMã tỉnh thành: 12\ntên: 1'),
(164, 7, '2024-05-19 22:24:47', 'Xóa tỉnh thành:\nMã tỉnh thành: 12\ntên: 1'),
(165, 7, '2024-05-19 22:24:53', 'Xóa tỉnh thành:\nMã tỉnh thành: 1\ntên: 12222'),
(166, 7, '2024-05-19 22:29:31', 'Thêm tuyến vận tải:\nMã tuyến vận tải: 1\nTên tuyến vận tải: 1\nĐiểm đầu: Bắc Cạn\nMã tỉnh thành đầu: BCN\nĐiểm cuốiBắc Cạn\nMã tỉnh thành cuối: BCN\nCự ly: 1\nDầu tiêu thụ: 0.13\nGhi chú: 1'),
(167, 7, '2024-05-19 22:31:27', 'Thêm tuyến vận tải:\nMã tuyến vận tải: 1111\nTên tuyến vận tải: 1111\nĐiểm đầu: Hải Phòng\nMã tỉnh thành đầu: HPG\nĐiểm cuối:Bình Định\nMã tỉnh thành cuối: BDV\nCự ly: 111\nDầu tiêu thụ: 13.88\nGhi chú: 11'),
(168, 7, '2024-05-19 22:41:48', 'Xóa tuyến vận tải:\nMã tuyến vận tải: 1111\nTên tuyến vận tải: 1111\nĐiểm đầu: Hải Phòng\nMã tỉnh thành đầu: HPG\nĐiểm cuốiBình Định\nMã tỉnh thành cuối: BDV\nCự ly: 111\nDầu tiêu thụ: 13.88\nGhi chú: 11'),
(169, 7, '2024-05-19 22:41:51', 'Xóa tuyến vận tải:\nMã tuyến vận tải: 1\nTên tuyến vận tải: 1\nĐiểm đầu: Bắc Cạn\nMã tỉnh thành đầu: BCN\nĐiểm cuốiBắc Cạn\nMã tỉnh thành cuối: BCN\nCự ly: 1\nDầu tiêu thụ: 0.13\nGhi chú: 1'),
(170, 7, '2024-05-19 22:43:23', 'Thêm xe:\nMã xe: 12\nBiển số: 11111\nTrạng thái xe: OK\nMã nhóm xe: nhomxengoai\nTên nhóm xe: Nhóm xe ngoài\nMã nhiên liệu: DO\nMã thầu phụ: CTY-L\nMã nhóm hàng: FCL'),
(171, 7, '2024-05-19 22:45:08', 'Xóa xe:\nMã xe: 12\nBiển số: 11111\nTrạng thái xe: OK\nMã nhóm xe: nhomxengoai\nTên nhóm xe: Nhóm xe ngoài\nMã nhiên liệu: DO\nMã thầu phụ: CTY-L\nMã nhóm hàng: FCL'),
(172, 7, '2024-05-19 22:45:18', 'Thêm xe:\nMã xe: 13\nBiển số: 1\nTrạng thái xe: OK\nMã nhóm xe: daukeo\nTên nhóm xe: Đầu kéo\nMã nhiên liệu: DO\nMã thầu phụ: PLJ-F\nMã nhóm hàng: FCL'),
(173, 7, '2024-05-19 22:47:37', 'Sửa thông tin xe:\n\nGiá trị cũ:\nBiển số: 1\nTrạng thái xe: OK\nMã nhóm xe: daukeo\nTên nhóm xe: Đầu kéo\nMã thầu phụ: PLJ-F\nMã nhóm hàng: FCL\n\nGiá trị mới:\nBiển số: 12\nTrạng thái xe: Đang sửa\nMã nhóm xe: nhomxengoai\nTên nhóm xe: Nhóm xe ngoài\nMã thầu phụ: GPT-F\nMã nhóm hàng: LCL'),
(174, 7, '2024-05-19 22:47:51', 'Xóa xe:\nMã xe: 13\nBiển số: 12\nTrạng thái xe: Đang sửa\nMã nhóm xe: nhomxengoai\nTên nhóm xe: Nhóm xe ngoài\nMã nhiên liệu: DO\nMã thầu phụ: GPT-F\nMã nhóm hàng: LCL'),
(175, 5, '2024-05-21 19:28:13', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nTrạng thái: Hủy\n\nGiá trị mới:\nTrạng thái: Hoàn thành'),
(176, 5, '2024-05-21 19:34:52', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nTrạng thái: Hủy\n\nGiá trị mới:\nTrạng thái: Hoàn thành'),
(177, 5, '2024-05-21 19:37:50', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nTrạng thái: Hoàn thành\n\nGiá trị mới:\nTrạng thái: Hủy'),
(178, 5, '2024-05-21 20:12:16', 'Xóa chi phí vận tải:\nMã cpvt: 11\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: không có ghi chú\n'),
(179, 5, '2024-05-21 20:15:08', 'Thêm chi phí vận tải:\nMã cpvt: 12\nMã đơn hàng: 2\nPhí cầu đường: 35000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6995938\nGhi chú: \n'),
(180, 5, '2024-05-21 20:16:49', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nGhi chú: \n\nGiá trị mới:\nGhi chú: ko có ghi chú'),
(181, 5, '2024-05-21 20:23:03', 'Xóa khách hàng:\nMã đơn hàng: 1\nMã nhân viên sale:  12\nMã khách hàng: 12\nMã số thuế: 12\nTên khách hàng: 12\nLoại hàng: 12\nHãng tàu: 12\nNhóm hàng hóa: 12\nHàng hóa: 12\nSố lượng: 12\nSố kg: ADHP'),
(182, 5, '2024-05-21 20:29:19', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nTrạng thái: Hoàn thành\n\nGiá trị mới:\nTrạng thái: Hủy'),
(183, 5, '2024-05-21 20:30:17', 'Xóa điều vận:\nMã điều vận: 5\nMã đơn hàng: 30\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 2147483647\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(184, 5, '2024-05-21 20:32:16', 'Thêm điều vận:\nMã điều vận: 11\nMã đơn hàng: 30\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 2\nMã tài xế: HoangBao\nĐiện thoại tài xế: 2147483647\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(185, 5, '2024-05-21 22:40:35', 'Xóa đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 2gfshdhfd\n'),
(186, 5, '2024-05-21 22:41:05', 'Thêm đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 1\n'),
(187, 5, '2024-05-21 22:43:42', 'Xóa đơn vị cung cấp dầu:\nMã ĐVCCD: 1\nTên: 1\n'),
(188, 5, '2024-05-21 22:53:48', 'Xóa tài xế:\nMã tài xế: 1\nTên tài xế: 12\nSđt: 12\nĐịa chỉ: 12\nCMND: 12\nSố bằng lái: 12\nMã thầu phụ: GPT-F'),
(189, 5, '2024-05-22 09:19:15', 'Sửa thông tin nhiên liệu:\n\nGiá trị cũ:\nĐơn giá sau thuế: 19500\n\nGiá trị mới:\nĐơn giá sau thuế: 195001'),
(190, 5, '2024-05-22 09:19:32', 'Sửa thông tin nhiên liệu:\n\nGiá trị cũ:\nĐơn giá sau thuế: 195001\n\nGiá trị mới:\nĐơn giá sau thuế: 19500'),
(191, 5, '2024-05-22 09:25:04', 'Thêm nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-22\nĐơn giá sau thuế: 1'),
(192, 5, '2024-05-22 09:25:09', 'Xóa nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-22\nĐơn giá sau thuế: 1'),
(193, 5, '2024-05-22 11:28:14', 'Thêm đơn hàng:\nMã đơn hàng: 42\nMã nhân viên sale: 3\nMã khách hàng: EXP\nMã số thuế: 0312545104-001\nTên khách hàng: FNBK98\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 12222\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-23\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-08\nGiờ cắt máng: 00:00:00\nNgười giao nhận: ddd\nĐiện thoại: 012444442\nThu thủ tục: 123332\nThu khác: 123333\nHạn thanh toán: 2024-05-22\nẢnh 1: logo_paci.png\nẢnh 2: logo-rm.png'),
(194, 5, '2024-05-22 19:21:17', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nMã  khách hàng: EXP\nMã số thuế: 0312545104-001\nHãng tàu: COSCO\n\nGiá trị mới:\nMã  khách hàng: APT\nMã số thuế: 0202169016\nHãng tàu: '),
(195, 5, '2024-05-22 19:21:36', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nMã  khách hàng: APT\nMã số thuế: 0202169016\n\nGiá trị mới:\nMã  khách hàng: GLS\nMã số thuế: 0304995011-001'),
(196, 5, '2024-05-22 20:28:24', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nẢnh: logo_paci.png\n\nGiá trị mới:\nẢnh: booking notice.jpg'),
(197, 5, '2024-05-22 20:32:44', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nNgày đóng cont: 2024-05-23\nNgày cắt máng: 2024-05-08\n\nGiá trị mới:\nNgày đóng cont: 2024-05-22\nNgày cắt máng: 2024-05-24'),
(198, 5, '2024-05-22 20:33:32', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\n\nGiá trị mới:\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 40HC'),
(199, 5, '2024-05-22 20:41:13', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 14\nMã đơn hàng: 42\nNgày đổ nhiên liệu: 2024-05-22\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: phiếu đổ dầu.jpg\nThành tiền: 246188\nGhi chú: ko'),
(200, 5, '2024-05-22 20:48:40', 'Thêm điều vận:\nMã điều vận: 12\nMã đơn hàng: 42\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 1\nMã tài xế: QuocDanh\nĐiện thoại tài xế: 321456\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(201, 5, '2024-05-22 20:52:55', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nMã đơn vị cung cấp dầu: KVNS\n\nGiá trị mới:\nMã đơn vị cung cấp dầu: HFC'),
(202, 5, '2024-05-22 21:02:31', 'Xóa phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 14\nMã đơn hàng: 42\nNgày đổ nhiên liệu: 2024-05-22\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: phiếu đổ dầu.jpg\nThành tiền: 246188\nGhi chú: ko'),
(203, 5, '2024-05-22 21:02:51', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 15\nMã đơn hàng: 42\nNgày đổ nhiên liệu: 2024-05-22\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: phiếu giao nhận container điện tử.jpg\nThành tiền: 246188\nGhi chú: ko'),
(204, 5, '2024-05-22 21:02:57', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nẢnh 1: phiếu giao nhận container điện tử.jpg\n\nGiá trị mới:\nẢnh 1: phiếu đổ dầu.jpg'),
(205, 5, '2024-05-22 21:03:10', 'Xóa điều vận:\nMã điều vận: 12\nMã đơn hàng: 42\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 1\nMã tài xế: QuocDanh\nĐiện thoại tài xế: 321456\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(206, 5, '2024-05-22 21:10:45', 'Thêm điều vận:\nMã điều vận: 13\nMã đơn hàng: 42\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 5\nMã tài xế: NgocDoan\nĐiện thoại tài xế: 1299825\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(207, 5, '2024-05-22 21:15:57', 'Sửa thông tin điều vận:\n\nGiá trị cũ:\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 5\nMã tài xế: NgocDoan\nĐiện thoại tài xế: 1299825\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n\nGiá trị mới:\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 2147483647\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0'),
(208, 5, '2024-05-22 21:18:05', 'Sửa thông tin xe:\n\nGiá trị cũ:\nTrạng thái xe: OK\n\nGiá trị mới:\nTrạng thái xe: Đang sửa'),
(209, 5, '2024-05-22 21:19:03', 'Sửa thông tin xe:\n\nGiá trị cũ:\nTrạng thái xe: Đang sửa\n\nGiá trị mới:\nTrạng thái xe: OK'),
(210, 5, '2024-05-22 21:30:37', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nSố km đồng hồ: 9998\n\nGiá trị mới:\nSố km đồng hồ: 99981'),
(211, 5, '2024-05-22 21:30:41', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nSố km đồng hồ: 99981\n\nGiá trị mới:\nSố km đồng hồ: 9998'),
(212, 5, '2024-05-22 21:38:45', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nĐơn giá vật tư: 100000\nTổng tiền: 100000\n\nGiá trị mới:\nĐơn giá vật tư: 1000001\nTổng tiền: 1000001'),
(213, 5, '2024-05-22 21:38:52', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nĐơn giá vật tư: 1000001\nTổng tiền: 1000001\n\nGiá trị mới:\nĐơn giá vật tư: 100000\nTổng tiền: 100000'),
(214, 5, '2024-05-22 22:10:11', 'Thêm sửa chữa:\nMã sửa chữa: 11\nMã xe: 3\nNgày sửa chữa: 2024-05-22 00:00:00\nSố km đồng hồ: 123455\nNội dung sửa chữa: 123\nĐơn giá vật tư: 355000\nTiền nhân công: 155500\nSố lượng: 1\nNgười sửa chữa: thiên\nThời gian bảo hành: 0000-00-00\nTổng tiền: 511\nẢnh 1: anhhoanung1.jpg\nGhi chú: ko'),
(215, 5, '2024-05-22 22:17:38', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nTổng tiền: 511\n\nGiá trị mới:\nTổng tiền: 510500'),
(216, 5, '2024-05-22 22:19:00', 'Xóa sửa chữa:\nMã sửa chữa: 11\nMã xe: 3\nNgày sửa chữa: 2024-05-22 00:00:00\nSố km đồng hồ: 123455\nNội dung sửa chữa: 123\nĐơn giá vật tư: 355000\nTiền nhân công: 155500\nSố lượng: 1\nNgười sửa chữa: thiên\nThời gian bảo hành: 0000-00-00\nTổng tiền: 510500\nẢnh 1: anhhoanung1.jpg\nGhi chú: ko'),
(217, 5, '2024-05-22 22:20:17', 'Thêm sửa chữa:\nMã sửa chữa: 12\nMã xe: 6\nNgày sửa chữa: 2024-05-22 00:00:00\nSố km đồng hồ: 7775\nNội dung sửa chữa: Lắp 1 bộ súng hơi + rắc co\nĐơn giá vật tư: 250000\nTiền nhân công: 56000\nSố lượng: 1\nNgười sửa chữa: long\nThời gian bảo hành: 0000-00-00\nTổng tiền: 306000\nẢnh 1: \nGhi chú: '),
(218, 5, '2024-05-22 22:35:11', 'Xóa sửa chữa:\nMã sửa chữa: 12\nMã xe: 6\nNgày sửa chữa: 2024-05-22 00:00:00\nSố km đồng hồ: 7775\nNội dung sửa chữa: Lắp 1 bộ súng hơi + rắc co\nĐơn giá vật tư: 250000\nTiền nhân công: 56000\nSố lượng: 1\nNgười sửa chữa: long\nThời gian bảo hành: 0000-00-00\nTổng tiền: 306000\nẢnh 1: \nGhi chú: '),
(219, 5, '2024-05-22 22:36:13', 'Thêm sửa chữa:\nMã sửa chữa: 13\nMã xe: 3\nNgày sửa chữa: 2024-05-22 00:00:00\nSố km đồng hồ: 9998\nNội dung sửa chữa: Lắp 1 bộ súng hơi + rắc co\nĐơn giá vật tư: 255000\nTiền nhân công: 56000\nSố lượng: 1\nNgười sửa chữa: thiên\nThời gian bảo hành: 0000-00-00\nTổng tiền: 311000\nẢnh 1: \nGhi chú: '),
(220, 5, '2024-05-22 22:36:45', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nĐơn giá vật tư: 255000\nTiền nhân công: 56000\nTổng tiền: 311000\n\nGiá trị mới:\nĐơn giá vật tư: 245000\nTiền nhân công: 59000\nTổng tiền: 304000'),
(221, 3, '2024-05-22 23:01:01', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nSố lượng: 3\n\nGiá trị mới:\nSố lượng: 1'),
(222, 5, '2024-05-23 20:54:04', 'Thêm tạm ứng:\nMã tạm ứng: 14\nMã đơn hàng: 42\nNgày tạm ứng: 2024-05-23\nMã nhân sự tạm ứng: 31\nTiền cước vỏ: 100000\nTiền hải quan: 200000\nTiền nâng hạ: 300000\nTiền khác: 400000\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 00:00:00\nGhi chú: koẢnh: '),
(223, 5, '2024-05-23 21:00:01', 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:\nTiền cước vỏ: 100000\nTiền hải quan: 200000\nTiền nâng hạ: 300000\nTiền khác: 400000\nNgày thanh toán: 0000-00-00\nGhi chú: ko\nẢnh: \n\nGiá trị mới:\nTiền cước vỏ: 400000\nTiền hải quan: 300000\nTiền nâng hạ: 200000\nTiền khác: 100000\nNgày thanh toán: 2024-05-23\nGhi chú:  ko\nẢnh: anhhoanung2.jpg'),
(224, 5, '2024-05-23 21:21:18', 'Thêm chi phí vận tải:\nMã cpvt: 13\nMã đơn hàng: 42\nPhí cầu đường: 20000\nTiền ăn ca: 20000\nLương chuyến: 20000\nLương chủ nhật: 20000\nTiền thuê xe ngoài: 20000\nTổng chi phí: 7457188\nGhi chú: \n'),
(225, 5, '2024-05-23 21:51:50', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nPhí cầu đường: 20000\nTiền ăn ca: 20000\nLương chuyến: 20000\nLương chủ nhật: 20000\nTiền thuê xe ngoài: 20000\nTổng chi phí: 7457188\n\nGiá trị mới:\nPhí cầu đường: 1\nTiền ăn ca: 1\nLương chuyến: 1\nLương chủ nhật: 1\nTiền thuê xe ngoài: 1\nTổng chi phí: 1270637'),
(226, 5, '2024-05-23 21:52:40', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nPhí cầu đường: 1\nTiền ăn ca: 1\nLương chuyến: 1\nLương chủ nhật: 1\nTiền thuê xe ngoài: 1\nTổng chi phí: 1270637\nGhi chú: \n\nGiá trị mới:\nPhí cầu đường: 20000\nTiền ăn ca: 20000\nLương chuyến: 20000\nLương chủ nhật: 20000\nTiền thuê xe ngoài: 20000\nTổng chi phí: 7457188\nGhi chú: ko'),
(227, 5, '2024-05-23 22:32:41', 'Sửa thông tin khách hàng:\n\nGiá trị cũ:\nTên khách hàng: Chi nhánh Công ty TNHH Expeditors Việt Nam - CN Hà Nội\n\nGiá trị mới:\nTên khách hàng:  Chi nhánh Công ty TNHH Expeditors Việt Nam - CN Hà Nội'),
(228, 5, '2024-05-23 22:32:52', 'Sửa thông tin khách hàng:\n\nGiá trị cũ:\nTên khách hàng:  Chi nhánh Công ty TNHH Expeditors Việt Nam - CN Hà Nội\nMã tuyến vận tải: ANBD\n\nGiá trị mới:\nTên khách hàng:   Chi nhánh Công ty TNHH Expeditors Việt Nam - CN Hà Nội\nMã tuyến vận tải: ĐĐHN'),
(229, 5, '2024-05-23 22:44:48', 'Thêm nhiên liệu:\nMã nhiên liệu: 1\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-23\nĐơn giá sau thuế: 1'),
(230, 5, '2024-05-23 22:44:54', 'Sửa thông tin nhiên liệu:\n\nGiá trị cũ:\nTên nhiên liệu: 1\nNgày áp dụng: 2024-05-23\nĐơn giá sau thuế: 1\n\nGiá trị mới:\nTên nhiên liệu: 12\nNgày áp dụng: 2024-05-25\nĐơn giá sau thuế: 12'),
(232, 5, '2024-05-24 09:20:35', 'Thêm đơn hàng:\nMã đơn hàng: 43\nMã nhân viên sale: 3\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: CN5555\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 10000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-24\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-05-24\nGiờ cắt máng: 00:00:00\nNgười giao nhận: gggg\nĐiện thoại: 011111\nThu thủ tục: 11111\nThu khác: 222222\nHạn thanh toán: 2024-05-28\nẢnh 1: \nẢnh 2: '),
(233, 5, '2024-05-24 09:21:37', 'Xóa thầu phụ:\nMã thầu phụ: 1\nTên: 12\nĐịa chỉ: 12\nSố điện thoại: 12\nMã số thuế: 12\nNhóm hàng vận chuyển: LCL'),
(234, 5, '2024-05-24 09:23:23', 'Sửa thông tin xe:\n\nGiá trị cũ:\nTrạng thái xe: OK\n\nGiá trị mới:\nTrạng thái xe: Đang sửa'),
(235, 5, '2024-05-24 09:23:38', 'Sửa thông tin xe:\n\nGiá trị cũ:\nTrạng thái xe: Đang sửa\n\nGiá trị mới:\nTrạng thái xe: OK'),
(236, 5, '2024-05-24 09:24:36', 'Thêm điều vận:\nMã điều vận: 14\nMã đơn hàng: 43\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 6\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(237, 5, '2024-05-24 09:26:34', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 16\nMã đơn hàng: 43\nNgày đổ nhiên liệu: 2024-05-24\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 246188\nGhi chú: ko'),
(238, 5, '2024-05-24 09:30:05', 'Thêm chi phí vận tải:\nMã cpvt: 14\nMã đơn hàng: 43\nPhí cầu đường: 20000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 5646188\nGhi chú: ko\n'),
(239, 5, '2024-05-24 09:34:21', 'Thêm tạm ứng:\nMã tạm ứng: 15\nMã đơn hàng: 43\nNgày tạm ứng: 2024-05-24\nMã nhân sự tạm ứng: 1\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: '),
(240, 5, '2024-05-24 09:34:45', 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:\nNgày thanh toán: 0000-00-00\nẢnh: \n\nGiá trị mới:\nNgày thanh toán: 2024-05-25\nẢnh: anhhoanung2.jpg'),
(241, 5, '2024-05-24 09:36:37', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nHãng tàu: Evergreen\nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\n\nGiá trị mới:\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 40HC'),
(242, 5, '2024-05-24 09:37:09', 'Sửa thông tin điều vận:\n\nGiá trị cũ:\nMã thầu phụ: PLJ-L\nMã xe: 6\nMã tài xế: DoVuong\nĐiện thoại tài xế: 1234569999\n\nGiá trị mới:\nMã thầu phụ: PLJ-F\nMã xe: 2\nMã tài xế: HoangBao\nĐiện thoại tài xế: 2147483647'),
(243, 5, '2024-05-25 19:02:32', 'Thêm đơn hàng:\nMã đơn hàng: 44\nMã nhân viên sale: 2\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 123\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 111111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ADHP\nCự ly: 25\nDầu tiêu thụ: 3.125\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: s\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-01\nẢnh 1: \nẢnh 2: '),
(244, 5, '2024-05-25 19:02:42', 'Xóa đơn hàng:\nMã đơn hàng: 44\nMã nhân viên sale: 2\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 123\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 111111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ADHP\nCự ly: 25\nDầu tiêu thụ: 3.125\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: s\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-01\nẢnh 1: \nẢnh 2: '),
(245, 5, '2024-05-25 19:06:04', 'Thêm đơn hàng:\nMã đơn hàng: 45\nMã nhân viên sale: 2\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 11\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 1.5T\nSố lượng: 1\nSố kg: 111111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: 1\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-05-26\nẢnh 1: \nẢnh 2: '),
(246, 5, '2024-05-25 19:06:11', 'Xóa đơn hàng:\nMã đơn hàng: 45\nMã nhân viên sale: 2\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 11\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 1.5T\nSố lượng: 1\nSố kg: 111111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: 1\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-05-26\nẢnh 1: \nẢnh 2: '),
(247, 5, '2024-05-25 19:10:40', 'Thêm đơn hàng:\nMã đơn hàng: 46\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 122221\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: 1\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-05-18\nẢnh 1: \nẢnh 2: '),
(248, 5, '2024-05-25 19:10:48', 'Xóa đơn hàng:\nMã đơn hàng: 46\nMã nhân viên sale: 31\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: 1\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 122221\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-05-18\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: 1\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-05-18\nẢnh 1: \nẢnh 2: '),
(249, 5, '2024-05-29 19:02:26', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 13811250\n\nGiá trị mới:\nTổng chi phí: 15836250'),
(250, 5, '2024-05-29 19:23:58', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 15836250\n\nGiá trị mới:\nTổng chi phí: 13811250'),
(251, 5, '2024-05-29 19:24:06', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 5646188\n\nGiá trị mới:\nTổng chi phí: 7146188'),
(252, 5, '2024-05-29 19:27:20', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 13811250\n\nGiá trị mới:\nTổng chi phí: 15836250'),
(253, 5, '2024-05-29 20:09:37', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 6995938\n\nGiá trị mới:\nTổng chi phí: 7495938'),
(254, 5, '2024-05-29 20:09:46', 'Sửa thông tin chi phí vận tải:\n\nGiá trị cũ:\nTổng chi phí: 7495938\n\nGiá trị mới:\nTổng chi phí: 6995938'),
(255, 5, '2024-06-03 20:29:11', 'Thêm đơn hàng:\nMã đơn hàng: 47\nMã nhân viên sale: 1\nMã khách hàng: GLS\nMã số thuế: 0304995011-001\nTên khách hàng: BKONCE134\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 20000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-03\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-06-07\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại: 0123336544\nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-20\nẢnh 1: \nẢnh 2: ');
INSERT INTO `nhatky` (`id_nhatky`, `id_nguoidung`, `thoigian`, `noidung`) VALUES
(256, 5, '2024-06-03 20:29:34', 'Thêm điều vận:\nMã điều vận: 15\nMã đơn hàng: 47\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: BuiChien\nĐiện thoại tài xế: 2147483647\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(257, 5, '2024-06-03 20:29:57', 'Thêm tạm ứng:\nMã tạm ứng: 16\nMã đơn hàng: 47\nNgày tạm ứng: 2024-06-03\nMã nhân sự tạm ứng: 31\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1000000\nTiền khác: 0\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: '),
(258, 5, '2024-06-03 20:30:11', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 17\nMã đơn hàng: 47\nNgày đổ nhiên liệu: 2024-06-03\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 246188\nGhi chú: '),
(259, 5, '2024-06-03 20:30:43', 'Thêm chi phí vận tải:\nMã cpvt: 15\nMã đơn hàng: 47\nPhí cầu đường: 50000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 11676188\nGhi chú: \n'),
(260, 5, '2024-06-03 21:01:27', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nHãng tàu: Evergreen\nẢnh: \n\nGiá trị mới:\nHãng tàu: \nẢnh: booking notice.jpg'),
(261, 5, '2024-06-03 21:50:04', 'Xóa tạm ứng:\nMã tạm ứng: 16\nMã đơn hàng: 47\nNgày tạm ứng: 2024-06-03\nMã nhân sự tạm ứng: 31\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1000000\nTiền khác: 0\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: '),
(262, 5, '2024-06-03 22:32:11', 'Thêm tạm ứng:\nMã tạm ứng: 17\nMã đơn hàng: 47\nNgày tạm ứng: 2024-06-03\nMã nhân sự tạm ứng: 1\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 0000-00-00\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: '),
(263, 5, '2024-06-09 14:46:41', 'Thêm khách hàng:\nMã đơn hàng: ANT\nMã nhân viên sale: CÔNG TY CỔ PHẦN CHUYỂN HÀNG NHANH ANTS\nMã khách hàng: Số 8 ngõ 309 đường Nguyễn Đức Thuận, Thị trấn Trâu Quỳ, Huyện Gia Lâm, TP. Hà Nội, Việt Nam\nMã số thuế: \nTên khách hàng: \nLoại hàng: 0109193913\nHãng tàu: Ngân hàng BIDV- Chi nhánh Từ Liêm\nNhóm hàng hóa: 21710000664353\nHàng hóa: Ông Hoàng Cao Thế\nSố lượng: \nSố kg: ADHP'),
(264, 5, '2024-06-09 14:47:13', 'Thêm khách hàng:\nMã đơn hàng: DKC\nMã nhân viên sale: Công Ty TNHH và Giao Nhận Vận tải Đức Khánh\nMã khách hàng: số 135+136 lô 9 tái định cư,Phường Đằng Hải, Hải An ,HP\nMã số thuế: \nTên khách hàng: \nLoại hàng: 0201861009\nHãng tàu: \nNhóm hàng hóa: \nHàng hóa: Mr Khánh\nSố lượng: \nSố kg: ADHP'),
(265, 5, '2024-06-09 14:48:13', 'Thêm khách hàng:\nMã đơn hàng: HHH\nMã nhân viên sale: CHI NHÁNH CÔNG TY CỔ PHẦN HÀNG HẢI TIÊU ĐIỂM TẠI HÀ NỘI\nMã khách hàng: Số 1A-A1 Phố Thái Thịnh, Phường Láng Hạ, Quận Đống Đa, Thành phố Hà Nội, Việt Nam\nMã số thuế: \nTên khách hàng: \nLoại hàng: 0304948188-001\nHãng tàu: \nNhóm hàng hóa: \nHàng hóa: Bà Nhật Anh\nSố lượng: \nSố kg: VPHN'),
(266, 5, '2024-06-09 14:49:03', 'Thêm khách hàng:\nMã đơn hàng: HXC-L\nMã nhân viên sale: Công ty CP Thương mại Hoàng Xuân\nMã khách hàng: Số 16 lô E ngõ tập thể 19/5 đường Lê Thánh Tông, Phường Máy Tơ, Quận Ngô Quyền, Hải Phòng\nMã số thuế: \nTên khách hàng: \nLoại hàng: 0200727995\nHãng tàu: \nNhóm hàng hóa: \nHàng hóa: Ông Bùi Việt Hoàn\nSố lượng: \nSố kg: ADHP'),
(267, 5, '2024-06-09 14:49:59', 'Thêm khách hàng:\nMã đơn hàng: NCC00399\nMã nhân viên sale: CÔNG TY TNHH VẬN TẢI HOÀNG BẢO HUY\nMã khách hàng: 106 Tuệ Tĩnh, Phường Nam Thành, TP Ninh Bình, Tỉnh Ninh Bình, Việt Nam\nMã số thuế: \nTên khách hàng: \nLoại hàng: 27007413\nHãng tàu: Ngân hàng TM CP Ngoại thương Việt Nam- Chi Nhánh Ninh Bình\nNhóm hàng hóa: 0221000014389\nHàng hóa: Mr Tiến Trễ\nSố lượng: \nSố kg: ANBD'),
(268, 5, '2024-06-09 14:53:27', 'Thêm nhân sự:\nMã nhân sự: 33.sales.DangAnh\nTên: Đặng Châu Anh\nPhòng ban: Phòng Chăm sóc khách hàng\nChức vụ: Chăm sóc khách hàng\nNguyên quán: Thanh Oai, Hà Nội\nĐịa chỉ thường trú: Số 4 Lạch Tray, Lạch Tray, Ngô Quyền, Hải Phòng\nNgày sinh: 1998-06-09\nCMND: '),
(269, 5, '2024-06-09 14:54:45', 'Thêm nhân sự:\nMã nhân sự: 34.ktoan.HaPhuong\nTên: Phạm Thị Hà Phương\nPhòng ban: phòng kế toán\nChức vụ: kế toán\nNguyên quán: Đông Hưng, Thái Bình\nĐịa chỉ thường trú: 16/727 Ngô Gia Tự, Phường Đằng lâm, Quận Hải An, HP\nNgày sinh: 1999-12-09\nCMND: 03119300076'),
(270, 5, '2024-06-09 14:57:17', 'Thêm tuyến vận tải:\nMã tuyến vận tải: BDHP\nTên tuyến vận tải: CHP<->Ba Đình (HN)\nĐiểm đầu: CHP\nMã tỉnh thành đầu: HPG\nĐiểm cuối:Ba Đình\nMã tỉnh thành cuối: HNI\nCự ly: 112\nDầu tiêu thụ: 14\nGhi chú: '),
(271, 5, '2024-06-09 14:58:02', 'Thêm tuyến vận tải:\nMã tuyến vận tải: CHPNS\nTên tuyến vận tải: CHP<->KCN Nam Sách (HD)\nĐiểm đầu: CHP\nMã tỉnh thành đầu: HPG\nĐiểm cuối:KCN Nam Sách (HD)\nMã tỉnh thành cuối: HDG\nCự ly: 52\nDầu tiêu thụ: 6.5\nGhi chú: '),
(272, 5, '2024-06-09 15:05:50', 'Thêm đơn hàng:\nMã đơn hàng: 48\nMã nhân viên sale: 33\nMã khách hàng: HXC-L\nMã số thuế: 0200727995\nTên khách hàng: BK1239N4\nLoại hàng: 2\nHãng tàu: Evergreen\nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 15000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ĐĐHN\nCự ly: 120\nDầu tiêu thụ: 15\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Hoàng Huy\nĐiện thoại: 0339521547\nThu thủ tục: 100000\nThu khác: 150000\nHạn thanh toán: 2024-06-14\nẢnh 1: \nẢnh 2: '),
(273, 5, '2024-06-09 15:08:06', 'Thêm đơn hàng:\nMã đơn hàng: 49\nMã nhân viên sale: 31\nMã khách hàng: ANT\nMã số thuế: 0109193913\nTên khách hàng: BK76FB\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 10000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-01\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: CHPNS\nCự ly: 52\nDầu tiêu thụ: 6.5\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại: 0126664889\nThu thủ tục: 0\nThu khác: 200000\nHạn thanh toán: 2024-06-23\nẢnh 1: \nẢnh 2: '),
(274, 5, '2024-06-09 15:12:53', 'Thêm đơn hàng:\nMã đơn hàng: 50\nMã nhân viên sale: 3\nMã khách hàng: EXP\nMã số thuế: 0312545104-001\nTên khách hàng: Bk864GHD\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 22000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-06\nGiờ đóng cont: 15:14:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Đỗ Khải Hoàn\nĐiện thoại: \nThu thủ tục: 120000\nThu khác: 0\nHạn thanh toán: 2024-06-27\nẢnh 1: \nẢnh 2: '),
(275, 5, '2024-06-09 15:15:14', 'Thêm đơn hàng:\nMã đơn hàng: 51\nMã nhân viên sale: 1\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: BKND96765F\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 13000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ADHP\nCự ly: 25\nDầu tiêu thụ: 3.125\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Nguyễn Khang\nĐiện thoại: 0126664889\nThu thủ tục: 0\nThu khác: 100000\nHạn thanh toán: 2024-06-29\nẢnh 1: \nẢnh 2: '),
(276, 5, '2024-06-09 15:17:42', 'Thêm hãng tàu:\nMã hãng tàu: Maersk\nTên hãng tàu: Maersk\n'),
(277, 5, '2024-06-09 15:18:51', 'Thêm hãng tàu:\nMã hãng tàu: OOCL\nTên hãng tàu: OOCL\n'),
(278, 5, '2024-06-09 15:19:07', 'Thêm hãng tàu:\nMã hãng tàu: CMA-CGM\nTên hãng tàu: CMA-CGM\n'),
(279, 5, '2024-06-09 15:19:19', 'Thêm hãng tàu:\nMã hãng tàu: Tân Cảng SG\nTên hãng tàu: Tân Cảng SG\n'),
(280, 5, '2024-06-09 15:19:31', 'Thêm hãng tàu:\nMã hãng tàu: Macs\nTên hãng tàu: Macs\n'),
(281, 5, '2024-06-09 15:19:43', 'Thêm hãng tàu:\nMã hãng tàu: Hải An\nTên hãng tàu: Hải An\n'),
(282, 5, '2024-06-09 15:19:57', 'Thêm hãng tàu:\nMã hãng tàu: Apectrans\nTên hãng tàu: Apectrans\n'),
(283, 5, '2024-06-09 15:20:44', 'Thêm hãng tàu:\nMã hãng tàu: HMM\nTên hãng tàu: HMM\n'),
(284, 5, '2024-06-09 15:23:11', 'Thêm đơn hàng:\nMã đơn hàng: 52\nMã nhân viên sale: 1\nMã khách hàng: APT\nMã số thuế: 0202169016\nTên khách hàng: HANA07129400\nLoại hàng: 2\nHãng tàu: HMM\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 20000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: BDHP\nCự ly: 112\nDầu tiêu thụ: 14\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Ngọc Đinh\nĐiện thoại: 0129857444\nThu thủ tục: 100000\nThu khác: 0\nHạn thanh toán: 2024-06-28\nẢnh 1: booking notice.jpg\nẢnh 2: phiếu giao nhận container điện tử.jpg'),
(285, 5, '2024-06-09 15:24:29', 'Thêm đơn hàng:\nMã đơn hàng: 53\nMã nhân viên sale: 1\nMã khách hàng: HXC-L\nMã số thuế: 0200727995\nTên khách hàng: BK78NMN12NN\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 1.5T\nSố lượng: 1\nSố kg: 10000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: CHPNS\nCự ly: 52\nDầu tiêu thụ: 6.5\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Hoàng Thiên\nĐiện thoại: 0339527489\nThu thủ tục: 0\nThu khác: 210000\nHạn thanh toán: 2024-06-29\nẢnh 1: \nẢnh 2: '),
(286, 5, '2024-06-09 15:25:43', 'Thêm đơn hàng:\nMã đơn hàng: 54\nMã nhân viên sale: 34\nMã khách hàng: DKC\nMã số thuế: 0201861009\nTên khách hàng: BK980EXPAA\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 12000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-08\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: BDHP\nCự ly: 112\nDầu tiêu thụ: 14\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Đỗ Khải Hoàn\nĐiện thoại: 0126664889\nThu thủ tục: 120000\nThu khác: 0\nHạn thanh toán: 2024-06-30\nẢnh 1: \nẢnh 2: '),
(287, 5, '2024-06-09 15:27:06', 'Thêm đơn hàng:\nMã đơn hàng: 55\nMã nhân viên sale: 33\nMã khách hàng: EXP\nMã số thuế: 0312545104-001\nTên khách hàng: BK78NMNZ\nLoại hàng: 2\nHãng tàu: Maersk\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 20000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-01\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ANBD\nCự ly: 1100\nDầu tiêu thụ: 137.5\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Nguyễn Khang\nĐiện thoại: 0126664889\nThu thủ tục: 122000\nThu khác: 210000\nHạn thanh toán: 2024-06-30\nẢnh 1: \nẢnh 2: '),
(288, 5, '2024-06-09 15:28:23', 'Thêm đơn hàng:\nMã đơn hàng: 56\nMã nhân viên sale: 3\nMã khách hàng: NCC00399\nMã số thuế: 27007413\nTên khách hàng: BK56PL\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 20RF\nSố lượng: 1\nSố kg: 10000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-01\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ĐĐHN\nCự ly: 120\nDầu tiêu thụ: 15\nNgày cắt máng: 2024-06-05\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Vũ Văn Chiến\nĐiện thoại: 0126664889\nThu thủ tục: 0\nThu khác: 410000\nHạn thanh toán: 2024-06-21\nẢnh 1: \nẢnh 2: '),
(289, 5, '2024-06-09 15:29:34', 'Thêm đơn hàng:\nMã đơn hàng: 57\nMã nhân viên sale: 33\nMã khách hàng: DKC\nMã số thuế: 0201861009\nTên khách hàng: BK78NMNS\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 9000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 18:28:00\nMã tuyến vận tải: ADHP\nCự ly: 25\nDầu tiêu thụ: 3.125\nNgày cắt máng: 2024-06-09\nGiờ cắt máng: 22:32:00\nNgười giao nhận: Đỗ Khải Hoàn\nĐiện thoại: 0126664889\nThu thủ tục: 0\nThu khác: 100000\nHạn thanh toán: 2024-06-29\nẢnh 1: \nẢnh 2: '),
(290, 5, '2024-06-09 15:30:38', 'Thêm đơn hàng:\nMã đơn hàng: 58\nMã nhân viên sale: 3\nMã khách hàng: HHH\nMã số thuế: 0304948188-001\nTên khách hàng: BK56PL22\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 20000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-01\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-06-05\nGiờ cắt máng: 15:32:00\nNgười giao nhận: Trần Quốc\nĐiện thoại: 0126664889\nThu thủ tục: 0\nThu khác: 210000\nHạn thanh toán: 2024-06-30\nẢnh 1: \nẢnh 2: '),
(291, 5, '2024-06-09 15:31:44', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nẢnh 1: \n\nGiá trị mới:\nẢnh 1: phiếu đổ dầu.jpg'),
(292, 5, '2024-06-09 15:33:18', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 01234569999\n\nGiá trị mới:\nSố đt: 0339527145'),
(293, 5, '2024-06-09 15:33:23', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 01299825\n\nGiá trị mới:\nSố đt: 0339527178'),
(294, 5, '2024-06-09 15:33:29', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 03333333333\n\nGiá trị mới:\nSố đt: 033512447'),
(295, 5, '2024-06-09 15:33:36', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 0339527178\n\nGiá trị mới:\nSố đt: 033952717'),
(296, 5, '2024-06-09 15:33:39', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 0339527145\n\nGiá trị mới:\nSố đt: 033952714'),
(297, 5, '2024-06-09 15:33:44', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 033512447\n\nGiá trị mới:\nSố đt: 0335124471'),
(298, 5, '2024-06-09 15:33:46', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 033952717\n\nGiá trị mới:\nSố đt: 0339527171'),
(299, 5, '2024-06-09 15:33:49', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 033952714\n\nGiá trị mới:\nSố đt: 0339527143'),
(300, 5, '2024-06-09 15:33:56', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 06666666666\n\nGiá trị mới:\nSố đt: 033124789'),
(301, 5, '2024-06-09 15:33:59', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 033124789\n\nGiá trị mới:\nSố đt: 0331247891'),
(302, 5, '2024-06-09 15:34:03', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 01234567777\n\nGiá trị mới:\nSố đt: 012345677'),
(303, 5, '2024-06-09 15:34:09', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 012345677\n\nGiá trị mới:\nSố đt: 0123456779'),
(304, 5, '2024-06-09 15:34:16', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 0123456\n\nGiá trị mới:\nSố đt: 033456145'),
(305, 5, '2024-06-09 15:34:20', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 033456145\n\nGiá trị mới:\nSố đt: 0334561457'),
(306, 5, '2024-06-09 15:34:26', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 0321456\n\nGiá trị mới:\nSố đt: 03394527489'),
(307, 5, '2024-06-09 15:34:31', 'Sửa thông tin tài xế:\n\nGiá trị cũ:\nSố đt: 03394527489\n\nGiá trị mới:\nSố đt: 0339452748'),
(308, 5, '2024-06-09 15:35:41', 'Thêm điều vận:\nMã điều vận: 16\nMã đơn hàng: 58\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 335124471\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(309, 5, '2024-06-09 15:36:44', 'Thêm điều vận:\nMã điều vận: 17\nMã đơn hàng: 57\nMã thầu phụ: CTY-L\nMã số thuế: 0201734748\nTên thầu phụ: Công ty CP City Delivery \nMã xe: 11\nMã tài xế: NhatBao\nĐiện thoại tài xế: 123456779\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(310, 5, '2024-06-09 15:37:13', 'Thêm điều vận:\nMã điều vận: 18\nMã đơn hàng: 56\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 5\nMã tài xế: NgocDoan\nĐiện thoại tài xế: 339527171\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(311, 5, '2024-06-09 15:37:31', 'Thêm điều vận:\nMã điều vận: 19\nMã đơn hàng: 55\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 5\nMã tài xế: NgocDoan\nĐiện thoại tài xế: 339527171\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(312, 5, '2024-06-09 15:37:48', 'Thêm điều vận:\nMã điều vận: 20\nMã đơn hàng: 54\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: BuiChien\nĐiện thoại tài xế: 331247891\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(313, 5, '2024-06-09 15:38:03', 'Thêm điều vận:\nMã điều vận: 21\nMã đơn hàng: 53\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 6\nMã tài xế: DoVuong\nĐiện thoại tài xế: 339527143\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(314, 5, '2024-06-09 15:38:21', 'Thêm điều vận:\nMã điều vận: 22\nMã đơn hàng: 52\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 335124471\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(315, 5, '2024-06-09 15:38:42', 'Thêm điều vận:\nMã điều vận: 23\nMã đơn hàng: 51\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: BuiChien\nĐiện thoại tài xế: 331247891\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(316, 5, '2024-06-09 15:39:10', 'Thêm điều vận:\nMã điều vận: 24\nMã đơn hàng: 50\nMã thầu phụ: GPT-F\nMã số thuế: 0201255664\nTên thầu phụ: Công ty CP Vận tải Đối tác Toàn Cầu\nMã xe: 1\nMã tài xế: QuocDanh\nĐiện thoại tài xế: 339452748\nTình trạng đơn hàng: Kết hợp\nSố đơn kết hợp: 1\n'),
(317, 5, '2024-06-09 15:39:29', 'Thêm điều vận:\nMã điều vận: 25\nMã đơn hàng: 49\nMã thầu phụ: PLJ-L\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 6\nMã tài xế: DoVuong\nĐiện thoại tài xế: 339527143\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(318, 5, '2024-06-09 15:39:45', 'Thêm điều vận:\nMã điều vận: 26\nMã đơn hàng: 48\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 335124471\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(319, 5, '2024-06-09 15:40:17', 'Thêm tạm ứng:\nMã tạm ứng: 18\nMã đơn hàng: 58\nNgày tạm ứng: 2024-06-09\nMã nhân sự tạm ứng: 34\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 2024-06-15\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: anhhoanung1.jpg'),
(320, 5, '2024-06-09 15:40:54', 'Thêm tạm ứng:\nMã tạm ứng: 19\nMã đơn hàng: 57\nNgày tạm ứng: 2024-06-10\nMã nhân sự tạm ứng: 1\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 0\nTiền khác: 400000\nNgày thanh toán: 2024-06-14\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: anhhoanung2.jpg'),
(321, 5, '2024-06-09 15:41:45', 'Thêm tạm ứng:\nMã tạm ứng: 20\nMã đơn hàng: 56\nNgày tạm ứng: 2024-06-09\nMã nhân sự tạm ứng: 33\nTiền cước vỏ: 400000\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 2024-06-09\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: anhhoanung1.jpg'),
(322, 5, '2024-06-09 15:42:16', 'Thêm tạm ứng:\nMã tạm ứng: 21\nMã đơn hàng: 55\nNgày tạm ứng: 2024-06-09\nMã nhân sự tạm ứng: 3\nTiền cước vỏ: 1000000\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 2024-06-09\nGiờ thanh toán: 00:00:00\nGhi chú: Ảnh: anhhoanung2.jpg'),
(323, 5, '2024-06-09 15:43:01', 'Thêm tạm ứng:\nMã tạm ứng: 22\nMã đơn hàng: 52\nNgày tạm ứng: 2024-06-09\nMã nhân sự tạm ứng: 31\nTiền cước vỏ: 0\nTiền hải quan: 0\nTiền nâng hạ: 1500000\nTiền khác: 0\nNgày thanh toán: 2024-06-09\nGiờ thanh toán: 15:45:00\nGhi chú: Ảnh: anhhoanung2.jpg'),
(324, 5, '2024-06-09 15:43:24', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 18\nMã đơn hàng: 58\nNgày đổ nhiên liệu: 2024-06-09\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 246188\nGhi chú: '),
(325, 5, '2024-06-09 15:43:42', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 19\nMã đơn hàng: 57\nNgày đổ nhiên liệu: 2024-06-07\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 3.125\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 60938\nGhi chú: '),
(326, 5, '2024-06-09 15:43:55', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 20\nMã đơn hàng: 56\nNgày đổ nhiên liệu: 2024-06-05\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 15\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 292500\nGhi chú: '),
(327, 5, '2024-06-09 15:44:05', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 21\nMã đơn hàng: 55\nNgày đổ nhiên liệu: 2024-06-03\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 137.5\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 2681250\nGhi chú: '),
(328, 5, '2024-06-09 15:44:13', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 22\nMã đơn hàng: 54\nNgày đổ nhiên liệu: 2024-06-09\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 14\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 273000\nGhi chú: '),
(329, 5, '2024-06-09 15:44:24', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 23\nMã đơn hàng: 53\nNgày đổ nhiên liệu: 2024-06-06\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 6.5\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 126750\nGhi chú: '),
(330, 5, '2024-06-09 15:44:33', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 24\nMã đơn hàng: 52\nNgày đổ nhiên liệu: 2024-06-03\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 14\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 273000\nGhi chú: '),
(331, 5, '2024-06-09 15:44:42', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 25\nMã đơn hàng: 51\nNgày đổ nhiên liệu: 2024-06-02\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 3.125\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 60938\nGhi chú: '),
(332, 5, '2024-06-09 15:44:51', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 26\nMã đơn hàng: 50\nNgày đổ nhiên liệu: 2024-06-03\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 246188\nGhi chú: '),
(333, 5, '2024-06-09 15:45:02', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 27\nMã đơn hàng: 49\nNgày đổ nhiên liệu: 2024-06-01\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 6.5\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 126750\nGhi chú: '),
(334, 5, '2024-06-09 15:45:32', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 28\nMã đơn hàng: 48\nNgày đổ nhiên liệu: 2024-06-02\nMã đơn vị cung cấp dầu: HFC\nSố lượng nhiên liệu: 15\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 292500\nGhi chú: '),
(335, 5, '2024-06-09 15:45:37', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nẢnh 1: \n\nGiá trị mới:\nẢnh 1: phiếu đổ dầu.jpg'),
(336, 5, '2024-06-09 15:47:51', 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:\nẢnh 1: \n\nGiá trị mới:\nẢnh 1: 1233.png'),
(337, 5, '2024-06-09 15:49:53', 'Thêm sửa chữa:\nMã sửa chữa: 14\nMã xe: 3\nNgày sửa chữa: 2024-06-01 00:00:00\nSố km đồng hồ: 123455\nNội dung sửa chữa: thay Còi điện\nĐơn giá vật tư: 250000\nTiền nhân công: 0\nSố lượng: 1\nNgười sửa chữa: Ngọc Tuân\nThời gian bảo hành: 0000-00-00\nTổng tiền: 250000\nẢnh 1: \nGhi chú: '),
(338, 5, '2024-06-09 15:50:30', 'Thêm sửa chữa:\nMã sửa chữa: 15\nMã xe: 4\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 7775\nNội dung sửa chữa: thay 1 bát phanh đạp\nĐơn giá vật tư: 100000\nTiền nhân công: 23000\nSố lượng: 1\nNgười sửa chữa: long\nThời gian bảo hành: 0000-00-00\nTổng tiền: 123000\nẢnh 1: \nGhi chú: '),
(339, 5, '2024-06-09 15:51:04', 'Thêm sửa chữa:\nMã sửa chữa: 16\nMã xe: 2\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 7775\nNội dung sửa chữa: Bút xông còi hơi\nĐơn giá vật tư: 355000\nTiền nhân công: 20000\nSố lượng: 1\nNgười sửa chữa: thiên\nThời gian bảo hành: 0000-00-00\nTổng tiền: 375000\nẢnh 1: \nGhi chú: '),
(340, 5, '2024-06-09 15:52:21', 'Thêm sửa chữa:\nMã sửa chữa: 17\nMã xe: 4\nNgày sửa chữa: 2024-06-04 00:00:00\nSố km đồng hồ: 1200\nNội dung sửa chữa: Thay 2 quả lốc kê đầu kéo + mooc\nĐơn giá vật tư: 600000\nTiền nhân công: 30000\nSố lượng: 2\nNgười sửa chữa: Ngọc Tuân\nThời gian bảo hành: 2024-07-04\nTổng tiền: 1230000\nẢnh 1: \nGhi chú: '),
(341, 5, '2024-06-09 15:52:28', 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:\nSố km đồng hồ: 123455\n\nGiá trị mới:\nSố km đồng hồ: 1222'),
(342, 5, '2024-06-09 15:53:27', 'Thêm sửa chữa:\nMã sửa chữa: 18\nMã xe: 2\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 7775\nNội dung sửa chữa: Thay 1 bát phanh + nối đường hơi mooc\nĐơn giá vật tư: 250000\nTiền nhân công: 30000\nSố lượng: 1\nNgười sửa chữa: Đoàn Chiến\nThời gian bảo hành: 0000-00-00\nTổng tiền: 280000\nẢnh 1: \nGhi chú: '),
(343, 5, '2024-06-09 15:53:56', 'Thêm sửa chữa:\nMã sửa chữa: 19\nMã xe: 3\nNgày sửa chữa: 2024-06-09 00:00:00\nSố km đồng hồ: 6300\nNội dung sửa chữa: Thay zắc co ba trục + zắc nối + van khóa chế cả bóng hơi\nĐơn giá vật tư: 355000\nTiền nhân công: 20000\nSố lượng: 1\nNgười sửa chữa: \nThời gian bảo hành: 0000-00-00\nTổng tiền: 375000\nẢnh 1: \nGhi chú: '),
(344, 5, '2024-06-09 15:54:34', 'Thêm chi phí vận tải:\nMã cpvt: 16\nMã đơn hàng: 58\nPhí cầu đường: 20000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 12146188\nGhi chú: \n'),
(345, 5, '2024-06-09 15:55:17', 'Thêm chi phí vận tải:\nMã cpvt: 17\nMã đơn hàng: 57\nPhí cầu đường: 0\nTiền ăn ca: 60000\nLương chuyến: 0\nLương chủ nhật: 420000\nTiền thuê xe ngoài: 120000\nTổng chi phí: 5560938\nGhi chú: \n'),
(346, 5, '2024-06-09 15:55:53', 'Thêm chi phí vận tải:\nMã cpvt: 18\nMã đơn hàng: 56\nPhí cầu đường: 70000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 1200000\nTổng chi phí: 8842500\nGhi chú: \n'),
(347, 5, '2024-06-09 15:56:22', 'Thêm chi phí vận tải:\nMã cpvt: 19\nMã đơn hàng: 55\nPhí cầu đường: 20000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 1200000\nTổng chi phí: 16781250\nGhi chú: \n'),
(348, 5, '2024-06-09 15:56:37', 'Thêm chi phí vận tải:\nMã cpvt: 20\nMã đơn hàng: 54\nPhí cầu đường: 30000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 6683000\nGhi chú: \n'),
(349, 5, '2024-06-09 15:57:05', 'Thêm chi phí vận tải:\nMã cpvt: 21\nMã đơn hàng: 53\nPhí cầu đường: 40000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 5546750\nGhi chú: \n'),
(350, 5, '2024-06-09 15:57:18', 'Thêm chi phí vận tải:\nMã cpvt: 22\nMã đơn hàng: 52\nPhí cầu đường: 60000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 12213000\nGhi chú: \n'),
(351, 5, '2024-06-09 15:57:33', 'Thêm chi phí vận tải:\nMã cpvt: 23\nMã đơn hàng: 51\nPhí cầu đường: 60000\nTiền ăn ca: 60000\nLương chuyến: 0\nLương chủ nhật: 420000\nTiền thuê xe ngoài: 0\nTổng chi phí: 7100938\nGhi chú: \n'),
(352, 5, '2024-06-09 15:58:12', 'Thêm chi phí vận tải:\nMã cpvt: 24\nMã đơn hàng: 50\nPhí cầu đường: 20000\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 2300000\nTổng chi phí: 13946188\nGhi chú: \n'),
(353, 5, '2024-06-09 15:58:32', 'Thêm chi phí vận tải:\nMã cpvt: 25\nMã đơn hàng: 49\nPhí cầu đường: 0\nTiền ăn ca: 60000\nLương chuyến: 320000\nLương chủ nhật: 0\nTiền thuê xe ngoài: 0\nTổng chi phí: 5506750\nGhi chú: \n'),
(354, 5, '2024-06-09 15:58:57', 'Thêm chi phí vận tải:\nMã cpvt: 26\nMã đơn hàng: 48\nPhí cầu đường: 90000\nTiền ăn ca: 60000\nLương chuyến: 0\nLương chủ nhật: 420000\nTiền thuê xe ngoài: 0\nTổng chi phí: 8362500\nGhi chú: \n'),
(355, 5, '2024-06-09 15:59:56', 'Sửa thông tin tạm ứng:\n\nGiá trị cũ:\nTiền hải quan: 0\n\nGiá trị mới:\nTiền hải quan: 1000000'),
(356, 5, '2024-06-09 16:51:52', 'Thêm đơn hàng:\nMã đơn hàng: 59\nMã nhân viên sale: 34\nMã khách hàng: DKC\nMã số thuế: 0201861009\nTên khách hàng: BK56PL\nLoại hàng: 3\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 10000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-09\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: ĐĐHN\nCự ly: 120\nDầu tiêu thụ: 15\nNgày cắt máng: 0000-00-00\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Trần Quốc Chung\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-29\nẢnh 1: \nẢnh 2: '),
(357, 5, '2024-06-09 16:51:58', 'Sửa thông tin đơn hàng:\n\nGiá trị cũ:\nTrạng thái: Hoàn thành\n\nGiá trị mới:\nTrạng thái: Hủy'),
(358, 5, '2024-06-10 11:31:40', 'Thêm đơn hàng:\nMã đơn hàng: 60\nMã nhân viên sale: 1\nMã khách hàng: ANT\nMã số thuế: 0109193913\nTên khách hàng: BK78NMNqqq\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 40000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-10\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-06-12\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Ngọc\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 100000\nHạn thanh toán: 2024-06-27\nẢnh 1: \nẢnh 2: '),
(359, 5, '2024-06-10 11:32:36', 'Sửa thông tin xe:\n\nGiá trị cũ:\nTrạng thái xe: OK\n\nGiá trị mới:\nTrạng thái xe: Đang sửa'),
(360, 5, '2024-06-10 11:33:08', 'Thêm điều vận:\nMã điều vận: 27\nMã đơn hàng: 60\nMã thầu phụ: PLJ-F\nMã số thuế: 0201249276\nTên thầu phụ: Công ty CP Tiếp vận Thái Bình Dương\nMã xe: 4\nMã tài xế: HoangBao\nĐiện thoại tài xế: 335124471\nTình trạng đơn hàng: Đơn\nSố đơn kết hợp: 0\n'),
(361, 5, '2024-06-10 11:33:46', 'Thêm phiếu đổ nhiên liệu:\nMã phiếu đổ nhiên liệu: 29\nMã đơn hàng: 60\nNgày đổ nhiên liệu: 2024-06-10\nMã đơn vị cung cấp dầu: KVNS\nSố lượng nhiên liệu: 12.625\nMã nhiên liệu: DO\nẢnh 1: \nThành tiền: 246188\nGhi chú: '),
(362, 5, '2024-06-11 14:26:55', 'Thêm đơn hàng:\nMã đơn hàng: 61\nMã nhân viên sale: 1\nMã khách hàng: NCC00399\nMã số thuế: 27007413\nTên khách hàng: 123\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 1111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-11\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: CHPNS\nCự ly: 52\nDầu tiêu thụ: 6.5\nNgày cắt máng: 2024-06-11\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Đỗ Khải Hoàn\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-30\nẢnh 1: \nẢnh 2: '),
(363, 5, '2024-06-13 14:02:27', 'Xóa đơn hàng:\nMã đơn hàng: 61\nMã nhân viên sale: 1\nMã khách hàng: NCC00399\nMã số thuế: 27007413\nTên khách hàng: 123\nLoại hàng: 1\nHãng tàu: \nNhóm hàng hóa: LCL\nHàng hóa: 2.5T\nSố lượng: 1\nSố kg: 1111\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-11\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: CHPNS\nCự ly: 52\nDầu tiêu thụ: 6.5\nNgày cắt máng: 2024-06-11\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Đỗ Khải Hoàn\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 0\nHạn thanh toán: 2024-06-30\nẢnh 1: \nẢnh 2: '),
(364, 5, '2024-06-13 14:02:58', 'Xóa đơn hàng:\nMã đơn hàng: 60\nMã nhân viên sale: 1\nMã khách hàng: ANT\nMã số thuế: 0109193913\nTên khách hàng: BK78NMNqqq\nLoại hàng: 2\nHãng tàu: COSCO\nNhóm hàng hóa: FCL\nHàng hóa: 40HC\nSố lượng: 1\nSố kg: 40000\nTrạng thái: Hoàn thành\nNgày đóng cont: 2024-06-10\nGiờ đóng cont: 00:00:00\nMã tuyến vận tải: VPHN\nCự ly: 101\nDầu tiêu thụ: 12.625\nNgày cắt máng: 2024-06-12\nGiờ cắt máng: 00:00:00\nNgười giao nhận: Ngọc\nĐiện thoại: \nThu thủ tục: 0\nThu khác: 100000\nHạn thanh toán: 2024-06-27\nẢnh 1: \nẢnh 2: ');

-- --------------------------------------------------------

--
-- Table structure for table `nhienlieu`
--

CREATE TABLE `nhienlieu` (
  `id_nhienlieu` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngayapdung` date DEFAULT NULL,
  `dongiasauthue` decimal(10,0) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhienlieu`
--

INSERT INTO `nhienlieu` (`id_nhienlieu`, `ten`, `ngayapdung`, `dongiasauthue`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('DO', 'Dầu DO', '2024-03-15', 19500, '2024-03-11 14:35:02', 3, '2024-05-22 09:19:32', 5);

--
-- Triggers `nhienlieu`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_nhienlieu` AFTER DELETE ON `nhienlieu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa nhiên liệu:\n',
  
                        'Mã nhiên liệu: ', OLD.id_nhienlieu, '\n',
                       'Tên nhiên liệu: ', OLD.ten, '\n',
                       'Ngày áp dụng: ', OLD.ngayapdung, '\n',
                       'Đơn giá sau thuế: ', OLD.dongiasauthue
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_nhienlieu` AFTER INSERT ON `nhienlieu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm nhiên liệu:\n',
  
                        'Mã nhiên liệu: ', NEW.id_nhienlieu, '\n',
                       'Tên nhiên liệu: ', NEW.ten, '\n',
                       'Ngày áp dụng: ', NEW.ngayapdung, '\n',
                       'Đơn giá sau thuế: ', NEW.dongiasauthue
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_nhienlieu` AFTER UPDATE ON `nhienlieu` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên nhiên liệu: ', OLD.ten);
    SET new_values = CONCAT('\nTên nhiên liệu: ', NEW.ten);
  END IF;
  
  IF OLD.ngayapdung != NEW.ngayapdung THEN
    SET old_values = CONCAT(old_values, '\nNgày áp dụng: ', OLD.ngayapdung);
    SET new_values = CONCAT(new_values, '\nNgày áp dụng: ', NEW.ngayapdung);
  END IF;
  
  IF OLD.dongiasauthue != NEW.dongiasauthue THEN
    SET old_values = CONCAT(old_values, '\nĐơn giá sau thuế: ', OLD.dongiasauthue);
    SET new_values = CONCAT(new_values, '\nĐơn giá sau thuế: ', NEW.dongiasauthue);
  END IF;
  
  
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin nhiên liệu:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `nhomhanghoa`
--

CREATE TABLE `nhomhanghoa` (
  `id_nhomhanghoa` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhomhanghoa`
--

INSERT INTO `nhomhanghoa` (`id_nhomhanghoa`, `ten`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('FCL', 'FCL', '2024-03-11 15:34:47', 3, NULL, NULL),
('LCL', 'LCL', '2024-03-11 15:34:47', 3, NULL, NULL);

--
-- Triggers `nhomhanghoa`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_nhomhanghoa` AFTER DELETE ON `nhomhanghoa` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;


  SET noidung = CONCAT('Xóa nhóm hàng hóa:\n',
  
                        'Mã nhóm hàng hóa: ', OLD.id_nhomhanghoa, '\n',
                       'Tên nhóm hàng hóa: ', OLD.ten
                      
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_nhomhanghoa` AFTER INSERT ON `nhomhanghoa` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm nhóm hàng hóa:\n',
  
                        'Mã nhóm hàng hóa: ', NEW.id_nhomhanghoa, '\n',
                       'Tên nhóm hàng hóa: ', NEW.ten
                      
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_nhonhanghoa` AFTER UPDATE ON `nhomhanghoa` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên nhóm hàng hóa: ', OLD.ten);
    SET new_values = CONCAT('\nTên nhóm hàng hóa: ', NEW.ten);
  END IF;
  
 
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin nhóm hàng hóa:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `nhomxe`
--

CREATE TABLE `nhomxe` (
  `id_nhomxe` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nhomxe`
--

INSERT INTO `nhomxe` (`id_nhomxe`, `ten`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('daukeo', 'Đầu kéo', '2024-03-11 15:12:23', 5, '2024-03-28 10:48:00', NULL),
('nhomxengoai', 'Nhóm xe ngoài', '2024-03-11 15:12:23', 5, '2024-04-24 20:42:54', NULL),
('x2c2', 'Xe cont 2 cầu 2 dàn', '2024-03-11 15:12:23', 5, '2024-03-28 10:48:00', NULL),
('xt1.5', 'Xe tải 1.5 tấn', '2024-03-11 15:12:23', 5, '2024-04-24 20:42:57', NULL),
('xt8', 'Xe tải 8 tấn', '2024-03-11 15:12:23', 5, '2024-03-28 10:48:00', NULL);

--
-- Triggers `nhomxe`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_nhomxe` AFTER DELETE ON `nhomxe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;


  SET noidung = CONCAT('Xóa nhóm xe:\n',
  
                        'Mã đơn hàng: ', OLD.id_nhomxe, '\n',
                       'Mã nhân viên sale: ', OLD.ten
                      );


INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_nhomxe` AFTER INSERT ON `nhomxe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm nhóm xe:\n',
  
                        'Mã đơn hàng: ', NEW.id_nhomxe, '\n',
                       'Mã nhân viên sale: ', NEW.ten
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_nhomxe` AFTER UPDATE ON `nhomxe` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên nhóm xe: ', OLD.ten);
    SET new_values = CONCAT('\nTên nhóm xe: ', NEW.ten);
  END IF;
  
  

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin nhóm xe:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `phanquyen`
--

CREATE TABLE `phanquyen` (
  `id_phanquyen` int(11) NOT NULL,
  `id_nguoidung` int(11) DEFAULT NULL,
  `id_chucnang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phanquyen`
--

INSERT INTO `phanquyen` (`id_phanquyen`, `id_nguoidung`, `id_chucnang`) VALUES
(22, 7, 6),
(23, 7, 8),
(24, 3, 4),
(25, 3, 5),
(26, 3, 6),
(27, 3, 8),
(28, 2, 4),
(29, 2, 5),
(30, 2, 6),
(31, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `phieudonhienlieu`
--

CREATE TABLE `phieudonhienlieu` (
  `id_pdnl` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `ngaydonhienlieu` date NOT NULL,
  `id_dvccdau` varchar(255) NOT NULL,
  `soluongnhienlieu` float NOT NULL,
  `id_nhienlieu` varchar(255) NOT NULL,
  `anh1` varchar(255) DEFAULT NULL,
  `thanhtien` float NOT NULL,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phieudonhienlieu`
--

INSERT INTO `phieudonhienlieu` (`id_pdnl`, `id_donhang`, `ngaydonhienlieu`, `id_dvccdau`, `soluongnhienlieu`, `id_nhienlieu`, `anh1`, `thanhtien`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(3, 3, '2024-04-08', 'HFC', 137.5, 'DO', 'anh_phieu_dau.jpg', 2681250, '321', '2024-04-09 22:49:01', 5, '2024-04-12 10:02:32', 3),
(7, 2, '2024-04-15', 'KVNS', 3.125, 'DO', 'anh_phieu_dau.jpg', 60938, 'ko', '2024-04-15 21:17:06', 5, NULL, NULL),
(8, 4, '2024-04-16', 'KVNS', 12.625, 'DO', '', 246188, '', '2024-04-16 20:06:41', 5, '2024-04-16 20:07:38', 3),
(9, 29, '2024-05-02', 'KVNS', 137.5, 'DO', 'phiếu đổ dầu.jpg', 2681250, 'ko', '2024-05-02 15:48:14', 5, '2024-05-02 16:43:18', 3),
(10, 30, '2024-05-08', 'KVNS', 15, 'DO', '', 292500, '', '2024-05-08 19:19:41', 5, NULL, NULL),
(11, 33, '2024-03-14', 'HFC', 15, 'DO', NULL, 292500, NULL, '2024-03-14 23:29:58', 5, NULL, NULL),
(15, 42, '2024-05-22', 'HFC', 12.625, 'DO', 'phiếu đổ dầu.jpg', 246188, 'ko', '2024-05-22 21:02:51', 5, '2024-05-22 21:02:57', 5),
(16, 43, '2024-05-24', 'KVNS', 12.625, 'DO', '', 246188, 'ko', '2024-05-24 09:26:34', 5, NULL, NULL),
(17, 47, '2024-06-03', 'HFC', 12.625, 'DO', 'phiếu đổ dầu.jpg', 246188, '', '2024-06-03 20:30:11', 5, '2024-06-09 15:31:44', 5),
(18, 58, '2024-06-09', 'KVNS', 12.625, 'DO', '', 246188, '', '2024-06-09 15:43:24', 5, NULL, NULL),
(19, 57, '2024-06-07', 'HFC', 3.125, 'DO', '', 60938, '', '2024-06-09 15:43:42', 5, NULL, NULL),
(20, 56, '2024-06-05', 'HFC', 15, 'DO', '', 292500, '', '2024-06-09 15:43:55', 5, NULL, NULL),
(21, 55, '2024-06-03', 'HFC', 137.5, 'DO', '', 2681250, '', '2024-06-09 15:44:05', 5, NULL, NULL),
(22, 54, '2024-06-09', 'HFC', 14, 'DO', '', 273000, '', '2024-06-09 15:44:13', 5, NULL, NULL),
(23, 53, '2024-06-06', 'HFC', 6.5, 'DO', '', 126750, '', '2024-06-09 15:44:24', 5, NULL, NULL),
(24, 52, '2024-06-03', 'KVNS', 14, 'DO', '', 273000, '', '2024-06-09 15:44:33', 5, NULL, NULL),
(25, 51, '2024-06-02', 'KVNS', 3.125, 'DO', '', 60938, '', '2024-06-09 15:44:42', 5, NULL, NULL),
(26, 50, '2024-06-03', 'HFC', 12.625, 'DO', '', 246188, '', '2024-06-09 15:44:51', 5, NULL, NULL),
(27, 49, '2024-06-01', 'KVNS', 6.5, 'DO', '1233.png', 126750, '', '2024-06-09 15:45:02', 5, '2024-06-09 15:47:51', 5),
(28, 48, '2024-06-02', 'HFC', 15, 'DO', 'phiếu đổ dầu.jpg', 292500, '', '2024-06-09 15:45:32', 5, '2024-06-09 15:45:37', 5);

--
-- Triggers `phieudonhienlieu`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_phieudonhienlieu` AFTER DELETE ON `phieudonhienlieu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;


  SET noidung = CONCAT('Xóa phiếu đổ nhiên liệu:\n',
  
                        'Mã phiếu đổ nhiên liệu: ', OLD.id_pdnl, '\n',
                       'Mã đơn hàng: ', OLD.id_donhang, '\n',
                       'Ngày đổ nhiên liệu: ', OLD.ngaydonhienlieu, '\n',
                       'Mã đơn vị cung cấp dầu: ', OLD.id_dvccdau,'\n',
                       'Số lượng nhiên liệu: ', OLD.soluongnhienlieu,'\n',
                       'Mã nhiên liệu: ', OLD.id_nhienlieu,'\n',
                       'Ảnh 1: ', OLD.anh1,'\n',
                       'Thành tiền: ', OLD.thanhtien,'\n',
                       'Ghi chú: ', OLD.ghichu
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_phieudonhienlieu` AFTER INSERT ON `phieudonhienlieu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm phiếu đổ nhiên liệu:\n',
  
                        'Mã phiếu đổ nhiên liệu: ', NEW.id_pdnl, '\n',
                       'Mã đơn hàng: ', NEW.id_donhang, '\n',
                       'Ngày đổ nhiên liệu: ', NEW.ngaydonhienlieu, '\n',
                       'Mã đơn vị cung cấp dầu: ', NEW.id_dvccdau,'\n',
                       'Số lượng nhiên liệu: ', NEW.soluongnhienlieu,'\n',
                       'Mã nhiên liệu: ', NEW.id_nhienlieu,'\n',
                       'Ảnh 1: ', NEW.anh1,'\n',
                       'Thành tiền: ', NEW.thanhtien,'\n',
                       'Ghi chú: ', NEW.ghichu
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_phieudonhienlieu` AFTER UPDATE ON `phieudonhienlieu` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.id_donhang != NEW.id_donhang THEN
    SET old_values = CONCAT('\nMã đơn hàng: ', OLD.id_donhang);
    SET new_values = CONCAT('\nMã đơn hàng: ', NEW.id_donhang);
  END IF;
  
  IF OLD.ngaydonhienlieu != NEW.ngaydonhienlieu THEN
    SET old_values = CONCAT(old_values, '\nNgày đổ nhiên liệu: ', OLD.ngaydonhienlieu);
    SET new_values = CONCAT(new_values, '\nNgày đổ nhiên liệu: ', NEW.ngaydonhienlieu);
  END IF;
  
  IF OLD.id_dvccdau != NEW.id_dvccdau THEN
    SET old_values = CONCAT(old_values, '\nMã đơn vị cung cấp dầu: ', OLD.id_dvccdau);
    SET new_values = CONCAT(new_values, '\nMã đơn vị cung cấp dầu: ', NEW.id_dvccdau);
  END IF;
  

  IF OLD.soluongnhienlieu != NEW.soluongnhienlieu THEN
    SET old_values = CONCAT(old_values, '\nSố lượng nhiên liệu: ', OLD.soluongnhienlieu);
    SET new_values = CONCAT(new_values, '\nSố lượng nhiên liệu: ', NEW.soluongnhienlieu);
  END IF;
  
  IF OLD.id_nhienlieu != NEW.id_nhienlieu THEN
    SET old_values = CONCAT(old_values, '\nMã nhiên liệu: ', OLD.id_nhienlieu);
    SET new_values = CONCAT(new_values, '\nMã nhiên liệu: ', NEW.id_nhienlieu);
  END IF;
  
  IF OLD.anh1 != NEW.anh1 THEN
    SET old_values = CONCAT(old_values, '\nẢnh 1: ', OLD.anh1);
    SET new_values = CONCAT(new_values, '\nẢnh 1: ', NEW.anh1);
  END IF;
  
  IF OLD.thanhtien != NEW.thanhtien THEN
    SET old_values = CONCAT(old_values, '\nThành tiền: ', OLD.thanhtien);
    SET new_values = CONCAT(new_values, '\nThành tiền: ', NEW.thanhtien);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;
  
  

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin phiếu đổ nhiên liệu:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suachua`
--

CREATE TABLE `suachua` (
  `id_suachua` int(11) NOT NULL,
  `id_xe` int(11) NOT NULL,
  `ngaysuachua` datetime NOT NULL,
  `sokmdongho` varchar(255) DEFAULT NULL,
  `noidungsuachua` text NOT NULL,
  `dongiavattu` decimal(10,0) NOT NULL DEFAULT 0,
  `tiennhancong` decimal(10,0) DEFAULT 0,
  `soluong` int(11) NOT NULL,
  `nguoisuachua` varchar(255) DEFAULT NULL,
  `thoigianbaohanh` date DEFAULT NULL,
  `tongtien` decimal(10,0) NOT NULL DEFAULT 0,
  `anh1` varchar(255) DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suachua`
--

INSERT INTO `suachua` (`id_suachua`, `id_xe`, `ngaysuachua`, `sokmdongho`, `noidungsuachua`, `dongiavattu`, `tiennhancong`, `soluong`, `nguoisuachua`, `thoigianbaohanh`, `tongtien`, `anh1`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(1, 2, '2024-03-13 00:00:00', '7000', 'thay  2 bánh sau', 300000, 30000, 2, 'Long', '2024-04-24', 630000, '', 'ko', '2024-04-13 16:31:01', 3, '2024-05-07 20:12:09', NULL),
(2, 6, '2024-03-13 00:00:00', '15000', 'thay Dầu nhớt Dành động cơ xe bán tải AP X-SUPER LUBE', 550000, 30000, 1, 'Long', '0000-00-00', 580000, 'Screenshot 2024-02-27 115344.png', '', '2024-05-13 16:31:01', 3, '2024-05-07 10:43:28', 3),
(4, 3, '2024-05-07 00:00:00', '6500', 'Thông hàn két nước, két gió', 1200000, 0, 1, 'long', '0000-00-00', 1200000, '', '', '2024-05-07 10:29:27', 5, NULL, NULL),
(5, 4, '2024-05-05 00:00:00', '9998', 'Roong bơm hơi', 100000, 0, 1, 'thiên', '0000-00-00', 100000, '', '', '2024-05-07 10:42:08', 5, '2024-05-22 21:38:52', 5),
(6, 6, '2024-03-31 00:00:00', '15550', 'Roong bơm hơi', 100000, 50000, 1, 'thiên', '0000-00-00', 150000, '', '', '2024-05-07 10:57:31', 5, '2024-05-07 19:46:19', NULL),
(7, 3, '2024-05-07 00:00:00', '6555', 'Roong bơm hơi', 100000, 50000, 1, 'long', '0000-00-00', 150000, '', '', '2024-05-07 10:29:27', 5, '2024-05-07 16:04:00', NULL),
(13, 3, '2024-05-22 00:00:00', '9998', 'Lắp 1 bộ súng hơi + rắc co', 245000, 59000, 1, 'thiên', '0000-00-00', 304000, '', '', '2024-05-22 22:36:13', 5, '2024-05-22 22:36:45', 5),
(14, 3, '2024-06-01 00:00:00', '1222', 'thay Còi điện', 250000, 0, 1, 'Ngọc Tuân', '0000-00-00', 250000, '', '', '2024-06-09 15:49:53', 5, '2024-06-09 15:52:28', 5),
(15, 4, '2024-06-09 00:00:00', '7775', 'thay 1 bát phanh đạp', 100000, 23000, 1, 'long', '0000-00-00', 123000, '', '', '2024-06-09 15:50:30', 5, NULL, NULL),
(16, 2, '2024-06-09 00:00:00', '7775', 'Bút xông còi hơi', 355000, 20000, 1, 'thiên', '0000-00-00', 375000, '', '', '2024-06-09 15:51:04', 5, NULL, NULL),
(17, 4, '2024-06-04 00:00:00', '1200', 'Thay 2 quả lốc kê đầu kéo + mooc', 600000, 30000, 2, 'Ngọc Tuân', '2024-07-04', 1230000, '', '', '2024-06-09 15:52:21', 5, NULL, NULL),
(18, 2, '2024-06-09 00:00:00', '7775', 'Thay 1 bát phanh + nối đường hơi mooc', 250000, 30000, 1, 'Đoàn Chiến', '0000-00-00', 280000, '', '', '2024-06-09 15:53:27', 5, NULL, NULL),
(19, 3, '2024-06-09 00:00:00', '6300', 'Thay zắc co ba trục + zắc nối + van khóa chế cả bóng hơi', 355000, 20000, 1, '', '0000-00-00', 375000, '', '', '2024-06-09 15:53:56', 5, NULL, NULL);

--
-- Triggers `suachua`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_suachua` AFTER DELETE ON `suachua` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;


  SET noidung = CONCAT('Xóa sửa chữa:\n',
  
                        'Mã sửa chữa: ', OLD.id_suachua, '\n',
                       'Mã xe: ', OLD.id_xe, '\n',
                       'Ngày sửa chữa: ', OLD.ngaysuachua, '\n',
                       'Số km đồng hồ: ', OLD.sokmdongho,'\n',
                       'Nội dung sửa chữa: ', OLD.noidungsuachua,'\n',
                       'Đơn giá vật tư: ', OLD.dongiavattu,'\n',
                       'Tiền nhân công: ', OLD.tiennhancong,'\n',
                       'Số lượng: ', OLD.soluong,'\n',
                       'Người sửa chữa: ', OLD.nguoisuachua,'\n',
                       'Thời gian bảo hành: ', OLD.thoigianbaohanh,'\n',
                       'Tổng tiền: ', OLD.tongtien,'\n',
                       'Ảnh 1: ', OLD.anh1,'\n',
                       'Ghi chú: ', OLD.ghichu
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_suachua` AFTER INSERT ON `suachua` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm sửa chữa:\n',
  
                        'Mã sửa chữa: ', NEW.id_suachua, '\n',
                       'Mã xe: ', NEW.id_xe, '\n',
                       'Ngày sửa chữa: ', NEW.ngaysuachua, '\n',
                       'Số km đồng hồ: ', NEW.sokmdongho,'\n',
                       'Nội dung sửa chữa: ', NEW.noidungsuachua,'\n',
                       'Đơn giá vật tư: ', NEW.dongiavattu,'\n',
                       'Tiền nhân công: ', NEW.tiennhancong,'\n',
                       'Số lượng: ', NEW.soluong,'\n',
                       'Người sửa chữa: ', NEW.nguoisuachua,'\n',
                       'Thời gian bảo hành: ', NEW.thoigianbaohanh,'\n',
                       'Tổng tiền: ', NEW.tongtien,'\n',
                       'Ảnh 1: ', NEW.anh1,'\n',
                       'Ghi chú: ', NEW.ghichu
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_suachua` AFTER UPDATE ON `suachua` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.id_xe != NEW.id_xe THEN
    SET old_values = CONCAT('\nMã xe: ', OLD.id_xe);
    SET new_values = CONCAT('\nMã xe: ', NEW.id_xe);
  END IF;
  
  IF OLD.ngaysuachua != NEW.ngaysuachua THEN
    SET old_values = CONCAT(old_values, '\nNgày sửa chữa: ', OLD.ngaysuachua);
    SET new_values = CONCAT(new_values, '\nNgày sửa chữa: ', NEW.ngaysuachua);
  END IF;
  
  IF OLD.sokmdongho != NEW.sokmdongho THEN
    SET old_values = CONCAT(old_values, '\nSố km đồng hồ: ', OLD.sokmdongho);
    SET new_values = CONCAT(new_values, '\nSố km đồng hồ: ', NEW.sokmdongho);
  END IF;
  

  IF OLD.noidungsuachua != NEW.noidungsuachua THEN
    SET old_values = CONCAT(old_values, '\nNội dung sửa chữa: ', OLD.noidungsuachua);
    SET new_values = CONCAT(new_values, '\nNội dung sửa chữa: ', NEW.noidungsuachua);
  END IF;
  
  IF OLD.dongiavattu != NEW.dongiavattu THEN
    SET old_values = CONCAT(old_values, '\nĐơn giá vật tư: ', OLD.dongiavattu);
    SET new_values = CONCAT(new_values, '\nĐơn giá vật tư: ', NEW.dongiavattu);
  END IF;
  
  IF OLD.tiennhancong != NEW.tiennhancong THEN
    SET old_values = CONCAT(old_values, '\nTiền nhân công: ', OLD.tiennhancong);
    SET new_values = CONCAT(new_values, '\nTiền nhân công: ', NEW.tiennhancong);
  END IF;
  
  IF OLD.soluong != NEW.soluong THEN
    SET old_values = CONCAT(old_values, '\nSố lượng: ', OLD.soluong);
    SET new_values = CONCAT(new_values, '\nSố lượng: ', NEW.soluong);
  END IF;
  
  IF OLD.nguoisuachua != NEW.nguoisuachua THEN
    SET old_values = CONCAT(old_values, '\nNgười sửa chữa: ', OLD.nguoisuachua);
    SET new_values = CONCAT(new_values, '\nNgười sửa chữa: ', NEW.nguoisuachua);
  END IF;
  
  IF OLD.thoigianbaohanh != NEW.thoigianbaohanh THEN
    SET old_values = CONCAT(old_values, '\nThời gian bảo hành: ', OLD.thoigianbaohanh);
    SET new_values = CONCAT(new_values, '\nThời gian bảo hành: ', NEW.thoigianbaohanh);
  END IF;

   IF OLD.tongtien != NEW.tongtien THEN
    SET old_values = CONCAT(old_values, '\nTổng tiền: ', OLD.tongtien);
    SET new_values = CONCAT(new_values, '\nTổng tiền: ', NEW.tongtien);
  END IF;

  IF OLD.anh1 != NEW.anh1 THEN
    SET old_values = CONCAT(old_values, '\nẢnh 1: ', OLD.anh1);
    SET new_values = CONCAT(new_values, '\nẢnh 1: ', NEW.anh1);
  END IF;

  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;

 

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin sửa chữa:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `taixe`
--

CREATE TABLE `taixe` (
  `id_taixe` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `sodienthoai` varchar(255) NOT NULL,
  `diachi` varchar(255) DEFAULT NULL,
  `cmnd` varchar(255) DEFAULT NULL,
  `sobanglai` varchar(255) DEFAULT NULL,
  `id_thauphu` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taixe`
--

INSERT INTO `taixe` (`id_taixe`, `ten`, `sodienthoai`, `diachi`, `cmnd`, `sobanglai`, `id_thauphu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('AnhSon', 'Anh Sơn', '0334561457', 'Tiên lãng - Vĩnh Bảo', '', '', 'PLJ-L', '2024-03-11 15:55:32', 3, '2024-06-09 15:34:20', 5),
('BuiChien', 'Bùi Chiến', '0331247891', 'Yên Lai - Hưng Yên', '', '', 'PLJ-F', '2024-03-11 15:55:32', 5, '2024-06-09 15:33:59', 5),
('DoVuong', 'Đỗ Vương', '0339527143', 'Tiên lãng - Vĩnh Bảo', '', '', 'PLJ-L', '2024-03-11 15:55:32', 3, '2024-06-09 15:33:49', 5),
('HoangBao', 'Hoàng Bảo', '0335124471', 'Yên Lai - Hưng Yên', '', '', 'PLJ-F', '2024-03-11 15:55:32', 5, '2024-06-09 15:33:44', 5),
('NgocDoan', 'Ngọc Đoàn', '0339527171', 'Đông Lãm - Hải Phòng', '', '', 'GPT-F', '2024-03-11 15:55:32', 3, '2024-06-09 15:33:46', 5),
('NhatBao', 'Nhật Bảo', '0123456779', 'Tiên lãng - Vĩnh Bảo', '', '', 'CTY-L', '2024-03-11 15:55:32', 3, '2024-06-09 15:34:09', 5),
('QuocDanh', 'Quốc Danh', '0339452748', 'Đông Lãm - Hải Phòng', '', '', 'GPT-F', '2024-03-11 15:55:32', 3, '2024-06-09 15:34:31', 5);

--
-- Triggers `taixe`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_taixe` AFTER DELETE ON `taixe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;


  SET noidung = CONCAT('Xóa tài xế:\n',
  
                        'Mã tài xế: ', OLD.id_taixe, '\n',
                       'Tên tài xế: ', OLD.ten, '\n',
                       'Sđt: ', OLD.sodienthoai, '\n',
                       'Địa chỉ: ', OLD.diachi,'\n',
                       'CMND: ', OLD.cmnd,'\n',
                       'Số bằng lái: ', OLD.sobanglai,'\n',
                       'Mã thầu phụ: ', OLD.id_thauphu
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_taixe` AFTER INSERT ON `taixe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  
  SET noidung = CONCAT('Thêm tài xế:\n',
  
                        'Mã tài xế: ', NEW.id_taixe, '\n',
                       'Tên tài xế: ', NEW.ten, '\n',
                       'Sđt: ', NEW.sodienthoai, '\n',
                       'Địa chỉ: ', NEW.diachi,'\n',
                       'CMND: ', NEW.cmnd,'\n',
                       'Số bằng lái: ', NEW.sobanglai,'\n',
                       'Mã thầu phụ: ', NEW.id_thauphu
                      );
  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_taixe` AFTER UPDATE ON `taixe` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên tài xế: ', OLD.ten);
    SET new_values = CONCAT('\nTên tài xế: ', NEW.ten);
  END IF;
  
  IF OLD.sodienthoai != NEW.sodienthoai THEN
    SET old_values = CONCAT(old_values, '\nSố đt: ', OLD.sodienthoai);
    SET new_values = CONCAT(new_values, '\nSố đt: ', NEW.sodienthoai);
  END IF;
  
  IF OLD.diachi != NEW.diachi THEN
    SET old_values = CONCAT(old_values, '\nĐịa chỉ: ', OLD.diachi);
    SET new_values = CONCAT(new_values, '\nĐịa chỉ: ', NEW.diachi);
  END IF;
  

  IF OLD.cmnd != NEW.cmnd THEN
    SET old_values = CONCAT(old_values, '\nCMND: ', OLD.cmnd);
    SET new_values = CONCAT(new_values, '\nCMND: ', NEW.cmnd);
  END IF;
  
  IF OLD.sobanglai != NEW.sobanglai THEN
    SET old_values = CONCAT(old_values, '\nSố bằng lái: ', OLD.sobanglai);
    SET new_values = CONCAT(new_values, '\nSố bằng lái: ', NEW.sobanglai);
  END IF;
  
  IF OLD.id_thauphu != NEW.id_thauphu THEN
    SET old_values = CONCAT(old_values, '\nMã thầu phụ: ', OLD.id_thauphu);
    SET new_values = CONCAT(new_values, '\nMã thầu phụ: ', NEW.id_thauphu);
  END IF;
  
 

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin tài xế:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `thauphu`
--

CREATE TABLE `thauphu` (
  `id_thauphu` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `sodienthoai` varchar(255) DEFAULT NULL,
  `masothue` varchar(255) NOT NULL,
  `id_nhomhanghoa` varchar(255) DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thauphu`
--

INSERT INTO `thauphu` (`id_thauphu`, `ten`, `diachi`, `sodienthoai`, `masothue`, `id_nhomhanghoa`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('CTY-L', 'Công ty CP City Delivery ', 'Số 31 Cầu Đất, Phường Cầu Đất, Quận Ngô Quyền, Hải Phòng', NULL, '0201734748', 'LCL', '2024-03-21 15:29:57', 3, NULL, NULL),
('GPT-F', 'Công ty CP Vận tải Đối tác Toàn Cầu', 'Tầng 8, toà nhà DK, số 2, lô 22A Lê Hồng Phong, Phường Đông Khê, Quận Ngô Quyền, Hải Phòng', NULL, '0201255664', 'FCL', '2024-03-11 15:29:57', 3, '2024-04-25 21:45:59', NULL),
('PLJ-F', 'Công ty CP Tiếp vận Thái Bình Dương', 'KCN Đình Vũ, Đông Hải 2, Hải An, Hải Phòng', NULL, '0201249276', 'FCL', '2024-03-11 15:29:57', 3, '2024-04-25 21:46:08', NULL),
('PLJ-L', 'Công ty CP Tiếp vận Thái Bình Dương', 'KCN Đình Vũ, Đông Hải 2, Hải An, Hải Phòng', NULL, '0201249276', 'LCL', '2024-03-11 15:29:57', 3, '2024-04-26 20:55:40', NULL);

--
-- Triggers `thauphu`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_thauphu` AFTER DELETE ON `thauphu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa thầu phụ:\n',
  
                        'Mã thầu phụ: ', OLD.id_thauphu, '\n',
                       'Tên: ', OLD.ten, '\n',
                       'Địa chỉ: ', OLD.diachi, '\n',
                       'Số điện thoại: ', OLD.sodienthoai,'\n',
                       'Mã số thuế: ', OLD.masothue,'\n',
                       'Nhóm hàng vận chuyển: ', OLD.id_nhomhanghoa
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_thauphu` AFTER INSERT ON `thauphu` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm thầu phụ:\n',
  
                        'Mã thầu phụ: ', NEW.id_thauphu, '\n',
                       'Tên: ', NEW.ten, '\n',
                       'Địa chỉ: ', NEW.diachi, '\n',
                       'Số điện thoại: ', NEW.sodienthoai,'\n',
                       'Mã số thuế: ', NEW.masothue,'\n',
                       'Nhóm hàng vận chuyển: ', NEW.id_nhomhanghoa
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_thauphu` AFTER UPDATE ON `thauphu` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên thầu phụ: ', OLD.ten);
    SET new_values = CONCAT('\nTên thầu phụ: ', NEW.ten);
  END IF;
  
  IF OLD.diachi != NEW.diachi THEN
    SET old_values = CONCAT(old_values, '\nĐịa chỉ: ', OLD.diachi);
    SET new_values = CONCAT(new_values, '\nĐịa chỉ: ', NEW.diachi);
  END IF;
  
  IF OLD.sodienthoai != NEW.sodienthoai THEN
    SET old_values = CONCAT(old_values, '\nSđt: ', OLD.sodienthoai);
    SET new_values = CONCAT(new_values, '\nSđt: ', NEW.sodienthoai);
  END IF;
  

  IF OLD.masothue != NEW.masothue THEN
    SET old_values = CONCAT(old_values, '\nMã số thuế: ', OLD.masothue);
    SET new_values = CONCAT(new_values, '\nMã số thuế: ', NEW.masothue);
  END IF;
  
  IF OLD.id_nhomhanghoa != NEW.id_nhomhanghoa THEN
    SET old_values = CONCAT(old_values, '\nMã nhóm hàng vận chuyển: ', OLD.id_nhomhanghoa);
    SET new_values = CONCAT(new_values, '\nMã nhóm hàng vận chuyển: ', NEW.id_nhomhanghoa);
  END IF;
  
 
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin thầu phụ:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tinhthanh`
--

CREATE TABLE `tinhthanh` (
  `id_tinhthanh` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tinhthanh`
--

INSERT INTO `tinhthanh` (`id_tinhthanh`, `ten`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('AGG', 'An Giang', '2024-03-22 15:01:29', 2, '2024-03-28 11:03:31', 3),
('BCN', 'Bắc Cạn', '2024-03-22 11:45:07', 2, '2024-03-22 11:45:07', NULL),
('BDG', 'Bình Dương', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('BDV', 'Bình Định', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('BGG', 'Bắc Giang', '2024-03-22 11:39:56', 2, '2024-03-22 11:40:13', 2),
('BLU', 'Bạc Liêu', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('BNH', 'Bắc Ninh', '2024-03-22 11:43:35', 2, '2024-03-22 11:45:13', NULL),
('BPC', 'Bình Phước', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('BTE', 'Bến Tre', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('BTN', 'Bình Thuận', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('CBG', 'Cao Bằng', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('CMA', 'Cà Mau', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('CTH', 'Cần Thơ', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DBN', 'Điện Biên', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DKN', 'Đắk Nông', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DLK', 'Đắk Lắk', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DNG', 'Đà Nẵng', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DNI', 'Đồng Nai', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('DTP', 'Đồng Tháp', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('GLA', 'Gia Lai', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HAG', 'Hậu Giang', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HBH', 'Hoà Bình', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HCM', 'Hồ Chí Minh', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HDG', 'Hải Dương', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HGG', 'Hà Giang', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HNA', 'Hà Nam', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HNI', 'Hà Nội', '2024-03-08 14:37:57', 3, '2024-03-11 14:14:46', NULL),
('HPG', 'Hải Phòng', '2024-04-02 15:05:24', 2, '2024-04-02 15:32:52', 3),
('HTH', 'Hà Tĩnh', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HUE', 'Huế', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('HYN', 'Hưng Yên', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('KGG', 'Kiên Giang', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('KHA', 'Khánh Hoà', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('KTM', 'Kon Tum', '2024-03-22 15:01:29', 2, '2024-04-01 16:29:02', 3),
('LAN', 'Long An', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('LCI', 'Lào Cai', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('LCU', 'Lai Châu', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('LDG', 'Lâm Đồng', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('LSN', 'Lạng Sơn', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('NAN', 'Nghệ An', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('NBH', 'Ninh Bình', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('NDN', 'Nam Định', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('NTN', 'Ninh Thuận', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('PTH', 'Phú Thọ', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('PYN', 'Phú Yên', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QBH', 'Quảng Bình', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QNG', 'Quảng Ngãi', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QNH', 'Quảng Ninh', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QNM', 'Quảng Nam', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QNN', 'Quy Nhơn', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('QTR', 'Quảng Trị', '2024-03-22 15:01:29', 2, '2024-04-02 13:47:18', 3),
('SLA', 'Sơn La', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('STG', 'Sóc Trăng', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('TBH', 'Thái Bình', '2024-03-22 15:01:29', 2, '2024-04-01 15:00:28', 3),
('TGG', 'Tiền Giang', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('THH', 'Thanh Hoá', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('TNG', 'Thái Nguyên', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('TNH', 'Tây Ninh', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('TQG', 'Tuyên Quang', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('TVH', 'Trà Vinh', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('VLG', 'Vĩnh Long', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('VPC', 'Vĩnh Phúc', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('VTU', 'Vũng Tàu', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL),
('YNB', 'Yên Bái', '2024-03-22 15:01:29', 2, '2024-03-22 15:01:29', NULL);

--
-- Triggers `tinhthanh`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_tinhthanh` AFTER DELETE ON `tinhthanh` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa tỉnh thành:\n',
  
                        'Mã tỉnh thành: ', OLD.id_tinhthanh, '\n',
                       'tên: ', OLD.ten
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_tinhthanh` AFTER INSERT ON `tinhthanh` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm tỉnh thành:\n',
  
                        'Mã tỉnh thành: ', NEW.id_tinhthanh, '\n',
                       'tên: ', NEW.ten
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_tinhthanh` AFTER UPDATE ON `tinhthanh` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên tỉnh thành: ', OLD.ten);
    SET new_values = CONCAT('\nTên tỉnh thành: ', NEW.ten);
  END IF;
 

  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin tỉnh thành:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `id_tintuc` int(11) NOT NULL,
  `tieude` varchar(255) NOT NULL,
  `noidung` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `special` varchar(32) NOT NULL,
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`id_tintuc`, `tieude`, `noidung`, `img`, `ngaytao`, `special`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(21, 'Thương mại điện tử thúc đẩy bất động sản hậu cần đô thị', '<p style=\"-webkit-text-stroke-width:0px;border-width:0px;color:rgb(0, 0, 0);font-family:Arial;font-feature-settings:inherit;font-kerning:inherit;font-optical-sizing:inherit;font-size:17px;font-stretch:inherit;font-style:normal;font-variant-alternates:inherit;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-variant-position:inherit;font-variation-settings:inherit;font-weight:400;letter-spacing:normal;line-height:1.6em;margin:0px 0px 15px;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Các chuyên gia của Cushman &amp; Wakefield chia sẻ, Bất động sản hậu cần đô thị đang nhận được rất nhiều sự quan tâm của giới truyền thông và giới đầu tư. Mặc dù khái niệm khác nhau, nhưng lĩnh vực mới này thường bị nhầm lẫn với mô hình đô thị logistics. Trong khi đô thị logistics có thể hiểu là mô hình đô thị gắn liền với việc phát triển dịch vụ logistics, lấy dịch vụ logistics làm ngành kinh tế mũi nhọn.</p><p style=\"-webkit-text-stroke-width:0px;border-width:0px;color:rgb(0, 0, 0);font-family:Arial;font-feature-settings:inherit;font-kerning:inherit;font-optical-sizing:inherit;font-size:17px;font-stretch:inherit;font-style:normal;font-variant-alternates:inherit;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-variant-position:inherit;font-variation-settings:inherit;font-weight:400;letter-spacing:normal;line-height:1.6em;margin:0px 0px 15px;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Thông thường, đô thị logistics sẽ gắn liền với một loại hình cơ sở hạ tầng quan trọng phục vụ cho dịch vụ logistics như cảng biển, sân bay quốc tế. Hậu cần đô thị lại lấy đô thị làm trung tâm, phục vụ chủ yếu cho nhu cầu tiêu dùng tại các thành phố.</p><p style=\"-webkit-text-stroke-width:0px;border-width:0px;color:rgb(0, 0, 0);font-family:Arial;font-feature-settings:inherit;font-kerning:inherit;font-optical-sizing:inherit;font-size:17px;font-stretch:inherit;font-style:normal;font-variant-alternates:inherit;font-variant-caps:normal;font-variant-east-asian:inherit;font-variant-ligatures:normal;font-variant-numeric:inherit;font-variant-position:inherit;font-variation-settings:inherit;font-weight:400;letter-spacing:normal;line-height:1.6em;margin:0px 0px 15px;orphans:2;padding:0px;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Xu hướng nhân khẩu học cho thấy sự gia tăng của đơn giao hàng chặng cuối ở khu vực đô thị. Điều này đặc biệt đúng ở Việt Nam, nơi có gần 40 triệu dân số sinh sống ở các thành phố. Tuy nhiên, chi phí giao hàng trong đô thị cũng ngày càng tăng cao, lên tới 50% hoặc hơn tổng chi phí chuỗi cung ứng. Do đó, các nhà đầu tư thương mại điện tử rất mong muốn có được bất động sản hậu cần có khả năng tiếp cận nội thành trong thời gian 30 phút lái xe. Đây cũng là mục tiêu ưu tiên hàng đầu của những nhà phát triển để gia tăng lợi thế cạnh tranh.</p>', '125528-thi-truong-bat-dong-san-tp-ho-chi-minh-va-cac-tinh-lan-can-co-su-phuc-hoi.jpg', '2024-04-07 21:14:36', 'ok', 2, '2024-06-13 09:47:50', 5),
(23, 'Pacific Agency: Đón tàu hàng rời hơn 17 vạn tấn tại cảng Dung Quất', '<p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Tháng 10/2023, Công ty Pacific Agency đã hoàn thành dự án đón tàu hàng rời hơn 17 vạn tấn tại cảng Dung Quất. Với đội ngũ nhân viên chuyên nghiệp và giàu kinh nghiệm, chúng tôi tự hào luôn đón nhận được sự tin tưởng tuyệt đối từ Quý đối tác – Quý khách hàng trong những dự án lớn. Niềm tin của Quý đối tác – Quý khách hàng chính là động lực to lớn để Pacific Agency ngày càng cải thiện và phát triển dịch vụ hơn nữa. Chúng tôi cam kết tiếp tục nỗ lực để mang đến những giải pháp logistics tối ưu, đáp ứng mọi nhu cầu của khách hàng. Hướng đến tương lai, Pacific Agency không ngừng đổi mới và nâng cao chất lượng dịch vụ nhằm duy trì vị thế hàng đầu trong ngành.</span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">&nbsp;Tàu hàng rời caprsize CAPE MARY M có tải trọng lớn lên tới hơn 17 vạn tấn, đây là một trong những tàu lớn nhất cập cảng Việt Nam. Pacific Agency đã có kinh nghiệm nhiều năm với tàu capesize, chúng tôi chắc chắn sẽ đem đến cho Quý đối tác – Quý khách hàng dịch vụ tốt nhất, ngày càng khẳng định năng lực uy tín hàng đầu trong ngành đại lý hàng hải tại Việt Nam.<o:p></o:p></span></span></p><figure class=\"image\" style=\"height:auto;\"><img class=\"aligncenter wp-image-4128\" style=\"aspect-ratio:800/1067;background-color:transparent;border-width:0px;box-sizing:border-box;clear:both;display:block;font-size:14px;margin:0px auto;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/z4835278667635_23f8ff13cdfa84c3b46cc54ae78c32ae.jpg\" alt=\"\" srcset=\"https://pacificlt.com/wp-content/uploads/2023/10/z4835278667635_23f8ff13cdfa84c3b46cc54ae78c32ae.jpg 800w, https://pacificlt.com/wp-content/uploads/2023/10/z4835278667635_23f8ff13cdfa84c3b46cc54ae78c32ae-480x640.jpg 480w\" sizes=\"(min-width: 0px) and (max-width: 480px) 480px, (min-width: 481px) 800px, 100vw\" width=\"800\" height=\"1067\" loading=\"lazy\" decoding=\"async\"></figure><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Pacific Agency – thuộc công ty Pacific Group là một trong những công ty chuyên về Dịch vụ đại lý tàu biển tại Việt Nam. Với nhiều năm kinh nghiệm &amp; đội ngũ nhân sự chuyên nghiệp, Pacific Agency đã nhận được sự tin tưởng &amp; hợp tác với nhiều đối tác và chủ tàu &amp; chủ hàng lớn trong nước &amp; quốc tế.<o:p></o:p></span></span></p><figure class=\"image\" style=\"height:auto;\"><img class=\"aligncenter wp-image-4130\" style=\"aspect-ratio:800/600;background-color:transparent;border-width:0px;box-sizing:border-box;clear:both;display:block;font-size:14px;margin:0px auto;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/z4835278633506_7f4da7607c724969c7307975857be69a.jpg\" alt=\"\" width=\"800\" height=\"600\" loading=\"lazy\" decoding=\"async\"></figure><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Chúc mừng dự án đã thành công rực rỡ!</span></span><o:p></o:p></p>', 'tt2.jpg', '2024-05-01 18:10:38', 'ok', 2, '2024-06-11 00:04:27', 5),
(27, 'Dự án nâng cấp luồng Nam Nghi Sơn triển khai đến đâu?', '<p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Tin từ Ban QLDA Hàng hải, tính đến hết ngày 6/9, gói thầu xây lắp NS-XL01 (nạo vét và vận chuyển chất nạo vét đi đổ) của dự án đầu tư xây dựng công trình cải tạo, nâng cấp luồng hàng hải vào các bến cảng khu vực Nam Nghi Sơn, (Thanh Hoá) đã thực hiện được khối lượng hơn 1,6 triệu m3, tương đương 70,5% khối lượng theo hợp đồng đã ký.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Gói thầu cũng đã hoàn thành công tác giải ngân 4 đợt cho nhà thầu với tổng giá trị giải ngân đạt 138,1 tỷ đồng, tương đương 77,4% kế hoạch giải ngân năm 2023 của gói thầu.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Theo đại diện Ban QLDA Hàng hải, đặc thù thời tiết tại Nam Nghi Sơn (Thanh Hoá) diễn biến phức tạp và khó lường, thời điểm thi công thuận lợi chỉ diễn ra từ tháng 5 đến tháng 8 hàng năm.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Để đảm bảo tiến độ của dự án hoàn thành theo đúng kế hoạch, thời kỳ cao điểm thi công, nhà thầu đã huy động đến công trường dự án tổng số 13 thiết bị thi công, bao gồm một tàu hút bụng, 4 máy đào gầu ngoạm và 8 sà lan đổ thải.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Thời điểm hiện tại, khi khối lượng thi công đã đạt và vượt tiến độ đã đề ra. Nhà thầu đang duy trì thi công trên công trường dự án với số lượng 3 máy đào gầu ngoạm và 7 sà lan đổ thải. Cơ bản đáp ứng khối lượng thi công hàng ngày và tiến độ theo giai đoạn.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Tuy nhiên, để dự phòng các tình huống trong mùa mưa bão, nhà thầu cũng được yêu cầu lên phương án, bổ sung thiết bị khi cần thiết.</span></span><o:p></o:p></p>', 'tt7.png', '2024-04-07 21:14:36', 'ok', 2, '2024-06-11 00:04:38', 5),
(30, 'Quy hoạch tỉnh Cao Bằng thời kỳ 2021-2030, tầm nhìn đến năm 2050', '<p><span style=\"color:rgb(0,0,0);font-family:Arial;font-size:17px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Theo đó, phạm vi lập quy hoạch bao gồm toàn bộ diện tích tự nhiên tỉnh Cao Bằng là 6.700,3 km2; gồm 10 đơn vị hành chính: thành phố Cao Bằng và 9 huyện (Bảo Lạc, Bảo Lâm, Hạ Lang, Hà Quảng, Hòa An, Nguyên Bình, Quảng Hòa, Thạch An, Trùng Khánh).</span></span><br><br><span style=\"color:rgb(0,0,0);font-family:Arial;font-size:17px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Mục tiêu tổng quát của Quy hoạch phấn đấu đến năm 2030, Cao Bằng trở thành tỉnh có nền kinh tế phát triển nhanh, năng động, xanh, bền vững và toàn diện, đạt trình độ phát triển thuộc nhóm trung bình của vùng Trung du và miền núi Bắc Bộ; hệ thống kết cấu hạ tầng được cải thiện, nhất là giao thông liên kết nội tỉnh và liên tỉnh; công nghiệp chế biến và khai thác khoáng sản có bước phát triển mới;</span></span><br><br><span style=\"color:rgb(0,0,0);font-family:Arial;font-size:17px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Phát triển nguồn năng lượng mới, năng lượng tái tạo; hình thành một số vùng nông nghiệp ứng dụng công nghệ cao, hữu cơ, đặc sản; kinh tế cửa khẩu, du lịch phát triển nhanh, bền vững; bảo vệ môi trường sinh thái, an ninh nguồn nước và chủ động ứng phó với thiên tai, thích ứng với biến đổi khí hậu.</span></span><br><br><span style=\"color:rgb(0,0,0);font-family:Arial;font-size:17px;\"><span style=\"-webkit-text-stroke-width:0px;display:inline !important;float:none;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:400;letter-spacing:normal;orphans:2;text-align:left;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-transform:none;white-space:normal;widows:2;word-spacing:0px;\">Từng bước hình thành trung tâm trung chuyển hàng hóa, logistics Việt Nam - Trung Quốc của vùng, trung tâm giao thương kinh tế, văn hóa, đối ngoại giữa Việt Nam với các tỉnh phía Tây, Tây Nam của Trung Quốc và các nước ASEAN.&nbsp;</span></span></p>', 'cao-bang-27042024.jpg', '2024-06-06 19:32:51', '', 5, NULL, NULL),
(31, 'Logistics cảng biển Việt Nam khởi sắc, hỗ trợ xuất khẩu', '<p>Tháng 6 sắp kết thúc với nhiều kỳ vọng tiếp tục đặt vào tăng trưởng xuất khẩu nửa đầu năm nay. Vì tính chung 5 tháng đầu năm, kim ngạch xuất khẩu cả nước tăng 16,7% nhờ hiệu quả của chính sách mở cửa nền kinh tế cũng như nỗ lực của doanh nghiệp trong bối cảnh khó khăn toàn cầu.<o:p></o:p></p><p>Trong đó, các mắt xích về hạ tầng hậu cần logistics&nbsp;từ cảng biển, trung tâm logistics… đóng vai trò quan trọng trong việc tạo thuận lợi cho xuất nhập khẩu hàng hóa.<o:p></o:p></p><p>Nhiều trang báo của Nga đăng tải thông tin Tập đoàn Vận tải lớn nhất nước Nga FESCO vừa khai trương tuyến đường biển kết nối các cảng Việt Nam, cụ thể là Hải Phòng và TP Hồ Chí Minh với Cảng biển Thương mại Vladivostok.<o:p></o:p></p><p>&nbsp;</p><p>Báo&nbsp;PortNews&nbsp;của Nga đánh giá, việc khai trương tuyến vận tải mới này sẽ góp phần nâng cao chất lượng dịch vụ, giảm thời gian giao hàng và tăng đáng kể năng lực của hành lang vận tải giữa hai nước.<o:p></o:p></p><p>“Hàng hóa của Việt Nam và Nga có tính bổ sung, bổ trợ cho nhau. So vậy tuyến đường biển thẳng từ Nga với Việt Nam và ngược lại sẽ là cơ hội thuận lợi cho việc phát triển”, ông Nguyễn Hồng Thành, Lãnh sự Kinh tế – Thương mại, Trưởng Chi nhánh Thương vụ Việt Nam tại Viễn Đông Liên bang Nga, cho hay.<o:p></o:p></p><p>Cảng quốc tế Tân cảng – Cái Mép cũng vừa lọt top 11 cảng container hiệu quả nhất thế giới, do Ngân hàng Thế giới và Hãng tin Tài chính S&amp;P Global Market Intelligence vừa công bố.<o:p></o:p></p><p>“Những năm qua, nếu không có dịch bệnh, tốc độ tăng trưởng khối lượng hàng hóa qua các cảng biển đạt hơn 20% hoặc hơn 10% mỗi năm. Điều này đang giúp Việt Nam đạt được các mục tiêu trung và dài hạn là trở thành một quốc gia giàu mạnh và phát triển toàn diện”, ông Thomas Snoeck, Tiểu ban Vận tải, Logistics, Hiệp hội Doanh nghiệp châu Âu tại Việt Nam (EuroCham), nói.<o:p></o:p></p><p>“Thúc đẩy nhanh chuyển đổi số trong hoạt động khai thác cảng biển, trong kết nối giữa các phương thức vận tải, thúc đẩy nhanh các chính sách để thúc đẩy chuỗi cung ứng, chuỗi sản xuất của Việt Nam, dần biến Việt Nam trở thành trung tâm sản xuất trung tâm trung chuyển hàng hóa quan trọng của khu vực”, ông Hoàng Hồng Giang, Phó Cục trưởng Cục Hàng hải Việt Nam, Bộ Giao thông Vận tải, nhận định.<o:p></o:p></p><p>Theo Báo cáo Chỉ số kết nối toàn cầu DHL 2021, Việt Nam được đánh giá là một trong số ít các quốc gia có kết quả ấn tượng về cải thiện kết nối toàn cầu.<o:p></o:p></p><p>Năm 2021, mặc dù chịu tác động lớn từ dịch COVID-19, nhưng khối lượng hàng hóa xuất nhập khẩu vận tải quốc tế của đội tàu biển Việt Nam đạt mức tăng trưởng hiếm có, tăng tới 54% so với năm 2020.<o:p></o:p></p>', 'logistics-phat-trien-1.jpg', '2024-06-06 19:37:35', 'ok', 5, '2024-06-13 09:47:15', 5),
(33, 'BEST tăng cường đầu tư vận tải đón mùa cao điểm', '<p style=\"background-color:#FCFAF6;line-height:21.6pt;margin-bottom:11.25pt;\"><span style=\"color:#222222;font-family:;\"><span>BEST Express nhận bàn giao lô 15 xe tải cỡ lớn ngày 11/6 tại Bắc Ninh, tăng cường đầu tư hạ tầng vận tải để nâng cao chất lượng dịch vụ vận chuyển, đón mùa cao điểm cuối năm.<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Trong bối cảnh thị trường mua sắm trực tuyến ngày càng sôi động, nhu cầu về dịch vụ giao nhận hàng ngày càng tăng đồng thời yêu cầu về chất lượng và tốc độ vận chuyển ngày càng khắt khe, BEST Express đã chú trọng gia tăng đầu tư hạ tầng vận tải và nâng cao chất lượng dịch vụ, nhằm đáp ứng kịp thời nhu cầu của khách hàng, đặc biệt là trong những tháng cao điểm cuối năm.<o:p></o:p></span></span></p><p style=\"line-height:16.8pt;margin-bottom:0in;\"><span style=\"color:#222222;font-family:;\"><span>BEST nhận bàn giao xe từ đối tác ôtô Hải Âu. Ảnh: Ôtô Hải Âu<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Lô 15 xe tải được đơn vị trang bị là xe tải thùng kín Chenglong M3 200HP, tải trọng 7.800 kg và thể tích lòng thùng lớn lên đến hơn 55,83 m3 giúp đơn vị tối đa số lượng hàng hóa có thể chuyên chở trong một chuyến. Đồng thời với hệ thống khung gầm chắc chắn và thùng kín container cỡ lớn, xe giúp đơn vị đảm bảo an toàn hàng hóa khi vận hành. Phương tiện này cũng đạt và tiêu chuẩn khí thải Euro V, thân thiện với môi trường và người sử dụng.<o:p></o:p></span></span></p><p style=\"line-height:16.8pt;margin-bottom:0in;\"><span style=\"color:#222222;font-family:;\"><span>Lô xe mới được bàn giao cho BEST Express tại Bắc Ninh. Ảnh:&nbsp;</span><i><span>Thành Trung</span></i><span><o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Tại sự kiện bàn giao xe, ông Mai Hoài Nam - Quản lý đội xe toàn quốc, BEST Việt Nam cho biết, nhằm đáp ứng đầy đủ nhu cầu giao vận ngày càng tăng của các đối tác thương mại điện tử trong ngoài nước, BEST Express hợp tác với Ôtô Hải Âu đầu tư thêm 15 đầu xe mới. \"Việc tăng cường đầu tư đội xe giúp BEST gia tăng năng lực vận tải để vận chuyển hàng hóa nhanh hơn, hiệu quả hơn, cũng là minh chứng rõ ràng cho cam kết nâng cao chất lượng dịch vụ vận chuyển của doanh nghiệp trong thời gian tới\", ông Hoài Nam nói.<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Việc gia tăng đội xe vận tải góp phần hiện thực hóa mong muốn của đơn vị thông qua việc củng cố hạ tầng vận tải sẽ mở rộng kết nối hàng hoá, gia tăng hiệu suất giao vận và mang đến nhiều tiện ích hơn nữa cho khách hàng sử dụng dịch vụ BEST Express. Đây cũng là một phần trong chuỗi các dự án nâng cao chất lượng dịch vụ chuyển phát nhanh của BEST tại Việt Nam.<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Năm 2023, BEST Việt Nam đã thực hiện gần 60.000 chuyến xe phục vụ nhu cầu giao nhận, vận chuyển hàng hóa trên toàn quốc. Dự kiến nhu cầu vận tải trong năm 2024 của đơn vị sẽ gia tăng khoảng 30% đến 40% khi các dịch vụ mới như vận chuyển xuyên biên giới BEST Cross-border, dịch vụ chuỗi cung ứng BEST Supplychain, dịch vụ vận tải BEST Cargo và dịch vụ phần mềm hỗ trợ quản lý bán hàng BEST Software đang trên đà mở rộng quy mô.<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Với việc bổ sung thêm 15 xe mới, BEST đang sở hữu hơn 500 đầu xe với nhiều thương hiệu khác nhau, phục vụ luân chuyển hàng hóa chuyển phát nhanh trên toàn quốc.<o:p></o:p></span></span></p><p style=\"line-height:16.8pt;margin-bottom:0in;\"><span style=\"color:#222222;font-family:;\"><span>Ông Mai Hoài Nam - Quản lý đội xe toàn quốc, BEST Việt Nam đang kiểm tra lô xe mới. Ảnh:&nbsp;</span><i><span>Thành Trung</span></i><span><o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Gia nhập thị trường Việt Nam từ năm 2019, BEST Express nhanh chóng tận dụng mạng lưới dịch vụ sẵn có tại thị trường nội địa, tạo bước đệm vững chắc cho sự phát triển của đơn vị tại đây.<o:p></o:p></span></span></p><p style=\"line-height:21.6pt;margin-bottom:12.0pt;\"><span style=\"font-family:;\"><span times=\"\" new=\"\">Sau gần 5 năm không ngừng xây dựng và phát triển, Best Express Việt Nam đã mở rộng mạng lưới hoạt động khắp 63 tỉnh thành toàn quốc, đạt độ phủ dịch vụ lên đến 99% với hệ thống 36 trung tâm phân loại hàng hóa tự động trải dài khắp cả nước, tổng diện tích kho bãi đang khai thác là hơn 100 ha với công suất xử lý đơn hàng lên đến hơn 2,2 triệu đơn một ngày. Hiện BEST Express là đối tác chuyển phát nhanh của các sàn thương mại điện tử và hàng chục nghìn shop online trên toàn quốc.<o:p></o:p></span></span></p><p>&nbsp;</p>', 'tải xuống.png', '2024-06-12 20:18:40', 'ok', 5, '2024-06-13 09:46:15', 5),
(35, 'Hải Phòng: Di dời cảng Hoàng Diệu hơn 100 năm tuổi để xây cầu, làm công viên', '<p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Những ngày cuối tháng 10, TP.Hải Phòng đẩy nhanh tiến độ, dự kiến khởi công cầu Nguyễn Trãi vào cuối năm 2023. Công tác giải phóng mặt bằng, đền bù tái định cư đang được gấp rút hoàn thành; việc di dời cảng Hoàng Diệu sẽ sớm được tiến hành để phục vụ dự án xây dựng cầu Nguyễn Trãi.</span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Được biết, đến thời điểm hiện tại, UBND P.Máy Tơ đã hoàn thành đo đạc, kiểm đếm đối với 20/21 tổ chức và 131/131 hộ gia đình, cá nhân; lập, công khai phương án bồi thường, hỗ trợ đối với 19/21 tổ chức, và 131/131 hộ gia đình. Đến nay, đã có 2 hộ gia đình được phê duyệt phương án bồi thường, hỗ trợ tái định cư và tiến hành bàn giao mặt bằng; 4 hộ gia đình khác cũng đồng thuận.</span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Theo UBND TP.Hải Phòng, dự án công trình cầu Nguyễn Trãi và chỉnh trang đô thị vùng phụ cận được UBND thành phố phê duyệt tại quyết định ngày 30.12.2022, tổng mức đầu tư hơn 6.300 tỉ đồng.</span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Dự án chia thành 2 dự án thành phần gồm: xây dựng công trình cầu Nguyễn Trãi có mức vốn hơn 4.416 tỉ đồng và thu hồi khoảng 52 ha đất, bồi thường, hỗ trợ giải phóng mặt bằng có mức vốn hơn 1.915 tỉ đồng.<o:p></o:p></span></span></p><figure class=\"image\" style=\"height:auto;\"><img class=\"alignnone size-full wp-image-4121 aligncenter\" style=\"aspect-ratio:640/418;background-color:transparent;border-width:0px;box-sizing:border-box;clear:both;display:block;font-size:14px;margin:0px auto;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/tru-so-ubnd-tp-16984976699991713409870.jpg\" alt=\"\" srcset=\"https://pacificlt.com/wp-content/uploads/2023/10/tru-so-ubnd-tp-16984976699991713409870.jpg 640w, https://pacificlt.com/wp-content/uploads/2023/10/tru-so-ubnd-tp-16984976699991713409870-480x314.jpg 480w\" sizes=\"(min-width: 0px) and (max-width: 480px) 480px, (min-width: 481px) 640px, 100vw\" width=\"640\" height=\"418\" decoding=\"async\"></figure><p><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;\"><span style=\"line-height:130%;\">Trao đổi với PV Báo Thanh Niên, Phó chủ tịch Thường trực UBND TP.Hải Phòng, ông Lê Anh Quân cho biết, ngoài một số công trình kiến trúc đặc biệt có giá trị lịch sử được giữ lại thì toàn bộ công trình xây dựng khác từ khu vực chân cầu Hoàng Văn Thụ về tới chân cầu Nguyễn Trãi mới sẽ được thành phố dỡ bỏ, sau đó cải tạo thành công viên.</span></span><span style=\"color:black;font-family:&quot;Arial&quot;,sans-serif;font-size:13.5pt;\"><span style=\"line-height:130%;\"><o:p></o:p></span></span><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\"><o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Bà Trần Thị Hoàng Mai, Giám đốc Sở VH-TT Hải Phòng cho biết thêm, những công trình đang được Hải Phòng xem xét giữ lại, bảo tồn gồm: các tòa nhà thuộc trụ sở UBND và HĐND thành phố hơn 100 năm tuổi; Trung tâm hội nghị thành phố và một góc bến cảng Hoàng Diệu.<o:p></o:p></span></span></p>', 'tt4.jpg', '2024-06-07 15:25:40', 'ok', 5, '2024-06-11 00:04:45', 5),
(36, 'Thị trường tàu dầu “ăn nên làm ra”, doanh nghiệp chớp thời cơ tăng đội tàu', '<p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">8 tháng đầu năm 2023, Tổng công ty CP Vận tải dầu khí (PVTrans) thông báo đạt doanh thu và lợi nhuận tăng trưởng mạnh. Tổng doanh thu của công ty trong 8 tháng đạt 5.998 tỷ đồng và lợi nhuận trước thuế hợp nhất đạt 899 tỷ đồng, tăng lần lượt 2% và 17% so với cùng kỳ năm trước. Trong năm 2023, PV Trans cho biết đã nâng tổng số lượng tàu sở hữu và khai thác tăng lên 49 chiếc với tổng trọng tải khoảng 1,3 triệu DWT, đa dạng chủng loại từ tàu chở dầu thô, tàu chở dầu/hóa chất, tàu chở LPG, tàu chở hàng rời đến tàu chứa dầu FSO.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Giá cước tàu dầu hiện vẫn neo cao mang tới nhiều cơ hội cho thị trường vận tải tàu dầu. Thông tin với Báo Giao thông, một doanh nghiệp vận tải biển cho biết mức giá cước và thuê định hạn của tàu dầu hiện nay đã giảm so với thời kỳ cao điểm, nhưng cơ bản vẫn ở mức cao so với thời điểm trước dịch Covid-19.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">“Giá thuê định hạn tàu dầu hiện khoảng 20.000 USD/ngày, tùy từng loại tàu và tùy từng hợp đồng. Nguồn thu từ tàu dầu có thể bù đắp cho tàu container đang có cước sụt giảm mạnh”, doanh nghiệp cho hay.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Dữ liệu từ công ty môi giới tàu biển Alibra Shipping Limited, giá thuê tàu dầu định hạn cho tàu loại Handy (trọng tải khoảng 10.000-30.000 tấn) trong thời hạn 1 năm khoảng 25.000 USD/ngày và 20.000 USD/ngày với hợp đồng 2 năm.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Với tàu dầu loại lớn Aframax (khoảng hơn 115.000 DWT), mức giá cước thuê định hạn trong 1 năm khoảng 36.500 USD/ngày và 35.000 USD/ngày với các hợp đồng 2 năm.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Đặc biệt, với các tàu dầu siêu lớn VLCC ( tàu chuyên chở dầu thô siêu trọng từ 150.000 đến 320.000 DWT) có giá thuê đắt đỏ nhất, khoảng 42.500 USD/ngày cho hợp đồng 1 năm và 41.500 USD/ngày cho hợp đồng 2 năm.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Đối với giá cước vận chuyển, ước tính giá giao ngay của tàu VLCC (với các tàu được trang bị máy lọc khí) khoảng 30.000 USD trên tuyến Vịnh Ba Tư – Bắc Á, giảm so với hơn 35.000 USD so với thời điểm cách đây 2 tháng.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\"><strong>Tranh thủ cơ hội tái cơ cấu đội tàu<o:p></o:p></strong></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Thị trường tàu dầu neo cao, một số doanh nghiệp vận tải biển Việt Nam đã tranh thủ tái cơ cấu, phát triển đội tàu.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Trong đó, Công ty CP Vận tải Dầu khí Thái Bình Dương (PVTrans Pacific) vừa đầu tư thêm tàu Pacific Era đóng tại Hàn Quốc. Tàu có trọng tải 50.057 DWT với chiều dài 183,09m, chiều rộng 32,20m, mớn nước 19,13m.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Pacific Era là loại tàu dầu hóa chất cỡ lớn (MR), doanh nghiệp đã quyết định khai thác tại thị trường quốc tế.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Theo đại diện PVTrans Pacific, thời gian tới, doanh nghiệp này tiếp tục đầu tư thêm nhiều tàu mới trong giai đoạn 2023-2025 tùy theo tình hình thị trường. Các tàu mới được đầu tư thuộc các dòng tàu lớn MR, Aframax, VLGC, VLCC.<o:p></o:p></span></span></p><figure class=\"image\" style=\"height:auto;\"><img class=\"size-full wp-image-4104 aligncenter\" style=\"aspect-ratio:800/541;background-color:transparent;border-width:0px;box-sizing:border-box;clear:both;display:block;font-size:14px;margin:0px auto;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/picture1-1697445826917872553241.webp\" alt=\"\" srcset=\"https://pacificlt.com/wp-content/uploads/2023/10/picture1-1697445826917872553241.webp 800w, https://pacificlt.com/wp-content/uploads/2023/10/picture1-1697445826917872553241-480x325.webp 480w\" sizes=\"(min-width: 0px) and (max-width: 480px) 480px, (min-width: 481px) 800px, 100vw\" width=\"800\" height=\"541\" decoding=\"async\"></figure><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Ngoài thị trường tàu dầu, thị trường tàu khí hóa lỏng cũng đang “được mùa” khi giá cước vận chuyển giữ ở mức cao vì căng thẳng địa chính trị. Theo Hellenics Shipping, giá LNG trung bình giao tháng 11 tới Đông Bắc Á ước tính tăng 7,4%, lên 14,5 USD/mmBtu.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Ngoài ra, giá vận chuyển LPG cũng đang đạt mức cao, đặc biệt trong bối cảnh tuyến tàu đi qua kênh đào Panama đang gặp khó khiến tuyến đường vận chuyển phải thay đổi.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Trong bối cảnh ấy, theo thông tin từ PVTrans, doanh nghiệp này đã bổ sung vào đội tàu với hai chiếc tàu chở khí hóa lỏng, gồm một tàu chở khí hóa lỏng loại VLGC Global Liberty có sức chở 84.597m3, được đóng tại Hàn Quốc, là loại tàu chở khí hóa lỏng lạnh lớn nhất thế giới.<o:p></o:p></span></span></p><p><span style=\"color:black;font-family:;\"><span style=\"line-height:130%;\">Ngoài ra, còn có một tàu chở khí hóa lỏng (LPG Coaster) đóng mới Morning Kate sức chở 5.150m3, được đóng tại Nhật Bản. Tàu được PVTrans thuê theo hình thức thuê tàu trần từ chủ tàu Nhật Bản theo hợp đồng thuê 10 năm và được bàn giao cho Công ty CP Vận tải biển Nhật Việt (NVTrans), đơn vị thành viên của PVTrans, thuê lại và trực tiếp quản lý vận hành khai thác.</span></span><o:p></o:p></p>', 'tt8.jpg', '2024-06-09 20:47:46', 'ok', 5, '2024-06-11 00:04:52', 5),
(41, 'ronaldo vô địch wolcup ', '<p>fasfasfafaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>', 'tt8.jpg', '2024-06-10 22:50:01', '', 5, NULL, NULL),
(42, 'vanh đẹp trai ', '<p>adasdadawdaw</p>', 'tt4.jpg', '2024-06-10 22:50:15', '', 5, NULL, NULL),
(43, 'ronaldo vô địch wolcup ', '<p>fafawfawfgr</p>', 'ronaldo.jpg', '2024-06-10 22:50:26', '', 5, NULL, NULL),
(44, 'ấàasf', '<p>cacscsacascascascascascsac</p>', 'tt7.png', '2024-06-10 22:50:43', '', 5, NULL, NULL),
(45, 'ronaldo vô địch wolcup ', '<p>đâsfasfasfasfas</p>', 'tt2.jpg', '2024-06-10 22:50:59', '', 5, NULL, NULL),
(46, 'ronaldo vô địch wolcup ', '<p>đasa</p>', '2.jpg', '2024-06-10 23:25:04', '', 5, NULL, NULL),
(47, 'adưadwa', '<p>ưqwewqewq</p>', '2.jpg', '2024-06-10 23:25:13', '', 5, NULL, NULL),
(48, 'ronaldo vô địch wolcup ', '<p>dădwa</p>', '2.jpg', '2024-06-10 23:25:27', '', 5, NULL, NULL),
(49, 'ădwadawd', '<p>ădawdawd</p>', '2.jpg', '2024-06-10 23:25:34', '', 5, NULL, NULL),
(50, 'đdădaw', '<p>đưaa</p>', '2.jpg', '2024-06-10 23:25:41', '', 5, NULL, NULL),
(51, 'ădawdaw', '<p>đưaăd</p>', '2.jpg', '2024-06-10 23:25:46', '', 5, NULL, NULL),
(52, 'aaaaaaaaaaaaaaabbbbb', '<p>cccccccccccc</p>', '5008efb9df96969624d2674645027a3a.jpg', '2024-06-10 23:27:08', '', 5, NULL, NULL),
(53, 'fefewfQF', '<p>DSFSFEFE</p>', '2.jpg', '2024-06-10 23:28:01', '', 5, NULL, NULL),
(54, 'ƯEQWD', '<p>DƯQDQWFQW</p>', '2.jpg', '2024-06-10 23:28:08', '', 5, NULL, NULL),
(55, 'tin tức mới nhất ', '<p>đêfefefef</p>', 'adspace.jpg', '2024-06-10 23:55:01', '', 5, NULL, NULL),
(58, 'Tàu siêu lớn cập cảng quốc tế ở Bà Rịa – Vũng Tàu', '<p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Chiều 30/10, đại diện Công ty TNHH Liên doanh dịch vụ container Quốc tế cảng Sài Gòn – SSA (SSIT) cho biết, tàu MSC ALEXANDRA của tuyến dịch vụ container trực tiếp đi Mỹ của hãng tàu MSC đã rời cảng để tiếp tục hải trình theo tuyến dịch vụ Sentosa-Shikra (Mỹ).</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Trước đó, ngày 24/10, tàu MSC ALEXANDRA đã cập cảng SSIT là cảng nước sâu tại khu vực Cái Mép – Thị Vải, tỉnh Bà Rịa – Vũng Tàu làm hàng.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Tổng sản lượng xếp dỡ của tàu MSC ALEXANDRA đạt gần 12.000 teus, đây là một trong những chuyến tàu có sản lượng cao ghé cảng SSIT làm hàng trong thời gian gần đây.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\"><img class=\"alignnone size-full wp-image-4117\" style=\"background-color:transparent;border-width:0px;box-sizing:border-box;font-size:14px;height:auto;margin:0px;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678.jpg\" alt=\"\" srcset=\"https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678.jpg 2000w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-1280x689.jpg 1280w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-980x528.jpg 980w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-480x258.jpg 480w\" sizes=\"(min-width: 0px) and (max-width: 480px) 480px, (min-width: 481px) and (max-width: 980px) 980px, (min-width: 981px) and (max-width: 1280px) 1280px, (min-width: 1281px) 2000px, 100vw\" width=\"2000\" height=\"1077\" decoding=\"async\"></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Theo đại diện Công ty Cổ phần Dịch vụ – Vận tải biển Hải Vân (Haivanship), đây là lần đầu tiên tàu container MSC ALEXANDRA đến Việt Nam và neo đậu tại cảng SSIT. Tàu được Hoa tiêu Vũng Tàu dẫn luồng và tàu kéo Sea Tiger 1 dẫn đường.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin:0px;orphans:2;outline:0px;padding:0px 0px 1em;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Khi đi đến phao số 19 (khu vực Cái Mép), đội tàu kéo của công ty Hải Vân đã hỗ trợ tàu MSC ALEXANDRA cập cảng SSIT an toàn.</p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:&quot;Open Sans&quot;, Arial, sans-serif;font-size:14px;font-style:normal;font-variant-caps:normal;font-variant-ligatures:normal;font-weight:500;letter-spacing:normal;margin-bottom:0px;margin-right:0px;margin-top:0px;orphans:2;outline:0px;padding:0px;text-align:start;text-decoration-color:initial;text-decoration-style:initial;text-decoration-thickness:initial;text-indent:0px;text-size-adjust:100%;text-transform:none;vertical-align:baseline;white-space:normal;widows:2;word-spacing:0px;\">Tàu MSC ALEXANDRA có trọng tải toàn phần là 165,908 tấn, chiều dài 365.50m.</p>', 'tt8.jpg', '2024-06-11 14:50:10', '', 5, NULL, NULL),
(59, 'ronaldo vô địch wolcup ', '<p>okeeeeeeeeee</p>', 'tt3.jpg', '2024-06-11 15:26:13', 'khong', 5, '2024-06-11 15:28:31', 5),
(61, 'Tàu siêu lớn cập cảng quốc tế ở Bà Rịa – Vũng Tàu', '<p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Chiều 30/10, đại diện Công ty TNHH Liên doanh dịch vụ container Quốc tế cảng Sài Gòn – SSA (SSIT) cho biết, tàu MSC ALEXANDRA của tuyến dịch vụ container trực tiếp đi Mỹ của hãng tàu MSC đã rời cảng để tiếp tục hải trình theo tuyến dịch vụ Sentosa-Shikra (Mỹ).</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Trước đó, ngày 24/10, tàu MSC ALEXANDRA đã cập cảng SSIT là cảng nước sâu tại khu vực Cái Mép – Thị Vải, tỉnh Bà Rịa – Vũng Tàu làm hàng.</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Tổng sản lượng xếp dỡ của tàu MSC ALEXANDRA đạt gần 12.000 teus, đây là một trong những chuyến tàu có sản lượng cao ghé cảng SSIT làm hàng trong thời gian gần đây.</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\"><img class=\"alignnone size-full wp-image-4117\" style=\"background-color:transparent;border-width:0px;box-sizing:border-box;font-size:14px;height:auto;margin:0px;max-width:100%;outline:0px;padding:0px;text-size-adjust:100%;vertical-align:baseline;\" src=\"https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678.jpg\" alt=\"\" srcset=\"https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678.jpg 2000w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-1280x689.jpg 1280w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-980x528.jpg 980w, https://pacificlt.com/wp-content/uploads/2023/10/z4831485312982b667abc8803367665f9efe61173e4d7e-16986497380131973335678-480x258.jpg 480w\" sizes=\"(min-width: 0px) and (max-width: 480px) 480px, (min-width: 481px) and (max-width: 980px) 980px, (min-width: 981px) and (max-width: 1280px) 1280px, (min-width: 1281px) 2000px, 100vw\" width=\"2000\" height=\"1077\" decoding=\"async\"></span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Theo đại diện Công ty Cổ phần Dịch vụ – Vận tải biển Hải Vân (Haivanship), đây là lần đầu tiên tàu container MSC ALEXANDRA đến Việt Nam và neo đậu tại cảng SSIT. Tàu được Hoa tiêu Vũng Tàu dẫn luồng và tàu kéo Sea Tiger 1 dẫn đường.</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Khi đi đến phao số 19 (khu vực Cái Mép), đội tàu kéo của công ty Hải Vân đã hỗ trợ tàu MSC ALEXANDRA cập cảng SSIT an toàn.</span></p><p style=\"-webkit-text-stroke-width:0px;background-color:rgb(255, 255, 255);border-width:0px;box-sizing:border-box;color:rgb(102, 102, 102);font-family:;\" open=\"\"><span style=\"color:hsl(0, 0%, 0%);\">Tàu MSC ALEXANDRA có trọng tải toàn phần là 165,908 tấn, chiều dài 365.50m.</span></p>', 'tt8.jpg', '2024-06-11 15:37:27', 'ok', 5, '2024-06-12 21:53:28', 5),
(62, 'Tàu siêu lớn cập cảng quốc tế ở Bà Rịa – Vũng Tàu aaaaaaaaaa aaaaaaaaaaaaaa â         aaaaaa', '<p><span style=\"color:hsl(0, 0%, 0%);\">adsdasd</span></p>', 'tt8.jpg', '2024-06-11 15:50:58', 'khong', 5, '2024-06-12 17:05:24', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tuyenvantai`
--

CREATE TABLE `tuyenvantai` (
  `id_tuyenvantai` varchar(255) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `diemdau` varchar(255) NOT NULL,
  `id_tinhthanhdau` varchar(255) NOT NULL,
  `diemcuoi` varchar(255) NOT NULL,
  `id_tinhthanhcuoi` varchar(255) NOT NULL,
  `culy` float NOT NULL,
  `dautieuthu` float NOT NULL,
  `ghichu` text DEFAULT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tuyenvantai`
--

INSERT INTO `tuyenvantai` (`id_tuyenvantai`, `ten`, `diemdau`, `id_tinhthanhdau`, `diemcuoi`, `id_tinhthanhcuoi`, `culy`, `dautieuthu`, `ghichu`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
('ADHP', 'CHP<->An Dương (HP)', 'Cảng Hải Phòng', 'HPG', 'An Dương (HP)', 'HPG', 25, 3.125, NULL, '2024-04-03 10:24:35', 5, '2024-04-08 13:56:00', NULL),
('ANBD', 'CHP<-> AN NHƠN, BÌNH ĐỊNH', 'Hải Phòng', 'HPG', 'Bình Định', 'BDV', 1100, 137.5, '', '2024-04-03 10:24:35', 2, '2024-05-07 09:55:47', 3),
('BDHP', 'CHP<->Ba Đình (HN)', 'CHP', 'HPG', 'Ba Đình', 'HNI', 112, 14, '', '2024-06-09 14:57:17', 5, NULL, NULL),
('CHPNS', 'CHP<->KCN Nam Sách (HD)', 'CHP', 'HPG', 'KCN Nam Sách (HD)', 'HDG', 52, 6.5, '', '2024-06-09 14:58:02', 5, NULL, NULL),
('ĐĐHN', 'CHP<->Đống Đa(HN)', 'Hải Phòng', 'HPG', 'Hà Nội', 'HNI', 120, 15, '', '2024-04-03 10:24:35', 2, '2024-05-02 16:36:00', 3),
('VPHN', 'CHP<->Vạn Phúc, Hà Đông (HN)', 'Hải Phòng', 'HPG', 'Hà Nội', 'HNI', 101, 12.625, '', '2024-04-03 10:24:35', 2, '2024-05-02 16:36:06', 3);

--
-- Triggers `tuyenvantai`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_tuyenvantai` AFTER DELETE ON `tuyenvantai` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa tuyến vận tải:\n',
  
                        'Mã tuyến vận tải: ', OLD.id_tuyenvantai, '\n',
                       'Tên tuyến vận tải: ', OLD.ten, '\n',
                       'Điểm đầu: ', OLD.diemdau, '\n',
                       'Mã tỉnh thành đầu: ', OLD.id_tinhthanhdau,'\n',
                       'Điểm cuối', OLD.diemcuoi,'\n',
                       'Mã tỉnh thành cuối: ', OLD.id_tinhthanhcuoi,'\n',
                       'Cự ly: ', OLD.culy,'\n',
                       'Dầu tiêu thụ: ', OLD.dautieuthu,'\n',
                       'Ghi chú: ', OLD.ghichu
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_tuyenvantai` AFTER INSERT ON `tuyenvantai` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm tuyến vận tải:\n',
  
                        'Mã tuyến vận tải: ', NEW.id_tuyenvantai, '\n',
                       'Tên tuyến vận tải: ', NEW.ten, '\n',
                       'Điểm đầu: ', NEW.diemdau, '\n',
                       'Mã tỉnh thành đầu: ', NEW.id_tinhthanhdau,'\n',
                       'Điểm cuối:', NEW.diemcuoi,'\n',
                       'Mã tỉnh thành cuối: ', NEW.id_tinhthanhcuoi,'\n',
                       'Cự ly: ', NEW.culy,'\n',
                       'Dầu tiêu thụ: ', NEW.dautieuthu,'\n',
                       'Ghi chú: ', NEW.ghichu
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_tuyenvantai` AFTER UPDATE ON `tuyenvantai` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.ten != NEW.ten THEN
    SET old_values = CONCAT('\nTên tuyến vận tải: ', OLD.ten);
    SET new_values = CONCAT('\nTên tuyến vận tải: ', NEW.ten);
  END IF;
  
  IF OLD.diemdau != NEW.diemdau THEN
    SET old_values = CONCAT(old_values, '\nĐiểm đầu: ', OLD.diemdau);
    SET new_values = CONCAT(new_values, '\nĐiểm đầu: ', NEW.diemdau);
  END IF;
  
  IF OLD.id_tinhthanhdau != NEW.id_tinhthanhdau THEN
    SET old_values = CONCAT(old_values, '\nMã tỉnh thành đầu: ', OLD.id_tinhthanhdau);
    SET new_values = CONCAT(new_values, '\nMã tỉnh thành đầu: ', NEW.id_tinhthanhdau);
  END IF;
  

  IF OLD.diemcuoi != NEW.diemcuoi THEN
    SET old_values = CONCAT(old_values, '\nĐiểm cuối: ', OLD.diemcuoi);
    SET new_values = CONCAT(new_values, '\nĐiểm cuối: ', NEW.diemcuoi);
  END IF;
  
  IF OLD.id_tinhthanhcuoi != NEW.id_tinhthanhcuoi THEN
    SET old_values = CONCAT(old_values, '\nMã tỉnh thành cuối: ', OLD.id_tinhthanhcuoi);
    SET new_values = CONCAT(new_values, '\nMã tỉnh thành cuối: ', NEW.id_tinhthanhcuoi);
  END IF;
  
  IF OLD.culy != NEW.culy THEN
    SET old_values = CONCAT(old_values, '\nCự ly: ', OLD.culy);
    SET new_values = CONCAT(new_values, '\nCự ly: ', NEW.culy);
  END IF;
  
  IF OLD.dautieuthu != NEW.dautieuthu THEN
    SET old_values = CONCAT(old_values, '\nDầu tiêu thụ: ', OLD.dautieuthu);
    SET new_values = CONCAT(new_values, '\nDầu tiêu thụ: ', NEW.dautieuthu);
  END IF;
  
  IF OLD.ghichu != NEW.ghichu THEN
    SET old_values = CONCAT(old_values, '\nGhi chú: ', OLD.ghichu);
    SET new_values = CONCAT(new_values, '\nGhi chú: ', NEW.ghichu);
  END IF;
  
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin tuyến vận tải:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `xe`
--

CREATE TABLE `xe` (
  `id_xe` int(11) NOT NULL,
  `bienso` varchar(255) NOT NULL,
  `trangthaixe` enum('OK','Đang sửa') NOT NULL DEFAULT 'OK',
  `id_nhomxe` varchar(255) NOT NULL,
  `tennhomxe` varchar(255) DEFAULT NULL,
  `id_nhienlieu` varchar(255) NOT NULL,
  `id_thauphu` varchar(255) NOT NULL,
  `id_nhomhang` varchar(255) NOT NULL,
  `ngaytao` datetime DEFAULT current_timestamp(),
  `id_nguoitao` int(11) DEFAULT NULL,
  `ngaysua` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `id_nguoisua` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `xe`
--

INSERT INTO `xe` (`id_xe`, `bienso`, `trangthaixe`, `id_nhomxe`, `tennhomxe`, `id_nhienlieu`, `id_thauphu`, `id_nhomhang`, `ngaytao`, `id_nguoitao`, `ngaysua`, `id_nguoisua`) VALUES
(1, '15C - 05554', 'OK', 'nhomxengoai', 'Nhóm xe ngoài', 'DO', 'GPT-F', 'FCL', '2024-03-11 15:48:59', 3, '2024-04-24 20:53:52', NULL),
(2, '15C - 15123', 'Đang sửa', 'xt1.5', 'Xe tải 1.5 tấn', 'DO', 'PLJ-F', 'FCL', '2024-03-11 15:48:59', 3, '2024-06-10 11:32:36', 5),
(3, '15H - 07460', 'OK', 'xt8', 'Xe tải 1.5 tấn', 'DO', 'PLJ-L', 'LCL', '2024-03-11 15:48:59', 5, '2024-04-26 22:08:27', NULL),
(4, '15C - 09939', 'OK', 'xt1.5', 'Xe tải 1.5 tấn', 'DO', 'PLJ-F', 'FCL', '2024-03-11 15:48:59', 3, '2024-04-26 22:08:32', NULL),
(5, '15C - 15372', 'OK', 'daukeo', 'Đầu kéo', 'DO', 'GPT-F', 'FCL', '2024-03-11 15:48:59', 3, NULL, NULL),
(6, '15H - 07131', 'OK', 'xt1.5', 'Xe tải 1.5 tấn', 'DO', 'PLJ-L', 'LCL', '2024-03-11 15:48:59', 5, '2024-05-24 09:23:38', 5),
(11, '15H - 54321', 'OK', 'xt1.5', 'Xe tải 1.5 tấn', 'DO', 'CTY-L', 'LCL', '2024-03-11 15:48:59', 5, NULL, NULL);

--
-- Triggers `xe`
--
DELIMITER $$
CREATE TRIGGER `nhatky_delete_xe` AFTER DELETE ON `xe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = OLD.id_nguoisua;

  SET noidung = CONCAT('Xóa xe:\n',
  
                        'Mã xe: ', OLD.id_xe, '\n',
                       'Biển số: ', OLD.bienso, '\n',
                       'Trạng thái xe: ', OLD.trangthaixe, '\n',
                       'Mã nhóm xe: ', OLD.id_nhomxe,'\n',
                       'Tên nhóm xe: ', OLD.tennhomxe,'\n',
                       'Mã nhiên liệu: ', OLD.id_nhienlieu,'\n',
                       'Mã thầu phụ: ', OLD.id_thauphu,'\n',
                       'Mã nhóm hàng: ', OLD.id_nhomhang
                      );

INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoisua, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_insert_xe` AFTER INSERT ON `xe` FOR EACH ROW BEGIN
  DECLARE noidung TEXT DEFAULT '';
   DECLARE nguoitao INT;
  SET nguoitao = NEW.id_nguoitao;

  SET noidung = CONCAT('Thêm xe:\n',
  
                        'Mã xe: ', NEW.id_xe, '\n',
                       'Biển số: ', NEW.bienso, '\n',
                       'Trạng thái xe: ', NEW.trangthaixe, '\n',
                       'Mã nhóm xe: ', NEW.id_nhomxe,'\n',
                       'Tên nhóm xe: ', NEW.tennhomxe,'\n',
                       'Mã nhiên liệu: ', NEW.id_nhienlieu,'\n',
                       'Mã thầu phụ: ', NEW.id_thauphu,'\n',
                       'Mã nhóm hàng: ', NEW.id_nhomhang
                      );

  INSERT INTO nhatky ( id_nguoidung, thoigian, noidung)
  VALUES (nguoitao, NOW(), noidung);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `nhatky_update_xe` AFTER UPDATE ON `xe` FOR EACH ROW BEGIN
  DECLARE old_values TEXT DEFAULT '';
  DECLARE new_values TEXT DEFAULT '';
  DECLARE nguoisua INT;
  SET nguoisua = NEW.id_nguoisua;

   IF OLD.bienso != NEW.bienso THEN
    SET old_values = CONCAT('\nBiển số: ', OLD.bienso);
    SET new_values = CONCAT('\nBiển số: ', NEW.bienso);
  END IF;
  
  IF OLD.trangthaixe != NEW.trangthaixe THEN
    SET old_values = CONCAT(old_values, '\nTrạng thái xe: ', OLD.trangthaixe);
    SET new_values = CONCAT(new_values, '\nTrạng thái xe: ', NEW.trangthaixe);
  END IF;
  
  IF OLD.id_nhomxe != NEW.id_nhomxe THEN
    SET old_values = CONCAT(old_values, '\nMã nhóm xe: ', OLD.id_nhomxe);
    SET new_values = CONCAT(new_values, '\nMã nhóm xe: ', NEW.id_nhomxe);
  END IF;
  

  IF OLD.tennhomxe != NEW.tennhomxe THEN
    SET old_values = CONCAT(old_values, '\nTên nhóm xe: ', OLD.tennhomxe);
    SET new_values = CONCAT(new_values, '\nTên nhóm xe: ', NEW.tennhomxe);
  END IF;
  
  IF OLD.id_nhienlieu != NEW.id_nhienlieu THEN
    SET old_values = CONCAT(old_values, '\nMã nhiên liệu: ', OLD.id_nhienlieu);
    SET new_values = CONCAT(new_values, '\nMã nhiên liệu: ', NEW.id_nhienlieu);
  END IF;
  
  IF OLD.id_thauphu != NEW.id_thauphu THEN
    SET old_values = CONCAT(old_values, '\nMã thầu phụ: ', OLD.id_thauphu);
    SET new_values = CONCAT(new_values, '\nMã thầu phụ: ', NEW.id_thauphu);
  END IF;
  
  IF OLD.id_nhomhang != NEW.id_nhomhang THEN
    SET old_values = CONCAT(old_values, '\nMã nhóm hàng: ', OLD.id_nhomhang);
    SET new_values = CONCAT(new_values, '\nMã nhóm hàng: ', NEW.id_nhomhang);
  END IF;
  
 
  
  -- Tiếp tục cho các trường khác

  IF old_values != '' OR new_values != '' THEN
    SET @noidung := '';

    IF old_values != '' THEN
      SET @noidung := CONCAT(@noidung, 'Sửa thông tin xe:\n\nGiá trị cũ:', old_values);
    END IF;

    IF new_values != '' THEN
      SET @noidung := CONCAT(@noidung, '\n\nGiá trị mới:', new_values);
    END IF;

    INSERT INTO nhatky (id_nguoidung, thoigian, noidung)
    VALUES (nguoisua, NOW(), @noidung);
  END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chiphivantai`
--
ALTER TABLE `chiphivantai`
  ADD PRIMARY KEY (`id_cpvt`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_donhang` (`id_donhang`);

--
-- Indexes for table `chitietdonhangtamung`
--
ALTER TABLE `chitietdonhangtamung`
  ADD PRIMARY KEY (`id_ctdhtu`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_donhang` (`id_donhang`),
  ADD KEY `id_nhansu` (`id_nhansu`);

--
-- Indexes for table `chucnang`
--
ALTER TABLE `chucnang`
  ADD PRIMARY KEY (`id_chucnang`),
  ADD UNIQUE KEY `tenchucnang` (`tenchucnang`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nguoisua` (`id_nguoisua`);

--
-- Indexes for table `dieuhanh`
--
ALTER TABLE `dieuhanh`
  ADD PRIMARY KEY (`id_dieuhanh`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_donhang` (`id_donhang`),
  ADD KEY `id_thauphu` (`id_thauphu`),
  ADD KEY `id_taixe` (`id_taixe`),
  ADD KEY `id_xe` (`id_xe`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id_donhang`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_sales` (`id_sales`),
  ADD KEY `id_khachhang` (`id_khachhang`),
  ADD KEY `id_nhomhanghoa` (`id_nhomhanghoa`),
  ADD KEY `id_hanghoa` (`id_hanghoa`),
  ADD KEY `id_tuyenvantai` (`id_tuyenvantai`);

--
-- Indexes for table `donvicungcapdau`
--
ALTER TABLE `donvicungcapdau`
  ADD PRIMARY KEY (`id_donviccdau`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`id_hanghoa`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nhomhanghoa` (`id_nhomhanghoa`);

--
-- Indexes for table `hangtau`
--
ALTER TABLE `hangtau`
  ADD PRIMARY KEY (`id_hangtau`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`id_khachhang`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_tuyenvantai` (`id_tuyenvantai`);

--
-- Indexes for table `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD PRIMARY KEY (`id_lichtrinh`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nhomhanghoa` (`id_nhomhanghoa`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id_nguoidung`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nguoisua` (`id_nguoisua`);

--
-- Indexes for table `nhansu`
--
ALTER TABLE `nhansu`
  ADD PRIMARY KEY (`id_auto_increment`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `nhatky`
--
ALTER TABLE `nhatky`
  ADD PRIMARY KEY (`id_nhatky`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `nhienlieu`
--
ALTER TABLE `nhienlieu`
  ADD PRIMARY KEY (`id_nhienlieu`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `nhomhanghoa`
--
ALTER TABLE `nhomhanghoa`
  ADD PRIMARY KEY (`id_nhomhanghoa`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `nhomxe`
--
ALTER TABLE `nhomxe`
  ADD PRIMARY KEY (`id_nhomxe`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD PRIMARY KEY (`id_phanquyen`),
  ADD KEY `id_chucnang` (`id_chucnang`),
  ADD KEY `id_nguoidung` (`id_nguoidung`);

--
-- Indexes for table `phieudonhienlieu`
--
ALTER TABLE `phieudonhienlieu`
  ADD PRIMARY KEY (`id_pdnl`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_dvccdau` (`id_dvccdau`),
  ADD KEY `id_nhienlieu` (`id_nhienlieu`),
  ADD KEY `id_donhang` (`id_donhang`);

--
-- Indexes for table `suachua`
--
ALTER TABLE `suachua`
  ADD PRIMARY KEY (`id_suachua`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_xe` (`id_xe`);

--
-- Indexes for table `taixe`
--
ALTER TABLE `taixe`
  ADD PRIMARY KEY (`id_taixe`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_thauphu` (`id_thauphu`);

--
-- Indexes for table `thauphu`
--
ALTER TABLE `thauphu`
  ADD PRIMARY KEY (`id_thauphu`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nhomhanghoa` (`id_nhomhanghoa`);

--
-- Indexes for table `tinhthanh`
--
ALTER TABLE `tinhthanh`
  ADD PRIMARY KEY (`id_tinhthanh`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nguoisua` (`id_nguoisua`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id_tintuc`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`);

--
-- Indexes for table `tuyenvantai`
--
ALTER TABLE `tuyenvantai`
  ADD PRIMARY KEY (`id_tuyenvantai`),
  ADD KEY `id_tinhthanhdau` (`id_tinhthanhdau`),
  ADD KEY `id_tinhthanhcuoi` (`id_tinhthanhcuoi`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nguoisua` (`id_nguoisua`);

--
-- Indexes for table `xe`
--
ALTER TABLE `xe`
  ADD PRIMARY KEY (`id_xe`),
  ADD KEY `id_nguoisua` (`id_nguoisua`),
  ADD KEY `id_nguoitao` (`id_nguoitao`),
  ADD KEY `id_nhienlieu` (`id_nhienlieu`),
  ADD KEY `id_nhomhang` (`id_nhomhang`),
  ADD KEY `id_thauphu` (`id_thauphu`),
  ADD KEY `id_nhomxe` (`id_nhomxe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chiphivantai`
--
ALTER TABLE `chiphivantai`
  MODIFY `id_cpvt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `chitietdonhangtamung`
--
ALTER TABLE `chitietdonhangtamung`
  MODIFY `id_ctdhtu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chucnang`
--
ALTER TABLE `chucnang`
  MODIFY `id_chucnang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dieuhanh`
--
ALTER TABLE `dieuhanh`
  MODIFY `id_dieuhanh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id_donhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id_nguoidung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nhansu`
--
ALTER TABLE `nhansu`
  MODIFY `id_auto_increment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `nhatky`
--
ALTER TABLE `nhatky`
  MODIFY `id_nhatky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT for table `phanquyen`
--
ALTER TABLE `phanquyen`
  MODIFY `id_phanquyen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `phieudonhienlieu`
--
ALTER TABLE `phieudonhienlieu`
  MODIFY `id_pdnl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `suachua`
--
ALTER TABLE `suachua`
  MODIFY `id_suachua` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id_tintuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `xe`
--
ALTER TABLE `xe`
  MODIFY `id_xe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chiphivantai`
--
ALTER TABLE `chiphivantai`
  ADD CONSTRAINT `chiphivantai_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chiphivantai_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chiphivantai_ibfk_4` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id_donhang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chitietdonhangtamung`
--
ALTER TABLE `chitietdonhangtamung`
  ADD CONSTRAINT `chitietdonhangtamung_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhangtamung_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhangtamung_ibfk_3` FOREIGN KEY (`id_nhansu`) REFERENCES `nhansu` (`id_auto_increment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chitietdonhangtamung_ibfk_4` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id_donhang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chucnang`
--
ALTER TABLE `chucnang`
  ADD CONSTRAINT `chucnang_ibfk_1` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `chucnang_ibfk_2` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dieuhanh`
--
ALTER TABLE `dieuhanh`
  ADD CONSTRAINT `dieuhanh_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieuhanh_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieuhanh_ibfk_4` FOREIGN KEY (`id_thauphu`) REFERENCES `thauphu` (`id_thauphu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieuhanh_ibfk_5` FOREIGN KEY (`id_taixe`) REFERENCES `taixe` (`id_taixe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieuhanh_ibfk_6` FOREIGN KEY (`id_xe`) REFERENCES `xe` (`id_xe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dieuhanh_ibfk_7` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id_donhang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_4` FOREIGN KEY (`id_khachhang`) REFERENCES `khachhang` (`id_khachhang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_5` FOREIGN KEY (`id_nhomhanghoa`) REFERENCES `nhomhanghoa` (`id_nhomhanghoa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_6` FOREIGN KEY (`id_hanghoa`) REFERENCES `hanghoa` (`id_hanghoa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_7` FOREIGN KEY (`id_tuyenvantai`) REFERENCES `tuyenvantai` (`id_tuyenvantai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donhang_ibfk_9` FOREIGN KEY (`id_sales`) REFERENCES `nhansu` (`id_auto_increment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `donvicungcapdau`
--
ALTER TABLE `donvicungcapdau`
  ADD CONSTRAINT `donvicungcapdau_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `donvicungcapdau_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `hanghoa_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hanghoa_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hanghoa_ibfk_3` FOREIGN KEY (`id_nhomhanghoa`) REFERENCES `nhomhanghoa` (`id_nhomhanghoa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hangtau`
--
ALTER TABLE `hangtau`
  ADD CONSTRAINT `hangtau_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hangtau_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD CONSTRAINT `khachhang_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `khachhang_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `khachhang_ibfk_3` FOREIGN KEY (`id_tuyenvantai`) REFERENCES `tuyenvantai` (`id_tuyenvantai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lichtrinh`
--
ALTER TABLE `lichtrinh`
  ADD CONSTRAINT `lichtrinh_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lichtrinh_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lichtrinh_ibfk_3` FOREIGN KEY (`id_nhomhanghoa`) REFERENCES `nhomhanghoa` (`id_nhomhanghoa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `nguoidung_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nguoidung_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhansu`
--
ALTER TABLE `nhansu`
  ADD CONSTRAINT `nhansu_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhansu_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhatky`
--
ALTER TABLE `nhatky`
  ADD CONSTRAINT `nhatky_ibfk_1` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id_nguoidung`);

--
-- Constraints for table `nhienlieu`
--
ALTER TABLE `nhienlieu`
  ADD CONSTRAINT `nhienlieu_ibfk_1` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhienlieu_ibfk_2` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhomhanghoa`
--
ALTER TABLE `nhomhanghoa`
  ADD CONSTRAINT `nhomhanghoa_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhomhanghoa_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nhomxe`
--
ALTER TABLE `nhomxe`
  ADD CONSTRAINT `nhomxe_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nhomxe_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phanquyen`
--
ALTER TABLE `phanquyen`
  ADD CONSTRAINT `phanquyen_ibfk_1` FOREIGN KEY (`id_chucnang`) REFERENCES `chucnang` (`id_chucnang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phanquyen_ibfk_2` FOREIGN KEY (`id_nguoidung`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phieudonhienlieu`
--
ALTER TABLE `phieudonhienlieu`
  ADD CONSTRAINT `phieudonhienlieu_ibfk_1` FOREIGN KEY (`id_dvccdau`) REFERENCES `donvicungcapdau` (`id_donviccdau`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phieudonhienlieu_ibfk_4` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phieudonhienlieu_ibfk_5` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phieudonhienlieu_ibfk_6` FOREIGN KEY (`id_nhienlieu`) REFERENCES `nhienlieu` (`id_nhienlieu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phieudonhienlieu_ibfk_8` FOREIGN KEY (`id_donhang`) REFERENCES `donhang` (`id_donhang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suachua`
--
ALTER TABLE `suachua`
  ADD CONSTRAINT `suachua_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suachua_ibfk_2` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suachua_ibfk_3` FOREIGN KEY (`id_xe`) REFERENCES `xe` (`id_xe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taixe`
--
ALTER TABLE `taixe`
  ADD CONSTRAINT `taixe_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taixe_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taixe_ibfk_3` FOREIGN KEY (`id_thauphu`) REFERENCES `thauphu` (`id_thauphu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `thauphu`
--
ALTER TABLE `thauphu`
  ADD CONSTRAINT `thauphu_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thauphu_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thauphu_ibfk_3` FOREIGN KEY (`id_nhomhanghoa`) REFERENCES `nhomhanghoa` (`id_nhomhanghoa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tinhthanh`
--
ALTER TABLE `tinhthanh`
  ADD CONSTRAINT `tinhthanh_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tinhthanh_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `tintuc_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tintuc_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tuyenvantai`
--
ALTER TABLE `tuyenvantai`
  ADD CONSTRAINT `tuyenvantai_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tuyenvantai_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tuyenvantai_ibfk_3` FOREIGN KEY (`id_tinhthanhcuoi`) REFERENCES `tinhthanh` (`id_tinhthanh`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tuyenvantai_ibfk_4` FOREIGN KEY (`id_tinhthanhdau`) REFERENCES `tinhthanh` (`id_tinhthanh`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `xe`
--
ALTER TABLE `xe`
  ADD CONSTRAINT `xe_ibfk_1` FOREIGN KEY (`id_nguoisua`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xe_ibfk_2` FOREIGN KEY (`id_nguoitao`) REFERENCES `nguoidung` (`id_nguoidung`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xe_ibfk_3` FOREIGN KEY (`id_nhienlieu`) REFERENCES `nhienlieu` (`id_nhienlieu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xe_ibfk_4` FOREIGN KEY (`id_nhomxe`) REFERENCES `nhomxe` (`id_nhomxe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xe_ibfk_5` FOREIGN KEY (`id_thauphu`) REFERENCES `thauphu` (`id_thauphu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xe_ibfk_6` FOREIGN KEY (`id_nhomhang`) REFERENCES `nhomhanghoa` (`id_nhomhanghoa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
