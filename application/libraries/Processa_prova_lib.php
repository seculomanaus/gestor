<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Library Processa_prova_lib
 * Autor: Silvio de Souza
 * Email: silvio.souza@seculomanaus.com.br
 * Data: 15/06/2015
 * 
 * Retorna:
 * ----------------------------------------
 * 
 */

class Processa_prova_lib {

    public $prova;
    public $aluno;

    public function prova() {
        $obj = & get_instance();
        $obj->load->model('prova_questao_model', 'questao', TRUE);
        
        $a = array(
            'aluno'=>$this->aluno,
            'prova'=>$this->prova
        );

        // VERIFICA AS QUESTÕES DA PROVA
        $prova = $obj->questao->resultado($a);

        // SEPARA AS DISCIPLINAS, ACERTOS, ERROS, BRANCOS
        $resultado = array();
        
        foreach($prova as $p){
            // ARRAY CODIGO DA DISCIPLINA
            $resultado[$p['CD_DISCIPLINA']]['CODIGO'] = $p['CD_DISCIPLINA'];
            // ARRAY CODIGO DA PROVA
            $resultado[$p['CD_DISCIPLINA']]['PROVA'] = $p['CD_PROVA'];
            // ARRAY CODIGO DA NOTA (NUM_NOTA)
            $resultado[$p['CD_DISCIPLINA']]['NUM_NOTA'] = $p['NUM_NOTA'];
            // ARRAY CODIGO DO ALUNO
            $resultado[$p['CD_DISCIPLINA']]['ALUNO'] = $p['CD_ALUNO'];
            // ARRAY CODIGO DO ALUNO NA DISCIPLIA (CD_ALU_DISC)
            $resultado[$p['CD_DISCIPLINA']]['CD_ALU_DISC'] = $p['CD_ALU_DISC'];
            // ARRAY NOME DA DISCIPLINA
            $resultado[$p['CD_DISCIPLINA']]['DISCIPLINA'] = $p['NM_DISCIPLINA'];
            // ARRAY VALOR POR QUESTÃO DA DISCIPLINA
            $resultado[$p['CD_DISCIPLINA']]['VALOR'] = number_format($p['VL_QUESTAO'],4,'.','');
        }
        
        foreach($resultado as $res){
            // INICIA A VARIAVEL BRANCO COM 0;
            $resultado[$res['CODIGO']]['BRANCO'] = 0;
            // INICIA A VARIAVEL ACERTO COM 0;
            $resultado[$res['CODIGO']]['ACERTO'] = 0;
            // INICIA A VARIAVEL ERRO COM 0;
            $resultado[$res['CODIGO']]['ERRO'] = 0;
            
            foreach($prova as $p){

                if($res['CODIGO'] == $p['CD_DISCIPLINA']){

                    if($p['RESPOSTA'] == ''){
                        // SOMA AS QUESTÕES EM BRANCO
                        $resultado[$res['CODIGO']]['BRANCO'] = $resultado[$res['CODIGO']]['BRANCO'] + 1;
                        
                    }else if($p['RESPOSTA'] == $p['CORRETA']){
                        // SOMA AS QUESTÕES CORRETAS
                        $resultado[$res['CODIGO']]['ACERTO'] = $resultado[$res['CODIGO']]['ACERTO'] + 1;
                        
                    }else{
                        // SOMA AS QUESTÕES ERRADAS
                        $resultado[$res['CODIGO']]['ERRO'] = $resultado[$res['CODIGO']]['ERRO'] + 1;
                        
                    }
                    // QUANTIDADE TOTAL DE QUESTÕES
                    $resultado[$res['CODIGO']]['QTD']      = ($resultado[$res['CODIGO']]['ACERTO'] + $resultado[$res['CODIGO']]['ERRO'] + $resultado[$res['CODIGO']]['BRANCO']);
                    // NOTA DO ALUNO POR DISCIPLINA
                    $resultado[$res['CODIGO']]['NOTA']     = number_format(($resultado[$res['CODIGO']]['ACERTO'] * $resultado[$res['CODIGO']]['VALOR']),2,'.','');
                    // PERCENTUAL DE ACERTO
                    $resultado[$res['CODIGO']]['P_ACERTO'] = number_format((($resultado[$res['CODIGO']]['ACERTO'] * 100) / $resultado[$res['CODIGO']]['QTD']),1,'.','');
                    // PERCENTUAL DE ERRO
                    $resultado[$res['CODIGO']]['P_ERRO']   = number_format((($resultado[$res['CODIGO']]['ERRO'] * 100) / $resultado[$res['CODIGO']]['QTD']),1,'.','');
                }
            }
        }
                
        foreach($resultado as $res){
            $param = array(
                  'aluno' => $res['ALUNO'],
                  'prova' => $this->prova,//$res['PROVA'],
             'disciplina' => $res['CODIGO'],
                 'acerto' => $res['ACERTO'],
               'p_acerto' => $res['P_ACERTO'],
                   'erro' => $res['ERRO'],
                 'p_erro' => $res['P_ERRO'],
                   'nota' => $res['NOTA'],
            );
            $obj->questao->adicionar($param);
            $obj->questao->editar($param);

            $nota = array(
             'alu_disc' => $res['CD_ALU_DISC'],
             'num_nota' => $res['NUM_NOTA'],
                 'nota' => $res['NOTA'],
            );
            $obj->questao->lancar_nota($nota);
            
            //$obj->questao->editar_nota($nota);
            
        }
    }
}

?>