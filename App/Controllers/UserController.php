<?php
namespace App\Controllers;

use App\Models\UserModel;

class UserController extends Controller {

    public function view(){
		
        $model = new UserModel();
        $data = [
            'names' => 'Jack Boer',
            'email' => 'jack@fr.fr',
            'num' => '34533535'
        ];
        $model ->insert($data);
//		return $this->request->redirectTo('/home');
		return view('home', ['data' => $data]);
    }

    public function test(){
        $data = ['s' =>2, 'm' => 5];
        return $this->respond->json(['data' => $this->request->getUrl('string')]);
//        dump($this->fromPost("id"));
    }
}