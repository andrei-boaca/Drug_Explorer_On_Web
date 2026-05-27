# Drug Explorer on Web

Aplicatie web pentru vizualizarea datelor despre droguri in Romania: confiscari, condamnari, urgente medicale, tratament, actiuni de preventie si boli infectioase.

## Stack

- **Backend**: PHP 8 vanilla, PDO + MySQL, arhitectura MVC (`src/Controller`, `src/Service`, `src/Repository`, `src/DTO`)
- **Frontend**: HTML/CSS + JavaScript vanilla, grafice pe Canvas (bar, horizontal bar, donut)
- **Harti**: D3.js + topojson, scor AI via Groq API (Llama 3.3)
- **Router**: `api/router.php` — un singur punct de intrare pentru toate request-urile JSON

## Structura

```
index.php          # Shell HTML
admin.php          # Panou CRUD + autentificare
config.php         # Conexiune PDO, constante DB
api/router.php     # Dispatcher central
js/app.js          # Toata logica frontend (AJAX, tabele, grafice, export)
js/ai_map.js       # Harta europeana cu scoruri AI
src/               # MVC backend (Controller / Service / Repository / DTO)
```

## Cum rulezi

1. Importa `schema.sql`, apoi `populare_2021.sql`, `populare_2022.sql`, `populare_extra.sql`
2. Completeaza `config.php` cu datele conexiunii MySQL
3. Serveste directorul cu un server PHP (`php -S localhost:8080`) sau Apache/Nginx
4. Deschide `http://localhost:8080/`

Panoul de administrare e la `/admin.php` (credentiale implicite in `admin.php` — schimba-le inainte de productie).
