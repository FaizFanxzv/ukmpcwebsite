-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Waktu pembuatan: 02 Jul 2026 pada 12.38
-- Versi server: 11.4.12-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41492242_ukmpcunesa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `Id_absensi` int(11) NOT NULL,
  `Anggota` char(15) NOT NULL,
  `Tanggal` date NOT NULL,
  `Jadwal` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Keterangan` text NOT NULL,
  `Poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`Id_absensi`, `Anggota`, `Tanggal`, `Jadwal`, `Status`, `Keterangan`, `Poin`) VALUES
(1, '24051204121', '2026-04-22', 4, 'hadir', 'Aktif', 3),
(4, '25031554183', '2026-04-22', 3, 'Izin', 'hadir di kelas atlet', 1),
(6, '25031554247', '2026-04-21', 3, 'hadir', '', 3),
(7, '24030214129', '2026-04-23', 5, 'hadir', 'hafal nilai nilai bidak catur', 3),
(8, '24031554184', '2026-04-22', 4, 'Izin', 'kerja kelompok project uas', 1),
(9, '24030204135', '2026-04-21', 3, 'hadir', 'tidak Berhasil menyelesaikan soal Ending', 2),
(10, '24080314173', '2026-04-21', 3, 'Izin', 'Kerja kelompok', 1),
(11, '24030204079', '2026-04-21', 3, 'hadir', 'Berhasil menjawab teka-teki ending', 3),
(12, '24030234055', '2026-04-21', 3, 'Izin', 'nggak tau info', 1),
(13, '24030244054', '2026-04-23', 5, 'hadir', 'kalah dalam bermain secara kelompok', 2),
(14, '25022044073', '2026-04-23', 5, 'hadir', 'kalah dalam bermain catur secara kelompok', 2),
(15, '24031554184', '2026-04-30', 4, 'hadir', '', 3),
(16, '25091397080', '2026-04-22', 4, 'Alpha', '-', 0),
(17, '25030214073', '2026-04-30', 3, 'hadir', 'notasi', 3),
(18, '25030214073', '2026-04-21', 3, 'hadir', 'end game', 3),
(19, '25031554247', '2026-04-30', 3, 'Izin', 'Lomba ITB\r\n', 1),
(20, '24051204106', '2026-04-30', 3, 'hadir', '', 2),
(21, '24030214129', '2026-04-30', 5, 'hadir', 'paham notasi', 3),
(22, '25031554183', '2026-04-21', 3, 'hadir', 'Bisa menjawab Pertanyaan', 3),
(23, '25050874077', '2026-04-23', 5, 'hadir', 'Bisa Mnegulas kembali dan bisa menjawab Pertanyaan', 3),
(24, '25050974144', '2026-04-23', 5, 'Izin', 'Pulang Kampung', 1),
(25, '25041344084', '2026-04-21', 3, 'hadir', 'Bisa Menngulas dan Menjawab Pertanyaan', 3),
(26, '25142154058', '2026-04-21', 3, 'Alpha', 'Mbuh', 0),
(27, '25050874023', '2026-04-22', 4, 'Alpha', 'Kayaknya Sibuk', 0),
(28, '25050974025', '2026-04-23', 5, 'hadir', 'Bisa Menjawabn pertanyaan', 3),
(29, '25050524095', '2026-04-22', 5, 'hadir', '', 3),
(30, '25050524095', '2026-05-28', 5, 'Izin', 'acara keluarga', 1),
(33, '25091397080', '2026-04-30', 4, 'Izin', 'izin', 1),
(34, '24051204121', '2026-04-30', 4, 'hadir', 'hadir', 3),
(39, '24030204052', '2026-04-23', 5, 'hadir', 'hadir ', 3),
(40, '24030204052', '2026-04-30', 5, 'hadir', 'hadir', 3),
(43, '25031554218', '2026-04-21', 3, 'hadir', 'hadir ', 1),
(44, '25031554079', '2026-04-21', 3, 'hadir', 'belum pemaparan materi', 2),
(45, '25031554218', '2026-04-22', 3, 'hadir', 'hadir ', 2),
(46, '25031554218', '2026-04-30', 3, 'hadir', 'Hadir aktif', 3),
(47, '25050974144', '2026-04-30', 5, 'Izin', 'Pulang Kampung', 1),
(48, '25091397108', '2026-04-23', 5, 'hadir', 'hadir', 2),
(49, '25091397108', '2026-04-30', 5, 'hadir', 'hadir', 2),
(50, '25051204005', '2026-04-21', 3, 'Izin', 'Sakit', 1),
(51, '25142134035', '2026-04-23', 5, 'Alpha', 'Horor', 0),
(52, '25042037024', '2026-04-21', 3, 'hadir', 'hadir', 2),
(53, '25042037024', '2026-04-30', 3, 'hadir', 'hadir', 2),
(54, '25142134035', '2026-04-30', 5, 'hadir', 'Horor lagi ga ada keterangan apa apa', 2),
(55, '25080554128', '2026-04-21', 3, 'Izin', 'izin', 1),
(56, '25080554128', '2026-04-30', 3, 'hadir', 'hadir', 2),
(57, '24030204079', '2026-04-30', 3, 'hadir', '', 3),
(58, '24030204135', '2026-04-30', 3, 'hadir', '', 3),
(59, '24030244054', '2026-04-30', 5, 'Izin', '', 1),
(60, '24030234055', '2026-04-30', 3, 'Izin', '', 1),
(61, '24051204121', '2026-04-30', 4, 'hadir', '', 3),
(62, '24080314173', '2026-04-30', 3, 'Izin', '', 1),
(63, '25022044073', '2026-04-30', 5, 'Izin', '', 1),
(64, '25031864085', '2026-04-30', 5, 'Izin', '', 1),
(65, '25050754193', '2026-04-30', 5, 'Izin', '', 1),
(66, '25050974025', '2026-04-30', 5, 'hadir', 'masih Bingung dan butuh Latihan lagi', 2),
(67, '25031554183', '2026-04-30', 3, 'hadir', 'Aktif dan dapat menjawab Pertanyaan', 3),
(68, '25050874077', '2026-04-30', 5, 'Izin', 'kurang Fit , Sakit', 1),
(69, '25142154058', '2026-04-30', 3, 'Alpha', 'Ga ada keterangan', 0),
(70, '25051204005', '2026-04-30', 3, 'hadir', 'Bisa Menjawab Pertanyaan', 3),
(71, '25041344084', '2026-04-30', 3, 'hadir', 'bisa menjawab pertanyaan dan menjelaskan', 3),
(72, '25050874023', '2026-04-30', 4, 'Alpha', 'Sibuk Banget sampai gada Kabar', 0),
(73, '24050874126', '2026-04-21', 3, 'Alpha', '', 0),
(74, '24050874126', '0000-00-00', 3, 'Alpha', 'ron tanggal e hilangkan. ganti pertemuan ke-n aja\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n-', 0),
(75, '25080554128', '2026-05-05', 3, 'Izin', 'izin', 1),
(76, '25091397080', '2026-05-07', 4, 'Izin', 'Pulang RS ', 1),
(77, '24030214129', '2026-05-07', 5, 'hadir', 'opening Italian game', 3),
(78, '25031554218', '2026-05-05', 3, 'hadir', 'Hadir, aktip', 3),
(79, '25042037024', '2026-05-05', 3, 'hadir', 'Hadir aktip', 3),
(80, '25081494157', '2026-05-05', 3, 'hadir', 'hadir ', 2),
(81, '25091397108', '2026-05-13', 5, 'Sakit', 'Sakit blm pulih ', 1),
(84, '25031554079', '2026-05-05', 3, 'hadir', 'menjawab puzzle yang diberikan', 3),
(85, '25030214073', '2026-05-05', 3, 'hadir', 'menjawab puzzle yang diberikan', 3),
(86, '25031554247', '2026-05-13', 3, 'Izin', 'ada lomba', 1),
(87, '24030214129', '2026-05-13', 5, 'hadir', '', 2),
(88, '24030204052', '2026-05-07', 5, 'hadir', 'hadir', 2),
(89, '25031554218', '2026-05-07', 3, 'hadir', 'hadir', 2),
(90, '25081494157', '2026-05-13', 3, 'hadir', 'hadir', 2),
(91, '25042037024', '2026-05-13', 3, 'hadir', 'hadir', 2),
(92, '25031554218', '2026-05-13', 3, 'hadir', 'hadir', 2),
(93, '25031554218', '2026-05-19', 3, 'hadir', 'hadir', 2),
(94, '25042037024', '2026-05-19', 3, 'hadir', 'hadir.', 2),
(95, '25081494157', '2026-05-19', 3, 'hadir', 'hadir', 2),
(96, '25091397108', '2026-05-19', 5, 'Izin', 'kerkel', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `NIM` char(15) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Prodi` varchar(100) NOT NULL,
  `No_Telp` varchar(20) NOT NULL,
  `Level` int(11) NOT NULL,
  `Poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`NIM`, `Nama`, `Prodi`, `No_Telp`, `Level`, `Poin`) VALUES
