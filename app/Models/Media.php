<?php

namespace App\Models;

use \App\Model as Model;

/**
 * Class Media
 * @package App\Models
 * @version August 18, 2021, 4:06 pm UTC
 *
 * @property integer directory_id
 * @property string name
 */
class Media extends Model
{

    public $table = 'media';

    public $upload_path = 'uploads/media';

    public $search_fields = [
        'directory_id',
        'name'
    ];
    public $fillable = [
        'directory_id',
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'directory_id' => 'integer',
        'name' => 'string',
        'attachment' => 'text'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'directory_id' => 'required',
        'name' => 'required'
    ];

    
}
