<?php

namespace App\Policies;

use App\Models\DeviceType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeviceTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read devicetypes');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeviceType $deviceType): bool
    {
        return $user->can('read devicetypes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create devicetypes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeviceType $deviceType): bool
    {
        return $user->can('update devicetypes');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeviceType $deviceType): bool
    {
        return $user->can('delete devicetypes');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeviceType $deviceType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeviceType $deviceType): bool
    {
        return false;
    }
}
