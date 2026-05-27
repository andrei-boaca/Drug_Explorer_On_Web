SET FOREIGN_KEY_CHECKS = 0;

-- ── categorii_droguri ──────────────────────────────────────────────
INSERT IGNORE INTO `categorii_droguri` (`id`, `nume`) VALUES
(1,  'Canabis si derivate'),
(2,  'Opioide'),
(3,  'Cocaina si stimulante'),
(4,  'Amfetamine si entactogene'),
(5,  'Substante halucinogene'),
(6,  'Sedative, hipnotice si anxiolitice'),
(7,  'Inhalante'),
(8,  'Substante noi psihoactive'),
(9,  'Steroizi anabolizanti'),
(10, 'Alte substante psihoactive');

-- ── tipuri_droguri ─────────────────────────────────────────────────
-- existing: id 1=Cactus/Mescalina(NULL), 2=Buprenorfina(NULL), 3=Mitraginina(NULL)
INSERT IGNORE INTO `tipuri_droguri` (`nume`, `id_categorie`) VALUES
('Cannabis',                    1),
('Canabis',                     1),
('Hasis',                       1),
('Rezină de canabis',           1),
('Ulei de cannabis',            1),
('Ulei de canabis',             1),
('Fragmente vegetale cu THC',   1),
('Masă plante de canabis',      1),
('Soluție cu THC',              1),
('THC sintetic',                1),
('Heroina',                     2),
('Heroină',                     2),
('Morfina',                     2),
('Morfină',                     2),
('Metadona',                    2),
('Metadonă',                    2),
('Fentanil',                    2),
('Fentanyl',                    2),
('Oxycodona',                   2),
('Oxicodonă',                   2),
('Tramadol',                    2),
('Codeina',                     2),
('Codeină',                     2),
('Dihidrocodeină',              2),
('Clorhidrat de morfina',       2),
('Buprenorfină',                2),
('Mitraginină',                 2),
('Opiu',                        2),
('Petidină',                    2),
('Cocaina',                     3),
('Cocaină',                     3),
('Crack',                       3),
('Pasta de coca',               3),
('Amfetamina',                  4),
('Amfetamină',                  4),
('Metamfetamina',               4),
('Metamfetamină',               4),
('MDMA',                        4),
('MDA',                         4),
('MDEA',                        4),
('4-MMA',                       4),
('Amfepramonă',                 4),
('LSD',                         5),
('Psilocibina',                 5),
('DMT',                         5),
('Ketamina',                    5),
('Ketamină',                    5),
('PCP',                         5),
('2C-X',                        5),
('Cactus/Mescalină',            5),
('Ciuperci halucinogene',       5),
('Triptamine',                  5),
('Diazepam',                    6),
('Flunitrazepam',               6),
('GHB',                         6),
('Zolpidem',                    6),
('Alprazolam',                  6),
('Clonazepam',                  6),
('Fenobarbital',                6),
('Barbiturice',                 6),
('Benzodiazepine',              6),
('Solvent industrial',          7),
('Nitrit de amil',              7),
('Oxid nitros',                 7),
('Spice/K2',                    8),
('Mefedrona',                   8),
('Alpha-PVP',                   8),
('2C-B',                        8),
('PMMA',                        8),
('Cathinona sintetica',         8),
('Canabinoizi sintetici',       8),
('Catinone',                    8),
('NBOMe',                       8),
('Nandrolon',                   9),
('Stanozolol',                  9),
('Testosteron sintetic',        9),
('Boldenon',                    9),
('Altele',                      10);

-- ── boli ───────────────────────────────────────────────────────────
-- existing: 1=VHC, 2=HIV, 3=VHB
INSERT IGNORE INTO `boli` (`id`, `nume`) VALUES
(4,  'Tuberculoza'),
(5,  'Sifilis'),
(6,  'Gonoreea'),
(7,  'Hepatita D (VHD)'),
(8,  'Chlamydia'),
(9,  'MRSA'),
(10, 'Infectie HPV');

