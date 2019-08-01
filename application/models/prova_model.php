<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();

        //$this->table = 'BD_SICA.ALUNO';
        // $this->view = 'BD_SICA.VW_AVAL_PROVA_INSCRITOS';
    }

    function lista($p) {

        //$this->db->select('P.*, I.*, T.DC_TIPO_PROVA, (BD_SICA.F_AVAL_PROVA_DISCIPLINAS(P.CD_PROVA)) AS DISCIPLINAS');
        $this->db->where('CD_ALUNO', $p['aluno']);
        $this->db->where('FL_FORMATO', 'O');
        //$this->db->where('P.PERIODO', $p['periodo']);
        $this->db->where('DT_PROVA', date('d-M-Y'));
        //$this->db->where('DT_PROVA', '20-MAR-2017');
        $this->db->order_by('CD_PROVA', 'ASC');
        //$this->db->join('BD_SICA.AVAL_PROVA_INSCRITOS I', 'P.CD_PROVA = I.CD_PROVA');
        //$this->db->join('BD_SICA.AVAL_TIPO_PROVA T', 'P.CD_TIPO_PROVA = T.CD_TIPO_PROVA');
        $query = $this->db->get('BD_SICA.VW_AVAL_PROVA_INSCRITOS')->result_object();

        //echo $this->db->last_query();
        return $query;
    }

    function exibeNota($p=null){

        return $this->db->query("SELECT FLG_EXIBE_RESULTADO FROM BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO WHERE
                                 CD_PROVA_VERSAO = '".$p['prova']."' AND CD_ALUNO = '".$p['aluno']."' AND ROWNUM < 2");
    }

    function filtro($p) {
        $this->db->where('CD_PROVA', $p['codigo']);
        $query = $this->db->get('BD_SICA.AVAL_PROVA')->row();
        return $query;
    }

    function qtdeQuestoes($p) {
        $this->db->select('PQ.CD_PROVA');
        $this->db->where('P.DT_PROVA', date('d-M-Y'));
        $this->db->where('A.CD_ALUNO', $p['aluno']);
        $this->db->where('Q.FLG_TIPO', 'O');
        $this->db->order_by('PQD.POSICAO_INICIAL', 'ASC');
        $this->db->join('BD_SICA.AVAL_PROVA_INSCRITOS PI', 'PQ.CD_PROVA = PI.CD_PROVA');
        $this->db->join('BD_SICA.AVAL_PROVA P', 'PQ.CD_PROVA = P.CD_PROVA');
        $this->db->join('BD_SICA.ALUNO A', 'A.CD_ALUNO = PI.CD_ALUNO');
        $this->db->join('BD_ACADEMICO.AVAL_QUESTAO Q', 'PQ.CD_QUESTAO = Q.CD_QUESTAO');
        $this->db->join('BD_SICA.AVAL_PROVA_DISC PQD', 'PQD.CD_PROVA = PQ.CD_PROVA AND PQD.CD_DISCIPLINA = Q.CD_DISCIPLINA', 'left');
        $this->db->join('BD_SICA.CL_DISCIPLINA D', 'D.CD_DISCIPLINA = Q.CD_DISCIPLINA');
        //$this->db->group_by('PQ.CD_PROVA');

        $query = $this->db->get('BD_SICA.AVAL_PROVA_QUESTOES PQ')->result_array();

        echo $query;
    }

    function verificaAvalConcluida($p) {
        $this->db->select('CD_PROVA');
        $this->db->where('CD_PROVA', $p['prova']);
        $this->db->where('CD_ALUNO', $p['aluno']);

        $query = $this->db->get('BD_SICA.AVAL_PROVA_ALUNO_QUESTAO')->result_array();

        echo $query;
    }

    /**
     * Função que irá retornar o tempo da prova.
     * 
     * @param int $codigo
     * @return string
     */
    function tempo($codigo) {
        //obter o horário da prova
        $prova = $this->prova->filtro(array(
            'codigo' => $codigo
        ));

        $inicio = $prova->HR_INICIO;
        $fim = $prova->HR_FIM;

        $horaInicio = new DateTime($inicio);
        $horaFim = new DateTime($fim);
        $horaAtual = new DateTime();

        $tempo = 0;
        if ($horaAtual > $horaInicio) {
            $tempo = $horaFim->diff($horaAtual);
        } else {
            $tempo = $horaFim->diff($horaInicio);
        }

        //return ($tempo === null) ? "" : $tempo->format("%H:%i:%s");
    
        return $tempo->format("%H:%i:%s");
    }

    /**
     * Registra a presenca e o tempo da ultima acao em prova
     * 
     * @param array $params Vetor com a estrutura:
     * array(
     *      CD_PROVA => <int>,
     *      CD_ALUNO => <int>,
     *      HR_ULTIMA_ACAO => <string>
     * );
     */
    function registrarUltimaAcao($params) {
        $this->db->set("HR_ULTIMA_ACAO", $params['HR_ULTIMA_ACAO']);
        
        $this->db->where("CD_PROVA", $params['CD_PROVA']);
        $this->db->where("CD_ALUNO", $params['CD_ALUNO']);
        
        return $this->db->update("BD_SICA.AVAL_PROVA_INSCRITOS");
    }

    /**
     * Obtem o tempo da ultima acao realizada na prova.
     * 
     * @param array $params Vetor com a estrutura:
     * array(
     *      prova => <int>,
     *      aluno => <int>
     * );     
     */
    function getUltimaAcao($params) {
        $this->db->select("HR_ULTIMA_ACAO AS TEMPO");
        $this->db->from("BD_SICA.AVAL_PROVA_INSCRITOS");
        $this->db->where("CD_PROVA", $params['prova']);
        $this->db->where("CD_ALUNO", $params['aluno']);        
        
        $query = $this->db->get();
        return $query->row();
    }

    function getMinutoLiberaBtn($params){

        $this->db->select("MIN_LIBERACAO");
        $this->db->from("BD_SICA.AVAL_PROVA");
        $this->db->where("CD_PROVA", $params['CD_PROVA']);
        $query = $this->db->get();
        return $query->row();

    }
}
