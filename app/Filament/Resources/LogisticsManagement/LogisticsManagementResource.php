<?php

namespace App\Filament\Resources\LogisticsManagement;

use App\Filament\Resources\LogisticsManagement\Pages\CreateLogisticsManagement;
use App\Filament\Resources\LogisticsManagement\Pages\EditLogisticsManagement;
use App\Filament\Resources\LogisticsManagement\Pages\ListLogisticsManagement;
use App\Filament\Resources\LogisticsManagement\Pages\ViewLogisticsManagement;
use App\Filament\Resources\LogisticsManagement\Schemas\LogisticsManagementForm;
use App\Filament\Resources\LogisticsManagement\Schemas\LogisticsManagementInfolist;
use App\Filament\Resources\LogisticsManagement\Tables\LogisticsManagementTable;
use App\Models\LogisticsManagement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class LogisticsManagementResource extends Resource
{
    protected static ?string $model = LogisticsManagement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $recordTitleAttribute = 'item';

    protected static ?string $navigationLabel = 'Logistics Management';

    protected static string | UnitEnum | null $navigationGroup = 'Logistics';

    public static function form(Schema $schema): Schema
    {
        return LogisticsManagementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LogisticsManagementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogisticsManagementTable::configure($table);
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
            'index' => ListLogisticsManagement::route('/'),
            'create' => CreateLogisticsManagement::route('/create'),
            'view' => ViewLogisticsManagement::route('/{record}'),
            'edit' => EditLogisticsManagement::route('/{record}/edit'),
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
