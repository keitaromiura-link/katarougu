<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller {

    public function index()
    {
        $cus_name = "";
        if ($this->input->post("cus_name")){
            $cus_name = $this->input->post("cus_name");
        }

        $data = array(
            "cus_name" => $cus_name,
        );
        $this->load->view('index', $data);
    }

    public function join()
    {
        //入力チェック
        //名前
        if (!$cus_name = $this->input->post("cus_name")){
            //名前がなければエラーにする。
            $this->index();
        }

        //ランダムな文字列を設定する
        $cus_id = random_string("alnum", 32);
        $data = array(
            "cus_id" => $cus_id,
            "cus_name" => $cus_name,
            "cus_ins_timestamp" => date("Y-m-d H:i:s"),
            "cus_upd_timestamp" => date("Y-m-d H:i:s"),
        );
        $this->db->insert("customer", $data);
        //データベースを登録する
        $_SESSION["cus_id"] = $cus_id;

        redirect("top/mypage");
    }

    public function mypage()
    {

        if (!$_SESSION["cus_id"]) {
            //セッションがなければ
            redirect("top/index");
        }

        $query = $this->get_where("customer", array("cus_id" => $_SESSION["cus_id"]), 1);
        if ($query->num_rows() == 0) {
            //顧客データがなければ
            redirect("top/index");
        }

        //現在のゲームの設定
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

        $my = $query->row();
        $data = array(
            "my" => $my,
            "now_game_id" => $now_game_id,
            "game" => $game,
            "parant" => $parant,
            "catalog" => $catalog,
        );
        $this->load->view('mypage', $data);

    }

    public function login($cus_id = "")
    {
        //idがなければ、
        if (strlen($cus_id) == 0) {
            redirect("top/index");
        }

        $query = $this->get_where("customer", array("cus_id" => $cus_id), 1);
        if ($query->num_rows() == 0) {
            //顧客データがなければ
            redirect("top/index");
        }

        $_SESSION["cus_id"] = $cus_id;

        redirect("top/mypage");
    }
}
