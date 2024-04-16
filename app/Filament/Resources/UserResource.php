<?php
//Táblázat: oszlopok, szűrő és akciók
namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Pages\EditUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): string
    {
        return __('module_names.navigation_groups.administration');
    }

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('module_names.users.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.users.plural_label');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('fields.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->label(__('fields.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->required(static fn (Page $livewire): string => $livewire instanceof CreateUser,)
                    ->dehydrateStateUsing(
                        fn (?string $state): ?string =>
                        filled($state) ? Hash::make($state) : null
                    )
                    ->dehydrated(
                        fn (?string $state): bool =>
                        filled($state)
                    )
                    ->label(
                        fn (Page $livewire): string => ($livewire instanceof EditUser) ? __('fields.new_password') : __('fields.password')
                    ),

                Forms\Components\CheckboxList::make('roles')->label(__('module_names.roles.label'))
                    ->columnSpanFull()
                    ->relationship('roles', 'name')
                    ->columns(3)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('fields.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__('fields.email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->label(__('module_names.roles.plural_label'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')->label(__('fields.deleted_at'))
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
