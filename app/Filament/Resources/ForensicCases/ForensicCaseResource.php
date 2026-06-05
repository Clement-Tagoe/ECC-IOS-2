<?php

namespace App\Filament\Resources\ForensicCases;

use App\Filament\Resources\ForensicCases\Pages\CreateForensicCase;
use App\Filament\Resources\ForensicCases\Pages\EditForensicCase;
use App\Filament\Resources\ForensicCases\Pages\ListForensicCases;
use App\Filament\Resources\ForensicCases\Pages\ViewForensicCase;
use App\Filament\Resources\ForensicCases\Schemas\ForensicCaseForm;
use App\Filament\Resources\ForensicCases\Schemas\ForensicCaseInfolist;
use App\Filament\Resources\ForensicCases\Tables\ForensicCasesTable;
use App\Models\ForensicCase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ForensicCaseResource extends Resource
{
    protected static ?string $model = ForensicCase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentMagnifyingGlass;

    protected static ?string $recordTitleAttribute = 'case_title';

    protected static string | UnitEnum | null $navigationGroup = 'Forensics';

    public static function form(Schema $schema): Schema
    {
        return ForensicCaseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ForensicCaseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ForensicCasesTable::configure($table);
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
            'index' => ListForensicCases::route('/'),
            'create' => CreateForensicCase::route('/create'),
            'view' => ViewForensicCase::route('/{record}'),
            'edit' => EditForensicCase::route('/{record}/edit'),
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
