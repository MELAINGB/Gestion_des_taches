-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 01:38 PM
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
-- Database: `mes_taches`
--

-- --------------------------------------------------------

--
-- Table structure for table `taches`
--

CREATE TABLE `taches` (
  `id_tache` int(10) NOT NULL,
  `titre` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `statut` tinyint(1) NOT NULL,
  `adddate` date NOT NULL DEFAULT current_timestamp(),
  `deadline` datetime DEFAULT NULL,
  `id_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taches`
--

INSERT INTO `taches` (`id_tache`, `titre`, `description`, `statut`, `adddate`, `deadline`, `id_user`) VALUES
(184, 'Changer de mot de passe', 'Option update mdp', 0, '2025-02-16', '2025-02-17 23:59:00', 15),
(185, 'TP Linux', '', 0, '2025-02-16', '2025-02-23 22:00:00', 15),
(186, 'Wordpress', '', 0, '2025-02-16', '2025-02-19 23:59:00', 15),
(187, 'Hébergement de site dynamique', '', 0, '2025-02-16', '2025-02-23 20:00:00', 15),
(188, 'Responsive le site web', '', 0, '2025-02-16', '2025-02-20 22:00:00', 15),
(189, 'Plus de 50% en formation JS', '', 0, '2025-02-16', '2025-02-28 22:34:00', 15),
(190, 'Dev Application', 'Information de développement de APK', 0, '2025-02-16', '2025-02-17 23:00:00', 15),
(191, 'Recherche de stage', 'Tout site', 1, '2025-02-16', '2025-02-16 23:59:00', 15),
(192, 'Veille technologique ', 'Portfolio', 0, '2025-02-16', '2025-02-21 23:00:00', 15),
(193, 'Installation libre office', '', 1, '2025-02-16', '2025-02-17 23:59:00', 15),
(194, 'Appelez des entreprises (stage)', '', 0, '2025-02-17', '2025-02-17 17:00:00', 15);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_user` int(10) NOT NULL,
  `mat_user` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `password` varchar(500) NOT NULL,
  `datins` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `mat_user`, `email`, `pseudo`, `password`, `datins`) VALUES
(15, '', 'melaingb@gmail.com', 'Melain001', '$2y$10$xzt/D5DBB.PYS1qtx6WVHOv7BiN3yxk2X0/Eu3mpFMPHbuqwYQQ9S', '2025-02-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id_tache`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taches`
--
ALTER TABLE `taches`
  MODIFY `id_tache` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
