<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examples extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function _example_output($output = null)
	{
		$this->load->view('example.php',(array)$output);
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function catalog_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('catalog');
			$crud->columns('cl_id','cl_name','cl_ins_timestamp','cl_upd_timestamp');
			$crud->display_as('cl_id','カタログID')
			     ->display_as('cl_name','カタログ名')
			     ->display_as('cl_ins_timestamp','登録日時')
			     ->display_as('cl_upd_timestamp','更新日時')
			;
			$crud->set_subject('カタログ');

			$crud->required_fields('cl_name');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function customers_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('customer');
			$crud->columns('cus_id','cus_name','cus_ins_timestamp','cus_upd_timestamp');
			$crud->display_as('cus_id','会員番号')
    			->display_as('cus_name','名前')
				 ->display_as('cus_ins_timestamp','登録日時')
				 ->display_as('cus_upd_timestamp','更新日時');
			$crud->set_subject('customer');
			$crud->required_fields('cus_name');
			$output = $crud->render();

			$this->_example_output($output);
	}

	public function catalog_item_management()
	{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('catalog_item');
			$crud->columns('cli_id','cli_cl_id','cli_name','cli_ins_timestamp','cli_upd_timestamp');
			$crud->display_as('cli_id','カタログ項目ID')
			->display_as('cli_cl_id','カタログ名')
			->display_as('cli_name','カタログ項目名')
			->display_as('cli_ins_timestamp','登録日時')
			->display_as('cli_upd_timestamp','更新日時')
			;
			$crud->set_relation('cli_cl_id','catalog','cl_name');
			$crud->set_subject('カタログ項目');

			$crud->required_fields('cli_cl_id');
			$crud->required_fields('cli_name');

			$output = $crud->render();

			$this->_example_output($output);
	}

	public function game()
	{
	    $crud = new grocery_CRUD();

	    $crud->set_theme('datatables');
	    $crud->set_table('game');
	    $crud->columns('game_id','game_cus_id_parent','game_now_turn_number','game_cl_id','game_ins_timestamp','game_upd_timestamp');
	    $crud->display_as('game_id','ゲームID')
	    ->display_as('game_cus_id_parent','親')
	    ->display_as('game_now_turn_number','現在のターン数')
	    ->display_as('game_cl_id','カタログ名')
	    ->display_as('game_ins_timestamp','登録日時')
	    ->display_as('game_upd_timestamp','更新日時')
	    ;
	    $crud->set_relation('game_cl_id','catalog','cl_name');
	    $crud->set_relation('game_cus_id_parent','customer','cus_name');
	    $crud->set_subject('ゲーム');

	    $crud->required_fields('game_cus_id_parent');
	    $crud->required_fields('game_now_turn_number');
	    $crud->required_fields('game_cl_id');

	    $output = $crud->render();

	    $this->_example_output($output);
	}

	public function turn()
	{
	    $crud = new grocery_CRUD();

	    $crud->set_theme('datatables');
	    $crud->set_table('turn');
	    $crud->columns('turn_id','turn_cus_id','turn_cli_id','turn_game_id','turn_number','turn_ins_timestamp','turn_upd_timestamp');
	    $crud->display_as('turn_id','ターンID')
	    ->display_as('turn_cus_id','参加者')
	    ->display_as('turn_cli_id','選択したカタログ項目名')
	    ->display_as('turn_game_id','ゲームID')
	    ->display_as('turn_number','ターン数')
	    ->display_as('turn_ins_timestamp','登録日時')
	    ->display_as('turn_upd_timestamp','更新日時')
	    ;
	    $crud->set_relation('turn_cli_id','catalog_item','cli_name');
	    $crud->set_relation('turn_cus_id','customer','cus_name');
	    $crud->set_relation('turn_game_id','game','game_id');
	    $crud->set_subject('ターン');

	    $crud->required_fields('turn_cus_id');
	    $crud->required_fields('turn_cli_id');
	    $crud->required_fields('turn_game_id');
	    $crud->required_fields('turn_number');

	    $output = $crud->render();

	    $this->_example_output($output);
	}
}
