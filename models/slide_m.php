<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Slide_m extends MY_Model {

	protected $stream_name = 'slides',
			  $stream_namespace = 'slides';

	function delete( $id = null ) {
		if( $id !== null &&
			$this->streams->entries->delete_entry($id, $this->stream_name, $this->stream_namespace) ) {
			return true;
		} else {
			return false;
		}
	}

	function publish($id = null) {
		if( $id === null ) return false;
		return $this->streams->entries->update_entry($id, array('status' => 'Live'), $this->stream_name, $this->stream_namespace, array('label', 'image', 'link', 'ribbon'));
	}

	function unpublish($id = null) {
		if( $id === null ) return false;
		return $this->streams->entries->update_entry($id, array('status' => 'Draft'), $this->stream_name, $this->stream_namespace, array('label', 'image', 'link', 'ribbon'));
	}

	function batch_publish($ids = null) {
		if($ids === null || !is_array($ids)) return false;
		$all_good = true;
		foreach ($ids as $id) {
			$all_good = $all_good && $this->publish($id);
		}
		return $all_good;
	}

	function batch_unpublish($ids = null) {
		if($ids === null || !is_array($ids)) return false;
		$all_good = true;
		foreach ($ids as $id) {
			$all_good = $all_good && $this->unpublish($id);
		}
		return $all_good;
	}

	function batch_delete($ids = null) {
		if($ids === null || !is_array($ids)) return false;
		$all_good = true;
		foreach ($ids as $id) {
			$all_good = $all_good && $this->delete($id);
		}
		return $all_good;
	}

}