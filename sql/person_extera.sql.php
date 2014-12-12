<?php
namespace sql;
class person_extera {

  public $id             = array("type" => "int@10");
  public $users_id       = array("type" => "int@10"); 
  public $place_birt     = array("type" => "int@10"); 
  public $child_doughter = array("type" => "int@2"); 
  public $child_son      = array("type" => "int@2"); 
  public $dependants     = array("type" => "int@2"); 
  public $soldiering     = array("type" => "enum@done,exempt"); 
  public $exemption_type = array("type" => "enum@education,dependants,temp,medical,continual"); 
  public $job            = array("type" => "varchar@255"); 
  public $residence      = array("type" => "enum@private,rent,more"); 
  public $health         = array("type" => "enum@healthy,maim"); 
  public $treated        = array("type" => "enum@yes,no"); 
  public $stature        = array("type" => "float@"); 
  public $weight         = array("type" => "int@3"); 
  public $blood_group    = array("type" => "enum@A+,A-,B+,B-,AB+,AB-,O+,O-"); 
  public $disease        = array("type" => "varchar@255"); 
  public $insurance_type = array("type" => "varchar@255"); 
  public $insurance_code = array("type" => "varchar@20"); 
  public $good_remember  = array("type" => "varchar@255"); 
  public $bad_remember   = array("type" => "varchar@255"); 
  public $tahqiq         = array("type" => "float@"); 
  public $tartil         = array("type" => "float@"); 
  public $tajvid         = array("type" => "float@"); 
  


  public function id(){
    $this->validate("id");
  }

  public function users_id(){
    $this->validate("id");
  }

  public function place_birt(){
    $this->form("#number")->name("place_birt")->label("place_birt");
  }

  public function child_doughter(){
    $this->form("#number")->name("child_doughter")->label("child_doughter");
  }

  public function child_son(){
    $this->form("#number")->name("child_son")->label("child_son");
  }

  public function dependants(){
    $this->form("#number")->name("dependants")->label("dependants");
  }

  public function soldiering(){
    $this->form("select")->name("soldiering")->label("soldiering");
    $this->setChild($this->form);
  }

  public function exemption_type(){
    $this->form("select")->name("exemption_type")->label("exemption_type");
    $this->setChild($this->form);
  }

  public function job(){
     $this->form("#fatext")->name("job")->label("job");
  }

  public function residence(){
    $this->form("select")->name("residence")->label("residence");
    $this->setChild($this->form);
  }

  public function health(){
    $this->form("select")->name("health")->label("health");
    $this->setChild($this->form);
  }

  public function treated(){
    $this->form("select")->name("treated")->label("treated");
    $this->setChild($this->form);
  }

  public function stature(){
     $this->form("#number")->name("stature")->label("stature");

  }

  public function weight(){
     $this->form("#number")->name("weight")->label("weight");

  }

  public function blood_group(){
    $this->form("select")->name("blood_group")->label("blood_group");
    $this->setChild($this->form);
  }

  public function disease(){
     $this->form("#fatext")->name("disease")->label("disease");      
  }

  public function insurance_type(){
     $this->form("#fatext")->name("insurance_type")->label("insurance_type");  
  }

  public function insurance_code(){
     $this->form("#fatext")->name("insurance_code")->label("insurance_code");  
  }

  public function good_remember(){
     $this->form("#fatext")->name("good_remember")->label("good_remember");  
  }

  public function bad_remember(){
     $this->form("#fatext")->name("bad_remember")->label("bad_remember");  
  }

  public function tahqiq(){
     $this->form("#number")->name("tahqiq")->label("tahqiq");    
  }

  public function tartil(){
     $this->form("#number")->name("tartil")->label("tartil");
  }

  public function tajvid(){
     $this->form("#number")->name("tajvid")->label("tajvid");
  }
}

?>
