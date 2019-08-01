<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('prova_model', 'prova', FALSE);
        $this->load->model('prova_questao_model', 'questoes', FALSE);
        $this->load->model('prova_aluno_model', 'aluno', FALSE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('prova_lib', 'processa_prova_lib', 'session', 'encrypt'));
    }

    function index($id) {
        
        //caso o aluno recarregue a pagina da erro 500
        
        if($this->session->userdata('nreload')==0){
            $this->aluno->get_fez_prova();//so pra dar o erro 500
        }
        $this->session->set_userdata('nreload',0);
       
        // informacoes da prova e usuario
        $p = array(
            'materia'   => $this->session->userdata('CES_MATERIA'),
            'prova'     => $this->session->userdata('CES_PROVA'),
            'aluno'     => $this->session->userdata('PVO_USER'),
            'posicao'   => 1,
        );

        // se o aluno ja fez a prova redireciona
        $fez =  $this->aluno->get_fez_prova($p);
        if ($fez[0]['FEZ_PROVA'] == 1) {
            redirect("prova/resultado");
        }

        // CONSULTA EXIBE QUESTÃO E SUA POSICAO
        $questao_posicao = $this->questoes->lista($p);
        
        $questao =  (object) $questao_posicao[0];
        
        // CONSULTA EXIBE LISTA DE QUESTÕES COM CÓDIGO, POSIÇÃO E RESPOSTA
        $qtd_questoes = $this->questoes->lista_opcao($p);        

        //OBTEM O TEMPO PARA TÉRMINO DA PROVA
        $tempo = $this->prova->getUltimaAcao($p);
        if ($tempo->TEMPO != '') {

            //adicionar parte de segundos no registro
            $tempo = $tempo->TEMPO . ":00";
        } else {
            //caso não tenha tempo restante verificar o tempo total de prova            
            $tempo = $this->prova->tempo($this->session->userdata('CES_PROVA'));
        }

        $data = array(
            'questao'           =>$questao,
            'tempo'             => $tempo,
            'questao_posicao'   => $questao_posicao,
            'qtd'               => $qtd_questoes,
            'materia'           => $this->session->userdata('CES_MATERIA'),
            'versao'            => $p['prova'],
            'cd_aluno'          => $p['aluno'],
            'ultimaPosicao'     =>count($qtd_questoes)
        );
        
        $this->load->view('prova/index', $data);
    }

    function questao() {

        $res = new Prova_lib();

        $p = array(
            'prova'     => $this->session->userdata('CES_PROVA'),
            'questao'   => $this->input->post('questao'),
            'posicao'   => $this->input->post('posicao'),
            'tprova'    => $this->input->post('crono'),
            'tresposta' => $this->input->post('time'),
            'posicao'   => $this->input->post('posicao'),
            'resposta'  => $this->input->post('resposta'),
            'atual'     => $this->input->post('atual'),
            'correta'   => $this->encrypt->decode($this->input->post('correta')),
            'aluno'     => $this->session->userdata('PVO_USER'),
        );
         // ADICIONA O LOG DE TEMPO PARA CADA RESPOSTA
        $this->aluno->add_log($p);

         // CONSULTA EXIBE QUESTÃO E SUA POSICAO
         $questao_posicao = $this->questoes->lista($p);

         $questao = (object) $questao_posicao[0];
 
        // CONSULTA EXIBE LISTA DE QUESTÕES COM CÓDIGO, POSIÇÃO E RESPOSTA
         $qtd_questoes = $this->questoes->lista_opcao($p);        

         $data = array(
             'questao'           =>$questao,
             'questao_posicao'   => $questao_posicao,
             'qtd'               => $qtd_questoes,
             'materia'           => $this->session->userdata('CES_MATERIA'),
             'versao'            => $p['prova']
         );
         $this->load->view('prova/questao', $data);
    }

    //adiciona resposta do aluno
    function manter() {
		 
        $p = array(
            'prova'     => $this->session->userdata('CES_PROVA'),
            'questao'   => $this->input->post('questao'),
            'tprova'    => $this->input->post('crono'),
            'tresposta' => $this->input->post('time'),
            'posicao'   => $this->input->post('posicao'),
            'resposta'  => $this->input->post('resposta'),
            'atual'     => $this->input->post('atual'),
            'correta'   => $this->encrypt->decode($this->input->post('correta')),
            'aluno'     => $this->session->userdata('PVO_USER'),
        );

       // var_dump($p);

        //adiciona log
        $this->aluno->add_log($p);

        // ADICIONA A RESPOSTA NO CARTÃO
        $res = $this->aluno->adicionar($p);

        if ($res == 'erro') {
            $this->aluno->editar($p);
        }
    }

    //atualiza cartao resposta
    function cartao() {
        $p = array(
            'prova' => $this->session->userdata('CES_PROVA'),
            'aluno' => $this->session->userdata('PVO_USER'),
        );

        // CONSULTA EXIBE LISTA DE QUESTÕES COM CÓDIGO, POSIÇÃO E RESPOSTA
        $questoes = $this->questoes->lista_opcao($p);
              
	        $data = array(
            'qtd' => $questoes,
            
        );
        $this->load->view('prova/cartao', $data);
    }

    function resultado() {
        
        $prova = $this->session->userdata('CES_PROVA');
        $aluno = $this->session->userdata('PVO_USER');

        /************** INICIO DO PROCESSAMENTO ************ */
        $processa = new Processa_prova_lib();
        $processa->aluno = $aluno;
        $processa->prova = $prova;
        $processa->prova();
        /****************** FIM DO PROCESSAMENTO ************ */


        $p = array(
            'prova' => $prova,
            'aluno' => $aluno,
        );

        //seta QUE O ALUNO FEZ A PROVA
        $this->aluno->fez_prova($p);


        // RETORNA O RESULTADO DA PROVA
        $prova = $this->questoes->resultado_final($p);

        // if(!$prova['FLG_EXIBE_RESULTADO']){
        //      $exibe_res = $this->questoes->exibe_res($prova);

        // }else{
        //      $exibe_res = $prova['FLG_EXIBE_RESULTADO'];
        // }
        
        $data = array(
            'lista' => $prova,
            'materia'=> $this->session->userdata('MATERIA')
        );

        //$this->load->view('prova/resultado', $data);  retirado por mauricio (pipocado)
    }

    /**
     * Registra o tempo da ultima acao na prova
     * 
     * @param string $tempo
     */
    function registrarUltimaAcao() {
        $tempo = $this->input->post("tempo");
        $prova = $this->session->userdata("CES_PROVA");

        $params = array(
            "CD_PROVA"       => $prova,
            "HR_ULTIMA_ACAO" => $tempo,
            "CD_ALUNO"       => $this->session->userdata('PVO_USER'),
        );

        $this->prova->registrarUltimaAcao($params);
    }

}