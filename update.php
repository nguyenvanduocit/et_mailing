<?php 

require_once dirname(__FILE__) . '/inc/inc.update.php';
if (!class_exists('AE_Paymill_Update')){
	class AE_Paymill_Update extends AE_Plugin_Updater{
		const VERSION = '1.0';

		// setting up updater
		public function __construct(){
			$this->product_slug 	= plugin_basename( dirname(__FILE__) . '/ae_mailing.php' );
			$this->slug 			= 'ae_mailing';
			$this->license_key 		= get_option('et_license_key', '');
			$this->current_version 	= self::VERSION;
			$this->update_path 		= 'http://www.enginethemes.com/forums/?do=product-update&product='.$this->slug.'&type=plugin';

			parent::__construct();
		}
	}
	new AE_Paymill_Update();
}


?>