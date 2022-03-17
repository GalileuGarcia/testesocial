<?php

/**
 * Description of Postagem
 *
 * @author G4lil3u
 */
class Postagem extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Postagem_Model', 'postagem');
    }

    public function post() {
        $post = $this->input->post('post');

        $this->postagem->insere($post);

        echo json_encode(array(
            'situacao' => TRUE
        ));
    }

    public function enviaComentario() {
        $id_post = $this->input->post('id_post');
        $comentario = $this->input->post('comentario');

        $this->postagem->insereComentario($id_post, $comentario);

        echo json_encode(array(
            'html' => $this->htmlComentario($id_post),
            'post' => $id_post,
            'comentarios' => $this->comentariosPost($id_post),
            'situacao' => TRUE
        ));
    }

    public function comentario() {
        $id_post = $this->input->post('post');

        echo json_encode(array(
            'html' => $this->htmlComentario($id_post),
            'post' => $id_post,
            'situacao' => TRUE
        ));
    }

    public function curtidas($id_post) {
        $totCurt = $this->postagem->curtidasPost($id_post);
        empty($totCurt) ? $curtidas = 0 : $curtidas = count($totCurt);

        return $curtidas;
    }

    public function like() {
        $id_post = $this->input->post('post');
        $this->postagem->inserecurtidas($id_post);

        echo json_encode(array(
            'likes' => $this->curtidas($id_post),
            'post' => $id_post,
            'situacao' => $this->curtidas($id_post) == 0 ? FALSE : TRUE
        ));
    }

    private function htmlComentario($id_post) {
        $comentarios = $this->postagem->comentarios($id_post);
        $html = '<div class="comentarios-box comm">';
        if (!empty($comentarios)) {
            foreach ($comentarios as $comentario) {
                $html .= '<p style="background-color: #424242; border-radius: 25px; padding: 2%;">';
                $html .= '<span><b>' . $comentario->nome . '</b></span><br>';
                $html .= $comentario->comentario;
                $html .= '</p>';
            }

            $html .= '</div>';
        } else {
            $html .= '</p> Nenhum comentário encontrado </p>';
        }
        $html .= '</div>';
        return $html;
    }

    public function comentariosPost($id_post) {
        $totCurt = $this->postagem->comentariosPost($id_post);
        empty($totCurt) ? $comentarios = 0 : $comentarios = count($totCurt);

        return $comentarios;
    }


}
