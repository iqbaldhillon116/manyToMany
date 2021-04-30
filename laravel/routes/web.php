<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create' , function(){

    $user = User::find(1);//find the user

    $role = new Role(['name'=>'Administrator']);//instantiate the role with administrator

    $user->roles()->save($role);//save the vale in roles table and pivot table with respect to the user

});

Route::get('/read',function(){

    $user = User::findOrFail(1);//finding the user
    
    // dd($user->roles);
    
    foreach($user->roles as $role){
        
        // dd($role);

        return $role->name;

    }
});

Route::get('/update',function(){

    $user = User::findOrFail(1);

    if($user->has('roles')){//this will check if we have defined any relational function roles inside user model

        foreach($user->roles as $role){

            if($role->name=="Administrator"){

                $role->name = 'administrator';

                $role->save();

            }

        }

    }

});

Route::get('/delete',function(){

    $user = User::findOrFail(1);//finding user

    foreach($user->roles as $role){//getting the roles associated with it from roles table

        $role->whereId(3)->delete();//delete role from role table not from pivot table 
    }

});

Route::get('/attach',function(){

    $user = User::findOrFail(1);

    $user->roles()->attach(4);

});

Route::get('/detach',function(){

    $user = User::findOrFail(1);

    $user->roles()->detach(4);//this will remove all rows from pivot table wiht user id =1 and role id = 4

});

Route::get('/sync',function(){

    $user = User::findOrFail(1);

    $user->roles()->sync([1,2,3,4,5,6]);//this will remove all rows from pivot table wiht user id =1 and role id = 4

});