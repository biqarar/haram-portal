<?php
class query_assoc_cls extends query_cls
{
	public function province() {
		return $this->sql()->tableProvince()->select()->allAssoc();
	}

	public function education() {
		return $this->sql()->tableEducation()->groupbyGroup()->select()->allAssoc();
	}
}
?>