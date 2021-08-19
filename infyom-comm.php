<?
php artisan infyom:scaffold User --fromTable --tableName=users --datatables=true --paginate=10 --ignoreFields=email_verified_at,remember_token


Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'UserController', ["as" => 'admin']);
});
