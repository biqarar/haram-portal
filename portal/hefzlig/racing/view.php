<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public $team1_data, $team2_data, $race_id;

	public function config() {
		
		//------------------------------ globals
	
		$this->race_id = $this->xuId();
		$this->data->raceid = $this->race_id;
		list($this->team1_data, $this->team2_data) = $this->sql("#find_team_id", $this->race_id);

		$this->global->page_title = 'مسابقه بین ' . $this->team1_data['name'] . ' و ' . $this->team2_data['name'];

		$team1 = $this->sql(".list", "hefz_teamuser", function ($query) {
			$query->whereHefz_team_id($this->team1_data['id']);
			$query->joinHefz_race_result()->whereHefz_race_id($this->race_id)->andHefz_teamuser_id($this->team1_data['id']);
			$query->joinPerson()->whereUsers_id("#hefz_teamuser.users_id")->fieldName("personname")->fieldFamily("personfamily");
			// $query->joinHefz_ligs()->whereId("#hefz_teams.lig_id")->fieldName("ligname");
		});
		// var_dump($team1);exit();
		$team1->removeCol("id,hefz_team_id,users_id");
			$team1->addColEnd("race1","تلاوت اول")->select(-1, "race1")->html("<div class='form-element'>
					<input type='text' name='race1' teamusersid='%id%' class='race-mark' raceid='{$this->race_id}' style='width:50px !important' placeholder='تلاوت اول' id='race1'>
					</div>");
		$team1->addColEnd("race2","تلاوت دوم")->select(-1, "race2")->html("<div class='form-element'>
					<input type='text' name='race2'  teamusersid='%id%' class='race-mark' raceid='{$this->race_id}' style='width:50px !important' placeholder='تلاوت دوم' id='race2'>
					</div>");
		$this->data->team1['id'] = $this->team1_data['id'];
		$this->data->team1['name'] = $this->team1_data['name'];
		$this->data->team1['list'] = $team1->compile();




		$team2 = $this->sql(".list", "hefz_teamuser", function ($query) {
			$query->whereHefz_team_id($this->team2_data['id']);
			$query->joinPerson()->whereUsers_id("#hefz_teamuser.users_id")->fieldName("personname")->fieldFamily("personfamily");
			// $query->joinHefz_ligs()->whereId("#hefz_teams.lig_id")->fieldName("ligname");
		});
		// var_dump($team2);exit();
		$team2->removeCol("id,hefz_team_id,users_id");
			$team2->addColEnd("race1","تلاوت اول")->select(-1, "race1")->html("<div class='form-element'>
					<input type='text' name='race1' teamusersid='%id%' class='race-mark' raceid='{$this->race_id}' style='width:50px !important' placeholder='تلاوت اول' id='race1'>
					</div>");
		$team2->addColEnd("race2","تلاوت دوم")->select(-1, "race2")->html("<div class='form-element'>
					<input type='text' name='race2' teamusersid='%id%' class='race-mark' raceid='{$this->race_id}' style='width:50px !important' placeholder='تلاوت دوم' id='race2'>
					</div>");
		$this->data->team2['id'] =$this->team2_data['id'];
		$this->data->team2['name'] =$this->team2_data['name'];
		$this->data->team2['list'] = $team2->compile();

		

		$result = $this->sql(".hefzlig.race_result", $this->race_id);

		$this->data->result1 = isset($result[$this->team1_data['id']]) ? $result[$this->team1_data['id']] : 0;
		$this->data->result2 = isset($result[$this->team2_data['id']]) ? $result[$this->team2_data['id']] : 0;
		
		

	}



}
?>