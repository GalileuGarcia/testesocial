<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Postagem
 *
 * @author G4lil3u
 */
class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('usuario'))) {
            redirect();
        }
        $this->load->model('Postagem_Model', 'postagem');
    }

    public function index() {
        
        
        
        $dados = [
            'postagens' => $this->postagem->postagens(),
            'ctrl' => $this
        ];

        $this->load->view('home', $dados);
    }
    
    public function curtidasPost($id_post) {
        $totCurt  = $this->postagem->curtidasPost($id_post);
        empty($totCurt) ? $curtidas = 0 : $curtidas = count($totCurt);
        
        return $curtidas;
    }
    
    public function comentariosPost($id_post) {
        $totCurt  = $this->postagem->comentariosPost($id_post);
        empty($totCurt) ? $comentarios = 0 : $comentarios = count($totCurt);
        
        return $comentarios;
    }

}
