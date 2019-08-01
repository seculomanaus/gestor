<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Library Bloqueio_lib
 * Autor: Silvio de Souza
 * Email: silvio.souza@seculomanaus.com.br
 * Data: 09/05/2017
 * 
 */

class Bloqueio_lib {

    public $aluno;
    public $ip;
    public $maquina;
    public $prova;
    
    function verificacao() {
        $obj = & get_instance();
        $obj->load->model('prova_inscricao_model', 'inscricao', TRUE);

        // FAZ A VERIFICAÇÃO 
        $param = array(
            array('campo' => 'CD_ALUNO', 'valor' => $this->aluno),
            array('campo' => "TRUNC(DT_PROVA) = TO_DATE('".date('d/m/Y')."','DD/MM/YYYY')", 'valor' => ''),
            array('campo' => 'CD_PROVA_VERSAO', 'valor' => $this->prova),
        );

        $result = $obj->inscricao->filtrar($param);
        
        foreach($result as $r){
            if($r->NR_IP != ''){
                $ip      = $r->NR_IP;
                $maquina = $r->NM_MAQUINA;
            }
        }
            
        if($ip == ''){
            
            foreach($result as $rs){
                /* 
                 * 
                 * ATUALIZA O CAMPO DA TABELA
                 * NR_IP =  COM O IP DA MÁQUINA DO USUÁRIO
                 * NM_MAQUINA = COM O NOME DA MAQUINA DO USUÁRIO
                 * 
                 */
                $key = array(
                    array('campo' => 'CD_ALUNO', 'valor' => $rs->CD_ALUNO),
                    array('campo' => 'CD_PROVA', 'valor' => $rs->CD_PROVA),
                );
                $param = array(
                    array('campo' => 'NR_IP',      'valor' => $this->ip),
                    array('campo' => 'NM_MAQUINA', 'valor' => $this->maquina),
                );
                $obj->inscricao->editar($key,$param);
            }
            return (array('ip'=>$this->ip, 'maquina'=>$this->maquina, 'status'=>TRUE));
            
        }if($ip == $this->ip){
            // CASO SEJA A MESMA MAQUINA
            return (array('ip'=>$this->ip, 'maquina'=>$this->maquina, 'status'=>TRUE));
        }else{
            // CASO SEJA OUTRA MÁQUINA
            return (array('ip'=>$ip, 'maquina'=>$maquina, 'status'=>FALSE));
        }
    }
    
    function liberacao() {
        
        // LIBERA ALUNO PARA ATUALIZA A MAQUINA DELE
        $obj = & get_instance();
        $obj->load->model('prova_inscricao_model', 'inscricao', TRUE);

        // FAZ o select da prova e aluno
        $param = array(
            array('campo' => 'CD_ALUNO', 'valor' => $this->aluno),
            array('campo' => "TRUNC(DT_PROVA) = TO_DATE('".date('d/m/Y')."','DD/MM/YYYY')", 'valor' => ''),
            array('campo' => 'CD_PROVA_VERSAO', 'valor' => $this->prova),
        );
        $result = $obj->inscricao->filtrar($param);

        foreach($result as $rs){
            /* 
             * ATUALIZA O CAMPO DA TABELA
             * NR_IP =  COM O IP DA MÁQUINA DO USUÁRIO
             * NM_MAQUINA = COM O NOME DA MAQUINA DO USUÁRIO
             */
            $key = array(
                array('campo' => 'CD_ALUNO', 'valor' => $rs->CD_ALUNO),
                array('campo' => 'CD_PROVA', 'valor' => $rs->CD_PROVA),
            );
            $param = array(
                array('campo' => 'NR_IP',      'valor' => $this->ip),
                array('campo' => 'NM_MAQUINA', 'valor' => $this->maquina),
            );
            $obj->inscricao->editar($key,$param);
        }
        return TRUE;

    }
}

?>