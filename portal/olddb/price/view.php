 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "oldprice";

		//------------------------------ list of classes
		$oldprice = $this->sql(".list", "oldprice", function ($query, $id) {
			$query->whereParvande($id);
		}, $this->xuId());

		$oldprice->removeCol("code,description1,valueback,branch,date_erja,erja_status,date_o");

		// $oldprice->addCol("add","انتقال به دوره جدید");
		// $oldprice->select(-1, "add")->html($this->tag("a")->class("icodadd")->href("%id%")->render());
		// var_dump($oldprice->compile());exit();
		
		$this->data->list = $oldprice->compile();
	}
}
?>