-- ===================================================================
-- POPULARE TABEL: confiscari
-- Date preluate si prelucrate din "capturi-droguri-2022"
-- ===================================================================

USE `statistici_droguri`;

INSERT INTO `confiscari` (`id_drog`, `grame`, `comprimate`, `doze`, `mililitri`, `nr_capturi`, `an`) VALUES
((SELECT id FROM tipuri_droguri WHERE nume = 'Heroină'), 191288.96, NULL, 1, NULL, 373, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Cocaină'), 80117.56, NULL, NULL, NULL, 646, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Amfetamină'), 13960.68, 5438, NULL, 200.00, 302, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Metamfetamină'), 732.14, NULL, NULL, NULL, 15, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'MDMA'), 2372.16, 45355, NULL, NULL, 635, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Metadonă'), 3.26, 1157, NULL, 55.00, 122, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Oxicodonă'), NULL, 20, NULL, 505.30, 3, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Morfină'), 0.03, 3941, NULL, 1049.00, 5, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Opiu'), 119365.60, NULL, NULL, NULL, 2, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'LSD'), NULL, NULL, 1414, 1.90, 26, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Codeină'), 2.55, 80, NULL, NULL, 6, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ciuperci halucinogene'), 752.64, NULL, NULL, NULL, 47, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Canabinoizi sintetici'), 593.74, NULL, NULL, 9.00, 115, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Catinone'), 16968.63, 1, NULL, NULL, 74, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = '2C-X'), 1.46, 70, NULL, NULL, 10, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Petidină'), NULL, NULL, NULL, 420.00, 1, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Fentanyl'), NULL, 8142, 267, 20.00, 7, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Dihidrocodeină'), NULL, 410, NULL, NULL, 1, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Triptamine'), 414.42, NULL, NULL, NULL, 4, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Canabis'), 624938.20, NULL, NULL, NULL, 3889, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Rezină de canabis'), 12587.84, NULL, NULL, NULL, 191, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ulei de canabis'), NULL, NULL, NULL, 220.48, 4, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Soluție cu THC'), NULL, NULL, NULL, 60045.60, 17, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ketamină'), 1650.49, NULL, NULL, 369.92, 107, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Benzodiazepine'), 13.33, 442062, NULL, 86.40, 176, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Barbiturice'), NULL, 10, NULL, 16.00, 2, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Zolpidem'), NULL, 69, NULL, NULL, 4, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Amfepramonă'), NULL, 2703, NULL, NULL, 14, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Masă plante de canabis'), 652576.72, NULL, NULL, NULL, 97, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Fragmente vegetale cu THC'), 176928.09, NULL, NULL, NULL, 259, 2022),
((SELECT id FROM tipuri_droguri WHERE nume = 'Altele'), 118.90, 51, NULL, 5065.00, 14, 2022);


-- ===================================================================
-- POPULARE TABELE INFRACTIONALITATE (Condamnari 2022)
-- Date preluate din raportul "infractionalitate-2022"
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `legi`
-- -------------------------------------------------------------------
INSERT IGNORE INTO `legi` (`nume`) VALUES
('Art.2 din Legea nr. 143/2000'),
('Art.3 din Legea nr. 143/2000'),
('Art.4 din Legea nr. 143/2000'),
('Legea nr. 194/2011');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `lege_condamnari` (Corelare Legi cu Număr Condamnări)
-- -------------------------------------------------------------------
INSERT INTO `lege_condamnari` (`id_lege`, `numar`, `an`) VALUES
((SELECT id FROM legi WHERE nume = 'Art.2 din Legea nr. 143/2000'), 664, 2022),
((SELECT id FROM legi WHERE nume = 'Art.3 din Legea nr. 143/2000'), 68, 2022),
((SELECT id FROM legi WHERE nume = 'Art.4 din Legea nr. 143/2000'), 352, 2022),
((SELECT id FROM legi WHERE nume = 'Legea nr. 194/2011'), 77, 2022);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `condamnari` (Profil Demografic: Sex și Major/Minor)
-- minor = 0 înseamnă Major, minor = 1 înseamnă Minor
-- -------------------------------------------------------------------
INSERT INTO `condamnari` (`numar`, `sex`, `minor`, `an`) VALUES
-- Bărbați Majori (992)
(992, 'Masculin', 0, 2022),

