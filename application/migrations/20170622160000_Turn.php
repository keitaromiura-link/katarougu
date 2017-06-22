<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_turn extends CI_Migration {

    public function up()
    {
        //turn
        $fields = array(
            'turn_game_id' => array(
                'type' => 'bigint',
                'constraint' => 20,
                'null' => false,
                'comment' => 'ゲームID',
                'after' => 'turn_cus_id'
            ),
            'turn_number' => array(
                'type' => 'int',
                'constraint' => 10,
                'null' => false,
                'comment' => 'ターン数'
            ),
        );
        $this->dbforge->add_column("turn", $fields);
        $fields = array(
            'turn_cus_id' => array(
                'type' => 'varchar',
                'constraint' => 64,
            ),
        );
        $this->dbforge->modify_column("turn", $fields);
    }

    public function down()
    {
        //turn
        $this->dbforge->drop_column("turn", 'turn_game_id');
        $this->dbforge->drop_column("turn", 'turn_number');
        $fields = array(
            'turn_cus_id' => array(
                'type' => 'bigint',
                'constraint' => 20,
            ),
        );
        $this->dbforge->modify_column("turn", $fields);

    }
}