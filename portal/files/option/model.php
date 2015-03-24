<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class model extends main_model{

	public $post_file = array();

	public function post_files(){
		$base = config_lib::$surl['base'];
		$id = post::id();
		$tag = post::tag();
		$file = $_FILES['file'];
		$this->post_file = (object) array(
			'base' => $base,
			'id' => $id,
			'tag' => $tag
			);
		if(!$this->condition($file)) return;
	}

	private function condition($file){
		$get_condition = $this->sql()->tableFile_tag()
		->whereTable_name($this->post_file->base)
		->andId($this->post_file->tag)->select();
		$list = $get_condition->Object();
		$this->post_file->list = $list;
		$condition = conditions_cls::parse($list->condition);
		$this->post_file->condition = $condition;
		$exec = array();
		switch ($list->type) {
			case 'image':
			$exec = array('png', 'jpg', 'jpeg', 'gif', 'tiff');
			break;
			case 'multimedia':
			$exec = array('mp3', 'mp4', 'flv', 'avi', 'ogg', 'wmv', '3gp');
			break;
			case 'multimedia':
			$exec = array('docx', 'doc', 'xls', 'xlsx', 'ppt', 'pps', 'pptx', 'ppsx');
			break;
			case 'multimedia':
			$exec = array('zip', 'rar', '7zip');
			break;
			
		}
		$file_name = explode(".", $file['name']);
		$file_exec = strtolower(end($file_name));
		if(!preg_grep("/^{$file_exec}$/", $exec)){
			debug_lib::fatal("type must be ". join(', ', $exec));
			return false;
		}
		if($list->max_size < ($file['size']/ 1000000)){
			debug_lib::fatal("max size must be ". $list->max_size .' mb');
			return false;
		}
		if($list->type == 'image'){
			$crop = $this->post_file->crop = explode(" ", post::crop_size());
			switch ($condition->ratio) {
				case '1.777777778':
				case '1.7777777777778':
					$rat_name = '16:9';
					break;
				case '1.333333333':
				case '1.3333333333333':
					$rat_name = '4:3';
					break;
				case '0.75':
					$rat_name = '3:4';
					break;
				case '0.5625':
					$rat_name = '9:16';
					break;
				default:
					$rat_name = $condition->ratio;
					break;
			}
			if($condition->ratio != $crop[2] / $crop[3]){
				debug_lib::fatal("ratio must be ". $rat_name);
				return false;
			}
		}
		return true;
	}

	public function sql_get_tag($base){
		$sql = $this->sql()->tableFile_tag()->whereTable_name($base);
		return $sql->select()->allObject();
	}

	public function post_add_files(){
		$uploadPath = query_files_cls::getAddr();
		$FILE = isset($_FILES) && isset($_FILES['file'])? $_FILES['file'] : false;
		$name = false;
		$gPathId = false;
		if(!$FILE){
			debug_lib::fatal('upload your file', 'file', 'form');
		}elseif($FILE){
			if($FILE['error'] == 4){
				debug_lib::fatal('select your file', 'file', 'form');
			}
			if($FILE['error'] == 0){
				$name = fileexec_cls::validation($FILE['name'], true);
				if(!$name){
					debug_lib::fatal('incorrect file exec', 'file', 'form');
				}
			}
		}
		if($name){
			$size = (float) number_format($FILE['size'] / (1024 * 1024), 2);
			if($size > $name['max']){
				debug_lib::fatal("max file size is $name[max] mb", 'file', 'form');
			}
			$sqlU = $this->sql()->tableFiles()
			->setTitle(post::title())
			->setSize($size)
			->setType($name['exec'])
			->setDescription(post::description())
			->insert();
			$id = $sqlU->LAST_INSERT_ID();
			$path = $uploadPath;
			$gPathId = $this->sql()->tableFiles()->whereId($id)->select()->assoc();
			$path .= $gPathId['folder'];
			if(!is_dir($path) && !mkdir($path)){
				debug_lib::fatal("error in file transfer", 'file', 'form');
			}
			$filename = str_pad($id, 10, "0", STR_PAD_LEFT);

			$copyPublic = query_files_cls::checkbase($name);
			if(debug_lib::$status){
				$fileAddr = $path.'/'.$filename;
				if(!move_uploaded_file($FILE['tmp_name'], $fileAddr)){
					debug_lib::fatal("error in file transfer", 'file', 'form');
				}elseif($copyPublic == 'public'){
					$gPathId['fileAddr'] = str_replace(query_files_cls::getPath(), "", $fileAddr);
					// $pPath = $this->publicAddr.'/'.$this->prefixPath.$gPathId['folder'];
					// $pFileAddr = $pPath.'/'.$filename.'.'.$name['exec'];
					// if(!is_dir($this->publicAddr) && !mkdir($this->publicAddr)){
					// 	debug_lib::fatal("error in public file transfer", 'file', 'form');
					// }elseif(!is_dir($pPath) && !mkdir($pPath)){
					// 	debug_lib::fatal("error in public file transfer", 'file', 'form');
					// }elseif(!copy($fileAddr, $pFileAddr)){
					// 	debug_lib::fatal("error in public file transfer", 'file', 'form');
					// }else{
					// 	$gPathId['publicAddr'] = $pFileAddr;
					// }
					// if(debug_lib::$status){
					// 	unlink($fileAddr);
					// }
				}
			}

		}
		
		$this->commit(function($array) {
			$base = $_SESSION['base_'.post::base()];
			unset($_SESSION['base_'.post::base()]);
			$array['base'] = query_files_cls::makeBase($base);
			debug_lib::true("[[insert files successful]]");
			debug_lib::msg($array);
		}, $gPathId);
		$this->rollback(function() {
			debug_lib::fatal("[[insert files failed]]");
		});
	}

	public function post_edit_files(){
		$sql = $this->makeQuery()
		->whereId($this->uId())
		->update();
		$this->commit(function() {
			debug_lib::true("[[update files successful]]");
		});
		$this->rollback(function() {
			debug_lib::fatal("[[update files failed]]");
		});
	}
}
?>