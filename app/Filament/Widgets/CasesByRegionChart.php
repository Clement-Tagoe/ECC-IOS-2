<?php

namespace App\Filament\Widgets;

use App\Models\Region;
use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class CasesByRegionChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Cases By Region Chart';
 
    protected ?string $description = 'Valid cases per region';

    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        $caseCounts = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])
            ->select('region_id', DB::raw('count(*) as total'))
            ->groupBy('region_id')
            ->pluck('total', 'region_id');

        $regions = Region::orderBy('name')->get();

        $labels = [];
        $values = [];

        foreach ($regions as $region) {
            $labels[] = $region->name;
            $values[] = $caseCounts->get($region->id, 0);
        }

        $colors = collect($values)->map(
            fn ($v) => $v > 0
                ? 'rgba(29, 78, 216, 0.85)'
                : 'rgba(156, 163, 175, 0.4)'
        )->toArray();

        return [
            'datasets' => [
                [
                    'label'           => 'Cases',
                    'data'            => $values,
                    'backgroundColor' => $colors,
                    'borderRadius'    => 4,
                    'borderWidth'     => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => ['beginAtZero' => true, 'grid' => ['display' => true]],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }
}
