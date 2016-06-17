<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_insertmanfiapi(){
		$teamid= $this->xuId("teamid");
		$raceid = $this->xuId("raceid");
		$type = $this->xuId("type");
		$manfi = $this->sql()->tableHefz_race()->whereId($raceid)->select()->assoc();
		
		if($teamid == $manfi['hefz_team_id_1']){
			$hefz_team_id = "hefz_team_id_1";
			$field = "manfi1";
		}elseif($teamid == $manfi['hefz_team_id_2']){
			$hefz_team_id = "hefz_team_id_2";
			$field = "manfi2";
		}else{
			debug_lib::fatal("خدا در ثبت نمره منفی");
		}

		$value = intval($manfi[$field]);

		if($type == "up") $value++;
		if($type == "down") $value--;

		if($value >= 0) {
			$field = "set" . ucfirst($field);
			$set = $this->sql()->tableHefz_race()->whereId($raceid)->$field($value)->update();
			
		}
		

		$this->commit(function(){
			debug_lib::true("ثبت امتیاز  منفی انجام شد");
		});
		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت امتیاز منفی");
		});
		
	}

	public function post_resultapi(){
		$raceid = $this->xuId("raceid");
		debug_lib::msg("result", $this->sql(".hefzlig.race_result", $raceid));
	}

	public function post_insertapi(){
		
		$teamuserid= $this->xuId("teamuserid");
		$raceid = $this->xuId("raceid");
		$value = $this->xuId("value");
		$type = $this->xuId("type");
		if($type == "race1"){
			$type = "تلاوت اول";
		}elseif($type== "race2"){
			$type = "تلاوت دوم";
		}else{
			debug_lib::fatal("خطا در نوع تلاوت");
		}
		$check = $this->sql()->tableHefz_race_result()
			->whereHefz_race_id($raceid)
			->andHefz_teamuser_id($teamuserid)
			->andType($type);

		if($check->select()->num() == 0){

			$query = $this->sql()->tableHefz_race_result()
				->setHefz_race_id($raceid)
				->setHefz_teamuser_id($teamuserid)
				->setType($type)
				->setValue($value)
				->insert();

		}else{
			$check = $check->setValue($value)->update();
			// var_dump($check->string());
		}
			// var_dump($query->string());exit();
		$this->commit(function(){
			debug_lib::true("ثبت امتیاز  مسابقه انجام شد");
		});
		$this->rollback(function(){
			debug_lib::fatal("خطا در ثبت امتیاز مسابقه");
		});
	}

	public function sql_find_team_id ($race_id = false ){
		$return = $this->sql()->tableHefz_race()->whereId($race_id)->limit(1)->select()->assoc();
		$team1 = $this->sql()->tableHefz_teams()->whereId($return['hefz_team_id_1'])->limit(1)->select()->assoc("name");
		$team2 = $this->sql()->tableHefz_teams()->whereId($return['hefz_team_id_2'])->limit(1)->select()->assoc("name");
		return array(
			array("id" => $return['hefz_team_id_1'], "name" => $team1),
			array("id" => $return['hefz_team_id_2'], "name" => $team2)
			);

	}

}
?>