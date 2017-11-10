<?php

namespace App\Repositories\Interfaces;

/**
 * Interface BaseRepository
 *
 * @package App\Repositories\Interfaces
 */
interface BaseRepository {
    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function find(int $id);

    public function all();
}