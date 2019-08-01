<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function acesso($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_USUARIO', 'value' => $p['usuario']),
            array('name' => ':P_SENHA', 'value' => $p['senha']),
            array('name' => ':P_SENHA_ALTERADA', 'value' => $p['nova_senha']),
            array('name' => ':P_PESSOA', 'value' => $p['pessoa']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $res = $this->db->procedure('BD_PORTAL','AES_PORTAL_ACESSO', $params);
        return($res);
        
    }
}



