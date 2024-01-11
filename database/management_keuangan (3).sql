-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Jan 2024 pada 07.57
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management_keuangan`
--

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
(1, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2023_11_24_040818_create_tbl_kategoris_table', 1),
(4, '2023_11_24_040850_create_users_table', 1),
(5, '2023_11_24_040946_create_tbl_anggarans_table', 1),
(6, '2023_11_24_041005_create_tbl_pengeluarans_table', 1),
(7, '2023_11_24_041024_create_tbl_pemasukans_table', 1),
(8, '2023_12_02_105819_create_tbl_roles_table', 1),
(9, '2023_11_24_000001_create_tbl_divisis_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ghandisatria@gmail.com', '$2y$10$jmU9qBsCta6Xqh/f0KRwFO6P0zIPV8yD2Q3I/8MEieKA3BSC1xcEi', '2023-12-27 01:59:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_anggarans`
--

CREATE TABLE `tbl_anggarans` (
  `id_anggaran` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_divisi` bigint(20) UNSIGNED NOT NULL,
  `rencana_anggaran` int(11) NOT NULL,
  `aktualisasi_anggaran` int(11) NOT NULL,
  `tgl_anggaran` date NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_anggarans`
--

INSERT INTO `tbl_anggarans` (`id_anggaran`, `id_kategori`, `id_divisi`, `rencana_anggaran`, `aktualisasi_anggaran`, `tgl_anggaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 1, 500000, 490000, '2023-12-15', '1', '2023-12-15 08:26:40', '2023-12-27 01:27:19'),
(3, 1, 1, 120000, 123123, '2023-12-12', '0', '2023-12-16 06:39:28', '2023-12-17 05:15:00'),
(4, 8, 1, 100000, 80000, '2023-12-15', '0', '2023-12-16 06:44:44', '2023-12-21 03:18:49'),
(5, 8, 1, 510000, 461000, '2023-11-15', '1', '2023-12-16 06:49:21', '2023-12-27 01:29:01'),
(6, 1, 1, 123, 123131, '2023-12-07', '0', '2023-12-17 06:15:33', '2023-12-17 06:20:24'),
(7, 2, 2, 120000, 100000, '2023-12-21', '1', '2023-12-19 18:35:25', '2023-12-19 18:35:25'),
(8, 8, 1, 510000, 410000, '2023-10-21', '1', '2023-12-21 01:57:18', '2023-12-27 01:29:06'),
(9, 8, 1, 520000, 491000, '2023-09-21', '1', '2023-12-21 01:57:54', '2023-12-27 01:28:50'),
(10, 8, 1, 500000, 476000, '2023-08-21', '1', '2023-12-21 01:58:28', '2023-12-27 01:28:11'),
(11, 8, 1, 530000, 470000, '2023-07-21', '1', '2023-12-21 01:59:01', '2023-12-27 01:29:20'),
(12, 8, 1, 500000, 486000, '2023-06-21', '1', '2023-12-21 01:59:29', '2023-12-27 01:28:35'),
(13, 8, 1, 200000, 100000, '2023-12-04', '0', '2023-12-26 14:11:15', '2023-12-26 14:11:37'),
(14, 8, 1, 10000, 5000, '2023-12-26', '0', '2023-12-26 14:12:03', '2023-12-26 14:15:17'),
(15, 8, 1, 200000, 200000, '2023-12-26', '0', '2023-12-26 15:51:33', '2023-12-26 15:52:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_divisis`
--

CREATE TABLE `tbl_divisis` (
  `id_divisi` bigint(20) UNSIGNED NOT NULL,
  `nama_divisi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_divisis`
--

INSERT INTO `tbl_divisis` (`id_divisi`, `nama_divisi`, `created_at`, `updated_at`) VALUES
(1, 'Logistik', '2023-12-20 15:38:33', '2023-12-26 18:02:02'),
(2, 'Sumber Daya Manusia', '2023-12-20 15:38:41', '2023-12-20 15:38:41'),
(3, 'Teknologi Informasi', '2023-12-20 15:38:52', '2023-12-20 15:38:52'),
(4, 'Pemasaran', '2023-12-20 15:39:04', '2023-12-20 15:39:04'),
(5, 'Hubungan Internal', '2023-12-20 15:39:13', '2023-12-20 15:39:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategoris`
--

CREATE TABLE `tbl_kategoris` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_kategoris`
--

INSERT INTO `tbl_kategoris` (`id_kategori`, `nama_kategori`, `jenis_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Transportasi', 'Pengeluaran', '2023-12-15 08:19:00', '2023-12-19 19:47:42'),
(2, 'Akomodasi', 'Pengeluaran', '2023-12-15 08:19:08', '2023-12-19 19:47:52'),
(3, 'Perjalanan Dinas', 'Pengeluaran', '2023-12-19 19:48:04', '2023-12-19 19:48:04'),
(4, 'Makan dan minum', 'Pengeluaran', '2023-12-19 19:48:14', '2023-12-19 19:48:14'),
(5, 'Asuransi', 'Pengeluaran', '2023-12-19 19:48:21', '2023-12-19 19:48:21'),
(6, 'Peralatan', 'Pengeluaran', '2023-12-19 19:48:31', '2023-12-19 19:48:31'),
(7, 'Penjualan Produk', 'Pemasukkan', '2023-12-19 19:48:41', '2023-12-19 19:48:41'),
(8, 'Angaran Divisi', 'Pemasukkan', '2023-12-19 19:48:49', '2023-12-19 19:48:49'),
(9, 'Lainnya', 'Pemasukkan', '2023-12-19 19:49:02', '2023-12-19 19:49:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pemasukans`
--

CREATE TABLE `tbl_pemasukans` (
  `id_pemasukan` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_user_create` bigint(20) NOT NULL,
  `id_user_edit` bigint(20) NOT NULL,
  `jml_masuk` int(11) NOT NULL,
  `tgl_pemasukan` date NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pemasukan` blob NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_pemasukans`
--

INSERT INTO `tbl_pemasukans` (`id_pemasukan`, `id_kategori`, `id_user`, `id_user_create`, `id_user_edit`, `jml_masuk`, `tgl_pemasukan`, `catatan`, `bukti_pemasukan`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 2, 2, 2, 140000, '2023-12-17', 'pemasukan bensin', 0x313730333631363331325f6e6f7461322e6a7067, '1', '2023-12-17 09:43:18', '2023-12-27 01:22:15'),
(6, 1, 20, 1, 1, 100000, '2023-12-19', 'anu', 0x313730333630373436375f312e706e67, '1', '2023-12-18 09:51:21', '2023-12-26 16:17:47'),
(7, 1, 20, 1, 1, 100000, '2023-12-06', '1', 0x31, '1', '2023-12-18 09:51:42', '2023-12-18 09:51:42'),
(11, 1, 2, 1, 1, 100000, '2023-12-20', '1', 0x313730333631363235365f6e6f7461322e6a7067, '1', '2023-12-19 18:37:10', '2023-12-26 18:44:16'),
(12, 2, 25, 23, 23, 100000, '2023-12-20', '1', 0x31, '1', '2023-12-19 18:49:06', '2023-12-19 18:49:06'),
(22, 8, 2, 2, 2, 500000, '2023-07-21', '1', 0x313730333132353933305f436170747572652e504e47, '1', '2023-12-21 02:32:10', '2023-12-21 02:32:10'),
(25, 8, 2, 2, 2, 500000, '2023-06-21', '1', 0x313730333132363035315f436170747572652e504e47, '1', '2023-12-21 02:34:11', '2023-12-21 02:34:11'),
(27, 1, 2, 2, 2, 500000, '2023-09-21', '-', 0x313730333132363039385f436170747572652e504e47, '1', '2023-12-21 02:34:58', '2023-12-21 02:34:58'),
(28, 8, 2, 2, 2, 500000, '2023-08-21', '-', 0x313730333132363133325f436170747572652e504e47, '1', '2023-12-21 02:35:32', '2023-12-21 02:35:32'),
(29, 8, 2, 2, 2, 500000, '2023-10-21', '-', 0x313730333132363137345f436170747572652e504e47, '1', '2023-12-21 02:36:14', '2023-12-21 02:52:23'),
(30, 8, 2, 2, 2, 500000, '2023-11-21', '-', 0x313730333132363139365f436170747572652e504e47, '1', '2023-12-21 02:36:36', '2023-12-21 02:36:36'),
(31, 1, 2, 2, 1, 25000, '2023-12-21', '-', 0x313730333634303932385f6e6f7461322e6a7067, '1', '2023-12-21 02:55:42', '2023-12-27 01:35:29'),
(32, 8, 2, 2, 2, 50000, '2023-12-21', '-', 0x313730333132373436315f3239343638373933385f373635383732363231373533353335335f323836383034323831343338323236313233385f6e2e6a7067, '0', '2023-12-21 02:57:41', '2023-12-25 13:33:13'),
(33, 1, 2, 2, 1, 100000, '2023-12-21', '-', 0x313730333631363231315f6e6f74612e706e67, '1', '2023-12-21 03:54:11', '2023-12-26 18:43:31'),
(34, 6, 2, 2, 2, 50000, '2023-11-21', '-', 0x313730333133303935325f3239343638373933385f373635383732363231373533353335335f323836383034323831343338323236313233385f6e2e6a7067, '1', '2023-12-21 03:55:52', '2023-12-21 03:55:52'),
(35, 1, 2, 2, 1, 11000, '2023-12-26', '-', 0x313730333536383235325f53494d414b4555502e706e67, '0', '2023-12-26 03:58:30', '2023-12-26 16:18:48'),
(36, 8, 2, 2, 2, 200000, '2023-12-26', '-', 0x313730333630373431395f322e706e67, '0', '2023-12-26 16:17:00', '2023-12-26 16:18:44'),
(37, 3, 2, 2, 2, 10000, '2023-12-26', '-', 0x313730333630373434355f322e706e67, '0', '2023-12-26 16:17:25', '2023-12-26 16:17:34'),
(38, 1, 2, 2, 2, 100000, '2023-12-26', '1', 0x313730333630373438345f322e706e67, '0', '2023-12-26 16:18:04', '2023-12-26 16:18:36'),
(39, 1, 2, 2, 2, 5000, '2023-12-26', '-', 0x313730333630373837385f322e706e67, '0', '2023-12-26 16:24:38', '2023-12-26 16:25:26'),
(40, 3, 30, 30, 30, 5000, '2023-12-27', '-', 0x313730333631303136395f53494d414b455550202831292e706e67, '1', '2023-12-26 17:02:49', '2023-12-26 17:02:49'),
(41, 8, 28, 28, 28, 50000, '2023-12-27', '-', 0x313730333631313638395f53494d414b455550202831292e706e67, '1', '2023-12-26 17:28:09', '2023-12-26 17:28:09'),
(42, 1, 29, 29, 1, 10000, '2023-12-21', '-', 0x313730333631333633335f53494d414b455550202831292e706e67, '1', '2023-12-26 17:50:56', '2023-12-26 18:00:33'),
(43, 9, 2, 2, 2, 100000, '2023-12-27', '-', 0x313730333634353739305f6e6f7461322e6a7067, '1', '2023-12-27 02:56:30', '2023-12-27 02:56:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengeluarans`
--

CREATE TABLE `tbl_pengeluarans` (
  `id_pengeluaran` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_user_create` bigint(20) NOT NULL,
  `id_user_edit` bigint(20) NOT NULL,
  `jml_keluar` int(11) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pengeluaran` blob NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_pengeluarans`
--

INSERT INTO `tbl_pengeluarans` (`id_pengeluaran`, `id_kategori`, `id_user`, `id_user_create`, `id_user_edit`, `jml_keluar`, `tgl_pengeluaran`, `catatan`, `bukti_pengeluaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 2, 2, 120000, '2023-12-20', '1', 0x31, '0', '2023-12-19 19:15:40', '2023-12-21 02:12:55'),
(2, 2, 2, 2, 2, 1300000, '2023-12-20', 'akomodasi', 0x31, '0', '2023-12-21 02:11:58', '2023-12-21 02:12:59'),
(3, 5, 2, 2, 2, 300000, '2023-06-21', 'asuransi', 0x31, '0', '2023-12-21 02:12:24', '2023-12-21 02:13:02'),
(4, 3, 2, 2, 2, 500000, '2023-06-21', 'Perjalanan ke surabaya', 0x31, '1', '2023-12-21 02:13:30', '2023-12-21 02:13:30'),
(5, 5, 2, 2, 2, 360000, '2023-07-21', 'Asuransi', 0x31, '0', '2023-12-21 02:13:59', '2023-12-26 05:48:23'),
(6, 1, 2, 2, 2, 400000, '2023-08-21', 'biaya transportasi', 0x31, '0', '2023-12-21 02:14:48', '2023-12-26 05:47:55'),
(7, 4, 2, 2, 2, 430000, '2023-09-21', 'makan bersama', 0x31, '0', '2023-12-21 02:28:35', '2023-12-25 18:29:56'),
(8, 1, 2, 2, 1, 400000, '2023-10-21', '1', 0x313730333631363239365f6e6f7461322e6a7067, '1', '2023-12-21 02:29:56', '2023-12-26 18:44:56'),
(9, 1, 2, 2, 1, 470000, '2023-11-21', '1', 0x313730333631363237355f6e6f7461322e6a7067, '1', '2023-12-21 02:30:13', '2023-12-26 18:44:35'),
(10, 6, 2, 2, 2, 390000, '2023-12-21', 'peralatan perusahaan', 0x31, '0', '2023-12-21 02:30:41', '2023-12-25 09:05:15'),
(11, 2, 2, 2, 2, 10000, '2023-12-27', '123', 0x313730333538313437325f53494d414b4555502e706e67, '0', '2023-12-26 09:04:32', '2023-12-26 15:03:06'),
(12, 1, 2, 2, 1, 10000, '2023-12-21', '-', 0x313730333631363139355f6e6f74612e706e67, '1', '2023-12-26 09:05:27', '2023-12-26 18:43:15'),
(13, 1, 2, 2, 1, 10000, '2023-12-20', '1', 0x313730333631363234315f6e6f7461322e6a7067, '1', '2023-12-26 09:06:29', '2023-12-26 18:44:01'),
(14, 2, 2, 2, 2, 460000, '2023-07-27', '-', 0x313730333631353839375f53494d414b455550202832292e706e67, '1', '2023-12-26 18:38:17', '2023-12-26 18:38:17'),
(15, 2, 2, 2, 2, 430000, '2023-08-27', '-', 0x313730333631353933365f53494d414b455550202832292e706e67, '1', '2023-12-26 18:38:56', '2023-12-26 18:38:56'),
(16, 2, 2, 2, 2, 0, '2023-09-21', '-', 0x313730333631353937305f53494d414b455550202831292e706e67, '1', '2023-12-26 18:39:30', '2023-12-26 18:39:30'),
(17, 9, 2, 2, 2, 550000, '2023-12-13', 'WiFi', 0x313730333631363031395f53494d414b455550202831292e706e67, '1', '2023-12-26 18:40:19', '2023-12-26 18:40:19'),
(18, 1, 2, 2, 2, 490000, '2023-09-27', '-', 0x313730333631363131395f6e6f74612e706e67, '1', '2023-12-26 18:41:59', '2023-12-26 18:41:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_roles`
--

INSERT INTO `tbl_roles` (`id_role`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Direktur', NULL, NULL),
(3, 'Manajer', NULL, NULL),
(4, 'Karyawan', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_divisi` int(10) UNSIGNED DEFAULT NULL,
  `role` int(10) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `id_divisi`, `role`, `nama`, `username`, `password`, `jenis_kelamin`, `nomor_telepon`, `alamat`, `foto_profil`, `email`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Gandhi Satria', 'gndhstr', '$2y$10$fVgoeoSOwLkSd8CD1uqz.O328P8hVzb6oXW4Ue9/PbC6gBlcXo502', 'Laki-laki', '085647422491', 'Salatiga', 'img/iYfERwGFBsO9mZJn9QDSUbAQXKKJ5eZjsQ5usL88.jpg', 'ghandisatria@gmail.com', NULL, 'TuT0fDtt5hmwn6DvDEMKv9FYC5T0qxhOQTABi8HsEWclPom3y7LSgxuY7toH', NULL, '2023-12-26 09:00:16'),
(2, 1, 4, 'Mina Sulistiyowati', 'gandhikaryawan', '$2y$10$1X4Hrw618Wz3k6mUKbWdxudKnNz9.WXGhOKYLG5F8psKNM2DMDLFK', 'Laki-laki', '08163022032', 'Semarang', 'img/4TJa77H17R6Hd5xVZBaErCbRvNfer0U6tvL5AvBv.jpg', 'minal.minul@gmail.com', NULL, NULL, '2023-12-15 08:16:15', '2023-12-27 02:07:57'),
(3, 2, 1, 'Rido', 'admin', '$2y$10$VRwMo4M0KJD5iLzAks89ruWTBjO28X2G3JZYr7C0Lc1IW1nEMgnXu', NULL, '123123', 'test', 'img/7Z2bLfKu1i2FcXyexw5uCMv7jU1Xhuh796NAUuYv.jpg', 'gndhstr@gmail.com', NULL, 'k9gIfttQnkzb7YOYf0aPDv86i0HtEokDiwGvz8JfQTl3YTTQLZS4lAMUU5ij', NULL, '2023-12-27 02:41:05'),
(19, 1, 2, 'M. Syukran', 'direktur', '$2a$12$D53j7r50VGwadpEGhQY99u29D9BDGGYAU0bLSazAoRcgf8mgiVi3.', NULL, NULL, NULL, NULL, '', NULL, NULL, '2023-12-17 05:44:53', '2023-12-27 02:07:39'),
(20, 1, 4, 'Roby Saputra', 'robysptr', NULL, 'Laki-laki', '085612381235', 'Semarang', NULL, '', NULL, NULL, '2023-12-17 07:38:25', '2023-12-26 13:33:29'),
(23, 2, 3, 'Raffi Ahmad', 'manajer2', '$2y$10$kVoGbOzfaPwyDPVME03oP.Z1hxSPnPUObkR1nfYUjAChBu3AUgb3a', NULL, NULL, NULL, NULL, '', NULL, NULL, '2023-12-19 18:17:39', '2023-12-27 02:07:11'),
(25, 2, 4, 'Raisa Anggraini', 'jonwaw', '$2y$10$MrZFIca7rnujdCROfdaBWe/xeWhOvA4VvCA2mgfKKO5WSm50YxDIi', 'Laki-laki', '123123', 'Salatiga', NULL, '', NULL, NULL, '2023-12-19 18:39:01', '2023-12-27 02:07:27'),
(27, 2, 3, 'Ahmad Irzarul', 'gndhstr2', '$2y$10$zxMFRdwVQ8o3pp/UBsFFjeSfmI8yvYq8xWDxfWCdWO4JK0qKFTNvq', NULL, NULL, NULL, NULL, '', NULL, NULL, '2023-12-24 13:17:22', '2023-12-27 02:06:01'),
(28, 1, 4, 'Indra Kurniawan', 'indrkrnwn', '$2y$10$xt/jBXQakkbI.gmW.QFxse0gQ5hOWcnGEBv6K3u65omMf7cfslu22', 'Laki-laki', '08123412345', 'Surabaya', NULL, NULL, NULL, NULL, '2023-12-26 13:33:17', '2023-12-26 13:33:17'),
(29, 1, 4, 'Raisa Andini', 'raisndi', '$2y$10$9tQ7gXcx27IzSgI57h2RLect5KnhRWoUoIWnPo9G1KYhbvR4nTlEK', 'Perempuan', '09865123123', 'Sleman', NULL, NULL, NULL, NULL, '2023-12-26 13:37:57', '2023-12-26 16:16:21'),
(30, 1, 4, 'Angelica', 'angelica', '$2y$10$xS2auq8lupv6PTScRTETNuvjaU4iAFct7tSnez6oJHUfb3P9M3vO2', 'Perempuan', '09865123456', 'Semarang', NULL, NULL, NULL, NULL, '2023-12-26 13:38:26', '2023-12-26 13:38:26');

--
-- Indexes for dumped tables
--

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
-- Indeks untuk tabel `tbl_anggarans`
--
ALTER TABLE `tbl_anggarans`
  ADD PRIMARY KEY (`id_anggaran`),
  ADD KEY `tbl_anggarans_id_kategori_foreign` (`id_kategori`),
  ADD KEY `tbl_anggarans_id_divisi_foreign` (`id_divisi`);

--
-- Indeks untuk tabel `tbl_divisis`
--
ALTER TABLE `tbl_divisis`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indeks untuk tabel `tbl_kategoris`
--
ALTER TABLE `tbl_kategoris`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbl_pemasukans`
--
ALTER TABLE `tbl_pemasukans`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `tbl_pemasukans_id_kategori_foreign` (`id_kategori`),
  ADD KEY `tbl_pemasukans_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `tbl_pengeluarans`
--
ALTER TABLE `tbl_pengeluarans`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `tbl_pengeluarans_id_kategori_foreign` (`id_kategori`),
  ADD KEY `tbl_pengeluarans_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_anggarans`
--
ALTER TABLE `tbl_anggarans`
  MODIFY `id_anggaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_divisis`
--
ALTER TABLE `tbl_divisis`
  MODIFY `id_divisi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategoris`
--
ALTER TABLE `tbl_kategoris`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_pemasukans`
--
ALTER TABLE `tbl_pemasukans`
  MODIFY `id_pemasukan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengeluarans`
--
ALTER TABLE `tbl_pengeluarans`
  MODIFY `id_pengeluaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_anggarans`
--
ALTER TABLE `tbl_anggarans`
  ADD CONSTRAINT `tbl_anggarans_id_divisi_foreign` FOREIGN KEY (`id_divisi`) REFERENCES `tbl_divisis` (`id_divisi`),
  ADD CONSTRAINT `tbl_anggarans_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategoris` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `tbl_pemasukans`
--
ALTER TABLE `tbl_pemasukans`
  ADD CONSTRAINT `tbl_pemasukans_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategoris` (`id_kategori`),
  ADD CONSTRAINT `tbl_pemasukans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_pengeluarans`
--
ALTER TABLE `tbl_pengeluarans`
  ADD CONSTRAINT `tbl_pengeluarans_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategoris` (`id_kategori`),
  ADD CONSTRAINT `tbl_pengeluarans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `tbl_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
