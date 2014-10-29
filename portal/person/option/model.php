<?php 
/**
 * @author reza mohitit rm.biqarar@gmail.com
 */

class model extends main_model{
	
	public function post_add_person() {
		//----------------------------- got to users/option/model to add users
	}

	public function post_edit_person() {

		//----------------------------- make object sql to update person
		$makeQuery = $this->sql()->tablePerson()
				->setName(post::name())
				->setFamily(post::family())
				->setFather(post::father())
				->setGender(post::gender())
				->setNationalcode(post::nationalcode())
				->setCode(post::code())
				->setMarriage(post::marriage())
				->setChild(post::child())
				->setType(post::type());
				
		// The line for this is that if this field was filled can not be empty and must be changed
		//----------------------------- if country != irna and is set post pasport date update this
		if(post::pasport_date() != "") {
			$makeQuery->setPasport_date(post::pasport_date());
		}


		//----------------------------- if nationality != null update this
		if(post::nationality() != "") {
			$makeQuery->setNationality(post::nationality());
		}
		
		//----------------------------- if britday != null update this
		if(post::birthday() != "") {
			$makeQuery->setBirthday(post::birthday());
		}

		//----------------------------- if from != null update this (foreign key to city table)
		if(post::from() != "") {
			$makeQuery->setFrom(post::from());
		}

		//----------------------------- if education != null update this (foreign key to education table)
		if(post::education_id() != "") {
			$makeQuery->setEducation_id(post::education_id());
		}

		//----------------------------- update query
		$sql = $makeQuery->whereId($this->xuId())->update();
	
		//----------------------------- commit code
		$this->commit(function() {
			debug_lib::true("[[update person successful]]");
		});
		
		//----------------------------- rool back code
		$this->rollback(function() {
			debug_lib::fatal("[[update person failed]]");
		});
	}
}
?>