<?php
namespace sv_100;

/**
 * @author			straightvisions
 * @package			sv_100
 * @copyright		2019 Matthias Reuter
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */
class sv_excerpt extends init {
	const section_title							= 'Abstract';
	static $scripts_loaded						= false;
	
	public function __construct() {
	
	}
	
	public function admin_init() {
		$this->get_root()->add_section( $this );
		$this->load_settings();
	}

	public function init() {
		$this->set_section_title( 'Excerpt' );
		$this->set_section_desc( __( 'Adjust Settings', $this->get_module_name() ) );
		$this->set_section_type( 'settings' );
		
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );

		if ( ! is_admin() ) {
			$this->load_settings();
		}
	}

	public function load_settings() {
		$this->s['length'] = static::$settings->create( $this )
			->set_ID( 'length' )
			->set_title( 'Excerpt Length' )
			->set_description( __( 'Maximum of chars allowed in displaying excerpts. Default is 80.', $this->get_module_name() ) )
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