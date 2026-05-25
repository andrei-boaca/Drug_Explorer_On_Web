-- ===================================================================
-- POPULARE TABEL: confiscari
-- Date preluate si prelucrate din "capturi-droguri" (2021)
-- ===================================================================

USE `statistici_droguri`;

-- Adaugam tipuri de droguri noi aparute in datele din 2021
-- (absent din nomenclatorul initial populat de test_populare.sql)
INSERT IGNORE INTO `tipuri_droguri` (`nume`, `id_categorie`) VALUES
('Cactus/Mescalină', (SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene')),
('Buprenorfină', (SELECT id FROM categorii_droguri WHERE nume = 'Opioide')),
('Mitraginină', (SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'));

INSERT INTO `confiscari` (`id_drog`, `grame`, `comprimate`, `doze`, `mililitri`, `nr_capturi`, `an`) VALUES
((SELECT id FROM tipuri_droguri WHERE nume = 'Heroină'), 1437392.05, NULL, NULL, NULL, 244, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Cocaină'), 874727.27, NULL, NULL, NULL, 541, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Amfetamină'), 8374.68, 83, NULL, 2.60, 283, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Metamfetamină'), 1383.53, 203, NULL, NULL, 23, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'MDMA'), 2677.23, 48594, NULL, NULL, 634, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Metadonă'), 15.34, 961, NULL, 254.00, 93, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Oxicodonă'), 0.05, 610, NULL, NULL, 5, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Morfină'), 50.86, 66, NULL, 50.00, 6, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'LSD'), 3.62, NULL, 1541, 4.70, 55, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Codeină'), 4.06, 215, NULL, NULL, 7, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ciuperci halucinogene'), 657.25, NULL, NULL, NULL, 36, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Canabinoizi sintetici'), 861.22, NULL, NULL, NULL, 4, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Catinone'), 112.44, NULL, NULL, NULL, 16, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = '2C-X'), 2.41, 459, NULL, NULL, 20, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Cactus/Mescalină'), 133.56, 10, NULL, NULL, 2, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Triptamine'), 47.89, 55, NULL, NULL, 9, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Altele'), 48.75, 30, NULL, 4087.86, 24, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Canabis'), 498009.35, NULL, NULL, NULL, 3531, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Rezină de canabis'), 6136.55, NULL, NULL, NULL, 80, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ulei de canabis'), NULL, NULL, NULL, 14.30, 3, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Ketamină'), 1905.19, NULL, NULL, 125.50, 77, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Benzodiazepine'), 3.53, 3940, NULL, 33.00, 139, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Barbiturice'), 1.00, NULL, NULL, NULL, 1, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Buprenorfină'), NULL, 1, NULL, NULL, 1, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Zolpidem'), NULL, 147, NULL, NULL, 6, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Amfepramonă'), NULL, 2124, NULL, NULL, 7, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Mitraginină'), 2.00, NULL, NULL, NULL, 1, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Masă plante de canabis'), 3586348.20, NULL, NULL, NULL, 140, 2021),
((SELECT id FROM tipuri_droguri WHERE nume = 'Fragmente vegetale cu THC'), 1341889.55, NULL, NULL, NULL, 270, 2021);


-- ===================================================================
-- POPULARE TABELE INFRACTIONALITATE (Condamnari 2021)
-- Date preluate din raportul "infractionalitate" (2021)
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `legi`
-- (INSERT IGNORE pentru cele deja existente din alte seturi de date)
-- -------------------------------------------------------------------
INSERT IGNORE INTO `legi` (`nume`) VALUES
('Art.2 din Legea nr. 143/2000'),
('Art.3 din Legea nr. 143/2000'),
('Art.4 din Legea nr. 143/2000'),
('Art.7 din Legea nr. 143/2000'),
('Legea nr. 194/2011');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `lege_condamnari`
-- -------------------------------------------------------------------
INSERT INTO `lege_condamnari` (`id_lege`, `numar`, `an`) VALUES
((SELECT id FROM legi WHERE nume = 'Art.2 din Legea nr. 143/2000'), 559, 2021),
((SELECT id FROM legi WHERE nume = 'Art.3 din Legea nr. 143/2000'), 54, 2021),
((SELECT id FROM legi WHERE nume = 'Art.4 din Legea nr. 143/2000'), 354, 2021),
((SELECT id FROM legi WHERE nume = 'Art.7 din Legea nr. 143/2000'), 1, 2021),
((SELECT id FROM legi WHERE nume = 'Legea nr. 194/2011'), 63, 2021);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `condamnari`
-- minor = 0 inseamna Major, minor = 1 inseamna Minor
-- -------------------------------------------------------------------
INSERT INTO `condamnari` (`numar`, `sex`, `minor`, `an`) VALUES
(878, 'Masculin', 0, 2021),
(4,   'Masculin', 1, 2021),
(146, 'Feminin',  0, 2021),
(3,   'Feminin',  1, 2021);


