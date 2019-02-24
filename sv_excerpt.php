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
	public function __construct() {
	
	}

	public function init() {
		// Module Info
		$this->set_module_title( 'SV Excerpt' );
		$this->set_module_desc( __( 'This module manages how excerpts will be displayed.', $this->get_module_name() ) );

		// Section Info
		$this->set_section_title( 'Excerpt' );
		$this->set_section_desc( __( 'Adjust Settings', $this->get_module_name() ) );
		$this->set_section_type( 'settings' );
		$this->get_root()->add_section( $this );

		// Loads Settings
		$this->load_settings();

		// Action Hooks
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
	}

	public function load_settings() {
		$this->s['length'] = static::$settings->create( $this )
			->set_ID( 'length' )
			->set_title( 'Excerpt Length' )
			->set_description( __( 'Maximum of words allowed in displaying excerpts. Default is 80.', $this->get_module_name() ) )
			->set_placeholder( '80' )
			->load_type( 'number' );

		$this->s['more'] = static::$settings->create( $this )
			->set_ID( 'more' )
			->set_title( 'Excerpt Read More Text' )
			->set_description( __( 'Read More Text for Excerpts, default ...', $this->get_module_name() ) )
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