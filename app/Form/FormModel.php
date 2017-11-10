<?php namespace App\Form;

/**
 * Class FormModel
 *
 * Class to save form data associated to a model
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
use App\Form\Interfaces\FormInterface;
use App\Repositories\Interfaces\BaseRepository;
use App\Validators\Interfaces\ValidatorInterface;
use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\MessageBag;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionException;
use Event;

class FormModel implements FormInterface
{
    /**
     * Validator
     *
     * @var ValidatorInterface
     */
    protected $v;
    /**
     * Repository used to handle data
     *
     * @var BaseRepository
     */
    protected $r;
    /**
     * Name of the model id field
     *
     * @var string
     */
    protected $id_field_name = "id";
    /**
     * Validation errors
     *
     * @var MessageBag
     */
    protected $errors;

    /**
     * FormModel constructor.
     *
     * @param ValidatorInterface $validator
     * @param BaseRepository     $repository
     */
    public function __construct(
        ValidatorInterface $validator,
        BaseRepository $repository
    ) {
        $this->v = $validator;
        $this->r = $repository;
    }

    /**
     * Process the input and calls the repository
     *
     * @param array $input
     *
     * @return mixed
     * @throws ValidationException
     */
    public function process(array $input)
    {
        if ($this->v->validate($input)) {
            Event::fire("form.processing", array($input));

            return $this->callRepository($input);
        } else {
            $this->errors = $this->v->getErrors();
            throw new ValidationException;
        }
    }

    /**
     * Calls create or update depending on giving or not the id
     *
     * @param $input
     *
     * @return mixed
     * @throws NotFoundException
     * @throws PermissionException
     */
    protected function callRepository($input)
    {
        if ($this->isUpdate($input)) {
            try {
                $obj = $this->r->update($input[$this->id_field_name], $input);
            } catch (ModelNotFoundException $e) {
                $this->errors = new MessageBag(
                    array("model" => "Element not found.")
                );
                throw new NotFoundException();
            } catch (PermissionException $e) {
                $this->errors = new MessageBag(
                    array("model" => "You don't have the permission to edit this item. Does the item is associated to other elements? if so delete the associations first.")
                );
                throw new PermissionException();
            }
        } else {
            try {
                $obj = $this->r->create($input);
            } catch (NotFoundException $e) {
                $this->errors = new MessageBag(
                    array("model" => $e->getMessage())
                );
                throw new NotFoundException();
            }
        }

        return $obj;
    }

    /**
     * Check if the operation is update or create
     *
     * @param $input
     *
     * @return bool
     */
    protected function isUpdate($input)
    {
        return (isset($input[$this->id_field_name])
            && !empty($input[$this->id_field_name]));
    }

    /**
     * Run delete on the repository
     *
     * @param array $input
     *
     * @throws NotFoundException
     * @throws PermissionException
     */
    public function delete(array $input)
    {
        if (isset($input[$this->id_field_name])
            && !empty($input[$this->id_field_name])
        ) {
            try {
                $this->r->delete($input[$this->id_field_name]);
            } catch (ModelNotFoundException $e) {
                $this->errors = new MessageBag(
                    array("model" => "Element does not exists.")
                );
                throw new NotFoundException();
            } catch (PermissionException $e) {
                $this->errors = new MessageBag(
                    array("model" => "Cannot delete this item, please check that the item is not already associated to any other element, in that case remove the association first.")
                );
                throw new PermissionException();
            }
        } else {
            $this->errors = new MessageBag(array("model" => "Id not given"));
            throw new NotFoundException();
        }
    }

    /**
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param string $id_name
     */
    public function setIdName($id_name)
    {
        $this->id_field_name = $id_name;
    }

    /**
     * @return string
     */
    public function getIdName()
    {
        return $this->id_field_name;
    }
}