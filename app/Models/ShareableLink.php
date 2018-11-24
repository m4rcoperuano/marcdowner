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
 * @property integer $content_id;
 */
class ShareableLink extends Model
{
    use UuidTrait, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'content_id'
    ];

    public function content() {
        return $this->belongsTo('App\Models\Content');
    }
}