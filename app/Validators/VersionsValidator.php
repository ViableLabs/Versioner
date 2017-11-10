<?php

namespace App\Validators;

/**
 * Class VersionsValidator
 *
 * @package App\Validators
 */
class VersionsValidator extends AbstractValidator
{
    /** @var array $rules */
    protected static $rules
        = [
//            Uncomment if we want to validate this by rules and not resolve it in the repo
//            'commit_hash' => 'required|string|unique_with:versions,repository',
            'commit_hash' => 'required|string',
            'repository'  => 'required|string',
        ];
}