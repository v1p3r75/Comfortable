<?php
namespace System\Library;

use App\Models\Admin\AdminPanelModel;

class Form {

	private $model = null;

    public function __construct($model)
    {
		$this->model = $model;
    }

    public function build(array $details = []): string{
        $dbColumns = $this->model->getAllColumns();
        $form = '';
        $noFields = $this->model-> getIgnoredFields();
        foreach ($dbColumns as $column) {
            if(! in_array($column['Field'], $noFields)){
				$field = $column['Field'];
				$type = $details['form'][$field]['type'] ?? 'text';
				$minSize = $details['form'][$field]['minSize'] ?? '';
				$maxSize = $details['form'][$field]['maxSize'] ?? '';
				$attr = $details['form'][$field]['attributes'] ?? '';
				$placeholder = $details['form'][$field]['placeholder'] ?? $column['Field'];
                $form .= '<div><input type='. $type . ' name ="'. $column['Field'] .'" placeholder="'. ucfirst($placeholder) .'" min="'. $minSize .'" max="'. $maxSize .'"'. $attr .'/></div>';
            }
        }
        return $form;
    }
}