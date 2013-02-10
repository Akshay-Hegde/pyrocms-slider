<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_settings extends Admin_Controller {

	protected $section = 'slider_settings';

	function __construct() {
		parent::__construct();
		$this->lang->load( array("slider") );
		$this->load->driver('Streams');
		$this->load->model('slide_m');
	}

	function index() {
		$this->template->build('admin/settings_index');
	}


}
