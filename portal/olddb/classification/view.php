 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "oldclassification";

		//------------------------------ list of classes
		$oldclassification = $this->sql(".list", "oldclassification", function ($query, $id) {
			$query->whereParvande($id);
		}, $this->xuId());
		$oldclassification->addCol("classes", "classes");
		foreach ($oldclassification->list as $key => $value) {
			$oldclassification->select($key, "classes")->html($this->sql("#oldclasses_detail", $value['oldclasses']));
		}

		$this->data->list = $oldclassification->compile();
	}
}
?>