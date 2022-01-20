<?php

class Prescription{
  private $imgURL;
  private $area;
  private $note;

  public function __construct($imgURL, $area, $note){
    $this->imgURL = $imgURL;
    $this->area = $area;
    $this->note = $note;
  }

  public function getImgURL(){
    return $this->imgURL;
  }

  public function getArea(){
    return $this->area;
  }

  public function getNote(){
    return $this->note;
  }
}

 ?>
