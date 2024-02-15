-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 03:04 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address_line1`, `address_line2`, `city`, `District`, `postal_code`, `Subdistrict`, `created_at`, `updated_at`) VALUES
(1, 5, '94 หมู่ 5 ', '', 'ขอนแก่น', 'เมือง', '40000', 'สำราญ', '2023-10-28 22:15:00', '2023-11-06 08:06:45'),
(2, 9, '444/87 หมู่3', NULL, 'ขอนแก่น', 'เมือง', '40000', 'บ้านทุ่ม', '2023-10-28 22:15:00', '2023-10-30 04:55:22'),
(3, 12, '11', '22', 'Kk', 'kk', '1111', 'La', '2023-11-11 12:56:57', '2023-11-11 12:56:57'),
(4, 12, '11', '22', 'Kk', 'kk', '1111', 'La', '2023-11-11 12:56:59', '2023-11-11 12:56:59'),
(5, 10, 'adasda', '', 'asda', 'asdasd', 'asdasd', 'asdas', '2023-11-11 15:29:21', '2023-11-11 15:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(96, 5, '2024-03-13 20:36:55', '42900.00', 'ได้รับสินค้าแล้ว'),
(97, 9, '2024-03-08 02:54:57', '6590.00', 'กำลังจัดส่ง'),
(101, 5, '2023-06-12 05:47:43', '4290.00', 'ได้รับสินค้าแล้ว'),
(102, 5, '2023-09-05 06:45:35', '20190.00', 'ได้รับสินค้าแล้ว'),
(103, 5, '2023-11-10 16:53:52', '20190.00', 'ได้รับสินค้าแล้ว'),
(104, 5, '2023-11-10 17:26:47', '329.00', 'ได้รับสินค้าแล้ว'),
(105, 5, '2023-11-10 18:22:37', '33900.00', 'ได้รับสินค้าแล้ว'),
(106, 5, '2023-11-10 18:30:51', '59500.00', 'ได้รับสินค้าแล้ว'),
(107, 5, '2023-11-11 12:47:39', '42900.00', 'ได้รับสินค้าแล้ว'),
(108, 12, '2023-11-11 12:57:27', '122890.00', 'ได้รับสินค้าแล้ว'),
(109, 5, '2023-11-11 15:25:05', '379500.00', 'ได้รับสินค้าแล้ว');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `subtotal`) VALUES
(133, 96, 52, 10, '42900.00'),
(134, 97, 51, 1, '6590.00'),
(138, 101, 52, 1, '4290.00'),
(139, 102, 45, 1, '20190.00'),
(140, 103, 45, 1, '20190.00'),
(141, 104, 49, 1, '329.00'),
(142, 105, 73, 3, '33900.00'),
(143, 106, 70, 1, '59500.00'),
(144, 107, 52, 10, '42900.00'),
(145, 108, 67, 1, '49900.00'),
(146, 108, 78, 1, '72990.00'),
(147, 109, 77, 5, '379500.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_brand` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_stock` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `dateup` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_img`, `product_name`, `product_brand`, `product_description`, `product_stock`, `product_price`, `dateup`, `product_category_id`) VALUES
(45, 'ram1.jpg', 'แรมพีซี Corsair Ram PC DDR5 32GB/6200MHz CL36 (16GBx2) Dominator Platinum RGB (Black)', 'CORSAIR', 'ก้าวข้ามขีดจำกัดของประสิทธิภาพด้วยหน่วยความจำ CORSAIR DOMINATOR PLATINUM RGB DDR5 ที่ปรับแต่งมาเพื่อ Intel DDR5 ให้สูงขึ้น ความถี่และความจุที่มากกว่าหน่วยความจำรุ่นก่อน ชิปหน่วยความจำที่คัดแยกด้วยมือและคัดกรองอย่างแน่นหนาและ PCB แบบกำหนดเองที่ระบายความร้อ', 86, '20190.00', '2023-11-10 17:23:20', 1),
(46, 'ram2.jpg', 'แรมพีซี Thermaltake Ram PC DDR5 32GB/5200MHz.CL38 (2x16GB) TOUGHRAM RC', 'THERMALTAKE', 'แรมพีซี TOUGHRAM RC DDR5 แรมคอมพิวเตอร์ที่มาพร้อมกับความจุที่สูงขึ้นพร้อมประสิทธิภาพที่เพิ่มขึ้น เข้ากันได้กับอุปกรณ์เสริมอย่าง Floe RC และ Floe RC Ultra CPU & Memory AIO Cooler Series ทำให้ TOUGHRAM RC ให้ความยืดหยุ่นมากขึ้นเพื่อให้เข้ากับพีซีประกอบของคุ', 95, '16490.00', '2023-11-10 18:27:16', 1),
(47, 'ram4.jpg', 'แรมพีซี v-color Ram PC DDR5 32GB/5600MHz.CL40 (2x16GB) Manta XPrism RGB (Glacier White)', 'V-COLOR', 'แรมพีซี V-Color MANTA XPrism RGB แรมคอมพิวเตอร์ ที่พร้อมผสานความเร็ว ความเสถียรกว่าที่เคย และรองรับการโอเวอร์คล็อกรูปแบบใหม่สำหรับเหล่าเกมเมอร์โดยเฉพาะ ทำงานร่วมกับซีพียูเจนใหม่ที่รองรับ DDR5 ของพีซีคอมพิวเตอร์ของคุณ พร้อมโดดเด่นด้วย ชุดไฟ RGB แบบไร้รอยต่', 91, '13100.00', '2023-11-10 18:26:11', 1),
(48, 'ram1.jpg', 'แรมพีซี v-color Ram PC DDR5 32GB/5600MHz CL40 (16GBx2) Golden Armis RGB', 'V-COLOR', 'แรมพีซี v-color DDR5 Golden Armis RGB เหนือขึ้นไปอีกระดับ ที่มอบประสบการณ์การทำงานที่รวดเร็ว แรง เสถียรกว่าที่เคย เหมาะกับการ Overclocking รูปแบบใหม่สำหรับเหล่าเกมเมอร์โดยเฉพาะ', 84, '15200.00', '2023-11-10 18:25:41', 1),
(49, 'm1.jpg', 'เม้าส์เกมมิ่ง Nubwo Gaming Mouse X59 Nimbuz White', 'NUBWO', 'Ergonomic Gaming Mouse  ตัวเครื่องมีน้ำหนักเบาและตอบสนองทุกคำสั่งอย่างรวดเร็ว ปุ่มที่มากถึง 7 ปุ่ม ให้คุณเพลิดเพลินในเกมส์สวิตช์ HUANO ที่ทนทานตอบสนองทุกสัมผัส มีเซ็นเซอร์เกมส์ออปติคอลสูงสุด 7200 DPI\r\nโดดเด่นกว่าใครด้วยไฟ RGB Lighting\r\nปรับ DPI  ได้ 6 ระดับ', 3, '329.00', '2023-11-11 09:17:10', 2),
(50, 'm2.jpg', 'เม้าส์เกมมิ่ง Nubwo Gaming Mouse X43 Plus Balrog Black', 'NUBWO', 'Nubwo Gaming Mouse X43 Plus Balrog เมาส์เกมมิ่ง ไฟ RGB รอบรับการคลิก 5 ล้านครั้ง ปุ่มควบคุมชั้นสูง 7 ปุ่ม ออกแบบตามสรีระศาสตร์ที่ยอดเยี่ยม\r\n\r\nรอบรับการคลิก 5 ล้านครั้ง\r\nปุ่มควบคุม 7 ปุ่ม\r\nสามารถปรับแต่งการตั้งค่า ไฟ RGB ได้', 7, '329.00', '2023-11-10 17:23:03', 2),
(51, 'm3.jpg', 'เม้าส์เกมมิ่ง Razer Gaming Mouse Deathadder V3 Pro Faker Edition', 'RAZER', 'Razer Deathadder V3 Pro Faker Edition เมาส์รุ่นพิเศษที่ถูกออกแบบมาเพื่อเป็นตำนาน ดีไซน์น้ำหนักเบาพิเศษ 63 G ในฐานะหนึ่งในเมาส์ sports ที่ออกแบบตามหลักสรีรศาสตร์ที่เบาที่สุด RAZER FOCUS PRO 30K OPTICAL SENSOR รองรับใช้งานได้กับทุกสภาพพื้นผิวรวมถึงผิวกระจก ', 78, '6590.00', '2023-11-10 17:29:55', 2),
(52, 'm4.jpg', 'เม้าส์เกมมิ่ง SteelSeries Gaming Mouse Aerox 3 Wireless Black', 'STEELSERIES', 'เมาส์เกมมิ่งไร้สาย SteelSeries Aerox 3 Wireless เชื่อมต่อได้ถึง 3 รูปแบบ ทั้ง USB Dongle, Cable หรือ Bluetooth เพื่อความสะดวกสบาย พร้อมด้วยฟีเจอร์สำหรับการเชื่อมต่อ Quantum 2.0 จะทำการหลบช่วงสัญญาณที่มีการใช้งานสูง หรือมีคลื่นรบกวนเพื่อการเชื่อมต่อที่เสถี', 40, '4290.00', '2023-11-11 12:47:39', 2),
(63, '2023090614060161893_1.jpg', 'คีย์บอร์ดเกมมิ่ง Logitech Gaming Keyboard G Pro X TKL Lightpeed Tactile (TH/EN)', 'LOGITECH', 'Logitech  G Pro X TKL ดีไซน์กับมือโปรออกแบบเพื่อชนะ วิวัฒนาการอีกขั้นของคีย์บอร์ด PRO มอบประสิทธิภาพและความน่าเชื่อถือที่แชมป์ไว้วางใจของระบบไร้สาย Lightspped ในรูปแบบไร้แป้นตัวเลขที่ออกแบบมาเพื่อการแข่งขันในระดับสูงสุด ระบบไร้สาย Lightspped ที่แชมป์ไว้วางใจ ประสิทธิภาพ ความเร็ว เชื่อมต่อกับเมาส์และคีย์บอร์ดที่รองรับอย่างง่ายดายด้วยอะแดปเตอร์ตัวเดียว ปรับแต่งและควบคุม มาพร้อมปุ่มตั้งโปรแกรมได้', 10, '6590.00', '2023-11-10 17:57:56', 3),
(64, 'az.jpg', 'คีย์บอร์ดเกมมิ่ง Nubwo Gaming Keyboard X37 Necritz Black Greywood Switch', 'NUBWO', 'คีย์บอร์ดเกมมิ่ง รุ่น X37 NECRITZ มาพร้อมไฟ RGB สวยงาม ตอบสนองอย่างรวดเร็วและแม่นยำ เปลี่ยนประสบการณ์เล่นเกมของคุณอย่างแน่นอน รุ่นนี้สามารถเปลี่ยนสวิตซ์ได้ง่ายดาย (แบบ 5 PIN) รองรับการกดใช้งานได้มากถึง 50 ล้านครั้ง มีระบบ Anti-Ghosting 100% แถมยังสามารถ Hot Swappable และสามารถถอดเปลี่ยนสายได้ ตามความต้องการ', 10, '1590.00', '2023-11-10 17:47:51', 3),
(65, 'as.jpg', 'คีย์บอร์ดเกมมิ่ง Nubwo Gaming Keyboard X36 Kasperz Tri Mode Black Red Switch', ' NUBWO', 'คีย์บอร์ดเกมมิ่ง รุ่น Kasperz X36 ไฟแบบ RGB ทั้งหมด 87 ปุ่ม มีระบบ Anti-Ghost 100% แถมยังสามารถ Hot Swappable และถอดเปลี่ยนสาย ได้ตามต้องการ รองรับการกดปุ่มใช้งานได้ถึง 50 ล้านครั้ง แบตเตอรี่ที่ให้มา 2500 mAh สามารถเชื่อมต่อการใช้งานได้ทั้ง Bluetooth และ Wireless', 10, '1690.00', '2023-11-10 17:47:09', 3),
(66, 'zzz.jpg', 'คีย์บอร์ดเกมมิ่ง SteelSeries Gaming Keyboard Apex Pro Mini', 'STEELSERIES', 'Apex Pro Mini คีย์บอร์ด Mechanical ที่สามารถปรับระยะน้ำหนักการกดต่อปุ่มได้ โครงอะลูมิเนียม Series 5000 วัสดุเดียวกับโลหะที่ใช้ทำเครื่องบินรบ มีความแข็งแรง ทนทาน มาพร้อมสวิตช์ตัวใหม่ OmniPoint 2.0 ที่เร็วที่สุดในโลกที่สามารถตอบสนองได้เร็วขึ้น 11 เท่า แม่นยำขึ้น 10 เท่า และวัสดุคงทนแข็งแรงกว่า 2 เท่า ปรับแต่งปุ่มได้ทุกปุ่มตั้งแต่ 0.2 มม. ที่มีความไวสูงสุดไปจนถึง 3.8 มม.ที่มีความหน่วงต่ำสุด ตั้งค่าการทำงานสองอย่างในเป็นปุ่มเดียว เดินไปข้างหน้าด้วยการกดแป้นเบาๆ และจะเปลี่ยนเป็นวิ่งโดยกดแป้นเดิมให้ลึกลงไป สร้างคอมโบขั้นสูงของคุณเองเพื่อแซงหน้าคู่แข่ง', 10, '7290.00', '2023-11-10 17:55:28', 3),
(67, 'images.jpg', 'จอมอนิเตอร์ SAMSUNG LS34BG850SEXXT (OLED 2K 175Hz 1ms Curved)', 'SAMSUNG', 'จอคอมพิวเตอร์ OLED สเปคแรง คุณภาพสูง แบรนด์ Samsung  เทคโนโลยี Neo Quantum Processor จอให้เหมาะสมกับการใช้งาน สี เฉดสี และคอนทราสต์ ได้รับการปรับแต่งให้แสดงผลได้สดใสและสวยงามตลอดเวลา พร้อมจอแสดงผล Ultra-WQHD ที่มีอัตราส่วน 21:9 ให้คุณมองเห็นได้ชัดเจน อัตราการตอบสนอง 0.1ms และค่ารีเฟรชเรท 175Hz ใช้งานไม่มีสะดุดด้วยเทคโนโลยี FreeSync Premium ', 9, '49900.00', '2023-11-11 12:57:27', 4),
(68, '../product_image/images (1).jpg', 'จอมอนิเตอร์ SAMSUNG Odyssey G7 LS28BG700EEXXT (IPS 4K 144Hz Smart)', 'SAMSUNG', 'จอมอนิเตอร์ SAMSUNG MONITOR Odyssey G7 LS28BG700EEXXT (IPS 4K 144Hz Smart) ความละเอียด UHD รองรับมาตรฐาน HDR400 ทำให้ภาพที่ออกมามีคุณภาพ สะดุดตา และเปี่ยมไปด้วยความคมชัดและรายละเอียดที่ลึกมาพร้อมกับรีเฟรชเรท 144Hz, อัตราการตอบสนอง 1ms (MPRT) และรองรับ G-Sync ที่จะช่วยให้คุณยืนหนึ่งเรื่องการเล่นเกมได้', 10, '16900.00', '2023-11-10 18:04:19', 4),
(69, 'qwq.jpg', 'จอมอนิเตอร์ SAMSUNG LS27C900PAEXXT (IPS 5K 60Hz Smart)', 'SAMSUNG', 'หน้าจอ 5K ที่เชื่อมต่อเข้ากับอุปกรณ์ Windows และ Mac เครื่องโปรดของคุณได้ด้วยการเชื่อมต่อแบบ DisplayPort  เเละรองรับกับ Thunderbolt 4 ที่เพิ่มเข้ามาใหม่นี้จะช่วยให้คุณถ่ายโอนข้อมูลได้เสถียรยิ่งขึ้น', 10, '45900.00', '2023-11-10 18:06:07', 4),
(70, '../product_image/images (2).jpg', 'จอมอนิเตอร์ SAMSUNG Odyssey G9 Gaming LS49CG934SEXXT (OLED 240Hz)', 'SAMSUNG', 'SAMSUNG Odyssey G9 Gaming Monitor จอมอนิเตอร์ที่เปิดมิติใหม่ในการเล่นเกม ด้วยคุณภาพจอแสดงผล OLED ให้สีสันที่สดใส และแสงสว่างที่ไม่มีใครเทียบได้ Odyssey G9 มาด้วยหน้าจอโค้ง 49 นิ้ว สัดส่วน 32:9 ช่วยมอบประสบการณ์เล่นเกมได้อย่างสมจริง', 9, '59500.00', '2023-11-10 18:30:51', 4),
(71, 'images (3).jpg', 'ซีพียู Intel Core i5-14600KF 3.50GHz 14C/20T LGA-1700', 'INTEL', 'โปรเซสเซอร์เดสก์ท็อป Gen 14 Intel Core i5-14600KF รุ่นล่าสุดจาก Intel มี Socket LGA-1700 มี 14 คอร์ 20 เทรด รวดเร็วและทรงพลังต่อการใช้งานพื้นฐานทั่วไป โดยความเร็วจะอยู่ที่ 3.50 GHz รับประกัน 3 ปี เต็ม', 10, '12900.00', '2023-11-10 18:16:00', 5),
(72, '../product_image/images (4).jpg', 'ซีพียู Intel Core i9-14900KF 3.20GHz 24C/32T LGA-1700', 'INTEL', 'โปรเซสเซอร์เดสก์ท็อป Gen 14 Intel Core i9-14900KF รุ่นล่าสุดจาก Intel มี Socket LGA-1700 มี 24 คอร์ 32 เทรด รวดเร็วและทรงพลังต่อการใช้งานพื้นฐานทั่วไป โดยความเร็วจะอยู่ที่ 3.20 GHz รับประกัน 3 ปี เต็ม', 10, '24700.00', '2023-11-10 18:16:10', 5),
(73, '../product_image/images (5).jpg', 'ซีพียู AMD Ryzen 7 7700 3.8GHz 8C/16T AM5', 'AMD', 'AMD CPU Ryzen 7 7700 3.8 GHz 8C/16T AM5 ซีพียูคุณภาพใหม่ที่ยกระดับความคุ้มค่า ด้วยสถาปัตยกรรม Zen 4 ที่ใช้กระบวนการผลิตระดับ 5 นาโนเมตร มาพร้อมชุดกราฟฟิคการ์ด Radeon บนซีพียู ทำให้ AMD Ryzen 7 7700 มาพร้อมความเร็วประมวลผล 3.8 GHz พร้อมเร่งความเร็วได้ถึง 5.3 GHz  แกนประมวลผล 8 คอร์ 16 เธรด พร้อมแคช L3 Cache ที่สูงถึง 32 MB  ตอบโจทย์การใช้งานทั่วไป ไปจนถึงเล่นเกม สตรีม ร่วมไปถึง การสร้างสรรคอนเท้นต์หลากหลายรูปแบบ และตอบโจทย์การใช้งานร่วมกับระบบปฏิบัติ Windows 11 64-bit ใหม่ล่าสุดอีกด้วย', 7, '11300.00', '2023-11-10 18:22:37', 5),
(74, '../product_image/images (6).jpg', 'ซีพียู AMD Ryzen 5 7600 3.8GHz 6C/12T AM5', 'AMD', 'AMD CPU Ryzen 5 7600 3.8 GHz 6C/12T AM5  โปรเซสเซอร์ที่ล้ำหน้าที่สุดสำหรับการทำงานและการเล่นเกม ด้วยสถาปัตยกรรม Zen 4 ที่ใช้กระบวนการผลิตระดับ 5 นาโนเมตร มาพร้อมชุดกราฟฟิคการ์ด Radeon บนซีพียู ทำให้ AMD Ryzen 5 7600 มาพร้อมความเร็วประมวลผล 3.8 GHz พร้อมเร่งความเร็วได้ถึง 5.1 GHz แกนประมวลผล 6 คอร์ 12 เธรด พร้อมแคช L3 Cache ที่สูงถึง 32 MB ตอบโจทย์การใช้งานทั่วไป ไปจนถึงเล่นเกม สตรีม ร่วมไปถึง การสร้างสรรคอนเท้นต์หลากหลายรูปแบบ และตอบโจทย์การใช้งานร่วมกับระบบปฏิบัติ Windows 11 64-bit ใหม่ล่าสุดอีกด้วย', 10, '7500.00', '2023-11-10 18:13:52', 5),
(76, '../product_image/images_1.jpg', 'การ์ดจอ COLORFUL RTX 4060 Ti NB DUO 8GB-V 8GB GDDR6 128-bit', 'COLORFUL', 'NVIDIA GeForce RTX 40 Series GPUs สัมผัสประสบการณ์โลกเสมือนจริงที่สมจริงด้วย Ray Tracing และการเล่นเกมด้วย FPS ที่สูงเป็นพิเศษพร้อมความหน่วงที่ต่ำสุด ค้นพบวิธีใหม่ ๆ ที่ปฏิวัติวงการครเอเตอร์และเร่งความเร็วเวิร์กโฟลว์ที่ไม่เคยมีมาก่อน', 10, '15180.00', '2023-11-11 11:58:05', 6),
(77, '../product_image/images (1)_1.jpg', 'การ์ดจอ GALAX RTX 4090 SG (1-Click OC) 24GB GDDR6X 384-bit', 'GALAX', 'กราฟฟิคการ์ด NVIDIA GeForce RTX 4090 คือสุดยอด GPU GeForce การ์ดจอที่มอบการก้าวกระโดดครั้งใหญ่ในด้านสมรรถนะ ประสิทธิภาพ และกราฟิกที่ขับเคลื่อนโดย AI สัมผัสประสบการณ์การเล่นเกมที่มีประสิทธิภาพสูงเป็นพิเศษ โลกเสมือนจริงที่มีรายละเอียดอย่างไม่น่าเชื่อ ประสิทธิภาพการทำงานที่ไม่เคยมีมาก่อน และวิธีใหม่ในการสร้างสรรค์ ขับเคลื่อนโดยสถาปัตยกรรม NVIDIA Ada Lovelace และมาพร้อมกับหน่วยความจำ G6X ขนาด 24 GB เพื่อมอบสุดยอดประสบการณ์สำหรับเกมเมอร์และครีเอเตอร์', 5, '75900.00', '2023-11-11 15:25:05', 6),
(78, '../product_image/images (2)_1.jpg', 'การ์ดจอ PNY RTX 3090 24GB XLR8 Gaming REVEL EPIC-X RGB 24GB GDDR6X 384-bit', 'PNY', 'GeForce RTX 3090 เป็น GPU ไซส์ใหญ่ที่ดุดัน (BFGPU) พร้อมประสิทธิภาพระดับ TITAN ขับเคลื่อนด้วย Ampere ซึ่งเป็นสถาปัตยกรรม RTX เจเนอเรชันที่ 2 ของ NVIDIA เพื่อเพิ่มประสิทธิภาพของ Ray Tracing และ AI เป็นสองเท่า ด้วยแกน Ray Tracing (RT) Core ที่ได้รับการปรับปรุงให้ดียิ่งขึ้น Tensor Core และมัลติโปรเซสเซอร์สำหรับการสตรีมใหม่ นอกจากนี้ยังมีหน่วยความจำ G6X 24 GB ที่น่าทึ่ง ทั้งหมดนี้เพื่อมอบสุดยอดประสบการณ์การเล่นเกมให้คุณ', 9, '72990.00', '2023-11-11 12:57:27', 6),
(79, '../product_image/images (3)_1.jpg', 'การ์ดจอ COLORFUL RTX 4070 Ti NB EX-V 12GB GDDR6X 192-bit', 'COLORFUL', 'การ์ดจอ NVIDIA GeForce RTX 40 Series GPUs การ์ดกราฟฟิคที่มอบความเร็วเหนือระดับให้แก่เกมเมอร์และครีเอเตอร์ ขับเคลื่อนโดยสถาปัตยกรรม NVIDIA Ada Lovelace ที่มีประสิทธิภาพสูง เพื่อประสิทธิภาพและกราฟิกที่ขับเคลื่อนด้วย AI ที่ดีกว่าในระดับก้าวกระโดด สัมผัสประสบการณ์โลกเสมือนจริงที่สมจริงด้วย Ray Tracing และการเล่นเกมด้วย FPS ที่สูงเป็นพิเศษพร้อมความหน่วงที่ต่ำสุด ค้นพบวิธีใหม่ ๆ ที่ปฏิวัติวงการครเอเตอร์และเร่งความเร็วเวิร์กโฟลว์ที่ไม่เคยมีมาก่อน', 10, '28880.00', '2023-11-11 12:02:38', 6),
(80, 'sada.jpg', 'เมนบอร์ด MSI MEG X670E ACE AM5', 'MSI', 'เมนบอร์ด MSI MEG X670E ACE มาเธอร์บอร์ดประดับประดาความงามระดับพรีเมียมด้วยพื้นผิวสีดำเข้มและสีทอง MEG X670E ACE พัฒนาขึ้นเพื่อปลดล็อกศักยภาพการเล่นเกมอย่างเต็มรูปแบบของชิปเซ็ต AMD X670 โดยการผสมผสานการรองรับระบบฮาร์ดแวร์ชั้นยอดและความทนทานระดับพรีเมียม MEG X670E ACE เป็นแพลตฟอร์ม E-ATX ที่โดดเด่นสำหรับการตั้งค่าขั้นสูงสุดในแง่ของการโอเวอร์คล็อกหน่วยความจำ โปรเซสเซอร์ และการ์ดกราฟิกในระดับสูงสุด', 10, '30500.00', '2023-11-11 12:10:26', 7),
(81, '../product_image/images (4)_1.jpg', 'เมนบอร์ด ASRock Z790 PG SONIC DDR5 LGA-1700', 'ASROCK', 'เมนบอร์ด ASRock Z790 PG SONIC มาเธอร์บอร์ดที่ใช้ชิพ chipset Z790 รุ่นใหม่ ที่จับมือกับทาง SEGA ดีไซน์มาพร้อมธีมตัวการ์ตูน Sonic โดดเด่นด้านการเลือกสีสัน และลายกราฟิก pcb สีดำ ตัดกับ Heatsink แบบ Silver / Blue รองรับฟีเจอร์พิเศษสำหรับใช้งานร่วมกับหน่วยประมวลผล Intel Gen 12 / 13 โดยรองรับการติดตั้ง Memory แบบ DDR5, รองรับกราฟิกการ์ดมาตรฐาน PCIe 5.0, รองรับ SSD Nvme มาตรฐาน PCIe Gen5 x4 รวมไปถึงพอร์ตเชื่อมต่อ USB type-C', 10, '11500.00', '2023-11-11 12:12:35', 7),
(82, '../product_image/zzx.jpg', 'เมนบอร์ด GIGABYTE B650I AORUS ULTRA (rev.1.0) AM5', 'GIGABYTE', 'เมนบอร์ด GIGABYTE B650I AORUS ULTRA (rev. 1.0) มาเธอร์บอร์ที่รองรับการเปลี่ยนแปลงของเทคโนโลยีที่เคลื่อนไหวอย่างรวดเร็ว ทำให้ GIGABYTE B650I จะมอบคุณสมบัติขั้นสูงและเทคโนโลยีล่าสุดให้กับลูกค้า เมนบอร์ด GIGABYTE ได้รับการติดตั้งโซลูชั่นพลังงานที่ได้รับการอัพเกรด มาตรฐานการจัดเก็บข้อมูลล่าสุด และการเชื่อมต่อที่โดดเด่นเพื่อเพิ่มประสิทธิภาพในการเล่นเกม', 10, '12400.00', '2023-11-11 12:13:43', 7),
(83, '../product_image/images (5)_1.jpg', 'เมนบอร์ด ASRock B650E STEEL LEGEND WIFI DDR5 AM5', 'ASROCK', 'เมนบอร์ด ASRock B650E STEEL LEGEND WIFI DDR5 มาเธอร์บอร์ดที่ใช้ชิพ Chipset AMD B650E ระดับ Hi-end ในตระกูล Steel Legend โดดเด่นตั้งแต่การดีไซน์กราฟิกทหารที่หลาย ๆ คนคุ้นเคย แและรองรับทุกฟีเจอร์ไม่แพ้เมนบอร์ด Chipset X670E ทั้งความสามารถในการโอเวอร์คล็อก การรองรับกราฟิกการ์ด และ SSD M.2 มาตรฐาน PCIe 5.0 ทั้งหมด รองรับการเชื่อมต่อเครือข่ายที่ความเร็ว 2.5Gbps และการเชื่อมต่อไร้สายมาตรฐาน Wifi6E / Bluetooth High speed class II', 10, '10600.00', '2023-11-11 12:16:20', 7),
(84, '../product_image/jk.jpg', 'พาวเวอร์ซัพพลาย Corsair Power Supply AX1600i 1600Watt 80+Titanium -10Years (CP-9020087-NA)', 'CORSAIR', 'CORSAIR AX1600i เป็นแหล่งจ่ายไฟดิจิตอล ATX ที่ดีที่สุด สร้างขึ้นโดยใช้ส่วนประกอบที่ดีที่สุดและทรานซิสเตอร์แกลเลียมไนไตรด์ (gallium nitride) ที่ล้ำสมัยเพื่อมอบประสิทธิภาพมากกว่า 94%', 9, '20990.00', '2023-11-11 12:18:41', 8),
(85, 'jkjk.jpg', 'พาวเวอร์ซัพพลาย ASUS ROG Thor 1000W Platinum II EVA Edition', 'ASUS', 'พาวเวอร์ซัพพลาย ASUS ROG Thor 1000W Platinum II EVA Edition กับโปรเจ็กต์ EVANGELION ROG Thor II แพลทินัมรุ่น EVA ได้รับแรงบันดาลใจจาก EVA และใช้ส่วนประกอบและการอัพเกรดการระบายความร้อนที่ช่วยให้มีระดับเสียงต่ำที่สุด แม้ในระหว่างการปะทะที่รุนแรงที่สุดกับฝ่ายตรงข้าม', 10, '14990.00', '2023-11-11 12:27:51', 8),
(86, '../product_image/ssdf.jpg', 'พาวเวอร์ซัพพลาย Asus Power Supply ROG-STRIX-1000G Aura-Gaming - 10 Years', 'ASUS', 'พาวเวอร์ซัพพลาย ASUS ROG Strix 1000W Gold Aura รวมส่วนประกอบระดับพรีเมียม การระบายความร้อนที่เหนือกว่า และการส่องสว่าง RGB ที่น่าหลงใหลเพื่อสร้างพลังที่น่าเกรงขาม ด้วยฮีตซิงก์ ROG ขนาดใหญ่ พัดลม Axial-tech ประสิทธิภาพสูง และผิวอะลูมิเนียมที่โดดเด่น มันคือขุมพลัง PSU แบบปั๊มและลงสีสำหรับอุปกรณ์เล่นเกมชิ้นต่อไปของคุณ', 10, '9990.00', '2023-11-11 12:20:19', 8),
(87, '../product_image/hhhh.jpg', 'พาวเวอร์ซัพพลาย Asus Power Supply ROG-STRIX-750G Aura-Gaming - 10 Years', 'ASUS', 'พาวเวอร์ซัพพลาย ASUS ROG Strix 750W Gold Aura รวมส่วนประกอบระดับพรีเมียม การระบายความร้อนที่เหนือกว่า และการส่องสว่าง RGB ที่น่าหลงใหลเพื่อสร้างพลังที่น่าเกรงขาม ด้วยฮีตซิงก์ ROG ขนาดใหญ่ พัดลม Axial-tech ประสิทธิภาพสูง และผิวอะลูมิเนียมที่โดดเด่น มันคือขุมพลัง PSU แบบปั๊มและลงสีสำหรับอุปกรณ์เล่นเกมชิ้นต่อไปของคุณ', 10, '7490.00', '2023-11-11 12:21:30', 8);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `user_id`, `total_amount`, `timestamp`) VALUES
(152, 5, '13100.00', '2023-10-04 07:13:32'),
(153, 5, '13180.00', '2023-12-01 07:49:00'),
(154, 5, '6590.00', '2023-12-14 08:04:02'),
(155, 5, '42900.00', '2023-12-14 08:07:04'),
(156, 5, '4290.00', '2023-11-08 08:08:20'),
(157, 5, '42900.00', '2023-11-08 08:57:07'),
(158, 9, '6590.00', '2023-11-09 02:54:57'),
(159, 5, '6590.00', '2023-11-09 03:53:57'),
(160, 5, '6590.00', '2023-11-09 03:56:21'),
(161, 5, '6590.00', '2023-11-09 05:29:50'),
(162, 5, '4290.00', '2023-11-09 05:47:44'),
(163, 5, '20190.00', '2023-11-09 06:45:35'),
(164, 5, '20190.00', '2023-11-10 16:53:52'),
(165, 5, '329.00', '2023-11-10 17:26:47'),
(166, 5, '33900.00', '2023-11-10 18:22:37'),
(167, 5, '59500.00', '2023-11-10 18:30:51'),
(168, 5, '42900.00', '2023-11-11 12:47:39'),
(169, 12, '122890.00', '2023-11-11 12:57:27'),
(170, 5, '379500.00', '2023-11-11 15:25:05');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receipt_items`
--

INSERT INTO `receipt_items` (`item_id`, `receipt_id`, `product_id`, `quantity`, `price_per_unit`) VALUES
(194, 152, 47, 1, '13100.00'),
(195, 153, 51, 2, '6590.00'),
(196, 154, 51, 1, '6590.00'),
(197, 155, 52, 10, '4290.00'),
(198, 156, 52, 1, '4290.00'),
(199, 157, 52, 10, '4290.00'),
(200, 158, 51, 1, '6590.00'),
(201, 159, 51, 1, '6590.00'),
(202, 160, 51, 1, '6590.00'),
(203, 161, 51, 1, '6590.00'),
(204, 162, 52, 1, '4290.00'),
(205, 163, 45, 1, '20190.00'),
(206, 164, 45, 1, '20190.00'),
(207, 165, 49, 1, '329.00'),
(208, 166, 73, 3, '11300.00'),
(209, 167, 70, 1, '59500.00'),
(210, 168, 52, 10, '4290.00'),
(211, 169, 67, 1, '49900.00'),
(212, 169, 78, 1, '72990.00'),
(213, 170, 77, 5, '75900.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `username`, `password`, `level`, `money`, `img`, `email`, `phone`) VALUES
(5, 'ศุภกิจ', 'หล่มเหลา', 'aaa', 'aaa', 'U', 8433483, '1787599642.jpg', 'rewkisuphakit77@gmail.com', '0930509571'),
(8, 'admin', 'admin', 'admin', '123456', 'A', 0, '202310291799819675.png', 'admin@gmail.com', ''),
(9, 'ดวงฤทัย', 'อุบลบาน', 'sss', 'sss', 'U', 993409, '2048517446.jpg', 'kktech@gmail.com', '0646435354'),
(10, 'sss', 'aaa', 'hhh', 'hhh', 'U', 400, '1690516947.png', 'anuj.lpu1@gmail.com', '123546'),
(11, 'ริน', 'คนสวย', 'rinrdaaa', '16122008', 'U', 0, '20231111425344091.jpeg', 'rinrada@gmail', '-'),
(12, 'รินคนสวยสวยมากกคับ', 'มีพี่ชายเป็นแฮ็กเกอร์', 'Rinlazyyyyyy', '16122008', 'U', 877110, '202311111849664292.jpeg', 'rinradaa@gmail', '-'),
(13, 'nnn', 'nnn', 'nnn', 'nnn', 'U', 0, '202311112117637197.png', 'rewkisuphakit77@gmail.com', '-'),
(14, 'พี่กุเป็นโปรแกรมเมอร์', 'รินสวยจ้าด', 'Rinlazywheniwhitoutyou', '16122008', '', 0, '20231111570973728.jpeg', 'rinradaa@gmail.com', '');

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `receipt_items`
--
ALTER TABLE `receipt_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
