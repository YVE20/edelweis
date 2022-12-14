-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Nov 2022 pada 16.44
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edelweis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `license`
--

CREATE TABLE `license` (
  `id` int(10) NOT NULL,
  `nama` text NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(50) NOT NULL,
  `icon` text NOT NULL,
  `minus` varchar(1) NOT NULL DEFAULT 'Y',
  `shift1` varchar(100) NOT NULL,
  `shift2` varchar(100) NOT NULL,
  `shift3` varchar(100) NOT NULL,
  `lembur` varchar(100) NOT NULL,
  `idtoko` varchar(20) NOT NULL,
  `printer` text NOT NULL,
  `ppn` int(11) NOT NULL,
  `meja` int(11) NOT NULL,
  `instagram` text NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `license`
--

INSERT INTO `license` (`id`, `nama`, `alamat`, `telp`, `icon`, `minus`, `shift1`, `shift2`, `shift3`, `lembur`, `idtoko`, `printer`, `ppn`, `meja`, `instagram`, `password`) VALUES
(1, 'Edelweis', 'Jln. Nurul Huda', '-', '1608598162_Logo Cherish Collection.png', 'Y', 'undefined', 'undefined', 'undefined', 'undefined', '0004', 'undefined', 0, 0, 'undefined', 'undefined');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbhutang`
--

CREATE TABLE `tbhutang` (
  `id` int(10) NOT NULL,
  `id_pembelian` varchar(191) NOT NULL,
  `jumlah` double NOT NULL,
  `sisa` double NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbhutangdetil`
--

CREATE TABLE `tbhutangdetil` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_hutang` int(10) NOT NULL,
  `jumlah` double NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbjual`
--

CREATE TABLE `tbjual` (
  `id` varchar(100) NOT NULL,
  `kodecanvas` varchar(100) NOT NULL,
  `iduser` int(10) NOT NULL,
  `idkonsumen` int(11) NOT NULL,
  `idsales` varchar(100) NOT NULL,
  `tanggal` date NOT NULL,
  `metode_pembayaran` enum('Cash','Kredit') NOT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `shift` varchar(20) DEFAULT '2',
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `grandtotal` double NOT NULL,
  `cash` double NOT NULL,
  `kembalian` double NOT NULL,
  `status_antar` enum('yes','no') NOT NULL COMMENT 'status Antar /belum',
  `tgl_antar` datetime DEFAULT NULL,
  `nopol_supir` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbjualdetil`
--

CREATE TABLE `tbjualdetil` (
  `id` int(10) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `idmenu` int(10) NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `harga` double NOT NULL,
  `pajak` int(10) NOT NULL COMMENT 'persen pajak',
  `jlhpajak` double NOT NULL,
  `diskon` int(10) NOT NULL COMMENT 'persen diskon',
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkaryawan`
--

CREATE TABLE `tbkaryawan` (
  `id` int(10) NOT NULL,
  `nama` text NOT NULL,
  `pekerjaan` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkas`
--

CREATE TABLE `tbkas` (
  `id` int(10) NOT NULL,
  `iduser` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` text NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkategori`
--

CREATE TABLE `tbkategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tipe` int(11) NOT NULL,
  `id_printer` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbkonsumen`
--

CREATE TABLE `tbkonsumen` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `wilayah` enum('dalam','luar') NOT NULL,
  `kategori` enum('dalam','luar','depo','modern','tradisional','agen','user') NOT NULL,
  `rute` varchar(191) NOT NULL,
  `no_freezer` varchar(50) NOT NULL,
  `rate_pajak` int(11) NOT NULL,
  `max_hutang` int(11) NOT NULL COMMENT 'Jumlah Max. Hutang ',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tblogsmenu`
--

CREATE TABLE `tblogsmenu` (
  `id` int(10) NOT NULL,
  `idmenu` int(10) NOT NULL,
  `jumlah` double NOT NULL,
  `kategori` enum('masuk','keluar') NOT NULL,
  `iduser` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tblogsmenu`
--

INSERT INTO `tblogsmenu` (`id`, `idmenu`, `jumlah`, `kategori`, `iduser`, `created_at`, `updated_at`) VALUES
(1, 66, 1, 'keluar', 1, '2021-02-07 05:30:08', '2021-02-07 05:30:08'),
(2, 2783, 1, 'keluar', 32, '2022-10-01 06:17:07', '2022-10-01 06:17:07'),
(3, 2783, 100, 'keluar', 32, '2022-10-01 19:30:27', '2022-10-01 19:30:27'),
(4, 2783, 100, 'masuk', 32, '2022-10-02 09:08:13', '2022-10-02 09:08:13'),
(5, 2783, 100, 'keluar', 32, '2022-10-02 09:12:26', '2022-10-02 09:12:26'),
(6, 2783, 100, 'masuk', 32, '2022-10-02 09:19:26', '2022-10-02 09:19:26'),
(7, 2365, 1, 'keluar', 1, '2022-10-03 07:46:41', '2022-10-03 07:46:41'),
(8, 2365, 1, 'keluar', 1, '2022-10-19 15:49:03', '2022-10-19 15:49:03'),
(9, 2365, 1, 'masuk', 1, '2022-10-21 06:57:10', '2022-10-21 06:57:10'),
(10, 2365, 1, 'keluar', 1, '2022-10-21 07:13:11', '2022-10-21 07:13:11'),
(11, 990, 1, 'keluar', 1, '2022-10-21 07:22:01', '2022-10-21 07:22:01'),
(12, 2106, 1, 'keluar', 1, '2022-10-21 07:33:08', '2022-10-21 07:33:08'),
(13, 990, 1, 'keluar', 1, '2022-10-21 07:33:09', '2022-10-21 07:33:09'),
(14, 2106, 1, 'masuk', 1, '2022-10-27 07:47:38', '2022-10-27 07:47:38'),
(15, 990, 1, 'masuk', 1, '2022-10-27 07:47:38', '2022-10-27 07:47:38'),
(16, 2365, 1, 'keluar', 1, '2022-10-27 07:59:38', '2022-10-27 07:59:38'),
(17, 2365, 1, 'keluar', 1, '2022-10-27 08:11:32', '2022-10-27 08:11:32'),
(18, 2365, 1, 'keluar', 1, '2022-10-27 08:12:06', '2022-10-27 08:12:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbmenu`
--

CREATE TABLE `tbmenu` (
  `id` int(10) NOT NULL,
  `kode_barang` varchar(191) NOT NULL DEFAULT '0',
  `nama` text NOT NULL,
  `wilayah` enum('dalam','luar') NOT NULL,
  `jenis_market` enum('depo','modern','tradisional','agen','user') NOT NULL,
  `img_url` text NOT NULL,
  `harga_beli` double NOT NULL DEFAULT '0',
  `harga_dk` double NOT NULL DEFAULT '0',
  `harga_lk` double NOT NULL DEFAULT '0',
  `harga_depo` double NOT NULL,
  `harga_modern` double NOT NULL,
  `harga_tradisional` double NOT NULL,
  `harga_agen` double NOT NULL,
  `harga_user` double NOT NULL,
  `diskon` int(11) NOT NULL COMMENT 'by Persentase',
  `pajak` int(11) NOT NULL COMMENT 'by Persentase',
  `satuan` varchar(50) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `isi_kemasan` int(11) NOT NULL,
  `jumlah` decimal(10,0) NOT NULL,
  `lokasi` varchar(191) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbmenu`
--

INSERT INTO `tbmenu` (`id`, `kode_barang`, `nama`, `wilayah`, `jenis_market`, `img_url`, `harga_beli`, `harga_dk`, `harga_lk`, `harga_depo`, `harga_modern`, `harga_tradisional`, `harga_agen`, `harga_user`, `diskon`, `pajak`, `satuan`, `kategori`, `isi_kemasan`, `jumlah`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, '001', 'Pensil', 'dalam', 'depo', 'dummy.jpg', 0, 5000, 0, 0, 0, 0, 0, 0, 0, 0, 'Pcs', 'Sepatu', 1, '0', '', '2022-10-27 08:44:38', '2022-10-27 08:44:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpembelian`
--

CREATE TABLE `tbpembelian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_user_approve` bigint(20) DEFAULT NULL,
  `id_supplier` bigint(20) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `referensi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_pembayaran` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jatuh_tempo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biaya_lainnya` double DEFAULT '0',
  `desc_biaya_lainnya` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `grandtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpembeliandetil`
--

CREATE TABLE `tbpembeliandetil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `jlhdiskon` double NOT NULL,
  `jlhpajak` decimal(10,0) NOT NULL,
  `subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpiutang`
--

CREATE TABLE `tbpiutang` (
  `id` int(10) NOT NULL,
  `id_penjualan` varchar(191) NOT NULL,
  `jumlah` double NOT NULL,
  `sisa` double NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `penagih` varchar(191) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbpiutang`
--

INSERT INTO `tbpiutang` (`id`, `id_penjualan`, `jumlah`, `sisa`, `jatuh_tempo`, `penagih`, `created_at`, `updated_at`) VALUES
(1, 'J-20221002--32-03850', 0, 0, '2022-10-07', 'Admin', '2022-10-01 19:30:27', '2022-10-01 19:32:10'),
(2, 'J-20221002--32-03850', 0, 11500000, '2022-10-09', '', '2022-10-02 09:12:26', '2022-10-02 09:12:26'),
(3, 'J-20221019-6-1-00001', 0, 35000, '0000-00-00', '', '2022-10-19 15:49:03', '2022-10-19 15:49:03'),
(4, 'J-20221021-73-1-00001', 0, 35000, '0000-00-00', '', '2022-10-21 07:13:11', '2022-10-21 07:13:11'),
(5, 'J-20221021-73-1-00002', 0, 30000, '0000-00-00', '', '2022-10-21 07:22:01', '2022-10-21 07:22:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbpiutangdetil`
--

CREATE TABLE `tbpiutangdetil` (
  `id` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `id_piutang` int(10) NOT NULL,
  `jumlah` double NOT NULL,
  `tanggal` date NOT NULL,
  `penagih` varchar(191) NOT NULL DEFAULT '',
  `note` varchar(191) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbpiutangdetil`
--

INSERT INTO `tbpiutangdetil` (`id`, `id_user`, `id_piutang`, `jumlah`, `tanggal`, `penagih`, `note`, `created_at`, `updated_at`) VALUES
(1, 32, 1, 11500000, '2022-10-03', 'Admin', 'Transfer', '2022-10-01 19:32:10', '2022-10-01 19:32:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbretur`
--

CREATE TABLE `tbretur` (
  `id` int(11) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `kelayakan` enum('layak','tidaklayak') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsales`
--

CREATE TABLE `tbsales` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbsales`
--

INSERT INTO `tbsales` (`id`, `kode`, `nama`, `alamat`, `kontak`, `created_at`, `updated_at`) VALUES
(1, '0', 'Toko', '-', '0', '2020-12-24 04:41:11', '2020-12-24 04:41:23'),
(10, '001', 'ijah', '--', '888', '2022-04-30 22:24:37', '2022-04-30 22:24:37'),
(17, '007', 'fitri', '--', '', '2022-05-20 08:47:15', '2022-05-28 17:39:18'),
(19, '006', 'Qoriah', 'siantan', '', '2022-08-27 12:45:32', '2022-08-29 14:34:24'),
(20, '009', 'nisa', 'siantan', '', '2022-08-29 14:34:07', '2022-08-29 14:34:07'),
(21, '009', 'Andi', '28 okt', '', '2022-10-01 07:37:31', '2022-10-01 07:37:55'),
(22, '010', 'Admin', '', '', '2022-10-01 07:38:17', '2022-10-01 07:38:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsatuan`
--

CREATE TABLE `tbsatuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbsatuan`
--

INSERT INTO `tbsatuan` (`id_satuan`, `satuan`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', '2020-09-24 18:20:43', '2021-01-06 15:59:42'),
(5, 'dus', '2022-10-02 09:10:13', '2022-10-02 09:10:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbsupplier`
--

CREATE TABLE `tbsupplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktif` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbsupplier`
--

INSERT INTO `tbsupplier` (`id`, `nama`, `kontak`, `alamat`, `deskripsi`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Contoh Supplier', '0', '-', '-', 'Active', '2020-10-14 06:35:14', '2021-01-06 15:59:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbuser`
--

CREATE TABLE `tbuser` (
  `iduser` int(10) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text,
  `status` varchar(100) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbuser`
--

INSERT INTO `tbuser` (`iduser`, `username`, `password`, `status`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'aXRjc3N1a3Nlcw==', 'Admin', 'Admin', '2018-02-15 13:53:30', '2022-09-16 13:31:12'),
(2, 'admin', 'MTIzNDU2', '', 'admin', '2022-10-27 08:41:04', '2022-10-27 08:41:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tempjualdetil`
--

CREATE TABLE `tempjualdetil` (
  `id` int(10) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `kodecanvas` varchar(100) NOT NULL,
  `idkonsumen` int(11) NOT NULL,
  `idsales` varchar(100) NOT NULL,
  `idmenu` int(10) NOT NULL,
  `iduser` int(10) DEFAULT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` double NOT NULL,
  `pajak` int(10) NOT NULL,
  `jlhpajak` double NOT NULL,
  `diskon` int(10) NOT NULL,
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `temppembeliandetil`
--

CREATE TABLE `temppembeliandetil` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pembelian` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menu` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `jlhdiskon` double NOT NULL,
  `jlhpajak` decimal(10,0) NOT NULL,
  `subtotal` double NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trashjual`
--

CREATE TABLE `trashjual` (
  `id` varchar(100) NOT NULL,
  `iduser` int(10) NOT NULL,
  `idkaryawan` int(10) NOT NULL,
  `tanggal` date NOT NULL,
  `shift` varchar(20) DEFAULT '2',
  `meja` varchar(100) NOT NULL,
  `subtotal` double NOT NULL,
  `diskon` double NOT NULL,
  `pajak` double NOT NULL,
  `grandtotal` double NOT NULL,
  `cash` double NOT NULL,
  `kembalian` double NOT NULL,
  `alasan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trashjual`
--

INSERT INTO `trashjual` (`id`, `iduser`, `idkaryawan`, `tanggal`, `shift`, `meja`, `subtotal`, `diskon`, `pajak`, `grandtotal`, `cash`, `kembalian`, `alasan`, `created_at`, `updated_at`) VALUES
('J-20221019-6-1-00001', 1, 0, '2022-10-19', '1', '', 35000, 0, 0, 35000, 0, 0, 'fiktif', '2022-10-21 06:57:10', '2022-10-21 06:57:10'),
('J-20221021-73-1-00003', 1, 0, '2022-10-21', '1', '', 80000, 0, 0, 76000, 0, 0, '', '2022-10-27 07:47:38', '2022-10-27 07:47:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trashjualdetil`
--

CREATE TABLE `trashjualdetil` (
  `id` int(10) NOT NULL,
  `idjual` varchar(100) NOT NULL,
  `idmenu` int(10) NOT NULL,
  `iduser` int(10) DEFAULT NULL,
  `jumlah` int(10) NOT NULL,
  `harga` double NOT NULL,
  `pajak` int(10) NOT NULL,
  `jlhpajak` double NOT NULL,
  `diskon` int(10) NOT NULL,
  `jlhdiskon` double NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `trashjualdetil`
--

INSERT INTO `trashjualdetil` (`id`, `idjual`, `idmenu`, `iduser`, `jumlah`, `harga`, `pajak`, `jlhpajak`, `diskon`, `jlhdiskon`, `subtotal`, `total`, `created_at`, `updated_at`) VALUES
(1, 'J-20221019-6-1-00001', 2365, 1, 1, 35000, 0, 0, 0, 0, 35000, 35000, '2022-10-21 06:57:10', '2022-10-21 06:57:10'),
(2, 'J-20221021-73-1-00003', 2106, 1, 1, 60000, 0, 0, 0, 0, 60000, 60000, '2022-10-27 07:47:38', '2022-10-27 07:47:38'),
(3, 'J-20221021-73-1-00003', 990, 1, 1, 20000, 0, 0, 20, 4000, 20000, 16000, '2022-10-27 07:47:38', '2022-10-27 07:47:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbhutang`
--
ALTER TABLE `tbhutang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbhutangdetil`
--
ALTER TABLE `tbhutangdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbjual`
--
ALTER TABLE `tbjual`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbjualdetil`
--
ALTER TABLE `tbjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkaryawan`
--
ALTER TABLE `tbkaryawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkas`
--
ALTER TABLE `tbkas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbkategori`
--
ALTER TABLE `tbkategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbkonsumen`
--
ALTER TABLE `tbkonsumen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tblogsmenu`
--
ALTER TABLE `tblogsmenu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbmenu`
--
ALTER TABLE `tbmenu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbpembelian`
--
ALTER TABLE `tbpembelian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembelian_inventories_id_pembelian_unique` (`id_pembelian`);

--
-- Indeks untuk tabel `tbpembeliandetil`
--
ALTER TABLE `tbpembeliandetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbpiutang`
--
ALTER TABLE `tbpiutang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbpiutangdetil`
--
ALTER TABLE `tbpiutangdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbretur`
--
ALTER TABLE `tbretur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbsales`
--
ALTER TABLE `tbsales`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbsatuan`
--
ALTER TABLE `tbsatuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `tbsupplier`
--
ALTER TABLE `tbsupplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`iduser`);

--
-- Indeks untuk tabel `tempjualdetil`
--
ALTER TABLE `tempjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `temppembeliandetil`
--
ALTER TABLE `temppembeliandetil`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trashjual`
--
ALTER TABLE `trashjual`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `trashjualdetil`
--
ALTER TABLE `trashjualdetil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbhutang`
--
ALTER TABLE `tbhutang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbhutangdetil`
--
ALTER TABLE `tbhutangdetil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbjualdetil`
--
ALTER TABLE `tbjualdetil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkaryawan`
--
ALTER TABLE `tbkaryawan`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkas`
--
ALTER TABLE `tbkas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkategori`
--
ALTER TABLE `tbkategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbkonsumen`
--
ALTER TABLE `tbkonsumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tblogsmenu`
--
ALTER TABLE `tblogsmenu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbmenu`
--
ALTER TABLE `tbmenu`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbpembelian`
--
ALTER TABLE `tbpembelian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbpembeliandetil`
--
ALTER TABLE `tbpembeliandetil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbpiutang`
--
ALTER TABLE `tbpiutang`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbpiutangdetil`
--
ALTER TABLE `tbpiutangdetil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbretur`
--
ALTER TABLE `tbretur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbsales`
--
ALTER TABLE `tbsales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tbsatuan`
--
ALTER TABLE `tbsatuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbsupplier`
--
ALTER TABLE `tbsupplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `iduser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tempjualdetil`
--
ALTER TABLE `tempjualdetil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `temppembeliandetil`
--
ALTER TABLE `temppembeliandetil`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `trashjualdetil`
--
ALTER TABLE `trashjualdetil`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