-- ===================================================================
-- POPULARE TABELE: PROIECTE SI ACTIUNI (PREVENIRE 2021)
-- Date preluate din raportul "prevenire" (2021)
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `proiecte`
-- (INSERT IGNORE pentru proiectele nationale identice cu cele din 2022)
-- -------------------------------------------------------------------
INSERT IGNORE INTO `proiecte` (`nume`) VALUES
('Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI (Nivel preșcolar)'),
('Proiect național ABC-UL EMOŢIILOR (Nivel primar)'),
('Proiect național NECENZURAT (Nivel gimnazial)'),
('Proiect național FRED GOES NET (Nivel liceal)'),
('Proiect național MESAJUL MEU ANTIDROG (Gimnazial și Liceal)'),
('Proiect național EU ŞI COPILUL MEU (Adresat părinților)'),
('Campania FII LIBER! (2021)'),
('Campania RENUNȚI ȘI CÂȘTIGĂ (2021)'),
('Campania 19 Zile de prevenire a abuzurilor și violențelor');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `actiuni`
-- -------------------------------------------------------------------
INSERT INTO `actiuni` (`id_proiect`, `nr_beneficiari`, `an`) VALUES
((SELECT id FROM proiecte WHERE nume = 'Proiect național CUM SĂ CREŞTEM SĂNĂTOŞI (Nivel preșcolar)'), 17530, 2021),
((SELECT id FROM proiecte WHERE nume = 'Proiect național ABC-UL EMOŢIILOR (Nivel primar)'), 18781, 2021),
((SELECT id FROM proiecte WHERE nume = 'Proiect național NECENZURAT (Nivel gimnazial)'), 12638, 2021),
((SELECT id FROM proiecte WHERE nume = 'Proiect național FRED GOES NET (Nivel liceal)'), 177, 2021),
((SELECT id FROM proiecte WHERE nume = 'Proiect național MESAJUL MEU ANTIDROG (Gimnazial și Liceal)'), 4005, 2021),
((SELECT id FROM proiecte WHERE nume = 'Proiect național EU ŞI COPILUL MEU (Adresat părinților)'), 1676, 2021),
((SELECT id FROM proiecte WHERE nume = 'Campania FII LIBER! (2021)'), 79947, 2021),
((SELECT id FROM proiecte WHERE nume = 'Campania RENUNȚI ȘI CÂȘTIGĂ (2021)'), 17059, 2021),
((SELECT id FROM proiecte WHERE nume = 'Campania 19 Zile de prevenire a abuzurilor și violențelor'), 4559, 2021);


-- ===================================================================
-- POPULARE TABELE: URGENTE MEDICALE (Anul 2021)
-- Date preluate din raportul "urgente_medicale_2021"
-- Categorii: Canabis, Stimulanti -> 'Stimulanți (alții decât cocaina)',
--            Opiacee -> 'Opioide', NSP -> 'Alte Substanțe'
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel: `sex_urgente`
-- -------------------------------------------------------------------
INSERT INTO `sex_urgente` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Masculin', 497, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Feminin', 111, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Masculin', 171, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Feminin', 55, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Masculin', 107, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Feminin', 48, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Masculin', 500, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Feminin', 93, 2021);

-- -------------------------------------------------------------------
-- 2. Populare tabel: `varsta_urgente`
-- -------------------------------------------------------------------
INSERT INTO `varsta_urgente` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '<25', 332, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '25-34', 209, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '>35', 67, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '<25', 110, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '25-34', 84, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '>35', 32, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '<25', 45, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '25-34', 59, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '>35', 51, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '<25', 310, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '25-34', 191, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '>35', 92, 2021);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `cale_administrare`
-- -------------------------------------------------------------------
INSERT INTO `cale_administrare` (`id_categorie`, `cale`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Oral/fumat/prizat', 608, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Altele', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Injectabil', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Oral/fumat/prizat', 224, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Altele', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Injectabil', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Oral/fumat/prizat', 108, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Altele', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Injectabil', 47, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Oral/fumat/prizat', 573, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Altele', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Injectabil', 20, 2021);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `model_consum_urgente`
-- -------------------------------------------------------------------
INSERT INTO `model_consum_urgente` (`id_categorie`, `model`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Consum singular', 344, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Consum combinat', 264, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Consum singular', 62, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Consum combinat', 164, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Consum singular', 58, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Consum combinat', 97, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Consum singular', 436, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Consum combinat', 157, 2021);

