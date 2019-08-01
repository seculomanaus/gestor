<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.ALUNO';
        $this->view = 'BD_SICA.VW_CL_USUARIOS';
    }
    
}



