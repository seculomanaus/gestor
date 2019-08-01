<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_inscricao_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = 'BD_SICA.AVAL_PROVA_INSCRITOS';
        $this->view  = 'BD_SICA.VW_AVAL_PROVA_INSCRITOS';
    }
    
}



