<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_questao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    function resultado($p) {

        $this->db->select('CD_ALUNO,
                           CD_PROVA,
                           CD_DISCIPLINA,
                           NM_DISCIPLINA,
                           RESPOSTA,
                           CORRETA,
                           DC_TEMA,
                           DC_CONTEUDO,
                           CD_ALU_DISC,
                           NUM_NOTA,
                           DIFICULDADE,
                           VL_QUESTAO,
                           NR_TEMPO_PROVA,
                           NR_TEMPO_RESPOSTA');
        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        //$this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('FLG_TIPO', 'O');
        $this->db->order_by('NM_DISCIPLINA', 'ASC');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->result_array();
        return $query;
    }
    
    function resultado_final($p) {
        $this->db->where('D.CD_PROVA', $p['prova']);
        $this->db->where('D.CD_ALUNO', $p['aluno']);
        $this->db->order_by('DS.NM_DISCIPLINA', 'ASC');
        $this->db->join('BD_SICA.AVAL_PROVA P', 'P.CD_PROVA = D.CD_PROVA');
        $this->db->join('BD_SICA.CL_DISCIPLINA DS', 'D.CD_DISCIPLINA = DS.CD_DISCIPLINA');
        $this->db->join('BD_SICA.AVAL_PROVA_INSCRITOS API', 'API.CD_PROVA_VERSAO = D.CD_PROVA');
        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_DISC D')->result_array();
        
        return $query;
        
        //echo $this->db->last_query($query);
        
    }
    

    function lista($p) {
        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
       //$this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('FLG_TIPO', 'O');
        $this->db->order_by('POSICAO', 'ASC');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->result_array();
 
        return $query;
        
    }
    
    
    function posicao($p) {
        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        $this->db->where('POSICAO', $p['posicao']);
        $this->db->where('FLG_TIPO', 'O');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->row();
        return $query;
    }
    
    
    function filtro($p) {
        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('FLG_TIPO', 'O');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->row();
        return $query;
    }
    
    function lista_opcao($p) {
        $this->db->select('QO.CD_QUESTAO,
                           QO.CD_OPCAO,
                           QO.DC_OPCAO,
                           QO.CD_USU_CADASTRO,
                           QO.DT_CADASTRO,
                           QO.TIPO,
                           QO.FLG_CORRETA,
                           PO.POSICAO');
        $this->db->where('QO.CD_QUESTAO', $p['questao']);
        $this->db->join('BD_SICA.AVAL_PROVA_QUESTOES_OPCAO PO', 'QO.CD_QUESTAO = PO.CD_QUESTAO AND QO.CD_OPCAO = PO.CD_OPCAO AND PO.CD_PROVA = '.$p['prova'].'','left');
        $this->db->order_by('PO.POSICAO', 'ASC');
        $query = $this->db->get('BD_ACADEMICO.AVAL_QUESTAO_OPCAO QO')->result_array();
        return $query;
    }
    
    
    
    
    function listaQuestoesByDisc($p) {
        
        $this->db->distinct();
        $this->db->select('D.NM_DISCIPLINA, PQD.POSICAO_INICIAL, PQD.POSICAO_FINAL'); 
        $this->db->where('PI.CD_PROVA_VERSAO', $p['prova']);
        //$this->db->where('A.CD_ALUNO', $p['aluno']);
        $this->db->where('Q.FLG_TIPO', 'O');
        $this->db->order_by('PQD.POSICAO_INICIAL', 'ASC');
        $this->db->join('BD_SICA.AVAL_PROVA_INSCRITOS PI', 'PQ.CD_PROVA = PI.CD_PROVA');
        $this->db->join('BD_SICA.ALUNO A', 'A.CD_ALUNO = PI.CD_ALUNO');
        $this->db->join('BD_ACADEMICO.AVAL_QUESTAO Q', 'PQ.CD_QUESTAO = Q.CD_QUESTAO');  
        $this->db->join('BD_SICA.AVAL_PROVA_DISC PQD', 'PQD.CD_PROVA = PQ.CD_PROVA AND PQD.CD_DISCIPLINA = Q.CD_DISCIPLINA','left');
        $this->db->join('BD_SICA.CL_DISCIPLINA D', 'D.CD_DISCIPLINA = Q.CD_DISCIPLINA');

        $query = $this->db->get('BD_SICA.AVAL_PROVA_QUESTOES PQ')->result_array();
        
        //echo $this->db->last_query($query);
     
        return $query;
    }
    
    
}



