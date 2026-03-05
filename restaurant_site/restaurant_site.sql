-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Mar 03, 2026 alle 20:40
-- Versione del server: 5.7.24
-- Versione PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_site`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-03-03 20:26:40');

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `name`, `sort_order`, `created_at`) VALUES
(1, 'Pizze Rosse', 1, '2026-03-03 20:26:40'),
(2, 'Pizze Bianche', 2, '2026-03-03 20:26:40'),
(3, 'Pizze Speciali', 3, '2026-03-03 20:26:40'),
(4, 'Antipasti', 4, '2026-03-03 20:26:40'),
(5, 'Fritti', 5, '2026-03-03 20:26:40'),
(6, 'Dolci', 6, '2026-03-03 20:26:40'),
(7, 'Bevande', 7, '2026-03-03 20:26:40');

-- --------------------------------------------------------

--
-- Struttura della tabella `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `privacy_accepted` tinyint(1) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT '1',
  `sort_order` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `image`, `is_available`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Margherita', 'Pomodoro, mozzarella fior di latte, basilico', '7.50', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(2, 1, 'Marinara', 'Pomodoro, aglio, origano, olio EVO', '6.50', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(3, 1, 'Diavola', 'Pomodoro, mozzarella, salame piccante', '9.00', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(4, 1, 'Capricciosa', 'Pomodoro, mozzarella, prosciutto cotto, funghi, olive, carciofi', '10.50', NULL, 1, 4, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(5, 1, 'Quattro Stagioni', 'Pomodoro, mozzarella, prosciutto, funghi, olive, carciofi (sezioni separate)', '10.50', NULL, 1, 5, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(6, 1, 'Boscaiola', 'Pomodoro, mozzarella, salsiccia, funghi porcini', '11.00', NULL, 1, 6, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(7, 1, 'Napoletana', 'Pomodoro, mozzarella, acciughe, capperi, origano', '9.50', NULL, 1, 7, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(8, 1, 'Prosciutto e Funghi', 'Pomodoro, mozzarella, prosciutto cotto, funghi', '9.50', NULL, 1, 8, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(9, 1, 'Vegana', 'Pomodoro, verdure di stagione grigliate, olio EVO', '9.00', NULL, 1, 9, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(16, 2, 'Bianca', 'Mozzarella fior di latte, olio EVO, origano', '7.00', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(17, 2, 'Porchetta', 'Mozzarella, porchetta artigianale, rosmarino', '10.50', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(18, 2, 'Prosciutto Crudo', 'Mozzarella, prosciutto crudo DOP, rucola, grana padano', '11.00', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(19, 2, 'Zucchine e Speck', 'Mozzarella, zucchine trifolate, speck, scamorza', '10.50', NULL, 1, 4, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(20, 2, 'Patate e Rosmarino', 'Mozzarella, patate a fette, rosmarino, olio EVO', '9.00', NULL, 1, 5, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(23, 3, 'Dal Tano', 'La pizza della casa: ingredienti segreti del pizzaiolo, impasto 48h', '13.00', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(24, 3, 'Burrata e Speck', 'Pomodoro datterino, burrata fresca, speck croccante, basilico', '12.50', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(25, 3, 'Nduja e Stracciatella', 'Pomodoro, nduja calabrese, stracciatella di bufala, olive taggiasche', '12.00', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(26, 3, 'Maiale e Friarielli', 'Mozzarella, salsiccia di maiale, friarielli saltati, peperoncino', '12.50', NULL, 1, 4, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(30, 4, 'Tagliere Misto', 'Selezione di salumi e formaggi locali con focaccine', '12.00', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(31, 4, 'Bruschetta al Pomodoro', 'Pane di casa tostato, pomodoro fresco, basilico, olio EVO', '5.00', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(32, 4, 'Crocche di Patate', 'Crocchette artigianali di patate con prezzemolo', '5.00', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(33, 5, 'Frittura Mista', 'Anelli di cipolla, zucchine, mozzarelline in carrozza', '8.00', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(34, 5, 'Montanare', 'Pizzette fritte con pomodoro e parmigiano (6 pz)', '6.00', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(35, 5, 'Calzone Fritto', 'Ripieno di ricotta, salame, mozzarella', '8.00', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(36, 6, 'Tiramisù', 'Ricetta artigianale della casa', '5.00', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(37, 6, 'Nutella Pizza', 'Mini pizza dolce con Nutella e zucchero a velo', '5.00', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(38, 6, 'Panna Cotta', 'Con coulis di frutti di bosco', '4.50', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(39, 7, 'Acqua Naturale 0.5L', '', '1.50', NULL, 1, 1, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(40, 7, 'Acqua Frizzante 0.5L', '', '1.50', NULL, 1, 2, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(41, 7, 'Coca-Cola 0.33L', '', '2.50', NULL, 1, 3, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(42, 7, 'Birra alla Spina (pinta)', 'Birra artigianale locale', '4.00', NULL, 1, 4, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(43, 7, 'Birra alla Spina (media)', 'Birra artigianale locale', '3.00', NULL, 1, 5, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(44, 7, 'Vino della Casa (quartino)', 'Rosso o bianco della casa', '4.00', NULL, 1, 6, '2026-03-03 20:26:40', '2026-03-03 20:26:40'),
(45, 7, 'Vino della Casa (mezzo)', 'Rosso o bianco della casa', '7.00', NULL, 1, 7, '2026-03-03 20:26:40', '2026-03-03 20:26:40');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indici per le tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_messages_read` (`is_read`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_category` (`category_id`),
  ADD KEY `idx_products_available` (`is_available`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
