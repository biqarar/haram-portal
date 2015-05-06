 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "price";

		//------------------------------ list of classes
		$price = $this->sql(".list", "price", function ($query) {
			$query->whereUsers_id($this->xuId("usersid"))->andVisible(1);
			$query->joinPrice_change()->whereId("#price.title")->fieldName("changeName")->fieldType("priceChangeType");
			$query->joinPerson()->whereUsers_id("#price.users_id")->fieldName()->fieldFamily();		
		})
		->removeCol("branch_id,title,status,users_id,visible")
		->addColFirst("priceChangeType", "priceChangeType")
		->addColFirst("family", "family")
		->addColFirst("name", "name")
		->addColFirst("id", "id")

		->compile();
		foreach ($price['list'] as $key => $value) {
			$plan_id = $this->sql(".assoc.foreign", "classes", $price['list'][$key]['transactions'] , "plan_id");
			$plan_name = $this->sql(".assoc.foreign", "plan", $plan_id , "name");

			if($value['changeName'] == 'شرکت در کلاس') {
				$price['list'][$key]['transactions'] = $this->tag("a")
					->href("classes/status=detail/id=" . $value['transactions'])
					->class("icoclass")->title("در کلاس استفاده شده است")->render() . " $plan_name  " ;

			}
		}

		$this->data->list = $price;
	}
}
?>