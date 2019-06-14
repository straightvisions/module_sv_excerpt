<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions
 * @package			sv_100
 * @copyright		2019 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_excerpt extends init {
	public function init() {
		// Module Info
		$this->set_module_title( 'SV Excerpt' );
		$this->set_module_desc( __( 'This module gives the ability to define how excerpts will be displayed.', 'straightvisions_100' ) );

		// Section Info
		$this->set_section_title( __( 'Excerpt', 'straightvisions_100' ) );
		$this->set_section_desc( __( 'Adjust Settings', 'straightvisions_100' ) );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Loads Settings
		$this->load_settings();

		// Action Hooks
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
	}

	public function load_settings() {
		$this->s['length'] = $this->get_setting()
			->set_ID( 'length' )
			->set_title( __( 'Excerpt length', 'straightvisions_100' ) )
			->set_description( __( 'Maximum number of words allowed in displaying excerpts.', 'straightvisions_100' ) )
			->set_placeholder( '80' )
			->load_type( 'number' );

		$this->s['more'] = $this->get_setting()
			->set_ID( 'more' )
			->set_title( __( 'Text to show at the end of the excerpt', 'straightvisions_100' ) )
			->set_placeholder( '...' )
			->load_type( 'text' );
	}

	public function excerpt_length( $length ) {
		return $this->s['length']->run_type()->get_data() ? $this->s['length']->run_type()->get_data() : 80;
	}

	public function excerpt_more() {
		return $this->s['more']->run_type()->get_data() ? $this->s['more']->run_type()->get_data() : '...';
	}
}