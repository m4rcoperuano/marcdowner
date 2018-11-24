<?php
/**
 * Created by PhpStorm.
 * User: marcoledesma
 * Date: 11/23/18
 * Time: 12:49 PM
 */

namespace App\Models;


use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Content
 * @package App\Models
 * @property string $title;
 * @property string $unparsed_markdown;
 * @property integer $user_id;
 */
class Content extends Model
{
    use UuidTrait, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'title',
        'unparsed_markdown',
        'user_id'
    ];
}