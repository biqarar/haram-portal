<?php
class query_edit_cls extends query_cls
{
	public function config($table = false, $id = false, $form = false)	{
		$id = intval($id);

		$option = $this->query($table, $id);  
		foreach ($form as $key => $value) {
			// var_dump($key);
			// exit();
			if(isset($option[$key])){
				$oForm = $form->$key;
				if($oForm->attr['type'] == "radio" || $oForm->attr['type'] == "select" || $oForm->attr['type'] == "checkbox") {
					foreach ($oForm->child as $k => $v) {
						if($v->attr["value"] == $option[$key]){

							if ($oForm->attr['type'] == "select"){
								$form->$key->child($k)->selected("selected");
								// $oForm->child($k)->selected("selected");
								// $v->selected("selected");
							}else{
								$v->checked("checked");
							}
						// var_dump($k,$key, "-------" );
						}
					}
				}else{
					$oForm->value($option[$key]);
				}
			}
		}
	}

	public function query($table = false, $id = false) {
		$table = "table".ucfirst($table);
		return $this->sql()->$table()->whereId($id)->select()->assoc();
	}
}
?>