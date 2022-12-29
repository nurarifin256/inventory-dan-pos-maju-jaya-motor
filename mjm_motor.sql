-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Des 2022 pada 08.58
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mjm_motor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akuns`
--

CREATE TABLE `akuns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categori_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(8,2) NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barangs`
--

INSERT INTO `barangs` (`id`, `categori_id`, `nama`, `harga`, `created_by`, `updated_by`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 5, 'Aki', '75000.00', 'Agus', 'Agus', 0, '2022-11-17 06:27:51', '2022-11-18 04:04:59'),
(3, 6, 'Busi', '15000.00', 'Agus', 'Agus', 0, '2022-11-22 07:33:28', '2022-11-22 07:33:28'),
(4, 6, 'Velg', '250000.00', 'Agus', 'Agus', 0, '2022-12-02 09:13:49', '2022-12-02 09:13:49'),
(5, 5, 'Oli Mesin', '47000.00', 'Agus', 'Agus', 0, '2022-12-03 05:48:20', '2022-12-03 05:48:20'),
(6, 1, 'Spray Paint', '15000.00', 'Agus', 'Agus', 0, '2022-12-09 09:40:53', '2022-12-09 09:40:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluars`
--

CREATE TABLE `barang_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `no_barang_keluar` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_keluars`
--

