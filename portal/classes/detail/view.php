 <?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = "classes_detail";

		$edit_link = $this->tag("a")
		->href("classes/status=edit/id=%id%")
		->addClass("icoedit")
		->style("margin : 0px !important;")
		->render();

		//------------------------------ list of classes
		$classes_detail = $this->sql(".list", "classes", function ($query) {
			$query->whereId($this->xuId());
		})
		->addColFirst("edit", "edit")
		->select(0, "edit")
		->html($edit_link)
		->compile();

		//------------------------------ convert paln_id , teacher , place id , ... to name of this
		$classes_detail = $this->detailClasses($classes_detail);

		$this->data->list = $classes_detail;
	}
}
?>