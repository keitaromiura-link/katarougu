<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Base extends CI_Migration {

        public function up()
        {
            //config
            $this->dbforge->add_field(array(
                'cfg_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 254,
                    'null' => false,
                    'comment' => '設定項目名'
                    ),
                'cfg_data' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '254',
                    'null' => false,
                    'comment' => '設定データ',
                ),
                'cfg_comment' => array(
                    'type' => 'varchar',
                    'constraint' => '254',
                    'null' => false,
                    'comment' => '設定コメント',
                ),
                'cfg_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => true,
                    'default' => null,
                    'comment' => '更新日時',
                ),
            ));
            $this->dbforge->add_key('cfg_name', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"設定テーブル"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('config', false, $attributes);


            $reg_val = [
                ['cfg_name' => 'now_game_id', 'cfg_data' => 0, 'cfg_comment' => '現在のゲームID', 'cfg_upd_timestamp' => date('Y-m-d H:i:s')],
            ];
            $this->db->insert_batch('config', $reg_val);

            //customer
            $this->dbforge->add_field(array(
                'cus_id' => array(
                    'type' => 'varchar',
                    'constraint' => 64,
                    'null' => false,
                    'comment' => '会員ID'
                ),
                'cus_ins_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '登録日時'
                ),
                'cus_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '更新日時'
                ),
            ));
            $this->dbforge->add_key('cus_id', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"会員テーブル"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('customer', false, $attributes);

            //session
            $this->dbforge->add_field(array(
                'id' => array(
                    'type' => 'varchar',
                    'constraint' => 40,
                    'null' => false,
                    'comment' => 'セッションID'
                ),
                'ip_address' => array(
                    'type' => 'varchar',
                    'constraint' => 45,
                    'null' => false,
                    'comment' => 'IPアドレス'
                ),
                'timestamp' => array(
                    'type' => 'int',
                    'constraint' => 10,
                    'unsigned' => true,
                    'null' => false,
                    'default' => 0,
                    'comment' => 'タイムスタンプ'
                ),
                'data' => array(
                    'type' => 'blob',
                    'null' => false,
                    'comment' => 'データ'
                ),
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_key('timestamp');
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"予約削除データテーブル"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('session', false, $attributes);

            //game
            $this->dbforge->add_field(array(
                'game_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'auto_increment' => true,
                    'comment' => 'ゲームID'
                ),
                'game_cus_id_parent' => array(
                    'type' => 'varchar',
                    'constraint' => 64,
                    'null' => false,
                    'comment' => '親（会員ID）'
                ),
                'game_cl_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'comment' => 'ゲームカタログID'
                ),
                'game_ins_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '登録日時'
                ),
                'game_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '更新日時'
                ),
            ));
            $this->dbforge->add_key('game_id', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"ゲーム"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('game', false, $attributes);

            //turn
            $this->dbforge->add_field(array(
                'turn_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'auto_increment' => true,
                    'comment' => 'ターンID'
                ),
                'turn_cus_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'comment' => '参加者ID'
                ),
                'turn_cli_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'comment' => '選択したカタログ項目ID'
                ),
                'turn_ins_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '登録日時'
                ),
                'turn_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '更新日時'
                ),
            ));
            $this->dbforge->add_key('turn_id', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"ターン"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('turn', false, $attributes);

            //catalog
            $this->dbforge->add_field(array(
                'cl_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'auto_increment' => true,
                    'comment' => 'カタログID'
                ),
                'cl_name' => array(
                    'type' => 'varchar',
                    'constraint' => 64,
                    'null' => false,
                    'comment' => 'カタログ名'
                ),
                'cl_ins_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '登録日時'
                ),
                'cl_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '更新日時'
                ),
            ));
            $this->dbforge->add_key('cl_id', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"カタログ"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('catalog', false, $attributes);

            //catalog_item
            $this->dbforge->add_field(array(
                'cli_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'auto_increment' => true,
                    'comment' => 'カタログ項目ID'
                ),
                'cli_cl_id' => array(
                    'type' => 'bigint',
                    'constraint' => 20,
                    'null' => false,
                    'comment' => 'カタログID'
                ),
                'cli_name' => array(
                    'type' => 'varchar',
                    'constraint' => 64,
                    'null' => false,
                    'comment' => 'カタログ項目名'
                ),
                'cli_ins_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '登録日時'
                ),
                'cli_upd_timestamp' => array(
                    'type' => 'datetime',
                    'null' => false,
                    'comment' => '更新日時'
                ),
            ));
            $this->dbforge->add_key('cl_id', TRUE);
            $attributes = array(
                'ENGINE' => 'InnoDB',
                'COLLATE' => 'utf8_general_ci',
                'DEFAULT CHARACTER SET' => 'utf8',
                'COMMENT' => '"カタログ項目"' //テーブルコメントはつねにダブルクォーテーションで囲む
            );
            $this->dbforge->create_table('catalog_item', false, $attributes);



        }

        public function down()
        {
            //config
            $this->dbforge->drop_table('config');
            //customer
            $this->dbforge->drop_table('customer');
            //session
            $this->dbforge->drop_table('session');
            //game
            $this->dbforge->drop_table('game');
            //turn
            $this->dbforge->drop_table('turn');
        }
}