-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2021 at 05:10 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlnhanvien`
--

-- --------------------------------------------------------

--
-- Table structure for table `loainv`
--

CREATE TABLE `loainv` (
  `MALOAINV` varchar(20) NOT NULL,
  `TENLOAINV` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `loainv`
--

INSERT INTO `loainv` (`MALOAINV`, `TENLOAINV`) VALUES
('LETAN', 'Lễ tân'),
('QUANLY', 'Quản lý');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MANV` varchar(10) NOT NULL,
  `HO` varchar(50) NOT NULL,
  `TEN` varchar(30) NOT NULL,
  `NGAYSINH` date NOT NULL,
  `GIOITINH` tinyint(4) NOT NULL,
  `DIACHI` varchar(50) NOT NULL,
  `ANH` varchar(250) NOT NULL,
  `MALOAINV` varchar(20) NOT NULL,
  `MAPHONG` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`MANV`, `HO`, `TEN`, `NGAYSINH`, `GIOITINH`, `DIACHI`, `ANH`, `MALOAINV`, `MAPHONG`) VALUES
('NV0001', 'Phan', 'Thanh Hà', '2000-03-08', 1, 'Ninh Hòa', 'avatar2.jpg', 'QUANLY', 'PB001'),
('NV0002', 'Nguyễn', 'Văn Trí', '2000-10-17', 1, 'Cam Ranh', 'tri_avatar.jpg', 'LETAN', 'PB002'),
('NV0003', 'Lê', 'Minh Long', '2000-06-01', 1, 'Cam Lâm', 'avatar.jpg', 'LETAN', 'PB001'),
('NV0004', 'Mang', 'Bảo', '2000-01-13', 1, 'Cam Ranh', 'avatar.jpg', 'QUANLY', 'PB002'),
('NV0005', 'Nguyễn', 'Đức Lộc', '2000-02-19', 1, 'Cam Ranh', 'avatar.jpg', 'LETAN', 'PB002'),
('NV0006', 'Ngô', 'Hữu Bằng', '2000-11-25', 1, 'Nha Trang', 'avatar.jpg', 'LETAN', 'PB001');

-- --------------------------------------------------------

--
-- Table structure for table `phongban`
--

CREATE TABLE `phongban` (
  `MAPHONG` varchar(20) NOT NULL,
  `TENPHONG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `phongban`
--

INSERT INTO `phongban` (`MAPHONG`, `TENPHONG`) VALUES
('PB001', 'Phòng ban 1'),
('PB002', 'Phòng ban 2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`) VALUES
('admin@gmail.com', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loainv`
--
ALTER TABLE `loainv`
  ADD PRIMARY KEY (`MALOAINV`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MANV`),
  ADD KEY `nv_lnv_fk` (`MALOAINV`),
  ADD KEY `nv_pb_fk` (`MAPHONG`);

--
-- Indexes for table `phongban`
--
ALTER TABLE `phongban`
  ADD PRIMARY KEY (`MAPHONG`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nv_lnv_fk` FOREIGN KEY (`MALOAINV`) REFERENCES `loainv` (`MALOAINV`),
  ADD CONSTRAINT `nv_pb_fk` FOREIGN KEY (`MAPHONG`) REFERENCES `phongban` (`MAPHONG`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
