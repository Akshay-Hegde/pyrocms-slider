<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Slider extends Module {

	public $version = '1.0';

	public function info() {
		return array(
			'name' => array(
				'en' => 'Slider',
				'de' => 'Slider',
			),
			'description' => array(
				'en' => 'The clients module lets you create Clients and manage their data.',
				'de' => 'Mit dem Slider-Modul können Sie Bilder hochladen und diese im Karussel anzeigen lassen.',
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content',
		    'sections' => array(
			    'clients' => array(
				    'name' => 'slides.section_title',
				    'uri' => 'admin/slider/',
				    'shortcuts' => array(
				    	array(
							'name' => 'slides.add_shortcut',
							'uri' => 'admin/slider/create',
							'class' => 'add'
						)
				    ),
				),
			),
		);
	}

	public function install() {
		/*
			Clean up.
		 */
		$this->dbforge->drop_table('slides');
		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('slides');
		if ($this->db->table_exists('data_streams')) {
			$this->db->where('stream_namespace', 'slides')->delete('data_streams');
		}

		/*
			Add the stuff!
		 */

		$this->load->library("files/files");
		$new_folder = Files::create_folder(0, "slides_images");
		$new_folder_id = (isset($new_folder['data']['id'])) ? $new_folder['data']['id'] : 0;

		$this->streams->streams->add_stream('lang:slides:slides.section_title', 'slides', 'slides', null, null);
		$slides_fields = array(
				array(
					'name'          => 'Beschriftung',
			        'slug'          => 'label',
			        'namespace'     => 'slides',
			        'type'          => 'text',
			        'extra'         => array('max_length' => 255),
			        'assign'        => 'slides',
			        'title_column'  => true,
			        'required'      => true,
			        'unique'        => false
				),
				array(
					'name'          => 'Status',
			        'slug'          => 'status',
			        'namespace'     => 'slides',
			        'type'          => 'choice',
			        'extra'         => array('choice_data' => "Live\nDraft", 'choice_type' => 'dropdown', 'default_value' => 'Draft'),
			        'assign'        => 'slides',
			        'title_column'  => false,
			        'required'      => true,
			        'unique'        => false
				),
				array(
					'name'          => 'Bild',
			        'slug'          => 'image',
			        'namespace'     => 'slides',
			        'type'          => 'image',
			        'extra'         => array('folder' => $new_folder_id, 'allowed_types' => 'jpg|jpeg|png'),
			        'assign'        => 'slides',
			        'title_column'  => false,
			        'required'      => true,
			        'unique'        => false
				),
				array(
					'name'          => 'URL',
			        'slug'          => 'link',
			        'namespace'     => 'slides',
			        'type'          => 'url',
			        'assign'        => 'slides',
			        'title_column'  => false,
			        'required'      => false,
			        'unique'        => false
				),
				array(
					'name'          => 'Plakette',
			        'slug'          => 'ribbon',
			        'namespace'     => 'slides',
			        'type'          => 'text',
			        'extra'         => array('max_length' => 255),
			        'assign'        => 'slides',
			        'title_column'  => false,
			        'required'      => false,
			        'unique'        => false
				),

		);
		$this->streams->fields->add_fields($slides_fields);

		return true;
	}

	public function uninstall() {
		/*
			Delete the slides folder
			get folder ID from assigned field?
			...
			$this->load->library('files/files');
			Files::delete_folder()
		*/
		$this->dbforge->drop_table('clients');
		$this->load->driver('Streams');
		$this->streams->utilities->remove_namespace('clients');
		if ($this->db->table_exists('data_streams')) {
			$this->db->where('stream_namespace', 'clients')->delete('data_streams');
		}
		return true;
	}


	public function upgrade($old_version) {
		return true;
	}

	public function help() {
		return "Coming soon&tm;.";
	}

}
/* End of file details.php */