-- ── legi ───────────────────────────────────────────────────────────
-- existing: 1-5
INSERT IGNORE INTO `legi` (`nume`) VALUES
('Art.5 din Legea nr. 143/2000'),
('Art.6 din Legea nr. 143/2000'),
('Art.8 din Legea nr. 143/2000'),
('Art.10 din Legea nr. 143/2000'),
('Art.11 din Legea nr. 143/2000'),
('Art.12 din Legea nr. 143/2000'),
('Legea nr. 339/2005'),
('Legea nr. 248/2005'),
('OUG nr. 6/2010'),
('Legea nr. 186/2021');

-- ── proiecte ───────────────────────────────────────────────────────
-- existing: 1-12
INSERT IGNORE INTO `proiecte` (`nume`) VALUES
('Campania FII LIBER! (2018)'),
('Campania FII LIBER! (2019)'),
('Campania FII LIBER! (2020)'),
('Campania FII LIBER! (2022)'),
('Campania RENUNȚI ȘI CÂȘTIGĂ (2018)'),
('Campania RENUNȚI ȘI CÂȘTIGĂ (2019)'),
('Campania RENUNȚI ȘI CÂȘTIGĂ (2020)'),
('Campania RENUNȚI ȘI CÂȘTIGĂ (2022)'),
('Proiect SMART - Prevenire in scoli'),
('Proiect ECAD - Coalitia europeana'),
('Proiect Parinti Activi Antidrog'),
('Proiect Tineri Fara Droguri'),
('Campania Ziua Internationala Fara Drog'),
('Proiect SPORT contra DROGURI'),
('Proiect Comunitate Sanatoasa'),
('Program de consiliere post-tratament'),
('Campania Online Safe Youth'),
('Proiect RESET - Reintegrare sociala'),
('Program Reducerea Riscurilor (harm reduction)'),
('Campania Alcool Zero la Volan'),
('Proiect Munca nu Droguri'),
('Program national de educatie antidrog'),
('Proiect Retea Stradala de Preventie'),
('Campania Europa fara Droguri'),
('Proiect parteneriat cu Politia Romana'),
('Campania Media Antidrog'),
('Proiect De-Tox Social'),
('Campania Fara Droguri in Familie'),
('Proiect Consiliere pentru parinti'),
('Program integrat de sanatate mintala'),
('Proiect Scoala Activa'),
('Campania Tineretea Ta, Alegerea Ta'),
('Proiect Oras Sanatos Suceava'),
('Proiect Oras Sanatos Cluj'),
('Proiect Oras Sanatos Iasi'),
('Proiect Oras Sanatos Timisoara'),
('Proiect Oras Sanatos Constanta'),
('Proiect Oras Sanatos Craiova');

-- ── substante ──────────────────────────────────────────────────────
-- existing: 1-16
INSERT IGNORE INTO `substante` (`nume`, `categorie`) VALUES
('ACID ACETIC',            3),
('ACID ANTHRANILIC',       1),
('ISOSAFROLE',             1),
('SAFROLE',                1),
('PIPERONAL (HELIOTROPIN)',1),
('ANHIDRIDA ACETICA',      1),
('3,4-METHYLENDIOXYPHENYL-2-PROPANONE', 1),
('N-ACETYLANTHRANILIC ACID', 1),
('CLOROFORM',              3),
('ETER ETILIC',            3),
('BENZEN',                 3),
('HEXAN',                  3),
('METILAMINA',             2),
('ETILAMINA',              2),
('IZOPROPILAMINA',         2),
('FORMIC ACID',            3),
('BENZALDEHIDA',           1),
('BROMOBENZENE',           1),
('IODOFORM',               3),
('HIDRURA DE SODIU',       2),
('CARBONAT DE POTASIU',    2),
('CLORURA DE AMONIU',      2),
('FENILALANINA',           1),
('L-EFEDRINA PURA',        1),
('CLORHIDRAT DE FENILALANINA', 1),
('SODIU BORHIDRURA',       2),
('ANILINA',                2),
('PIRIDINA',               2),
('CLORURA DE FOSFORIL',    2),
('OXICLORURA DE FOSFOR',   2),
('MALONONITRIL',           2),
('DIMETILSULFAT',          3),
('METILENDIAMINA',         1),
('CLORURA DE BENZIL',      1);

