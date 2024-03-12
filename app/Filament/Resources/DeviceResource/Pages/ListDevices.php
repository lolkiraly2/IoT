<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use Filament\Actions;
use App\Models\Device;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DeviceResource;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;


class ListDevices extends ListRecords
{
    protected static string $resource = DeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()->label(__('fields.all'))
                ->icon('heroicon-o-list-bullet')
                ->badge(Device::query()->count()),
            'active' => Tab::make()->label(__('fields.active'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', true))
                ->icon('heroicon-o-check-circle')
                ->badge(Device::query()->where('active', true)->count()),
            'inactive' => Tab::make()->label(__('fields.inactive'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('active', false))
                ->icon('heroicon-o-x-circle')
                ->badge(Device::query()->where('active', false)->count()),
        ];
    }

    public ?string $activeTab = 'active';
}