-- Bărbați Minori (5)
(5, 'Masculin', 1, 2022),

-- Femei Majore (164)
(164, 'Feminin', 0, 2022),

-- Femei Minore (0 - o inserăm pentru consistența filtrelor din aplicație)
(0, 'Feminin', 1, 2022);

-- ===================================================================
-- POPULARE TABELE: PRECURSORI ȘI SUBSTANȚE CLASIFICATE (Anul 2022)
-- ===================================================================


-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `substante` (Include categoriile 1-4)
-- -------------------------------------------------------------------
INSERT IGNORE INTO `substante` (`nume`, `categorie`) VALUES
-- Categoria 1
('CLORHIDRAT DE EFEDRINĂ', 1),
('EFEDRINĂ', 1),
('CLORHIDRAT DE PSEUDOEFEDRINĂ', 1),
('TARTRAT DE ERGOTAMINĂ', 1),
('HIDROGENOMALEAT DE ERGOMETRINĂ', 1),
('ACID LISERGIC', 1),
('PIPERONAL', 1),

-- Categoria 2
('PERMANGANAT DE POTASIU', 2),
('FOSFOR ROȘU', 2),
('PIPERIDINĂ', 2),

-- Categoria 3
('ACID SULFURIC', 3),
('ACID CLORHIDRIC', 3),
('TOLUEN', 3),
('METILETILCETONĂ', 3),
('ACETONĂ', 3),

-- Categoria 4
('Medicamente cu conținut de clorhidrat de pseudoefedrină', 4);


-- -------------------------------------------------------------------
-- 2. Populare tabel: `precursori` (Corelarea substanțelor cu nr. operațiuni)
-- -------------------------------------------------------------------
INSERT INTO `precursori` (`id_substanta`, `nr_operatiuni`, `an`) VALUES
-- Date pentru Categoria 1
((SELECT id FROM substante WHERE nume = 'CLORHIDRAT DE EFEDRINĂ'), 13, 2022),
((SELECT id FROM substante WHERE nume = 'EFEDRINĂ'), 12, 2022),
((SELECT id FROM substante WHERE nume = 'CLORHIDRAT DE PSEUDOEFEDRINĂ'), 15, 2022),
((SELECT id FROM substante WHERE nume = 'TARTRAT DE ERGOTAMINĂ'), 8, 2022),
((SELECT id FROM substante WHERE nume = 'HIDROGENOMALEAT DE ERGOMETRINĂ'), 8, 2022),
((SELECT id FROM substante WHERE nume = 'ACID LISERGIC'), 8, 2022),
((SELECT id FROM substante WHERE nume = 'PIPERONAL'), 4, 2022),

-- Date pentru Categoria 2
((SELECT id FROM substante WHERE nume = 'PERMANGANAT DE POTASIU'), 9, 2022),
((SELECT id FROM substante WHERE nume = 'FOSFOR ROȘU'), 3, 2022),
((SELECT id FROM substante WHERE nume = 'PIPERIDINĂ'), 2, 2022),

-- Date pentru Categoria 3
((SELECT id FROM substante WHERE nume = 'ACID SULFURIC'), 36, 2022),
((SELECT id FROM substante WHERE nume = 'ACID CLORHIDRIC'), 51, 2022),
((SELECT id FROM substante WHERE nume = 'TOLUEN'), 31, 2022),
((SELECT id FROM substante WHERE nume = 'METILETILCETONĂ'), 27, 2022),
((SELECT id FROM substante WHERE nume = 'ACETONĂ'), 36, 2022),

-- Date pentru Categoria 4
((SELECT id FROM substante WHERE nume = 'Medicamente cu conținut de clorhidrat de pseudoefedrină'), 33, 2022);

