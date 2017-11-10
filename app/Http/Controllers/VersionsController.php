<?php

namespace App\Http\Controllers;

use App\Repositories\VersionsRepository;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use \Illuminate\Http\JsonResponse;
/**
 * Class VersionsController
 *
 * @package App\Http\Controllers
 */
class VersionsController extends Controller {

    /** @var VersionsRepository $repository */
    protected $repository;

    /**
     * VersionsController constructor.
     *
     * @param VersionsRepository $repository
     */
    public function __construct(VersionsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Factory|View
     */
    public function list()
    {
        return view('Versions.list');
    }

    /**
     * @return JsonResponse
     */
    public function getListData()
    {
        return DataTables::eloquent($this->repository->getQuery())->make(true);
    }
}