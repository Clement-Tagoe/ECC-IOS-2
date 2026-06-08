<?php

namespace App\Filament\Resources\ForensicReports;

use App\Filament\Resources\ForensicReports\Pages\CreateForensicReport;
use App\Filament\Resources\ForensicReports\Pages\EditForensicReport;
use App\Filament\Resources\ForensicReports\Pages\ListForensicReports;
use App\Filament\Resources\ForensicReports\Pages\ViewForensicReport;
use App\Filament\Resources\ForensicReports\Schemas\ForensicReportForm;
use App\Filament\Resources\ForensicReports\Schemas\ForensicReportInfolist;
use App\Filament\Resources\ForensicReports\Tables\ForensicReportsTable;
use App\Models\ForensicReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ForensicReportResource extends Resource
{
    protected static ?string $model = ForensicReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'case_reference_number';

    protected static string | UnitEnum | null $navigationGroup = 'Forensics';

    public static function form(Schema $schema): Schema
    {
        return ForensicReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ForensicReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ForensicReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForensicReports::route('/'),
            'create' => CreateForensicReport::route('/create'),
            'view' => ViewForensicReport::route('/{record}'),
            'edit' => EditForensicReport::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
