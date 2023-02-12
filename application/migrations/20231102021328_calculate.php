<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
class Migration_Calculate extends CI_Migration { 
    public function up() { 
            $this->dbforge->add_field(array(
            'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
            ),
            'expression' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ),
            'result' => array(
                    'type' => 'FLOAT',
                    'null' => TRUE
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tbl_result');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_result');
    }
}