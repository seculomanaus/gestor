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
        //$this->db->distinct();
        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        //$this->db->where('FLG_TIPO', 'O');
        $this->db->order_by('NM_DISCIPLINA', 'ASC');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->result_array();
        //echo $this->db->last_query();
        $this->db->close();
        return $query;
    }
    
    function resultado_final($p) {
        // $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        // $this->db->where('CD_ALUNO', $p['aluno']);
        // $this->db->order_by('NM_DISCIPLINA', 'ASC');
        // $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_RESULTADO D')->result_array();
        // //echo $this->db->last_query($query);
        // $this->db->close();
        

         return $this->db->query("select d.cd_prova, d.nr_acerto, d.nr_erro, d.nr_nota, flg_exibe_resultado
                                    from bd_sica.aval_prova_aluno_disc d
                                    left join BD_SICA.AVAL_PROVA P ON d.cd_prova = p.cd_prova
                                    left join BD_SICA.AVAL_PROVA_CALENDARIO pc on p.cd_prova_pai = pc.cd_prova
                                where d.cd_prova = ".$p['prova']." and d.cd_aluno = ".$p['aluno'])->result_array();
        
    }
    
    function lista($p) {

    $cursor = '';
    $params = array(
              array('name' => ':P_TIPO',                'value' => 'MQ'),
              array('name' => ':P_CD_PROVA_VERSAO',     'value' => $p['prova']),
              array('name' => ':P_POSICAO',             'value' => $p['posicao']),
              array('name' => ':P_CD_ALUNO',            'value' => $p['aluno']),                  
              array('name' => ':P_CURSOR',              'value' => $cursor, 'type' => OCI_B_CURSOR)
          );

          $query = $this->db->procedure('BD_SICA','SP_MONTA_PROVA', $params);
        //   var_dump($query[0]); exit();
          return $query;
        
    }
        
    function posicao($p) {

        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('POSICAO', $p['posicao']);
        //$this->db->where('FLG_TIPO', 'O');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->row();
        $this->db->close();
        return $query;
    }
    
    
    function filtro($p) {

        $this->db->where('CD_PROVA_VERSAO', $p['prova']);
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('FLG_TIPO', 'O');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO')->row();
        $this->db->close();
        return $query;
    }
    
    function lista_opcao($p) {
        $cursor = '';
        $params = array(
                  array('name' => ':P_TIPO',                'value' => 'MLQ'),
                  array('name' => ':P_CD_PROVA_VERSAO',     'value' => $p['prova']),
                  array('name' => ':P_POSICAO',             'value' => $p['posicao']),
                  array('name' => ':P_CD_ALUNO',            'value' => $p['aluno']),                  
                  array('name' => ':P_CURSOR',              'value' => $cursor, 'type' => OCI_B_CURSOR)
              );
    
              $query = $this->db->procedure('BD_SICA','SP_MONTA_PROVA', $params);
            //   var_dump($query[0]); exit();
              return $query;
    }
       
    function adicionar($p) {

        $data = array(
             'CD_PROVA' => $p['prova'],
             'CD_ALUNO' => $p['aluno'],
        'CD_DISCIPLINA' => $p['disciplina'],
            'NR_ACERTO' => $p['acerto'],
            'PC_ACERTO' => $p['p_acerto'],
              'NR_ERRO' => $p['erro'],
              'PC_ERRO' => $p['p_erro'],
              'NR_NOTA' => $p['nota'],
        );
        $this->db->insert('BD_SICA.AVAL_PROVA_ALUNO_DISC', $data); 
        $this->db->close();
    }
    
    function editar($p) {
        $data = array(
         'NR_ACERTO' => $p['acerto'],
         'PC_ACERTO' => $p['p_acerto'],
           'NR_ERRO' => $p['erro'],
           'PC_ERRO' => $p['p_erro'],
           'NR_NOTA' => $p['nota'],
        );
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('CD_DISCIPLINA', $p['disciplina']);
        $this->db->update('BD_SICA.AVAL_PROVA_ALUNO_DISC', $data); 
        $this->db->close();
    }
    
    function verificarTempo($p){
        
        $this->db->select('MIN(NR_TEMPO_PROVA) AS TEMPO'); 
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);
        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO')->result_array();
        $this->db->close();
        return $query;
    }
    /*Remoção de comentario $this->db->insert('BD_SICA.CL_ALU_NOTA', $data);*/
    function lancar_nota($p) {
        $data = array(
          'CD_ALU_DISC' => $p['alu_disc'],
             'NUM_NOTA' => $p['num_nota'],
                 'NOTA' => number_format($p['nota'],1,'.',''),
        );
        
       // $this->db->insert('BD_SICA.CL_ALU_NOTA', $data); 
       $this->db->close();
    }
    
    /*Remoção de comentario $this->db->update('BD_SICA.CL_ALU_NOTA', $data); */
    function editar_nota($p) {
        $data = array(
            'NOTA' => number_format($p['nota'],1,'.',''),
        );

        $this->db->where('CD_ALU_DISC', $p['alu_disc']);
        $this->db->where('NUM_NOTA', $p['num_nota']);
      //  $this->db->update('BD_SICA.CL_ALU_NOTA', $data); 
      $this->db->close();
    }
    
}