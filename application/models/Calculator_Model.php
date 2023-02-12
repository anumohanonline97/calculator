<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calculator_Model extends CI_Model {

  /*Function for inserting expression and answer into the table*/
  function calculate_save($table, $data){
 
    $ins=$this->db->insert($table, $data);
    // echo  $ins;exit;
    if($ins)
    {
        $in=$this->db->insert_id();
        //  echo  $in;exit;
        return $in;
    }
    else
        return 0;
  }

  /*Function for displying  last 5 calculations*/

  public function fetch_details()
  {
    $this->db->select('*');
    $this->db->from('tbl_result');
    $this->db->order_by('id','desc');
    $this->db->limit('5');
    $query=$this->db->get();
    $data=$query->result();
    return $data;
  }


}