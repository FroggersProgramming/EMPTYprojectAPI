<?php

namespace App\Policies;

use App\Models\CategoryField;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryFieldPolicy
{
    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @param CategoryField $categoryField
     * @return bool
     */
    public function view(User $user, CategoryField $categoryField): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param CategoryField $categoryField
     * @return bool
     */
    public function update(User $user, CategoryField $categoryField): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param CategoryField $categoryField
     * @return bool
     */
    public function delete(User $user, CategoryField $categoryField): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param CategoryField $categoryField
     * @return bool
     */
    public function restore(User $user, CategoryField $categoryField): bool
    {
        return $user->role->id === 1 || $user->role->id === 2;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @param User $user
     * @param CategoryField $categoryField
     * @return bool
     */
    public function forceDelete(User $user, CategoryField $categoryField): bool
    {
        return $user->role->id === 1;
    }
}
