<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdvertisementPolicy
{
    /**
     * Determine whether the user can view any models.
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * @param User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * @param User $user
     * @param Advertisement $advertisement
     * @return bool
     */
    public function update(User $user, Advertisement $advertisement): bool
    {
        return $advertisement->user->id === $user->id ||
            $user->id === 1;
    }

    /**
     * Determine whether the user can delete the model.
     * @param User $user
     * @param Advertisement $advertisement
     * @return bool
     */
    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $advertisement->user->id === $user->id ||
            $user->id === 1 || $user->id === 2;
    }

    /**
     * Determine whether the user can restore the model.
     * @param User $user
     * @param Advertisement $advertisement
     * @return bool
     */
    public function restore(User $user, Advertisement $advertisement): bool
    {
        return $advertisement->user()->id === $user->id ||
            $user->id === 1;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Advertisement $advertisement): bool
    {
        return $user->id === 2 || $user->id === 1;
    }
}
