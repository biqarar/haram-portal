<?php
namespace sql;
class price {
	public $id           = array('type'=> 'int@10', 'autoI', 'label' => 'price_id');
	public $users_id     = array('type'=> 'int@10', "label" => "users_id");
	public $date		 = array("type" => "int@8", "label" => "date");
	public $title		 = array('type' => "int@10", "price_title");
	public $card        = array('type'=> 'int@7', "label" => "card");
	public $value        = array('type'=> 'int@7', "label" => "price_value");
	public $pay_type     = array('type'=> 'enum@pos_mellat,pos_melli', "label" => "pay_type");
	public $transactions = array('type'=> 'varchar@255', "label" => "price_transactions");
	public $description  = array('type'=> 'text@' , "label" => "description");
	
	public $foreign = array("title" => "price_change@id!name");
	
	public function id(){
		$this->validate("id");
	}

	public function users_id(){
		$this->validate("id");
	}

	public function date() {
		$this->form("#date")->name("date")->label("date");
		$this->validate()->date()->form->date("date incorect");
	}

	public function title(){
		$this->form("select")->name("title")->id("title")->addClass("select-title notselect")->label("type");
		$this->setChild(function($q){
			// var_dump($q);
		}, function($child, $value){
			$child->label($value['name'])->value($value['id']); 
		});
	}


	public function card(){
		$this->form("text")->name("card")->label("card")->pl("4 رقم آخر شماره کارت");
		$this->validate()->number()->form->number("price card is not valid");
	}

	public function value(){
		$this->form("text")->name("value")->label("مبلغ")->pl("به ریال");
		$this->validate()->price()->form->price("price value is not valid");
	}

	public function pay_type(){
		$this->form("radio")->name("pay_type")->label("pay_type");
		$this->setChild($this->form);
	}

	public function transactions(){
		$this->form("text")->name("transactions")->label("transactions");
		$this->validate()->transactions()->form->transactions("transactions is not valid");
	}

	public function description() {
		$this->form("#text_desc")->name("description");
		$this->validate()->description()->form->description("description must be between 3 and 255 charset");
	}

	
}	
?>