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

    public static function childrenCopy($id, $new_directory_parent_id){
        $childrenObj = self::where('directory_id', $id);
        $childrenObjData = $childrenObj->get();
        if($childrenObj->count()){
            foreach ($childrenObjData as $child) {

                $copyAsParent = new \App\Models\Media;
                $copyAsParent->directory_id = $new_directory_parent_id;
                $copyAsParent->name = $child->name;


                $copyied_file_name = add_text_before_ext($text='_copy', $child->attachment);

                $file = public_path("/uploads/medias/" . $child->attachment);
                $destination = public_path("/uploads/medias/". $copyied_file_name);

                if(\File::exists($file)){
                    \File::copy($file,$destination);
                }


                $copyAsParent->attachment = $copyied_file_name;
                $copyAsParent->save();

                // self::childrenCopy($child->id, $copyAsParent->id);

            }
        }
    }


    public static function childrenDelete($id){
        $childrenObj = self::where('directory_id', $id);
        $childrenObjData = $childrenObj->get();
        if($childrenObj->count()){
            foreach ($childrenObjData as $child) {
                $file = public_path("/uploads/medias/" . $child->attachment);
                if (\File::exists($file)) { // unlink or remove previous image from folder
                    unlink($file);
                }
                $child->delete();
            }
        }
    }



    

    
}
