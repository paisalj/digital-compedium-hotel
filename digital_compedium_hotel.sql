-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 04:33 AM
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
-- Database: `digital_compedium_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `module` varchar(255) NOT NULL,
  `action` enum('create','update','delete','publish','archive','login','logout') NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `module`, `action`, `description`, `ip_address`, `created_at`, `updated_at`) VALUES
(659, 2, 'Category', 'create', 'Category ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:08:21', '2026-07-29 02:08:21'),
(660, 2, 'Content', 'create', 'Content ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(661, 2, 'Content', 'create', 'Content ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(662, 2, 'Content', 'create', 'Content ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(663, 2, 'Content', 'create', 'Content ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(664, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:27:26', '2026-07-29 02:27:26'),
(665, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:27:26', '2026-07-29 02:27:26'),
(666, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:27:37', '2026-07-29 02:27:37'),
(667, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:27:37', '2026-07-29 02:27:37'),
(668, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:30:43', '2026-07-29 02:30:43'),
(669, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:30:43', '2026-07-29 02:30:43'),
(670, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:31:28', '2026-07-29 02:31:28'),
(671, 2, 'Category', 'update', 'Category ID 1 telah di-update', '127.0.0.1', '2026-07-29 02:31:29', '2026-07-29 02:31:29'),
(672, 2, 'Media', 'create', 'Media ID 1 telah di-create', '127.0.0.1', '2026-07-29 02:32:24', '2026-07-29 02:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-ai_trans_0902dd2144339efefa4b812c88c527c2_id_da', 'O:37:\"App\\Services\\AI\\DTO\\TranslationResult\":10:{s:7:\"success\";b:1;s:14:\"translatedText\";s:24:\"wifi dan ngaran pengguna\";s:8:\"provider\";s:4:\"groq\";s:5:\"model\";s:0:\"\";s:14:\"sourceLanguage\";s:2:\"id\";s:14:\"targetLanguage\";s:2:\"da\";s:6:\"tokens\";i:0;s:13:\"executionTime\";d:0;s:6:\"cached\";b:0;s:5:\"error\";N;}', 1787882889),
('laravel-cache-ai_trans_0902dd2144339efefa4b812c88c527c2_id_en', 'O:37:\"App\\Services\\AI\\DTO\\TranslationResult\":10:{s:7:\"success\";b:1;s:14:\"translatedText\";s:17:\"wifi and username\";s:8:\"provider\";s:4:\"groq\";s:5:\"model\";s:0:\"\";s:14:\"sourceLanguage\";s:2:\"id\";s:14:\"targetLanguage\";s:2:\"en\";s:6:\"tokens\";i:0;s:13:\"executionTime\";d:0;s:6:\"cached\";b:0;s:5:\"error\";N;}', 1787882889),
('laravel-cache-ai_trans_36bdb7442abffd60ef4daf287a924057_id_da', 'O:37:\"App\\Services\\AI\\DTO\\TranslationResult\":10:{s:7:\"success\";b:1;s:14:\"translatedText\";s:3600:\"{\"title\":\"cara koneksi wifi\",\"body\":\"<p class=\\\"PDq2pG_selectionAnchorContainer\\\" data-start=\\\"216\\\" data-end=\\\"378\\\">Selamat datang di <strong data-start=\\\"234\\\" data-end=\\\"253\\\">M Bahalap Hotel<\\/strong>. Untuk memberikan kenyamanan selama menginap, kami menyediakan akses WiFi gratis yang dapat digunakan di seluruh area hotel.<\\/p>\\n<h3 data-section-id=\\\"18mbtfg\\\" data-start=\\\"380\\\" data-end=\\\"418\\\">Langkah-langkah Menghubungkan WiFi<\\/h3>\\n<ol data-start=\\\"420\\\" data-end=\\\"785\\\">\\n<li data-section-id=\\\"18b7v0a\\\" data-start=\\\"420\\\" data-end=\\\"501\\\">Aktifkan fitur <strong data-start=\\\"438\\\" data-end=\\\"446\\\">WiFi<\\/strong> pada perangkat Anda (Smartphone, Tablet, atau Laptop).<\\/li>\\n<li data-section-id=\\\"jctmm9\\\" data-start=\\\"502\\\" data-end=\\\"545\\\">Buka daftar jaringan WiFi yang tersedia.<\\/li>\\n<li data-section-id=\\\"e5vht7\\\" data-start=\\\"546\\\" data-end=\\\"598\\\">Pilih jaringan WiFi hotel:<br><strong data-start=\\\"579\\\" data-end=\\\"598\\\">M Bahalap<\\/strong><\\/li>\\n<li data-section-id=\\\"19r7hxu\\\" data-start=\\\"599\\\" data-end=\\\"703\\\">Masukkan kata sandi WiFi<br><strong>5StarPKY<\\/strong><\\/li>\\n<li data-section-id=\\\"1tp6uz9\\\" data-start=\\\"704\\\" data-end=\\\"785\\\">Tekan <strong data-start=\\\"713\\\" data-end=\\\"737\\\">Connect \\/ Sambungkan<\\/strong> dan tunggu hingga perangkat berhasil terhubung.<\\/li>\\n<\\/ol>\\n<h3 data-section-id=\\\"18onfiz\\\" data-start=\\\"787\\\" data-end=\\\"838\\\">Jika Menggunakan Halaman Login (Captive Portal)<\\/h3>\\n<p data-start=\\\"840\\\" data-end=\\\"952\\\">Pada beberapa perangkat, halaman login akan muncul secara otomatis setelah terhubung ke WiFi. Jika tidak muncul:<\\/p>\\n<ul data-start=\\\"954\\\" data-end=\\\"1146\\\">\\n<li data-section-id=\\\"1695pjo\\\" data-start=\\\"954\\\" data-end=\\\"1006\\\">Buka browser (Chrome, Edge, Safari, atau lainnya).<\\/li>\\n<li data-section-id=\\\"1ryckz\\\" data-start=\\\"1007\\\" data-end=\\\"1038\\\">Kunjungi sembarang situs web.<\\/li>\\n<li data-section-id=\\\"tdqvs\\\" data-start=\\\"1039\\\" data-end=\\\"1089\\\">Halaman login WiFi akan terbuka secara otomatis.<\\/li>\\n<li data-section-id=\\\"1pxs51g\\\" data-start=\\\"1090\\\" data-end=\\\"1146\\\">Masukkan informasi yang diminta, lalu tekan <strong data-start=\\\"1136\\\" data-end=\\\"1145\\\">Login<\\/strong>.<\\/li>\\n<\\/ul>\\n<h3 data-section-id=\\\"qq3ho8\\\" data-start=\\\"1148\\\" data-end=\\\"1170\\\">Mengalami Kendala?<\\/h3>\\n<p data-start=\\\"1172\\\" data-end=\\\"1284\\\">Apabila Anda mengalami kesulitan saat menghubungkan perangkat ke jaringan WiFi, silakan lakukan langkah berikut:<\\/p>\\n<ul data-start=\\\"1286\\\" data-end=\\\"1480\\\">\\n<li data-section-id=\\\"lbqvrr\\\" data-start=\\\"1286\\\" data-end=\\\"1333\\\">Matikan lalu aktifkan kembali WiFi perangkat.<\\/li>\\n<li data-section-id=\\\"115pj7v\\\" data-start=\\\"1334\\\" data-end=\\\"1403\\\">Lupakan (Forget Network) jaringan WiFi kemudian sambungkan kembali.<\\/li>\\n<li data-section-id=\\\"ebcw22\\\" data-start=\\\"1404\\\" data-end=\\\"1429\\\">Restart perangkat Anda.<\\/li>\\n<li data-section-id=\\\"vcy53e\\\" data-start=\\\"1430\\\" data-end=\\\"1480\\\">Pastikan Anda menggunakan kata sandi yang benar.<\\/li>\\n<\\/ul>\\n<p data-start=\\\"1482\\\" data-end=\\\"1614\\\">Jika masalah masih berlanjut, silakan hubungi <strong data-start=\\\"1528\\\" data-end=\\\"1544\\\">Front Office<\\/strong> atau <strong data-start=\\\"1550\\\" data-end=\\\"1570\\\">Customer Service<\\/strong>. Tim kami siap membantu Anda selama 24 jam.<\\/p>\\n<blockquote data-start=\\\"1616\\\" data-end=\\\"1775\\\">\\n<p data-start=\\\"1618\\\" data-end=\\\"1775\\\"><strong data-start=\\\"1618\\\" data-end=\\\"1630\\\">Catatan:<\\/strong> Demi kenyamanan bersama, gunakan jaringan WiFi hotel secara bijak dan hindari aktivitas yang melanggar hukum atau kebijakan penggunaan internet.<\\/p>\\n<\\/blockquote>\"}\";s:8:\"provider\";s:4:\"groq\";s:5:\"model\";s:0:\"\";s:14:\"sourceLanguage\";s:2:\"id\";s:14:\"targetLanguage\";s:2:\"da\";s:6:\"tokens\";i:0;s:13:\"executionTime\";d:0;s:6:\"cached\";b:0;s:5:\"error\";N;}', 1787883313),
('laravel-cache-ai_trans_36bdb7442abffd60ef4daf287a924057_id_en', 'O:37:\"App\\Services\\AI\\DTO\\TranslationResult\":10:{s:7:\"success\";b:1;s:14:\"translatedText\";s:3466:\"{\"title\":\"how to connect wifi\",\"body\":\"<p class=\\\"PDq2pG_selectionAnchorContainer\\\" data-start=\\\"216\\\" data-end=\\\"378\\\">Welcome to <strong data-start=\\\"234\\\" data-end=\\\"253\\\">M Bahalap Hotel<\\/strong>. To provide comfort during your stay, we provide free WiFi access that can be used throughout the hotel area.<\\/p>\\n<h3 data-section-id=\\\"18mbtfg\\\" data-start=\\\"380\\\" data-end=\\\"418\\\">Steps to Connect WiFi<\\/h3>\\n<ol data-start=\\\"420\\\" data-end=\\\"785\\\">\\n<li data-section-id=\\\"18b7v0a\\\" data-start=\\\"420\\\" data-end=\\\"501\\\">Enable the <strong data-start=\\\"438\\\" data-end=\\\"446\\\">WiFi<\\/strong> feature on your device (Smartphone, Tablet, or Laptop).<\\/li>\\n<li data-section-id=\\\"jctmm9\\\" data-start=\\\"502\\\" data-end=\\\"545\\\">Open the list of available WiFi networks.<\\/li>\\n<li data-section-id=\\\"e5vht7\\\" data-start=\\\"546\\\" data-end=\\\"598\\\">Select the hotel\'s WiFi network:<br><strong data-start=\\\"579\\\" data-end=\\\"598\\\">M Bahalap<\\/strong><\\/li>\\n<li data-section-id=\\\"19r7hxu\\\" data-start=\\\"599\\\" data-end=\\\"703\\\">Enter the WiFi password<br><strong>5StarPKY<\\/strong><\\/li>\\n<li data-section-id=\\\"1tp6uz9\\\" data-start=\\\"704\\\" data-end=\\\"785\\\">Press <strong data-start=\\\"713\\\" data-end=\\\"737\\\">Connect \\/ Connect<\\/strong> and wait until the device is successfully connected.<\\/li>\\n<\\/ol>\\n<h3 data-section-id=\\\"18onfiz\\\" data-start=\\\"787\\\" data-end=\\\"838\\\">If Using Login Page (Captive Portal)<\\/h3>\\n<p data-start=\\\"840\\\" data-end=\\\"952\\\">On some devices, the login page will appear automatically after connecting to WiFi. If it doesn\'t appear:<\\/p>\\n<ul data-start=\\\"954\\\" data-end=\\\"1146\\\">\\n<li data-section-id=\\\"1695pjo\\\" data-start=\\\"954\\\" data-end=\\\"1006\\\">Open a browser (Chrome, Edge, Safari, or other).<\\/li>\\n<li data-section-id=\\\"1ryckz\\\" data-start=\\\"1007\\\" data-end=\\\"1038\\\">Visit any website.<\\/li>\\n<li data-section-id=\\\"tdqvs\\\" data-start=\\\"1039\\\" data-end=\\\"1089\\\">The WiFi login page will open automatically.<\\/li>\\n<li data-section-id=\\\"1pxs51g\\\" data-start=\\\"1090\\\" data-end=\\\"1146\\\">Enter the requested information, then press <strong data-start=\\\"1136\\\" data-end=\\\"1145\\\">Login<\\/strong>.<\\/li>\\n<\\/ul>\\n<h3 data-section-id=\\\"qq3ho8\\\" data-start=\\\"1148\\\" data-end=\\\"1170\\\">Having Trouble?<\\/h3>\\n<p data-start=\\\"1172\\\" data-end=\\\"1284\\\">If you are having trouble connecting your device to the WiFi network, please do the following:<\\/p>\\n<ul data-start=\\\"1286\\\" data-end=\\\"1480\\\">\\n<li data-section-id=\\\"lbqvrr\\\" data-start=\\\"1286\\\" data-end=\\\"1333\\\">Turn off and then turn on the WiFi on your device.<\\/li>\\n<li data-section-id=\\\"115pj7v\\\" data-start=\\\"1334\\\" data-end=\\\"1403\\\">Forget the WiFi network and then reconnect.<\\/li>\\n<li data-section-id=\\\"ebcw22\\\" data-start=\\\"1404\\\" data-end=\\\"1429\\\">Restart your device.<\\/li>\\n<li data-section-id=\\\"vcy53e\\\" data-start=\\\"1430\\\" data-end=\\\"1480\\\">Make sure you are using the correct password.<\\/li>\\n<\\/ul>\\n<p data-start=\\\"1482\\\" data-end=\\\"1614\\\">If the problem persists, please contact <strong data-start=\\\"1528\\\" data-end=\\\"1544\\\">Front Office<\\/strong> or <strong data-start=\\\"1550\\\" data-end=\\\"1570\\\">Customer Service<\\/strong>. Our team is ready to help you 24 hours a day.<\\/p>\\n<blockquote data-start=\\\"1616\\\" data-end=\\\"1775\\\">\\n<p data-start=\\\"1618\\\" data-end=\\\"1775\\\"><strong data-start=\\\"1618\\\" data-end=\\\"1630\\\">Note:<\\/strong> For the comfort of all, use the hotel\'s WiFi network wisely and avoid activities that violate the law or internet usage policy.<\\/p>\\n<\\/blockquote>\"}\";s:8:\"provider\";s:4:\"groq\";s:5:\"model\";s:0:\"\";s:14:\"sourceLanguage\";s:2:\"id\";s:14:\"targetLanguage\";s:2:\"en\";s:6:\"tokens\";i:0;s:13:\"executionTime\";d:0;s:6:\"cached\";b:0;s:5:\"error\";N;}', 1787883311);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`, `views`) VALUES
(1, 'wifi dan username', 'wifi-dan-username', 'bi-wifi', 1, 1, '2026-07-29 02:08:21', '2026-07-29 02:31:29', NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `category_translations`
--

CREATE TABLE `category_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `language_id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(55, 1, 1, 'wifi dan username', 'wifi-dan-username', '2026-07-29 02:08:21', '2026-07-29 02:08:21'),
(56, 1, 2, 'wifi and username', 'wifi-and-username', '2026-07-29 02:08:21', '2026-07-29 02:08:21'),
(57, 1, 3, 'wifi dan ngaran pengguna', 'wifi-dan-ngaran-pengguna', '2026-07-29 02:08:21', '2026-07-29 02:08:21');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `category_id`, `icon`, `sort_order`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'bi-wifi', 1, 1, NULL, '2026-07-29 02:27:08', '2026-07-29 02:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `content_translations`
--

CREATE TABLE `content_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` longtext DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_translations`
--

INSERT INTO `content_translations` (`id`, `content_id`, `language_id`, `title`, `body`, `slug`, `created_at`, `updated_at`) VALUES
(76, 1, 1, 'cara koneksi wifi', '<p class=\"PDq2pG_selectionAnchorContainer\" data-start=\"216\" data-end=\"378\">Selamat datang di <strong data-start=\"234\" data-end=\"253\">M Bahalap Hotel</strong>. Untuk memberikan kenyamanan selama menginap, kami menyediakan akses WiFi gratis yang dapat digunakan di seluruh area hotel.</p>\r\n<h3 data-section-id=\"18mbtfg\" data-start=\"380\" data-end=\"418\">Langkah-langkah Menghubungkan WiFi</h3>\r\n<ol data-start=\"420\" data-end=\"785\">\r\n<li data-section-id=\"18b7v0a\" data-start=\"420\" data-end=\"501\">Aktifkan fitur <strong data-start=\"438\" data-end=\"446\">WiFi</strong> pada perangkat Anda (Smartphone, Tablet, atau Laptop).</li>\r\n<li data-section-id=\"jctmm9\" data-start=\"502\" data-end=\"545\">Buka daftar jaringan WiFi yang tersedia.</li>\r\n<li data-section-id=\"e5vht7\" data-start=\"546\" data-end=\"598\">Pilih jaringan WiFi hotel:<br><strong data-start=\"579\" data-end=\"598\">M Bahalap</strong></li>\r\n<li data-section-id=\"19r7hxu\" data-start=\"599\" data-end=\"703\">Masukkan kata sandi WiFi<br><strong>5StarPKY</strong></li>\r\n<li data-section-id=\"1tp6uz9\" data-start=\"704\" data-end=\"785\">Tekan <strong data-start=\"713\" data-end=\"737\">Connect / Sambungkan</strong> dan tunggu hingga perangkat berhasil terhubung.</li>\r\n</ol>\r\n<h3 data-section-id=\"18onfiz\" data-start=\"787\" data-end=\"838\">Jika Menggunakan Halaman Login (Captive Portal)</h3>\r\n<p data-start=\"840\" data-end=\"952\">Pada beberapa perangkat, halaman login akan muncul secara otomatis setelah terhubung ke WiFi. Jika tidak muncul:</p>\r\n<ul data-start=\"954\" data-end=\"1146\">\r\n<li data-section-id=\"1695pjo\" data-start=\"954\" data-end=\"1006\">Buka browser (Chrome, Edge, Safari, atau lainnya).</li>\r\n<li data-section-id=\"1ryckz\" data-start=\"1007\" data-end=\"1038\">Kunjungi sembarang situs web.</li>\r\n<li data-section-id=\"tdqvs\" data-start=\"1039\" data-end=\"1089\">Halaman login WiFi akan terbuka secara otomatis.</li>\r\n<li data-section-id=\"1pxs51g\" data-start=\"1090\" data-end=\"1146\">Masukkan informasi yang diminta, lalu tekan <strong data-start=\"1136\" data-end=\"1145\">Login</strong>.</li>\r\n</ul>\r\n<h3 data-section-id=\"qq3ho8\" data-start=\"1148\" data-end=\"1170\">Mengalami Kendala?</h3>\r\n<p data-start=\"1172\" data-end=\"1284\">Apabila Anda mengalami kesulitan saat menghubungkan perangkat ke jaringan WiFi, silakan lakukan langkah berikut:</p>\r\n<ul data-start=\"1286\" data-end=\"1480\">\r\n<li data-section-id=\"lbqvrr\" data-start=\"1286\" data-end=\"1333\">Matikan lalu aktifkan kembali WiFi perangkat.</li>\r\n<li data-section-id=\"115pj7v\" data-start=\"1334\" data-end=\"1403\">Lupakan (Forget Network) jaringan WiFi kemudian sambungkan kembali.</li>\r\n<li data-section-id=\"ebcw22\" data-start=\"1404\" data-end=\"1429\">Restart perangkat Anda.</li>\r\n<li data-section-id=\"vcy53e\" data-start=\"1430\" data-end=\"1480\">Pastikan Anda menggunakan kata sandi yang benar.</li>\r\n</ul>\r\n<p data-start=\"1482\" data-end=\"1614\">Jika masalah masih berlanjut, silakan hubungi <strong data-start=\"1528\" data-end=\"1544\">Front Office</strong> atau <strong data-start=\"1550\" data-end=\"1570\">Customer Service</strong>. Tim kami siap membantu Anda selama 24 jam.</p>\r\n<blockquote data-start=\"1616\" data-end=\"1775\">\r\n<p data-start=\"1618\" data-end=\"1775\"><strong data-start=\"1618\" data-end=\"1630\">Catatan:</strong> Demi kenyamanan bersama, gunakan jaringan WiFi hotel secara bijak dan hindari aktivitas yang melanggar hukum atau kebijakan penggunaan internet.</p>\r\n</blockquote>', 'cara-koneksi-wifi', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(77, 1, 2, 'how to connect wifi', '<p class=\"PDq2pG_selectionAnchorContainer\" data-start=\"216\" data-end=\"378\">Welcome to <strong data-start=\"234\" data-end=\"253\">M Bahalap Hotel</strong>. To provide comfort during your stay, we provide free WiFi access that can be used throughout the hotel area.</p>\r\n<h3 data-section-id=\"18mbtfg\" data-start=\"380\" data-end=\"418\">Steps to Connect WiFi</h3>\r\n<ol data-start=\"420\" data-end=\"785\">\r\n<li data-section-id=\"18b7v0a\" data-start=\"420\" data-end=\"501\">Enable the <strong data-start=\"438\" data-end=\"446\">WiFi</strong> feature on your device (Smartphone, Tablet, or Laptop).</li>\r\n<li data-section-id=\"jctmm9\" data-start=\"502\" data-end=\"545\">Open the list of available WiFi networks.</li>\r\n<li data-section-id=\"e5vht7\" data-start=\"546\" data-end=\"598\">Select the hotel\'s WiFi network:<br><strong data-start=\"579\" data-end=\"598\">M Bahalap</strong></li>\r\n<li data-section-id=\"19r7hxu\" data-start=\"599\" data-end=\"703\">Enter the WiFi password<br><strong>5StarPKY</strong></li>\r\n<li data-section-id=\"1tp6uz9\" data-start=\"704\" data-end=\"785\">Press <strong data-start=\"713\" data-end=\"737\">Connect / Connect</strong> and wait until the device is successfully connected.</li>\r\n</ol>\r\n<h3 data-section-id=\"18onfiz\" data-start=\"787\" data-end=\"838\">If Using Login Page (Captive Portal)</h3>\r\n<p data-start=\"840\" data-end=\"952\">On some devices, the login page will appear automatically after connecting to WiFi. If it doesn\'t appear:</p>\r\n<ul data-start=\"954\" data-end=\"1146\">\r\n<li data-section-id=\"1695pjo\" data-start=\"954\" data-end=\"1006\">Open a browser (Chrome, Edge, Safari, or other).</li>\r\n<li data-section-id=\"1ryckz\" data-start=\"1007\" data-end=\"1038\">Visit any website.</li>\r\n<li data-section-id=\"tdqvs\" data-start=\"1039\" data-end=\"1089\">The WiFi login page will open automatically.</li>\r\n<li data-section-id=\"1pxs51g\" data-start=\"1090\" data-end=\"1146\">Enter the requested information, then press <strong data-start=\"1136\" data-end=\"1145\">Login</strong>.</li>\r\n</ul>\r\n<h3 data-section-id=\"qq3ho8\" data-start=\"1148\" data-end=\"1170\">Having Trouble?</h3>\r\n<p data-start=\"1172\" data-end=\"1284\">If you are having trouble connecting your device to the WiFi network, please do the following:</p>\r\n<ul data-start=\"1286\" data-end=\"1480\">\r\n<li data-section-id=\"lbqvrr\" data-start=\"1286\" data-end=\"1333\">Turn off and then turn on the WiFi on your device.</li>\r\n<li data-section-id=\"115pj7v\" data-start=\"1334\" data-end=\"1403\">Forget the WiFi network and then reconnect.</li>\r\n<li data-section-id=\"ebcw22\" data-start=\"1404\" data-end=\"1429\">Restart your device.</li>\r\n<li data-section-id=\"vcy53e\" data-start=\"1430\" data-end=\"1480\">Make sure you are using the correct password.</li>\r\n</ul>\r\n<p data-start=\"1482\" data-end=\"1614\">If the problem persists, please contact <strong data-start=\"1528\" data-end=\"1544\">Front Office</strong> or <strong data-start=\"1550\" data-end=\"1570\">Customer Service</strong>. Our team is ready to help you 24 hours a day.</p>\r\n<blockquote data-start=\"1616\" data-end=\"1775\">\r\n<p data-start=\"1618\" data-end=\"1775\"><strong data-start=\"1618\" data-end=\"1630\">Note:</strong> For the comfort of all, use the hotel\'s WiFi network wisely and avoid activities that violate the law or internet usage policy.</p>\r\n</blockquote>', 'how-to-connect-wifi', '2026-07-29 02:27:08', '2026-07-29 02:27:08'),
(78, 1, 3, 'cara koneksi wifi', '<p class=\"PDq2pG_selectionAnchorContainer\" data-start=\"216\" data-end=\"378\">Selamat dumah melai <strong data-start=\"234\" data-end=\"253\">M Bahalap Hotel</strong>. Untuk memberikan kenyamanan akan ketun selama menginap, ike menyediakan akses WiFi gratis ije tau nahapa ketun melay area hotel.</p>\r\n<h3 data-section-id=\"18mbtfg\" data-start=\"380\" data-end=\"418\">Langkah-langkah Menghubungkan WiFi</h3>\r\n<ol data-start=\"420\" data-end=\"785\">\r\n<li data-section-id=\"18b7v0a\" data-start=\"420\" data-end=\"501\">Aktifkan fitur <strong data-start=\"438\" data-end=\"446\">WiFi</strong> pada perangkat Ketun (Smartphone, Tablet, atau Laptop).</li>\r\n<li data-section-id=\"jctmm9\" data-start=\"502\" data-end=\"545\">Buka daftar jaringan WiFi yang tersedia.</li>\r\n<li data-section-id=\"e5vht7\" data-start=\"546\" data-end=\"598\">Pilih jaringan WiFi hotel:<br><strong data-start=\"579\" data-end=\"598\">M Bahalap</strong></li>\r\n<li data-section-id=\"19r7hxu\" data-start=\"599\" data-end=\"703\">Masukkan kata sandi WiFi<br><strong>5StarPKY</strong></li>\r\n<li data-section-id=\"1tp6uz9\" data-start=\"704\" data-end=\"785\">Tekan <strong data-start=\"713\" data-end=\"737\">Connect / Sambungkan</strong> dan tunggu hingga perangkat berhasil terhubung.</li>\r\n</ol>\r\n<h3 data-section-id=\"18onfiz\" data-start=\"787\" data-end=\"838\">amun Tege Menggunakan Halaman Login (Captive Portal)</h3>\r\n<p data-start=\"840\" data-end=\"952\">Tege beberapa perangkat, halaman login tege je muncul secara otomatis amun jadi puji hapa ke WiFi ikeh. Amun jatun muncul:</p>\r\n<ul data-start=\"954\" data-end=\"1146\">\r\n<li data-section-id=\"1695pjo\" data-start=\"954\" data-end=\"1006\">Buka browser (Chrome, Edge, Safari, atau lainnya).</li>\r\n<li data-section-id=\"1ryckz\" data-start=\"1007\" data-end=\"1038\">Kunjungi sembarang situs web.</li>\r\n<li data-section-id=\"tdqvs\" data-start=\"1039\" data-end=\"1089\">Halaman login WiFi akan terbuka secara otomatis.</li>\r\n<li data-section-id=\"1pxs51g\" data-start=\"1090\" data-end=\"1146\">Tame informasi amun tege je nalaku ah, lalu tekan&nbsp;<strong data-start=\"1136\" data-end=\"1145\">Login</strong>.</li>\r\n</ul>\r\n<h3 data-section-id=\"qq3ho8\" data-start=\"1148\" data-end=\"1170\">Amun tege mengalamin masalah?</h3>\r\n<p data-start=\"1172\" data-end=\"1284\">Apabila Ketun mengalami kesulitan saat menghubungkan perangkat ke jaringan WiFi, coba ketun coba cara melai pendah tuh:</p>\r\n<ul data-start=\"1286\" data-end=\"1480\">\r\n<li data-section-id=\"lbqvrr\" data-start=\"1286\" data-end=\"1333\">Matikan lalu aktifkan kembali WiFi perangkat.</li>\r\n<li data-section-id=\"115pj7v\" data-start=\"1334\" data-end=\"1403\">Lupakan (Forget Network) jaringan WiFi kemudian sambungkan kembali.</li>\r\n<li data-section-id=\"ebcw22\" data-start=\"1404\" data-end=\"1429\">Restart perangkat Ketun.</li>\r\n<li data-section-id=\"vcy53e\" data-start=\"1430\" data-end=\"1480\">Pastikan Ketun menggunakan kata sandi je pass.</li>\r\n</ul>\r\n<p data-start=\"1482\" data-end=\"1614\">Amun masalah masih berlanjut, silakan hubungi <strong data-start=\"1528\" data-end=\"1544\">Front Office</strong> atau <strong data-start=\"1550\" data-end=\"1570\">Customer Service</strong>. Tim ikeh siap dohop ketun selama 24 jam.</p>\r\n<blockquote data-start=\"1616\" data-end=\"1775\">\r\n<p data-start=\"1618\" data-end=\"1775\"><strong data-start=\"1618\" data-end=\"1630\">Catatan:</strong> Akan kenyamanan itah, gunakan jaringan WiFi hotel tuh secara bijak dan hindari aktivitas yang melanggar hukum atau kebijakan penggunaan internet.</p>\r\n</blockquote>', 'cara-koneksi-wifi', '2026-07-29 02:27:08', '2026-07-29 02:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_device_logs`
--

CREATE TABLE `guest_device_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `device` varchar(50) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_device_logs`
--

INSERT INTO `guest_device_logs` (`id`, `device`, `ip_address`, `created_at`, `updated_at`) VALUES
(147, 'Mobile', '127.0.0.1', '2026-07-29 02:27:26', '2026-07-29 02:27:26'),
(148, 'Mobile', '127.0.0.1', '2026-07-29 02:27:37', '2026-07-29 02:27:37'),
(149, 'Mobile', '127.0.0.1', '2026-07-29 02:30:43', '2026-07-29 02:30:43'),
(150, 'Mobile', '127.0.0.1', '2026-07-29 02:31:29', '2026-07-29 02:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `guest_favorites`
--

CREATE TABLE `guest_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_language_logs`
--

CREATE TABLE `guest_language_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_language_logs`
--

INSERT INTO `guest_language_logs` (`id`, `language_name`, `ip_address`, `created_at`, `updated_at`) VALUES
(287, 'Indo', '127.0.0.1', '2026-07-29 02:05:29', '2026-07-29 02:05:29'),
(288, 'Indo', '127.0.0.1', '2026-07-29 02:05:45', '2026-07-29 02:05:45'),
(289, 'Indo', '127.0.0.1', '2026-07-29 02:27:17', '2026-07-29 02:27:17'),
(290, 'Indo', '127.0.0.1', '2026-07-29 02:27:26', '2026-07-29 02:27:26'),
(291, 'Dayak', '127.0.0.1', '2026-07-29 02:27:37', '2026-07-29 02:27:37'),
(292, 'Dayak', '127.0.0.1', '2026-07-29 02:30:43', '2026-07-29 02:30:43'),
(293, 'Dayak', '127.0.0.1', '2026-07-29 02:31:28', '2026-07-29 02:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `guest_views`
--

CREATE TABLE `guest_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_views`
--

INSERT INTO `guest_views` (`id`, `category_id`, `category_name`, `ip_address`, `created_at`, `updated_at`) VALUES
(178, 1, 'wifi dan username', '127.0.0.1', '2026-07-29 02:27:26', '2026-07-29 02:27:26'),
(179, 1, 'wifi dan username', '127.0.0.1', '2026-07-29 02:27:37', '2026-07-29 02:27:37'),
(180, 1, 'wifi dan username', '127.0.0.1', '2026-07-29 02:30:43', '2026-07-29 02:30:43'),
(181, 1, 'wifi dan username', '127.0.0.1', '2026-07-29 02:31:28', '2026-07-29 02:31:28');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `native_name` varchar(100) NOT NULL,
  `flag` varchar(20) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `native_name`, `flag`, `is_default`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bahasa Indonesia', 'id', 'Bahasa Indonesia', '🇮🇩', 1, 1, 1, '2026-07-08 01:19:14', '2026-07-08 01:19:14', NULL),
(2, 'English', 'en', 'English', '🇺🇸', 0, 1, 2, '2026-07-08 01:19:14', '2026-07-08 01:19:14', NULL),
(3, 'Dayak Ngaju', 'da', 'Dayak Ngaju', 'DA', 0, 1, 3, '2026-07-08 01:19:14', '2026-07-10 13:34:15', NULL),
(4, 'jepang', 'jp', 'jepang', 'jp', 0, 0, 4, '2026-07-27 08:45:47', '2026-07-28 05:04:09', '2026-07-28 05:04:09'),
(5, 'bahasa china', 'ch', 'china', 'ch', 0, 0, 5, '2026-07-28 01:14:19', '2026-07-28 05:04:01', '2026-07-28 05:04:01'),
(6, 'bahasa korea', 'ks', 'korea selatan', 'ks', 0, 0, 6, '2026-07-28 01:37:24', '2026-07-28 02:04:20', '2026-07-28 02:04:20'),
(7, 'korea', 'ku', 'korea utara', 'ku', 0, 0, 7, '2026-07-28 01:41:57', '2026-07-28 02:04:29', '2026-07-28 02:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(50) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `content_id`, `file_name`, `file_path`, `file_type`, `mime_type`, `file_size`, `alt_text`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, '1785292344_love.jpg', 'uploads/1785292344_love.jpg', 'jpg', 'image/jpeg', 30173, 'contoh', 0, '2026-07-29 02:32:24', '2026-07-29 02:32:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_30_043240_create_contents_table', 1),
(5, '2026_06_30_075104_create_languages_table', 1),
(6, '2026_06_30_080551_create_categories_table', 1),
(7, '2026_06_30_081933_create_settings_table', 1),
(8, '2026_06_30_082729_create_activity_logs_table', 1),
(9, '2026_06_30_141636_add_role_to_users_table', 1),
(10, '2026_06_30_143246_create_media_table', 1),
(11, '2026_07_01_062909_add_description_to_categories_table', 2),
(12, '2026_07_01_065515_remove_thumbnail_from_categories_table', 3),
(13, '2026_07_02_071142_create_category_translations_table', 3),
(14, '2026_07_06_065849_create_ai_api_keys_table', 3),
(15, '2026_07_06_154725_create_content_translations_table', 3),
(16, '2026_07_11_130504_add_deleted_at_to_media_table', 4),
(17, '2026_07_15_104452_create_setting_translations_table', 5),
(18, '2026_07_16_145916_add_slug_to_contents_table', 6),
(20, '2026_07_21_145150_create_guest_views_table', 7),
(21, '2026_07_21_151226_create_guest_language_logs_table', 8),
(22, '2026_07_23_090255_create_guest_device_logs_table', 9),
(23, '2026_07_23_091708_create_guest_favorites_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5tfmGjZpZXgviYeIdZXhryIw2eY4e7367FiaVIPD', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZldyWEs1U1NkZ3Z3UmlsVHZWSGVsV1ZNMnNzSFA1cXhDYm56eU9KZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2NhdGVnb3JpZXMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1785230052),
('Ac9olRkhIVtmr2L1PEww38Ecntef9a7zt2f6Fgtw', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFljNlU2UHVNRjZCS1BHcmx1NnE2VUdKcjJqTW5iRldoQjB0RnFKaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jYXRlZ29yeS9hcmVhLXJva29rP2xhbmc9aWQiO3M6NToicm91dGUiO3M6MTQ6Imd1ZXN0LmNhdGVnb3J5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785289665),
('s33rcqCyWG6CIs5FBzXCegN8NC9SNomhIrebvS4X', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTmROaFI3ZjJkbWx4UFdEUGlIUk9YWHlVbEtycDBjVkJIeGhZNHJZRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1785230183),
('xiRsINfBJ5x8WxnkaOOQRFjxOKN8ZanV4tz2G7nN', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiWHdFckk2WEpQaDlMMzFLQWVsOGtDQlNnR3hSekpIMVNBeGRrWmZlViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6MjA6ImFwcF9saWNlbnNlX3VubG9ja2VkIjtiOjE7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo0OiJsYW5nIjtzOjI6ImlkIjt9', 1785292358);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` enum('text','textarea','image','email','phone','url','boolean') NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `is_public`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'hotel_name', 'M Bahalap Hotel', 'text', 'hotel', 'Nama Hotel', 'Nama resmi hotel (tampil di bawah logo)', 1, 2, '2026-07-08 01:19:14', '2026-07-15 08:14:57'),
(2, 'hotel_logo', 'uploads/1784017594_WhatsApp Image 2026-05-21 at 15.37.43.jpeg', 'image', 'hotel', 'Logo Hotel', 'Logo utama hotel (tampil di paling atas)', 1, 1, '2026-07-08 01:19:14', '2026-07-15 08:14:57'),
(3, 'hotel_description', 'Merupakan suatu kehormatan bagi k﻿ami menerima Anda di sini dan kami berharap Anda mendapatkan pengalaman menginap yang sangat menyenangkan. Selamat menikmatin fasilitas hotel', 'textarea', 'hotel', 'Deskripsi Sambutan', 'Teks paragraf di bawah garis pembatas', 1, 4, '2026-07-08 01:19:14', '2026-07-16 02:58:37'),
(4, 'hotel_phone', '82158881288', 'phone', 'contact', 'Nomor Telepon', '', 1, 5, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(5, 'hotel_email', 'mbahalaphotel@pky.com', 'email', 'contact', 'Email Hotel', '', 1, 6, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(6, 'hotel_address', 'Jln RTA', 'textarea', 'contact', 'Alamat Hotel', '', 1, 7, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(7, 'hotel_whatsapp', '82158881288', 'phone', 'contact', 'WhatsApp Reception', '', 1, 8, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(8, 'instagram', NULL, 'url', 'social', 'Instagram', '', 1, 9, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(9, 'facebook', NULL, 'url', 'social', 'Facebook', '', 1, 10, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(10, 'youtube', NULL, 'url', 'social', 'YouTube', '', 1, 11, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(11, 'footer_text', '© M Bahalap Hotel', 'text', 'website', 'Footer Website', '', 1, 12, '2026-07-08 01:19:14', '2026-07-14 03:00:03'),
(12, 'hotel_background', 'uploads/1784081812_ChatGPT Image Jul 15, 2026, 09_02_46 AM (1).png', 'image', 'hotel', 'Background Utama', 'Gambar latar belakang halaman depan tamu', 1, 5, '2026-07-14 01:57:50', '2026-07-15 08:14:57'),
(13, 'hotel_welcome_title', 'Selamat Datang di M Bahalap Hotel', 'text', 'hotel', 'Judul Selamat Datang', 'Teks utama sambutan (Teks Tebal)', 1, 3, '2026-07-14 02:32:11', '2026-07-15 08:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `setting_translations`
--

CREATE TABLE `setting_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `language_id` bigint(20) UNSIGNED NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting_translations`
--

INSERT INTO `setting_translations` (`id`, `setting_id`, `language_id`, `value`, `created_at`, `updated_at`) VALUES
(2, 3, 2, 'It is an honor for us to welcome you here, and we hope you have a very pleasant stay. Enjoy the hotel facilities', '2026-07-15 08:14:57', '2026-07-16 02:58:38'),
(3, 13, 2, 'Welcome to M Bahalap Hotel', '2026-07-15 08:14:57', '2026-07-16 01:28:49'),
(5, 3, 3, 'Mangat kahormatan je ganal akan ikei manarima ikau intu hetoh, tuntang ikei maharap ikau mandino pangalaman manginap je sasar manyanang. Sanang manyana fasilitas hotel.', '2026-07-15 08:14:57', '2026-07-16 02:58:38'),
(6, 13, 3, 'Selamat Dumah Melai M Bahalap Hotel', '2026-07-15 08:14:57', '2026-07-16 01:28:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(225) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `avatar`, `password`, `role`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'paisal johen', 'johenfaisal3@gmail.com', NULL, 'avatars/ranHDslE5z49VtNAjCdnm1YXCvwBugymLQ5F9iEy.jpg', '$2y$12$YKw0e.kIGry29yhX1szpd.TV.MBcySg/EPWBzbZLzlaciv3cRvuP6', 'super_admin', 1, NULL, 'Yn6evHsFGlbsAjY5CyV31i4Xw31RcVRBLzfAgpuYpWKe7uIELR8O274PCNcY', '2026-07-08 01:19:13', '2026-07-28 08:43:58'),
(2, 'admin OP', 'admin@mbahalaphotel.com', NULL, NULL, '$2y$12$A.3zuoJ8tlG1CSk0PK0KLus6RUvMDINegqQck/7a.XrPLK04vvlZS', 'admin', 1, NULL, NULL, '2026-07-08 01:19:14', '2026-07-23 07:33:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translations_category_id_language_id_unique` (`category_id`,`language_id`),
  ADD UNIQUE KEY `category_translations_language_id_slug_unique` (`language_id`,`slug`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_translations`
--
ALTER TABLE `content_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guest_device_logs`
--
ALTER TABLE `guest_device_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_favorites`
--
ALTER TABLE `guest_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_language_logs`
--
ALTER TABLE `guest_language_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_views`
--
ALTER TABLE `guest_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_views_category_id_foreign` (`category_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_code_unique` (`code`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_content_id_foreign` (`content_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `setting_translations`
--
ALTER TABLE `setting_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setting_translations_setting_id_foreign` (`setting_id`),
  ADD KEY `setting_translations_language_id_foreign` (`language_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=673;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `content_translations`
--
ALTER TABLE `content_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest_device_logs`
--
ALTER TABLE `guest_device_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `guest_favorites`
--
ALTER TABLE `guest_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `guest_language_logs`
--
ALTER TABLE `guest_language_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `guest_views`
--
ALTER TABLE `guest_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `setting_translations`
--
ALTER TABLE `setting_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_translations`
--
ALTER TABLE `category_translations`
  ADD CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guest_views`
--
ALTER TABLE `guest_views`
  ADD CONSTRAINT `guest_views_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_content_id_foreign` FOREIGN KEY (`content_id`) REFERENCES `contents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `setting_translations`
--
ALTER TABLE `setting_translations`
  ADD CONSTRAINT `setting_translations_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `setting_translations_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
