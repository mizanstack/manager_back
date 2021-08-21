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

    public static function childrenCopy($id, $created_parent_id){
        $childrenObj = self::where('parent_id', $id);
        $childrenObjData = $childrenObj->get();
        if($childrenObj->count()){
            foreach ($childrenObjData as $child) {

                $copyAsParent = new \App\Models\Directory;
                $copyAsParent->parent_id = $created_parent_id;
                $copyAsParent->name = $child->name;
                $copyAsParent->slug = \Illuminate\Support\Str::slug($child->name);
                $copyAsParent->save();

                self::childrenCopy($child->id, $copyAsParent->id);
                \App\Models\Media::childrenCopy($child->id, $copyAsParent->id);

            }
        }
    }


     public static function childrenDelete($id){
        $childrenObj = self::where('parent_id', $id);
        $childrenObjData = $childrenObj->get();
        if($childrenObj->count()){
            foreach ($childrenObjData as $child) {
                $child->delete();
                self::childrenDelete($child->id);
                \App\Models\Media::childrenDelete($child->id);
            }
        }
    }


    public static function getNestedCategories(){
        $source = self::all();
        return self::nestedCategories($source);
    }

    public static function make_index_id($source){
        $id_indexed_array = [];
        foreach ($source as $value) {
            $id_indexed_array[$value['id']] = $value;
        }
        return $id_indexed_array;
    }


    public static function nestedCategories($source) {
        $nested = [];
        $source = $source->toArray();
        // return $source;
        $indexed_id_array = self::make_index_id($source);

        foreach ( $indexed_id_array as &$s ) {
            if ( is_null($s['parent_id']) ) {
                // no parent_id so we put it in the root of the array
                $nested[] = &$s;
            }
            else {
                $pid = $s['parent_id'];
                if ( isset($indexed_id_array[$pid]) ) {
                // dd($pid);
                    // If the parent ID exists in the indexed_id_array array
                    // we add it to the 'children' array of the parent after initializing it.

                    if ( !isset($indexed_id_array[$pid]['children']) ) {
                        $indexed_id_array[$pid]['children'] = array();
                    }

                    $indexed_id_array[$pid]['children'][] = &$s;
                }
            }
        }
        return $nested;
    }


    static function fetchNestedCategories($arr, $field_name='categories', $active_list=[], $indent='') {
        // dd($active_list);
        if ($arr) {
            foreach ($arr as $key => $value) {
                if (is_array($value)) {
                    //
                    self::fetchNestedCategories($value, $field_name, $active_list, $indent . '&nbsp;&nbsp;');
                } else {
                    if($key == 'id'){
                        if(in_array($arr[$key], $active_list)){
                            $checked = 'checked';
                        } else{
                            $checked = '';
                        }


                        echo '<li>' . $indent . '<label><input value="'.$arr[$key].'" type="checkbox" name="'.$field_name.'[]" '. $checked.'>'.$arr['name'].'</label></li>';
                        // echo "$indent $value <br />";
                    }
                }
            }
        }
    }

    
}
