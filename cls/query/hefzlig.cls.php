<?php
class query_hefzlig_cls extends query_cls
{
	public function race_result($race_id = false) {
		
		//-----------------------------------------------
		$query = $this->sql()->tableHefz_race_result()->whereHefz_race_id($race_id);
		$query->joinHefz_teamuser()->whereId("#hefz_race_result.hefz_teamuser_id");
		$query->joinPerson()->whereUsers_id("#hefz_teamuser.users_id")->fieldName("personname")->fieldFamily("family");
		$query = $query->select()->allAssoc();


		//-----------------------------------------------
		$team_count_query = $this->sql()->tableHefz_race()->whereId($race_id)->select()->assoc();
		
		$manfi = array();
		$manfi[$team_count_query['hefz_team_id_1']] = $team_count_query['manfi1']; 
		$manfi[$team_count_query['hefz_team_id_2']] = $team_count_query['manfi2']; 

		
		$team_count = array();
		$team_count[$team_count_query['hefz_team_id_1']] = 
			$this->sql()->tableHefz_teamuser()->whereHefz_team_id($team_count_query['hefz_team_id_1'])->select()->num();
		
		$team_count[$team_count_query['hefz_team_id_2']] = 
			$this->sql()->tableHefz_teamuser()->whereHefz_team_id($team_count_query['hefz_team_id_2'])->select()->num();
				

		//-----------------------------------------------
		$result = array();

		foreach ($query as $key => $value) {
			$result[$value['hefz_team_id']]['teamid'] = $value['hefz_team_id'];

			if(isset($result[$value['hefz_team_id']]['value'])){
				$result[$value['hefz_team_id']]['value'] += intval($value['value']);
			}else{
				$result[$value['hefz_team_id']]['value'] = intval($value['value']);
			}
			
			
		}

		foreach ($result as $key => $value) {
			$result[$key]['value'] = $result[$key]['value'] - $manfi[$key];
			$result[$key]['manfi'] = $manfi[$key];
		}
		

		//-----------------------------------------------
		foreach ($result as $key => $value) {
			$d = (intval($value['value']) * 100) / (5 * 2 * intval($team_count[$key]));
			// echo "dddddd ============" . $d . "\n";
			switch ($d) {
				case ($d < 30) :
					$result[$key]['rate'] = 0;
					break;
				case ($d >= 80 and $d < 90) :
					$result[$key]['rate'] = 1;
					break;
				case ($d >= 90 and $d < 100) :
					$result[$key]['rate'] = 2;
					break;
				case ($d == 100) :
					$result[$key]['rate'] = 3;
					break;
				default :
					$result[$key]['rate'] = 0;
					break;
				
			}
			$result[$key]['main_result'] = $d;
			$result[$key]['result'] =" ٪ " . $d;
		}
		

		//-----------------------------------------------
		$rate = array();
		$id = 0;
		foreach ($result as $key => $value) {
			// print_r($result);
			$rate[$id]['rate'] = $result[$key]['rate'];
			$rate[$id]['id'] = $key;
			$id++;
		}


		//-----------------------------------------------
		if(isset($rate[0])){
			$this->rate($result);
		}

		//-----------------------------------------------
		return  $result;
		var_dump($result);
		exit();


		
	}

	public function rate(&$result){
		$team = array();
		$team[] = $result[array_keys($result)[0]];
		$team[] = $result[array_keys($result)[1]];

		$r1 = $team[0]['main_result'];
		$r2 = $team[1]['main_result'];
		$s1 = 0;
		$s2 = 0;
		if($r1 == $r2)
		{

			if($r1 >= 30 and $r1 < 90)
			{
				$s1 = 1;
				$s2 = 1;
			}

			if($r1 >= 90 and $r1 < 100)
			{
				$s1 = 2;
				$s2 = 2;
			}

			if($r1 == 100 )
			{
				$s1 = 3;
				$s2 = 3;
			}
		}

		if($r1 < $r2)
		{
			if($r1 < 30 and $r2 > 30)
			{
				$s1 = 0;
				$s2 = 3;
			}
			if($r1 >= 30 and $r1 < 80 )
			{
				$s1 = 0;
				$s2 = 3;
			}
			if($r1 >= 80 and $r1 < 90 )
			{
				$s1 = 1;
				$s2 = 3;
			}
			if($r1 >= 90 and $r1 < 100 )
			{
				$s1 = 2;
				$s2 = 3;
			}
			
		}

		if($r2 < $r1)
		{
			if($r2 < 30 and $r1 > 30)
			{
				$s2 = 0;
				$s1 = 3;
			}
			if($r2 >= 30 and $r2 < 80 )
			{
				$s2 = 0;
				$s1 = 3;
			}
			if($r2 >= 80 and $r2 < 90 )
			{
				$s2 = 1;
				$s1 = 3;
			}
			if($r2 >= 90 and $r2 < 100 )
			{
				$s2 = 2;
				$s1 = 3;
			}
			
		}
		
		$result[array_keys($result)[0]]['rate'] = $s1;
		$result[array_keys($result)[1]]['rate'] = $s2;
	}

}
?>