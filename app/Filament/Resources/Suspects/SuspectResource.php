<?php

namespace App\Filament\Resources\Suspects;

use App\Filament\Resources\Suspects\Pages\CreateSuspect;
use App\Filament\Resources\Suspects\Pages\EditSuspect;
use App\Filament\Resources\Suspects\Pages\ListSuspects;
use App\Filament\Resources\Suspects\Pages\ViewSuspect;
use App\Filament\Resources\Suspects\Schemas\SuspectForm;
use App\Filament\Resources\Suspects\Schemas\SuspectInfolist;
use App\Filament\Resources\Suspects\Tables\SuspectsTable;
use App\Models\Suspect;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class SuspectResource extends Resource
{
    protected static ?string $model = Suspect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserMinus;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | UnitEnum | null $navigationGroup = 'Visitor Management';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return SuspectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SuspectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuspectsTable::configure($table);
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
            'index' => ListSuspects::route('/'),
            'create' => CreateSuspect::route('/create'),
            'view' => ViewSuspect::route('/{record}'),
            'edit' => EditSuspect::route('/{record}/edit'),
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