-- ── condamnari ─────────────────────────────────────────────────────
-- existing: 2021, 2022. Add 2018, 2019, 2020
INSERT INTO `condamnari` (`numar`, `sex`, `minor`, `an`) VALUES
(945,  'Masculin', 0, 2018),
(6,    'Masculin', 1, 2018),
(134,  'Feminin',  0, 2018),
(2,    'Feminin',  1, 2018),
(961,  'Masculin', 0, 2019),
(7,    'Masculin', 1, 2019),
(139,  'Feminin',  0, 2019),
(1,    'Feminin',  1, 2019),
(903,  'Masculin', 0, 2020),
(5,    'Masculin', 1, 2020),
(128,  'Feminin',  0, 2020),
(2,    'Feminin',  1, 2020);

-- ── lege_condamnari ────────────────────────────────────────────────
-- add combinations for all 15 legi × years 2018-2022 to reach 50
INSERT INTO `lege_condamnari` (`id_lege`, `numar`, `an`) VALUES
(1, 712, 2018), (2, 89,  2018), (3, 134, 2018), (4, 45,  2018), (5, 23,  2018),
(1, 741, 2019), (2, 94,  2019), (3, 141, 2019), (4, 52,  2019), (5, 19,  2019),
(1, 695, 2020), (2, 88,  2020), (3, 127, 2020), (4, 38,  2020), (5, 21,  2020),
(1, 723, 2021), (2, 97,  2021), (3, 148, 2021), (5, 28,  2021),
(1, 756, 2022), (2, 102, 2022), (3, 155, 2022), (4, 61,  2022), (5, 31,  2022),
(6, 312, 2018), (7, 201, 2018), (8, 89,  2018),
(6, 328, 2019), (7, 215, 2019), (8, 94,  2019),
(6, 298, 2020), (7, 198, 2020), (8, 87,  2020),
(6, 341, 2021), (7, 223, 2021), (8, 101, 2021),
(6, 367, 2022), (7, 241, 2022), (8, 112, 2022),
(9, 44,  2021), (10, 28, 2021),
(9, 52,  2022), (10, 35, 2022);

-- ── actiuni ────────────────────────────────────────────────────────
-- existing 19 rows, add 31 more (proiecte 13-50 × ani)
INSERT INTO `actiuni` (`id_proiect`, `nr_beneficiari`, `an`) VALUES
(13, 1250, 2022), (14, 3400, 2022), (15, 890,  2022),
(16, 2100, 2022), (17, 760,  2022), (18, 1500, 2022),
(19, 430,  2022), (20, 980,  2022), (21, 1200, 2022),
(22, 2800, 2022), (23, 4500, 2022), (24, 890,  2022),
(13, 1180, 2021), (14, 3100, 2021), (15, 820,  2021),
(16, 1950, 2021), (17, 710,  2021), (18, 1400, 2021),
(19, 390,  2021), (20, 910,  2021), (21, 1100, 2021),
(22, 2650, 2021), (13, 1050, 2020), (14, 2800, 2020),
(15, 750,  2020), (16, 1800, 2020), (17, 680,  2020),
(18, 1280, 2020), (19, 350,  2020), (20, 840,  2020),
(21, 990,  2020);

-- ── precursori ─────────────────────────────────────────────────────
-- existing 16 rows (substante 1-16, an 2022). Add years 2018-2021 for key substances
INSERT INTO `precursori` (`id_substanta`, `nr_operatiuni`, `an`) VALUES
(1,  11, 2021), (2,  10, 2021), (3,  13, 2021), (4,  7,  2021),
(5,  6,  2021), (6,  7,  2021), (7,  3,  2021), (8,  8,  2021),
(1,  9,  2020), (2,  8,  2020), (3,  11, 2020), (4,  5,  2020),
(5,  5,  2020), (6,  6,  2020), (1,  8,  2019), (2,  7,  2019),
(3,  10, 2019), (4,  4,  2019), (5,  4,  2019), (1,  7,  2018),
(2,  6,  2018), (3,  9,  2018), (4,  4,  2018);

