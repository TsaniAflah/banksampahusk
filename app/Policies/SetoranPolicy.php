<?php

namespace App\Policies;

use App\Models\Setoran;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SetoranPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Setoran $setoran): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $admins = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'admin');
            }
        )->get(); //[1, 3]

        if ($admins) return true;
        else return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Setoran $setoran): bool
    {
        $admins = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'admin');
            }
        )->get(); //[1, 3]

        if ($admins) return true;
        else return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Setoran $setoran): bool
    {
        $admins = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'admin');
            }
        )->get(); //[1, 3]

        if ($admins) return true;
        else return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Setoran $setoran): bool
    {
        $admins = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'admin');
            }
        )->get(); //[1, 3]

        if ($admins) return true;
        else return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Setoran $setoran): bool
    {
        $admins = User::whereHas(
            'roles',
            function ($query) {
                $query->where('name', 'admin');
            }
        )->get(); //[1, 3]

        if ($admins) return true;
        else return false;
    }
}
