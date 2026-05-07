# Drug Explorer on Web — Changelog v2

## Fișiere modificate

| Fișier | Tip modificare |
|---|---|
| `index.php` | Restructurare completă |
| `style.css` | Rescris complet |
| `js/app.js` | Rescris complet |
| `api/filters.php` | Adăugat ani |

---

## 1. Temă de culori — light mode complet

**Problemă:** versiunea anterioară folosea header și tab-uri pe fundal navy închis (dark theme parțial).

**Soluție:** paleta a fost rescrisă integral cu culori deschise.

```css
--navy:       #0b2545   /* text, header tabel */
--blue:       #1d6fb8   /* butoane, accente */
--turq:       #0cb8c9   /* indicator tab activ, borduri focus */
--turq-light: #e0f7fa   /* hover export, result count bg */
--bg:         #f0f6ff   /* fundal pagină */
--surface:    #ffffff   /* carduri, header, tab nav */
--border:     #cfe0f5   /* borduri */
```

Header și tab nav sunt acum pe fundal alb cu text navy, în loc de fundal navy cu text deschis.

---

## 2. Donut charts cu hover și click

Fiecare secțiune are un donut chart generat pe `<canvas>` cu vanilla JS (fără biblioteci externe).

**Cum funcționează:**

La încărcarea paginii, `app.js` face un `fetch` către endpoint-ul secțiunii (fără filtre) și agregă datele client-side prin funcția `aggregate(rows, groupKey, valueKey)`. Rezultatul este o listă de segmente `{ label, value }` sortate descrescător.

**Hover:** la `mousemove`, se face hit testing geometric — se calculează distanța față de centru (pentru donut hole) și unghiul față de `atan2`, normalizat la `[-PI/2, 3PI/2]` pentru a corespunde arcelor desenate. Segmentul hovered se „sare" cu 9px față de centru și apare un tooltip cu numele și procentul.

**Click:** click pe un segment populează automat selectul corespunzător din formular (ex. click pe „Cannabis" → selectul „Tip drog" devine Cannabis) și declanșează un `submit` pe formular, care face fetch și afișează tabelul filtrat.

**Configurare per secțiune** (`PIE_CONFIG` în `app.js`):

```javascript
confiscari: { groupKey: 'drog',      valueKey: 'nr_capturi',    drillSelect: '#conf-drog', drillFilter: 'droguri' },
urgente:    { groupKey: 'categorie', valueKey: 'nr_pacienti',   drillSelect: '#urg-cat',   drillFilter: 'categorii' },
boli:       { groupKey: 'boala',     valueKey: 'nr_pozitivi',   drillSelect: '#boala-sel', drillFilter: 'boli' },
// ...
```

Legendă generată ca HTML lângă canvas, cu procentele calculate din totalul segmentelor.

---

## 3. Selector an — dropdown în loc de input text

**Problemă:** input `type="number"` pentru an permitea valori arbitrare, risc de injecție și UX slab.

**Soluție:** toate câmpurile de an au devenit `<select>` populate dinamic din API.

`api/filters.php` returnează acum și lista de ani disponibili:

```sql
SELECT DISTINCT an AS id, an AS label FROM confiscari
UNION SELECT DISTINCT an, an FROM condamnari
UNION SELECT DISTINCT an, an FROM sex_urgente
ORDER BY id ASC
```

La init, `app.js` populează toate selecturile `[name="an"]` și `.chart-year` cu valorile primite. Selectoarele de an din charturile sunt independente față de formular — schimbarea lor reîncarcă doar chartul, nu și tabelul.

---

## 4. Paginare — 50 rânduri per pagină

**Problemă:** tabelele puteau returna sute de rânduri fără nicio delimitare.

**Soluție:** funcția `renderPaginated(rows, cols, containerId)` gestionează paginarea client-side.

Datele sunt primite integral de la API, apoi sliced în JS:
```javascript
const slice = rows.slice((page - 1) * ROWS_PER_PAGE, page * ROWS_PER_PAGE);
```

Navigarea paginilor se face fără request suplimentar la server. Funcția `buildPagination(current, total)` generează butoane cu ellipsis pentru seturi mari de pagini:

```
‹  1  …  4  5  6  …  12  ›
```

La schimbarea paginii, pagina face scroll automat la începutul tabelului.

---

## 5. Drill-down: chart → tabel filtrat

Fluxul complet pentru secțiunea Confiscări ca exemplu:

1. Pagina se încarcă → `loadChart('confiscari', '')` → fetch `api/confiscari.php` → agregate `nr_capturi` per `drog` → donut chart randat
2. Utilizatorul schimbă anul din chart → `loadChart('confiscari', '2022')` → chart actualizat
3. Utilizatorul dă click pe un segment (ex. „Heroină") → `onSliceClick` găsește ID-ul în `filtersData.droguri` → setează `#conf-drog` → `form.dispatchEvent(submit)` → fetch `api/confiscari.php?drog_id=3` → tabel paginated afișat
4. Utilizatorul poate rafina manual din formular și da din nou Caută

---

## Pași următori

- [ ] Export vizualizări PNG / WebP / SVG
- [ ] Modul de administrare
- [ ] Validare HTML/CSS W3C
- [ ] Corelații între secțiuni (ex. confiscări vs urgențe pe același an)
