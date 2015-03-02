<?php
/**
* @author reza mohiti rm.biqarar@gmail.com
*/

class model extends main_model{

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