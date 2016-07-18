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

		$teams = $this->sql()->tableHefz_teams()->whereLig_id($lig_id)->groupbyHefz_group_id();

		$teams->joinHefz_group()->whereId("#hefz_teams.hefz_group_id")->fieldName("groupname");

		$teams = $teams->select()->allAssoc();	

		$return = array();
		foreach ($teams as $key => $value) {
			$return[] = $this->team_result($value['hefz_group_id'], $value['groupname']);
		}

		return $return;
		var_dump($return);

		exit();
		
	}

	
	public function team_result($group_id = false, $groupname = false) {

		$teams = $this->sql()->tableHefz_teams()->whereHefz_group_id($group_id)->select()->allAssoc();
		$result = array();
		$ar1 = array();
		$j = 0;
		foreach ($teams as $key => $value) {
	
		
			$race_count = $this->sql()->tableHefz_race()
									->whereType("دوره ای")
									->groupOpen()
									->andHefz_team_id_1($value['id'])
									->orHefz_team_id_2($value['id'])
									->groupClose()
									->select()->num();


			$result[$j]['name'] = $value['name'];
		
			$result[$j]['race_count'] = $race_count;
			
			$r = $this->race_win($value['id'], $race_count);

			$result[$j]['race_win'] = $r['win'];
			$result[$j]['race_ower'] = $r['ower'];
			$result[$j]['race_req'] = $r['req'];
			
			if($race_count == 0) $race_count = 1;

			$result[$j]['average'] = round(floatval($r['average'] / $race_count),3);
			$result[$j]['race_rate'] = $r['rate'];
			$result[$j]['more'] = $this->tag("a")->href("hefzlig/raceteam/id=" . $value['id'])->class("icomore")->render();
			$j++;

			$ar1[] = $r['rate'];
		}
		array_multisort($ar1,SORT_DESC,$result);


		$return = array();
		$return['group_id'] = $group_id;
		$return['groupname'] = $groupname;
		$return['result'] = $result;
		return $return;
		var_dump($return);
		// var_dump($ar1);
		exit();		
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
							 ->groupOpen()
							 ->whereHefz_team_id_1($team_id)
							 ->orHefz_team_id_2($team_id)
							 ->groupClose()
							 ->andType("دوره ای")
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
				if($r1 == 3) { // bord bord
					$return['win']++;
				}else{
					$return['req']++;
				}
			} 
			
		}
		return $return;
	}
}
?>