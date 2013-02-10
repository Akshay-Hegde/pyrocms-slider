<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	 * Shoot URL
	 *
	 * Returns the URL to a shoot's detail page based on the shoot's ID. Returns false if no ID is given.
	 *
	 * @return string or false
	 * @author Nicolas Schneider
	 **/
	if( !function_exists("shoot_url") ) {
		function shoot_url( $shoot_id = null, $shoot_title = null ) {
			if( null === $shoot_id ) return false;
			if( null === $shoot_title ) {
				$this->load->driver("Streams");
				$shoot = $this->streams->entries->get_entry( $shoot_id, 'shoots', 'welschenbach' );
				$shoot_title = $shoot->shoot_title;
			}
			$link_template = site_url('shoots/detail/%1$s/%2$s');
			$title_as_uri = strtolower( url_title( $shoot_title ) );
			return sprintf( $link_template, $shoot_id, $title_as_uri );
		}
	}


?>