<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user_api_model extends CI_Model {

	public function get($id = null)
	{
        if ($id === null) {
            return $this->db->get('user')->result();
        }else {
            return $this->db->get_where('user', ['id_user' => $id])->row();
        }
	}

    public function delete($id) {
    $this->db->delete('user', ['id_user' => $id]);
    return $this->db->affected_rows();
   }

   public function created($data)  {
      $this->db->insert('user',$data);
      return $this->db->affected_rows();
   }

   public function updated($data, $id)  {
    $this->db->update('user', $data, ['id_user' => $id]);
    return $this->db->affected_rows();
 }
}
