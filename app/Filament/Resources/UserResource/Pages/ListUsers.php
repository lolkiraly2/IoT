<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Spatie\Permission\Models\Role;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make()->label(__('fields.all'))
                ->icon('heroicon-o-list-bullet')
                ->badge(User::query()->count()),
        ];

        $roles = Role::all()->pluck('name');
        foreach ($roles as $role) {
            $tabs[$role] = Tab::make()->label($role)
                ->modifyQueryUsing(
                    fn (Builder $query) => $query
                        ->whereHas(
                            'roles',
                            function ($q) use ($role) {
                                $q->where('name', $role);
                            }
                        )
                )
                ->badge(
                    User::query()
                        ->whereHas(
                            'roles',
                            function ($q) use ($role) {
                                $q->where('name', $role);
                            }
                        )->count()
                )
                ->icon('heroicon-o-user-group');
        }
        return $tabs;
    }

    public ?string $activeTab = 'all';
}
