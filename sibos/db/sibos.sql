-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2016 at 03:04 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sibos`
--
CREATE DATABASE `sibos`;
USE `sibos`;

-- --------------------------------------------------------

--
-- Table structure for table `belanja`
--

CREATE TABLE IF NOT EXISTS `belanja` (
  `id_belanja` int(11) NOT NULL,
  `jns_belanja` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dana`
--

CREATE TABLE IF NOT EXISTS `dana` (
  `id_dana` int(5) NOT NULL,
  `tgl` date NOT NULL,
  `id_pajak` int(5) NOT NULL,
  `uraian` text NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `komponen`
--

CREATE TABLE IF NOT EXISTS `komponen` (
  `id_komponen` int(5) NOT NULL,
  `komponen` varchar(50) NOT NULL,
  `id_satuan` int(5) NOT NULL,
  `id_rekening` int(5) NOT NULL,
  `id_belanja` int(5) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pajak`
--

CREATE TABLE IF NOT EXISTS `pajak` (
  `id_pajak` int(5) NOT NULL,
  `jns_pajak` varchar(50) NOT NULL,
  `jumlah` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rapbs`
--

CREATE TABLE IF NOT EXISTS `rapbs` (
  `id_rapbs` int(5) NOT NULL,
  `nss` int(5) NOT NULL,
  `id_satuan` int(5) NOT NULL,
  `id_komponen` int(5) NOT NULL,
  `tahun` date NOT NULL,
  `koefisien1` int(10) NOT NULL,
  `koefisien2` int(10) NOT NULL,
  `koefisien3` int(10) NOT NULL,
  `koefisien4` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=53546 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `realisasi`
--

CREATE TABLE IF NOT EXISTS `realisasi` (
  `id_realisasi` int(5) NOT NULL,
  `id_komponen` int(5) NOT NULL,
  `tgl_realisasi` date NOT NULL,
  `jml_realisasi` int(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE IF NOT EXISTS `rekening` (
  `id_rekening` int(5) NOT NULL,
  `nm_rekening` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sekolah`
--

CREATE TABLE IF NOT EXISTS `sekolah` (
  `nss` int(5) NOT NULL,
  `nama_sklh` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nama_kpl` varchar(50) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36566757 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belanja`
--
ALTER TABLE `belanja`
  ADD PRIMARY KEY (`id_belanja`);

--
-- Indexes for table `dana`
--
ALTER TABLE `dana`
  ADD PRIMARY KEY (`id_dana`), ADD KEY `fk_pajak` (`id_pajak`);

--
-- Indexes for table `komponen`
--
ALTER TABLE `komponen`
  ADD PRIMARY KEY (`id_komponen`), ADD KEY `fk_satuan` (`id_satuan`), ADD KEY `fk_rekening` (`id_rekening`), ADD KEY `fk_belanja` (`id_belanja`);

--
-- Indexes for table `pajak`
--
ALTER TABLE `pajak`
  ADD PRIMARY KEY (`id_pajak`);

--
-- Indexes for table `rapbs`
--
ALTER TABLE `rapbs`
  ADD PRIMARY KEY (`id_rapbs`), ADD KEY `fk_sklh` (`nss`), ADD KEY `fk_satuan` (`id_satuan`), ADD KEY `fk_kom` (`id_komponen`);

--
-- Indexes for table `realisasi`
--
ALTER TABLE `realisasi`
  ADD PRIMARY KEY (`id_realisasi`), ADD KEY `fk_komponen` (`id_komponen`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `sekolah`
--
ALTER TABLE `sekolah`
  ADD PRIMARY KEY (`nss`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `belanja`
--
ALTER TABLE `belanja`
  MODIFY `id_belanja` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dana`
--
ALTER TABLE `dana`
  MODIFY `id_dana` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `komponen`
--
ALTER TABLE `komponen`
  MODIFY `id_komponen` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pajak`
--
ALTER TABLE `pajak`
  MODIFY `id_pajak` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rapbs`
--
ALTER TABLE `rapbs`
  MODIFY `id_rapbs` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `realisasi`
--
ALTER TABLE `realisasi`
  MODIFY `id_realisasi` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id_rekening` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sekolah`
--
ALTER TABLE `sekolah`
  MODIFY `nss` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `dana`
--
ALTER TABLE `dana`
ADD CONSTRAINT `dana_ibfk_1` FOREIGN KEY (`id_pajak`) REFERENCES `pajak` (`id_pajak`)  ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komponen`
--
ALTER TABLE `komponen`
ADD CONSTRAINT `komponen_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `komponen_ibfk_2` FOREIGN KEY (`id_rekening`) REFERENCES `rekening` (`id_rekening`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `komponen_ibfk_3` FOREIGN KEY (`id_belanja`) REFERENCES `belanja` (`id_belanja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rapbs`
--
ALTER TABLE `rapbs`
ADD CONSTRAINT `rapbs_ibfk_1` FOREIGN KEY (`nss`) REFERENCES `sekolah` (`nss`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `rapbs_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `rapbs_ibfk_3` FOREIGN KEY (`id_komponen`) REFERENCES `komponen` (`id_komponen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `realisasi`
--
ALTER TABLE `realisasi`
ADD CONSTRAINT `realisasi_ibfk_1` FOREIGN KEY (`id_komponen`) REFERENCES `komponen` (`id_komponen`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