-- ── regim_tratament ────────────────────────────────────────────────
-- existing 39 rows (NULL categorie). Add 11 with proper categories
INSERT INTO `regim_tratament` (`id_categorie`, `regim`, `nr_pacienti`, `an`) VALUES
(1, 'Ambulator',        145, 2022),
(1, 'Rezidential',       38, 2022),
(2, 'Ambulator',        412, 2022),
(2, 'Rezidential',      189, 2022),
(3, 'Ambulator',         87, 2022),
(4, 'Ambulator',         63, 2022),
(5, 'Ambulator',         22, 2022),
(1, 'Ambulator',        138, 2021),
(2, 'Ambulator',        398, 2021),
(3, 'Ambulator',         79, 2021),
(4, 'Ambulator',         57, 2021);

-- ── sex_pacienti ───────────────────────────────────────────────────
-- existing 26 rows. Add 24 more with proper categories
INSERT INTO `sex_pacienti` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
(1, 'Masculin', 312, 2022), (1, 'Feminin', 89,  2022),
(2, 'Masculin', 478, 2022), (2, 'Feminin', 134, 2022),
(3, 'Masculin', 123, 2022), (3, 'Feminin', 31,  2022),
(4, 'Masculin',  98, 2022), (4, 'Feminin', 24,  2022),
(5, 'Masculin',  34, 2022), (5, 'Feminin', 8,   2022),
(1, 'Masculin', 298, 2021), (1, 'Feminin', 84,  2021),
(2, 'Masculin', 461, 2021), (2, 'Feminin', 128, 2021),
(3, 'Masculin', 115, 2021), (3, 'Feminin', 28,  2021),
(4, 'Masculin',  91, 2021), (4, 'Feminin', 21,  2021),
(1, 'Masculin', 275, 2020), (1, 'Feminin', 79,  2020),
(2, 'Masculin', 445, 2020), (2, 'Feminin', 121, 2020),
(3, 'Masculin', 108, 2020), (3, 'Feminin', 26,  2020);

-- ── varsta_pacienti ────────────────────────────────────────────────
-- existing 33 rows. Add 17 more
INSERT INTO `varsta_pacienti` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
(1, 'Sub 15 ani',  4,   2022), (1, '15-19 ani', 87,  2022),
(1, '20-24 ani',  145,  2022), (1, '25-34 ani', 198, 2022),
(2, 'Sub 15 ani',  2,   2022), (2, '15-19 ani', 45,  2022),
(2, '20-24 ani',  167,  2022), (2, '25-34 ani', 289, 2022),
(2, '35-44 ani',  134,  2022), (2, 'Peste 44',  71,  2022),
(3, '15-19 ani',  12,   2022), (3, '20-24 ani', 56,  2022),
(3, '25-34 ani',  89,   2022), (4, '15-19 ani', 18,  2022),
(4, '20-24 ani',  47,   2022), (4, '25-34 ani', 34,  2022),
(5, '20-24 ani',  11,   2022);

-- ── surse ──────────────────────────────────────────────────────────
-- existing 30 rows. Add 20 more
INSERT INTO `surse` (`id_categorie`, `sursa`, `nr_pacienti`, `an`) VALUES
(1, 'Trimitere medic',      89, 2022), (1, 'Auto-prezentare',    145, 2022),
(1, 'Familie/prieteni',     67, 2022), (1, 'Servicii sociale',   34, 2022),
(2, 'Trimitere medic',     178, 2022), (2, 'Auto-prezentare',    234, 2022),
(2, 'Familie/prieteni',     91, 2022), (2, 'Servicii sociale',   45, 2022),
(2, 'Justitie/probatiune',  89, 2022), (3, 'Trimitere medic',    34, 2022),
(3, 'Auto-prezentare',      67, 2022), (3, 'Justitie/probatiune',23, 2022),
(4, 'Trimitere medic',      28, 2022), (4, 'Auto-prezentare',    41, 2022),
(1, 'Trimitere medic',      81, 2021), (1, 'Auto-prezentare',   138, 2021),
(2, 'Trimitere medic',     165, 2021), (2, 'Auto-prezentare',   218, 2021),
(3, 'Trimitere medic',      29, 2021), (3, 'Auto-prezentare',    58, 2021);