-- -------------------------------------------------------------------
-- 5. Populare tabel: `diagnostic_urgenta`
-- -------------------------------------------------------------------
INSERT INTO `diagnostic_urgenta` (`id_categorie`, `diagnostic`, `nr_pacienti`, `an`) VALUES
-- Canabis
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Intoxicație', 239, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Utilizare nocivă', 101, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Dependență', 63, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Sevraj', 16, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Tulburări de comportament', 137, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Supradoză', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Testare toxicologică', 52, 2021),

-- Stimulanți
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Intoxicație', 109, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Utilizare nocivă', 32, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Dependență', 23, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Sevraj', 10, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Tulburări de comportament', 38, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Supradoză', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Testare toxicologică', 12, 2021),

-- Opioide (Opiacee)
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Intoxicație', 47, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Utilizare nocivă', 32, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Dependență', 39, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Sevraj', 17, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Tulburări de comportament', 15, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Supradoză', 3, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Testare toxicologică', 2, 2021),

-- NSP (Noi Substanțe Psihoactive -> 'Alte Substanțe' in nomenclator)
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Intoxicație', 367, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Utilizare nocivă', 43, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Dependență', 67, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Sevraj', 5, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Tulburări de comportament', 105, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Supradoză', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Testare toxicologică', 6, 2021);


-- ===================================================================
-- POPULARE TABELE: TRATAMENT (TDI - Anul 2021)
-- Date agregate din raportul "tdi-date-guvern-2021"
-- Categorii: Opioide, Cocaină, Stimulanți (alții decât cocaina),
--            Hipnotice și Sedative, Halucinogene,
--            Substanțe Volatile și Inhalanți, Canabis, Alte Substanțe
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel: `regim_tratament`
-- -------------------------------------------------------------------
INSERT INTO `regim_tratament` (`id_categorie`, `regim`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Ambulatoriu', 408, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Internare', 219, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Penitenciar', 20, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Ambulatoriu', 57, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Internare', 25, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Penitenciar', 2, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Ambulatoriu', 43, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Internare', 51, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Penitenciar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Ambulatoriu', 5, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Internare', 33, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Penitenciar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Ambulatoriu', 15, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Internare', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Penitenciar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Ambulatoriu', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Internare', 15, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Penitenciar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Ambulatoriu', 1469, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Internare', 332, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Penitenciar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Ambulatoriu', 126, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Internare', 269, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Penitenciar', 2, 2021);

-- -------------------------------------------------------------------
-- 2. Populare tabel: `sex_pacienti`
-- -------------------------------------------------------------------
INSERT INTO `sex_pacienti` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Masculin', 560, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Feminin', 87, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Masculin', 73, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Feminin', 11, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Masculin', 69, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Feminin', 25, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Masculin', 24, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Feminin', 14, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Masculin', 14, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Feminin', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Masculin', 16, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Feminin', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Masculin', 1660, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Feminin', 141, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Masculin', 347, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Feminin', 50, 2021);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `varsta_pacienti`
-- Intervale agregate: <25 = sub 25 ani, 25-34, >35
-- <25 = sum(<15, 15-19, 20-24); 25-34 = sum(25-29, 30-34); >35 = rest (fara necunoscut)
-- -------------------------------------------------------------------
INSERT INTO `varsta_pacienti` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '<25', 52, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '25-34', 220, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), '>35', 375, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), '<25', 19, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), '25-34', 36, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), '>35', 29, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '<25', 55, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '25-34', 29, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), '>35', 10, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), '<25', 14, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), '25-34', 7, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), '>35', 17, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), '<25', 10, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), '25-34', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), '>35', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), '<25', 14, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), '25-34', 5, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), '>35', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '<25', 894, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '25-34', 724, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), '>35', 183, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '<25', 188, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '25-34', 159, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), '>35', 50, 2021);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `surse` (Sursa de referire la tratament)
-- -------------------------------------------------------------------
INSERT INTO `surse` (`id_categorie`, `sursa`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Proprie inițiativă / Familie', 452, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Servicii medicale', 34, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Justiție / Poliție', 135, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Proprie inițiativă / Familie', 20, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Servicii medicale', 5, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Justiție / Poliție', 56, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Proprie inițiativă / Familie', 31, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Servicii medicale', 18, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Justiție / Poliție', 44, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Proprie inițiativă / Familie', 20, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Servicii medicale', 9, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Justiție / Poliție', 8, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Proprie inițiativă / Familie', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Servicii medicale', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Justiție / Poliție', 13, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Proprie inițiativă / Familie', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Servicii medicale', 11, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Justiție / Poliție', 5, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Proprie inițiativă / Familie', 217, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Servicii medicale', 82, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Justiție / Poliție', 1456, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Proprie inițiativă / Familie', 106, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Servicii medicale', 115, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Justiție / Poliție', 131, 2021);

