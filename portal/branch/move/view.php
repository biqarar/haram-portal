<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {

	public function config() {
		//------------------------------ globals
		$this->global->page_title = 'branch move';

		//------------------------------ make chane password form
		$hidden = $this->form("#hidden")->value("branch_move");
		$username = $this->form("text")->name("username")->label("username");
		$id = $this->form("text")->name("old_branch")->label("شعبه فعلی");
		$branch =  $this->form("text")->name("new_branch")->label("شعبه جدید");
		$submit = $this->form("#submitedit")->value("edit");

		// $this->listBranch($branch);	
		//------------------------------ list of branch

		$branch_cash = array();
		$branch_cash[] = $hidden->compile();
		$branch_cash[] = $username->compile();
		$branch_cash[] = $id->compile();
		$branch_cash[] = $branch->compile();
		$branch_cash[] = $submit->compile();
		
		// $this->listBranch($branch_cash);
		
		$this->data->branch_cash = $branch_cash;
	}
}
?>