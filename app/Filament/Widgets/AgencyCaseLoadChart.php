<?php

namespace App\Filament\Widgets;

use App\Models\ValidCase;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class AgencyCaseLoadChart extends ChartWidget
{
    use InteractsWithPageFilters;
    
    protected ?string $heading = 'Agency Case Load Chart';

    protected ?string $description = 'Agency case load';
 
    protected function getData(): array
    {
        $startDate = isset($this->filters['startDate'])
            ? Carbon::parse($this->filters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->filters['endDate'])
            ? Carbon::parse($this->filters['endDate'])->endOfDay()
            : now()->endOfDay();

        $data = ValidCase::whereBetween('reporting_date', [$startDate, $endDate])
            ->select('agency_id', DB::raw('count(*) as total'))
            ->with('Agency')
            ->groupBy('agency_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = $data->map(fn ($row) => $row->agency?->name ?? "Agency {$row->agency_id}")->toArray();
        $values = $data->pluck('total')->toArray();

        $palette = [
            '#1d4ed8', // blue
            '#059669', // green
            '#dc2626', // red
            '#d97706', // amber
            '#7c3aed', // purple
            '#0891b2', // cyan
            '#be185d', // pink
            '#65a30d', // lime
            '#ea580c', // orange
            '#0f766e', // teal
        ];

        $colors = collect($labels)->map(fn ($_, $i) => $palette[$i % count($palette)])->toArray();

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
            'plugins'   => ['legend' => ['display' => false]],
            'scales'    => [
                'x' => ['beginAtZero' => true, 'grid' => ['color' => 'rgba(0,0,0,0.05)']],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }
}
