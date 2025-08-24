<?php

namespace Modules\Team\Policies;

use Modules\Team\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_admin::admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('view_admin::admin');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_admin::admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('update_admin::admin');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('delete_admin::admin');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_admin::admin');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_admin::admin');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_admin::admin');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('restore_admin::admin');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_admin::admin');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function replicate(User $user): bool
    {
        return $user->can('replicate_admin::admin');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \Modules\Team\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_admin::admin');
    }
}
