<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    public function index()
    {
        $this->manage();
    }
    public function manage()
    {
        //現在のゲームIDを取得する
        $query = $this->db->get_where('config', array('cfg_name' => 'now_game_id'), 1);
        $row = $query->row();
        $now_game_id = (int) $row->cfg_data;

        //ゲームIDが存在すれば
        $game = null;
        $parant = null;
        $catalog = null;
        if ($now_game_id > 0) {
            //現在のゲームと親とカタログの状況を表示する
            $query = $this->db->get_where('game', array('game_id', $now_game_id), 1);
            $game = $query->row();
            $query = $this->db->get_where('customer', array('cus_id', $game->game_cus_id_parent), 1);
            $parant= $query->row();
            $query = $this->db->get_where('catalog', array('cl_id', $game->game_cl_id), 1);
            $catalog= $query->row();
        }else {
            //何も表示しない
        }

        //ゲームスタートからのリダイレクトの場合
        $game_start_error = 0;
        if (isset($_SESSION['game_start_error'])) {
            $game_start_error = $_SESSION['game_start_error'];
        }

        //ゲームリダイレクトからの場合
        $game_start_success = false;
        if (isset($_SESSION['game_start_success'])) {
            $game_start_success= $_SESSION['game_start_success'];
        }
        //Viewへ
        $data = array(
            "game_start_error" => $game_start_error,
            "game_start_success" => $game_start_success,
            "now_game_id" => $now_game_id,
            "game" => $game,
            "parant" => $parant,
            "catalog" => $catalog,
        );
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
            $_SESSION['game_start_error'] = 110;
            $this->session->mark_as_flash('game_start_error');
            //何もしないでgame/manageへリダイレクトさせる
            redirect("game/manage");
        }
        //現在の参加者を取得する
        $query = $this->db->get('customer');
        //参加者が居なければリダイレクト
        if ($query->num_rows() == 0) {
            $_SESSION['game_start_error'] = 200;
            $this->session->mark_as_flash('game_start_error');
            redirect("game/manage");
        }
        //現在の参加者からランダムでデータを取ってくる
        $members = $query->result();
        $parent = array_rand($members);
        //カタログデータからランダムで一つ決定する
        $query = $this->db->order_by(23, 'RANDOM')->get('catalog',1);
        //カタログがなければリダイレクト
        if ($query->num_rows() == 0) {
            $_SESSION['game_start_error'] = 300;
            $this->session->mark_as_flash('game_start_error');
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
            $_SESSION['game_start_error'] = 999;
            $this->session->mark_as_flash('game_start_error');
            redirect("game/manage");
        }

        $_SESSION['game_start_success'] = true;
        $this->session->mark_as_flash('game_start_success');
        redirect("game/manage");
    }

}
