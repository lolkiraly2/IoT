<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Device;
use Filament\Infolists;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DeviceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeviceResource\RelationManagers;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Contracts\View\View;


class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.devices.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.devices.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('fields.name'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('erp_code')->label(__('fields.erp_code'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('type_id')->label(__('fields.type'))
                    ->relationship('type', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->label(__('fields.name'))
                            ->required()
                            ->unique()
                            ->maxLength(255)
                    ])
                    ->required(),
                Forms\Components\TextInput::make('plant')->label(__('fields.plant'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('active')->label(__('fields.active'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpan('full'),
                Forms\Components\TextInput::make('history')->label(__('fields.history'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('note')->label(__('fields.note'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('erp_code')->label(__('fields.erp_code'))
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type.name')->label(__('fields.type'))
                    ->searchable()->sortable(),
                Tables\Columns\IconColumn::make('active')->label(__('fields.active'))
                    ->boolean()
                    ->action(function ($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    }),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\Action::make('QR')->label(__('fields.qr_code'))
                    ->modalContent(fn ($record): View => view('filament.resources.device-resource.pages.q-r-device', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
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
            RelationManagers\DocumentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
            'qr' => Pages\QRDevice::route('/qr/{record}'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')->label(__('fields.name')),
                Infolists\Components\TextEntry::make('erp_code')->label(__('fields.erp_code')),
                Infolists\Components\TextEntry::make('type.name')->label(__('fields.type')),
                Infolists\Components\TextEntry::make('plant')->label(__('fields.plant')),
                Infolists\Components\TextEntry::make('active')->label(__('fields.active'))
                    ->state(function (Model $record): string {
                        return $record->active ? __('fields.yes') :  __('fields.no');
                    }),
                Infolists\Components\TextEntry::make('history')->label(__('fields.history')),
                Infolists\Components\TextEntry::make('notes')->label(__('fields.note')),
            ]);
    }
}
