<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Spatie\Permission\Models\Role;

class UsersByRolesChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $roles = Role::all()->pluck('name');
        $data = [];
        $colors = ['red', 'green', 'blue'];

        foreach ($roles as $role) {
            $data[] = User::with('roles')->get()->filter(
                fn ($user) => $user->roles->where('name', $role)->toArray()
            )->count();
        }
        return [
            'datasets' => [
                [
                    'label' => 'Users by roles',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $roles,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getHeading(): string
    {
        return __('module_names.widgets.usersbyroles');
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'display' => false,
                ],
                'y' => [
                    'display' => false,
                ],
            ],
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => __('module_names.users.plural_label') . ' (' . User::all()->count() . ')',
                ]
            ]
        ];
    }
}
