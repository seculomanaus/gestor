<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_aluno_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function filtro($p) {
        $this->db->where('CD_PROVA',$p['codigo']);
        $query = $this->db->get('BD_SICA.AVAL_PROVA')->row();
        return $query;
    }
       
    function add_log($p) {

        $data = array(
            'CD_QLOG'           => date('dmYhms'),
            'CD_PROVA'          => $p['prova'],
            'CD_QUESTAO'        => $p['questao'],
            'CD_ALUNO'          => $p['aluno'],
            'NR_TEMPO_PROVA'    => $p['tprova'],
            'NR_TEMPO_RESPOSTA' => $p['tresposta'],
            'CD_OPCAO'          => $p['resposta'],
            'POSICAO'           => $p['atual'],
            'CORRETA'           => $p['correta']
        );
        //print_r($data);
        $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_QLOG', $data);
        
        return (true);

    }
    
     function adicionar($p) {

        $data = array(
            'CD_PROVA'          => $p['prova'],
            'CD_QUESTAO'        => $p['questao'],
            'CD_ALUNO'          => $p['aluno'],
            'NR_TEMPO_PROVA'    => $p['tprova'],
            'NR_TEMPO_RESPOSTA' => $p['tresposta'],
            'RESPOSTA'          => $p['resposta'],
            'POSICAO'           => $p['posicao'],
            'CORRETA'           => $p['correta']
        );
        $res = $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO', $data);
        
        if($res){
            return 'success';
        }else{
            return 'erro';
        }
    }
    
    function editar($p) {

        $data = array(
            'NR_TEMPO_PROVA'    => $p['tprova'],
            'NR_TEMPO_RESPOSTA' => $p['tresposta'],
            'RESPOSTA'          => $p['resposta'],
            'POSICAO'           => $p['posicao'],
            'CORRETA'           => $p['correta']
        );
        
        $this->db->where('CD_PROVA',$p['prova']);
        $this->db->where('CD_QUESTAO',$p['questao']);
        $this->db->where('CD_ALUNO',$p['aluno']);
        $this->db->update('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO', $data);
        return (true);
    }
    
     function fez_prova($p) {
        $data = array(
            'FEZ_PROVA' => 1,
            'DT_ALTERACAO_FEZ_PROVA' => date('d-M-Y')
            //'DT_ALTERACAO_FEZ_PROVA' => date('Y-m-d',strtotime(implode("-",array_reverse(explode("/",date('d/m/Y')))))),
        );
        $this->db->where('CD_PROVA_VERSAO',$p['prova']);
        $this->db->where('CD_ALUNO',$p['aluno']);
        $this->db->update('BD_SICA.AVAL_PROVA_INSCRITOS', $data);
        return (true);
    }
    
    function deletar($p) {

        $this->db->where('CD_PROVA',$p['prova']);
        $this->db->where('CD_QUESTAO',$p['questao']);
        $this->db->where('CD_ALUNO',$p['aluno']);

        $this->db->delete('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO', $data);
        return (true);
    }
    
}