-- ── situatie_locativa ──────────────────────────────────────────────
-- existing 30 rows. Add 20 more
INSERT INTO `situatie_locativa` (`id_categorie`, `situatie`, `nr_pacienti`, `an`) VALUES
(1, 'Locuinta stabila',     198, 2022), (1, 'Fara adapost',       23, 2022),
(1, 'Institutionalizat',     12, 2022), (1, 'Cu familia',        167, 2022),
(2, 'Locuinta stabila',     312, 2022), (2, 'Fara adapost',       45, 2022),
(2, 'Institutionalizat',     28, 2022), (2, 'Cu familia',        223, 2022),
(3, 'Locuinta stabila',      89, 2022), (3, 'Fara adapost',       12, 2022),
(3, 'Cu familia',            51, 2022), (4, 'Locuinta stabila',   54, 2022),
(4, 'Cu familia',            38, 2022), (5, 'Locuinta stabila',   19, 2022),
(1, 'Locuinta stabila',     185, 2021), (1, 'Fara adapost',       19, 2021),
(2, 'Locuinta stabila',     298, 2021), (2, 'Fara adapost',       39, 2021),
(3, 'Locuinta stabila',      82, 2021), (4, 'Locuinta stabila',   48, 2021);

-- ── nivel_educational ──────────────────────────────────────────────
-- existing 30 rows. Add 20 more
INSERT INTO `nivel_educational` (`id_categorie`, `nivel`, `nr_pacienti`, `an`) VALUES
(1, 'Primar sau mai putin', 34,  2022), (1, 'Gimnazial',         78,  2022),
(1, 'Liceal',              145,  2022), (1, 'Superior',          67,  2022),
(2, 'Primar sau mai putin', 89,  2022), (2, 'Gimnazial',        167,  2022),
(2, 'Liceal',              234,  2022), (2, 'Superior',          78,  2022),
(3, 'Primar sau mai putin', 23,  2022), (3, 'Gimnazial',         45,  2022),
(3, 'Liceal',               67,  2022), (4, 'Gimnazial',         29,  2022),
(4, 'Liceal',               41,  2022), (5, 'Liceal',            14,  2022),
(1, 'Primar sau mai putin', 31,  2021), (1, 'Gimnazial',         72,  2021),
(2, 'Primar sau mai putin', 84,  2021), (2, 'Gimnazial',        158,  2021),
(3, 'Primar sau mai putin', 21,  2021), (3, 'Liceal',            60,  2021);

-- ── ocupatie_pacienti ──────────────────────────────────────────────
-- existing 32 rows. Add 18 more
INSERT INTO `ocupatie_pacienti` (`id_categorie`, `ocupatie`, `nr_pacienti`, `an`) VALUES
(1, 'Angajat',             123, 2022), (1, 'Somer',             145, 2022),
(1, 'Elev/Student',         78, 2022), (1, 'Pensionar',          12, 2022),
(2, 'Angajat',             198, 2022), (2, 'Somer',             267, 2022),
(2, 'Elev/Student',         45, 2022), (2, 'Pensionar',          34, 2022),
(3, 'Angajat',              56, 2022), (3, 'Somer',              67, 2022),
(3, 'Elev/Student',         23, 2022), (4, 'Angajat',            34, 2022),
(4, 'Somer',                38, 2022), (5, 'Angajat',            12, 2022),
(1, 'Angajat',             115, 2021), (1, 'Somer',             138, 2021),
(2, 'Angajat',             185, 2021), (2, 'Somer',             254, 2021);

