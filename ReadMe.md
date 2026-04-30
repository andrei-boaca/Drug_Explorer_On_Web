# Drug Explorer on Web — Frontend

## Arhitectura frontend

```
Drug_Explorer_On_Web/
├── index.php          # Shell HTML pur — nu mai conține logică PHP de query
├── style.css          # Design complet, variabile CSS, temă navy/blue/turcoaz
├── js/
│   └── app.js         # Tot JavaScript-ul: AJAX, tab-uri, tabel, export
└── api/               # Endpoint-uri JSON (consumate de app.js via fetch)
    ├── _base.php
    ├── filters.php
    ├── confiscari.php
    ├── condamnari.php
    ├── urgente.php
    ├── tratament.php
    ├── actiuni.php
    ├── boli.php
    └── export.php
```

---

## Ce s-a implementat

### 1. Separarea frontend / backend

`index.php` a fost transformat dintr-un fișier PHP monolitic (query-uri + HTML + logică) într-un **shell HTML pur**. Tot ce ținea de date a fost mutat în `api/`.

Înainte: un singur fișier făcea query SQL, construia HTML-ul tabelului și returna pagina — totul amestecat.

Acum: `index.php` conține doar structura HTML. Datele vin exclusiv prin `fetch()` în JavaScript.

---

### 2. Strat API RESTful (`api/`)

Fiecare secțiune are propriul endpoint PHP care returnează **JSON**:

| Endpoint | Parametri acceptați |
|---|---|
| `api/filters.php` | — |
| `api/confiscari.php` | `drog_id`, `an` |
| `api/condamnari.php` | `an`, `sex` |
| `api/urgente.php` | `categorie_id`, `an` |
| `api/tratament.php` | `categorie_id`, `an` |
| `api/actiuni.php` | `an` |
| `api/boli.php` | `boala_id` |
| `api/export.php` | `section`, `format` (csv/json) |

`api/_base.php` centralizează funcțiile comune: conexiunea PDO, helper-e de sanitizare (`intParam`, `strParam`), răspuns JSON și gestionare erori.

Toate query-urile folosesc **prepared statements** — protecție SQL injection.

---

### 3. AJAX via `fetch()` (vanilla JS)

Formularele nu mai fac `submit` clasic cu page reload. La apăsarea butonului **Caută**:

1. JavaScript colectează valorile câmpurilor cu `getFormParams()` (fără `FormData` — mai fiabil cross-browser)
2. Se face `fetch()` către endpoint-ul corespunzător cu parametrii ca query string
3. Răspunsul JSON este randat ca tabel HTML direct în pagină

Dropdown-urile (tip drog, categorie, boală) se populează automat la încărcarea paginii printr-un singur apel la `api/filters.php`.

---

### 4. Navigare prin tab-uri

Toate cele 6 secțiuni există simultan în DOM, dar doar una este vizibilă (`display: block`). Click pe tab ascunde secțiunea activă și o afișează pe cea selectată — fără niciun request HTTP suplimentar.

Secțiunile: Confiscări · Condamnări · Urgențe medicale · Tratament · Prevenire · Boli infecțioase.

---

### 5. Export CSV și JSON

Fiecare secțiune are două butoane de export. La click, `app.js` preia parametrii curenti din formular și redirecționează către `api/export.php?section=...&format=csv|json`.

`export.php` returnează:
- **CSV** cu BOM UTF-8 (compatibil Excel), header-e din cheile JSON
- **JSON** pretty-printed, attachment pentru download

---

### 6. Design — temă navy / albastru / turcoaz

Paleta de culori definită prin variabile CSS:

```css
--navy:       #0b1f3a
--navy-mid:   #102952
--blue:       #1d6fb8
--turquoise:  #0cb8c9
--bg:         #f2f7fc
```

Fonturi: **Inter** (UI) + **DM Mono** (valori numerice în tabel).

Elemente vizuale notabile:
- Header cu gradient navy și bordură turcoaz
- Tab-uri sticky pe fundal navy, indicator turcoaz la secțiunea activă
- Titluri de secțiune cu accent lateral turcoaz
- Header tabel pe fundal navy
- Hover pe rânduri cu highlight albastru deschis
- Butoane cu shadow colorat, hover turcoaz
- Animație `fadeUp` la schimbarea secțiunii

Design responsiv: layout adaptat pentru ecrane sub 680px.

---

## Pași următori

- [ ] Vizualizări grafice (minim 3: bar chart, line chart, pie/donut)
- [ ] Export grafice în PNG, WebP, SVG
- [ ] Modul de administrare
- [ ] Validare HTML/CSS cu W3C Validator