<?php

namespace App;

use Flash;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $guard_name = 'web';
    public $upload_path = 'uploads';
    public $search_fields = [];
    protected $guarded = [];

    public function scopeWithSearch($query){
        $keyword = request()->keyword;
        $search_fields = $this->search_fields;
        // dd($search_fields);

        if(request('keyword')){

            if(count($search_fields)){
                foreach ($search_fields as $field) {
                    $query = $query->orWhere( $field, 'like', '%' . $keyword . '%');
                }
            }
        }
        return $query;
    }
    
    public function scopeActive($query){
        return $query->where('status', 1);
    }



    public function uploadFileVue($field_or_field_with_request, $save_title='', $path=null, $request_method = false){
        // return($field);
        $path = $path ? $path : $this->upload_path;

        $has_profile_photo = $request_method ? $field_or_field_with_request : request($field_or_field_with_request);

        if($has_profile_photo){
            $extension = $has_profile_photo->getClientOriginalExtension(); // getting image extension
            $filename =  remove_space_dots_replace_underscore($save_title) . '_' . time() . mt_rand(1000, 9999) . '.'.$extension;

            // \Image::make($has_profile_photo)->save(public_path($path).$filename);

            request($field_or_field_with_request)->move(public_path($path), $filename);

            return $filename;
        }
        return null;
    }         

    public function deleteImage($field)
    {
        $image = $this->getOriginal($field);
        if (empty($image)) {
            return true;
        }
        // dd($this->getOriginal($field));
        $post_data_photo = public_path($this->upload_path . "/{$image}"); // get previous image from folder
        if (\File::exists($post_data_photo)) { // unlink or remove previous image from folder
            unlink($post_data_photo);
        }
    }

    public function delete_existing_and_upload_file($field, $save_title='', $path=null){
        if(request()->hasfile($field)) 
        { 
          $this->deleteImage($field); // if older image exists

          $filename = $this->uploadFile($field, $save_title, $path);
          return $filename;
        }
        return $this->$field;

    }



    public static function ajaxUploadFile($field_instance = null, $save_title='', $path = 'uploads/media_srcs/', $class=""){
        //dd($field_name);
        if($field_instance){
            // dd($field_instance);
            $extension = $field_instance->getClientOriginalExtension(); // getting image extension
            $filename = remove_space_dots_replace_underscore($save_title) . '_' . time() . mt_rand(1000, 9999) . '.'.$extension;
            $field_instance->move(public_path($path), $filename);
            $output = array(
             'success' => 'Image uploaded successfully',
             'image'  => '<img src="/'.$path.'/'.$filename.'" class="'.$class.'" />',
             'uploaded_name' => $filename
            );
            return $output;
        }
        return null;
    }
}


