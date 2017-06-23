<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_game extends CI_Migration {

    public function up()
    {
        //gameにターン数を追加
        $fields = array(
            'game_now_turn_number' => array(
                'type' => 'int',
                'constraint' => 10,
                'null' => false,
                'default' => 0,
                'comment' => 'ゲームの現ターン数D',
                'after' => 'game_cl_id'
            ),
        );
        //$this->dbforge->add_column("game", $fields);

        //customerに名前を追加
        $fields = array(
            'cus_name' => array(
                'type' => 'varchar',
                'constraint' => 64,
                'null' => false,
                'comment' => '名前',
                'after' => 'cus_id'
            ),
        );
        $this->dbforge->add_column("customer", $fields);

    }

    public function down()
    {
        //turn
        $this->dbforge->drop_column("game", 'game_now_turn_number');
        //customer
        $this->dbforge->drop_column("customer", 'cus_name');
    }
}