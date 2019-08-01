<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Restrito extends CI_Controller {
     
     function __construct() {
        parent::__construct();
        //$this->load->model('usuarios_model', 'user', TRUE);
        //$this->load->model('aluno_model', 'aluno', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session')); 
    }
    
    function index() {        
        $this->load->view('login');
    }
    


}