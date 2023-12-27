<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * Список пользователей доступен только Администратору.
     * @param User $user
     * @return bool|Response
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->role->id === 1 && $user->role->name == 'Администратор';
    }

    /**
     * Determine whether the user can view the model.
     * Информация о конкретном пользователе доступна всем.
     * @param User $user
     * @param User $model
     * @return bool|Response
     */
    public function view(User $user, User $model): Response|bool
    {
//        return ($user->id === $model->id
//            || ($user->role->id === 1 && $user->role->name == 'Администратор')
//        );
        return true;
    }

    /**
     * Determine whether the user can create models.
     * Регистрация доступна всем.
     * @param User $user
     * @return bool|Response
     */
    public function create(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * Обновление пользователя доступно только самому пользователю.
     * @param User $user
     * @param User $model
     * @return bool|Response
     */
    public function update(User $user, User $model): Response|bool
    {
        return $user->role->id === $model->role->id || $user->role->id === 1;
    }

    /**
     * Determine whether the user can delete the model.
     * Удаление пользователя доступно самому пользователю, а также Администратору
     * @param User $user
     * @param User $model
     * @return bool|Response
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $user->role->id === $model->role->id || $user->role->id === 1;
    }

    /**
     * Determine whether the user can restore the model.
     * Восстановление пользователя доступно Администратору.
     * @param User $user
     * @param User $model
     * @return bool|Response
     */
    public function restore(User $user, User $model): Response|bool
    {
        return $user->role->id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Удаление доступно Администратору
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->role->id === 1;
    }
}