-- -------------------------------------------------------------------
-- 5. Populare tabel: `situatie_locativa` (Tipul locuintei)
-- -------------------------------------------------------------------
INSERT INTO `situatie_locativa` (`id_categorie`, `situatie`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Stabilă (Locuință proprie/chirie)', 576, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Instabilă / Fără adăpost', 20, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Instituție (Penitenciar/Centru)', 46, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Stabilă (Locuință proprie/chirie)', 72, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Instabilă / Fără adăpost', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Instituție (Penitenciar/Centru)', 6, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Stabilă (Locuință proprie/chirie)', 83, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Instabilă / Fără adăpost', 6, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Instituție (Penitenciar/Centru)', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Stabilă (Locuință proprie/chirie)', 36, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Instabilă / Fără adăpost', 1, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Instituție (Penitenciar/Centru)', 1, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Stabilă (Locuință proprie/chirie)', 16, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Instabilă / Fără adăpost', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Instituție (Penitenciar/Centru)', 1, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Stabilă (Locuință proprie/chirie)', 8, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Instabilă / Fără adăpost', 7, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Instituție (Penitenciar/Centru)', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Stabilă (Locuință proprie/chirie)', 1699, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Instabilă / Fără adăpost', 24, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Instituție (Penitenciar/Centru)', 66, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Stabilă (Locuință proprie/chirie)', 321, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Instabilă / Fără adăpost', 27, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Instituție (Penitenciar/Centru)', 20, 2021);

-- -------------------------------------------------------------------
-- 6. Populare tabel: `nivel_educational`
-- Primar/Fara = ISCED 0 + ISCED 1; Secundar = ISCED 2-3; Superior = ISCED 4-6
-- -------------------------------------------------------------------
INSERT INTO `nivel_educational` (`id_categorie`, `nivel`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Primar / Fără studii', 364, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Secundar (Liceu/Școală prof.)', 268, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Superior', 5, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Primar / Fără studii', 21, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Secundar (Liceu/Școală prof.)', 54, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Superior', 5, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Primar / Fără studii', 23, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Secundar (Liceu/Școală prof.)', 62, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Superior', 1, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Primar / Fără studii', 8, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Secundar (Liceu/Școală prof.)', 23, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Superior', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Primar / Fără studii', 2, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Secundar (Liceu/Școală prof.)', 14, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Superior', 1, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Primar / Fără studii', 13, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Secundar (Liceu/Școală prof.)', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Superior', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Primar / Fără studii', 417, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Secundar (Liceu/Școală prof.)', 1305, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Superior', 56, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Primar / Fără studii', 215, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Secundar (Liceu/Școală prof.)', 137, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Superior', 4, 2021);

-- -------------------------------------------------------------------
-- 7. Populare tabel: `ocupatie_pacienti` (Status ocupational)
-- Angajat = angajat ocazional + angajat permanent
-- -------------------------------------------------------------------
INSERT INTO `ocupatie_pacienti` (`id_categorie`, `ocupatie`, `nr_pacienti`, `an`) VALUES
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Angajat (ocazional/permanent)', 222, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Elev / Student', 9, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Șomer / Fără ocupație', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Opioide'), 'Asistat / Pensionar', 3, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Angajat (ocazional/permanent)', 42, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Elev / Student', 3, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Șomer / Fără ocupație', 1, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Cocaină'), 'Asistat / Pensionar', 1, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Angajat (ocazional/permanent)', 41, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Elev / Student', 24, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Șomer / Fără ocupație', 9, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Stimulanți (alții decât cocaina)'), 'Asistat / Pensionar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Angajat (ocazional/permanent)', 7, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Elev / Student', 8, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Șomer / Fără ocupație', 1, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Hipnotice și Sedative'), 'Asistat / Pensionar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Angajat (ocazional/permanent)', 8, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Elev / Student', 5, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Șomer / Fără ocupație', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Halucinogene'), 'Asistat / Pensionar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Angajat (ocazional/permanent)', 0, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Elev / Student', 6, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Șomer / Fără ocupație', 4, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Substanțe Volatile și Inhalanți'), 'Asistat / Pensionar', 0, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Angajat (ocazional/permanent)', 972, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Elev / Student', 334, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Șomer / Fără ocupație', 72, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Canabis'), 'Asistat / Pensionar', 6, 2021),

