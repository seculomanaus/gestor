<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {
     
     function __construct() {
        parent::__construct();
        $this->load->model('usuarios_model', 'user', TRUE);
        $this->load->model('aluno_model', 'aluno', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session')); 
    }
    
    function index() {        
        redirect('usuario/login', 'refresh');
    }
    
    function login() {
        $this->load->view('usuario/login');
    }
    
    function acesso() {
        
        //remove all session data
        $this->session->unset_userdata('PVO_USER');
        $this->session->unset_userdata('PVO_NOME');
        $this->session->unset_userdata('PVO_CODIGO');
        $this->session->unset_userdata('PVO_PERIODO');
        
        $this->form_validation->set_rules('lguser', ' ', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lgpass', ' ', 'trim|required|xss_clean|callback_validar_usuario');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('usuario/login');
        } else {
            redirect('home/index', 'refresh');
        }
    }
    
    function validar_ip($lgpass) {

        $ip = $_SERVER['REMOTE_ADDR'];
        $p = explode('.',$ip);
        
        if ($p[0] != 10) {
            $this->form_validation->set_message('validar_ip', "<div class='alert alert-danger'>Máquina não cadastrada</div>");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function validar_usuario($lgpass) {
        
        $param = array(
            array('campo' => 'USU_LOGIN', 'valor' => $this->input->post('lguser')),
            array('campo' => 'USU_SENHA', 'valor' => $this->input->post('lgpass')),
            array('campo' => 'TIPO_TEXTO', 'valor' => 'ALUNO'),
        );
        $result = $this->aluno->pesquisar_id($param);
        
        if ($result == FALSE) {
            $this->form_validation->set_message('validar_usuario', "<div class='alert alert-danger'>Usuário / Senha Inválidos</div>");
            return FALSE;
        } else {

                $sess_array = array();
                $this->session->set_userdata('PVO_USER',    $result->USU_LOGIN);
                $this->session->set_userdata('PVO_NOME',    $result->USU_NOME);
                $this->session->set_userdata('PVO_CODIGO',  $result->USU_LOGIN);
                $this->session->set_userdata('PVO_PERIODO', $result->PERIODO);
                return true;

        }
    }    

    function logout() {

        //remove all session data
        $this->session->unset_userdata('PVO_USER');
        $this->session->unset_userdata('PVO_NOME');
        $this->session->unset_userdata('PVO_CODIGO');
        $this->session->unset_userdata('PVO_PERIODO');

        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    function error() {
         $this->load->view('layout/error');
    }
    
    function foto() {

        $parametro = array(
            'operacao' => 'FT',
            'usuario' => $this->input->get('codigo'),
        );
        $result = $this->user->acesso($parametro);

        if (empty($result[0]['FOTO'])) {
            header("Content-type: image/jpg");
            readfile(base_url('assets/images/user.png'));
        } else {
            header("Content-type: image/jpg");
            echo $result[0]['FOTO'];
        }
        exit();
    }
    
    function bmp() {
        
        $bmp = explode('--',base64_decode($this->input->get('bmp')));

        $parametro = array(
            'operacao' => 'FT',
            'usuario' => $bmp[0],
        );
        $result = $this->user->acesso($parametro);
        
        if (empty($result[0]['FOTO'])) {
            header("Content-type: image/jpg");
            readfile(base_url('assets/images/logo.png'));
        } else {
            header("Content-type: image/jpg");
            echo $result[0]['FOTO'];
        }
        exit();
    }

}