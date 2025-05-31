-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 01:40 AM
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
-- Database: `probasyon`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `alias` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `info_stat` varchar(255) NOT NULL,
  `case_number` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `caretaker_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `middle_name`, `last_name`, `suffix`, `alias`, `email`, `mobile_number`, `dob`, `gender`, `street`, `barangay`, `municipality`, `info_stat`, `case_number`, `status`, `registration_date`, `caretaker_user_id`) VALUES
(1, 'ed', 'Sison', 'Rana', '', 'jay', 'ed@example.com', '09285553336', '2005-06-07', 'Male', '41478', 'maytalang', 'lumban', 'Bailed', 445566, 'completed', '2023-12-07 03:03:27', 0),
(2, 'Peter', '', 'Parker', '', 'Spidey', 'peter@example.com', '09252564585', '2005-06-08', 'Male', 'web', 'mass', 'Kalayaan', 'Bailed', 445588, 'denied', '2023-12-07 03:11:09', 0),
(3, 'stephen', 'stone', 'strange', '', 'dr', 'stephen@example.com', '09256549875', '2005-10-03', 'Male', 'Nyc', 'massa', 'Paete', 'BAILED', 445552, 'grant', '2023-12-07 03:23:51', 0),
(4, 'Mickey', 'M', 'mouse', 'IV', 'dodeng daga', 'mickey@example.com', '09758456213', '2000-04-20', 'Male', 'kanye', 'monde', 'Cavinti', 'BAILED', 448832, 'pending', '2023-12-07 03:29:59', 0),
(5, 'Tony', 'Time', 'Stark', '', 'Iron Man', 'Tony@example.com', '09095873216', '2001-01-09', 'Male', '3000', 'L.A', 'Sta.maria', 'BAILED', 3003, 'completed', '2023-12-11 14:07:24', 0),
(6, 'Thor', 'Thunder', 'Odinson', '', 'God of Thunder', 'thor@example.com', '09221567412', '1996-01-02', 'Male', '616', 'Adgard', 'Cavinti', 'PDL', 4493, 'pending', '2023-12-11 14:20:10', 0),
(7, 'chinchin', 'chi', 'chemera', '', 'ant', 'chin@example.com', '09887544123', '1989-10-08', 'Female', 'new', 'bago', 'Liliw', 'BAILED', 778899, 'completed', '2023-12-19 15:00:17', 0),
(8, 'Eddie', 'V', 'Brock', '', 'Venom', 'eddie@example.com', '09225503876', '1993-06-05', 'Male', 'Klyntar', 'Planet', 'Paete', 'BAILED', 1479, 'revoked', '2024-01-06 17:15:16', 0),
(9, 'Adam', 'M', 'Warlock', 'III', 'Savior', 'adam@exampl.com', '09194563217', '1990-06-24', 'Male', 'Shard', 'Island', 'Pila', 'BAILED', 6240, NULL, '2024-01-06 17:20:33', 0),
(10, 'America', '', 'Chaves', '', 'Miss America', 'america@example.com', '09163216548', '1985-07-30', 'Female', 'Utopian', 'Parallel', 'Pakil', 'BAILED', 6165, 'grant', '2024-01-06 17:28:56', 0),
(11, 'Luke', 'T', 'Charles', '', 'Black Panther', 'luke@example.com', '09091234567', '1992-03-25', 'Male', 'Wankanda', 'affi', 'Mabitac', 'PDL', 6200, NULL, '2024-01-09 22:12:06', 0),
(12, 'Steve', '', 'Rogers', '', 'Captain America', 'steve@example.com', '09081593577', '1985-01-31', 'Male', 'Manhattan', 'York', 'Siniloan', 'BAILED', 62240, 'grant', '2024-01-09 22:48:39', 0),
(13, 'Carol', '', 'Danvers', '', 'Captain Marvel', 'carol@example.com', '09212152361', '1979-04-20', 'Female', 'Boston', 'rizal', 'Victoria', 'BAILED', 51165, NULL, '2024-01-09 22:53:09', 0),
(14, 'Matt', 'D', 'Murdock', '', 'Daredevil', 'matt@example.com', '09285252369', '1977-05-11', 'Male', 'Clinton', 'maulawin', 'Pagsanjan', 'BAILED', 6201, NULL, '2024-01-09 22:57:47', 0),
(15, 'En', 'Dwi', 'Gast', '', 'Grandmaster', 'en@example.com', '09235624789', '1970-11-16', 'Male', 'Uni', 'general', 'Majayjay', 'PDL', 71240, NULL, '2024-01-10 01:46:29', 0),
(16, 'Norman', '', 'Osborn', 'Sr.', 'Green Goblin', 'norman@example.com', '09225314879', '1949-10-02', 'Male', 'Hardford', 'Connecticut', 'Pakil', 'PDL', 51164, 'denied', '2024-01-10 01:49:49', 0),
(17, 'Clint', '', 'Barton', '', 'Hawkeye', 'clint@example.com', '09225457896', '1977-02-22', 'Male', 'Waverly', 'Iowa', 'Famy', 'BAILED', 63230, NULL, '2024-01-10 01:52:29', 0),
(18, 'Donald', '', 'Velez', '', 'Heimdallr', 'donald@example.com', '09204458879', '1954-07-12', 'Male', 'Himinbjorg', 'Puti', 'Magdalena', 'PDL', 72525, NULL, '2024-01-10 02:02:23', 0),
(19, 'Bruce', 'B', 'Banner', '', 'Hulk', 'bruce@example.com', '09352541113', '1964-08-12', 'Male', 'Dayton', 'Ohio', 'Sta.Maria', 'BAILED', 5976, NULL, '2024-01-10 02:05:58', 0),
(20, 'Jane', '', 'Foster', '', 'The Mighty Thor', 'jane@example.com', '09235698741', '1979-01-10', 'Female', 'balubad', 'lutang', 'Sta.Cruz', 'PDL', 3000, NULL, '2024-01-10 02:10:36', 0),
(21, 'Nathaniel', '', 'Richards', '', 'Kang the Conqueror', 'nathaniel@example.com', '09193654874', '1978-10-31', 'Male', 'Kalye Onse', 'Bagong Silang', 'Lumban', 'BAILED', 631131, 'denied', '2024-01-10 02:14:16', 0),
(22, 'Loki', '', 'Laufeyson', '', 'God od Mischief', 'fortestemail92@gmail.com', '09174569873', '1990-11-05', 'Male', 'Jotunheim', 'pagsawitan', 'Sta.Cruz', 'BAILED', 64525, 'denied', '2024-01-10 02:17:54', 0),
(23, 'Marc', '', 'Spector', '', 'Moon Knight', 'marc@example.com', '09163203265', '1948-04-20', 'Male', 'Chicago', 'Illinois', 'Luisiana', 'PDL', 62225, NULL, '2024-01-10 02:21:59', 0),
(24, 'Kamala', '', 'Khan', '', 'Ms. Marvel', 'kamala@example.com', '09228796326', '1983-01-16', 'Female', 'Jersey', 'secret', 'Famy', 'BAILED', 54125, NULL, '2024-01-10 02:24:42', 0),
(25, 'Namor', '', 'Mckenzie', '', 'Sub-Mariner', 'namor@example.com', '09664478513', '1959-01-31', 'Male', 'Antarctic', 'Atlantis', 'Cavinti', 'PDL', 62278, NULL, '2024-01-10 02:27:11', 0),
(26, 'Nick', '', 'Fury', 'III', 'Super spy', 'nick@example.com', '09632541220', '1966-11-16', 'Male', 'newton', 'lewin', 'Siniloan', 'BAILED', 5540, NULL, '2024-01-10 02:30:28', 0),
(27, 'Odin', '', 'Borson', '', 'All-Father', 'odin@example.com', '09285467863', '1932-12-22', 'Male', 'sorbet', 'astin', 'Liliw', 'BAILED', 69650, 'grant', '2024-01-10 02:33:59', 0),
(28, 'Virginia', 'P', 'Potts', '', 'Pepper', 'virginia@example.com', '09638527419', '1974-09-10', 'Female', 'New Haven', 'Connecticut', 'Pangil', 'BAILED', 54110, NULL, '2024-01-10 02:36:23', 0),
(29, 'Wanda', '', 'Maximoff', '', 'Scarlet Witch', 'wanda@example.com', '09293216549', '1969-12-15', 'Female', 'Wundagore', 'Transia', 'Luisiana', 'PDL', 57132, NULL, '2024-01-10 10:01:21', 0),
(30, 'Aja', '', 'Adanna', '', 'Shuri', 'aja@example.com', '09278529637', '1965-09-07', 'Female', 'Wakanda', 'segunda pulo', 'Lumban', 'BAILED', 104, NULL, '2024-01-10 10:12:20', 0),
(31, 'Peter', '', 'Quill', '', 'Star-Lord', 'peterq@example.com', '09287412583', '1980-11-18', 'Male', 'Colorado', 'Lewin', 'Lumban', 'BAILED', 62175, NULL, '2024-01-10 10:16:08', 0),
(32, 'Anthony', 'T.', 'Masters', '', 'Taskmaster', 'anthony@example.com', '09271477412', '1982-01-19', 'Male', 'Bronx', 'New York', 'Siniloan', 'PDL', 62220, 'denied', '2024-01-10 10:20:52', 0),
(33, 'Victor', '', 'Shade', '', 'The Vision', 'victor@example.com', '09293699633', '1977-06-15', 'Male', 'Ultrons', 'Lab', 'Pangil', 'BAILED', 63300, 'grant', '2024-01-10 10:29:36', 0),
(34, 'Yondu', '', 'Udonta', 'Sr.', 'Yondu', 'yondu@example.com', '09263635548', '1965-02-17', 'Male', 'Plysa', 'Centauri', 'Famy', 'BAILED', 62210, 'revoked', '2024-01-10 10:32:07', 0),
(35, 'Bruce', '', 'Wayne', '', 'Batman', 'wayne@example.com', '09399517536', '1980-02-05', 'Male', 'Gotham', 'Salac', 'Lumban', 'BAILED', 1939, NULL, '2024-01-13 19:17:58', 0),
(36, 'Victor', 'Vic', 'Stone', '', 'Cyborg', 'victore@example.com', '09265445635', '1968-06-11', 'Male', 'poblacion', 'Numero', 'Mabitac', 'PDL', 55887, NULL, '2024-01-14 01:19:15', 0),
(37, 'Clark', 'Kal-El', 'Kent', '', 'Superman', 'clark@example.com', '09157896543', '1983-09-18', 'Male', 'metropolis', 'tanawan', 'Magdalena', 'BAILED', 1938, NULL, '2024-01-14 01:21:41', 0),
(38, 'Kent', '', 'Nelson', 'II', 'Doctor Fate', 'kent@example.com', '09212125634', '1985-06-14', 'Male', 'san', 'burol', 'Majayjay', 'PDL', 1940, NULL, '2024-01-14 13:05:15', 0),
(39, 'Richard', 'D', 'Grayson', '', 'Robin', 'richard@example.com', '09215202367', '1972-10-23', 'Male', 'Gotham', 'duhat', 'Sta.Cruz', 'PDL', 194038, NULL, '2024-01-14 13:12:12', 0),
(40, 'Billy', '', 'Batson', '', 'Captain Marvel', 'billy@example.com', '09232654826', '1985-11-20', 'Male', 'rizal', 'coralan', 'Sta.Maria', 'BAILED', 19402, NULL, '2024-01-14 13:14:52', 0),
(41, 'Marcial', '', 'Ama', '', 'Baby Ama', 'baby@example.com', '09875452163', '1984-10-18', 'Male', 'tondo', 'tondo', 'Mabitac', 'PDL', 196116, NULL, '2024-01-18 11:12:56', 0),
(42, 'Leonardo', '', 'Malecio', '', 'Nardong Putik', 'leonardo@example.com', '09287964312', '1980-11-01', 'Male', 'watis', 'liyang', 'Famy', 'PDL', 1969181, NULL, '2024-01-18 11:16:45', 0),
(43, 'Warlito', '', 'Toledo', '', 'Waway', 'warlito@example.com', '09212134356', '1990-04-11', 'Male', 'cebu', 'longos', 'Kalayaan', 'BAILED', 4040, 'denied', '2024-01-18 11:19:31', 0),
(44, 'Nicasio', '', 'Salonga', '', 'Asiong', 'nicasio@example.com', '09293223656', '1984-05-29', 'Male', 'tondo', 'bongkol', 'Liliw', 'BAILED', 71951, NULL, '2024-01-18 11:22:48', 0),
(45, 'Grepor', 'B', 'Belgica', '', 'Butch', 'grepor@example.com', '09242156312', '1990-06-13', 'Male', 'san', 'bukal', 'Pila', 'PDL', 20163, NULL, '2024-01-18 11:25:09', 0),
(46, 'Vicente', 'S.', 'Crisologo', '', 'Bingbong', 'vincente@example.com', '09251324555', '1984-05-23', 'Male', 'ilocos', 'sulib', 'Pangil', 'BAILED', 37335, NULL, '2024-01-18 11:27:19', 0),
(47, 'Benjamin', '', 'Garcia', '', 'Ben Tumbling', 'benjamin@example.com', '09145639877', '1999-08-20', 'Male', 'malabon', 'saray', 'Pakil', 'PDL', 198113, 'revoked', '2024-01-18 11:29:31', 0),
(48, 'Ruben', '', 'Ecleo', 'Jr.', 'Parisido', 'ruben@example.com', '09244257784', '1980-05-12', 'Male', 'dinagat', 'sabang', 'Pagsanjan', 'BAILED', 8723, NULL, '2024-01-19 07:11:38', 0),
(49, 'Marvin', '', 'Mercado', '', 'Shyboy', 'marvin@example.com', '09225114733', '1983-11-30', 'Male', 'vendor', 'ermita', 'Paete', 'PDL', 19948, NULL, '2024-01-19 07:13:57', 0),
(50, 'Harold', 'L', 'Fajardo', '', 'Harold', 'harold@example.com', '09231147880', '1974-10-22', 'Male', 'suplang', 'tanawan', 'Majayjay', 'BAILED', 55135, NULL, '2024-01-19 07:17:32', 0),
(51, 'Eduardo', '', 'Iran', '', 'Boy muslim', 'eduardo@example.com', '09114451123', '1970-01-27', 'Male', 'towito', 'malinao', 'Magdalena', 'BAILED', 9356, NULL, '2024-01-19 07:20:20', 11),
(52, 'boy', 'b', 'bastos', 'IV', 'Boss bastos', 'boy@example.com', '09244466337', '1986-02-26', 'Male', 'doon', 'sa', 'Kalayaan', 'BAILED', 144720, NULL, '2024-01-30 23:32:06', 0),
(53, 'Jose', 'S', 'Panlilio', '', 'Bong', 'jose@example.com', '09287591634', '1989-01-10', 'Male', 'purok uno', 'balubad', 'Lumban', 'PDL', 72214, 'completed', '2024-03-18 02:51:28', 17);

-- --------------------------------------------------------

--
-- Table structure for table `client_requirements`
--

CREATE TABLE `client_requirements` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `requirement_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `file_size` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `uploaded_by` varchar(255) NOT NULL,
  `upload_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_requirements`
