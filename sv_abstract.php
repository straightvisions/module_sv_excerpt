<?php
	namespace sv_100;
	
	/**
	 * @author			Matthias Reuter
	 * @package			sv_100
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 * @license			See license.txt or https://straightvisions.com
	 */
	class sv_abstract extends init{
		const section_title							= 'Abstract';
		static $scripts_loaded						= false;

		public function __construct($path,$url){
			$this->path								= $path;
			$this->url								= $url;
			$this->name								= get_class($this);

			add_action('admin_init', array($this, 'admin_init'));
			add_action('init', array($this, 'init'));
		}
		public function admin_init(){
			$this->get_root()->add_section($this, 'settings');
			$this->load_settings();
		}
		public function init(){
			add_filter('excerpt_length', array($this, 'excerpt_length'));

			if(!is_admin()){
				$this->load_settings();
			}
		}
		public function load_settings(){
			$this->s['length'] = static::$settings->create($this)
				->set_section_group($this->get_module_name())
				->set_section_name('Abstract Settings')
				->set_section_description(__('Adjust Settings', $this->get_module_name()))
				->set_ID('length')
				->set_title('Abstract Length')
				->set_description(__('Maximum of chars allowed in displaying excerpts. Default is 80.', $this->get_module_name()))
				->set_placeholder('80')
				->load_type('number');
		}
		public function excerpt_length($length){
			return $this->s['length']->run_type()->get_data() ? $this->s['length']->run_type()->get_data() : 80;
		}
	}
?>