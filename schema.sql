-- ===================================================================
-- SETĂRI INIȚIALE ȘI CREAREA BAZEI DE DATE
-- ===================================================================
CREATE DATABASE IF NOT EXISTS `statistici_droguri` CHARACTER SET utf8mb4 COLLATE utf8mb4_romanian_ci;
USE `statistici_droguri`;

-- Dezactivăm temporar verificarea cheilor străine pentru a putea rescrie tabelele
SET FOREIGN_KEY_CHECKS = 0; 

-- Ștergem tabelele dacă există deja (pentru a putea rula scriptul de mai multe ori fără erori)
DROP TABLE IF EXISTS `prevalenta_timp_prima_injectare`, `prevalenta_varsta`, `prevalenta_sex`, 
                     `diagnostic_urgenta`, `cale_administrare`, `varsta_urgente`, `sex_urgente`, 
                     `ocupatie_pacienti`, `nivel_educational`, `situatie_locativa`, `surse`, 
                     `varsta_pacienti`, `sex_pacienti`, `regim_tratament`, `actiuni`, `precursori`, 
                     `lege_condamnari`, `confiscari`, `tipuri_droguri`, `condamnari`, `substante`, 
                     `proiecte`, `boli`, `legi`, `categorii_droguri`;

-- Reactivăm verificarea cheilor străine
SET FOREIGN_KEY_CHECKS = 1;

-- ===================================================================
-- 1. NOMENCLATOARE (Tabele de bază ce nu depind de alte tabele)
-- ===================================================================

CREATE TABLE `categorii_droguri` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `legi` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `boli` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `proiecte` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `substante` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL,
  `categorie` int
) ENGINE=InnoDB;

CREATE TABLE `condamnari` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `numar` int,
  `sex` varchar(255),
  `minor` bool,
  `an` int
) ENGINE=InnoDB;

-- ===================================================================
-- 2. TABELE CU DEPENDENȚE (Conțin Foreign Keys către Nomenclatoare)
-- ===================================================================

CREATE TABLE `tipuri_droguri` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nume` varchar(255) UNIQUE NOT NULL,
  `id_categorie` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `confiscari` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_drog` int,
  `grame` decimal(15,2),
  `comprimate` int,
  `doze` int,
  `mililitri` decimal(15,2),
  `nr_capturi` int,
  `an` int,
  FOREIGN KEY (`id_drog`) REFERENCES `tipuri_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `lege_condamnari` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_lege` int,
  `numar` int,
  `an` int,
  FOREIGN KEY (`id_lege`) REFERENCES `legi`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `precursori` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_substanta` int,
  `nr_operatiuni` int,
  `an` int,
  FOREIGN KEY (`id_substanta`) REFERENCES `substante`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `actiuni` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_proiect` int,
  `nr_beneficiari` int,
  `an` int,
  FOREIGN KEY (`id_proiect`) REFERENCES `proiecte`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===================================================================
-- 3. DATE PACIENȚI & TRATAMENT (Grupate pe Categorii de Droguri)
-- ===================================================================

CREATE TABLE `regim_tratament` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `regim` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `sex_pacienti` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `sex` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `varsta_pacienti` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `interval` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `surse` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `sursa` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `situatie_locativa` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `situatie` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `nivel_educational` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `nivel` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `ocupatie_pacienti` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `ocupatie` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===================================================================
-- 4. URGENȚE MEDICALE (Grupate pe Categorii de Droguri)
-- ===================================================================

CREATE TABLE `sex_urgente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `sex` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `varsta_urgente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `interval` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `cale_administrare` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `cale` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `diagnostic_urgenta` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `diagnostic` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===================================================================
-- 5. BOLI INFECȚIOASE (Grupate pe Tip de Boală)
-- ===================================================================

CREATE TABLE `prevalenta_sex` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_boala` int,
  `sex` varchar(255),
  `nr_testati` int,
  `nr_pozitivi` int,
  FOREIGN KEY (`id_boala`) REFERENCES `boli`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `prevalenta_varsta` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_boala` int,
  `interval_varsta` varchar(255),
  `nr_testati` int,
  `nr_pozitivi` int,
  FOREIGN KEY (`id_boala`) REFERENCES `boli`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `prevalenta_timp_prima_injectare` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_boala` int,
  `interval` varchar(255),
  `nr_testati` int,
  `nr_pozitivi` int,
  FOREIGN KEY (`id_boala`) REFERENCES `boli`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;