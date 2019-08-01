<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    //carregando 
    function __construct() {
        parent::__construct();

        /*$this->load->model('prova_model', 'prova', FALSE);
        $this->load->model('prova_questao_model', 'questoes', FALSE);
        $this->load->model('prova_aluno_model', 'aluno', FALSE);*/
    

        //models
        $this->load->model('dashboard_model', 'dashboard', true);


        //libs
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('prova_lib', 'processa_prova_lib', 'session', 'encrypt'));
    }



    //operacao 1 - setando sp de pedidos do mantenedor no dashboard
    function index(){
        $data = array(
            'titulo'        => '<h1>Dashboard - Listagem de Pedidos</h1>',
            'lista_pedidos_mantenedora' => $this->dashboard->lista_pedidos_mantenedora($operacao = 
                array(
                    'p_operacao' => 1, 
                    'p_cd_mantenedora' => null, 
                    'p_cd_centro_custo' => null,
                    'p_ped_status' => null,
                    'p_cd_pedido' => null
                ))
        );


    	$this->load->view('home/dashboard', $data);
    }


    //operacao 2 - setando sp do centro de custo
    function lista_pedidos_ccusto($id){

        $data = array(
            'lista_pedidos_ccusto' => $this->dashboard->lista_pedidos_mantenedora($operacao = 
                array(
                    'p_operacao' => 2, 
                    'p_cd_mantenedora' => $id, 
                    'p_cd_centro_custo' => null,
                    'p_ped_status' => null,
                    'p_cd_pedido' => null
                ))
        );

        $this->load->view('home/lista', $data);
    }



    function lista_total_pedidos_ccusto(){

        $id = $this->input->get_post('id');
        
        $data = array( 
            'lista_total_pedidos_ccusto' => $this->dashboard->lista_pedidos_mantenedora($operacao = 
                array(
                    'p_operacao' => 3, 
                    'p_cd_mantenedora' => null, 
                    'p_cd_centro_custo' => $id,
                    'p_ped_status' => null,
                    'p_cd_pedido' => null
                ))
        );
       

        //$exclusao = $this->banco->excluirVersoes($prova);
        //echo json_encode($data);
    
        $this->load->view('home/item', $data);
    }


    //atualiza status do pedido
    function atualiza_status_pedido(){
        echo "teste";
    }


    /*function lista_total_pedidos_ccusto(){

        $id = $this->input->get_post('id');
        
        $data =  $this->dashboard->lista_pedidos_mantenedora($operacao = 
                array(
                    'p_operacao' => 3, 
                    'p_cd_mantenedora' => null, 
                    'p_cd_centro_custo' => $id,
                    'p_ped_status' => null,
                    'p_cd_pedido' => null
                ));
       

        //$exclusao = $this->banco->excluirVersoes($prova);
        echo json_encode($data);
    }*/




}

?>