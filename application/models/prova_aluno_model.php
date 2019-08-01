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

    	$q =  $this->db->query("select respostas from BD_SICA.AVAL_PROVA where CD_PROVA = ".$p['prova']);
        $resp = $q->result_array();
        $resp = $resp[0]['RESPOSTAS'];

        $r = ' ';
        if (!empty($resp)) {
            $r =  str_split($resp);
            $r = $r[$p['posicao']-1];
        }

        $data = array(
            'CD_QLOG'           => date('dmYhms'),
            'CD_PROVA'          => $p['prova'],
            'CD_QUESTAO'        => $p['questao'],
            'CD_ALUNO'          => $p['aluno'],
            'NR_TEMPO_PROVA'    => $p['tprova'],
            'NR_TEMPO_RESPOSTA' => $p['tresposta'],
            'CD_OPCAO'          => $p['resposta'],
            'POSICAO'           => $p['atual'],
            'CORRETA'           => $r
        );
   
        $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_QLOG', $data);
        
        return (true);

    }
    
     function adicionar($p) {

        $q =  $this->db->query("select respostas from BD_SICA.AVAL_PROVA where CD_PROVA = ".$p['prova']);
        $resp = $q->result_array();
        $resp = $resp[0]['RESPOSTAS'];

        $r = ' ';
        if (!empty($resp)) {
            $r =  str_split($resp);
            $r = $r[$p['posicao']-1]; 
        }

        $data = array(
            'CD_PROVA'          => $p['prova'],
            'CD_QUESTAO'        => $p['questao'],
            'CD_ALUNO'          => $p['aluno'],
            'NR_TEMPO_PROVA'    => $p['tprova'],
            'NR_TEMPO_RESPOSTA' => $p['tresposta'],
            'RESPOSTA'          => $p['resposta'],
            'POSICAO'           => $p['posicao'],
            'CORRETA'           => $r
        );
         
        $res = $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO', $data);
        //echo $this->db->last_query();
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

    function get_fez_prova($p) {
        
        $q =  $this->db->query("select fez_prova from BD_SICA.AVAL_PROVA_INSCRITOS where CD_ALUNO = ".$p['aluno']." and CD_PROVA_VERSAO = ".$p['prova']);
        return $q->result_array();

    }
    
    function deletar($p) {

        $this->db->where('CD_PROVA',$p['prova']);
        $this->db->where('CD_QUESTAO',$p['questao']);
        $this->db->where('CD_ALUNO',$p['aluno']);

        $this->db->delete('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO', $data);
        return (true);
    }



    function sp_reprocessa($p) {    
        $params = array(              
              array('name' => ':P_CD_PROVA_VERSAO',     'value' => $p['prova']),
              array('name' => ':P_CD_ALUNO',            'value' => $p['aluno'])
           );

          $query = $this->db->procedure('BD_SICA','SP_REPROCESSA_PROVA_ONLINE_ALU', $params);
        return (true);
    }

    
}