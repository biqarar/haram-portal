<?php
namespace sql;
class get_price {
	public $id           = array('type'=> 'int@10', 'autoI');
	public $price_id     = array('type'=> 'int@10');
	public $value        = array('type'=> 'int@10');
	public $date_receive = array('type'=> 'int@10');
	public $receiver     = array('type'=> 'int@10');
	public $type         = array('type'=> 'enum@pose,bank,cash!pose');
	public $card         = array('type'=> 'int@10');
	public $transactions = array('type'=> 'int@10');
}
?>