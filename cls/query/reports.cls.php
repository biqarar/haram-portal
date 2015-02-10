<?php
class query_reports_cls extends query_cls
{
	public function rList($tablse = false) {
		$list  = $this->sql()->tableReport()->whereTables($tablse)->select()->allAssoc();
		return $list;
	}
}
?>