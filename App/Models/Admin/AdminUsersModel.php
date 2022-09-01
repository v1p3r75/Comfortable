<?php

namespace App\Models\Admin;

use System\Models\SystemModel;

class AdminUsersModel extends SystemModel
{
	protected $table = 'cf_xxx_users';

	protected $beforeInsert = ['securePassword'];

	protected function securePassword($data){
		if(! isset($data['password'])) return $data;
		$data['password'] = password_hash( $data['password'], PASSWORD_DEFAULT);
		return $data;
	}
}