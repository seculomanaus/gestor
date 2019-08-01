<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


/*
|
|
|  CARREGA O DASHBOARD E LISTA AS INFORMAÇÕES
|
*/  
class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

        //$this->table = 'BD_SICA.ALUNO';
        // $this->view = 'BD_SICA.VW_AVAL_PROVA_INSCRITOS';
    }



    //sp responsável pela listagem de  das informações no dashboard
    function lista_pedidos_mantenedora($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',           'value' => $parametro['p_operacao']),
            array('name' => ':P_CD_MANTENEDORA',     'value' => $parametro['p_cd_mantenedora']),
            array('name' => ':P_CD_CENTRO_CUSTO',    'value' => $parametro['p_cd_centro_custo']),
            array('name' => ':P_PED_STATUS',         'value' => $parametro['p_ped_status']),
            array('name' => ':P_CD_PEDIDO',          'value' => $parametro['p_cd_pedido']),
            array('name' => ':P_CURSOR',             'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        // var_dump($params);
        // $cursor = '';
        // $params = array(
        //     array('name' => ':P_OPERACAO',           'value' => 1),
        //     array('name' => ':P_CURSOR',              'value' => $cursor, 'type' => OCI_B_CURSOR)
        // );

         $query = $this->db->procedure('BD_APLICACAO','GESTOR_PEDIDOS', $params);
        


        // $query = $this->db->get('BD_SICA.ALUNO')->result();
        return $query;
        
    }




}
?>