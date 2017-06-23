<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function index($cus_id = "")
    {
        $this->load->view('index');
    }

    public function join()
    {
        $this->load->view('index');
    }
}