((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Angajat (ocazional/permanent)', 78, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Elev / Student', 81, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Șomer / Fără ocupație', 31, 2021),
((SELECT id FROM categorii_droguri WHERE nume = 'Alte Substanțe'), 'Asistat / Pensionar', 5, 2021);


-- ===================================================================
-- POPULARE TABELE: BOLI INFECTIOASE (Anul 2021 - Raport DRID)
-- ===================================================================

-- -------------------------------------------------------------------
-- 1. Populare tabel Nomenclator: `boli`
-- (INSERT IGNORE pentru cele deja existente din alte seturi de date)
-- -------------------------------------------------------------------
INSERT IGNORE INTO `boli` (`nume`) VALUES
('VHC'),
('HIV'),
('VHB');

-- -------------------------------------------------------------------
-- 2. Populare tabel: `prevalenta_sex`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_sex` (`id_boala`, `sex`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC 2021
((SELECT id FROM boli WHERE nume = 'VHC'), 'Masculin', 110, 76),
((SELECT id FROM boli WHERE nume = 'VHC'), 'Feminin', 24, 16),
-- HIV 2021
((SELECT id FROM boli WHERE nume = 'HIV'), 'Masculin', 108, 19),
((SELECT id FROM boli WHERE nume = 'HIV'), 'Feminin', 26, 9),
-- VHB 2021
((SELECT id FROM boli WHERE nume = 'VHB'), 'Masculin', 108, 10),
((SELECT id FROM boli WHERE nume = 'VHB'), 'Feminin', 24, 0);

-- -------------------------------------------------------------------
-- 3. Populare tabel: `prevalenta_varsta`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_varsta` (`id_boala`, `interval_varsta`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC 2021
((SELECT id FROM boli WHERE nume = 'VHC'), '<25', 9, 3),
((SELECT id FROM boli WHERE nume = 'VHC'), '25-34', 48, 35),
((SELECT id FROM boli WHERE nume = 'VHC'), '>34', 77, 54),
-- HIV 2021
((SELECT id FROM boli WHERE nume = 'HIV'), '<25', 9, 3),
((SELECT id FROM boli WHERE nume = 'HIV'), '25-34', 46, 8),
((SELECT id FROM boli WHERE nume = 'HIV'), '>34', 79, 17),
-- VHB 2021
((SELECT id FROM boli WHERE nume = 'VHB'), '<25', 9, 0),
((SELECT id FROM boli WHERE nume = 'VHB'), '25-34', 47, 5),
((SELECT id FROM boli WHERE nume = 'VHB'), '>34', 76, 5);

-- -------------------------------------------------------------------
-- 4. Populare tabel: `prevalenta_timp_prima_injectare`
-- -------------------------------------------------------------------
INSERT INTO `prevalenta_timp_prima_injectare` (`id_boala`, `interval`, `nr_testati`, `nr_pozitivi`) VALUES
-- VHC 2021
((SELECT id FROM boli WHERE nume = 'VHC'), '<2', 0, 0),
((SELECT id FROM boli WHERE nume = 'VHC'), 'de la 2 la 5', 12, 9),
((SELECT id FROM boli WHERE nume = 'VHC'), 'de la 5 la 10', 6, 2),
((SELECT id FROM boli WHERE nume = 'VHC'), '10 sau mai mulți', 96, 68),
-- HIV 2021
((SELECT id FROM boli WHERE nume = 'HIV'), '<2', 5, 1),
((SELECT id FROM boli WHERE nume = 'HIV'), 'de la 2 la 5', 12, 2),
((SELECT id FROM boli WHERE nume = 'HIV'), 'de la 5 la 10', 6, 0),
((SELECT id FROM boli WHERE nume = 'HIV'), '10 sau mai mulți', 96, 21),
-- VHB 2021
((SELECT id FROM boli WHERE nume = 'VHB'), '<2', 0, 0),
((SELECT id FROM boli WHERE nume = 'VHB'), 'de la 2 la 5', 12, 1),
((SELECT id FROM boli WHERE nume = 'VHB'), 'de la 5 la 10', 6, 1),
((SELECT id FROM boli WHERE nume = 'VHB'), '10 sau mai mulți', 94, 8);
