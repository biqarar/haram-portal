<?php
/**
 * @author REZA MOHITI <rm.biqarar@gmail.com>
 */

class view extends main_view{
	public function config(){
		$this->global->page_title='files';
		$this->global->url = $this->uStatus(true);
		$hidden = $this->form("#hidden")->value("files");
		$tag = $this->form("select")->name("tag")->label("tag");
		$id = $this->form("text")->name("id")->label("id")->id("type-combo")->addClass("notselect");
		$file =  $this->form("file")->name("file")->label("file");
		$submit = $this->form("#submitedit")->value("send");
		
		$base = config_lib::$surl['base'];
		$tagList = $this->sql("@get_tag", $base);
		foreach ($tagList as $key => $value) {
			$tag->child()->value($value->id)->label($value->tag);
		}

		$files = array();
		
		$files[] = $hidden->compile();
		$files[] = $tag->compile();
		$files[] = $id->compile();
		$files[] = $file->compile();
		$files[] = $submit->compile();
		
		$this->data->files = $files;
		$this->data->baseOption = $base;
	}
}
?>