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
			$query->whereUsers_id($this->xuId("usersid"));
			$query->joinPrice_change()->whereId("#price.title")->fieldName("changeName");
			$query->joinPerson()->whereUsers_id("#price.users_id")->fieldName()->fieldFamily();		
		})
		->addColFirst("family", "family")
		->addColFirst("name", "name")
		->removeCol("branch_id,title,id,users_id")
		->compile();
		foreach ($price['list'] as $key => $value) {
			if($value['changeName'] == 'شرکت در کلاس') {
				$price['list'][$key]['transactions'] = $this->tag("a")
					->href("classes/status=detail/id=" . $value['transactions'])
					->vtext("نمایش اطلاعات کلاس" .$value['transactions'] )->render();
			}
		}

		$this->data->list = $price;
	}
}
?>