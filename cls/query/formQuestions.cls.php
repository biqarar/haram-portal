<?php
class query_formQuestions_cls extends query_cls
{
	public function config($formid = false){
		$form = new forms_lib;
		$form_questions =  $this->form_questions($formid);
		$f[] = array();
		foreach ($form_questions as $key => $value) {
			$type = $this->type($value['answer_type'] , $value['answer_value']);
			$f[$key] = $form->make($type['type'])->name("Q" . $value['id'])->label($value['string'])->pl($value['string']);
			if($type['type'] == "select") {
				foreach ($type['value'] as $k => $child) {
					$f[$key]->child()->name($child)->label($child);
				}
			}
		}
		return $f;
		// $return = array();
		// foreach ($f as $key => $value) {
		// 	$return[] = $f[$key]->compile();
		// }
		// return $return;
	}

	public function form_questions($formid = false) {
		$questions_list =  $this->sql()
				->tableForm_group_item()
				->whereForm_group_id($formid)
				->select()->allAssoc();
				
		$allQuestions = array();
		foreach ($questions_list as $key => $value) {
			$allQuestions[] = $this->sql()
				->tableForm_questions()
				->whereId($value['form_questions_id'])
				->limit(1)->select()->assoc();
		}
		return $allQuestions;
	}

	public function type($type , $value) {
		$return = array();
		switch ($type) {
			case 'string':
				if(intval($value) <= 32) {
					$return['type'] = 'text';
				}else{
					$return['type'] = 'textarea';
				}
				$return['value'] = $value;
				break;
			case 'enum':
			case 'set':
				if(preg_match("/\,|\،/", $value)) {
					$return['value'] = preg_split("/\,|\،/", $value);
					if($type == 'set') {
						$return['type'] = (count($return['value']) <= 2 ) ? "checkbox" : "combobox";
					}else{
						$return['type'] = (count($return['value']) <= 2 ) ? "radio" : "select";
					}
				}else{
					$return['type'] = 'select';
					$return['value'] = $value;
				}
				break;
			case 'bolean':
				$return['type'] = 'checkbox';
				$return['value'] = '1'; // yes or no 

			case 'table':
				$return['type'] = 'table';
				$return['value'] = preg_split("/\@T@/", $value);

			default:
				$return['type'] = "text";
				$return['value'] = $value;
				break;
		}
		return $return;
	}
}
?>