('23010664134', '4 - Diva Ramadina', 'Psikologi', '81338656133', 4, 0),
('23021254048', '2 - Nauval Fairuz Zahran', 'Musik', '85791921765', 6, 0),
('24020074115', '2 - Muhammad Ilham Rizqiyanu ', 'S1 Pendidikan Bahasa dan Sastra Indonesia ', '85853395463', 6, 0),
('24030174071', '4 - Tri Apriyanto Nur Sandy ', 'Pendidikan Matematika', '87892922845', 5, 0),
('24030204052', '2 - Wiwin Sugiarti', 'Pendidikan Biologi', '85706065346', 6, 8),
('24030204079', '3 - Amelia Nur Fibriarti', 'Pendidikan Biologi', '85710588056', 5, 6),
('24030204135', '3 - Septiani Nur Khasanah', 'Pendidikan Biologi', '85640626445', 5, 5),
('24030214129', '5 - Izazil Maghfuri', 'Matematika', '85730913468', 6, 11),
('24030234055', '3 - Naufal Zuhdi Al Hakim', 'Kimia Murni', '85233168228', 5, 2),
('24030244054', '3 - Savania Sahda Fiani', 'Biologi', '85608517840', 6, 3),
('24030654061', '5 - Mochammad Andika Firdaus', 'Pendidikan IPA', '89522651850', 6, 0),
('24031554184', '5 - ACM In\'am Cavan Rijal Musyafa\'', 'Sains Data', '85784078531', 4, 4),
('24041185169', '4 - Nisriina', 'Ilmu Komunikasi', '82338637627', 6, 0),
('24050874126', '4 - Sandyka Dwi Arta', 'Teknik Elektro', '89613076300', 5, 0),
('24051204106', '5 - Muhammad Naufal Zakcky Dzikrillah', 'Teknik Informatika', '81252264491', 5, 2),
('24051204121', '3 - Ali Syava Ramadhan', 'Teknik Informatika', '895809621100', 4, 9),
('24080314173', '3 - Ahmad Zain Quraisy', 'Pendidikan Administrasi Perkantoran', '83848097126', 5, 2),
('24081194053', '4 - Iqbal Bayan Arkan H.E', 'Ekonomi Islam', '89688066936', 5, 0),
('25022044073', '3 - Nabilah Ratnaduhita', 'D4 Film dan Animasi', '87761405216', 6, 3),
('25030214073', '5 - Bagas Aryana Devan T. H', 'Matematika', '88975990845', 5, 9),
('25030244072', '4 - Muhammad Faiq Widiapratama', 'Biologi', '81230478100', 6, 0),
('25031554079', '5 - Muhammad Thoriq Sadewo', 'Sains Data', '81218043525', 5, 5),
('25031554183', '1 - Muhammad Naufal Akif Magal', 'Sains Data', '82131964129', 5, 7),
('25031554218', '2 - Naufal Zhafran Basalamah', 'Sains Data', '82313358421', 5, 15),
('25031554247', '5 - Ferliyana Ronnan', 'Sains Data', '81311985700', 5, 5),
('25031864085', '3 - Muhammad Hanif Aulia', 'Sains Aktuari', '85784661776', 6, 1),
('25032014011', '5 - Fahmi Bima Yudhistira', 'Kecerdasan Artifisial', '81779333506', 6, 0),
('25041344084', '1 - Lintang Pertiwi', 'Pendidikan IPS', '85855802009', 5, 6),
('25042037024', '2 - Rafi Zaidan Ilma Wicaksono', 'Produksi Media ', '81219491906', 5, 11),
('25050524095', '4 - Andika Setiobudi P.', 'Pendidikan Teknik Mesin', '89524082479', 6, 4),
('25050754193', '3 - Izzuka Badaruttamam', 'Teknik Mesin', '85927775981', 6, 1),
('25050874023', '1 - Dani Gunawan', 'Teknik Elektro', '881027439500', 4, 0),
('25050874077', '1 - Steven Rain Martien', 'Teknik Elektro', '81210800963', 6, 4),
('25050974025', '1 -Jasmyne Aura Janesswa ', 'Pendidikan Teknologi Informasi', '895334702772', 6, 5),
('25050974144', '1 - Muhammad Iqbal Alamsyah', 'Pendidikan Teknologi Informasi', '83134874481', 6, 2),
('25051204005', '1 - Citra Ayuning Ratri', 'Teknik Informatika', '82132497539', 5, 4),
('25080554128', '2 - Ringga Putra Artha Wahendra', 'Pendidikan Ekonomi', '801515683885', 5, 4),
('25081494157', '2 - Muhammad Farras As-Sudais', 'BIsnis Digital', '81931782681', 5, 6),
('25091397080', '2 - Defani Natalia Ningrum', 'Manajmene Informatika', '85775521738', 4, 2),
('25091397108', '2 - Aisyah Currents', 'Manajemen Informatika', '89680355006', 6, 6),
('25120664257', '5 - Alida Nur Rajabiyah ', 'Psikologi', '881027262265', 6, 0),
('25120664347', '4 - Tsania Manzilatul Husna', 'Psikologi', '85701722172', 6, 0),
('25142134035', '1 - Hafiz Adhitama A', 'Biosains Hewan', '8', 6, 2),
('25142154058', '1 - Almalia Fajerin', 'Teknologi Pangan dan Hasil Pertanian', '82335264002', 5, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `nama_event` varchar(200) NOT NULL,
  `tanggal_event` date NOT NULL,
  `lokasi` varchar(200) NOT NULL,
  `penyelenggara` varchar(100) NOT NULL,
  `tanggal_seleksi` date NOT NULL,
  `syarat_poin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id_event`, `nama_event`, `tanggal_event`, `lokasi`, `penyelenggara`, `tanggal_seleksi`, `syarat_poin`) VALUES
