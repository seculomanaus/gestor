<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Model extends CI_Model {

    var $tabela = "";
    var $view = "";

    function __construct() {
        parent:: __construct();
        $this->load->database();
    }

    // FUNÇÃO PARA PEGAR O ULTIMO ID
    function max($campo) {

        $this->db->select(' MAX(' . $campo . ') as id');
        $result = $this->db->get($this->view)->row();
        return $result->ID;
    }

    // FUNÇÃO PARA IR FILTRANDO 
    // ATRASVÉS DOS CAMPOS DA TABELA
    // RETORNA UMA ROW
    function filtro_id($param) {

        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            $this->db->where($p['campo'], $p['valor']);
        }
        $result = $this->db->get($this->view)->row();

        return $result;
    }

    // FUNCAO PARA UM UNICO REGISTRO
    // ATRASVÉS DO ID
    // RETORNA APENAS UMA LINHA DA TABELA
    function pesquisar_id($param) {
        if (is_array($param) == NULL) {
            return NULL;
        } else {
            foreach ($param as $p) {
                if ($p['valor'] != '') {
                    $this->db->where($p['campo'], $p['valor']);
                } else {
                    $this->db->where($p['campo']);
                }
            }
        }
        $result = $this->db->get($this->view)->row();
        return $result;
    }

    // FUNCAO PARA LISTAR
    // TODOS OS REGISTROS
    // DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function listar($param = NULL) {
        if (!is_array($param) == NULL) {
            $this->db->order_by($param['campo'], $param['ordem']);
        }
        $result = $this->db->get($this->view)->result_object();
        return $result;
    }

    // FUNCAO PARA LISTAR
    // TODOS OS REGISTROS COM CLAUSULAS 'or'
    // DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function listar_or($param = NULL) {
        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            if ($p['valor'] != '') {
                $this->db->or_where($p['campo'], $p['valor']);
            }
        }
        $result = $this->db->get($this->view)->result_object();

        return $result;
    }

    // FUNCAO PARA LISTAR 
    // TODOS OS REGISTROS
    // DA TABELA COM LIMITES
    // RETORNA UM OBJETO/ARRAY 
    function limitar($param = NULL, $limite = NULL) {
        if (!is_array($param) == NULL) {
            $this->db->order_by($param['campo'], $param['ordem']);
        }
        $this->db->limit($limite['inicio'], $limite['fim']);
        $result = $this->db->get($this->view)->result_object();
        return $result;
    }

    // FUNÇÃO PARA IR FILTRANDO 
    // ATRASVÉS DOS CAMPOS DA TABELA
    // RETORNA UM OBJETO/ARRAY 
    function filtrar($param) {

        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            if ($p['valor'] != '') {
                $this->db->where($p['campo'], $p['valor']);
            } else {
                $this->db->where($p['campo']);
            }
        }
        $result = $this->db->get($this->view)->result_object();
        //echo $this->db->last_query();
        return $result;
    }

    // FUNCAO PARA INSERIR
    function inserir($data) {

        $res = $this->db->insert($this->table, $data);
        if ($this->db->affected_rows() > 0) {
            return (true);
        } else {
            //echo $this->db->_error_message(); 
            return (false);
        }
    }

    // FUNCAO PARA EDITAR
    function editar($key, $param) {

        if (is_array($key) == NULL || is_array($param) == NULL) {
            return NULL;
        }
        // PEGA OS VALOR A SEREM ATUALIZADOS
        foreach ($param as $p) {
            $this->db->set($p['campo'], $p['valor']);
        }
        
        // PEGA A CHAVE DA TABELA
        foreach ($key as $k) {
            $this->db->where($k['campo'], $k['valor']);
        }
        $res = $this->db->update($this->table);
        
        //echo $this->db->last_query();

        if ($res) {
            return (true);
        } else {
            return (false);
        }
    }

    // FUNCAO PARA DELETAR
    function deletar($param) {
        if (is_array($param) == NULL) {
            return NULL;
        }
        foreach ($param as $p) {
            $this->db->where($p['campo'], $p['valor']);
        }
        $res = $this->db->delete($this->table);

        if ($res) {
            return (true);
        } else {
            return (false);
        }
    }

}
