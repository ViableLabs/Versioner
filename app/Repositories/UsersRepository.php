<?php

namespace App\Repositories;

use App\Models\OauthClient;
use App\Models\User;
use App\Repositories\Interfaces\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class UsersRepository
 *
 * @package App\Repositories
 */
class UsersRepository implements BaseRepository
{

    /**
     * @param array $data
     *
     * @return User
     */
    public function create(array $data)
    {
        $obj = new User();
        $obj->fill($data);
        $obj->save();

        return $obj;
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return User
     */
    public function update(int $id, array $data)
    {
        $obj = $this->find($id);
        $obj->fill($data);
        $obj->save();

        return $obj;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function find(int $id)
    {
        return User::find($id);
    }

    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     * @return bool
     */
    public function delete(int $id)
    {
        $obj = $this->find($id);

        if (empty($obj)) {
            throw new ModelNotFoundException("User not found!");
        }

        $obj->delete();

        return true;
    }

    /**
     * @return Collection
     */
    public function all()
    {
        return User::all();
    }

    /**
     * @param int $id
     *
     * @return OauthClient
     */
    public function findApiClient(int $id)
    {
        return OauthClient::find($id);
    }

}