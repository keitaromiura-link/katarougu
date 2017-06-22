<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    public function index()
    {
        $this->manage();
    }
    public function manage()
    {
        $query = $this->db->get_where('config', array('cfg_name' => 'now_game_id'), 1);
        $row = $query->row();
        $now_game_id = (int) $row->cfg_data;
        $this->load->view('game_manage');
    }
    public function start()
    {
        $this->db->trans_start();
        //ゲームが始まっていないかチェック
        $query = $this->db->get_where('config', array('cfg_name' => 'now_game_id'), 1);
        $row = $query->row();
        $now_game_id = (int) $row->cfg_data;
        if ($now_game_id > 0) {
            //何もしないでgame/manageへリダイレクトさせる
            redirect("game/manage");
        }
        //現在の参加者を取得する
        $query = $this->db->get('customer');
        //参加者が居なければリダイレクト
        if ($query->num_rows() == 0) {
            redirect("game/manage");
        }
        //現在の参加者からランダムでデータを取ってくる
        $members = $query->result();
        $parent = array_rand($members);
        //カタログデータからランダムで一つ決定する
        $query = $this->db->order_by(23, 'RANDOM')->get('catalog',1);
        //カタログがなければリダイレクト
        if ($query->num_rows() == 0) {
            redirect("game/manage");
        }
        $catalog = $query->row();
        //ゲームデータを作成する
        $data = array(
            "game_cus_id_parent" => $parent->cus_id,
            "game_cl_id" => $catalog->cl_id,
            "game_ins_timestamp" => date("Y-m-d H:i:s"),
            "game_upd_timestamp" => date("Y-m-d H:i:s"),
        );
        $this->db->insert("game", $data);
        $game_id = $this->db->insert_id();
        //ターンデータを作成する
        $data = array();
        foreach ($members as $member) {
            for ($i = 1; $i <= 7; $i++) {
                $tmp = array(
                    "turn_cus_id" => $member->cus_id,
                    "turn_cli_id" => 0,//デフォルトは0
                    "turn_game_id" => $game_id,
                    "turn_number" => $i,
                    "turn_ins_timestamp" => date("Y-m-d H:i:s"),
                    "turn_upd_timestamp" => date("Y-m-d H:i:s"),
                );
                array_push($data, $tmp);
            }

            $this->db->insert_batch("game", $data);
        }
        //configの現在のゲームIDを変更する
        $this->db->where('cfg_name', "now_game_id")->update("config", array('cfg_data' => $game_id));

        //トランザクション
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            redirect("game/manage");
        }
    }

}
