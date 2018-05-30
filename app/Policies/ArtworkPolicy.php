<?php

namespace App\Policies;

use App\User;
use App\Artwork;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArtworkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the artWork.
     *
     * @param  \App\User  $user
     * @param  \App\ArtWork  $artWork
     * @return mixed
     */
    public function view(User $user, Artwork $artwork)
    {
        //
    }

    /**
     * Determine whether the user can create artWorks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the artWork.
     *
     * @param  \App\User  $user
     * @param  \App\ArtWork  $artWork
     * @return mixed
     */
    public function update(User $user, ArtWork $artWork)
    {
        //
    }

    /**
     * Determine whether the user can delete the artWork.
     *
     * @param  \App\User  $user
     * @param  \App\ArtWork  $artWork
     * @return mixed
     */
    public function delete(User $user, ArtWork $artWork)
    {
        //
    }
}
