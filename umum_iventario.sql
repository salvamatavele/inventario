-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2020 at 01:15 PM
-- Server version: 10.5.5-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umum_iventario`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(36, 'Assentos', '2020-10-07 18:56:06', '2020-10-07 18:56:06'),
(37, 'Mesas', '2020-10-14 20:07:37', '2020-10-15 04:47:20'),
(38, 'Eletronicos', '2020-10-14 20:25:51', '2020-10-14 20:25:51'),
(39, 'Viatura', '2020-10-15 08:04:52', '2020-10-15 08:04:52'),
(40, 'test', '2020-11-17 06:34:57', '2020-11-17 06:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `colories`
--

CREATE TABLE `colories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colories`
--

INSERT INTO `colories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Verde', '2020-09-15 18:22:18', '2020-09-16 02:16:15'),
(2, 'Azul', '2020-09-15 18:24:20', '2020-09-15 18:24:20'),
(3, 'Branca', '2020-09-15 18:24:29', '2020-09-15 18:24:29'),
(4, 'Preta', '2020-09-15 18:24:45', '2020-09-15 18:24:45'),
(6, 'Cinzeta', '2020-09-17 06:38:24', '2020-10-09 13:42:58'),
(7, 'Laranja', '2020-10-09 13:42:36', '2020-10-09 13:42:36'),
(8, 'castanha', '2020-10-15 07:54:22', '2020-10-29 08:22:25'),
(9, 'Amarela', '2020-10-26 11:42:25', '2020-10-26 11:42:25'),
(10, 'test', '2020-11-17 06:35:40', '2020-11-17 06:35:40');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(13, 'Gabinete de Apoio EIT', '2020-10-07 18:56:26', '2020-10-09 05:27:03'),
(14, 'Secretaria', '2020-10-09 05:27:34', '2020-10-09 05:27:34'),
(15, 'reitoria', '2020-11-17 06:35:22', '2020-11-17 06:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`) VALUES
(17, '', ''),
(22, 'smatavele1@gmail.com', 'd5f45c0b52386cf72f8657860c3d340a992bc4bd80a73b4816fa7f030985f36d9513118a42e885eda5410cec6530584288e649bb47f88acfaf4033a8eb879b68'),
(23, 'smatavele1@gmail.com', 'e799538d78e5b0f3d5a81d6524e3e92c2160b9a6eb76cd3f3603783ab651ed359d2fc46696d1c465cda68c5bb9e18a91ea64248887f918ea404cb711295092c4'),
(24, 'smatavele1@gmail.com', '21763b618f38f479b37ab2e2251816f46ef302920eb21ba4e9b5b5590d6276daaf8659e44004fd56854f50be3095e46bdca8466f2a397db9bd3a698cef34cb1d'),
(25, 'smatavele1@gmail.com', '4b85f9edf8bce120f33d45ad9fbaac48115225eed058395f1eeb65359fcf3ebd2be86d33eb24f9b9c05127c6a95d81cdf0106c3f3eb6c202e17fa12ebef3c576'),
(26, 'smatavele1@gmail.com', 'da706f22bcf865a5f2ee39a49d87e877953491a2ed9425ea42652a90ec2954d661de6e065eef464d174e35a12226b99f87100a94546553cafca64a072adf99a0'),
(27, 'smatavele1@gmail.com', '7b9ace5d3d4a4556f1f14b776e84254769be494a701792f06daa67967cc0192c496383e782d11bad359e756460b3b111ecbf6776f28fae464f522e1f8a82b087'),
(28, 'smatavele1@gmail.com', 'b8e27d1255d9341b780872ac35eb1190532a6aabee73fd879d1cae4bf6eaf52ebf40e6c6723e5162275d9ed5c098e734b0c2f2b8126d9771bea6bc8b673fd8c5'),
(29, 'smatavele1@gmail.com', '17cf8d9bd315073ff5774d2e1486415a7ccd341ac33782d83c98b99370bfc95f324abf090ed99a4500b4ef640a0ad14384f7a2b940f099c54a5d685799c36623'),
(30, 'smatavele1@gmail.com', '102453eb693bb68eb719a6d9ee067fcb62f9d43de28a0fdfbf9d22ee9d4b560c640474b48178a9436ab1bf009692e2a4079626110ca234a995c016598e09f54e'),
(31, 'smatavele1@gmail.com', '8fde07865375e10d2de7cd76f5b062a9ec9a128f4f850f04366b336850812eb4b850a283908e065b3acda79a9f526faf4881d027494ed0153a10cdc1257eb811'),
(32, 'smatavele1@gmail.com', '8f6d337a3f494846b7cd812b93500e2464e6e91ca3871b48349dfcd61b941bd8d497cc437a57f1a29a43a810ccebf77443ae2def2bd3a8e0579c9486d6a30596');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('Bom','Mau','Razoavel','') NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `location_id`, `category_id`, `color_id`, `name`, `stock`, `status`, `image`, `description`, `created_at`, `updated_at`) VALUES
(20, 13, 36, 3, 'Cadeira', 4, 'Razoavel', 'Public/storage/images/2020/10/chair-1840011-1920.jpg', 'test register product', '2020-10-07 18:57:19', '2020-10-29 10:48:09'),
(21, 13, 38, 6, 'NoteBook ', 7, 'Bom', 'Public/storage/images/2020/10/ecommerce-3563183.jpg', 'I7 4 Geracao 8RAM 500GB SSD 14``', '2020-10-14 20:24:32', '2020-10-15 08:17:55'),
(24, 13, 38, 6, 'Pasta de arquivos', 6, 'Bom', 'Public/storage/images/2020/10/folder-4119674-1920.jpg', 'Pasta de Arquivos', '2020-10-15 08:50:20', '2020-10-18 16:33:47'),
(27, 14, 38, 3, 'Impressora ', 4, 'Bom', 'Public/storage/images/2020/10/printer-790396-1920-1603046040.jpg', 'impresspra tipo sei la', '2020-10-16 01:06:29', '2020-10-19 19:45:25'),
(30, 15, 40, 4, 'Pasta de arquivos', 3, 'Razoavel', 'Public/storage/images/2020/11/folder-4119674-1920-1605602275.jpg', 'teste 1 tghhxkjclc', '2020-11-17 06:37:55', '2020-11-17 06:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `permition` enum('superadmin','admin','normal','') DEFAULT NULL,
  `status` enum('activo','inactivo') NOT NULL DEFAULT 'inactivo',
  `password` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `permition`, `status`, `password`, `image`, `created_at`, `updated_at`) VALUES
