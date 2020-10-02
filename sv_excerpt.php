<?php
	namespace sv100;

	class sv_excerpt extends init {
		public function init() {
			$this->set_module_title( __( 'SV Excerpt', 'sv100' ) )
				->set_module_desc( __( 'Manages excerpts.', 'sv100' ) )
				->set_section_title( $this->get_module_title() )
				->set_section_desc( $this->get_module_desc() )
				->set_section_type( 'settings' )
				->set_section_order(3500)
				->get_root()
				->add_section( $this );
	
			// Action Hooks
			add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
			add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		}
	
		protected function load_settings(): sv_excerpt {
			$this->get_setting( 'length' )
				 ->set_title( __( 'Excerpt length', 'sv100' ) )
				 ->set_description( __( 'Maximum number of words allowed in displayed excerpts.', 'sv100' ) )
				 ->set_placeholder( __( '30', 'sv100' ) )
				 ->set_default_value( 30 )
				 ->load_type( 'number' );
			
			$this->get_setting( 'more' )
				 ->set_title( __( 'Text to show at the end of the excerpt', 'sv100' ) )
				 ->set_placeholder( __( '...', 'sv100' ) )
				 ->set_default_value( __( '...', 'sv100' ) )
				 ->load_type( 'text' );
			
			return $this;
		}
	
		public function excerpt_length( int $length ): int {
			return $this->get_setting( 'length' )->get_data()
				? $this->get_setting( 'length' )->get_data()
				: 30;
		}
	
		public function excerpt_more(): string {
			return $this->get_setting( 'more' )->get_data()
				? $this->get_setting( 'more' )->get_data()
				: __( '...', 'sv100' );
		}
	}