<?php

namespace App\Models;

use System\Models\SystemModel;

class UserModel extends SystemModel
{
    protected $table = 'students';
    protected $create_at = 'date_creation';
    protected $update_at = 'date_edition';
    // protected $beforeInsert = ['test'];

    public function test($data = []){
        echo 'Called test !';
    }
}