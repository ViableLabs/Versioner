<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ValidationException;
use App\Form\FormModel;
use App\Http\Controllers\Api\ApiController;
use App\Repositories\VersionsRepository;
use App\Validators\VersionsValidator;
use Flugg\Responder\Responder;
use Illuminate\Http\Request;
use \Flugg\Responder\Http\Responses\ErrorResponseBuilder;
use \Flugg\Responder\Http\Responses\SuccessResponseBuilder;

/**
 * Class VersionsController
 *
 * @package App\Http\Controllers\Api\V1
 */
class VersionsController extends ApiController
{
    /** @var VersionsRepository $repository */
    protected $repository;
    /** @var VersionsValidator $validator */
    protected $validator;
    /** @var FormModel $formModel */
    protected $formModel;

    /**
     * VersionsController constructor.
     *
     * @param VersionsRepository $repository
     * @param VersionsValidator  $validator
     */
    public function __construct(
        VersionsRepository $repository,
        VersionsValidator $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->formModel = new FormModel($this->validator, $this->repository);
    }

    /**
     * @param Request   $request
     * @param Responder $responder
     *
     * @return ErrorResponseBuilder|SuccessResponseBuilder
     */
    public function create(Request $request, Responder $responder)
    {
        try {
            $this->formModel->process($request->all());
        } catch (ValidationException $exception) {
            return $responder->error(400, $this->formModel->getErrors()->toJson());
        }

        return $responder->success();
    }
}