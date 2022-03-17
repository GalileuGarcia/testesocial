<?php

/**
 * Description of Login
 *
 * @author G4lil3u
 */
class Login extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('Login_Model', 'login');
    }
    
    public function index() {
        $this->load->view('login');
    }
    
    public function acessar() {
        $usuario = $this->input->post('usuario', TRUE);
        $senha = base64_encode($this->input->post('senha', TRUE));
        
        $login = $this->login->login($usuario, $senha);
        
        if (!empty($login)) {
            $this->session->set_userdata('usuario', $login);
            redirect('perfil');
        } else {
            redirect();
        }
        
    }
    
    public function logout() {
        $this->session->unset_userdata('usuario');
        redirect();
    }
    
}
