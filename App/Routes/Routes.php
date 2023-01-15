<?php
namespace App\Routes;
session_start();
use App\Controllers\Admin\AdminPanelController;
use App\Controllers\Admin\AdminUsersController;
use App\Controllers\UserController;
use System\Routes\SystemRoutes;

$route = new SystemRoutes();

$route -> get('/', function($id = null){
    // dump(env('VIEW_PATH'));
    view('home', ['data' => 2]);
});
$route -> get('/user/{id}', [UserController::class,'view']);
$route -> post('/user/{id}/tel', function($name){
    return view('home', ['data' => 2]);
    return sendApiData(['status' => $name]);
}); 



/* ADMIN PANEL PATH. DON'T EDIT*/
$route -> get('/admin', [AdminPanelController::class,'index']);
$route -> get('/admin/login', function(){if(isset($_SESSION['id'])) return header('Location: /admin'); view('admin/login');} );
$route -> get('/admin/signup', function(){	if(isset($_SESSION['id'])) return header('Location: /admin'); view('admin/signup');} );
$route -> get('/admin/resetpassword', function(){ view('admin/pass-reset');} );
$route -> post('/admin/view', [AdminPanelController::class,'view']);
$route -> post('/admin/crud', [AdminPanelController::class,'crud']);
$route -> post('/admin/login', [AdminUsersController::class, 'login']);
$route -> post('/admin/signup', [AdminUsersController::class, 'signup']);
$route -> post('/admin/resetpassword', [AdminUsersController::class, 'resetpassword']);
$route -> get('/admin/logout', [AdminUsersController::class, 'logout']);