-- ── sex_urgente ────────────────────────────────────────────────────
-- existing 16 rows. Add 34 more with proper categories
INSERT INTO `sex_urgente` (`id_categorie`, `sex`, `nr_pacienti`, `an`) VALUES
(1, 'Masculin', 234, 2022), (1, 'Feminin',  67, 2022),
(2, 'Masculin', 189, 2022), (2, 'Feminin',  45, 2022),
(3, 'Masculin',  98, 2022), (3, 'Feminin',  23, 2022),
(4, 'Masculin',  78, 2022), (4, 'Feminin',  19, 2022),
(5, 'Masculin',  34, 2022), (5, 'Feminin',   8, 2022),
(1, 'Masculin', 218, 2021), (1, 'Feminin',  61, 2021),
(2, 'Masculin', 174, 2021), (2, 'Feminin',  41, 2021),
(3, 'Masculin',  89, 2021), (3, 'Feminin',  21, 2021),
(4, 'Masculin',  71, 2021), (4, 'Feminin',  17, 2021),
(1, 'Masculin', 198, 2020), (1, 'Feminin',  55, 2020),
(2, 'Masculin', 158, 2020), (2, 'Feminin',  37, 2020),
(3, 'Masculin',  78, 2020), (3, 'Feminin',  18, 2020),
(1, 'Masculin', 187, 2019), (1, 'Feminin',  51, 2019),
(2, 'Masculin', 145, 2019), (2, 'Feminin',  33, 2019),
(1, 'Masculin', 175, 2018), (1, 'Feminin',  48, 2018),
(2, 'Masculin', 134, 2018), (2, 'Feminin',  29, 2018),
(6, 'Masculin',  45, 2022), (6, 'Feminin',  18, 2022);

-- ── varsta_urgente ─────────────────────────────────────────────────
-- existing 24 rows. Add 26 more
INSERT INTO `varsta_urgente` (`id_categorie`, `interval`, `nr_pacienti`, `an`) VALUES
(1, '15-19 ani',  34, 2022), (1, '20-24 ani',  89, 2022),
(1, '25-34 ani', 123, 2022), (1, '35-44 ani',  45, 2022),
(1, 'Peste 44',   10, 2022),
(2, '15-19 ani',  12, 2022), (2, '20-24 ani',  67, 2022),
(2, '25-34 ani', 101, 2022), (2, '35-44 ani',  56, 2022),
(2, 'Peste 44',   23, 2022),
(3, '15-19 ani',   8, 2022), (3, '20-24 ani',  34, 2022),
(3, '25-34 ani',  51, 2022), (3, '35-44 ani',  19, 2022),
(1, '15-19 ani',  31, 2021), (1, '20-24 ani',  82, 2021),
(1, '25-34 ani', 115, 2021), (1, '35-44 ani',  41, 2021),
(2, '15-19 ani',  11, 2021), (2, '20-24 ani',  61, 2021),
(2, '25-34 ani',  93, 2021), (2, '35-44 ani',  51, 2021),
(4, '15-19 ani',  15, 2022), (4, '20-24 ani',  38, 2022),
(5, '15-19 ani',   6, 2022), (5, '20-24 ani',  19, 2022);

-- ── cale_administrare ──────────────────────────────────────────────
-- existing 24 rows. Add 26 more
INSERT INTO `cale_administrare` (`id_categorie`, `cale`, `nr_pacienti`, `an`) VALUES
(1, 'Fumat',          289, 2022), (1, 'Oral',              45, 2022),
(1, 'Injectabil',       8, 2022),
(2, 'Injectabil',     312, 2022), (2, 'Fumat',             34, 2022),
(2, 'Intranazal',      23, 2022), (2, 'Oral',              89, 2022),
(3, 'Intranazal',     102, 2022), (3, 'Fumat',             12, 2022),
(3, 'Injectabil',       8, 2022),
(4, 'Oral',            89, 2022), (4, 'Intranazal',        23, 2022),
(5, 'Oral',            28, 2022), (5, 'Fumat',             12, 2022),
(1, 'Fumat',          271, 2021), (1, 'Oral',              41, 2021),
(2, 'Injectabil',     295, 2021), (2, 'Oral',              82, 2021),
(3, 'Intranazal',      94, 2021), (3, 'Fumat',             10, 2021),
(1, 'Fumat',          252, 2020), (1, 'Oral',              38, 2020),
(2, 'Injectabil',     275, 2020), (2, 'Oral',              76, 2020),
(6, 'Oral',            67, 2022), (6, 'Injectabil',        12, 2022);

