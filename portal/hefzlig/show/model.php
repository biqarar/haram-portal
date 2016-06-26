<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public $lig_id, $mr = array();
	public $p = 0;

	public function sql_result($lig_id = false) {
	
		$this->lig_id = $lig_id;

		$lig_name = $this->sql()->tableHefz_ligs()->whereId($lig_id)->limit(1)->select()->assoc("name");

		$teams = $this->sql()->tableHefz_teams()->whereLig_id($lig_id)->select()->allAssoc();
		$result = array();
		$j = 0;
		foreach ($teams as $key => $value) {
			// var_dump($value);
			$j++;
			$result[$value['id']]['n'] = $j;
			$result[$value['id']]['ligname'] = $lig_name;
			$result[$value['id']]['name'] = $value['name'];
			$result[$value['id']]['race_count'] = 	$this->sql()->tableHefz_race()
																 ->whereHefz_team_id_1($value['id'])
																 ->orHefz_team_id_2($value['id'])
																 ->select()->num();
			$r = $this->race_win($value['id']);

			$result[$value['id']]['race_win'] = $r['win'];
			$result[$value['id']]['race_ower'] = $r['ower'];
			$result[$value['id']]['race_req'] = $r['req'];
			$result[$value['id']]['average'] = 
				round(floatval($r['average'] / $result[$value['id']]['race_count']),3);
			$result[$value['id']]['race_rate'] = $r['rate'];
			// $result[$value['id']]['more'] = $this->tag("a")->href("lig")->class("icomore")->render();
			$result[$value['id']]['more'] = $value['id'];

		}

		// var_dump($result);
		// foreach ($result as $key => $value) {
			
		// }


		// exit();

		// $r = array();
		foreach ($result as $key => $value) {
			if(!isset($this->mr[$value['race_rate']])){	
				$this->mr[$value['race_rate'] + $this->p]  = $value;
			}else{
				$this->fix($this->mr[$value['race_rate']], $value);
			}
		}

		krsort($this->mr);
		return $this->mr;
		var_dump($this->mr);
		exit();

		var_dump($result);
		
	}

	public function fix($r1 = false , $r2 = false) {
		$race_id = $this->sql()->tableHefz_race()
			->groupOpen()
			->whereHefz_team_id_1($r1['more'])
			->andHefz_team_id_2($r2['more'])
			->groupClose()
			->groupOpen()
			->orHefz_team_id_1($r2['more'])
			->andHefz_team_id_2($r1['more'])
			->groupClose()
			->select();

		if($race_id->num() > 0) {

			$race_id = $race_id->assoc("id");
			$r = $this->sql(".hefzlig.race_result", $race_id);
			if(count($r) < 2) return;
			if($r[$r1['more']]['rate'] == $r[$r2['more']]['rate']){
				$this->p++;
				if($r1['average'] > $r2['average']){
					$this->mr[$r1['race_rate'] + 1] = $r1;
					$this->mr[$r2['race_rate']] = $r2;
				}else{
					$this->mr[$r2['race_rate'] + 1] = $r2;
					$this->mr[$r1['race_rate']] = $r1;
				}
			}elseif($r[$r1['more']]['rate'] > $r[$r2['more']]['rate']){
				$this->p++;
				$this->mr[$r1['race_rate'] + 1] = $r1;
				$this->mr[$r2['race_rate']] = $r2;
			}else{
				$this->p++;
				$this->mr[$r2['race_rate'] + 1] = $r2;
				$this->mr[$r1['race_rate']] = $r1;

			}
		
		}else{
			return;
		}
	}

	public function race_win($team_id = false){

		$race = $this->sql()->tableHefz_race()
							 ->whereHefz_team_id_1($team_id)
							 ->orHefz_team_id_2($team_id)
							 ->select()->allAssoc();
		$return = array();
		$return['win']  = 0;
		$return['ower']	= 0;
		$return['req']  = 0;
		$return['average']  = 0;
		$return['rate']  = 0;

		foreach ($race as $key => $value) {

			$r = $this->sql(".hefzlig.race_result", $value['id']);
			if(count($r) < 2) continue;
			
			$return['average'] = $return['average'] + $r[$team_id]['main_result'];
			$return['rate'] = $return['rate'] + $r[$team_id]['rate'];

			if($r[$team_id]['rate'] == 3) {
			$return['win']++;
			} 

			if($r[$team_id]['rate'] < 3){
				$return['ower']++ ;
			}  

			$t = array();
			$t[] =  $r[array_keys($r)[0]];
			$t[] =  $r[array_keys($r)[1]];

			$r1 = $t[0]['rate'];
			$r2 = $t[1]['rate'];
			if($r1 == $r2) {
				$return['req']++;
			} 
			// var_dump($r,$team_id,  $return);
			
		}
		// var_dump($return);
		return $return;
	}
}
?>