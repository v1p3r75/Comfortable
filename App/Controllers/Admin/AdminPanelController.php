<?php
namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Admin\AdminPanelModel;
use System\Database\DatabaseQuery;
use System\Library\Form;

class AdminPanelController extends Controller {

    private $db = null;

	private $currentModel = null;

    public function index(){

		if(! $this->session->get('id')){
			return $this->request->redirectTo('/admin/login');
		}
		
        return view('admin/index');
    }

    public function view(){
		include_once ('AllModelInfo.php');
		$this->db = new DatabaseQuery();
		$this->currentModel = new AdminPanelModel();
		$page = $this->request->fromPost('page');
        $data = [];
        $columns = [];
        $form = [];
        
        if($page === 'tables'){
			// After : set hidden tables
			// $hiddenTables = $tabesInfo['hiddenTables'] ?? [];
            $data = $this->db -> getAllTables();
        }else if(preg_match('#^view-table-#', $page, $matches)){
            $table = substr($page, 11);
			$currentModelInfo = [];

			if(key_exists($table, $modelsData)){
				$currentModelInfo = $modelsData[$table];
				$this->setProps($this->currentModel, $table, $currentModelInfo);
			}else{ $this->currentModel -> setModel($table); }
            $columns = $this->currentModel -> getAllColumns();
            $data = $this->currentModel -> findAll();

            // Build Form template
            $form =  new Form($this->currentModel);
            $form = $form -> build($currentModelInfo);

            $page = 'view-table';

        }else if($page === 'profile'){
			$data = $_SESSION;
		}
        return view('/admin/pages/admin-'. $page, ['columns' => $columns, 'data' => $data, 'form' => $form, 'primaryKey' => $this->currentModel->getPrimaryKey()]);
    }

	private function setProps($model, $table, $data){
		$model -> setModel($table);
		$model -> primaryKey = $data['primaryKey'] ?? 'id';
		$model -> create_at = $data['create_at'] ?? null;
		$model -> update_at = $data['update_at'] ?? null;
		$model -> beforeInsert = $data['beforeInsert'] ?? null;
		$model -> beforeUpdate = $data['beforeUpdate'] ?? null;
		$model -> ignoredFields = $data['ignoredFields'] ?? [];
	}

    public function crud(){
		$this->currentModel = new AdminPanelModel();
		include_once ('AllModelInfo.php');
		$modelName = $this->request->fromPost('cf-xxx-model');
		$currentModelInfo = [];
		if(key_exists($modelName, $modelsData)){
			$currentModelInfo = $modelsData[$modelName];
			$this->setProps($this->currentModel, $modelName, $currentModelInfo);
		}else{ $this->currentModel -> setModel($modelName); }

        $type = $this->request->fromPost('type') ?? '';

		$response = [];
		if($type == 'add'){

			unset($_POST['cf-xxx-model'], $_POST['type']);
			$data = $this->request->fromPost();
			try {
				$this->currentModel -> insert($data);
				$response = [ 'status' => 200, 'message' => 'Registration was successful',];
			}catch (\Exception $e){
				$response = [ 'status' => 400, 'message' => $e -> getMessage()];
			}

		}else if($type == 'update'){

			$id = $this->request->fromPost('cf-xxx-id');
			unset($_POST['cf-xxx-model'], $_POST['type'], $_POST['cf-xxx-id']);
			$data = $this->request->fromPost();
			try {
				$response = [ 'status' => 200, 'message' => 'Update successfully', 'return' => $this->currentModel -> update($id, $data),];

			}catch (\Exception $e){

				$response = [ 'status' => 400, 'message' => $e -> getMessage()];
			}

		}else if($type == 'del'){
			unset($_POST['cf-xxx-model'], $_POST['type']);
			$data = $this->request->fromPost();
			try {
				$this->currentModel -> delete($data['cf-xxx-id']);
				$response = [ 'status' => 200, 'message' => 'Delete successfully',];

			}catch (\Exception $e){

				$response = [ 'status' => 400, 'message' => $e -> getMessage() ];
			}
		}
		return $this -> respond -> json($response);
	}
}