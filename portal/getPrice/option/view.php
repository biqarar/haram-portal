<?php
/**
 * @author Reza Mohiti <rm.biqarar@gmail.com>
 */
class view extends main_view {
	public function config() {
		$this->global->title = "اقساط شهریه";
		$type = $this->sql("enum", "getprice", "type");
		$p= $this->form('@getpriceadd', $type);
	}
}

class forms extends forms_lib{
	function getpriceadd($type = false){
		$this->input = $this->make("#hidden")->value("getprice_add");
		$this->value = $this->make("text")->name("value")->label("مقدار دریافتی");
		$this->date_recive = $this->make("text")->name("date_recive")->label("تاریخ دریافت");
		$this->reciver = $this->make("text")->name("reciver")->label("دریافت کننده");
		$this->type = $this->make("select")->label("نوع دریافت");
		$this->type->enum("get_price", "type");
		$this->card = $this->make("text")->name("card")->label("شماره کارت");
		$this->transactions = $this->make("text")->name("transactions")->label("شماره تراکنش");
		$this->submit = $this->make("#submit")->value("ثبت");
	}
}

?>