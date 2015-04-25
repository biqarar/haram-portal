 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "price";

		//------------------------------ list of classes
		$price = $this->sql(".list", "userprice", function ($query) {
			$query->whereUsers_id($this->xuId("usersid"));
			$query->joinPrice_change()->whereId("#userprice.title")->fieldName("changeName");
			$query->joinPerson()->whereUsers_id("#userprice.users_id")->fieldName()->fieldFamily();
			// $query->joinPlan()->whereId("#userprice.plan_id")->and("##userprice.plan_id", "is", "#null")->fieldName("planname");		
		})
		->addColFirst("family", "family")
		->addColFirst("name", "name")
		->removeCol("branch_id,title,id,users_id")
		->compile();

		foreach ($price['list'] as $key => $value) {
			if($value['classes_id'] != "") {
				$price['list'][$key]['classes_id'] = $this->tag("a")
					->href("classes/status=detail/id=" . $value['classes_id'])
					->title("در کلاس استفاده شده است")
					->class("icoclass")->render();
			}else{
				$price['list'][$key]['classes_id'] = $this->tag("a")
					->disable("disable")
					->title("در هیچ کلاسی استفاده نشده است")
					->class("icoclass")->style("opacity: 0.3;")->render();
			}

			if($value['plan_id'] != "") {
				$price['list'][$key]['plan_id'] = $this->sql(".assoc.foreign", "plan", $value['plan_id'], "name");
			}
		}

		$this->data->list = $price;
	}

}
?>