<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public $lig_id;
	
	public function sql_lig_name($lig_id = false) {
		return $lig_name = $this->sql()->tableHefz_ligs()->whereId($lig_id)->limit(1)->select()->assoc("name");

	}
	public function sql_mrhefz($lig_id = false) {
		
		$this->lig_id = $lig_id;

		$lig_name = $this->sql()->tableHefz_ligs()->whereId($lig_id)->limit(1)->select()->assoc("name");

		$teams = $this->sql()->tableHefz_teams()->whereLig_id($lig_id)->select()->allAssoc();

		$result = array();

		foreach ($teams as $key => $value) {

			$teamusers = $this->sql()->tableHefz_teamuser()->whereId($value['id'])->select()->allAssoc();
			foreach ($teamusers as $teamusersid => $v) {

				$usersid = $v['users_id'];
				
				$sum = $this->sql()->tableHefz_race_result()->whereHefz_teamuser_id($v['id'])->select()->allAssoc();
				$sum_result = 0;
				foreach ($sum as $index => $s) {
					$sum_result = $sum_result + intval($s['value']);
				}
				$result[$usersid]['sum'] = $sum_result;
				$result[$usersid]['team'] = $value['name'];
				
			}

		}

		$return = array();
		$ar1 = array();
		// $ar2 = array();
		$i = 0;
		foreach ($result as $key => $value) {
			// $return[$i]['ligname'] = $lig_name;
			$return[$i]['team'] = $value['team'];
			$return[$i]['name'] = $this->sql(".userNameFamily.name", $key);
			$return[$i]['family'] = $this->sql(".userNameFamily.family", $key);
			$return[$i]['sum'] = $value['sum'];

			$ar1[] = $value['sum'];
			$i++;
		}
		array_multisort($ar1,SORT_DESC,$return);
		return $return;
		var_dump($ar1,$return);
		exit();
		
		var_dump($return);		
		
	}

}
?>