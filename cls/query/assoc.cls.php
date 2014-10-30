<?php
class query_assoc_cls extends query_cls
{
	public function province() {
		return $this->sql()->tableProvince()->select()->allAssoc();
	}

	public function education() {
		return $this->sql()->tableEducation()->groupbyGroup()->select()->allAssoc();
	}

	public function foreign($table = false, $id = false, $field = false, $where = "id") {
		$table     = "table" . ucfirst($table);
		$funcField = "field" . ucfirst($field);
		$where     = "where" . ucfirst($where);
		$id        = intval($id);
		$sql = $this->sql()->$table()->$where($id)->limit(1)->$funcField()->select();
		return $sql->assoc($field);
	}
}
?>