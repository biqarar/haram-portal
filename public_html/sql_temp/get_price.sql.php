<?php
namespace sql;
class get_price 
{
	public $id = array('type' => 'int@10', 'label' => 'id');
	public $price_id = array('type' => 'int@10', 'label' => 'price_id');
	public $value = array('type' => 'int@7', 'label' => 'value');
	public $date_receive = array('type' => 'int@8', 'label' => 'date_receive');
	public $receiver = array('type' => 'int@10', 'label' => 'receiver');
	public $type = array('type' => 'enum@pose,bank,cash!pose', 'label' => 'type');
	public $card = array('type' => 'int@16', 'label' => 'card');
	public $transactions = array('type' => 'int@32', 'label' => 'transactions');


	//------------------------------------------------------------------ id - primary key
	public function id() {$this->validate("id");}

	//------------------------------------------------------------------ id - foreign key
	public function price_id() 
	{
		$this->validate("id");
	}
	public function value() 
	{
		
	}
	public function date_receive() 
	{
		
	}
	public function receiver() 
	{
		
	}
	public function type() 
	{
		
	}
	public function card() 
	{
		
	}
	public function transactions() 
	{
		
	}
}
?>