<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Shoots Plugin
 *
 * Builds the Shoots menu for the main page. Usage: {{ shoots:render_menu }}
 *
 * @author      Nicolas Schneider
 * @package     Hypemedia/Plugins
 * @copyright   Copyright (c) 2009 - now, hype.media
 */
class Plugin_Slider extends Plugin {
	/**
	 * Carousel
	 *
	 * Builds an HTML-list of roundabout.js-carousel-items
	 * Usage: {{ slider:carousel }}, wrapped in <ul>
	 *
	 * @return string The HTML of list items (<li>) for a roundabout.js-carousel
	 */
	public function carousel() {
		$this->load->driver('Streams');
		$slides = $this->streams->entries->get_entries(array(
			'stream' => 'slides',
			'namespace' => 'slides',
			'where' => 'status=\'Live\'',
		));
		$ribbon_template = '<span class="pricetag">%s</span>';
		$item_template = '<li><div class="prod_holder"><a href="%s" title="%s"><img src="%s" alt="" /></a><h3>%s</h3></div>%s</li>';
		$html = '';
		foreach ($slides['entries'] as $slide) {
			$ribbon_content = trim($slide['ribbon']); // since empty( trim(...) ) is not working
			$ribbon = (isset($slide['ribbon']) && !empty($ribbon_content)) ? sprintf($ribbon_template, $slide['ribbon']) : '';
			$html .= sprintf($item_template, $slide['link'], $slide['label'], site_url('files/thumb/'.$slide['image']['id'].'/450/300/fit'), $slide['label'], $ribbon)."\n";
		}
		return $html;
	}
}

/* End of file plugin.php */