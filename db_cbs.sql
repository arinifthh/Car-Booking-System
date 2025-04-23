-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2024 at 08:37 AM
-- Server version: 10.5.20-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id21411997_db_cbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `password_reset_id` int(11) NOT NULL,
  `password_reset_user_id` varchar(15) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `password_reset_status` int(11) NOT NULL DEFAULT 1,
  `password_reset_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`password_reset_id`, `password_reset_user_id`, `password_reset_token`, `password_reset_status`, `password_reset_created_at`) VALUES
(24, '031002030560', '1c36b6f5fdbfce8210bf3814a5a5f921', 1, '2024-01-26 15:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_booking`
--

CREATE TABLE `tb_booking` (
  `b_id` int(10) NOT NULL,
  `b_ic` varchar(15) NOT NULL,
  `b_req` varchar(10) NOT NULL,
  `b_pdate` date NOT NULL,
  `b_rdate` date NOT NULL,
  `b_total` float NOT NULL,
  `b_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_booking`
--

INSERT INTO `tb_booking` (`b_id`, `b_ic`, `b_req`, `b_pdate`, `b_rdate`, `b_total`, `b_status`) VALUES
(54, '970202034567', 'WVU 4756', '2024-01-26', '2024-01-27', 350, 2),
(57, '031002030560', 'WVU 4756', '2024-02-02', '2024-02-03', 350, 4),
(58, '031002030560', 'WYA 8990', '2024-01-27', '2024-01-28', 2500, 3),
(59, '031002030560', 'WYY 1110', '2024-01-26', '2024-01-27', 550, 2),
(60, '031002030560', 'WVU 4756', '2024-02-09', '2024-02-10', 350, 2),
(61, '031002030560', 'WVU 4756', '2024-01-28', '2024-01-29', 350, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `s_id` int(2) NOT NULL,
  `s_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`s_id`, `s_desc`) VALUES
(1, 'Received'),
(2, 'Approved'),
(3, 'Rejected'),
(4, 'Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `tb_type`
--

CREATE TABLE `tb_type` (
  `t_id` int(2) NOT NULL,
  `t_desc` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_type`
--

INSERT INTO `tb_type` (`t_id`, `t_desc`) VALUES
(1, 'Staff'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_ic` varchar(15) NOT NULL,
  `u_pwd` varchar(255) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `u_phone` varchar(20) NOT NULL,
  `u_email` varchar(50) DEFAULT NULL,
  `u_add` varchar(200) NOT NULL,
  `u_lic` varchar(20) NOT NULL,
  `u_type` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_ic`, `u_pwd`, `u_name`, `u_phone`, `u_email`, `u_add`, `u_lic`, `u_type`) VALUES
('031002030560', '$2y$10$ZKzQzwNa1L/qMhm1ErzOyO3Txs72EEzwSGN.VOO.vg.4ABw1pvPI.', 'FATIHAH BINTI AZMAN', '01222222222', 'arinifatihah710@gmail.com', 'Lot 27BLorong Bunga Tanjung 3/1,Senawang Industrial Park,', '98765436', 2),
('031102050390', '$2y$10$qy330sSCFbBmLesZSbvU0.z4rvWWX6Eto05XRjb.lLb6YDbimrYY.', 'ARINI BINTI SABIR', '01123305904', 'arinifatihah710@gmail.com', 'Lot 27B\r\nLorong Bunga Tanjung 3/1,\r\nSenawang Industrial Park,', '12345678', 1),
('970202034567', '$2y$10$t9E0jE1tb2RCejTX8AaRUe5lJc7Hl3GWtluSCaMU1JQuwx3ACN8lC', 'AIRIL BIN FAHIM', '0189078654', 'airil@gmail.com', '710, Jalan Cengal 16/1 Taman Ampangan, 70400 Seremban ,Negeri Sembilan', '1254768', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_vehicle`
--

CREATE TABLE `tb_vehicle` (
  `v_reg` varchar(10) NOT NULL,
  `v_type` varchar(10) NOT NULL,
  `v_model` varchar(50) NOT NULL,
  `v_colour` varchar(20) DEFAULT NULL,
  `v_price` float NOT NULL,
  `v_pic` varchar(200) DEFAULT NULL,
  `v_status` int(1) NOT NULL DEFAULT 1 COMMENT '2;Booked 1;Available 0;Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_vehicle`
--

INSERT INTO `tb_vehicle` (`v_reg`, `v_type`, `v_model`, `v_colour`, `v_price`, `v_pic`, `v_status`) VALUES
('WHO 8800', 'SEDAN', 'Toyota Corolla', 'Silver', 250, 'corolla.jpg', 0),
('WVU 4756', 'SEDAN', 'Honda Civic', 'Silver', 350, 'Civic Silver.jpg', 2),
('WYA 8990', 'SPORTS', 'Nissan 370Z', 'Orange', 2500, 'nissan sports.jpg', 2),
('WYY 1110', 'SEDAN', 'Ford Ranger', 'Silver', 550, 'ford ranger.jpg', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `password_reset_user_id` (`password_reset_user_id`);

--
-- Indexes for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `b_ic` (`b_ic`),
  ADD KEY `b_req` (`b_req`),
  ADD KEY `b_status` (`b_status`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_ic`),
  ADD KEY `u_type` (`u_type`);

--
-- Indexes for table `tb_vehicle`
--
ALTER TABLE `tb_vehicle`
  ADD PRIMARY KEY (`v_reg`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `b_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`password_reset_user_id`) REFERENCES `tb_user` (`u_ic`);

--
-- Constraints for table `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD CONSTRAINT `tb_booking_ibfk_1` FOREIGN KEY (`b_ic`) REFERENCES `tb_user` (`u_ic`),
  ADD CONSTRAINT `tb_booking_ibfk_2` FOREIGN KEY (`b_req`) REFERENCES `tb_vehicle` (`v_reg`),
  ADD CONSTRAINT `tb_booking_ibfk_3` FOREIGN KEY (`b_status`) REFERENCES `tb_status` (`s_id`);

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`u_type`) REFERENCES `tb_type` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
