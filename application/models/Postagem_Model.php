<?php

/**
 * Description of Postagem_Model
 *
 * @author G4lil3u
 */
class Postagem_Model extends CI_Model {

    private $table = 'post';

    public function insere($post) {
        $this->db->insert($this->table, array(
            'id_usuario' => 1,
            'texto' => $post
        ));
    }

    public function insereComentario($id_post, $comentario) {
        $this->db->insert('comentarios', array(
            'id_usuarios' => $this->session->userdata('usuario')['id_usuarios'],
            'id_post' => $id_post,
            'comentario' => $comentario
        ));
    }

    public function comentarios($id_post) {
        $this->db->join('usuarios u', 'u.id_usuarios = c.id_usuarios');
        $this->db->where(array(
            'c.id_post' => $id_post
        ));
        $this->db->order_by('c.id_comentarios', 'DESC');
        return $this->db->get('comentarios c')->result();
    }

    public function comentariosPost($id_post) {
        $this->db->where(array(
            'id_post' => $id_post
        ));
        return $this->db->get('comentarios')->result();
    }

    public function ultimaPostagem() {
        $this->db->where(array(
            'id_usuario' => $this->session->userdata('usuario')['id_usuarios']
        ));
        $this->db->order_by('id_post', 'DESC');
        return $this->db->get($this->table)->row_array();
    }

    public function postagens() {
        $this->db->join('usuarios u', 'u.id_usuarios = a.id_usuario');
        $this->db->order_by('a.id_post', 'DESC');
        return $this->db->get('post a')->result();
    }

    public function curtidasPost($id_post) {
        $this->db->where(array(
            'id_post' => $id_post
        ));
        return $this->db->get('curtidas')->result();
    }

    private function verificaLike() {
        $this->db->where(array(
            'id_usuario_curtiu' => $this->session->userdata('usuario')['id_usuarios'],
        ));

        return $this->db->get('curtidas')->row_array();
    }

    private function verificaLikePost($post) {
        $this->db->where(array(
            'id_post' => $post,
            'id_usuario_curtiu' => $this->session->userdata('usuario')['id_usuarios'],
        ));

        return $this->db->get('curtidas')->row_array();
    }

    public function inserecurtidas($post) {
        $jacurtiu = $this->verificaLike($post);

        if (empty($jacurtiu)) {
            $this->db->insert('curtidas', array(
                'id_usuario_curtiu' => $this->session->userdata('usuario')['id_usuarios'],
                'id_post' => $post
            ));
        } else {
            $likePost = $this->verificaLikePost($post);
 
            if (empty($likePost)) {
                $this->db->insert('curtidas', array(
                    'id_usuario_curtiu' => $this->session->userdata('usuario')['id_usuarios'],
                    'id_post' => $post
                ));
            } else {
                $this->db->where(array(
                    'id_post' => $post,
                    'id_usuario_curtiu' => $this->session->userdata('usuario')['id_usuarios'],
                ));
                $this->db->delete('curtidas');
            }
        }
    }

}
