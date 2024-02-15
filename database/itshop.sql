-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 09:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `District` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `Subdistrict` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address_line1`, `address_line2`, `city`, `District`, `postal_code`, `Subdistrict`, `created_at`, `updated_at`) VALUES
(1, 5, '94 หมู่ 5 ', '', 'ขอนแก่น', 'เมือง', '40000', 'สำราญ', '2023-10-28 22:15:00', '2023-11-06 08:06:45'),
(2, 9, '444/87 หมู่3', NULL, 'ขอนแก่น', 'เมือง', '40000', 'บ้านทุ่ม', '2023-10-28 22:15:00', '2023-10-30 04:55:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'RAM'),
(2, 'mouse'),
(3, 'keyboard'),
(4, 'Monitor'),
(5, 'CPU'),
(6, 'GPU'),
(7, 'Mainboard'),
(8, 'PowerSupply');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(96, 5, '2023-11-08 08:57:07', 42900.00, 'รอดำเนินการ'),
(97, 9, '2023-11-09 02:54:57', 6590.00, 'กำลังจัดส่ง'),
(101, 5, '2023-11-09 05:47:43', 4290.00, 'กำลังจัดส่ง'),
(102, 5, '2023-11-09 06:45:35', 20190.00, 'กำลังจัดส่ง');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `subtotal`) VALUES
(133, 96, 52, 10, 42900.00),
(134, 97, 51, 1, 6590.00),
(138, 101, 52, 1, 4290.00),
(139, 102, 45, 1, 20190.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_brand` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `dateup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_img`, `product_name`, `product_brand`, `product_description`, `product_stock`, `product_price`, `dateup`, `product_category_id`) VALUES
(45, '../product_image/ram1.jpg', 'แรมพีซี Corsair Ram PC DDR5 32GB/6200MHz CL36 (16GBx2) Dominator Platinum RGB (Black)', 'CORSAIR', 'ก้าวข้ามขีดจำกัดของประสิทธิภาพด้วยหน่วยความจำ CORSAIR DOMINATOR PLATINUM RGB DDR5 ที่ปรับแต่งมาเพื่อ Intel DDR5 ให้สูงขึ้น ความถี่และความจุที่มากกว่าหน่วยความจำรุ่นก่อน ชิปหน่วยความจำที่คัดแยกด้วยมือและคัดกรองอย่างแน่นหนาและ PCB แบบกำหนดเองที่ระบายความร้อ', 87, 20190.00, '2023-11-09 06:45:35', 1),
(46, '../product_image/ram2.jpg', 'แรมพีซี Thermaltake Ram PC DDR5 32GB/5200MHz.CL38 (2x16GB) TOUGHRAM RC', 'THERMALTAKE', 'แรมพีซี TOUGHRAM RC DDR5 แรมคอมพิวเตอร์ที่มาพร้อมกับความจุที่สูงขึ้นพร้อมประสิทธิภาพที่เพิ่มขึ้น เข้ากันได้กับอุปกรณ์เสริมอย่าง Floe RC และ Floe RC Ultra CPU & Memory AIO Cooler Series ทำให้ TOUGHRAM RC ให้ความยืดหยุ่นมากขึ้นเพื่อให้เข้ากับพีซีประกอบของคุ', 95, 16490.00, '2023-11-08 06:33:50', 1),
(47, '../product_image/ram3.jpg', 'แรมพีซี v-color Ram PC DDR5 32GB/5600MHz.CL40 (2x16GB) Manta XPrism RGB (Glacier White)', 'V-COLOR', 'แรมพีซี V-Color MANTA XPrism RGB แรมคอมพิวเตอร์ ที่พร้อมผสานความเร็ว ความเสถียรกว่าที่เคย และรองรับการโอเวอร์คล็อกรูปแบบใหม่สำหรับเหล่าเกมเมอร์โดยเฉพาะ ทำงานร่วมกับซีพียูเจนใหม่ที่รองรับ DDR5 ของพีซีคอมพิวเตอร์ของคุณ พร้อมโดดเด่นด้วย ชุดไฟ RGB แบบไร้รอยต่', 91, 13100.00, '2023-11-08 07:13:32', 1),
(48, '../product_image/ram4.jpg', 'แรมพีซี v-color Ram PC DDR5 32GB/5600MHz CL40 (16GBx2) Golden Armis RGB', 'V-COLOR', 'แรมพีซี v-color DDR5 Golden Armis RGB เหนือขึ้นไปอีกระดับ ที่มอบประสบการณ์การทำงานที่รวดเร็ว แรง เสถียรกว่าที่เคย เหมาะกับการ Overclocking รูปแบบใหม่สำหรับเหล่าเกมเมอร์โดยเฉพาะ', 84, 15200.00, '2023-11-08 05:40:40', 1),
(49, '../product_image/m1.jpg', 'เมาส์เกมมิ่ง Nubwo Gaming Mouse X59 Nimbuz White', 'NUBWO', 'Ergonomic Gaming Mouse  ตัวเครื่องมีน้ำหนักเบาและตอบสนองทุกคำสั่งอย่างรวดเร็ว ปุ่มที่มากถึง 7 ปุ่ม ให้คุณเพลิดเพลินในเกมส์สวิตช์ HUANO ที่ทนทานตอบสนองทุกสัมผัส มีเซ็นเซอร์เกมส์ออปติคอลสูงสุด 7200 DPI\r\n\r\nโดดเด่นกว่าใครด้วยไฟ RGB Lighting\r\nปรับ DPI  ได้ 6 ร', 0, 329.00, '2023-11-01 03:23:09', 2),
(50, '../product_image/m2.jpg', 'เมาส์เกมมิ่ง Nubwo Gaming Mouse X43 Plus Balrog Black', 'NUBWO', 'Nubwo Gaming Mouse X43 Plus Balrog เมาส์เกมมิ่ง ไฟ RGB รอบรับการคลิก 5 ล้านครั้ง ปุ่มควบคุมชั้นสูง 7 ปุ่ม ออกแบบตามสรีระศาสตร์ที่ยอดเยี่ยม\r\n\r\nรอบรับการคลิก 5 ล้านครั้ง\r\nปุ่มควบคุม 7 ปุ่ม\r\nสามารถปรับแต่งการตั้งค่า ไฟ RGB ได้', 0, 329.00, '2023-11-02 04:25:47', 2),
(51, '../product_image/m3.jpg', 'เมาส์เกมมิ่ง Razer Gaming Mouse Deathadder V3 Pro Faker Edition', 'RAZER', 'Razer Deathadder V3 Pro Faker Edition เมาส์รุ่นพิเศษที่ถูกออกแบบมาเพื่อเป็นตำนาน ดีไซน์น้ำหนักเบาพิเศษ 63 G ในฐานะหนึ่งในเมาส์ sports ที่ออกแบบตามหลักสรีรศาสตร์ที่เบาที่สุด RAZER FOCUS PRO 30K OPTICAL SENSOR รองรับใช้งานได้กับทุกสภาพพื้นผิวรวมถึงผิวกระจก ', 78, 6590.00, '2023-11-09 05:29:50', 2),
(52, '../product_image/m4.jpg', 'เมาส์เกมมิ่ง SteelSeries Gaming Mouse Aerox 3 Wireless Black', 'STEELSERIES', 'เมาส์เกมมิ่งไร้สาย SteelSeries Aerox 3 Wireless เชื่อมต่อได้ถึง 3 รูปแบบ ทั้ง USB Dongle, Cable หรือ Bluetooth เพื่อความสะดวกสบาย พร้อมด้วยฟีเจอร์สำหรับการเชื่อมต่อ Quantum 2.0 จะทำการหลบช่วงสัญญาณที่มีการใช้งานสูง หรือมีคลื่นรบกวนเพื่อการเชื่อมต่อที่เสถี', 51, 4290.00, '2023-11-09 05:47:43', 2);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `user_id`, `total_amount`, `timestamp`) VALUES
(152, 5, 13100.00, '2023-11-08 07:13:32'),
(153, 5, 13180.00, '2023-11-08 07:49:00'),
(154, 5, 6590.00, '2023-11-08 08:04:02'),
(155, 5, 42900.00, '2023-11-08 08:07:04'),
(156, 5, 4290.00, '2023-11-08 08:08:20'),
(157, 5, 42900.00, '2023-11-08 08:57:07'),
(158, 9, 6590.00, '2023-11-09 02:54:57'),
(159, 5, 6590.00, '2023-11-09 03:53:57'),
(160, 5, 6590.00, '2023-11-09 03:56:21'),
(161, 5, 6590.00, '2023-11-09 05:29:50'),
(162, 5, 4290.00, '2023-11-09 05:47:44'),
(163, 5, 20190.00, '2023-11-09 06:45:35');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_items`
--

CREATE TABLE `receipt_items` (
  `item_id` int(11) NOT NULL,
  `receipt_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price_per_unit` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt_items`
