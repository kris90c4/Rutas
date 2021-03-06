-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2017 a las 20:37:57
-- Versión del servidor: 5.7.14
-- Versión de PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestoria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada2`
--

CREATE TABLE `entrada2` (
  `id` int(11) NOT NULL,
  `matricula` varchar(10) NOT NULL,
  `base_imponible` int(11) NOT NULL,
  `tipo_de_gravamen` int(11) NOT NULL,
  `id_vendedor` int(11) DEFAULT NULL,
  `id_compraventa` int(11) DEFAULT NULL,
  `id_comprador` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `provision` varchar(20) NOT NULL,
  `cobrado` date DEFAULT NULL,
  `fecha_entrada` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_salida` timestamp NULL DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entrada2`
--

INSERT INTO `entrada2` (`id`, `matricula`, `base_imponible`, `tipo_de_gravamen`, `id_vendedor`, `id_compraventa`, `id_comprador`, `id_tipo`, `provision`, `cobrado`, `fecha_entrada`, `fecha_salida`, `id_usuario`) VALUES
(6, '7825dlc', 1750, 4, 31, NULL, 32, 3, 'efectivo', NULL, '2017-08-18 11:24:59', NULL, 0),
(7, '8620FBD', 176, 4, 36, NULL, 37, 3, 'efectivo', '2017-08-18', '2017-08-18 12:27:16', NULL, 0),
(8, '0784CTP', 1100, 4, 38, NULL, 39, 3, 'visa', NULL, '2017-08-18 13:16:12', NULL, 0),
(9, 'H9763F', 130, 4, 44, NULL, 45, 3, 'efectivo', NULL, '2017-08-18 15:47:04', NULL, 0),
(10, '5333BXF', 0, 4, 46, NULL, 47, 3, 'efectivo', '2017-08-18', '2017-08-18 16:10:12', NULL, 0),
(11, '6555fvl', 2600, 4, 59, NULL, 60, 3, 'efectivo', '2017-08-21', '2017-08-21 07:14:53', NULL, 0),
(12, '1763BNY', 2200, 8, 25, NULL, 68, 3, 'visa', '2017-08-21', '2017-08-21 14:16:47', NULL, 0),
(13, 'IB2707CY', 600, 4, 69, NULL, 70, 3, 'efectivo', '2017-08-21', '2017-08-21 14:20:55', NULL, 0),
(14, '6788DRD', 1800, 4, NULL, NULL, 73, 3, 'efectivo', '2017-08-21', '2017-08-21 16:26:27', NULL, 0),
(18, '4815GPT', 325, 4, 83, NULL, 84, 3, 'visa', '2017-08-22', '2017-08-22 12:26:37', NULL, 5),
(19, '9796FLK', 2500, 4, 65, NULL, 89, 3, 'efectivo', NULL, '2017-08-22 15:16:54', NULL, 4),
(20, 'IB3441W', 0, 4, 25, NULL, 92, 3, 'visa', '2017-08-22', '2017-08-22 16:13:17', NULL, 4),
(21, '9649BPR', 900, 4, 94, NULL, 95, 3, 'efectivo', '2017-08-22', '2017-08-22 16:24:37', NULL, 4),
(22, '4550FNJ', 1150, 4, 25, NULL, 25, 3, 'visa', NULL, '2017-08-22 17:06:25', NULL, 4),
(23, '4873CWY', 1200, 4, 98, NULL, 99, 3, 'efectivo', '2017-08-22', '2017-08-22 17:19:29', NULL, 4),
(30, 'IB1652DJ', 199, 4, 105, NULL, 106, 3, 'efectivo', '2017-08-23', '2017-08-23 09:19:54', NULL, 8),
(31, '2804GXM', 283, 4, 112, NULL, 113, 3, 'visa', '2017-08-23', '2017-08-23 12:07:12', NULL, 5),
(32, 'IB9262BK', 0, 4, 119, NULL, 25, 2, 'efectivo', '2017-08-23', '2017-08-23 16:49:45', NULL, 4),
(35, '7845HFS', 121, 4, 120, NULL, 121, 3, 'efectivo', '2017-08-24', '2017-08-24 06:30:23', NULL, 8),
(36, '7727BXC', 155, 4, 126, NULL, 38, 3, 'efectivo', '2017-08-24', '2017-08-24 11:35:28', NULL, 5),
(37, '0394FVZ', 3200, 4, 127, NULL, 128, 3, 'efectivo', '2017-08-24', '2017-08-24 13:48:03', NULL, 6),
(39, 'IB7843DG', 700, 4, 130, NULL, 131, 3, 'efectivo', '2017-08-24', '2017-08-24 16:39:22', NULL, 6),
(40, '8478FFK', 2100, 4, 25, NULL, 132, 3, 'efectivo', NULL, '2017-08-24 17:19:31', NULL, 6),
(41, '8372GDN', 383, 4, 25, NULL, 133, 3, 'efectivo', '2017-08-25', '2017-08-25 07:22:43', NULL, 8),
(42, '9016DBW', 0, 4, NULL, 21, 134, 3, 'efectivo', '2017-08-25', '2017-08-25 09:03:46', NULL, 6),
(43, '4829DGJ', 1500, 4, 25, NULL, 135, 3, 'efectivo', '2017-08-25', '2017-08-25 09:04:13', NULL, 8),
(44, '1803GZR', 121, 4, NULL, 1, 136, 3, 'efectivo', '2017-08-25', '2017-08-25 09:40:56', '2017-09-13 16:26:31', 8),
(45, '7820CCG', 1950, 4, 137, NULL, 138, 3, 'efectivo', '2017-08-25', '2017-08-25 10:19:19', NULL, 5),
(46, '3667CTX', 0, 4, NULL, 19, 139, 3, 'efectivo', '2017-08-25', '2017-08-25 10:41:41', NULL, 6),
(47, '4185BYT', 1500, 4, 25, NULL, 140, 3, 'visa', '2017-08-25', '2017-08-25 13:13:36', NULL, 5),
(48, '1025DLR', 850, 4, 141, NULL, 142, 3, 'efectivo', '2017-08-25', '2017-08-25 13:24:54', NULL, 6),
(49, '4445GRW', 0, 4, NULL, 2, 143, 3, 'efectivo', NULL, '2017-08-25 13:41:02', NULL, 6),
(50, '1557CGW', 650, 4, 25, NULL, 144, 3, 'efectivo', '2017-08-25', '2017-08-25 15:36:13', NULL, 5),
(51, '2831CNJ', 3100, 8, 145, NULL, 146, 3, 'visa', '2017-08-25', '2017-08-25 16:18:20', NULL, 5),
(52, '0130DVL', 650, 4, 147, NULL, 148, 3, 'efectivo', '2017-08-25', '2017-08-25 16:31:09', NULL, 6),
(53, '1879GCD', 0, 4, NULL, 11, 149, 3, 'efectivo', '2017-08-25', '2017-08-25 16:57:31', NULL, 6),
(54, '5357FBT', 0, 4, NULL, 16, 150, 3, 'efectivo', '2017-08-25', '2017-08-25 17:10:20', '2017-09-05 22:00:00', 6),
(57, '4922BSV', 0, 4, NULL, 1, 151, 3, 'efectivo', '2017-08-26', '2017-08-26 05:49:50', NULL, 6),
(58, '4922BSV', 0, 4, NULL, 1, 151, 3, 'efectivo', '2017-08-26', '2017-08-26 05:50:10', NULL, 6),
(59, '5897GLX', 0, 4, NULL, 1, 152, 3, 'efectivo', '2017-08-26', '2017-08-26 07:20:26', NULL, 6),
(60, '8239FLR', 0, 4, NULL, 4, 153, 3, 'efectivo', '2017-08-26', '2017-08-26 07:27:17', NULL, 6),
(61, '4483DKG', 120, 4, 154, NULL, 155, 3, 'efectivo', '2017-08-26', '2017-08-26 08:02:24', NULL, 6),
(62, '7905FFX', 1700, 4, NULL, NULL, 157, 3, 'efectivo', '2017-08-26', '2017-08-26 08:54:00', NULL, 6),
(63, '6634GGM', 0, 4, 158, NULL, 159, 3, 'visa', '2017-08-26', '2017-08-26 10:58:00', NULL, 6),
(64, '4950DKD', 0, 4, NULL, 2, 160, 3, 'visa', NULL, '2017-08-26 11:03:18', NULL, 5),
(65, '9929BMS', 0, 4, NULL, 14, 161, 3, 'efectivo', NULL, '2017-08-28 07:24:27', NULL, 6),
(66, '0760DLH', 0, 4, NULL, 2, 162, 3, 'efectivo', NULL, '2017-08-28 08:26:34', NULL, 6),
(67, '5375CND', 100, 4, NULL, 15, 163, 3, 'efectivo', NULL, '2017-08-28 10:59:04', NULL, 7),
(68, '2084DJB', 0, 4, NULL, 23, 164, 3, 'efectivo', '2017-08-28', '2017-08-28 11:04:23', NULL, 6),
(69, '4188BBV', 1800, 4, 165, NULL, 166, 3, 'efectivo', '2017-08-28', '2017-08-28 14:23:59', NULL, 4),
(70, '6341HDV', 0, 4, NULL, 1, 167, 3, 'efectivo', '2017-08-28', '2017-08-28 15:50:26', NULL, 6),
(74, '6150GZR', 5950, 4, NULL, NULL, 168, 3, 'visa', '2017-08-28', '2017-08-28 16:10:31', NULL, 6),
(75, '4177FDP', 2600, 8, 25, NULL, 169, 3, 'efectivo', '2017-08-28', '2017-08-28 16:15:35', NULL, 4),
(76, '2469BTJ', 2400, 4, 170, NULL, 171, 3, 'efectivo', '2017-08-28', '2017-08-28 16:54:51', NULL, 4),
(77, '9360GSS', 420, 4, 172, NULL, 173, 3, 'efectivo', '2017-08-28', '2017-08-28 17:34:03', NULL, 4),
(79, 'IB9950CU', 1500, 4, 144, NULL, 176, 3, 'efectivo', '2017-08-28', '2017-08-28 17:59:38', NULL, 4),
(80, '7128HML', 517, 4, 177, NULL, 178, 3, 'efectivo', '2017-08-28', '2017-08-28 18:19:37', NULL, 4),
(81, '4832DXZ', 0, 4, NULL, 1, 179, 3, 'efectivo', NULL, '2017-08-29 10:47:21', NULL, 6),
(82, 'IB1167DN', 0, 4, 180, NULL, 181, 3, 'efectivo', '2017-08-29', '2017-08-29 11:17:59', NULL, 6),
(83, 'CC0002A', 1100, 4, 182, NULL, 183, 3, 'visa', NULL, '2017-08-29 11:24:49', NULL, 7),
(84, '6054DJF', 0, 4, NULL, 15, 184, 3, 'efectivo', NULL, '2017-08-29 13:02:53', NULL, 6),
(85, '6338GGR', 4000, 4, 185, NULL, 186, 3, 'visa', NULL, '2017-08-29 13:46:57', NULL, 7),
(86, '5479CWF', 1750, 4, 187, NULL, 188, 3, 'efectivo', '2017-08-29', '2017-08-29 13:57:36', NULL, 6),
(87, '4412CCD', 2000, 4, 189, NULL, 190, 3, 'visa', NULL, '2017-08-29 14:05:43', NULL, 7),
(88, '1276DCS', 0, 4, NULL, 11, 191, 3, 'efectivo', '2017-08-29', '2017-08-29 14:57:01', NULL, 6),
(89, '0161BXH', 1350, 4, 192, NULL, 193, 3, 'efectivo', '2017-08-29', '2017-08-29 16:11:34', NULL, 6),
(90, '3899DPB', 1700, 4, NULL, 18, 194, 3, 'efectivo', '2017-08-29', '2017-08-29 16:37:32', NULL, 4),
(92, '4843DYR', 1750, 4, 36, NULL, 197, 2, 'efectivo', '2017-08-29', '2017-08-29 16:46:51', NULL, 6),
(93, '0416FFM', 850, 4, 198, NULL, 199, 3, 'efectivo', '2017-08-29', '2017-08-29 17:12:08', NULL, 4),
(94, '1409FKG', 2400, 4, 200, NULL, 201, 3, 'visa', '2017-08-29', '2017-08-29 17:20:35', NULL, 6),
(95, '1664HLF', 0, 4, 202, NULL, 203, 3, 'efectivo', '2017-08-30', '2017-08-30 07:18:09', NULL, 6),
(96, '4936CKH', 2000, 4, 204, NULL, 205, 3, 'visa', '2017-08-30', '2017-08-30 09:48:04', NULL, 6),
(97, 'IB2854CS', 550, 4, 206, NULL, 207, 3, 'efectivo', '2017-08-30', '2017-08-30 09:56:58', '2017-09-05 22:00:00', 7),
(98, '0064BPL', 0, 4, NULL, 2, 208, 3, 'efectivo', NULL, '2017-08-30 10:13:44', NULL, 6),
(99, '2495CRP', 1250, 4, 209, NULL, 210, 3, 'efectivo', '2017-08-30', '2017-08-30 10:16:50', NULL, 7),
(100, '7799BDZ', 1650, 4, 211, NULL, 212, 3, 'visa', '2017-08-30', '2017-08-30 10:53:41', NULL, 7),
(101, '6713CWX', 0, 4, NULL, 3, 213, 3, 'efectivo', NULL, '2017-08-30 12:15:32', NULL, 6),
(102, '5118GHW', 0, 4, NULL, 16, 214, 3, 'efectivo', '2017-08-30', '2017-08-30 14:18:56', NULL, 6),
(103, 'IB3912DB', 700, 4, 215, NULL, 216, 3, 'visa', '2017-08-30', '2017-08-30 15:09:20', NULL, 4),
(104, '3287GFS', 0, 4, NULL, 16, 217, 3, 'efectivo', '2017-08-30', '2017-08-30 15:14:36', NULL, 6),
(105, 'IB8265DB', 1700, 4, 218, NULL, 219, 3, 'efectivo', '2017-08-30', '2017-08-30 15:29:15', NULL, 4),
(106, '5558DSP', 0, 4, 220, NULL, 221, 3, 'efectivo', '2017-08-30', '2017-08-30 15:51:30', NULL, 4),
(107, '6521CWZ', 0, 4, NULL, 24, 222, 3, 'efectivo', '2017-08-30', '2017-08-30 16:03:01', NULL, 6),
(108, '2765BGC', 1900, 4, 225, NULL, 226, 3, 'efectivo', '2017-08-31', '2017-08-31 08:00:19', '2017-09-05 22:00:00', 7),
(109, '5791GFH', 2700, 4, 227, NULL, 228, 3, 'visa', '2017-08-31', '2017-08-31 11:17:35', '2017-09-05 22:00:00', 7),
(110, 'M4028SF', 0, 4, 229, NULL, 230, 3, 'efectivo', '2017-08-31', '2017-08-31 11:35:03', '2017-09-05 22:00:00', 7),
(111, '5080CNW', 2000, 4, 231, NULL, 232, 3, 'efectivo', '2017-08-31', '2017-08-31 12:04:37', '2017-09-05 22:00:00', 6),
(112, 'GR7994AF', 850, 4, 233, NULL, 234, 3, 'efectivo', '2017-08-31', '2017-08-31 12:35:28', '2017-09-05 22:00:00', 6),
(113, '7560FPP', 0, 4, 235, NULL, 235, 2, 'visa', NULL, '2017-08-31 14:12:11', NULL, 4),
(114, 'C2327BCL', 0, 4, 236, NULL, 237, 3, 'efectivo', '2017-08-31', '2017-08-31 14:39:18', '2017-09-05 22:00:00', 4),
(115, '5029CWF', 2000, 4, 238, NULL, 239, 3, 'efectivo', '2017-08-31', '2017-08-31 15:04:38', NULL, 4),
(116, 'IB1726BB', 300, 4, 240, NULL, 241, 3, 'efectivo', '2017-08-31', '2017-08-31 15:25:57', '2017-09-05 22:00:00', 6),
(117, '0003DDD', 1300, 4, 242, NULL, 243, 3, 'efectivo', '2017-08-31', '2017-08-31 16:16:07', '2017-09-05 22:00:00', 6),
(118, '1034DKB', 1700, 4, 244, NULL, 245, 3, 'efectivo', '2017-08-31', '2017-08-31 16:25:33', '2017-09-05 22:00:00', 4),
(119, 'C6597BVX', 0, 4, 247, NULL, 248, 3, 'visa', '2017-09-01', '2017-09-01 10:18:53', NULL, 7),
(120, 'MU4284CG', 1800, 4, 250, NULL, 251, 3, 'efectivo', '2017-09-01', '2017-09-01 12:05:26', '2017-09-05 22:00:00', 7),
(121, 'IB1354DL', 500, 4, 252, NULL, 253, 3, 'efectivo', '2017-09-01', '2017-09-01 12:57:59', '2017-09-05 22:00:00', 6),
(122, 'C8964BFH', 300, 4, 254, NULL, 255, 3, 'efectivo', '2017-09-01', '2017-09-01 14:25:05', '2017-09-05 22:00:00', 6),
(123, '4488JGF', 804, 4, 256, NULL, 257, 3, 'efectivo', '2017-09-01', '2017-09-01 14:25:22', '2017-09-05 22:00:00', 4),
(124, 'IB5145DC', 0, 4, 259, NULL, 236, 2, 'efectivo', '2017-09-01', '2017-09-01 15:09:07', '2017-09-05 22:00:00', 4),
(125, '7270DLX', 0, 4, 261, NULL, 260, 3, 'efectivo', '2017-09-01', '2017-09-01 15:29:50', '2017-09-13 16:31:08', 6),
(126, '5397CMD', 1500, 4, 262, NULL, 263, 3, 'efectivo', '2017-09-01', '2017-09-01 16:12:04', '2017-09-05 22:00:00', 4),
(128, '5455FCB', 750, 4, 266, NULL, 265, 3, 'efectivo', '2017-09-01', '2017-09-01 16:58:02', '2017-09-05 22:00:00', 6),
(129, 'IB5643DG', 1050, 4, 268, NULL, 267, 3, 'efectivo', '2017-09-01', '2017-09-01 17:45:55', '2017-09-05 22:00:00', 6),
(132, '7268CJF', 1000, 8, 280, NULL, 281, 3, 'efectivo', '2017-09-04', '2017-09-04 16:05:38', '2017-09-06 22:00:00', 6),
(134, '6415FYY', 2550, 4, 286, NULL, 287, 3, 'efectivo', '2017-09-04', '2017-09-04 16:53:40', NULL, 6),
(135, '9028CPG', 2000, 4, 288, NULL, 289, 3, 'efectivo', '2017-09-04', '2017-09-04 17:01:27', '2017-09-06 22:00:00', 4),
(136, '6892FYC', 0, 4, NULL, 1, 292, 3, 'efectivo', '2017-09-04', '2017-09-04 17:17:10', '2017-09-06 22:00:00', 6),
(137, '4477BGK', 1500, 4, NULL, 21, 293, 3, 'efectivo', '2017-09-04', '2017-09-04 17:19:35', '2017-09-06 22:00:00', 4),
(139, 'IB0957DT', 0, 4, NULL, 4, 283, 4, 'efectivo', '2017-09-04', '2017-09-04 17:35:17', '2017-09-06 22:00:00', 4),
(142, '5259CHV', 0, 4, NULL, 2, 296, 3, 'efectivo', NULL, '2017-09-05 08:02:01', '2017-09-13 16:26:31', 6),
(143, '7651GNV', 0, 4, 297, NULL, 298, 3, 'efectivo', NULL, '2017-09-05 08:34:04', '2017-09-13 16:26:31', 7),
(144, '0000DXR', 0, 4, NULL, 21, 299, 3, 'efectivo', '2017-09-05', '2017-09-05 08:59:15', '2017-09-13 16:26:31', 7),
(145, '5799DFN', 0, 4, NULL, 13, 300, 3, 'efectivo', '2017-09-05', '2017-09-05 09:13:10', '2017-09-13 16:26:31', 6),
(146, '9166BCF', 0, 4, NULL, 12, 301, 3, 'efectivo', '2017-09-05', '2017-09-05 09:17:13', '2017-09-13 16:26:31', 7),
(147, '4229FRY', 204, 4, 302, NULL, 303, 3, 'efectivo', '2017-09-05', '2017-09-05 09:32:34', '2017-09-13 16:26:31', 6),
(148, '4668HKP', 468, 4, 304, NULL, 305, 3, 'efectivo', '2017-09-05', '2017-09-05 09:51:34', '2017-09-13 16:26:31', 6),
(149, '8996CTB', 2200, 4, 306, NULL, 307, 3, 'efectivo', NULL, '2017-09-05 11:22:47', '2017-09-13 16:26:31', 7),
(150, '1008CDY', 0, 4, NULL, 1, 308, 3, 'efectivo', '2017-09-05', '2017-09-05 14:29:11', '2017-09-13 16:26:31', 6),
(151, 'IB0066DK', 0, 4, NULL, 10, 309, 3, 'efectivo', '2017-09-05', '2017-09-05 14:54:16', '2017-09-06 22:00:00', 4),
(152, '5842BXJ', 2200, 4, 310, NULL, 311, 3, 'efectivo', '2017-09-05', '2017-09-05 15:46:33', '2017-09-13 16:26:31', 6),
(153, 'IB4444DT', 0, 4, 313, NULL, 312, 3, 'efectivo', '2017-09-05', '2017-09-05 16:30:40', '2017-09-07 22:00:00', 4),
(154, '7201FLY', 2700, 8, 314, NULL, 315, 3, 'efectivo', '2017-09-05', '2017-09-05 16:43:43', NULL, 6),
(155, '6502CZV', 1150, 4, 316, NULL, 252, 3, 'visa', '2017-09-05', '2017-09-05 16:49:01', '2017-09-13 16:26:31', 6),
(156, '5870FBH', 0, 4, 317, NULL, 318, 3, 'efectivo', '2017-09-05', '2017-09-05 16:51:16', '2017-09-06 22:00:00', 4),
(157, 'T7171AT', 1100, 4, 319, NULL, 320, 3, 'efectivo', '2017-09-06', '2017-09-06 07:45:34', '2017-09-13 16:26:31', 7),
(158, '5302GYR', 0, 4, NULL, 13, 321, 3, 'visa', '2017-09-06', '2017-09-06 09:37:26', '2017-09-13 16:26:31', 7),
(159, '4986CFX', 1400, 4, 322, NULL, 323, 3, 'efectivo', '2017-09-06', '2017-09-06 13:27:58', '2017-09-13 16:26:31', 7),
(160, 'IB2551BP', 1600, 8, 324, NULL, 325, 3, 'efectivo', '2017-09-06', '2017-09-06 14:29:44', '2017-09-07 22:00:00', 4),
(161, '5889DMX', 0, 4, NULL, 11, 326, 3, 'efectivo', '2017-09-06', '2017-09-06 15:11:21', NULL, 6),
(162, '9970HKG', 3705, 4, 327, NULL, 328, 3, 'visa', '2017-09-06', '2017-09-06 15:19:34', '2017-09-13 16:26:31', 4),
(164, '5421HKP', 8500, 4, 330, NULL, 331, 3, 'efectivo', '2017-09-06', '2017-09-06 17:28:10', '2017-09-13 16:26:31', 4),
(165, '4404GJW', 1900, 4, 332, NULL, 177, 3, 'efectivo', '2017-09-06', '2017-09-06 17:50:05', '2017-09-13 16:26:31', 4),
(166, '9319BMC', 1950, 4, NULL, 8, 333, 3, 'efectivo', '2017-09-07', '2017-09-07 07:54:47', NULL, 6),
(167, '4692BZV', 1400, 4, 334, NULL, 335, 3, 'efectivo', '2017-09-07', '2017-09-07 07:55:37', NULL, 7),
(168, '6264BMH', 1650, 4, 336, NULL, 337, 3, 'efectivo', '2017-09-07', '2017-09-07 08:07:13', NULL, 6),
(169, '2745CTC', 0, 4, 338, NULL, 339, 3, 'efectivo', '2017-09-07', '2017-09-07 09:55:15', NULL, 7),
(170, '0335DWK', 2300, 8, 86, NULL, 340, 3, 'efectivo', '2017-09-07', '2017-09-07 13:59:51', NULL, 7),
(171, 'IB9343DH', 1400, 4, 341, NULL, 342, 3, 'efectivo', '2017-09-07', '2017-09-07 14:35:34', NULL, 4),
(172, '6946FLG', 0, 4, 343, NULL, 344, 3, 'efectivo', '2017-09-07', '2017-09-07 14:37:50', NULL, 6),
(173, '5880FLV', 850, 4, 345, NULL, 346, 3, 'efectivo', '2017-09-07', '2017-09-07 14:55:49', '2017-09-13 16:31:08', 4),
(174, 'IB5087CZ', 1300, 4, NULL, 8, 347, 3, 'efectivo', NULL, '2017-09-07 15:05:24', NULL, 6),
(175, '6212BXH', 0, 4, NULL, 1, 348, 3, 'efectivo', NULL, '2017-09-07 15:08:27', NULL, 6),
(176, '3286FPL', 3050, 4, 349, NULL, 350, 3, 'visa', '2017-09-07', '2017-09-07 15:13:03', NULL, 6),
(177, '9995GXD', 2400, 4, 351, NULL, 352, 3, 'efectivo', '2017-09-07', '2017-09-07 15:16:59', NULL, 6),
(178, '882FRZ', 0, 4, NULL, 1, 353, 3, 'efectivo', NULL, '2017-09-07 15:20:33', NULL, 6),
(179, '9817BGG', 1300, 4, NULL, 7, 354, 3, 'visa', NULL, '2017-09-07 15:23:16', NULL, 6),
(180, '4711FHW', 0, 4, NULL, 7, 355, 3, 'efectivo', '2017-09-07', '2017-09-07 15:39:32', NULL, 6),
(181, '0812FGT', 0, 4, NULL, 7, 356, 3, 'efectivo', '2017-09-07', '2017-09-07 16:00:01', NULL, 6),
(182, '9596BTL', 1500, 4, 357, NULL, 358, 3, 'efectivo', '2017-09-07', '2017-09-07 17:45:01', NULL, 4),
(183, '1717GBX', 2375, 4, 359, NULL, 360, 3, 'efectivo', '2017-09-08', '2017-09-08 06:41:26', '2017-09-13 16:31:08', 6),
(184, '5660GHD', 0, 4, NULL, 13, 361, 3, 'visa', '2017-09-08', '2017-09-08 08:23:43', '2017-09-13 16:31:08', 6),
(185, '9625CVF', 0, 4, NULL, 12, 362, 3, 'efectivo', '2017-09-08', '2017-09-08 08:58:41', '2017-09-13 16:31:08', 6),
(186, '7292DMZ', 1750, 4, 363, NULL, 364, 3, 'efectivo', '2017-09-08', '2017-09-08 09:16:23', NULL, 6),
(187, '7797FFJ', 650, 4, 365, NULL, 256, 3, 'efectivo', '2017-09-08', '2017-09-08 09:22:49', '2017-09-13 16:31:08', 7),
(188, '7232FWW', 0, 4, NULL, 3, 366, 3, 'efectivo', '2017-09-08', '2017-09-08 10:14:46', '2017-09-13 16:31:08', 6),
(189, '6570GLM', 4250, 4, 367, NULL, 368, 3, 'efectivo', '2017-09-08', '2017-09-08 12:43:23', NULL, 7),
(190, '8577CGV', 0, 4, NULL, 1, 369, 3, 'efectivo', '2017-09-08', '2017-09-08 14:07:36', '2017-09-13 16:31:08', 6),
(191, '4043GWN', 840, 4, 370, NULL, 345, 3, 'efectivo', '2017-09-08', '2017-09-08 14:52:37', '2017-09-13 16:31:08', 4),
(192, '7610CHZ', 1400, 4, NULL, 28, 371, 3, 'visa', '2017-09-08', '2017-09-08 15:16:16', '2017-09-13 16:31:08', 6),
(193, '8749BCP', 0, 4, NULL, 10, 372, 3, 'efectivo', '2017-09-08', '2017-09-08 15:17:07', NULL, 4),
(194, '6747GLX', 0, 4, NULL, 14, 373, 4, 'efectivo', '2017-09-08', '2017-09-08 15:59:02', '2017-09-13 16:31:08', 6),
(195, '2114BDR', 0, 4, NULL, 1, 374, 3, 'efectivo', '2017-09-08', '2017-09-08 17:21:28', '2017-09-13 16:31:08', 6),
(196, '7238DRS', 0, 4, NULL, 15, 375, 3, 'visa', NULL, '2017-09-08 18:02:19', NULL, 4),
(197, '4924BSV', 0, 4, NULL, 22, 376, 3, 'efectivo', '2017-09-11', '2017-09-11 14:26:11', NULL, 4),
(198, '0156BPL', 1700, 4, 377, NULL, 378, 3, 'efectivo', '2017-09-11', '2017-09-11 16:08:37', NULL, 4),
(199, 'IB9759DG', 1060, 4, 379, NULL, 380, 3, 'efectivo', NULL, '2017-09-11 16:27:55', NULL, 6),
(200, '5436BKP', 1650, 4, NULL, 2, 381, 3, 'efectivo', '2017-09-12', '2017-09-12 09:23:44', NULL, 6),
(201, '8097BHR', 850, 4, 382, NULL, 383, 3, 'efectivo', '2017-09-12', '2017-09-12 10:22:48', NULL, 6),
(202, '1239DJC', 2450, 8, 384, NULL, 385, 3, 'visa', '2017-09-12', '2017-09-12 11:48:14', NULL, 6),
(203, '7318BNZ', 900, 4, 386, NULL, 387, 3, 'visa', '2017-09-12', '2017-09-12 14:27:08', NULL, 4),
(204, '8893CGG', 2000, 4, 388, NULL, 389, 3, 'efectivo', '2017-09-12', '2017-09-12 15:09:32', NULL, 4),
(205, '8498GDV', 0, 4, NULL, 22, 390, 3, 'efectivo', '2017-09-12', '2017-09-12 15:43:49', NULL, 6),
(206, '5144FBV', 0, 4, NULL, 15, 391, 3, 'efectivo', NULL, '2017-09-12 16:19:41', NULL, 6),
(207, '4347CFF', 0, 4, NULL, 21, 392, 3, 'efectivo', '2017-09-13', '2017-09-13 09:58:13', NULL, 6),
(208, 'IB9491DM', 1100, 4, 38, NULL, 393, 3, 'efectivo', '2017-09-13', '2017-09-13 15:15:37', NULL, 6),
(209, '4255HYJ', 0, 4, NULL, 3, 394, 3, 'efectivo', '2017-09-13', '2017-09-13 15:46:01', NULL, 6),
(210, '3274DWY', 0, 4, NULL, 16, 395, 3, 'efectivo', '2017-09-13', '2017-09-13 17:03:48', NULL, 6),
(211, '7374DTY', 0, 4, NULL, 1, 396, 3, 'efectivo', NULL, '2017-09-13 17:16:33', NULL, 4),
(212, '1696GSM', 0, 4, NULL, 1, 397, 3, 'efectivo', NULL, '2017-09-13 18:01:40', NULL, 4),
(213, '9453DBB', 1400, 4, 398, NULL, 399, 3, 'efectivo', '2017-09-14', '2017-09-14 06:37:13', NULL, 7),
(214, '3297FVG', 0, 4, NULL, 11, 400, 3, 'efectivo', '2017-09-14', '2017-09-14 07:58:19', NULL, 6),
(215, '7363CNX', 0, 4, 220, NULL, 401, 3, 'efectivo', '2017-09-14', '2017-09-14 08:04:10', NULL, 7),
(216, 'IB0434BV', 1650, 4, 402, NULL, 403, 3, 'efectivo', '2017-09-14', '2017-09-14 11:01:21', NULL, 7),
(217, '9797CRP', 0, 4, NULL, 1, 404, 3, 'efectivo', '2017-09-14', '2017-09-14 11:22:19', NULL, 6),
(218, '6568DHB', 0, 4, NULL, 22, 405, 3, 'efectivo', '2017-09-14', '2017-09-14 13:30:50', NULL, 7),
(219, '5080CNW', 2000, 4, 232, NULL, 406, 3, 'visa', '2017-09-14', '2017-09-14 14:25:11', NULL, 4),
(220, '0979BCB', 0, 4, 407, NULL, 408, 2, 'efectivo', '2017-09-14', '2017-09-14 14:55:51', NULL, 4),
(221, '1904BRD', 1950, 4, NULL, 15, 409, 3, 'efectivo', '2017-09-14', '2017-09-14 15:00:15', NULL, 6),
(222, '4743DFM', 0, 4, NULL, 11, 410, 3, 'efectivo', '2017-09-14', '2017-09-14 15:03:14', NULL, 6),
(223, '9684HJK', 3705, 4, 411, NULL, 412, 3, 'visa', NULL, '2017-09-14 15:40:55', NULL, 6),
(224, 'B9828SF', 450, 4, NULL, 2, 413, 3, 'visa', '2017-09-14', '2017-09-14 16:02:24', NULL, 6),
(225, '1728CHW', 1200, 4, 144, NULL, 414, 3, 'visa', '2017-09-14', '2017-09-14 16:37:45', NULL, 4),
(226, '3270CYJ', 0, 4, NULL, 22, 415, 3, 'efectivo', '2017-09-14', '2017-09-14 17:24:05', NULL, 4),
(227, '1302JMZ', 1008, 4, 416, NULL, 417, 3, 'efectivo', '2017-09-14', '2017-09-14 17:40:42', NULL, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `entrada2`
--
ALTER TABLE `entrada2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_compraventa` (`id_compraventa`),
  ADD KEY `id_vendedor` (`id_vendedor`),
  ADD KEY `id_comprador` (`id_comprador`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `entrada2`
--
ALTER TABLE `entrada2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entrada2`
--
ALTER TABLE `entrada2`
  ADD CONSTRAINT `fk_comprador` FOREIGN KEY (`id_comprador`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_compraventa` FOREIGN KEY (`id_compraventa`) REFERENCES `compraventa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vendendor` FOREIGN KEY (`id_vendedor`) REFERENCES `cliente` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