(1, 'Ubaya Rapid Chess Competition', '2026-05-10', 'BG Junction', 'Ubaya', '2026-05-04', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `Id_Jadwal` int(11) NOT NULL,
  `Hari` varchar(10) NOT NULL,
  `Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`Id_Jadwal`, `Hari`, `Level`) VALUES
(3, 'Selasa', 5),
(4, 'Rabu', 4),
(5, 'Kamis', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `Id_Level` int(11) NOT NULL,
  `Nama_Level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`Id_Level`, `Nama_Level`) VALUES
(4, 'Atlet'),
(5, 'intermediate'),
(6, 'Beginner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seleksi`
--

CREATE TABLE `seleksi` (
  `id_seleksi` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `anggota` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `seleksi`
--

INSERT INTO `seleksi` (`id_seleksi`, `event`, `anggota`) VALUES
(1, 1, '25051204005'),
(2, 1, '25050874023'),
(3, 1, '25041344084'),
(4, 1, '25031554183'),
(5, 1, '25050874077'),
(6, 1, '25050974025'),
(7, 1, '25091397108'),
(8, 1, '25091397080'),
(9, 1, '24031554184'),
(10, 1, '25031554218'),
(11, 1, '24051204121'),
(12, 1, '25042037024'),
(13, 1, '25030214073'),
(14, 1, '25080554128'),
(15, 1, '24030204079'),
(16, 1, '25031554247'),
(17, 1, '25022044073'),
(18, 1, '24030214129'),
(19, 1, '24030244054'),
(20, 1, '25050524095'),
(21, 1, '23010664134'),
(22, 1, '24030204135');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `jabatan` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `jabatan`) VALUES
(1, 'Fata Favian Cannavaro', 'Fata', '$2y$10$YMbOjLB7NW9CtEwPueA9f.rSdKBCmRUX5RmYbITezSKL3iaDbCeFu', 'AK'),
(2, 'Muhammad Faiz Risqullah Ramadhan', 'Faiz', '$2y$10$LBz3md8zbf/7AoAMxXMgp.tmh/wfQgXbkSES5ZKMqawgWh2N8GD1i', 'AK'),
(5, 'Savania Sahda', 'Savania', '$2y$10$xCPBul8dP9jlMxlQ8x9OEur3etETuEr.rufh9Ygp8.ArpV9IKRCny', 'PSDU'),
(6, 'Jasmyne Aura', 'Aura', '$2y$10$fjAx3dVru1eKRTSqrY8dwOESs2ASt8uSiESfpZ/e6KSGkNyLeFWve', 'BPH'),
(7, 'Muhammad Haikal', 'Lakiah', '$2y$10$sPt0p3op6d/x9gOyx2iP3uTG43VxYa90yqVPM/wOGCSx7W4k4Ia7y', 'BPH'),
(8, 'Ragil Adit Pamungkas', 'Souron', '$2y$10$O.T/sSIvk7o4T/4wHTtS3eTbi4eYsk1YaCCAS9CynG28LVEXInYSO', 'BPH'),
(9, 'Rafael Kimi Abednego Tambunan', 'rafael', '$2y$10$.bZ06q3Up8kdANOhBzZ2BeGmHmAT1H9WLLKpAeKG3UxK/YiAcaauS', 'AK'),
(10, 'Nizam Ramdani', 'ZHAHANAS', '$2y$10$t8ylJsCAr2ZhesNt7B39GOJQ42hqwnp5Uqvtwj5dW1qWXwhurCWK6', 'KOMINFO'),
(11, 'Nisrina', 'Erin', '$2y$10$6eRVHWJPYbRntdvJFSXXKuWMwQMCYiqbgLHW1NiE41BlsSOBVMu1C', 'BPH'),
(12, 'Lintang Pertiwi', 'Lintang', '$2y$10$ESERE5aunr9scq5D/qbzg.t.8kNWBWtR21c82evZVVRSyQg0t3nQ.', 'BPH'),
(13, 'Amelia Nur Fibriarti', 'Amel', '$2y$10$O0NISEIUjIEVm25l2KGvQu8sBSuNWyZ9WCr3mqvgb6KmWwdsrocGG', 'BPH'),
(14, 'Mochammad Andika Firdaus', 'Andika', '$2y$10$9TN8xtR.MbtUPE60QOmyRuy985PQCbRnzfe61B1LfiwjyYDFhz1Da', 'AK'),
(15, 'Septiani Nur Khasanah', 'septiorangbaik', '$2y$10$EP6jgpretg/HpfkDyCY/T.piJqRqucG7OQ4bIU0gGwLQl6AiCeRU.', 'AK'),
(16, 'Muhammad Hisyam', 'semsemsem', '$2y$10$bMGATKfS5eEcGnLNgDmKPunIFQKh6BmiB3/CMzOoTha08GGRgXF7y', 'AK'),
(17, 'Ahmad Sahru Fahri Alfiyan', 'alfingantenk', '$2y$10$FhPiLh71W1d.6nie0yEkouz27QLvgLlA8SmrxT8.tnUNd9GRrLrPu', 'AK'),
(18, 'Iqbal Bayan Arkan H. F.', 'Iqbal', '$2y$10$pbAAqyat1Amn3j6QJAMRg.zDES0V/v5DXAXMS.OGIP6A6aBYUyiXC', 'PSDU'),
(19, 'Tri Apriyanto Nur Sandy', 'Sandy', '$2y$10$aFGD1AuKiApTO5WaKAoaleT4pE2SF7FAxgOn8gsDvT6z7WM8Ar9nC', 'PSDU'),
(20, 'Brian Dagna Bimantoro', 'Brian', '$2y$10$dQsEaNsCGb63xFVio8PdgOVgusxXLr0greQO7Qrisw/DhPxB3vUq6', 'PSDU'),
(21, 'Izazil Maghfuri', 'Iza', '$2y$10$kNpyg.thbQCQoCdtkbax6um3KdylPNgya2zFdn6DomvlSiGBLBQZO', 'PSDU'),
(22, 'Fahmi Bima Yudhistira', 'Bima', '$2y$10$oHomqW6MFui48xhiPX00G.JGIPR28lPew.mhwpULmxJk2tq4qn1KS', 'KOMINFO'),
(23, 'Ahmad Zain Quraisy', 'Zain', '$2y$10$TL1M65ELMk8CoIzfuSepdOUwRgPNaEzK/ENgci0sG.UeTZWAWYg9W', 'KOMINFO'),
(24, 'Wiwin Sugiarti', 'Wiwin', '$2y$10$VEY3F29GME6mARlpVoY5feOuevvwnCYav/QjjexfmglelhlnO/chG', 'KOMINFO'),
(25, 'Muhammad Naufal Zaki', 'Zaki', '$2y$10$sbEMpLWJse0fXLgS6.l84Obxb5GcblMNguveGInDRNzbiAxKoCSeW', 'KOMINFO'),
(26, 'Anggota UKM Penggemar Catur', 'anggotaukmpcunesa', '$2y$10$.suCcOGY/BAPayzOoDNyd.KMx.3NZDpyJH3i5QdCzgtMkY9PN87Py', 'Anggota');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`Id_absensi`),
  ADD KEY `Anggota` (`Anggota`),
  ADD KEY `Jadwal` (`Jadwal`);

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`NIM`),
  ADD KEY `Level_Anggota` (`Level`);

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`Id_Jadwal`),
  ADD KEY `Level` (`Level`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`Id_Level`);

--
-- Indeks untuk tabel `seleksi`
--
ALTER TABLE `seleksi`
  ADD PRIMARY KEY (`id_seleksi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `Id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT untuk tabel `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `Id_Jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `Id_Level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `seleksi`
--
ALTER TABLE `seleksi`
  MODIFY `id_seleksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `Anggota` FOREIGN KEY (`Anggota`) REFERENCES `anggota` (`NIM`),
  ADD CONSTRAINT `Jadwal` FOREIGN KEY (`Jadwal`) REFERENCES `jadwal` (`Id_Jadwal`);

--
-- Ketidakleluasaan untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `Level_Anggota` FOREIGN KEY (`Level`) REFERENCES `level` (`Id_Level`);

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `Level` FOREIGN KEY (`Level`) REFERENCES `level` (`Id_Level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