--

INSERT INTO `receipt_items` (`item_id`, `receipt_id`, `product_id`, `quantity`, `price_per_unit`) VALUES
(194, 152, 47, 1, 13100.00),
(195, 153, 51, 2, 6590.00),
(196, 154, 51, 1, 6590.00),
(197, 155, 52, 10, 4290.00),
(198, 156, 52, 1, 4290.00),
(199, 157, 52, 10, 4290.00),
(200, 158, 51, 1, 6590.00),
(201, 159, 51, 1, 6590.00),
(202, 160, 51, 1, 6590.00),
(203, 161, 51, 1, 6590.00),
(204, 162, 52, 1, 4290.00),
(205, 163, 45, 1, 20190.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `money` int(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `password`, `level`, `money`, `img`, `email`, `phone`) VALUES
(5, 'ศุภกิจ', 'หล่มเหลา', 'aaa', 'aaa', 'U', 8969802, '1787599642.jpg', 'rewkisuphakit77@gmail.com', '0930509571'),
(8, 'admin', 'admin', 'admin', '123456', 'A', 0, '202310291799819675.png', 'admin@gmail.com', ''),
(9, 'ดวงฤทัย', 'อุบลบาน', 'sss', 'sss', 'U', 993409, '2048517446.jpg', 'kktech@gmail.com', '0646435354'),
(10, 'sss', 'aaa', 'hhh', 'hhh', 'U', 400, '1698738613.jpg', 'anuj.lpu1@gmail.com', '123546');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_id` (`product_category_id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `receipt_items`
--
ALTER TABLE `receipt_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `receipt_id` (`receipt_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `receipt_items`
--
ALTER TABLE `receipt_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `receipt_items`
--
ALTER TABLE `receipt_items`
  ADD CONSTRAINT `receipt_items_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`receipt_id`),
  ADD CONSTRAINT `receipt_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
