<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Version
 *
 * @property string    $commit_hash
 * @property string    $repository
 * @property string    $repository_version
 * @property \DateTime $deployment_date
 *
 * @package App\Models
 */
class Version extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'commit_hash',
            'repository',
            'repository_version',
            'deployment_date',
        ];
}