(15, 'Salva Sudo Su', 'smatavele1@gmail.com', 'superadmin', 'inactivo', '$2y$10$rurmxjItFK99bsOh0wu7/OTU3p/Ss.IS9rafczc1l4qodKEU25MVm', 'Public/storage/images/2020/10/home-office-336378-1920.jpg', '2020-10-07 18:54:04', '2020-10-26 14:33:12'),
(16, 'Normal User', 'normal@gmail.com', 'normal', 'inactivo', '$2y$10$xKYEAz7Jt7KwaTYE1WoIkO8099vAr6J.8zoa89Ka/y1R3wH.eqhYu', 'Public/storage/images/2020/11/folder-4119674-1920.jpg', '2020-10-09 10:33:47', '2020-11-02 07:31:07'),
(19, 'Mauriocio', 'test@gmail.com', 'normal', 'inactivo', '$2y$10$Zv.Y3sMJoMjPuITZKR4Xn.TGbgFvzSvLYV0YgDJrdKLDPA7G90TnW', 'Public/avatar/Mauriocio1605602048.png', '2020-11-17 06:34:08', '2020-11-17 06:34:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colories`
--
ALTER TABLE `colories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_category_fky` (`category_id`),
  ADD KEY `product_location_fky` (`location_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `colories`
--
ALTER TABLE `colories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_category_fky` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_location_fky` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
