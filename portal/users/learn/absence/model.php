<?php 
/**
* 
*/
class model extends main_model {

	public function post_api() {

		$dtable = $this->dtable->table("absence")
		->fields('id', 'date', 'type', "id classesid")
		->search_fields("type", "gender")
		
		->query(function($q){
			$q->joinClassification()->whereId("#absence.classification_id")->andUsers_id($this->xuId("usersid"))->fieldClasses_id("classesid");
			$q->joinClasses()->whereId("#classification.classes_id")->fieldStart_time();
		})
		->result(function($r) {
			$r->classesid = '<a class="icoclassesid" href="branch/status=classesid/id='.$r->classesid.'" title="'.gettext('classesid').' '.$r->classesid.'"></a>';
		});
		$this->sql(".dataTable", $dtable);

	}
	public function sql_classification_list($usersid = false) {
		$return = array();
		$return['sum_active'] = 0;
		$return['sum_all'] = 0;
		$return['classes'] = array();
		$sql = $this->sql()->tableClassification()->whereUsers_id($usersid);
		$sql->joinClasses()->whereId("#classification.classes_id");
		$sql->joinPlan()->whereId("#classes.plan_id")->fieldName("planname");
		$sql->joinPlace()->whereId("#classes.place_id")->fieldName("placename");
		$sql->joinPerson()->whereUsers_id("#classes.teacher")->fieldName("teachername")->fieldFamily("teacherfamily");
		$x = $sql->select()->allAssoc();
		
		foreach ($x as $key => $value) {

			$return['sum_all']++;
			// if(empty($x[$key]['date_delete']) || $x[$key]['date_delete'] == ''){
				$return['sum_active']++;

				$return['classes'][$key]['string'] = $x[$key]['planname'] 		. '  ' .
								   _($x[$key]["age_range"]) 		. '  ' . 
								   $x[$key]['placename'] 		. ' ساعت ' .
								   $x[$key]['end_time']			. ' استاد ' .
								   $x[$key]["teachername"] 		. '  ' . 
								   $x[$key]['teacherfamily'];
				$return['classes'][$key]['id'] = $x[$key]["classes_id"];
				// }
								   
		}
		return $return;
	}
}
?>