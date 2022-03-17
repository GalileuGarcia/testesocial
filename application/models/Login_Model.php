<?php

/**
 * Description of Login_Model
 *
 * @author G4lil3u
 */
class Login_Model extends CI_Model{
    
    public function login($usuario, $senha) {
        $this->db->where(array(
            'usuario' => $usuario,
            'senha' => $senha
        ));
        
        return $this->db->get('usuarios')->row_array();
    }
    
}
