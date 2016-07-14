<?php
class query_certification_cls extends query_cls
{
	public function config($value = false) {
		$new_value = false;

		$value = floatval($value);

		$return  = "";
		
		switch ($value) {
			case $value >= 19 and $value <= 20 :
				$return  = "very good";
				break;

			case $value >= 17 and $value < 19 :
				$return  = "good";
				break;

			case $value >= 10 and $value < 17 :
				$return  = "acseptable";
				break;

		}	

		return gettext($return);


	}

}
?>