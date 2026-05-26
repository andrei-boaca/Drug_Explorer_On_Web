<?php

require_once __DIR__ . '/ActiuniService.php';
require_once __DIR__ . '/BoliService.php';
require_once __DIR__ . '/CondamnariService.php';
require_once __DIR__ . '/ConfiscariService.php';
require_once __DIR__ . '/TratamentService.php';
require_once __DIR__ . '/UrgenteService.php';
require_once __DIR__ . '/../Repository/ActiuniRepository.php';
require_once __DIR__ . '/../Repository/BoliRepository.php';
require_once __DIR__ . '/../Repository/CondamnariRepository.php';
require_once __DIR__ . '/../Repository/ConfiscariRepository.php';
require_once __DIR__ . '/../Repository/TratamentRepository.php';
require_once __DIR__ . '/../Repository/UrgenteRepository.php';

class ExportService
{
    public function __construct(private PDO $pdo) {}

    /**
     * Returns rows as plain arrays for the requested section,
     * applying the same filters as the individual endpoints.
     *
     * @return array[]|null  null when the section name is not recognised
     */
    public function getExportData(string $section, array $params): ?array
    {
        $an          = $params['an']           ?? null;
        $boala_id    = $params['boala_id']     ?? null;
        $drog_id     = $params['drog_id']      ?? null;
        $categorie_id = $params['categorie_id'] ?? null;
        $sex         = $params['sex']          ?? null;

        switch ($section) {
            case 'actiuni':
                $dtos = (new ActiuniService(new ActiuniRepository($this->pdo)))->getActiuni($an);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            case 'boli':
                $dtos = (new BoliService(new BoliRepository($this->pdo)))->getBoli($boala_id);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            case 'condamnari':
                $dtos = (new CondamnariService(new CondamnariRepository($this->pdo)))->getCondamnari($an, $sex);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            case 'confiscari':
                $dtos = (new ConfiscariService(new ConfiscariRepository($this->pdo)))->getConfiscari($drog_id, $an);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            case 'tratament':
                $dtos = (new TratamentService(new TratamentRepository($this->pdo)))->getTratament($categorie_id, $an);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            case 'urgente':
                $dtos = (new UrgenteService(new UrgenteRepository($this->pdo)))->getUrgente($categorie_id, $an);
                return array_map(fn($dto) => $dto->toArray(), $dtos);

            default:
                return null;
        }
    }
}