-- ── prevalenta_sex ─────────────────────────────────────────────────
-- existing 12 rows (boli 1-3). Add for boli 4-10
INSERT INTO `prevalenta_sex` (`id_boala`, `sex`, `nr_testati`, `nr_pozitivi`) VALUES
(4, 'Masculin', 1234, 89),  (4, 'Feminin', 987,  45),
(5, 'Masculin', 2341, 234), (5, 'Feminin', 1876, 178),
(6, 'Masculin', 1987, 167), (6, 'Feminin', 1654, 123),
(7, 'Masculin',  456, 34),  (7, 'Feminin',  389,  23),
(8, 'Masculin', 1543, 123), (8, 'Feminin', 1287,  89),
(9, 'Masculin',  234, 12),  (9, 'Feminin',  198,   8),
(10,'Masculin', 1876, 234), (10,'Feminin', 1543, 178);

-- ── prevalenta_varsta ──────────────────────────────────────────────
-- existing 18 rows. Add 32 more
INSERT INTO `prevalenta_varsta` (`id_boala`, `interval_varsta`, `nr_testati`, `nr_pozitivi`) VALUES
(1, '15-19 ani', 234,  12), (1, '20-24 ani', 456,  45),
(1, '25-34 ani', 678,  89), (1, '35-44 ani', 345,  56),
(1, 'Peste 44',  123,  23),
(2, '15-19 ani', 189,   8), (2, '20-24 ani', 345,  23),
(2, '25-34 ani', 567,  56), (2, '35-44 ani', 289,  34),
(2, 'Peste 44',   98,  12),
(3, '15-19 ani', 312,  34), (3, '20-24 ani', 567,  89),
(3, '25-34 ani', 789, 134), (3, '35-44 ani', 423,  67),
(3, 'Peste 44',  156,  28),
(4, '20-24 ani', 156,  12), (4, '25-34 ani', 234,  19),
(4, '35-44 ani', 189,  14), (4, 'Peste 44',   89,   7),
(5, '20-24 ani', 312,  34), (5, '25-34 ani', 456,  56),
(5, '35-44 ani', 234,  23), (5, 'Peste 44',   98,   9),
(6, '20-24 ani', 278,  28), (6, '25-34 ani', 389,  43),
(6, '35-44 ani', 198,  19), (6, 'Peste 44',   87,   8),
(7, '25-34 ani',  89,   8), (7, '35-44 ani',  67,   5),
(8, '20-24 ani', 198,  19), (8, '25-34 ani', 267,  27),
(10,'20-24 ani', 245,  34), (10,'25-34 ani', 312,  45);

-- ── prevalenta_timp_prima_injectare ────────────────────────────────
-- existing 24 rows. Add 26 more
INSERT INTO `prevalenta_timp_prima_injectare` (`id_boala`, `interval`, `nr_testati`, `nr_pozitivi`) VALUES
(1, 'Sub 2 ani',   234,  12), (1, '2-5 ani',    345,  34),
(1, '6-10 ani',   456,  67), (1, '11-20 ani',  289,  56),
(1, 'Peste 20 ani', 123, 34),
(2, 'Sub 2 ani',   189,   8), (2, '2-5 ani',    278,  19),
(2, '6-10 ani',   367,  34), (2, '11-20 ani',  234,  28),
(2, 'Peste 20 ani', 98,  14),
(3, 'Sub 2 ani',   312,  28), (3, '2-5 ani',    423,  56),
(3, '6-10 ani',   534,  89), (3, '11-20 ani',  345,  67),
(3, 'Peste 20 ani', 156, 34),
(4, '2-5 ani',    134,   9), (4, '6-10 ani',   189,  15),
(4, '11-20 ani',  123,  12), (5, '2-5 ani',    167,  18),
(5, '6-10 ani',   223,  28), (5, '11-20 ani',  156,  21),
(6, '2-5 ani',    145,  15), (6, '6-10 ani',   198,  24),
(7, '6-10 ani',    78,   6), (7, '11-20 ani',   56,   5),
(8, '2-5 ani',    112,  12);

SET FOREIGN_KEY_CHECKS = 1;
