<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calculator extends CI_Controller {

    public function __construct(){ 
        parent::__construct();
        /*Loading migration */
        $this->load->library('migration');  
        /*Loading model file */
        $this->load->model('Calculator_Model','CM'); 
    }

    /*function for loading the calculator
    Routes baseurl/calculate
    */

    public function index()
	{
        /**Running migration  */
        $this->migration->current();
        /**Loading view of calculator */
		$this->load->view('calculator');
	}

    /*Function for calculating math expression */
    public function calculate_exp()
    {
        $exp=$this->input->post('exp');
        // echo $exp;exit;
        $answer =  eval('return '.$exp.';');
        //check whether the answer is numeric or not 
        if(is_numeric($answer)){
            echo json_encode(['answer'=>$answer,'status'=>"success"]);
        }else{
            echo json_encode(['status'=>"failure"]);
        }

        
    }

    /*Function for saving the expression and answer into the database table 'tbl_result' */
    public function calculate_save()
    {
        
        $exp= $this->input->post("exp");
        $ans= $this->input->post("ans"); 

        $data=array(
            'expression'=> $exp,
            'result'    => $ans
        );

        $result=$this->CM->calculate_save('tbl_result',$data);

        echo json_encode($result);

        

    }

    //Function for displaying last 5 calculations

    public function display_details()
    {
        $output = '';
        $a=1;

        $result=$this->CM->fetch_details();
        $output .='<table>
                    <th>Sl No.</th>
                    <th>Expression</th>
                    <th>Result</th>
                    ';

        foreach($result as $row)
        { 
            $output .= '<tr>
            <td>'.$a.'</td>
            <td>'.$row->expression.'</td>
            <td>'.$row->result.'</td>
            <tr>';
            $a++;
        }

        $output .='</table>';
        echo json_encode($output);
    }

    
}
