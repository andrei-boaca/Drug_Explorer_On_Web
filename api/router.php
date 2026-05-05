<?php
require_once __DIR__ . '/_base.php';

$section = $_GET['section'] ?? '';
$format  = $_GET['format']  ?? null;

// If a format param is present it is an export request
if ($format !== null) {
    require_once __DIR__ . '/../src/Controller/ExportController.php';
    (new ExportController(
        new ExportService(getConnection())
    ))->handle();
}

switch ($section) {
    case 'filters':
        require_once __DIR__ . '/../src/Controller/FiltersController.php';
        (new FiltersController(
            new FiltersService(
                new FiltersRepository(getConnection())
            )
        ))->handle();
        break;

    case 'actiuni':
        require_once __DIR__ . '/../src/Controller/ActiuniController.php';
        (new ActiuniController(
            new ActiuniService(
                new ActiuniRepository(getConnection())
            )
        ))->handle();
        break;

    case 'boli':
        require_once __DIR__ . '/../src/Controller/BoliController.php';
        (new BoliController(
            new BoliService(
                new BoliRepository(getConnection())
            )
        ))->handle();
        break;

    case 'condamnari':
        require_once __DIR__ . '/../src/Controller/CondamnariController.php';
        (new CondamnariController(
            new CondamnariService(
                new CondamnariRepository(getConnection())
            )
        ))->handle();
        break;

    case 'confiscari':
        require_once __DIR__ . '/../src/Controller/ConfiscariController.php';
        (new ConfiscariController(
            new ConfiscariService(
                new ConfiscariRepository(getConnection())
            )
        ))->handle();
        break;

    case 'tratament':
        require_once __DIR__ . '/../src/Controller/TratamentController.php';
        (new TratamentController(
            new TratamentService(
                new TratamentRepository(getConnection())
            )
        ))->handle();
        break;

    case 'urgente':
        require_once __DIR__ . '/../src/Controller/UrgenteController.php';
        (new UrgenteController(
            new UrgenteService(
                new UrgenteRepository(getConnection())
            )
        ))->handle();
        break;

    default:
        respondError('Secțiune invalidă.');
}
