<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\Auth;

class TaskChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Task Chart';

    protected static ?int $sort = 6;

    protected function getData(): array
    {

        $startDate = isset($this->pageFilters['startDate'])
            ? Carbon::parse($this->pageFilters['startDate'])->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate'])
            ? Carbon::parse($this->pageFilters['endDate'])->endOfDay()
            : now()->endOfDay();

        // Use a subquery or a focused query to avoid including extra columns 
        // that trigger the GROUP BY error.
        $query = Task::where('status', 'completed')
            ->whereHas('collaborators', function ($query) {
                $query->where('users.id', Auth::id());
            });

        $data = Trend::query($query)
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'My Completed Tasks',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                    'borderColor' => '#4b0c64ff', 
                    'backgroundColor' => 'rgba(60, 8, 90, 0.2)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
