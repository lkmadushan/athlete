<?php namespace Athlete\Repositories\User;

interface UserRepository
{

    /**
     * Persist a user
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data);

    /**
     * Save user and device
     *
     * @param array $data
     * @return mixed
     */
    public function saveWithDevice(array $data);

    /**
     * Purchase the account
     *
     * @param \User $user
     * @return mixed
     */
    public function makePurchase(\User $user);
}