--

INSERT INTO `client_requirements` (`id`, `client_id`, `requirement_name`, `file_name`, `file_type`, `file_size`, `status`, `uploaded_by`, `upload_date`) VALUES
(10, 1, 'case_info', '1_case_info.jpg', 'image/jpeg', 79215, 'valid', 'fortestemail92@gmail.com', '2023-12-17 19:22:10'),
(12, 1, 'case_judgement', '1_case_judgement.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2023-12-17 19:35:21'),
(13, 1, 'petition_for_probation', '1_petition_for_probation.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2023-12-17 19:40:38'),
(23, 1, 'order_to_conduct_ps1', '1_ps1.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2023-12-18 21:39:56'),
(34, 2, 'birth_certificate', '2_birth_cert.jpg', 'image/jpeg', 14648, 'pending', 'fortestemail92@gmail.com', '2023-12-21 00:44:13'),
(35, 1, 'barangay_clearance', '1_barangay_clearance.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2023-12-21 17:30:00'),
(36, 1, 'valid_id', '1_valid_id.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2023-12-21 21:19:02'),
(38, 1, 'talambuhay', '1_talambuhay.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2023-12-21 22:02:27'),
(39, 1, 'birth_certificate', '1_birth_cert.png', 'image/png', 19711, 'valid', 'fortestemail92@gmail.com', '2023-12-22 00:22:42'),
(40, 1, 'case_dissmissed', '1_case_dissmissed.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2023-12-22 00:22:51'),
(41, 1, 'police_clearance', '1_police_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2023-12-22 01:04:04'),
(42, 1, 'mtc_mtcc_clearance', '1_mtc_mtcc_clearance.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2023-12-22 01:04:10'),
(43, 1, 'nbi_clearance', '1_nbi_clearance.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2023-12-22 01:04:15'),
(44, 1, 'drug_test_result', '1_drug_test_result.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2023-12-22 01:04:20'),
(61, 4, 'birth_certificate', '4_birth_certificate.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:34:40'),
(63, 4, 'talambuhay', '4_talambuhay.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:41:13'),
(65, 4, 'case_info', '4_case_info.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:41:27'),
(66, 4, 'case_judgement', '4_case_judgement.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:41:34'),
(67, 4, 'petition_for_probation', '4_petition_for_probation.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:41:44'),
(69, 4, 'order_to_conduct_ps1', '4_order_to_conduct_ps1.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:46:39'),
(70, 4, 'case_dissmissed', '4_case_dissmissed.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:47:51'),
(71, 4, 'police_clearance', '4_police_clearance.png', 'image/png', 19711, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:49:14'),
(72, 4, 'mtc_mtcc_clearance', '4_mtc_mtcc_clearance.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:50:30'),
(73, 4, 'nbi_clearance', '4_nbi_clearance.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2023-12-26 13:51:39'),
(75, 4, 'valid_id', '4_valid_id.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2023-12-26 16:14:05'),
(76, 3, 'birth_certificate', '3_birth_certificate.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:00'),
(77, 3, 'valid_id', '3_valid_id.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:06'),
(78, 3, 'talambuhay', '3_talambuhay.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:11'),
(79, 3, 'barangay_clearance', '3_barangay_clearance.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:18'),
(80, 3, 'case_info', '3_case_info.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:27'),
(81, 3, 'case_judgement', '3_case_judgement.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:34'),
(82, 3, 'petition_for_probation', '3_petition_for_probation.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:40'),
(83, 3, 'order_to_conduct_ps1', '3_order_to_conduct_ps1.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:08:50'),
(84, 3, 'case_dissmissed', '3_case_dissmissed.png', 'image/png', 19711, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:09:01'),
(85, 3, 'police_clearance', '3_police_clearance.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:09:10'),
(86, 3, 'mtc_mtcc_clearance', '3_mtc_mtcc_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:09:24'),
(87, 3, 'nbi_clearance', '3_nbi_clearance.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:09:29'),
(88, 3, 'drug_test_result', '3_drug_test_result.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-04 01:09:40'),
(96, 5, 'talambuhay', '5_talambuhay.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-05 04:06:19'),
(103, 5, 'birth_certificate', '5_birth_certificate.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2024-01-05 06:47:45'),
(104, 5, 'valid_id', '5_valid_id.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-05 17:46:32'),
(105, 5, 'barangay_clearance', '5_barangay_clearance.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-05 17:46:40'),
(106, 5, 'case_info', '5_case_info.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2024-01-05 17:52:56'),
(107, 5, 'case_judgement', '5_case_judgement.png', 'image/png', 72942, 'valid', 'fortestemail92@gmail.com', '2024-01-05 17:59:07'),
(108, 5, 'petition_for_probation', '5_petition_for_probation.png', 'image/png', 54770, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:02:20'),
(109, 5, 'order_to_conduct_ps1', '5_order_to_conduct_ps1.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:16:42'),
(110, 5, 'case_dissmissed', '5_case_dissmissed.png', 'image/png', 9241, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:18:29'),
(111, 5, 'police_clearance', '5_police_clearance.png', 'image/png', 7406, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:21:40'),
(112, 5, 'mtc_mtcc_clearance', '5_mtc_mtcc_clearance.png', 'image/png', 24293, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:21:49'),
(113, 5, 'nbi_clearance', '5_nbi_clearance.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:42:50'),
(114, 5, 'drug_test_result', '5_drug_test_result.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-05 18:44:14'),
(115, 6, 'birth_certificate', '6_birth_certificate.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-05 19:15:41'),
(116, 6, 'valid_id', '6_valid_id.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-06 00:52:48'),
(117, 6, 'talambuhay', '6_talambuhay.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-06 00:54:42'),
(118, 6, 'barangay_clearance', '6_barangay_clearance.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-06 00:56:11'),
(119, 6, 'case_info', '6_case_info.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-06 00:57:37'),
(120, 6, 'case_judgement', '6_case_judgement.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-06 00:58:52'),
(121, 6, 'petition_for_probation', '6_petition_for_probation.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-06 01:00:47'),
(122, 6, 'order_to_conduct_ps1', '6_order_to_conduct_ps1.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-06 01:01:53'),
(123, 6, 'case_dissmissed', '6_case_dissmissed.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-06 01:02:47'),
(125, 6, 'mtc_mtcc_clearance', '6_mtc_mtcc_clearance.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2024-01-06 01:05:04'),
(127, 4, 'drug_test_result', '4_drug_test_result.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-09 04:28:15'),
(128, 4, 'barangay_clearance', '4_barangay_clearance.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-09 04:57:41'),
(129, 8, 'birth_certificate', '8_birth_certificate.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:24'),
(130, 8, 'valid_id', '8_valid_id.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:30'),
(131, 8, 'talambuhay', '8_talambuhay.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:36'),
(132, 8, 'barangay_clearance', '8_barangay_clearance.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:43'),
(133, 8, 'case_info', '8_case_info.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:50'),
(134, 8, 'case_judgement', '8_case_judgement.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:52:56'),
(135, 8, 'petition_for_probation', '8_petition_for_probation.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:53:02'),
(137, 8, 'case_dissmissed', '8_case_dissmissed.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:53:24'),
(138, 8, 'police_clearance', '8_police_clearance.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:53:57'),
(139, 8, 'mtc_mtcc_clearance', '8_mtc_mtcc_clearance.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:54:06'),
(140, 8, 'nbi_clearance', '8_nbi_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:54:32'),
(141, 8, 'drug_test_result', '8_drug_test_result.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:54:37'),
(142, 8, 'order_to_conduct_ps1', '8_order_to_conduct_ps1.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-13 01:56:19'),
(143, 7, 'birth_certificate', '7_birth_certificate.jpg', 'image/jpeg', 34952, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:01'),
(144, 7, 'valid_id', '7_valid_id.jpg', 'image/jpeg', 204457, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:07'),
(145, 7, 'talambuhay', '7_talambuhay.jpg', 'image/jpeg', 71622, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:13'),
(146, 7, 'barangay_clearance', '7_barangay_clearance.png', 'image/png', 24910, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:39'),
(147, 7, 'case_info', '7_case_info.png', 'image/png', 24270, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:45'),
(148, 7, 'case_judgement', '7_case_judgement.png', 'image/png', 24219, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:51'),
(149, 7, 'petition_for_probation', '7_petition_for_probation.png', 'image/png', 26293, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:45:57'),
(150, 7, 'order_to_conduct_ps1', '7_order_to_conduct_ps1.png', 'image/png', 24293, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:05'),
(151, 7, 'case_dissmissed', '7_case_dissmissed.png', 'image/png', 24448, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:11'),
(152, 7, 'police_clearance', '7_police_clearance.png', 'image/png', 9241, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:16'),
(153, 7, 'mtc_mtcc_clearance', '7_mtc_mtcc_clearance.png', 'image/png', 5295, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:21'),
(154, 7, 'nbi_clearance', '7_nbi_clearance.png', 'image/png', 5295, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:28'),
(155, 7, 'drug_test_result', '7_drug_test_result.png', 'image/png', 7406, 'valid', 'edranatest07@gmail.com', '2024-01-13 10:46:34'),
(156, 22, 'birth_certificate', '22_birth_certificate.png', 'image/png', 7406, 'pending', 'edranatest07@gmail.com', '2024-01-13 18:01:45'),
(157, 32, 'birth_certificate', '32_birth_certificate.png', 'image/png', 7406, 'pending', 'fortestemail92@gmail.com', '2024-01-14 13:57:52'),
(158, 12, 'birth_certificate', '12_birth_certificate.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:29'),
(159, 12, 'valid_id', '12_valid_id.png', 'image/png', 24270, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:34'),
(160, 12, 'talambuhay', '12_talambuhay.png', 'image/png', 24219, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:40'),
(161, 12, 'barangay_clearance', '12_barangay_clearance.png', 'image/png', 23547, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:46'),
(162, 12, 'case_info', '12_case_info.png', 'image/png', 26293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:51'),
(163, 12, 'case_judgement', '12_case_judgement.png', 'image/png', 24293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:25:57'),
(164, 12, 'petition_for_probation', '12_petition_for_probation.png', 'image/png', 24448, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:03'),
(165, 12, 'order_to_conduct_ps1', '12_order_to_conduct_ps1.png', 'image/png', 9241, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:12'),
(166, 12, 'case_dissmissed', '12_case_dissmissed.png', 'image/png', 5295, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:19'),
(167, 12, 'police_clearance', '12_police_clearance.png', 'image/png', 5295, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:27'),
(168, 12, 'mtc_mtcc_clearance', '12_mtc_mtcc_clearance.png', 'image/png', 5295, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:35'),
(169, 12, 'nbi_clearance', '12_nbi_clearance.png', 'image/png', 7406, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:40'),
(170, 12, 'drug_test_result', '12_drug_test_result.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:26:51'),
(172, 27, 'birth_certificate', '27_birth_certificate.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:40:40'),
(173, 27, 'valid_id', '27_valid_id.png', 'image/png', 24270, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:40:46'),
(174, 27, 'talambuhay', '27_talambuhay.png', 'image/png', 24219, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:40:51'),
(175, 27, 'barangay_clearance', '27_barangay_clearance.png', 'image/png', 23547, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:40:56'),
(176, 27, 'case_info', '27_case_info.png', 'image/png', 26293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:41:01'),
(177, 27, 'case_judgement', '27_case_judgement.png', 'image/png', 24293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:41:06'),
(178, 27, 'petition_for_probation', '27_petition_for_probation.png', 'image/png', 24448, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:41:15'),
(179, 27, 'order_to_conduct_ps1', '27_order_to_conduct_ps1.png', 'image/png', 9241, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:41:20'),
(180, 27, 'case_dissmissed', '27_case_dissmissed.png', 'image/png', 9241, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:42:18'),
(181, 27, 'police_clearance', '27_police_clearance.png', 'image/png', 5295, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:42:23'),
(182, 27, 'mtc_mtcc_clearance', '27_mtc_mtcc_clearance.png', 'image/png', 7406, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:42:29'),
(183, 27, 'nbi_clearance', '27_nbi_clearance.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:42:35'),
(184, 27, 'drug_test_result', '27_drug_test_result.png', 'image/png', 24270, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:42:39'),
(185, 33, 'birth_certificate', '33_birth_certificate.jpg', 'image/jpeg', 19515, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:00'),
(186, 33, 'valid_id', '33_valid_id.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:05'),
(187, 33, 'talambuhay', '33_talambuhay.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:09'),
(188, 33, 'barangay_clearance', '33_barangay_clearance.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:19'),
(189, 33, 'case_info', '33_case_info.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:26'),
(190, 33, 'case_judgement', '33_case_judgement.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:34'),
(191, 33, 'petition_for_probation', '33_petition_for_probation.jpg', 'image/jpeg', 72649, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:41'),
(192, 33, 'order_to_conduct_ps1', '33_order_to_conduct_ps1.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:48'),
(193, 33, 'case_dissmissed', '33_case_dissmissed.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:45:55'),
(194, 33, 'police_clearance', '33_police_clearance.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:46:05'),
(195, 33, 'mtc_mtcc_clearance', '33_mtc_mtcc_clearance.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:46:19'),
(196, 33, 'nbi_clearance', '33_nbi_clearance.jpg', 'image/jpeg', 243375, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:46:25'),
(197, 33, 'drug_test_result', '33_drug_test_result.jpg', 'image/jpeg', 19515, 'valid', 'fortestemail92@gmail.com', '2024-01-14 14:46:30'),
(198, 34, 'birth_certificate', '34_birth_certificate.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:13'),
(199, 34, 'valid_id', '34_valid_id.png', 'image/png', 24270, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:24'),
(200, 34, 'talambuhay', '34_talambuhay.png', 'image/png', 24219, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:32'),
(201, 34, 'barangay_clearance', '34_barangay_clearance.png', 'image/png', 23547, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:37'),
(202, 34, 'case_info', '34_case_info.png', 'image/png', 26293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:44'),
(203, 34, 'case_judgement', '34_case_judgement.png', 'image/png', 24293, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:48'),
(204, 34, 'petition_for_probation', '34_petition_for_probation.png', 'image/png', 24448, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:53'),
(205, 34, 'order_to_conduct_ps1', '34_order_to_conduct_ps1.png', 'image/png', 9241, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:42:58'),
(206, 34, 'case_dissmissed', '34_case_dissmissed.png', 'image/png', 5295, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:43:03'),
(207, 34, 'police_clearance', '34_police_clearance.png', 'image/png', 7406, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:43:09'),
(208, 34, 'mtc_mtcc_clearance', '34_mtc_mtcc_clearance.png', 'image/png', 24910, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:43:14'),
(209, 34, 'nbi_clearance', '34_nbi_clearance.png', 'image/png', 24270, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:43:19'),
(210, 34, 'drug_test_result', '34_drug_test_result.png', 'image/png', 24219, 'valid', 'fortestemail92@gmail.com', '2024-01-14 19:43:23'),
(212, 10, 'birth_certificate', '10_birth_certificate.jpg', 'image/jpeg', 19515, 'valid', 'fortestemail92@gmail.com', '2024-01-16 07:11:54'),
(213, 10, 'valid_id', '10_valid_id.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-16 07:16:43'),
(214, 10, 'talambuhay', '10_talambuhay.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-16 07:18:21'),
(215, 10, 'barangay_clearance', '10_barangay_clearance.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-17 02:46:54'),
(216, 6, 'police_clearance', '6_police_clearance.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-17 03:06:31'),
(217, 6, 'drug_test_result', '6_drug_test_result.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-17 03:34:53'),
(219, 6, 'nbi_clearance', '6_nbi_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-17 03:41:54'),
(221, 10, 'case_info', '10_case_info.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-17 04:23:16'),
(222, 10, 'case_judgement', '10_case_judgement.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-17 04:27:53'),
(223, 10, 'petition_for_probation', '10_petition_for_probation.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-17 04:56:52'),
(224, 10, 'order_to_conduct_ps1', '10_order_to_conduct_ps1.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-17 05:09:32'),
(225, 10, 'case_dissmissed', '10_case_dissmissed.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-17 05:11:18'),
(227, 10, 'mtc_mtcc_clearance', '10_mtc_mtcc_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-17 06:08:39'),
(230, 10, 'police_clearance', '10_police_clearance.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-17 07:18:59'),
(231, 10, 'nbi_clearance', '10_nbi_clearance.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-17 07:29:55'),
(232, 9, 'birth_certificate', '9_birth_certificate.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-17 07:35:03'),
(235, 9, 'barangay_clearance', '9_barangay_clearance.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-17 07:43:31'),
(237, 9, 'valid_id', '9_valid_id.jpg', 'image/jpeg', 19515, 'valid', 'fortestemail92@gmail.com', '2024-01-18 06:22:44'),
(238, 9, 'talambuhay', '9_talambuhay.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-18 06:22:49'),
(239, 9, 'case_info', '9_case_info.jpg', 'image/jpeg', 204457, 'pending', 'fortestemail92@gmail.com', '2024-01-18 06:22:54'),
(240, 9, 'case_judgement', '9_case_judgement.jpg', 'image/jpeg', 71622, 'pending', 'fortestemail92@gmail.com', '2024-01-18 06:23:00'),
(241, 9, 'petition_for_probation', '9_petition_for_probation.jpg', 'image/jpeg', 92646, 'pending', 'fortestemail92@gmail.com', '2024-01-18 06:23:05'),
(242, 43, 'birth_certificate', '43_birth_certificate.jpg', 'image/jpeg', 19515, 'pending', 'fortestemail92@gmail.com', '2024-01-18 11:34:13'),
(243, 10, 'drug_test_result', '10_drug_test_result.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-19 06:29:36'),
(244, 47, 'birth_certificate', '47_birth_certificate.jpg', 'image/jpeg', 19515, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:21:27'),
(245, 47, 'valid_id', '47_valid_id.jpg', 'image/jpeg', 34952, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:21:41'),
(246, 47, 'talambuhay', '47_talambuhay.jpg', 'image/jpeg', 204457, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:21:46'),
(247, 47, 'barangay_clearance', '47_barangay_clearance.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:21:53'),
(248, 47, 'case_info', '47_case_info.jpg', 'image/jpeg', 71622, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:09'),
(249, 47, 'case_judgement', '47_case_judgement.jpg', 'image/jpeg', 92646, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:16'),
(250, 47, 'petition_for_probation', '47_petition_for_probation.jpg', 'image/jpeg', 102510, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:23'),
(251, 47, 'order_to_conduct_ps1', '47_order_to_conduct_ps1.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:36'),
(252, 47, 'case_dissmissed', '47_case_dissmissed.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:47'),
(253, 47, 'police_clearance', '47_police_clearance.jpg', 'image/jpeg', 14648, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:22:58'),
(254, 47, 'mtc_mtcc_clearance', '47_mtc_mtcc_clearance.png', 'image/png', 100248, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:23:04'),
(255, 47, 'nbi_clearance', '47_nbi_clearance.png', 'image/png', 19711, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:23:11'),
(256, 47, 'drug_test_result', '47_drug_test_result.png', 'image/png', 60862, 'valid', 'fortestemail92@gmail.com', '2024-01-19 07:23:16'),
(257, 13, 'birth_certificate', '13_birth_certificate.jpg', 'image/jpeg', 19515, 'pending', 'fortestemail92@gmail.com', '2024-01-20 11:05:35'),
(258, 51, 'birth_certificate', '51_birth_certificate.jpg', 'image/jpeg', 12047, 'valid', 'edranatest07@gmail.com', '2024-01-30 23:08:17'),
(259, 51, 'valid_id', '51_valid_id.jpg', 'image/jpeg', 7946, 'pending', 'edranatest07@gmail.com', '2024-01-30 23:11:35'),
(260, 51, 'talambuhay', '51_talambuhay.jpg', 'image/jpeg', 107457, 'pending', 'edranatest07@gmail.com', '2024-01-30 23:12:46'),
(261, 51, 'barangay_clearance', '51_barangay_clearance.jpg', 'image/jpeg', 20131, 'pending', 'edranatest07@gmail.com', '2024-01-30 23:14:49'),
(262, 9, 'order_to_conduct_ps1', '9_order_to_conduct_ps1.png', 'image/png', 9241, 'pending', 'fortestemail92@gmail.com', '2024-02-06 12:41:16'),
(263, 51, 'case_info', '51_case_info.png', 'image/png', 6174037, 'pending', 'edranatest07@gmail.com', '2024-02-06 13:18:35'),
(266, 51, 'case_judgement', '51_case_judgement.jpg', 'image/jpeg', 20131, 'pending', 'edranatest07@gmail.com', '2024-03-18 01:40:34'),
(267, 51, 'petition_for_probation', '51_petition_for_probation.jpg', 'image/jpeg', 107457, 'valid', 'edranatest07@gmail.com', '2024-03-18 01:53:33'),
(268, 53, 'birth_certificate', '53_birth_certificate.jpg', 'image/jpeg', 12047, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:55:52'),
(269, 53, 'valid_id', '53_valid_id.jpg', 'image/jpeg', 7946, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:56:38'),
(270, 53, 'talambuhay', '53_talambuhay.jpg', 'image/jpeg', 107457, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:56:48'),
(271, 53, 'barangay_clearance', '53_barangay_clearance.jpg', 'image/jpeg', 20131, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:56:55'),
(272, 53, 'case_info', '53_case_info.jpg', 'image/jpeg', 29483, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:57:01'),
(273, 53, 'case_judgement', '53_case_judgement.jpg', 'image/jpeg', 19515, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:58:45'),
(274, 53, 'petition_for_probation', '53_petition_for_probation.jpg', 'image/jpeg', 34952, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:58:59'),
(275, 53, 'order_to_conduct_ps1', '53_order_to_conduct_ps1.jpg', 'image/jpeg', 204457, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:59:08'),
(276, 53, 'case_dissmissed', '53_case_dissmissed.jpg', 'image/jpeg', 71622, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:59:18'),
(277, 53, 'police_clearance', '53_police_clearance.jpg', 'image/jpeg', 71622, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 02:59:27'),
(278, 53, 'mtc_mtcc_clearance', '53_mtc_mtcc_clearance.jpg', 'image/jpeg', 92646, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 03:07:55'),
(279, 53, 'nbi_clearance', '53_nbi_clearance.jpg', 'image/jpeg', 72649, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 03:08:14'),
(280, 53, 'drug_test_result', '53_drug_test_result.jpg', 'image/jpeg', 102510, 'valid', 'seduxer.edgar@gmail.com', '2024-03-18 03:08:57');

-- --------------------------------------------------------

--
-- Table structure for table `completed_client`
--

CREATE TABLE `completed_client` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_completed` datetime NOT NULL,
  `completed_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_client`
--

INSERT INTO `completed_client` (`id`, `client_id`, `date_completed`, `completed_by`) VALUES
(3, 1, '2024-01-14 02:24:45', 'navajajhonmanuel@gmail.com'),
(4, 7, '2024-01-14 12:30:20', 'navajajhonmanuel@gmail.com'),
(5, 5, '2024-01-19 06:54:42', 'navajajhonmanuel@gmail.com'),
(9, 53, '2024-03-18 05:14:47', 'navajajhonmanuel@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `denied_clients`
--

CREATE TABLE `denied_clients` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date_denied` datetime NOT NULL,
  `denied_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `denied_clients`
--

INSERT INTO `denied_clients` (`id`, `client_id`, `reason`, `date_denied`, `denied_by`) VALUES
(14, 2, 'Not good for probation program.', '2023-12-23 17:34:32', 'navajajhonmanuel@gmail.com'),
(17, 22, 'Risk to the community', '2024-01-13 18:11:15', 'navajajhonmanuel@gmail.com'),
(18, 16, 'Probation Officer found out that the client already have a record for probation in other province..', '2024-01-14 13:28:40', 'navajajhonmanuel@gmail.com'),
(19, 21, 'Better to serve in the jail/prison.', '2024-01-14 13:32:51', 'navajajhonmanuel@gmail.com'),
(20, 32, 'Not good for the probation program.', '2024-01-14 13:58:16', 'navajajhonmanuel@gmail.com'),
(21, 43, 'Not good for probation program.', '2024-01-18 11:35:38', 'navajajhonmanuel@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `email_messages`
--

CREATE TABLE `email_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date_received` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_messages`
--

INSERT INTO `email_messages` (`id`, `name`, `email`, `subject`, `message`, `date_received`) VALUES
(1, 'Edward', 'edward@example.com', 'Test', 'Testing', '2024-03-17 15:24:46'),
(2, 'Ed Caluag', 'ed_cal@example.com', 'Misteryo', 'Testing Misteryo sa dos.', '2024-03-17 16:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `grant_clients`
--

CREATE TABLE `grant_clients` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_granted` datetime NOT NULL,
  `granted_by` varchar(255) NOT NULL,
  `probation_duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grant_clients`
--

INSERT INTO `grant_clients` (`id`, `client_id`, `date_granted`, `granted_by`, `probation_duration`) VALUES
(2, 1, '2024-01-09 01:05:13', 'navajajhonmanuel@gmail.com', 6),
(6, 7, '2024-01-14 01:56:43', 'navajajhonmanuel@gmail.com', 24),
(7, 5, '2024-01-14 12:57:52', 'navajajhonmanuel@gmail.com', 6),
(8, 12, '2024-01-14 14:32:17', 'navajajhonmanuel@gmail.com', 6),
(9, 27, '2024-01-14 14:43:31', 'navajajhonmanuel@gmail.com', 24),
(10, 33, '2024-01-14 14:48:10', 'navajajhonmanuel@gmail.com', 36),
(11, 34, '2024-01-14 19:44:46', 'navajajhonmanuel@gmail.com', NULL),
(12, 8, '2024-01-16 06:49:39', 'navajajhonmanuel@gmail.com', 6),
(13, 10, '2024-01-19 06:37:10', 'navajajhonmanuel@gmail.com', 12),
(14, 47, '2024-01-19 07:25:02', 'navajajhonmanuel@gmail.com', NULL),
(15, 3, '2024-01-26 11:33:00', 'navajajhonmanuel@gmail.com', 12),
(22, 53, '2024-03-18 05:05:28', 'navajajhonmanuel@gmail.com', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `client_id`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
(51, 10, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'A new file has been uploaded', 1, '2024-01-16 23:18:59'),
(52, 10, 'fortestemail92@gmail.com', 'Valid File', 'police_clearance is valid!', 1, '2024-01-16 23:22:54'),
(53, 10, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'A new file has been uploaded', 1, '2024-01-16 23:29:55'),
(54, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'A new file has been uploaded', 1, '2024-01-16 23:35:03'),
(55, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', '9 has been uploaded', 1, '2024-01-16 23:39:37'),
(56, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'fortestemail92@gmail.com has been uploaded', 1, '2024-01-16 23:41:45'),
(57, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 has been uploaded', 1, '2024-01-16 23:43:31'),
(58, 9, 'fortestemail92@gmail.com', 'Valid File', 'birth_certificate is valid!', 1, '2024-01-16 23:43:48'),
(59, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-16 23:47:13'),
(60, 9, 'fortestemail92@gmail.com', 'Invalid File', 'Your file is invalid.', 1, '2024-01-17 22:14:09'),
(61, 9, 'fortestemail92@gmail.com', 'Invalid File', 'Your file is invalid.', 1, '2024-01-17 22:17:22'),
(62, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-17 22:22:44'),
(63, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-17 22:22:49'),
(64, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-17 22:22:54'),
(65, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-17 22:23:00'),
(66, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 9 uploaded a file', 1, '2024-01-17 22:23:05'),
(67, 9, 'fortestemail92@gmail.com', 'Valid File', 'barangay_clearance is valid!', 1, '2024-01-17 22:23:39'),
(68, 9, 'fortestemail92@gmail.com', 'Invalid File', 'Your file is invalid.', 1, '2024-01-17 22:23:55'),
(69, 43, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 43 uploaded a file', 1, '2024-01-18 03:34:13'),
(70, 43, 'fortestemail92@gmail.com', 'Application Denied', 'Sorry, Application denied', 1, '2024-01-18 03:35:42'),
(71, 10, 'fortestemail92@gmail.com', 'Valid File', 'nbi_clearance is valid!', 1, '2024-01-18 22:29:12'),
(72, 10, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 10 uploaded a file', 1, '2024-01-18 22:29:36'),
(73, 10, 'fortestemail92@gmail.com', 'Valid File', 'drug_test_result is valid!', 1, '2024-01-18 22:29:56'),
(74, 10, 'fortestemail92@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-01-18 22:37:10'),
(75, 5, 'fortestemail92@gmail.com', 'Completed', 'Congrats! You completed...', 1, '2024-01-18 22:54:42'),
(76, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:21:27'),
(77, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:21:41'),
(78, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:21:46'),
(79, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:21:53'),
(80, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:09'),
(81, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:16'),
(82, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:23'),
(83, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:36'),
(84, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:47'),
(85, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:22:58'),
(86, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:23:04'),
(87, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:23:11'),
(88, 47, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 47 uploaded a file', 1, '2024-01-18 23:23:16'),
(89, 47, 'fortestemail92@gmail.com', 'Valid File', 'birth_certificate is valid!', 1, '2024-01-18 23:23:30'),
(90, 47, 'fortestemail92@gmail.com', 'Valid File', 'valid_id is valid!', 1, '2024-01-18 23:23:35'),
(91, 47, 'fortestemail92@gmail.com', 'Valid File', 'talambuhay is valid!', 1, '2024-01-18 23:23:38'),
(92, 47, 'fortestemail92@gmail.com', 'Valid File', 'case_judgement is valid!', 1, '2024-01-18 23:23:43'),
(93, 47, 'fortestemail92@gmail.com', 'Valid File', 'barangay_clearance is valid!', 1, '2024-01-18 23:23:59'),
(94, 47, 'fortestemail92@gmail.com', 'Valid File', 'case_info is valid!', 1, '2024-01-18 23:24:02'),
(95, 47, 'fortestemail92@gmail.com', 'Valid File', 'petition_for_probation is valid!', 1, '2024-01-18 23:24:06'),
(96, 47, 'fortestemail92@gmail.com', 'Valid File', 'order_to_conduct_ps1 is valid!', 1, '2024-01-18 23:24:10'),
(97, 47, 'fortestemail92@gmail.com', 'Valid File', 'case_dissmissed is valid!', 1, '2024-01-18 23:24:14'),
(98, 47, 'fortestemail92@gmail.com', 'Valid File', 'police_clearance is valid!', 1, '2024-01-18 23:24:19'),
(99, 47, 'fortestemail92@gmail.com', 'Valid File', 'mtc_mtcc_clearance is valid!', 1, '2024-01-18 23:24:23'),
(100, 47, 'fortestemail92@gmail.com', 'Valid File', 'nbi_clearance is valid!', 1, '2024-01-18 23:24:29'),
(101, 47, 'fortestemail92@gmail.com', 'Valid File', 'drug_test_result is valid!', 1, '2024-01-18 23:24:32'),
(102, 47, 'fortestemail92@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-01-18 23:25:02'),
(103, 47, 'fortestemail92@gmail.com', 'Revoked', 'Sorry, but your probation...', 1, '2024-01-18 23:27:37'),
(104, 27, 'fortestemail92@gmail.com', 'Appointment', 'You have Scheduled Appointent.', 1, '2024-01-20 00:39:41'),
(105, 13, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 13 uploaded a file', 1, '2024-01-20 03:05:35'),
(106, 3, 'fortestemail92@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-01-26 03:33:00'),
(107, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'Client 51 uploaded a file', 1, '2024-01-30 15:08:17'),
(108, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com uploaded a file', 1, '2024-01-30 15:11:35'),
(109, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com uploaded \n a file', 1, '2024-01-30 15:12:46'),
(110, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com', 1, '2024-01-30 15:14:49'),
(111, 51, 'edranatest07@gmail.com', 'Valid File', 'birth_certificate is valid!', 1, '2024-01-30 15:15:21'),
(112, 9, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'fortestemail92@gmail.com', 1, '2024-02-06 04:41:16'),
(113, 9, 'fortestemail92@gmail.com', 'Valid File', 'valid_id is valid!', 1, '2024-02-06 04:43:26'),
(114, 9, 'fortestemail92@gmail.com', 'Valid File', 'talambuhay is valid!', 1, '2024-02-06 04:43:47'),
(115, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com', 1, '2024-02-06 05:18:35'),
(116, 17, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'fortestemail92@gmail.com', 1, '2024-02-06 12:37:00'),
(117, 17, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'fortestemail92@gmail.com', 1, '2024-02-06 12:42:27'),
(118, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com', 1, '2024-03-17 17:40:34'),
(119, 51, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'edranatest07@gmail.com', 1, '2024-03-17 17:53:33'),
(120, 51, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 17:53:33'),
(121, 51, 'edranatest07@gmail.com', 'Valid File', 'petition_for_probation is valid!', 1, '2024-03-17 17:54:41'),
(122, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:55:52'),
(123, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:55:52'),
(124, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:56:38'),
(125, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:56:38'),
(126, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:56:48'),
(127, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:56:48'),
(128, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:56:55'),
(129, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:56:55'),
(130, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:57:01'),
(131, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:57:01'),
(132, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:58:45'),
(133, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:58:45'),
(134, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:58:59'),
(135, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:58:59'),
(136, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:59:08'),
(137, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:59:08'),
(138, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:59:18'),
(139, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:59:18'),
(140, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 18:59:27'),
(141, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'navajajhonmanuel@gmail.com', 1, '2024-03-17 18:59:27'),
(142, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:07:55'),
(143, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:07:55'),
(144, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:08:14'),
(145, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:08:14'),
(146, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'birth_certificate is valid!', 1, '2024-03-17 19:08:34'),
(147, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'valid_id is valid!', 1, '2024-03-17 19:08:38'),
(148, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'talambuhay is valid!', 1, '2024-03-17 19:08:41'),
(149, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'barangay_clearance is valid!', 1, '2024-03-17 19:08:44'),
(150, 53, 'navajajhonmanuel@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:08:57'),
(151, 53, 'navarroaries995@gmail.com', 'New Uploaded File', 'seduxer.edgar@gmail.com', 1, '2024-03-17 19:08:57'),
(152, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'case_info is valid!', 1, '2024-03-17 19:09:28'),
(153, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'case_judgement is valid!', 1, '2024-03-17 19:09:42'),
(154, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'petition_for_probation is valid!', 1, '2024-03-17 19:09:52'),
(155, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'order_to_conduct_ps1 is valid!', 1, '2024-03-17 19:09:55'),
(156, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'case_dissmissed is valid!', 1, '2024-03-17 19:09:59'),
(157, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'police_clearance is valid!', 1, '2024-03-17 19:10:03'),
(158, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'mtc_mtcc_clearance is valid!', 1, '2024-03-17 19:10:06'),
(159, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'nbi_clearance is valid!', 1, '2024-03-17 19:10:10'),
(160, 53, 'seduxer.edgar@gmail.com', 'Valid File', 'drug_test_result is valid!', 1, '2024-03-17 19:10:14'),
(164, 53, 'navarroaries995@gmail.com', 'Confirmation', 'Submitted All Files', 1, '2024-03-17 19:33:46'),
(165, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 19:41:43'),
(166, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 19:50:10'),
(167, 53, 'seduxer.edgar@gmail.com', 'Completed', 'Congrats! You completed...', 1, '2024-03-17 20:00:49'),
(168, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 20:04:56'),
(169, 53, 'seduxer.edgar@gmail.com', 'Completed', 'Congrats! You completed...', 1, '2024-03-17 20:06:26'),
(170, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 20:21:00'),
(171, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 20:43:59'),
(172, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 20:50:31'),
(173, 53, 'seduxer.edgar@gmail.com', 'Granted', 'Congrats! Application is...', 1, '2024-03-17 21:05:28'),
(174, 53, 'seduxer.edgar@gmail.com', 'Completed', 'Congrats! You completed...', 1, '2024-03-17 21:12:01'),
(175, 53, 'seduxer.edgar@gmail.com', 'Completed', 'Congrats! You completed...', 1, '2024-03-17 21:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `revoked_clients`
--

CREATE TABLE `revoked_clients` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date_revoked` datetime NOT NULL,
  `revoked_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revoked_clients`
--

INSERT INTO `revoked_clients` (`id`, `client_id`, `reason`, `date_revoked`, `revoked_by`) VALUES
(3, 34, 'Violation of the rules in the contract.', '2024-01-14 19:48:41', 'navajajhonmanuel@gmail.com'),
(5, 8, 'Failed to attend a monthly reporting to office for two consecutive months.', '2024-01-16 06:55:39', 'navajajhonmanuel@gmail.com'),
(6, 47, 'better to spend in the jail/prison for safer community.', '2024-01-19 07:27:32', 'navajajhonmanuel@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_list`
--

CREATE TABLE `schedule_list` (
  `id` int(11) NOT NULL,
  `case_number` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `description` longtext NOT NULL,
  `start_datetime` longtext NOT NULL,
  `end_datetime` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule_list`
--

INSERT INTO `schedule_list` (`id`, `case_number`, `title`, `description`, `start_datetime`, `end_datetime`) VALUES
(29, 63300, 'Reporting', 'Monthly Reporting', '2024-01-18T09:00', '2024-01-18T10:00'),
(32, 69650, 'report', 'monthly reporting', '2024-01-29T08:00', '2024-01-29T09:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `user_level` tinyint(2) NOT NULL DEFAULT 0,
  `role` varchar(255) DEFAULT NULL,
  `active` char(32) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `registration_date` datetime NOT NULL,
  `client` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `middle_name`, `last_name`, `suffix`, `email`, `mobile_number`, `pass`, `user_level`, `role`, `active`, `verified`, `registration_date`, `client`) VALUES
(2, 'John Manuel', 'M', 'Navaja', '', 'navajajhonmanuel@gmail.com', '09283333357', '$2y$10$Asy74VaW9FRllohTcMZ8dOKNP2GZxZP70BTDayPUgoj6H43qHiv/e', 1, 'admin clerk', NULL, 1, '2023-12-02 10:12:32', 0),
(8, 'Edgar', 'Sison', 'Rana', 'Jr.', 'fortestemail92@gmail.com', '09283333357', '$2y$10$qKYzEqHBv3sX463aRjZifeIkwRfyQBO2.7fKABB37OdqfZaKW/Isi', 0, NULL, NULL, 1, '2023-12-05 23:31:09', 0),
(11, 'Ed', 'S', 'Rana', 'Jr.', 'edranatest07@gmail.com', '09287591634', '$2y$10$uM7SaYdUIc.vNWEeVKMN9OQalYnSp1qG9bggR2lsKQ6mUU.exEDEe', 0, NULL, NULL, 1, '2024-01-13 10:41:31', 51),
(12, 'Alfred', '', 'Pennyworth', 'Sr.', 'alfred@example.com', '09272715985', '$2y$10$LR5W7VscD0DDsClT0JCqee9stX7itVy3/kv3wjMNkOAICJ15fvSVK', 0, NULL, '9e32bd00fb333e1518503f4b6f86bd71', 0, '2024-01-13 22:49:29', 0),
(13, 'Fredrin', '', 'Dela Cruz', '', 'fredrindelacruz@gmail.com', '09512178262', '$2y$10$OAwCBU6LYHHoisQuCaihuujW3bqIrccN/91mfX25hSDLTajOhtq1m', 1, 'admin', NULL, 1, '2024-01-15 01:38:25', 0),
(14, 'Gerald', 'R', 'De Mesa', '', 'geralddemesa969@gmail.com', '09462206686', '$2y$10$BnfJtJJVt5YoVoz9DCFtUeIcVdJvVfWYHhPvoDdHJYL9QeO1lu1qu', 1, 'admin', NULL, 1, '2024-01-15 01:46:49', 0),
(15, 'Aries', '', 'Navarro', '', 'navarroaries995@gmail.com', '09287591634', '$2y$10$AFngB1Nw4Dn.nJW1/S7LLOl044uweKQc9kOt00EqoxHXFsjAWfxn.', 1, 'superadmin', NULL, 1, '2024-01-15 01:51:35', 0),
(17, 'Edgar', '', 'Rana', 'Jr.', 'seduxer.edgar@gmail.com', '09287591634', '$2y$10$LtxCM8flNVeYwFCRMnX5rO7SpyJCCut5dE4hIljzGMgCu3CWdxH2e', 0, NULL, NULL, 1, '2024-03-18 02:54:14', 53);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_requirements`
--
ALTER TABLE `client_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completed_client`
--
ALTER TABLE `completed_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `denied_clients`
--
ALTER TABLE `denied_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_messages`
--
ALTER TABLE `email_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grant_clients`
--
ALTER TABLE `grant_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revoked_clients`
--
ALTER TABLE `revoked_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_list`
--
ALTER TABLE `schedule_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `client_requirements`
--
ALTER TABLE `client_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `completed_client`
--
ALTER TABLE `completed_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `denied_clients`
--
ALTER TABLE `denied_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `email_messages`
--
ALTER TABLE `email_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grant_clients`
--
ALTER TABLE `grant_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `revoked_clients`
--
ALTER TABLE `revoked_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedule_list`
--
ALTER TABLE `schedule_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
