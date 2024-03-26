<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeviceTypeResource\Pages;
use App\Filament\Resources\DeviceTypeResource\RelationManagers;
use App\Models\DeviceType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceTypeResource extends Resource
{
    protected static ?string $model = DeviceType::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?int $navigationSort = 1;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeviceTypes::route('/'),
            'create' => Pages\CreateDeviceType::route('/create'),
            'edit' => Pages\EditDeviceType::route('/{record}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label(__('fields.name'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('note')->label(__('fields.note'))
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DevicesRelationManager::class,
        ];
    }
    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.maintenance');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.device_types.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.device_types.plural_label');
    }

    
}
