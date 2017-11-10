<?php namespace App\Form\Interfaces;

interface FormInterface
{
    public function process(array $input);

    public function delete(array $input);

    public function getErrors();
}