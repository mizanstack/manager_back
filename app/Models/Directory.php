<?php

namespace App\Models;

use \App\Model as Model;

/**
 * Class Directory
 * @package App\Models
 * @version August 18, 2021, 4:03 pm UTC
 *
 * @property integer parent_id
 * @property string name
 * @property string slug
 */
class Directory extends Model
{

    public $table = 'directories';

    public $upload_path = 'uploads/directories';

    public $search_fields = [
        'parent_id',
        'name',
        'slug'
    ];
    public $fillable = [
        'parent_id',
        'name',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
        'name' => 'string',
        'slug' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    
}
