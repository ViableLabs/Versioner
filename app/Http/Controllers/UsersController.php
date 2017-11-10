<?php

namespace App\Http\Controllers;

use App\Repositories\UsersRepository;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\View\View;

/**
 * Class UsersController
 *
 * @package App\Http\Controllers
 */
class UsersController extends Controller {

    /**
     * @return Factory|View
     */
    public function list()
    {
        return view('ApiUsers.list');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('ApiUsers.edit');
    }

    /**
     * @param int $id
     *
     * @return Factory|View
     */
    public function edit(int $id)
    {
        $user = (new UsersRepository())->findApiClient($id);

        return view('ApiUsers.edit', compact('user'));
    }
}