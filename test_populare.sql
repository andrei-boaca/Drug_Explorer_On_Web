-- ===================================================================
-- POPULARE TABEL: categorii_droguri
-- Date extrase si curatate din raportul TDI (Tratament) 2022
-- ===================================================================

USE `statistici_droguri`;

INSERT INTO `categorii_droguri` (`nume`) VALUES
('Opioide'),
('Cocaină'),
('Stimulanți (alții decât cocaina)'),
('Hipnotice și Sedative'),
('Halucinogene'),
('Substanțe Volatile și Inhalanți'),
('Canabis'),
('Alte Substanțe');

-- ===================================================================
-- POPULARE TABEL: tipuri_droguri (cu mapare pe categorii)
-- Corelare între Capturi și Categoriile standard TDI/ANA
-- ===================================================================

INSERT INTO `tipuri_droguri` (`nume`, `id_categorie`) VALUES
-- Categoria 1: Opioide
('Heroină', 1),
('Metadonă', 1),
('Oxicodonă', 1),
('Morfină', 1),
('Opiu', 1),
('Codeină', 1),
('Petidină', 1),
('Fentanyl', 1),
('Dihidrocodeină', 1),

-- Categoria 2: Cocaină
('Cocaină', 2),

-- Categoria 3: Stimulanți (alții decât cocaina)
('Amfetamină', 3),
('Metamfetamină', 3),
('MDMA', 3),
('Catinone', 3),
('Amfepramonă', 3),

-- Categoria 4: Hipnotice și Sedative
('Benzodiazepine', 4),
('Barbiturice', 4),
('Zolpidem', 4),

-- Categoria 5: Halucinogene
('LSD', 5),
('Ciuperci halucinogene', 5),
('2C-X', 5),
('Triptamine', 5),

-- Categoria 7: Canabis
('Canabis', 7),
('Rezină de canabis', 7),
('Ulei de canabis', 7),
('Soluție cu THC', 7),
('Masă plante de canabis', 7),
('Fragmente vegetale cu THC', 7),

-- Categoria 8: Alte Substanțe (include NSP/NPS și altele)
('Canabinoizi sintetici', 8),
('Ketamină', 8),
('Altele', 8);