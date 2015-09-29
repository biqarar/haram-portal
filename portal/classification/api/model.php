<?php
/**
* @author reza mohiti rm.biqarar@gmail.com 
*/
class model extends main_model {

	public function post_priceback() {
		$usersid = $this->xuId("usersid");
		$classesid = $this->xuId("classesid");
		$price = $this->sql()->tablePrice()
			->whereUsers_id($usersid)
			->andPay_type("rule")
			->andStatus("active")
			->andTitle(5)
			->andTransactions($classesid)
			->select();

		if($price->num() >= 1) {
			
			$sum_price = 0;
			foreach ($price->allAssoc() as $key => $value) {
			
				$back = $this->sql()->tablePrice()
					->setUsers_id($usersid)
					->setDate($this->dateNow())
					->setValue($value['value'])
					->setPay_type("rule")
					->setTitle(2)
					->setTransactions($value['id'])
					// ->setStatus("void")
					->insert()->LAST_INSERT_ID();
				$this->commit(function(){
					debug_lib::msg("msg","شهریه به دوره جدید منتقل شد");
				});
			}
		}else{
			debug_lib::msg("msg", "هیچ شهریه ای برای این کلاس ثبت نشده است.");
		}
		debug_lib::msg("msg", "هیچ شهریه ای برای این کلاس ثبت نشده است.");

		// var_dump("fuck");exit();
	}


	public function remove_payment_count($usersid = false, $classesid = false) {
		$this->sql()->tablePrice()
			->whereUsers_id($usersid)
			->andVisible(0)
			->andTransactions($classesid)
			->andTitle(8)
			->delete();
	}

	public function post_classificationapi() {

		
		$usersid = $this->xuId("usersid");
		$classesid = $this->xuId("classesid");
		
		$this->remove_payment_count($usersid, $classesid);
		
		$price = $this->sql()->tablePrice()
			->whereUsers_id($usersid)
			->andPay_type("rule")
			->andStatus("active")
			->andTitle(5)
			->andTransactions($classesid)
			->setStatus("void")->update();

		$classes_id = $this->sql()->tableClassification()->whereId($this->xuId())->limit(1)->select()->assoc("classes_id");
		$this->sql(".classesCount", $classes_id);
		
		$classification =  $this->sql()->tableClassification()		
			->setDate_delete($this->xuId("date"))
			->setBecause($this->xuId("because"))
			->whereId($this->xuId())->update();
			$this->commit(function(){
				debug_lib::msg("msg", "به روز رسانی اطلاعات انجام شد.");
			});
		debug_lib::msg("msg", "به روز رسانی اطلاعات انجام شد.");

	}

	public function post_price() {
		$usersid = $this->xuId("usersid");
		$classesid = $this->xuId("classesid");
		$price = $this->sql()->tablePrice()
			->whereUsers_id($usersid)
			->andPay_type("rule")
			->andStatus("active")
			->andTitle(5)
			->andTransactions($classesid)
			->select();

		$sum_price = 0;
		if($price->num() >= 1) {
			foreach ($price->allAssoc() as $key => $value) {
				$sum_price = $sum_price + intval($value['value']);
			}
		}
		debug_lib::msg("sum_price", $sum_price);
	}

	public function post_insert() {
		
		//------------------------------ set users id and classes id
		$users_id   = config_lib::$surl["usersid"];
		$classes_id = config_lib::$surl["classesid"];
		// $name_famil 

		//------------------------------ insert courseclasses
		$courseclasses = $this->sql(".courseclasses", $classes_id, $users_id);
		// var_dump($courseclasses);
		if(!$courseclasses){

		//------------------------------ key for check duplicate
		$duplicate = false;
		//------------------------------ check for duplicate this classes inserted 
			$check = $this->sql()->tableClassification()->whereUsers_id($users_id)->andClasses_id($classes_id)->limit(1)->select();
			
			if($check->num() == 0) {

				//------------------------------ check duplicate other classes as time for this users
				list($duplicate, $msg) = $this->sql(".duplicateUsersClasses.classification", $users_id, $classes_id);
				if($duplicate) {
					debug_lib::fatal($msg);
				}else{
					//------------------------------ check price 
					if(!$this->sql(".plan.maxPerson", $classes_id)) {
		
						debug_lib::fatal("ظرفیت این کلاس تکمیل است و امکان ثبت فراگیر وجود ندارد.");
				
					}elseif(!$this->sql(".price.checkClasses", $users_id , $classes_id)) {
		
						debug_lib::fatal("شهریه کافی نیست لفطا نسبت به شارژ حساب این فراگیر اقدام فرمایید.");
				
					}elseif(!$this->sql(".pasportCheck", $users_id)){
					
						debug_lib::fatal("اعتبار گذرنامه این فراگیر به اتمام رسیده است");
					
					}else{


						//------------------------------ insert classification
						$classification = $this->sql()->tableClassification()
								->setUsers_id($users_id)
								->setClasses_id($classes_id)
								->setDate_entry($this->dateNow())
								->insert();
						//------------------------------- set classification count in to classes table
						$this->sql(".classesCount", $classes_id);
						
							//------------------------------ commit code
						if(!$duplicate) {
							$this->commit(function() {
								debug_lib::true("فراگیر به کلاس اضافه شد");	
							});
						}
						
					}
				}
			}else{

				$duplicate = true;
				debug_lib::fatal("این فراگیر قبلا در کلاس ثبت شده است");
			}	
		}else{
			$type = $courseclasses['type'];
			if($type == 'fatal'){
				debug_lib::fatal($courseclasses['msg']);
			}else{
				debug_lib::true($courseclasses['msg']);
			}
		}
	
	

		// //------------------------------ rolback code
		// $this->rollback(function() {
		// 	debug_lib::fatal("خطا در ثبت");
		// });
	}
}
?>