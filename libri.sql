-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 15, 2024 alle 16:46
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestione_libreria`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `libri`
--

CREATE TABLE `libri` (
  `id` int(10) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `autore` varchar(50) NOT NULL,
  `anno_pubblicazione` int(4) NOT NULL,
  `genere` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `libri`
--

INSERT INTO `libri` (`id`, `titolo`, `autore`, `anno_pubblicazione`, `genere`) VALUES
(1, 'Il Signore degli Anelli - La Compagnia dell\'Anello', 'Jhon Ronald Reuel Tolkien', 1954, 'Romanzo'),
(2, 'Il Signore degli Anelli - Le DueTorri', 'John Ronald Reuel Tolkien', 1954, 'Romanzo'),
(3, 'Il Signore degli Anelli - Il Ritorno del re', 'Jhon Ronald Reuel Tolkien', 1955, 'Romanzo'),
(4, 'Pride and Prejudice', 'Jane Austen', 1813, 'Romazo'),
(5, 'Renoir, mio padre', 'Jean Renoir', 1963, 'Biografia'),
(6, 'Psicopatologia della vita quotidiana', 'Sigmund Freud', 1901, 'Saggio'),
(7, 'Il dado di Einstein e il gatto di Schrodinger', 'Paul Halpern', 2016, 'Scienza'),
(8, 'Solo bagaglio a mano', 'Gabriele Romagnoli', 2015, 'Biografia');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `libri`
--
ALTER TABLE `libri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `libri`
--
ALTER TABLE `libri`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
