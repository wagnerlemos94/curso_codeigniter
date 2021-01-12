<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Core_Model extends CI_Model{

    public function get_all($tabela = NULL, $condicao = NULL){

        if($tabela){

            if(is_array($condicao)){
                
                $this->db->where($condicao);
            }

            return $this->db-get($tabela)->result();


        }else{
            return FALSE;
        }

    }


    public fuction get_by_id($tabela = NULL, $condicao = NULL){

        if($tabela && is_array($condicao)){
            $this->db->where($condicao);
            $this->db->limit(1);

            return $this->db-get($tabela)->row();
        }else{
            return FALSE;
        }

    }

    public function insert($tabela = NULL, $data = NULL, $gete_last_id = NULL){
        if($tabela && is_array($data)){
            $this->db->insert($tabela, $data);

            if($gete_last_id){
                $this->session->set_userdata('last_id', $this->db->insert_id());
            }

            if($this->db->affected_rows() > 0 ){

                $this->session->set_flashdata('sucesso', 'Dados salvo com sucesso');

            }else{

                $this->session->set_flashdata('erro', 'Erro ao salvar dados')

            }

        }else{

        }
    }

    public function update($tabela = NULL, $data = NULL, $condicao = NULL){

        if($tabela && is_array($data) && is_array($condicao)){
            
            if($this->update->($tabela, $data, $condicao)){
                $this->session->set_flashdata('sucesso', "Dados salvo com sucesso");
            }else{
                $this->session->set_flashdata('erro', 'Erro ao atualizar os dados')
            }

        }else{
            return FALSE;
        }

    }

    public function delete($tabela = NULL, $condicao){

        $this->db->db_debug = FALSE;

        if($tabela && is_array($condicao)){
            $status = $this->db->delete($tabela, $condicao);

            $erro = $this->db->error();

            if(!$status){
                foreach($erro as $code){
                    if($code == 1451){
                        $this->session->set_flashdata('erro', 'Esse registro não poderar ser excluido, pois está sendo utilizado em outra tabela');
                    }
                }
            }else{
                $this->session->set_flashdata('sucesso', 'Registro excluirdo com sucesso');
            }
            $this->db->db_debug = FALSE;

        }else{
            return FALSE;
        }

    }


}