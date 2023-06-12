-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 12 Haz 2023, 16:31:16
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `its_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `category`
--

INSERT INTO `category` (`id`, `categoryName`) VALUES
(1, 'Camera'),
(2, 'Monitor');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `faculty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `items`
--

INSERT INTO `items` (`id`, `m_id`, `faculty`) VALUES
(1, 1, 'EEE'),
(2, 1, 'COMPE'),
(3, 3, 'CENG'),
(4, 2, 'EDUCATION');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `items_in_use`
--

CREATE TABLE `items_in_use` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `items_in_use`
--

INSERT INTO `items_in_use` (`id`, `r_id`) VALUES
(42, 3),
(44, 74),
(45, 76);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `imageNo` int(11) NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `model`
--

INSERT INTO `model` (`id`, `c_id`, `name`, `imageNo`, `details`) VALUES
(1, 1, 'Samsung c5', 1, '5k resolution, AutoFocus, AI'),
(2, 1, 'Acer a-1680', 2, '4k resolution, manuel focus'),
(3, 2, 'HP 25x', 3, '144hz, 1920x1080, 1ms, 450nit'),
(4, 2, 'MONSTER 10N', 4, '8k, 5000hz, 10 died pixel ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `requested_items`
--

CREATE TABLE `requested_items` (
  `id` int(11) NOT NULL,
  `u_id` int(9) NOT NULL,
  `i_id` int(11) NOT NULL,
  `startDate` datetime(6) NOT NULL,
  `releaseDate` datetime(6) NOT NULL,
  `requestDate` datetime(6) NOT NULL,
  `reason` text NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `requested_items`
--

INSERT INTO `requested_items` (`id`, `u_id`, `i_id`, `startDate`, `releaseDate`, `requestDate`, `reason`, `confirmed`) VALUES
(1, 99, 3, '2022-12-10 18:52:50.000000', '2022-12-15 18:52:50.000000', '2021-12-11 10:30:24.149257', 'It is required.', 1),
(3, 181501018, 3, '2022-12-17 18:52:50.000000', '2022-12-25 18:52:50.000000', '2021-12-25 10:30:24.149257', 'It is NOTrequired.', 0),
(74, 12345678, 1, '2022-01-18 00:00:00.000000', '2022-01-18 00:00:00.000000', '2022-01-01 20:51:38.000000', '', 1),
(75, 12345678, 3, '2022-01-19 00:00:00.000000', '2022-01-19 00:00:00.000000', '2022-01-01 20:51:38.000000', '', 0),
(76, 3131, 3, '2022-12-01 00:00:00.000000', '2022-12-09 00:00:00.000000', '2022-01-02 19:17:35.000000', 'zaaz', 1),
(77, 3131, 4, '2022-01-04 00:00:00.000000', '2022-01-21 00:00:00.000000', '2022-01-02 19:17:35.000000', 'zaaz', 0),
(78, 181501016, 1, '2023-06-15 00:00:00.000000', '2023-06-22 00:00:00.000000', '2023-06-12 17:17:53.000000', 'Required for capture image', 1),
(79, 181501016, 2, '2023-06-12 00:00:00.000000', '2023-06-14 00:00:00.000000', '2023-06-12 17:29:04.000000', 'Required for capture image', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `requested_rooms`
--

CREATE TABLE `requested_rooms` (
  `id` int(11) NOT NULL,
  `u_id` int(9) NOT NULL,
  `room_id` int(11) NOT NULL,
  `startDate` datetime(6) NOT NULL,
  `releaseDate` datetime(6) NOT NULL,
  `requestDate` datetime(6) NOT NULL,
  `reason` text NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `requested_rooms`
--

INSERT INTO `requested_rooms` (`id`, `u_id`, `room_id`, `startDate`, `releaseDate`, `requestDate`, `reason`, `confirmed`) VALUES
(1, 181501018, 1, '2021-12-23 01:15:02.000000', '2022-01-29 01:15:02.000000', '2021-12-01 01:15:02.000000', 'I want to have this room forever, becouse I dont have anywhere to stay. ', NULL),
(5, 181501016, 2, '2023-06-14 00:00:00.000000', '2023-06-15 00:00:00.000000', '2023-06-12 17:29:40.000000', 'I should study for final exams', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `faculty`) VALUES
(1, 'Arbim', 'COMPE'),
(2, 'COMPUTER LAB', 'COMPE'),
(3, 'ELECTRIC LAB', 'EEE');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rooms_in_use`
--

CREATE TABLE `rooms_in_use` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `used_items`
--

CREATE TABLE `used_items` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `releaseDate` datetime NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `used_items`
--

INSERT INTO `used_items` (`id`, `r_id`, `releaseDate`, `status`) VALUES
(43, 1, '2022-01-02 19:18:52', 'aaaaa');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `used_rooms`
--

CREATE TABLE `used_rooms` (
  `id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL,
  `releaseDate` datetime NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user`
--

CREATE TABLE `user` (
  `student_id` int(9) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `faculty` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user`
--

INSERT INTO `user` (`student_id`, `password`, `name`, `surname`, `faculty`, `department`, `email`, `phone`, `confirmed`) VALUES
(99, 'asd', ' asd', 'asd', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'zaa@zaa', '555-555-5544', 0),
(3131, 'asd', 'zaa', 'aaz', 'FACULTY OF ENGINEERING', 'Civil Engineering', 'a@a', '555-555-9999', 1),
(12345678, 'asd', 'Tuğcan  ', 'Canki', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'asd@asd', '333333', 1),
(111222333, '123123', 'New', 'Student', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'new@new.com', '555-555-5555', NULL),
(123456789, 'asd', 'Tuğcan  ', 'Canki', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'asd@asde', '3333333', 1),
(181501016, '123', 'Arda', 'Kozan', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'arda@gmail.com', '530-123-4563', 1),
(181501018, 'asd', 'Ahmet', 'Ünal', 'FACULTY OF ENGINEERING', 'Computer Engineering', 'afsdg@dgdfg', '5368535522', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Tablo için indeksler `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `model` (`m_id`);

--
-- Tablo için indeksler `items_in_use`
--
ALTER TABLE `items_in_use`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_id` (`r_id`);

--
-- Tablo için indeksler `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imageNo` (`imageNo`),
  ADD KEY `category` (`c_id`);

--
-- Tablo için indeksler `requested_items`
--
ALTER TABLE `requested_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requested_items-user` (`u_id`),
  ADD KEY `requested_items-items` (`i_id`);

--
-- Tablo için indeksler `requested_rooms`
--
ALTER TABLE `requested_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Tablo için indeksler `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rooms_in_use`
--
ALTER TABLE `rooms_in_use`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_in_use_ibfk_1` (`r_id`);

--
-- Tablo için indeksler `used_items`
--
ALTER TABLE `used_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requested_items` (`r_id`);

--
-- Tablo için indeksler `used_rooms`
--
ALTER TABLE `used_rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `r_id` (`r_id`);

--
-- Tablo için indeksler `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `items_in_use`
--
ALTER TABLE `items_in_use`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Tablo için AUTO_INCREMENT değeri `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `requested_items`
--
ALTER TABLE `requested_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Tablo için AUTO_INCREMENT değeri `requested_rooms`
--
ALTER TABLE `requested_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `rooms_in_use`
--
ALTER TABLE `rooms_in_use`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `used_items`
--
ALTER TABLE `used_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Tablo için AUTO_INCREMENT değeri `used_rooms`
--
ALTER TABLE `used_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `model` FOREIGN KEY (`m_id`) REFERENCES `model` (`id`);

--
-- Tablo kısıtlamaları `items_in_use`
--
ALTER TABLE `items_in_use`
  ADD CONSTRAINT `items_in_use_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `requested_items` (`id`);

--
-- Tablo kısıtlamaları `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `category` FOREIGN KEY (`c_id`) REFERENCES `category` (`id`);

--
-- Tablo kısıtlamaları `requested_items`
--
ALTER TABLE `requested_items`
  ADD CONSTRAINT `requested_items-items` FOREIGN KEY (`i_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `requested_items-user` FOREIGN KEY (`u_id`) REFERENCES `user` (`student_id`);

--
-- Tablo kısıtlamaları `requested_rooms`
--
ALTER TABLE `requested_rooms`
  ADD CONSTRAINT `requested_rooms_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `requested_rooms_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `user` (`student_id`);

--
-- Tablo kısıtlamaları `rooms_in_use`
--
ALTER TABLE `rooms_in_use`
  ADD CONSTRAINT `rooms_in_use_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `requested_rooms` (`id`);

--
-- Tablo kısıtlamaları `used_items`
--
ALTER TABLE `used_items`
  ADD CONSTRAINT `requested_items` FOREIGN KEY (`r_id`) REFERENCES `requested_items` (`id`);

--
-- Tablo kısıtlamaları `used_rooms`
--
ALTER TABLE `used_rooms`
  ADD CONSTRAINT `used_rooms_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `requested_rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
