<?php

namespace App;

use App\Traits\ImageTrait;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use Notifiable, ImageTrait;
    use ImageTrait {
        deleteImage as traitDeleteImage;
    }
    use HasRoles;

    public $table = 'users';
    const IMAGE_PATH = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'email_verified_at',
        'image_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'set_password'      => 'boolean',
        'image_path'      => 'string',
    ];

    public static function get_logged_student_id(){
        $student = \App\Models\Student::where('user_id', auth()->user()->id)->first();
        return $student ? $student->id : null;
    }

    public static function get_logged_student(){
        $logged_student_id = self::get_logged_student_id();
        $student = \App\Models\Student::find($logged_student_id);
        return $student ? $student : null;
    }

    public static function get_logged_teacher_id(){
        $teacher = \App\Models\Teacher::where('user_id', auth()->user()->id)->first();
        return $teacher ? $teacher->id : null;
    }

    public static function get_logged_teacher(){
        $logged_teacher_id = self::get_logged_teacher_id();
        $teacher = \App\Models\Teacher::find($logged_teacher_id);
        return $teacher ? $teacher : null;
    }

    public static function is_logged_user_student(){
        if(auth()->user()->hasRole('Student')){
            return true;
        }
        return false;

    }

    public static function is_logged_user_teacher(){
        if(auth()->user()->hasRole('Teacher')){
            return true;
        }
        return false;

    }

    public static function is_student_and_premium(){
        if(self::is_logged_user_student()){
            if(is_logged_student_premium()){
                return true;
            }
        }
        return false;
    }

    public static function own_teacher_id_restriction($teacher_id){
        if(is_logged_user_teacher()){
            if((int) get_logged_teacher()->id !== (int) $teacher_id){
                dd('This Profile is not yours');
            }
        }
    }

    public static function own_student_id_restriction($student_id){
        if(is_logged_user_student()){
            if((int) get_logged_student()->id !== (int) $student_id){
                dd('This Profile is not yours');
            }
        }
    }
    



    /**
     * Validation rules.
     *
     * @var array
     */
    // public static $rules = [
    //     'name'                  => 'required|unique:users,name',
    //     'email'                 => 'required|email|unique:users,email|regex:/^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/',
    //     'phone'                 => 'nullable|numeric|digits:10',
    //     'password'              => 'nullable|min:6',
    // ];

    // public static $messages = [
    //     'phone.digits'     => 'The phone number must be 10 digits long.',
    //     'email.regex'      => 'Please enter valid email.',
    //     'photo.mimes'      => 'The profile image must be a file of type: jpeg, jpg, png.',
    // ];

    // public static $setPasswordRules = [
    //     'user_id'               => 'required',
    //     'password'              => 'min:6',
    // ];

    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
    ];

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

    /**
     * @param $value
     *
     * @return string
     */
    public function getImagePathAttribute($value)
    {
        if (!empty($value)) {
            return $this->imageUrl(self::IMAGE_PATH.DIRECTORY_SEPARATOR.$value);
        }

        return getUserImageInitial($this->id, $this->name);
    }

    /**
     * @return bool
     */
    public function deleteImage()
    {
        $image = $this->getOriginal('image_path');
        if (empty($image)) {
            return true;
        }

        return $this->traitDeleteImage(self::IMAGE_PATH.DIRECTORY_SEPARATOR.$image);
    }
}
