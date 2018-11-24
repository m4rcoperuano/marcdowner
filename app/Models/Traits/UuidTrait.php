<?php
/**
 * Created by PhpStorm.
 * User: marcoledesma
 * Date: 11/23/18
 * Time: 12:48 PM
 */

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }
}