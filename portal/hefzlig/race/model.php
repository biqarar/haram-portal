<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class model extends main_model {

	public function post_listapi() {

	$dtable = $this->dtable->table("hefz_race")
		->fields(
			'id', 
			'ligname', 
			'team1',
			'hefz_team_id_2 team2',
			'type',
			'name',
			'id result',
			'id edit',
			'id race')
		->search_fields(
			'ligname hefz_ligs.name',
			'team1 hefz_teams.name',
			'hefz_team_id_2',
			'type',
			'name hefz_race.name')
		->query(function($q){
			
			$q->joinHefz_teams()->whereId("#hefz_race.hefz_team_id_1")->fieldName("team1");
			$q->joinHefz_ligs()->whereId("#hefz_teams.lig_id")->fieldId("lig_id")->fieldName("ligname");
			$q->groupOpen();
			foreach ($this->branch() as $key => $value) {
					if($key == 0){
						$q->condition("and", "hefz_ligs.branch_id","=",$value);
					}else{
						$q->condition("or","hefz_ligs.branch_id","=",$value);
					}
				}
			$q->groupClose();
			// echo ($q->select()->string());exit();
		})
		->search_result(function($result){
				$vsearch = $_POST['search']['value'];
			$vsearch = str_replace(" ", "_", $vsearch);
			$result->groupOpen();
			$result->condition("and", "hefz_ligs.name", "LIKE", "'%$vsearch%'");
			$result->condition("or", "hefz_teams.name", "LIKE", "'%$vsearch%'");
			$result->condition("or", "hefz_race.type", "LIKE", "'%$vsearch%'");
			$result->condition("or", "hefz_race.name", "LIKE", "'%$vsearch%'");
			$result->groupClose();
			
			})
		->result(function($r) {
			$r->team2 = $this->find_team_name($r->team2);
			$r->edit = '<a class="icoedit" href="hefzlig/race/status=edit/id='.$r->edit.'" title="'.gettext('edit').' '.$r->edit.'"></a>';

			$r->result = $this->result($r->result);
			$r->race = $this->tag("a")->href("hefzlig/race/status=racing/id=". $r->race)->addClass("icoallusers")->render();


		});
		$this->sql(".dataTable", $dtable);
	}

	public function result($race_id = false) {
		$result = $this->sql(".hefzlig.race_result",$race_id);
		$all = array();
		foreach ($result as $key => $value) {
			$all[] = $value;
		}
		return $all[0]["main_result"] . "  -  " . $all[1]['main_result'];
	}

	public function find_team_name($team_id = false) {
		return $this->sql()->tableHefz_teams()->whereId($team_id)->limit(1)->select()->assoc("name");
	}

	public function makeQuery() {

		$x = $this->sql(".branch.hefz_teams", post::hefz_team_id_1());
		$y = $this->sql(".branch.hefz_teams", post::hefz_team_id_2());

		if($x != $y) {
			debug_lib::fatal("خطا در تطابق شناسه شعبه دو تیم");
		}

		if(post::hefz_team_id_1() == post::hefz_team_id_2()) {
			debug_lib::fatal("تیم اول و دوم نباید هم نام باشند");
		}

		
		return $this->sql()->tableHefz_race()
			->setHefz_team_id_1(post::hefz_team_id_1())
			->setHefz_team_id_2(post::hefz_team_id_2())
			->setName(post::name())
			// ->setPlace(post::place())
			->setType(post::type());

	}


	public function post_add_hefz_race() {


		//------------------------------ insert race
		$sql = $this->makeQuery()->insert()->LAST_INSERT_ID();

		//------------------------------ commit code
		$this->commit(function($id = false) {
			debug_lib::true("<a href='hefzlig/race/status=racing/id=$id' target='_blank' style='text-decoration: none; color:white; cursor: pointer;'><div style='width: 70px;background: #0C706F;border-radius: 7px;padding: 25px 50px 25px 50px !important;text-align: center;display: inline-block;'>شروع مسابقه</div></a><br>");
		}, $sql);

		//------------------------------ rollback code
		$this->rollback(function() {
			debug_lib::fatal("[[insert race failed]]");
		});
	}

	public function post_edit_hefz_race() {
		//------------------------------ update race
		$sql = $this->makeQuery()->whereId($this->xuId())->update();
		
		//------------------------------ commit code
		$this->commit(function() {
			debug_lib::true("[[update race successful]]");
		});

		//------------------------------ update code
		$this->rollback(function() {
			debug_lib::fatal("[[update race failed]]");
		});
	}


}
?>