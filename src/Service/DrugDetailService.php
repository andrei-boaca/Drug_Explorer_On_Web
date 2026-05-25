<?php

class DrugDetailService
{
    public function __construct(private DrugDetailRepository $repo) {}

    public function getDetail(string $section, string $label): array
    {
        switch ($section) {
            case 'confiscari':
                $summary  = $this->repo->getConfiscariSummary($label);
                $category = $this->repo->getDrugCategoryName($label);
                $result = [
                    'type'     => 'confiscari',
                    'drug'     => $label,
                    'summary'  => $summary,
                    'category' => $category,
                ];
                if ($category) {
                    $result['urgente']   = $this->repo->getUrgenteBreakdowns($category);
                    $result['tratament'] = $this->repo->getTratamentBreakdowns($category);
                }
                return $result;

            case 'urgente':
                return [
                    'type'       => 'urgente',
                    'category'   => $label,
                    'breakdowns' => $this->repo->getUrgenteBreakdowns($label),
                ];

            case 'tratament':
                return [
                    'type'       => 'tratament',
                    'category'   => $label,
                    'breakdowns' => $this->repo->getTratamentBreakdowns($label),
                ];

            default:
                return ['type' => 'generic', 'label' => $label];
        }
    }
}
