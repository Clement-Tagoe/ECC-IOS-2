<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    
    protected function getStats(): array
    {
        $startDate = isset($this->pageFilters['startDate']) 
                    ? Carbon::parse($this->pageFilters['startDate'])->startOfDay() 
                    : now()->startOfMonth()->startOfDay();

        $endDate = isset($this->pageFilters['endDate']) 
                        ? Carbon::parse($this->pageFilters['endDate'])->endOfDay() 
                        : now()->endOfDay();

        $taskAssigned = Task::whereHas('collaborators', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $tasksCompleted = Task::where('status', 'completed')
            ->whereHas('collaborators', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $reportsSent = Report::where('user_id', Auth::id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $reportsReceived = Report::whereHas('receivers', fn ($q) => $q->where('users.id', Auth::id()))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            Stat::make('Reports Sent', $reportsSent)
                ->description('Sent Reports')
                ->color('success')
                ->icon('heroicon-o-document-arrow-up')
                ->chart([18, 15, 5, 10, 6, 8, 4, 9]),

            Stat::make('Reports Received', $reportsReceived)
                ->description('Received Reports')
                ->color('auxiliary')
                ->icon('heroicon-o-document-arrow-down')
                ->chart([4, 11, 5, 10, 6, 4, 8, 11]),
            
            Stat::make('Tasks Assigned', $taskAssigned)
                ->description('Tasks Assigned')
                ->color('nonary')
                ->icon('heroicon-o-clipboard-document')
                ->chart([18, 13, 5, 20, 6, 7, 8, 10]),

            Stat::make('Tasks Completed', $tasksCompleted)
                ->description('Completed Tasks')
                ->color('info')
                ->icon('heroicon-o-clipboard-document-check')
                ->chart([11, 13, 5, 15, 6, 7, 8, 14]),

        ];
    }
}
