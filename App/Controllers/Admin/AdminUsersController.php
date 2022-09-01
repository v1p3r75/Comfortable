<?php

namespace App\Controllers\Admin;

use \App\Controllers\Controller;
use App\Models\Admin\AdminUsersModel;

class AdminUsersController extends Controller
{
	private $model = null;
	private $tableSql = "CREATE TABLE `cf_xxx_users` (`id` int(11) NOT NULL,`username` varchar(255) CHARACTER SET utf8 NOT NULL,`email` int(255) NOT NULL,`role` tinyint(1) NOT NULL DEFAULT '0',`password` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `cf_xxx_users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `cf_xxx_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
";

	public function __construct(){
		parent::__construct();
		$this->model = new AdminUsersModel();
	}

	public function createUsersTable(){
		return $this->model->builder($this->tableSql);
	}

	public function signup(){

		$model = new AdminUsersModel();
		$data = $this->request->fromPost();
		$image = $_FILES['image'];
		if(empty($data['username']) || empty($data['email']) || empty($data['password'])){
			$response = [
				'status' => 400,
				'message' => 'All Fields are required'
			];
		}else {
			try {
				if(move_uploaded_file($image['tmp_name'], env('ADMINS_IMG') . $image['name'])){
					$data['image'] = $image['name'];
				}
				$model -> insert($data);
				$response = [
					'status' => 200,
					'message' => 'Registration was successful. You can login now',
				];
			}catch (\Exception $e){
				$response = [
					'status' => 400,
					'message' => $e -> getMessage()
				];
			}
		}
		return $this-> respond ->json($response);
	}

	public function login(){
		$model = new AdminUsersModel();
		$data = $this->request->fromPost();
		if(empty($data['email']) || empty($data['password'])){
			$response = [
				'status' => 400,
				'message' => 'All Fields are required'
			];
		}else {
			$db_verify = $model->builder("SELECT * FROM ". $model -> getModel() ." WHERE email = '". secure($data['email']) . "'");
			$db_verify->execute();
			$db_data = $db_verify -> fetch();
			if(! $db_data ){
				$response = [
					'status' => 400,
					'message' => 'Unknown User !'
				];
			}else{
				if(! password_verify($data['password'], $db_data['password'])){
					$response = [
						'status' => 400,
						'message' => 'Incorrect Password !'
					];
				}else{
					unset($db_data['password']);
					$this->session::setArray($db_data);
					$response = [
						'status' => 201,
						'message' => 'Login',
					];
				}
			}
		}
		return $this-> respond ->json($response);
	}

	public function logout(){
		if(session_destroy()){
			$this->request->redirectTo('/admin/login');
		}
	
	}
}