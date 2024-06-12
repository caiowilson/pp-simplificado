<?php

namespace App\Services;

use App\Models\User;
use Exception;
use GuzzleHttp\Client;


class UserService
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::all();
    }

    /**
     * Get a user by ID.
     *
     * @param  int  $id
     * @return \App\Models\User|null
     */
    public function findUserById($id)
    {
        return User::find($id);
    }

    /**
     * Create a new user.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }

    /**
     * Update a user.
     *
     * @param  int  $id
     * @param  array  $data
     * @return bool
     */
    public function updateUser($id, array $data)
    {
        $user = User::find($id);

        if ($user) {
            return $user->update($data);
        }

        return false;
    }

    /**
     * Delete a user.
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }

    public function validatePayerTransaction(User $payer, float $value): void
    {
        if ($payer->is_seller) {
            throw new Exception('Merchants/Sellers cannot send money', 403);
        }
    
        if ($payer->balance < $value) {
            throw new Exception('Insufficient funds', 403);
        }
    
        if ($payer->hasRole('seller')) {
            throw new Exception('Sellers/Merchants cannot create transactions', 403);
        }

        if (($payer->balance < $value) || $payer->balance == 0) {
            throw new Exception('Insufficient funds', 403);
        }
    }
}