INSERT INTO `barang_keluars` (`id`, `pelanggan_id`, `no_barang_keluar`, `total`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(44, 0, '29/12/22/1', '188000.00', 0, 'Agus', 'Agus', '2022-12-29 04:11:05', '2022-12-29 04:11:05'),
(45, 1, '29/12/22/2', '235000.00', 0, 'Agus', 'Agus', '2022-12-28 04:27:49', '2022-12-29 04:27:49'),
(46, 0, '29/12/22/3', '30000.00', 0, 'Agus', 'Agus', '2022-12-29 07:03:35', '2022-12-29 07:03:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar_details`
--

CREATE TABLE `barang_keluar_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_keluar_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `merek_id` bigint(20) UNSIGNED NOT NULL,
  `qty` bigint(20) NOT NULL,
  `not_in` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_keluar_details`
--

INSERT INTO `barang_keluar_details` (`id`, `barang_keluar_id`, `barang_id`, `merek_id`, `qty`, `not_in`, `created_by`, `updated_by`, `trashed`, `created_at`, `updated_at`) VALUES
(72, 44, 5, 4, 2, '5_4', 'Agus', 'Agus', 0, '2022-12-29 04:11:05', NULL),
(73, 44, 5, 5, 2, '5_5', 'Agus', 'Agus', 0, '2022-12-29 04:11:05', NULL),
(74, 45, 5, 4, 5, '5_4', 'Agus', 'Agus', 0, '2022-12-29 04:27:50', NULL),
(75, 46, 3, 2, 2, '3_2', 'Agus', 'Agus', 0, '2022-12-29 07:03:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuks`
--

CREATE TABLE `barang_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `no_barang_masuk` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_masuks`
--

INSERT INTO `barang_masuks` (`id`, `supplier_id`, `no_barang_masuk`, `status`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(112, 5, '28/12/22/1', 1, 0, 'Agus', 'Agus', '2022-12-28 09:18:42', '2022-12-28 09:19:17'),
(113, 4, '28/12/22/2', 1, 0, 'Agus', 'Agus', '2022-12-26 09:19:00', '2022-12-28 09:19:25'),
(114, 4, '28/12/22/3', 1, 0, 'Agus', 'Agus', '2022-12-27 09:20:18', '2022-12-28 09:20:31'),
(115, 1, '29/12/22/1', 1, 0, 'Agus', 'Agus', '2022-12-29 07:02:03', '2022-12-29 07:02:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_details`
--

CREATE TABLE `barang_masuk_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_masuk_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `merek_id` bigint(20) UNSIGNED NOT NULL,
  `locator_id` bigint(20) NOT NULL DEFAULT 0,
  `qty` bigint(20) NOT NULL,
  `not_in` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_masuk_details`
--

INSERT INTO `barang_masuk_details` (`id`, `barang_masuk_id`, `barang_id`, `merek_id`, `locator_id`, `qty`, `not_in`, `trashed`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(158, 112, 5, 4, 1, 8, '5_4', 0, 0, 'Agus', 'Agus', '2022-12-28 09:18:42', '2022-12-28 09:19:17'),
(159, 112, 5, 5, 4, 8, '5_5', 0, 0, 'Agus', 'Agus', '2022-12-28 09:18:42', '2022-12-28 09:19:17'),
(160, 113, 5, 4, 1, 5, '5_4', 0, 0, 'Agus', 'Agus', '2022-12-28 09:19:00', '2022-12-28 09:19:25'),
(161, 114, 5, 5, 4, 5, '5_5', 0, 0, 'Agus', 'Agus', '2022-12-28 09:20:18', '2022-12-28 09:20:31'),
(162, 115, 3, 2, 5, 18, '3_2', 0, 0, 'Agus', 'Agus', '2022-12-29 07:02:03', '2022-12-29 07:02:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_detail_laporans`
--

CREATE TABLE `barang_masuk_detail_laporans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_masuk_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `merek_id` bigint(20) UNSIGNED NOT NULL,
  `qty` bigint(20) NOT NULL,
  `not_in` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang_masuk_detail_laporans`
--

INSERT INTO `barang_masuk_detail_laporans` (`id`, `barang_masuk_id`, `barang_id`, `merek_id`, `qty`, `not_in`, `trashed`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(18, 112, 5, 4, 10, '5_4', 0, 0, 'Agus', 'Agus', '2022-12-28 09:18:42', NULL),
(19, 112, 5, 5, 10, '5_5', 0, 0, 'Agus', 'Agus', '2022-12-28 09:18:42', NULL),
(20, 113, 5, 4, 10, '5_4', 0, 0, 'Agus', 'Agus', '2022-12-16 09:22:49', NULL),
(21, 114, 5, 5, 5, '5_5', 0, 0, 'Agus', 'Agus', '2022-12-27 09:20:18', NULL),
(22, 115, 3, 2, 20, '3_2', 0, 0, 'Agus', 'Agus', '2022-12-29 07:02:03', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ijins`
--

CREATE TABLE `ijins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aksi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ijins`
--

INSERT INTO `ijins` (`id`, `name`, `aksi`, `created_at`, `updated_at`) VALUES
(33, 'Jabatan', 'tambah', '2022-11-11 03:48:57', '2022-11-11 03:48:57'),
(40, 'Akun', 'lihat', '2022-11-11 07:13:16', '2022-11-11 07:13:16'),
(50, 'Akun', 'tambah', '2022-11-11 07:51:11', '2022-11-11 07:51:11'),
(51, 'Akun', 'ubah', '2022-11-11 07:51:13', '2022-11-11 07:51:13'),
(52, 'Akun', 'hapus', '2022-11-11 07:51:15', '2022-11-11 07:51:15'),
(59, 'Rak', 'lihat', '2022-11-11 08:38:15', '2022-11-11 08:38:15'),
(60, 'Rak', 'tambah', '2022-11-11 09:12:26', '2022-11-11 09:12:26'),
(61, 'Rak', 'ubah', '2022-11-11 09:23:10', '2022-11-11 09:23:10'),
(62, 'Rak', 'hapus', '2022-11-11 09:23:13', '2022-11-11 09:23:13'),
(63, 'Level', 'lihat', '2022-11-12 13:07:49', '2022-11-12 13:07:49'),
(65, 'Level', 'ubah', '2022-11-12 13:07:53', '2022-11-12 13:07:53'),
(66, 'Level', 'hapus', '2022-11-12 13:07:55', '2022-11-12 13:07:55'),
(67, 'Level', 'tambah', '2022-11-12 13:46:08', '2022-11-12 13:46:08'),
(68, 'Locator', 'lihat', '2022-11-13 06:04:43', '2022-11-13 06:04:43'),
(69, 'Locator', 'tambah', '2022-11-13 06:49:09', '2022-11-13 06:49:09'),
(70, 'Locator', 'ubah', '2022-11-13 07:41:10', '2022-11-13 07:41:10'),
(71, 'Locator', 'hapus', '2022-11-13 07:41:19', '2022-11-13 07:41:19'),
(72, 'Kategori Barang', 'lihat', '2022-11-14 02:24:19', '2022-11-14 02:24:19'),
(73, 'Kategori Barang', 'tambah', '2022-11-14 02:24:21', '2022-11-14 02:24:21'),
(74, 'Kategori Barang', 'ubah', '2022-11-14 02:24:22', '2022-11-14 02:24:22'),
(75, 'Kategori Barang', 'hapus', '2022-11-14 02:24:26', '2022-11-14 02:24:26'),
(76, 'Supplier', 'lihat', '2022-11-14 03:45:53', '2022-11-14 03:45:53'),
(77, 'Supplier', 'tambah', '2022-11-14 03:45:55', '2022-11-14 03:45:55'),
(78, 'Supplier', 'ubah', '2022-11-14 03:45:57', '2022-11-14 03:45:57'),
(79, 'Supplier', 'hapus', '2022-11-14 03:45:58', '2022-11-14 03:45:58'),
(80, 'Merek Barang', 'lihat', '2022-11-14 07:01:37', '2022-11-14 07:01:37'),
(81, 'Merek Barang', 'tambah', '2022-11-14 07:01:38', '2022-11-14 07:01:38'),
(82, 'Merek Barang', 'ubah', '2022-11-14 07:01:40', '2022-11-14 07:01:40'),
(83, 'Merek Barang', 'hapus', '2022-11-14 07:01:44', '2022-11-14 07:01:44'),
(84, 'Barang', 'lihat', '2022-11-14 08:34:43', '2022-11-14 08:34:43'),
(85, 'Barang', 'tambah', '2022-11-14 08:34:45', '2022-11-14 08:34:45'),
(86, 'Barang', 'ubah', '2022-11-14 08:34:46', '2022-11-14 08:34:46'),
(87, 'Barang', 'hapus', '2022-11-14 08:34:48', '2022-11-14 08:34:48'),
(88, 'Transaksi', 'lihat', '2022-11-18 04:10:22', '2022-11-18 04:10:22'),
(89, 'Barang Masuk', 'lihat', '2022-11-18 04:11:53', '2022-11-18 04:11:53'),
(90, 'Barang Masuk', 'tambah', '2022-11-18 04:11:55', '2022-11-18 04:11:55'),
(91, 'Barang Masuk', 'ubah', '2022-11-18 04:11:56', '2022-11-18 04:11:56'),
(92, 'Barang Masuk', 'hapus', '2022-11-18 04:11:59', '2022-11-18 04:11:59'),
(93, 'Staging Area', 'lihat', '2022-12-07 02:15:52', '2022-12-07 02:15:52'),
(94, 'Staging Area', 'tambah', '2022-12-07 02:15:54', '2022-12-07 02:15:54'),
(95, 'Staging Area', 'ubah', '2022-12-07 02:15:57', '2022-12-07 02:15:57'),
(96, 'Staging Area', 'hapus', '2022-12-07 02:15:59', '2022-12-07 02:15:59'),
(97, 'Stok', 'lihat', '2022-12-09 02:41:26', '2022-12-09 02:41:26'),
(98, 'Stok', 'tambah', '2022-12-09 02:41:28', '2022-12-09 02:41:28'),
(99, 'Stok', 'ubah', '2022-12-09 02:41:30', '2022-12-09 02:41:30'),
(100, 'Stok', 'hapus', '2022-12-09 02:41:31', '2022-12-09 02:41:31'),
(101, 'Pindah Locator', 'lihat', '2022-12-10 12:44:49', '2022-12-10 12:44:49'),
(102, 'Pindah Locator', 'tambah', '2022-12-10 12:44:52', '2022-12-10 12:44:52'),
(103, 'Pindah Locator', 'ubah', '2022-12-10 12:44:53', '2022-12-10 12:44:53'),
(104, 'Pindah Locator', 'hapus', '2022-12-10 12:44:55', '2022-12-10 12:44:55'),
(131, 'Inventory', 'lihat', '2022-12-27 08:32:39', '2022-12-27 08:32:39'),
(137, 'Point Of Sales', 'lihat', '2022-12-29 07:41:53', '2022-12-29 07:41:53'),
(141, 'Kasir', 'lihat', '2022-12-29 07:42:01', '2022-12-29 07:42:01'),
(142, 'Kasir', 'tambah', '2022-12-29 07:42:03', '2022-12-29 07:42:03'),
(143, 'Kasir', 'ubah', '2022-12-29 07:42:04', '2022-12-29 07:42:04'),
(144, 'Kasir', 'hapus', '2022-12-29 07:42:08', '2022-12-29 07:42:08'),
(145, 'Pelanggan', 'lihat', '2022-12-29 07:42:10', '2022-12-29 07:42:10'),
(146, 'Pelanggan', 'tambah', '2022-12-29 07:42:12', '2022-12-29 07:42:12'),
(147, 'Pelanggan', 'ubah', '2022-12-29 07:42:14', '2022-12-29 07:42:14'),
(148, 'Pelanggan', 'hapus', '2022-12-29 07:42:16', '2022-12-29 07:42:16'),
(149, 'Inventory', 'lihat', '2022-12-29 07:42:34', '2022-12-29 07:42:34'),
(150, 'Stok', 'lihat', '2022-12-29 07:42:45', '2022-12-29 07:42:45'),
(154, 'Akses Managemen', 'lihat', '2022-12-29 07:45:45', '2022-12-29 07:45:45'),
(155, 'Jabatan', 'lihat', '2022-12-29 07:45:51', '2022-12-29 07:45:51'),
(156, 'Jabatan', 'ubah', '2022-12-29 07:45:53', '2022-12-29 07:45:53'),
(157, 'Jabatan', 'hapus', '2022-12-29 07:45:54', '2022-12-29 07:45:54'),
(158, 'Akun', 'lihat', '2022-12-29 07:45:57', '2022-12-29 07:45:57'),
(159, 'Akun', 'tambah', '2022-12-29 07:45:58', '2022-12-29 07:45:58'),
(160, 'Akun', 'ubah', '2022-12-29 07:46:00', '2022-12-29 07:46:00'),
(161, 'Akun', 'hapus', '2022-12-29 07:46:02', '2022-12-29 07:46:02'),
(162, 'Menu Managemen', 'lihat', '2022-12-29 07:46:04', '2022-12-29 07:46:04'),
(163, 'Menu Managemen', 'tambah', '2022-12-29 07:46:07', '2022-12-29 07:46:07'),
(164, 'Menu Managemen', 'ubah', '2022-12-29 07:46:09', '2022-12-29 07:46:09'),
(165, 'Menu Managemen', 'hapus', '2022-12-29 07:46:10', '2022-12-29 07:46:10'),
(166, 'Inventory', 'lihat', '2022-12-29 07:46:13', '2022-12-29 07:46:13'),
(167, 'Locator', 'lihat', '2022-12-29 07:46:17', '2022-12-29 07:46:17'),
(168, 'Locator', 'tambah', '2022-12-29 07:46:19', '2022-12-29 07:46:19'),
(169, 'Locator', 'ubah', '2022-12-29 07:46:20', '2022-12-29 07:46:20'),
(170, 'Locator', 'hapus', '2022-12-29 07:46:21', '2022-12-29 07:46:21'),
(171, 'Rak', 'lihat', '2022-12-29 07:46:23', '2022-12-29 07:46:23'),
(172, 'Rak', 'tambah', '2022-12-29 07:46:24', '2022-12-29 07:46:24'),
(173, 'Rak', 'ubah', '2022-12-29 07:46:26', '2022-12-29 07:46:26'),
(174, 'Rak', 'hapus', '2022-12-29 07:46:27', '2022-12-29 07:46:27'),
(175, 'Level', 'lihat', '2022-12-29 07:46:29', '2022-12-29 07:46:29'),
(176, 'Level', 'tambah', '2022-12-29 07:46:31', '2022-12-29 07:46:31'),
(177, 'Level', 'ubah', '2022-12-29 07:46:33', '2022-12-29 07:46:33'),
(178, 'Level', 'hapus', '2022-12-29 07:46:34', '2022-12-29 07:46:34'),
(179, 'Kategori Barang', 'lihat', '2022-12-29 07:46:36', '2022-12-29 07:46:36'),
(180, 'Kategori Barang', 'tambah', '2022-12-29 07:46:38', '2022-12-29 07:46:38'),
(181, 'Kategori Barang', 'ubah', '2022-12-29 07:46:40', '2022-12-29 07:46:40'),
(182, 'Kategori Barang', 'hapus', '2022-12-29 07:46:41', '2022-12-29 07:46:41'),
(183, 'Supplier', 'lihat', '2022-12-29 07:46:44', '2022-12-29 07:46:44'),
(184, 'Supplier', 'tambah', '2022-12-29 07:46:45', '2022-12-29 07:46:45'),
(185, 'Supplier', 'ubah', '2022-12-29 07:46:47', '2022-12-29 07:46:47'),
(186, 'Supplier', 'hapus', '2022-12-29 07:46:48', '2022-12-29 07:46:48'),
(187, 'Merek Barang', 'lihat', '2022-12-29 07:46:50', '2022-12-29 07:46:50'),
(188, 'Merek Barang', 'tambah', '2022-12-29 07:46:51', '2022-12-29 07:46:51'),
(189, 'Merek Barang', 'ubah', '2022-12-29 07:46:54', '2022-12-29 07:46:54'),
(190, 'Merek Barang', 'hapus', '2022-12-29 07:46:55', '2022-12-29 07:46:55'),
(191, 'Barang', 'lihat', '2022-12-29 07:47:00', '2022-12-29 07:47:00'),
(192, 'Barang', 'tambah', '2022-12-29 07:47:01', '2022-12-29 07:47:01'),
(193, 'Barang', 'ubah', '2022-12-29 07:47:04', '2022-12-29 07:47:04'),
(194, 'Barang', 'hapus', '2022-12-29 07:47:05', '2022-12-29 07:47:05'),
(195, 'Transaksi', 'lihat', '2022-12-29 07:47:13', '2022-12-29 07:47:13'),
(196, 'Barang Masuk', 'lihat', '2022-12-29 07:47:15', '2022-12-29 07:47:15'),
(197, 'Barang Masuk', 'tambah', '2022-12-29 07:47:16', '2022-12-29 07:47:16'),
(198, 'Barang Masuk', 'ubah', '2022-12-29 07:47:17', '2022-12-29 07:47:17'),
(199, 'Barang Masuk', 'hapus', '2022-12-29 07:47:19', '2022-12-29 07:47:19'),
(200, 'Staging Area', 'lihat', '2022-12-29 07:47:22', '2022-12-29 07:47:22'),
(201, 'Staging Area', 'tambah', '2022-12-29 07:47:23', '2022-12-29 07:47:23'),
(202, 'Staging Area', 'ubah', '2022-12-29 07:47:25', '2022-12-29 07:47:25'),
(203, 'Staging Area', 'hapus', '2022-12-29 07:47:26', '2022-12-29 07:47:26'),
(204, 'Stok', 'lihat', '2022-12-29 07:47:30', '2022-12-29 07:47:30'),
(205, 'Stok', 'tambah', '2022-12-29 07:47:33', '2022-12-29 07:47:33'),
(206, 'Stok', 'ubah', '2022-12-29 07:47:35', '2022-12-29 07:47:35'),
(207, 'Stok', 'hapus', '2022-12-29 07:47:36', '2022-12-29 07:47:36'),
(208, 'Pindah Locator', 'lihat', '2022-12-29 07:47:38', '2022-12-29 07:47:38'),
(209, 'Pindah Locator', 'tambah', '2022-12-29 07:47:40', '2022-12-29 07:47:40'),
(210, 'Pindah Locator', 'ubah', '2022-12-29 07:47:41', '2022-12-29 07:47:41'),
(211, 'Pindah Locator', 'hapus', '2022-12-29 07:47:43', '2022-12-29 07:47:43'),
(212, 'Laporan', 'lihat', '2022-12-29 07:47:45', '2022-12-29 07:47:45'),
(213, 'Laporan Barang Masuk', 'lihat', '2022-12-29 07:47:48', '2022-12-29 07:47:48'),
(214, 'Laporan Barang Masuk', 'tambah', '2022-12-29 07:47:50', '2022-12-29 07:47:50'),
(215, 'Laporan Barang Masuk', 'ubah', '2022-12-29 07:47:51', '2022-12-29 07:47:51'),
(216, 'Laporan Barang Masuk', 'hapus', '2022-12-29 07:47:52', '2022-12-29 07:47:52'),
(217, 'Point Of Sales', 'lihat', '2022-12-29 07:48:01', '2022-12-29 07:48:01'),
(218, 'Kasir', 'lihat', '2022-12-29 07:48:06', '2022-12-29 07:48:06'),
(219, 'Kasir', 'tambah', '2022-12-29 07:48:08', '2022-12-29 07:48:08'),
(220, 'Kasir', 'ubah', '2022-12-29 07:48:09', '2022-12-29 07:48:09'),
(221, 'Kasir', 'hapus', '2022-12-29 07:48:10', '2022-12-29 07:48:10'),
(222, 'Pelanggan', 'lihat', '2022-12-29 07:48:12', '2022-12-29 07:48:12'),
(223, 'Pelanggan', 'tambah', '2022-12-29 07:48:14', '2022-12-29 07:48:14'),
(224, 'Pelanggan', 'ubah', '2022-12-29 07:48:16', '2022-12-29 07:48:16'),
(225, 'Pelanggan', 'hapus', '2022-12-29 07:48:17', '2022-12-29 07:48:17'),
(226, 'Laporan Barang Keluar', 'lihat', '2022-12-29 07:48:21', '2022-12-29 07:48:21'),
(227, 'Laporan Barang Keluar', 'tambah', '2022-12-29 07:48:23', '2022-12-29 07:48:23'),
(228, 'Laporan Barang Keluar', 'ubah', '2022-12-29 07:48:24', '2022-12-29 07:48:24'),
(229, 'Laporan Barang Keluar', 'hapus', '2022-12-29 07:48:26', '2022-12-29 07:48:26'),
(230, 'Barang', 'lihat', '2022-12-29 07:52:08', '2022-12-29 07:52:08'),
(234, 'Akses Managemen', 'lihat', '2022-12-29 07:53:50', '2022-12-29 07:53:50'),
(235, 'Jabatan', 'lihat', '2022-12-29 07:54:03', '2022-12-29 07:54:03'),
(236, 'Jabatan', 'tambah', '2022-12-29 07:54:04', '2022-12-29 07:54:04'),
(237, 'Jabatan', 'ubah', '2022-12-29 07:54:06', '2022-12-29 07:54:06'),
(238, 'Jabatan', 'hapus', '2022-12-29 07:54:07', '2022-12-29 07:54:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ijin_jabatans`
--

CREATE TABLE `ijin_jabatans` (
  `ijin_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ijin_jabatans`
--

INSERT INTO `ijin_jabatans` (`ijin_id`, `jabatan_id`, `created_at`, `updated_at`) VALUES
(33, 6, '2022-11-11 03:48:57', '2022-11-11 03:48:57'),
(40, 4, '2022-11-11 07:13:16', '2022-11-11 07:13:16'),
(50, 4, '2022-11-11 07:51:11', '2022-11-11 07:51:11'),
(51, 4, '2022-11-11 07:51:13', '2022-11-11 07:51:13'),
(52, 4, '2022-11-11 07:51:15', '2022-11-11 07:51:15'),
(59, 4, '2022-11-11 08:38:15', '2022-11-11 08:38:15'),
(60, 4, '2022-11-11 09:12:26', '2022-11-11 09:12:26'),
(61, 4, '2022-11-11 09:23:10', '2022-11-11 09:23:10'),
(62, 4, '2022-11-11 09:23:13', '2022-11-11 09:23:13'),
(63, 4, '2022-11-12 13:07:49', '2022-11-12 13:07:49'),
(65, 4, '2022-11-12 13:07:53', '2022-11-12 13:07:53'),
(66, 4, '2022-11-12 13:07:55', '2022-11-12 13:07:55'),
(67, 4, '2022-11-12 13:46:08', '2022-11-12 13:46:08'),
(68, 4, '2022-11-13 06:04:43', '2022-11-13 06:04:43'),
(69, 4, '2022-11-13 06:49:09', '2022-11-13 06:49:09'),
(70, 4, '2022-11-13 07:41:12', '2022-11-13 07:41:12'),
(71, 4, '2022-11-13 07:41:19', '2022-11-13 07:41:19'),
(72, 4, '2022-11-14 02:24:19', '2022-11-14 02:24:19'),
(73, 4, '2022-11-14 02:24:21', '2022-11-14 02:24:21'),
(74, 4, '2022-11-14 02:24:22', '2022-11-14 02:24:22'),
(75, 4, '2022-11-14 02:24:26', '2022-11-14 02:24:26'),
(76, 4, '2022-11-14 03:45:54', '2022-11-14 03:45:54'),
(77, 4, '2022-11-14 03:45:55', '2022-11-14 03:45:55'),
(78, 4, '2022-11-14 03:45:57', '2022-11-14 03:45:57'),
(79, 4, '2022-11-14 03:45:58', '2022-11-14 03:45:58'),
(80, 4, '2022-11-14 07:01:37', '2022-11-14 07:01:37'),
(81, 4, '2022-11-14 07:01:38', '2022-11-14 07:01:38'),
(82, 4, '2022-11-14 07:01:40', '2022-11-14 07:01:40'),
(83, 4, '2022-11-14 07:01:44', '2022-11-14 07:01:44'),
(84, 4, '2022-11-14 08:34:44', '2022-11-14 08:34:44'),
(85, 4, '2022-11-14 08:34:45', '2022-11-14 08:34:45'),
(86, 4, '2022-11-14 08:34:46', '2022-11-14 08:34:46'),
(87, 4, '2022-11-14 08:34:48', '2022-11-14 08:34:48'),
(88, 4, '2022-11-18 04:10:22', '2022-11-18 04:10:22'),
(89, 4, '2022-11-18 04:11:53', '2022-11-18 04:11:53'),
(90, 4, '2022-11-18 04:11:55', '2022-11-18 04:11:55'),
(91, 4, '2022-11-18 04:11:56', '2022-11-18 04:11:56'),
(92, 4, '2022-11-18 04:11:59', '2022-11-18 04:11:59'),
(93, 4, '2022-12-07 02:15:52', '2022-12-07 02:15:52'),
(94, 4, '2022-12-07 02:15:54', '2022-12-07 02:15:54'),
(95, 4, '2022-12-07 02:15:57', '2022-12-07 02:15:57'),
(96, 4, '2022-12-07 02:15:59', '2022-12-07 02:15:59'),
(97, 4, '2022-12-09 02:41:26', '2022-12-09 02:41:26'),
(98, 4, '2022-12-09 02:41:28', '2022-12-09 02:41:28'),
(99, 4, '2022-12-09 02:41:30', '2022-12-09 02:41:30'),
(100, 4, '2022-12-09 02:41:31', '2022-12-09 02:41:31'),
(101, 4, '2022-12-10 12:44:49', '2022-12-10 12:44:49'),
(102, 4, '2022-12-10 12:44:52', '2022-12-10 12:44:52'),
(103, 4, '2022-12-10 12:44:53', '2022-12-10 12:44:53'),
(104, 4, '2022-12-10 12:44:55', '2022-12-10 12:44:55'),
(131, 4, '2022-12-27 08:32:39', '2022-12-27 08:32:39'),
(137, 5, '2022-12-29 07:41:53', '2022-12-29 07:41:53'),
(141, 5, '2022-12-29 07:42:01', '2022-12-29 07:42:01'),
(142, 5, '2022-12-29 07:42:03', '2022-12-29 07:42:03'),
(143, 5, '2022-12-29 07:42:04', '2022-12-29 07:42:04'),
(144, 5, '2022-12-29 07:42:08', '2022-12-29 07:42:08'),
(145, 5, '2022-12-29 07:42:10', '2022-12-29 07:42:10'),
(146, 5, '2022-12-29 07:42:12', '2022-12-29 07:42:12'),
(147, 5, '2022-12-29 07:42:14', '2022-12-29 07:42:14'),
(148, 5, '2022-12-29 07:42:16', '2022-12-29 07:42:16'),
(149, 5, '2022-12-29 07:42:34', '2022-12-29 07:42:34'),
(150, 5, '2022-12-29 07:42:45', '2022-12-29 07:42:45'),
(154, 6, '2022-12-29 07:45:45', '2022-12-29 07:45:45'),
(155, 6, '2022-12-29 07:45:51', '2022-12-29 07:45:51'),
(156, 6, '2022-12-29 07:45:53', '2022-12-29 07:45:53'),
(157, 6, '2022-12-29 07:45:54', '2022-12-29 07:45:54'),
(158, 6, '2022-12-29 07:45:57', '2022-12-29 07:45:57'),
(159, 6, '2022-12-29 07:45:58', '2022-12-29 07:45:58'),
(160, 6, '2022-12-29 07:46:00', '2022-12-29 07:46:00'),
(161, 6, '2022-12-29 07:46:02', '2022-12-29 07:46:02'),
(162, 6, '2022-12-29 07:46:04', '2022-12-29 07:46:04'),
(163, 6, '2022-12-29 07:46:07', '2022-12-29 07:46:07'),
(164, 6, '2022-12-29 07:46:09', '2022-12-29 07:46:09'),
(165, 6, '2022-12-29 07:46:10', '2022-12-29 07:46:10'),
(166, 6, '2022-12-29 07:46:13', '2022-12-29 07:46:13'),
(167, 6, '2022-12-29 07:46:17', '2022-12-29 07:46:17'),
(168, 6, '2022-12-29 07:46:19', '2022-12-29 07:46:19'),
(169, 6, '2022-12-29 07:46:20', '2022-12-29 07:46:20'),
(170, 6, '2022-12-29 07:46:21', '2022-12-29 07:46:21'),
(171, 6, '2022-12-29 07:46:23', '2022-12-29 07:46:23'),
(172, 6, '2022-12-29 07:46:24', '2022-12-29 07:46:24'),
(173, 6, '2022-12-29 07:46:26', '2022-12-29 07:46:26'),
(174, 6, '2022-12-29 07:46:27', '2022-12-29 07:46:27'),
(175, 6, '2022-12-29 07:46:29', '2022-12-29 07:46:29'),
(176, 6, '2022-12-29 07:46:31', '2022-12-29 07:46:31'),
(177, 6, '2022-12-29 07:46:33', '2022-12-29 07:46:33'),
(178, 6, '2022-12-29 07:46:34', '2022-12-29 07:46:34'),
(179, 6, '2022-12-29 07:46:36', '2022-12-29 07:46:36'),
(180, 6, '2022-12-29 07:46:38', '2022-12-29 07:46:38'),
(181, 6, '2022-12-29 07:46:40', '2022-12-29 07:46:40'),
(182, 6, '2022-12-29 07:46:41', '2022-12-29 07:46:41'),
(183, 6, '2022-12-29 07:46:44', '2022-12-29 07:46:44'),
(184, 6, '2022-12-29 07:46:45', '2022-12-29 07:46:45'),
(185, 6, '2022-12-29 07:46:47', '2022-12-29 07:46:47'),
(186, 6, '2022-12-29 07:46:48', '2022-12-29 07:46:48'),
(187, 6, '2022-12-29 07:46:50', '2022-12-29 07:46:50'),
(188, 6, '2022-12-29 07:46:52', '2022-12-29 07:46:52'),
(189, 6, '2022-12-29 07:46:54', '2022-12-29 07:46:54'),
(190, 6, '2022-12-29 07:46:55', '2022-12-29 07:46:55'),
(191, 6, '2022-12-29 07:47:00', '2022-12-29 07:47:00'),
(192, 6, '2022-12-29 07:47:01', '2022-12-29 07:47:01'),
(193, 6, '2022-12-29 07:47:04', '2022-12-29 07:47:04'),
(194, 6, '2022-12-29 07:47:05', '2022-12-29 07:47:05'),
(195, 6, '2022-12-29 07:47:13', '2022-12-29 07:47:13'),
(196, 6, '2022-12-29 07:47:15', '2022-12-29 07:47:15'),
(197, 6, '2022-12-29 07:47:16', '2022-12-29 07:47:16'),
(198, 6, '2022-12-29 07:47:18', '2022-12-29 07:47:18'),
(199, 6, '2022-12-29 07:47:19', '2022-12-29 07:47:19'),
(200, 6, '2022-12-29 07:47:22', '2022-12-29 07:47:22'),
(201, 6, '2022-12-29 07:47:23', '2022-12-29 07:47:23'),
(202, 6, '2022-12-29 07:47:25', '2022-12-29 07:47:25'),
(203, 6, '2022-12-29 07:47:27', '2022-12-29 07:47:27'),
(204, 6, '2022-12-29 07:47:30', '2022-12-29 07:47:30'),
(205, 6, '2022-12-29 07:47:33', '2022-12-29 07:47:33'),
(206, 6, '2022-12-29 07:47:35', '2022-12-29 07:47:35'),
(207, 6, '2022-12-29 07:47:37', '2022-12-29 07:47:37'),
(208, 6, '2022-12-29 07:47:38', '2022-12-29 07:47:38'),
(209, 6, '2022-12-29 07:47:40', '2022-12-29 07:47:40'),
(210, 6, '2022-12-29 07:47:41', '2022-12-29 07:47:41'),
(211, 6, '2022-12-29 07:47:43', '2022-12-29 07:47:43'),
(212, 6, '2022-12-29 07:47:45', '2022-12-29 07:47:45'),
(213, 6, '2022-12-29 07:47:48', '2022-12-29 07:47:48'),
(214, 6, '2022-12-29 07:47:50', '2022-12-29 07:47:50'),
(215, 6, '2022-12-29 07:47:51', '2022-12-29 07:47:51'),
(216, 6, '2022-12-29 07:47:52', '2022-12-29 07:47:52'),
(217, 6, '2022-12-29 07:48:01', '2022-12-29 07:48:01'),
(218, 6, '2022-12-29 07:48:06', '2022-12-29 07:48:06'),
(219, 6, '2022-12-29 07:48:08', '2022-12-29 07:48:08'),
(220, 6, '2022-12-29 07:48:09', '2022-12-29 07:48:09'),
(221, 6, '2022-12-29 07:48:10', '2022-12-29 07:48:10'),
(222, 6, '2022-12-29 07:48:12', '2022-12-29 07:48:12'),
(223, 6, '2022-12-29 07:48:14', '2022-12-29 07:48:14'),
(224, 6, '2022-12-29 07:48:16', '2022-12-29 07:48:16'),
(225, 6, '2022-12-29 07:48:17', '2022-12-29 07:48:17'),
(226, 6, '2022-12-29 07:48:21', '2022-12-29 07:48:21'),
(227, 6, '2022-12-29 07:48:23', '2022-12-29 07:48:23'),
(228, 6, '2022-12-29 07:48:24', '2022-12-29 07:48:24'),
(229, 6, '2022-12-29 07:48:26', '2022-12-29 07:48:26'),
(230, 5, '2022-12-29 07:52:08', '2022-12-29 07:52:08'),
(234, 4, '2022-12-29 07:53:50', '2022-12-29 07:53:50'),
(235, 4, '2022-12-29 07:54:03', '2022-12-29 07:54:03'),
(236, 4, '2022-12-29 07:54:04', '2022-12-29 07:54:04'),
(237, 4, '2022-12-29 07:54:06', '2022-12-29 07:54:06'),
(238, 4, '2022-12-29 07:54:07', '2022-12-29 07:54:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatans`
--

CREATE TABLE `jabatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jabatans`
--

INSERT INTO `jabatans` (`id`, `name`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Admin', 0, 'Admin', 'Admin', '2022-11-06 03:08:37', '2022-11-06 03:08:37'),
(5, 'Kasir', 0, 'Admin', 'Kasir', '2022-11-06 03:08:54', '2022-11-06 03:28:26'),
(6, 'Owner', 0, 'Admin', 'Admin', '2022-11-06 03:09:03', '2022-11-06 03:09:42'),
(7, 'tes', 1, 'Agus', 'Agus', '2022-11-11 07:55:45', '2022-11-11 08:06:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` int(1) NOT NULL DEFAULT 0,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'E', 0, 'Agus', 'Agus', '2022-11-14 03:18:37', '2022-11-14 03:40:08'),
(3, 'D', 0, 'Agus', 'Agus', '2022-11-14 03:24:24', '2022-11-14 03:40:00'),
(4, 'C', 0, 'Agus', 'Agus', '2022-11-14 03:24:32', '2022-11-14 03:24:32'),
(5, 'A', 0, 'Agus', 'Agus', '2022-11-17 06:29:43', '2022-11-17 06:29:43'),
(6, 'B', 0, 'Agus', 'Agus', '2022-11-17 06:29:51', '2022-11-17 06:29:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level` bigint(20) NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `levels`
--

INSERT INTO `levels` (`id`, `level`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 1, 0, 'Agus', 'Agus', '2022-11-12 13:47:40', '2022-11-12 13:47:40'),
(4, 20, 1, 'Agus', 'Agus', '2022-11-12 13:51:14', '2022-11-12 13:51:29'),
(6, 3, 0, 'Agus', 'Agus', '2022-11-12 13:54:25', '2022-11-12 14:11:51'),
(7, 2, 0, 'Agus', 'Agus', '2022-11-12 14:07:55', '2022-11-12 14:07:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locators`
--

CREATE TABLE `locators` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `rack_id` bigint(20) UNSIGNED NOT NULL,
  `no` bigint(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locators`
--

INSERT INTO `locators` (`id`, `level_id`, `rack_id`, `no`, `status`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 0, 0, 'Agus', 'Agus', '2022-11-13 07:18:29', '2022-11-13 07:18:29'),
(4, 3, 2, 2, 0, 0, 'Agus', 'Agus', '2022-11-13 08:14:19', '2022-11-13 08:14:19'),
(5, 3, 2, 3, 0, 0, 'Agus', 'Agus', '2022-11-13 08:20:20', '2022-11-14 02:16:01'),
(6, 3, 2, 4, 0, 0, 'Agus', 'Agus', '2022-12-08 07:46:09', '2022-12-08 07:46:09'),
(7, 3, 2, 5, 0, 0, 'Agus', 'Agus', '2022-12-08 07:46:18', '2022-12-08 07:46:18'),
(8, 7, 2, 1, 0, 0, 'Agus', 'Agus', '2022-12-12 02:41:23', '2022-12-12 02:41:23'),
(9, 7, 2, 2, 0, 0, 'Agus', 'Agus', '2022-12-12 02:41:37', '2022-12-12 02:41:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locator_barangs`
--

CREATE TABLE `locator_barangs` (
  `locator_id` bigint(20) UNSIGNED NOT NULL,
  `barang_masuk_detail_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menuses`
--

CREATE TABLE `menuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_menu` bigint(20) DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT 0,
  `trashed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menuses`
--

INSERT INTO `menuses` (`id`, `name`, `url`, `icon`, `created_by`, `updated_by`, `main_menu`, `sort`, `trashed`, `created_at`, `updated_at`) VALUES
(3, 'Akses Managemen', 'akses', 'ti-eye', 'Agus', 'Agus', NULL, 0, 0, '2022-11-08 09:09:43', '2022-11-08 09:09:43'),
(4, 'Jabatan', 'akses/jabatan', NULL, 'Agus', 'Agus', 3, 0, 0, '2022-11-08 09:12:08', '2022-11-08 09:12:08'),
(5, 'Akun', 'akses/akun', NULL, 'Agus', 'Agus', 3, 0, 0, '2022-11-08 09:19:20', '2022-11-08 09:19:20'),
(6, 'Menu Managemen', 'menu', 'ti-menu-alt', 'Agus', 'Agus', NULL, 0, 0, '2022-11-08 09:32:32', '2022-11-09 04:04:45'),
(7, 'Inventory', 'inventory', 'ti-server', 'Agus', 'Agus', NULL, 0, 0, '2022-11-11 08:18:46', '2022-11-11 08:18:46'),
(8, 'Locator', 'inventory/locator', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-11 08:20:24', '2022-11-11 08:20:24'),
(9, 'Rak', 'inventory/rak', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-11 08:33:47', '2022-11-11 08:33:47'),
(10, 'Level', 'inventory/level', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-12 13:07:31', '2022-11-12 13:07:31'),
(11, 'Kategori Barang', 'inventory/kategori', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-14 02:24:02', '2022-11-14 02:25:03'),
(12, 'Supplier', 'inventory/supplier', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-14 03:45:27', '2022-11-14 03:45:27'),
(13, 'Merek Barang', 'inventory/merek', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-14 07:01:22', '2022-11-14 07:01:22'),
(14, 'Barang', 'inventory/barang', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-11-14 08:34:26', '2022-11-14 08:34:26'),
(15, 'Transaksi', 'transaksi', 'ti-receipt', 'Agus', 'Agus', NULL, 0, 0, '2022-11-18 04:09:54', '2022-11-18 04:09:54'),
(16, 'Barang Masuk', 'transaksi/barang_masuk', NULL, 'Agus', 'Agus', 15, 0, 0, '2022-11-18 04:11:39', '2022-11-18 04:11:39'),
(17, 'Staging Area', 'transaksi/staging_area', NULL, 'Agus', 'Agus', 15, 0, 0, '2022-12-07 02:15:38', '2022-12-07 02:15:38'),
(18, 'Stok', 'inventory/stok', NULL, 'Agus', 'Agus', 7, 0, 0, '2022-12-09 02:41:15', '2022-12-09 02:41:15'),
(19, 'Pindah Locator', 'transaksi/pindah_locator', NULL, 'Agus', 'Agus', 15, 0, 0, '2022-12-10 12:44:27', '2022-12-10 12:44:27'),
(20, 'Laporan', 'laporan', 'ti-book', 'Agus', 'Agus', NULL, 0, 0, '2022-12-14 02:27:30', '2022-12-14 02:27:30'),
(21, 'Laporan Barang Masuk', 'laporan/barang_masuk', NULL, 'Agus', 'Agus', 20, 0, 0, '2022-12-14 02:29:17', '2022-12-14 02:29:17'),
(22, 'Point Of Sales', 'pos', 'ti-money', 'Agus', 'Agus', NULL, 0, 0, '2022-12-19 03:43:03', '2022-12-19 03:43:03'),
(23, 'Kasir', 'pos/kasir', NULL, 'Agus', 'Agus', 22, 0, 0, '2022-12-19 03:44:00', '2022-12-19 03:44:00'),
(24, 'Pelanggan', 'pos/pelanggan', NULL, 'Agus', 'Agus', 22, 0, 0, '2022-12-23 02:25:28', '2022-12-23 02:25:28'),
(25, 'Laporan Barang Keluar', 'laporan/barang_keluar', NULL, 'Agus', 'Agus', 20, 0, 0, '2022-12-27 08:02:05', '2022-12-27 08:02:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mereks`
--

CREATE TABLE `mereks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mereks`
--

INSERT INTO `mereks` (`id`, `nama`, `created_by`, `updated_by`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 'Honda', 'Agus', 'Agus', 1, '2022-11-14 08:22:28', '2022-11-14 08:25:47'),
(2, 'NGK', 'Agus', 'Agus', 0, '2022-11-14 08:22:44', '2022-11-14 08:32:41'),
(3, 'Racing', 'Agus', 'Agus', 0, '2022-11-14 08:23:00', '2022-11-14 08:32:54'),
(4, 'MPX 2', 'Agus', 'Agus', 0, '2022-12-03 05:48:45', '2022-12-03 05:48:45'),
(5, 'SPX 2', 'Agus', 'Agus', 0, '2022-12-03 05:48:54', '2022-12-03 05:49:05'),
(6, 'GS Astra', 'Agus', 'Agus', 0, '2022-12-03 07:57:35', '2022-12-03 07:57:35'),
(7, 'RJ London', 'Agus', 'Agus', 0, '2022-12-09 09:39:11', '2022-12-09 09:39:11'),
(8, 'Pylox', 'Agus', 'Agus', 0, '2022-12-09 09:39:44', '2022-12-09 09:39:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_11_05_050214_create_jabatans_table', 2),
(6, '2022_11_06_105007_create_akuns_table', 3),
(7, '2022_11_07_143826_create_menus_table', 4),
(8, '2022_11_10_094456_create_ijins_table', 5),
(9, '2022_11_10_095324_create_ijin_jabatans_table', 6),
(10, '2022_11_11_154329_create_raks_table', 7),
(11, '2022_11_11_155715_create_racks_table', 8),
(12, '2022_11_12_201629_create_levels_table', 9),
(13, '2022_11_13_130623_create_locators_table', 10),
(14, '2022_11_14_092959_create_kategoris_table', 11),
(15, '2022_11_14_104952_create_suppliers_table', 12),
(16, '2022_11_14_140342_create_mereks_table', 13),
(17, '2022_11_14_154137_create_barangs_table', 14),
(18, '2022_11_18_152858_create_barang_masuks_table', 15),
(19, '2022_11_18_155701_create_barang_masuk_details_table', 16),
(20, '2022_12_07_162130_create_locator_barangs_table', 17),
(21, '2022_12_19_141847_create_stocks_table', 18),
(22, '2022_12_23_092710_create_pelanggans_table', 19),
(23, '2022_12_23_105404_create_barang_keluars_table', 20),
(24, '2022_12_23_105435_create_barang_keluar_details_table', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggans`
--

CREATE TABLE `pelanggans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelanggans`
--

INSERT INTO `pelanggans` (`id`, `nama`, `status`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(0, 'lain-lain', 0, 0, '', '', NULL, NULL),
(1, 'wawa', 0, 0, 'Agus', 'Agus', '2022-12-23 03:04:55', '2022-12-23 03:14:15'),
(2, 'wiwi', 0, 1, 'Agus', 'Agus', '2022-12-23 03:09:02', '2022-12-23 03:09:31'),
(3, 'wowon', 0, 0, 'Agus', 'Agus', '2022-12-23 03:09:14', '2022-12-23 03:14:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `racks`
--

CREATE TABLE `racks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `no` bigint(20) NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `racks`
--

INSERT INTO `racks` (`id`, `no`, `trashed`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 23, 1, '', 'Agus', NULL, '2022-11-12 12:50:02'),
(2, 1, 0, 'Agus', 'Agus', '2022-11-12 12:36:15', '2022-11-12 12:59:20'),
(3, 2, 0, 'Agus', 'Agus', '2022-11-12 12:59:42', '2022-11-12 12:59:42'),
(4, 3, 0, 'Agus', 'Agus', '2022-11-12 12:59:51', '2022-11-12 12:59:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `not_in` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stocks`
--

INSERT INTO `stocks` (`id`, `not_in`, `stock`, `created_at`, `updated_at`) VALUES
(4, '2_2', 5, NULL, NULL),
(5, '5_4', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_supplier` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trashed` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama`, `kode_supplier`, `created_by`, `updated_by`, `trashed`, `created_at`, `updated_at`) VALUES
(1, 'CV Spare Part Motor', 'CVSM001', 'Agus', 'Agus', 0, '2022-11-14 06:26:35', '2022-11-22 07:04:55'),
(2, 'Mang Dede', '', 'Agus', 'Agus', 1, '2022-11-14 06:30:53', '2022-11-14 06:33:49'),
(3, 'Mang Jarot', 'MJ001', 'Agus', 'Agus', 0, '2022-11-14 06:34:14', '2022-11-22 07:04:09'),
(4, 'Mang Dendi', 'MD001', 'Agus', 'Agus', 0, '2022-11-14 06:52:38', '2022-11-22 07:03:43'),
(5, 'PT Oil Lubricant', 'PTOL001', 'Agus', 'Agus', 0, '2022-11-22 07:05:35', '2022-11-22 07:05:35'),
(6, 'CV Repaint', 'CVR001', 'Agus', 'Agus', 0, '2022-12-09 09:17:50', '2022-12-09 09:17:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` int(11) NOT NULL,
  `trashed` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_by` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `jabatan_id`, `trashed`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Agus', 'admin@gmail.com', NULL, '$2y$10$nQk1UL.Dwd8Hit1iYahAQO2exIlccoQfsynuCoei3VS0l8oPwMnJa', NULL, 4, 0, 0, '', 'Bokii', '2022-11-04 01:07:38', '2022-11-07 07:23:30'),
(5, 'salim', 'owner@gmail.com', NULL, '$2y$10$nLr3flG3KBUtZEj42yRu0OIos.MbLDwvS/tP9MuzhJCK0qjcsnPY.', NULL, 6, 0, 0, 'Agus', 'Agus', '2022-12-29 07:44:11', '2022-12-29 07:44:11'),
(6, 'Anto', 'kasir@gmail.com', NULL, '$2y$10$qr4t5AvG7iDl2K89uINQ/epRfIDPnPGTuOQmKB1dU7gU.2lTqWiNW', NULL, 5, 0, 0, 'Agus', 'Agus', '2022-12-29 07:50:45', '2022-12-29 07:50:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akuns`
--
ALTER TABLE `akuns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akuns_jabatan_id_foreign` (`jabatan_id`);

--
-- Indeks untuk tabel `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categori_id` (`categori_id`);

--
-- Indeks untuk tabel `barang_keluars`
--
ALTER TABLE `barang_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluars_pelanggan_id_index` (`pelanggan_id`);

--
-- Indeks untuk tabel `barang_keluar_details`
--
ALTER TABLE `barang_keluar_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluar_details_barang_keluar_id_barang_id_merek_id_index` (`barang_keluar_id`,`barang_id`,`merek_id`);

--
-- Indeks untuk tabel `barang_masuks`
--
ALTER TABLE `barang_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuks_supplier_id_index` (`supplier_id`);

--
-- Indeks untuk tabel `barang_masuk_details`
--
ALTER TABLE `barang_masuk_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuk_details_barang_id_merek_id_barang_masuk_id_index` (`barang_id`,`merek_id`,`barang_masuk_id`);

--
-- Indeks untuk tabel `barang_masuk_detail_laporans`
--
ALTER TABLE `barang_masuk_detail_laporans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuk_id` (`barang_masuk_id`,`barang_id`,`merek_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `ijins`
--
ALTER TABLE `ijins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ijin_jabatans`
--
ALTER TABLE `ijin_jabatans`
  ADD KEY `ijin_jabatans_ijin_id_foreign` (`ijin_id`),
  ADD KEY `ijin_jabatans_jabatan_id_foreign` (`jabatan_id`);

--
-- Indeks untuk tabel `jabatans`
--
ALTER TABLE `jabatans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `locators`
--
ALTER TABLE `locators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`,`rack_id`);

--
-- Indeks untuk tabel `locator_barangs`
--
ALTER TABLE `locator_barangs`
  ADD KEY `locator_barangs_locator_id_foreign` (`locator_id`),
  ADD KEY `locator_barangs_barang_masuk_detail_id_foreign` (`barang_masuk_detail_id`);

--
-- Indeks untuk tabel `menuses`
--
ALTER TABLE `menuses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mereks`
--
ALTER TABLE `mereks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `racks`
--
ALTER TABLE `racks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akuns`
--
ALTER TABLE `akuns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `barang_keluars`
--
ALTER TABLE `barang_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar_details`
--
ALTER TABLE `barang_keluar_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `barang_masuks`
--
ALTER TABLE `barang_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk_details`
--
ALTER TABLE `barang_masuk_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk_detail_laporans`
--
ALTER TABLE `barang_masuk_detail_laporans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ijins`
--
ALTER TABLE `ijins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT untuk tabel `jabatans`
--
ALTER TABLE `jabatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `locators`
--
ALTER TABLE `locators`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `menuses`
--
ALTER TABLE `menuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `mereks`
--
ALTER TABLE `mereks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `pelanggans`
--
ALTER TABLE `pelanggans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `racks`
--
ALTER TABLE `racks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akuns`
--
ALTER TABLE `akuns`
  ADD CONSTRAINT `akuns_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ijin_jabatans`
--
ALTER TABLE `ijin_jabatans`
  ADD CONSTRAINT `ijin_jabatans_ijin_id_foreign` FOREIGN KEY (`ijin_id`) REFERENCES `ijins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ijin_jabatans_jabatan_id_foreign` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatans` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `locator_barangs`
--
ALTER TABLE `locator_barangs`
  ADD CONSTRAINT `locator_barangs_barang_masuk_detail_id_foreign` FOREIGN KEY (`barang_masuk_detail_id`) REFERENCES `barang_masuk_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locator_barangs_locator_id_foreign` FOREIGN KEY (`locator_id`) REFERENCES `locators` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
