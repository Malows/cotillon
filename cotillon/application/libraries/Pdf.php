<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'third_party/mpdf/mpdf.php';

class Pdf {

  public $param;
  public $pdf;

  public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
  {
    $this->param =$param;
    $this->pdf = new mPDF($this->param);
  }
}
