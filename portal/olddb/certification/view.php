 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "certification";

		//------------------- check branch
		$this->sql(".branch.olddb", "oldcertification", $this->xuId());
		
		//------------------------------ list of classes
		$certification = $this->sql(".list", "oldcertification", function ($query, $id) {
			$query->whereParvande($id);
		}, $this->xuId());

		$certification->removeCol("name,family,father,shsh,nationalcod,id,branch,sadere,tavalod");
		$this->data->list = $certification->compile();
	}
}
?>