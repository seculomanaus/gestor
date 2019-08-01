<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova extends CI_Controller {
    
    
    var $link = 'comissao/prova/';

    function __construct() {
        parent::__construct();

        $this->load->model('comissao/prova_model', 'prova', TRUE);
        $this->load->model('comissao/prova_questao_model', 'questoes', TRUE);
        $this->load->model('comissao/prova_aluno_model', 'aluno', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('prova_lib', 'session'));
    }

    function index($id) {
        
        $row = json_decode(base64_decode($this->input->get('p')));
        
        $this->session->set_userdata('CES_PROVA', $row->CD_PROVA);
        
        
        $p = array(
            'prova' => $row->CD_PROVA,
            //'aluno' => $this->session->userdata('PVO_USER'),
            'posicao' => 1,
        );

        // CONSULTA AS QUESTÕES PARA TRAZER TODAS AS QUESTÕES
        $prova_qtd = $this->questoes->lista($p);

        // RETORNA A PRIMEIRA QUESTÃO
        $questao = $this->questoes->posicao($p);

        //obter quanto tempo restava de prova
        $tempo = $this->prova->getUltimaAcao($p);

        $questoesByDisc_qtd = $this->questoes->listaQuestoesByDisc($p);

        $data = array(
            'tempo' => $tempo,
            'questao' => $questao,
            'opcao' => $this->questoes->lista_opcao(array('prova' => $row->CD_PROVA, 'questao' => $questao->CD_QUESTAO)),
            'qtd' => $prova_qtd,
            'qtdeQuestoesByDisc' => $questoesByDisc_qtd

        );

      
        $this->load->view($this->link.'index', $data);
    }

    function questao() {

        $res = new Prova_lib();

        $p = array(
            'prova' => $this->session->userdata('CES_PROVA'),
            'questao' => $this->input->post('questao'),
            'posicao' => $this->input->post('posicao'),
            'tprova' => $this->input->post('crono'),
            'tresposta' => $this->input->post('time'),
            'posicao' => $this->input->post('posicao'),
            'resposta' => $this->input->post('resposta'),
            'atual' => $this->input->post('atual'),
        );
        // CONSULTA AS QUESTÕES PARA TRAZER TODAS AS QUESTÕES
        $prova_qtd = $this->questoes->lista($p);
        // RETORNA A PRIMEIRA QUESTÃO
        $questao = $this->questoes->posicao($p);

        $data = array(
            'questao' => $questao,
            'opcao' => $this->questoes->lista_opcao(array('prova' => $this->session->userdata('CES_PROVA'), 'questao' => $questao->CD_QUESTAO)),
            'qtd' => $prova_qtd
        );
        $this->load->view($this->link.'questao', $data);
    }

    function cartao() {
        $p = array(
            'prova' => $this->session->userdata('CES_PROVA'),
            'aluno' => $this->session->userdata('PVO_USER'),
        );
        // CONSULTA AS QUESTÕES PARA TRAZER TODAS AS QUESTÕES
        $questoes = $this->questoes->lista($p);
        $questoesByDisc_qtd = $this->questoes->listaQuestoesByDisc($p);


        $data = array(
            'qtd' => $questoes,
            'qtdeQuestoesByDisc' => $questoesByDisc_qtd
        );
        $this->load->view($this->link.'cartao', $data);
    }


}
