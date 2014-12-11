<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'branch_cash';

		//------------------------------ make chane password form
		$hidden = $this->form("#hidden")->value("branch_cash");
		$table = $this->form("text")->name("table")->label("table");
		$id = $this->form("text")->name("id")->label("id");

		$branch =  $this->form("text")->name("branch")->label("branch");
		$submit = $this->form("#submitadd")->value("add");
		$this->listBranch($branch);	
		
		$branch_cash = array();
		$branch_cash[] = $hidden->compile();
		$branch_cash[] = $table->compile();
		$branch_cash[] = $id->compile();
		$branch_cash[] = $branch->compile();
		$branch_cash[] = $submit->compile();
		
		
		$this->data->branch_cash = $branch_cash;
	}
}
?>