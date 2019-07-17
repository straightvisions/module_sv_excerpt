<?php
	namespace sv100;
	
	/**
	 * @version         4.000
	 * @author			straightvisions GmbH
	 * @package			sv100
	 * @copyright		2019 straightvisions GmbH
	 * @link			https://straightvisions.com
	 * @since			1.000
	 * @license			See license.txt or https://straightvisions.com
	 */
	
	class sv_excerpt extends init {
		public function init() {
			$this->set_module_title( 'SV Excerpt' )
				 ->set_module_desc( __( 'This module gives the ability to define how excerpts will be displayed.', 'sv100' ) )
				 ->load_settings()
				 ->set_section_title( __( 'Excerpt', 'sv100' ) )
				 ->set_section_desc( __( 'Adjust Settings', 'sv100' ) )
				 ->set_section_type( 'settings' )
				 ->get_root()
				 ->add_section( $this );
	
			// Action Hooks
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		}
	
		protected function load_settings(): sv_excerpt {
			$this->get_setting( 'length' )
				 ->set_title( __( 'Excerpt length', 'sv100' ) )
				 ->set_description( __( 'Maximum number of words allowed in displaying excerpts.', 'sv100' ) )
				 ->set_placeholder( '30' )
				 ->set_default_value( 30 )
				 ->load_type( 'number' );
			
			$this->get_setting( 'more' )
				 ->set_title( __( 'Text to show at the end of the excerpt', 'sv100' ) )
				 ->set_placeholder( '...' )
				 ->set_default_value( '...' )
				 ->load_type( 'text' );
			
			return $this;
		}
	
		public function excerpt_length( int $length ): int {
			return $this->get_setting( 'length' )->run_type()->get_data() ? $this->get_setting( 'length' )->run_type()->get_data() : 30;
		}
	
		public function excerpt_more(): string {
			return $this->get_setting( 'more' )->run_type()->get_data() ? $this->get_setting( 'more' )->run_type()->get_data() : '...';
		}
	}