-- ===================================================================
-- POPULARE TABELE: PROIECTE ȘI ACȚIUNI (PREVENIRE 2022)
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `proiecte`
-- -------------------------------------------------------------------
INSERT IGNORE INTO `proiecte` (`nume`) VALUES
('Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI (Nivel preșcolar)'),
('Proiect național ABC-UL EMOŢIILOR (Nivel primar)'),
('Proiect național NECENZURAT (Nivel gimnazial)'),
('Proiect național FRED GOES NET (Nivel liceal)'),
('Proiect național MESAJUL MEU ANTIDROG (Gimnazial și Liceal)'),
('Proiect național EU ŞI COPILUL MEU (Adresat părinților)'),
('Proiect național Abilități pentru acțiune'),
('Proiect național Acționăm just'),
('Campania Ziua Națională Fără Tutun'),
('Campania 19 Zile de prevenire a abuzurilor și violențelor');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `actiuni` (Nr. beneficiari corelați cu proiectele)
-- -------------------------------------------------------------------
INSERT INTO `actiuni` (`id_proiect`, `nr_beneficiari`, `an`) VALUES
((SELECT id FROM proiecte WHERE nume = 'Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI (Nivel preșcolar)'), 22520, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național ABC-UL EMOŢIILOR (Nivel primar)'), 20073, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național NECENZURAT (Nivel gimnazial)'), 19656, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național FRED GOES NET (Nivel liceal)'), 767, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național MESAJUL MEU ANTIDROG (Gimnazial și Liceal)'), 6523, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național EU ŞI COPILUL MEU (Adresat părinților)'), 2776, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național Abilități pentru acțiune'), 6014, 2022),
((SELECT id FROM proiecte WHERE nume = 'Proiect național Acționăm just'), 3169, 2022),
((SELECT id FROM proiecte WHERE nume = 'Campania Ziua Națională Fără Tutun'), 13998, 2022),
((SELECT id FROM proiecte WHERE nume = 'Campania 19 Zile de prevenire a abuzurilor și violențelor'), 10369, 2022);


-- ===================================================================
-- POPULARE TABELE: URGENȚE MEDICALE (Anul 2022)
-- Date preluate din raportul de urgente medicale
-- ===================================================================

USE `statistici_droguri`;

-- Adăugăm tabelul lipsă din schemă pentru "Modelul de Consum"
CREATE TABLE IF NOT EXISTS `model_consum_urgente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `model` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===================================================================
-- POPULARE TABELE: URGENȚE MEDICALE (Anul 2022)
-- ===================================================================

USE `statistici_droguri`;

-- Adăugăm tabelul lipsă din schemă pentru "Modelul de Consum"
CREATE TABLE IF NOT EXISTS `model_consum_urgente` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_categorie` int,
  `model` varchar(255),
  `nr_pacienti` int,
  `an` int,
  FOREIGN KEY (`id_categorie`) REFERENCES `categorii_droguri`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- -------------------------------------------------------------------
-- 1. Populare tabel: `sex_urgente`
-- -------------------------------------------------------------------
INSERT INTO `sex_urgente` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Masculin', 714, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Feminin', 156, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Masculin', 360, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Feminin', 101, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Masculin', 193, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Feminin', 57, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Masculin', 572, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Feminin', 116, 2022);

-- -------------------------------------------------------------------
-- 2. Populare tabel: `varsta_urgente`
-- -------------------------------------------------------------------
INSERT INTO `varsta_urgente` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '<25', 494, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '25-34', 301, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '>35', 75, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '<25', 220, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '25-34', 166, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '>35', 75, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '<25', 76, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '25-34', 88, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '>35', 86, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '<25', 312, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '25-34', 261, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '>35', 115, 2022);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `cale_administrare`
-- -------------------------------------------------------------------
INSERT INTO `cale_administrare` (`id_categorie`, `cale`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Oral/fumat/prizat', 870, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Altele', 0, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Injectabil', 0, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Oral/fumat/prizat', 451, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Altele', 7, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Injectabil', 3, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Oral/fumat/prizat', 128, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Altele', 27, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Injectabil', 95, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Oral/fumat/prizat', 369, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Altele', 281, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Injectabil', 38, 2022);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `model_consum_urgente`
-- -------------------------------------------------------------------
INSERT INTO `model_consum_urgente` (`id_categorie`, `model`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Consum singular', 493, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Consum combinat', 377, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Consum singular', 175, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Consum combinat', 286, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Consum singular', 94, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Consum combinat', 156, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Consum singular', 477, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Consum combinat', 211, 2022);

