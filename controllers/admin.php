<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Admin_Controller {

	protected $section = 'clients';

	function __construct() {
		parent::__construct();
		$this->lang->load( array("slider") );
		$this->load->driver('Streams');
		$this->load->model('slide_m');
	}

	function index() {
		$data['entries'] = $this->streams->entries->get_entries(array('stream' => 'slides', 'namespace' => 'slides'));
		$this->template->build('admin/index', $data);
	}

	function batch() {
		$ids = $this->input->post('action_to');
		// basic validation ...
		foreach ($ids as $key => $id) {
			if(!is_numeric($id)) unset($ids[$key]);
		}

		$message = '';
		$message_type = '';

		switch($this->input->post('btnAction')) {
			case 'publish':
				if($this->slide_m->batch_publish($ids)) {
					$message_type = 'success';
					$message = 'Die ausgewählten Slides wurden erfolgreich öffentlich geschaltet.';
				} else {
					$message_type = 'errorr';
					$message = 'Bei einer oder mehreren Slides ist beim veröffentlichen ein Fehler aufgetreten.';
				}
				break 1;
			case 'unpublish':
				if($this->slide_m->batch_unpublish($ids)) {
					$message_type = 'success';
					$message = 'Die ausgewählten Slides wurden erfolgreich als Entwurf markiert.';
				} else {
					$message_type = 'errorr';
					$message = 'Einer oder mehrere Slides konnten nicht als Entwurf markiert werden.';
				}
				break 1;
			case 'delete':
				if($this->slide_m->batch_delete($ids)) {
					$message_type = 'success';
					$message = 'Die ausgewählten Slides wurden erfolgreich gelöscht.';
				} else {
					$message_type = 'errorr';
					$message = 'Einer oder mehrere Slides konnten nicht gelöscht werden.';
				}
				break 1;
			default:
				$message_type = 'info';
				$message = 'Keine gültige Aktion.';
				break 1;
		}
		$this->session->set_flashdata($message_type, $message);
		redirect('admin/slider/');
	}

	function entries() {
		$this->index();
	}

	function create() {
		$data['create_form'] = $this->streams->cp->entry_form('slides', 'slides', $mode = 'new');
		$this->template->build('admin/create_entry', $data);
	}

	function edit( $id = null ) {
		$data['edit_form'] = $this->streams->cp->entry_form('slides', 'slides', $mode = 'edit', $id);
		$this->template->build('admin/edit_entry', $data);
	}

	function delete( $id = null ) {
		if( $this->slide_m->delete($id) ) {
			$this->session->set_flashdata('success', lang('slides.delete_success'));
		} else {
			$this->session->set_flashdata('error', lang('slides.delete_error'));
		}
		redirect('admin/slider/');
	}

}
