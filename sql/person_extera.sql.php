<?php
namespace sql;
class person_extera {

  public $id             = array("type" => "int@10");
  public $users_id       = array("type" => "int@10", "label" => "extera_users_id"); 
  public $place_birth     = array("type" => "int@10", "label" => "place_birth"); 
  public $child_daughter = array("type" => "int@2", "label" => "extera_child_daughter"); 
  public $child_son      = array("type" => "int@2", "label" => "extera_child_son"); 
  public $dependents     = array("type" => "int@2", "label" => "extera_dependents"); 
  public $soldiering     = array("type" => "enum@done,exempt", "label" => "extera_soldiering"); 
  public $exemption_type = array("type" => "enum@education,dependents,temp,medical,continual", "label" => "extera_exemption_type"); 
  public $job            = array("type" => "varchar@255", "label" => "extera_job"); 
  public $residence      = array("type" => "enum@private_home,rent,some_else", "label" => "extera_residence"); 
  public $health         = array("type" => "enum@healthy,maim", "label" => "extera_health"); 
  public $treated        = array("type" => "enum@yes,no", "label" => "extera_treated"); 
  public $stature        = array("type" => "float@", "label" => "extera_stature"); 
  public $weight         = array("type" => "int@3", "label" => "extera_weight"); 
  public $blood_group    = array("type" => "enum@A+,A-,B+,B-,AB+,AB-,O+,O-", "label" => "extera_blood_group"); 
  public $disease        = array("type" => "varchar@255", "label" => "extera_disease"); 
  public $insurance_type = array("type" => "varchar@255", "label" => "extera_insurance_type"); 
  public $insurance_code = array("type" => "varchar@20", "label" => "extera_insurance_code"); 
  public $good_remember  = array("type" => "varchar@255", "label" => "extera_good_remember"); 
  public $bad_remember   = array("type" => "varchar@255", "label" => "extera_bad_remember"); 
  public $tahqiq         = array("type" => "float@", "label" => "extera_tahqiq"); 
  public $tartil         = array("type" => "float@", "label" => "extera_tartil"); 
  public $tajvid         = array("type" => "float@", "label" => "extera_tajvid"); 
  public $melli_account  = array("type" => "varchar@13", "label" => "extera_melli_account"); 
  public $melat_account  = array("type" => "varchar@10", "label" => "extera_melat_account"); 
  


  public function id(){
    $this->validate("id");
  }

  public function users_id(){
    $this->validate("id");
  }

  public function place_birth(){
    $this->form("text")->name("place_birth")->id("from")->addClass("select-city")->data_url("city/api/");
    $this->validate()->reg("/(.*)/");

  }

  public function child_daughter(){
    $this->form("#number")->name("child_daughter")->label("child_daughter");
    $this->validate()->number()->form->number("number of girl children should be less than 99");
  }

  public function child_son(){
    $this->form("#number")->name("child_son")->label("child_son");
    $this->validate()->number()->form->number("number of boy children should be less than 99");
  }

  public function dependents(){
    $this->form("#number")->name("dependents")->label("dependents");
    $this->validate()->number(1, 2)->form->number("number of dependents is not valid");
  }

  public function soldiering(){
    $this->form("radio")->name("soldiering")->label("soldiering");
    $this->setChild($this->form);
  }

  public function exemption_type(){
    $this->form("select")->name("exemption_type")->label("exemption_type");
    $this->setChild($this->form);
  }

  public function job(){
     $this->form("#fatext")->name("job")->label("job");
     $this->validate()->farsi()->form->farsi("job title should be persian");
  }

  public function residence(){
    $this->form("radio")->name("residence")->label("residence");
    $this->setChild($this->form);
  }

  public function health(){
    $this->form("radio")->name("health")->label("health");
    $this->setChild($this->form);
  }

  public function treated(){
    $this->form("radio")->name("treated")->label("treated");
    $this->setChild($this->form);
  }

  public function stature(){
     $this->form("#number")->name("stature")->label("stature")->addClass('slider-number')->min(120)->max(300);
  }

  public function weight(){
     $this->form("#number")->name("weight")->label("weight")->addClass('slider-number')->min(30)->max(150);

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

  public function melli_account(){
     $this->form("#number")->name("melli_account")->label("melli_account");
     $this->validate()->number(13);
  }

  public function melat_account(){
     $this->form("#number")->name("melat_account")->label("melat_account");
     $this->validate()->number(10);
  }
}

?>