-- -------------------------------------------------------------------
-- 5. Populare tabel: `diagnostic_urgenta`
-- -------------------------------------------------------------------
INSERT INTO `diagnostic_urgenta` (`id_categorie`, `diagnostic`, `nr_pacienti`, `an`) VALUES
-- Canabis
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Intoxicație', 449, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Utilizare nocivă', 83, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Dependență', 57, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Sevraj', 12, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Tulburări de comportament', 142, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Supradoză', 3, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Testare toxicologică', 124, 2022),

-- Stimulanți
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Intoxicație', 240, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Utilizare nocivă', 57, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Dependență', 44, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Sevraj', 16, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Tulburări de comportament', 68, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Supradoză', 3, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Testare toxicologică', 33, 2022),

-- Opiacee
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Intoxicație', 64, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Utilizare nocivă', 11, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Dependență', 120, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Sevraj', 23, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Tulburări de comportament', 19, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Supradoză', 6, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Testare toxicologică', 7, 2022),

-- NSP (Noi Substanțe Psihoactive -> 'Alte Substanțe' in nomenclator)
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Intoxicație', 320, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Utilizare nocivă', 41, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Dependență', 103, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Sevraj', 12, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Tulburări de comportament', 93, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Supradoză', 1, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Testare toxicologică', 118, 2022);

-- ===================================================================
-- POPULARE TABELE: TRATAMENT (TDI - Anul 2022)
-- Date agregate din raportul "tdi-date-guvern-2022"
-- ===================================================================


-- -------------------------------------------------------------------
-- 1. Populare tabel: `regim_tratament` (Ambulatoriu, Internare, Închisori)
-- -------------------------------------------------------------------
INSERT INTO `regim_tratament` (`id_categorie`, `regim`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Ambulatoriu', 420, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Internare', 312, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Penitenciar', 45, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Ambulatoriu', 89, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Internare', 51, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Penitenciar', 4, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Ambulatoriu', 158, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Internare', 126, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Penitenciar', 1, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Ambulatoriu', 1620, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Internare', 280, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Penitenciar', 76, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Ambulatoriu', 255, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Internare', 145, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Penitenciar', 12, 2022);

-- -------------------------------------------------------------------
-- 2. Populare tabel: `sex_pacienti`
-- -------------------------------------------------------------------
INSERT INTO `sex_pacienti` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Masculin', 635, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Feminin', 142, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Masculin', 121, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Feminin', 23, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Masculin', 225, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Feminin', 60, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Masculin', 1650, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Feminin', 326, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Masculin', 360, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Feminin', 52, 2022);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `varsta_pacienti`
-- -------------------------------------------------------------------
INSERT INTO `varsta_pacienti` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '<25', 48, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '25-34', 285, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '>35', 444, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '<25', 110, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '25-34', 125, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '>35', 50, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '<25', 1205, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '25-34', 550, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '>35', 221, 2022);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `surse` (Sursa de referire la tratament)
-- -------------------------------------------------------------------
INSERT INTO `surse` (`id_categorie`, `sursa`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Proprie inițiativă / Familie', 350, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Servicii medicale', 210, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Justiție / Poliție', 217, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Proprie inițiativă / Familie', 410, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Servicii medicale', 220, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Justiție / Poliție', 1346, 2022);

-- -------------------------------------------------------------------
-- 5. Populare tabel: `situatie_locativa` (Condiții de locuit)
-- -------------------------------------------------------------------
INSERT INTO `situatie_locativa` (`id_categorie`, `situatie`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Stabilă (Locuință proprie/chirie)', 520, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Instabilă / Fără adăpost', 180, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Instituție (Penitenciar/Centru)', 77, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Stabilă (Locuință proprie/chirie)', 1750, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Instabilă / Fără adăpost', 90, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Instituție (Penitenciar/Centru)', 136, 2022);

