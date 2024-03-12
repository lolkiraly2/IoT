<?php

namespace App\Filament\Resources\DeviceResource\Pages;

use App\Filament\Resources\DeviceResource;
use Filament\Resources\Pages\Page;

class QRDevice extends Page
{
    protected static string $resource = DeviceResource::class;

    protected static string $view = 'filament.resources.device-resource.pages.q-r-device';
}
