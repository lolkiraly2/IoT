<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Worksheet;
use Filament\Tables\Table;
use App\Enums\WorksheetPriority;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\WorksheetResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\WorksheetResource\RelationManagers;

class WorksheetResource extends Resource
{
    protected static ?string $model = Worksheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.failure_report');
    }

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('module_names.worksheets.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.worksheets.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('device_id')->label(__('module_names.devices.label'))
                        ->relationship('device', 'name')
                        ->required(),
                    Forms\Components\Select::make('creator_id')->label(__('fields.creator'))
                        ->relationship('creator', 'name')
                        ->required(),
                    Forms\Components\Select::make('repairer_id')->label(__('fields.repairer'))
                        ->options(User::role('karbantartó')->get()->pluck('name', 'id')),
                    Forms\Components\Select::make('priority')->label(__('fields.priority'))
                        ->options(WorksheetPriority::class)
                        ->default('Normal')
                        ->required(),
                    Forms\Components\Textarea::make('description')->label(__('fields.description'))
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                    Forms\Components\DatePicker::make('due_date')->label(__('fields.due_date'))
                        ->minDate(now()),
                    Forms\Components\DatePicker::make('finish_date')->label(__('fields.finish_date'))
                        ->minDate(now())
                        ->default(now()),
                    Forms\Components\FileUpload::make('attachments')->label(__('fields.attachments'))
                        ->required()
                        ->multiple()
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('comment')->label(__('fields.note'))
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device.name')->label(__('module_names.devices.label'))
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')->label(__('fields.description'))
                    ->limit(30)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')->label(__('fields.priority'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')->label(__('fields.creator'))
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('repairer.name')->label(__('fields.repairer'))
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('due_date')->label(__('fields.due_date'))
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('finish_date')->label(__('fields.finish_date'))
                    ->date('Y-m-d')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__('fields.updated_at'))
                    ->dateTime('Y-m-d H:i')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListWorksheets::route('/'),
            'create' => Pages\CreateWorksheet::route('/create'),
            'view' => Pages\ViewWorksheet::route('/{record}'),
            'edit' => Pages\EditWorksheet::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     //dd(auth()->user());
    //     if (!auth()->user()->can('read worksheets'))
    //         return parent::getEloquentQuery()->where('creator_id', auth()->user()->id);
    // }
}