-- -------------------------------------------------------------------
-- 6. Populare tabel: `nivel_educational`
-- -------------------------------------------------------------------
INSERT INTO `nivel_educational` (`id_categorie`, `nivel`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Primar / Fără studii', 210, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Secundar (Liceu/Școală prof.)', 480, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Superior', 87, 2022),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Primar / Fără studii', 315, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Secundar (Liceu/Școală prof.)', 1420, 2022),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Superior', 241, 2022);

-- ===================================================================
-- POPULARE TABELE: BOLI INFECȚIOASE (Anul 2022 - Raport DRID)
-- ===================================================================


-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `boli`
-- -------------------------------------------------------------------
INSERT IGNORE INTO `boli` (`nume`) VALUES
('VHC'),
('HIV'),
('VHB');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `prevalenta_sex`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_sex` (`id_boala`, `sex`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC
((SELECT id FROM boli WHERE nume = 'VHC'), 'Masculin', 229, 161),
((SELECT id FROM boli WHERE nume = 'VHC'), 'Feminin', 35, 17),
-- HIV
((SELECT id FROM boli WHERE nume = 'HIV'), 'Masculin', 233, 59),
((SELECT id FROM boli WHERE nume = 'HIV'), 'Feminin', 35, 8),
-- VHB
((SELECT id FROM boli WHERE nume = 'VHB'), 'Masculin', 230, 10),
((SELECT id FROM boli WHERE nume = 'VHB'), 'Feminin', 34, 2);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `prevalenta_varsta`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_varsta` (`id_boala`, `interval_varsta`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC
((SELECT id FROM boli WHERE nume = 'VHC'), '<25', 11, 4),
((SELECT id FROM boli WHERE nume = 'VHC'), '25-34', 76, 47),
((SELECT id FROM boli WHERE nume = 'VHC'), '>34', 177, 127),
-- HIV
((SELECT id FROM boli WHERE nume = 'HIV'), '<25', 11, 0),
((SELECT id FROM boli WHERE nume = 'HIV'), '25-34', 77, 18),
((SELECT id FROM boli WHERE nume = 'HIV'), '>34', 180, 49),
-- VHB
((SELECT id FROM boli WHERE nume = 'VHB'), '<25', 11, 1),
((SELECT id FROM boli WHERE nume = 'VHB'), '25-34', 76, 4),
((SELECT id FROM boli WHERE nume = 'VHB'), '>34', 177, 7);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `prevalenta_timp_prima_injectare`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_timp_prima_injectare` (`id_boala`, `interval`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC
((SELECT id FROM boli WHERE nume = 'VHC'), '<2', 7, 1),
((SELECT id FROM boli WHERE nume = 'VHC'), 'de la 2 la 5', 17, 8),
((SELECT id FROM boli WHERE nume = 'VHC'), 'de la 5 la 10', 23, 13),
((SELECT id FROM boli WHERE nume = 'VHC'), '10 sau mai mulți', 146, 96),
-- HIV
((SELECT id FROM boli WHERE nume = 'HIV'), '<2', 7, 0),
((SELECT id FROM boli WHERE nume = 'HIV'), 'de la 2 la 5', 17, 4),
((SELECT id FROM boli WHERE nume = 'HIV'), 'de la 5 la 10', 23, 5),
((SELECT id FROM boli WHERE nume = 'HIV'), '10 sau mai mulți', 150, 32),
-- VHB
((SELECT id FROM boli WHERE nume = 'VHB'), '<2', 7, 0),
((SELECT id FROM boli WHERE nume = 'VHB'), 'de la 2 la 5', 17, 1),
((SELECT id FROM boli WHERE nume = 'VHB'), 'de la 5 la 10', 22, 1),
((SELECT id FROM boli WHERE nume = 'VHB'), '10 sau mai mulți', 147, 7);