<?php

/*
Plugin Name: ET Mailing
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: This plugin allows you to use Third-party service to send email, avoid spam filters.
Version: 1.0.0-b1
Author: EngineTheme
Developer : Duoc Nguyen Van
Author URI: http://enginethemes.com
*/
define( "AEM_PLUGIN_FILE", __FILE__ );
define( "AEM_PLUGIN_PATH", dirname( AEM_PLUGIN_FILE ) );
define( 'AEM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'AEM_VERSION', "1.0.0-b1" );
define( 'AEM_DOMAIN', "ae_mailing" );


require_once AEM_PLUGIN_PATH.'/update.php';
require_once AEM_PLUGIN_PATH.'/inc/class-aem-util.php';

$require_result = AEM_Util::check_require();

if ( !is_wp_error( $require_result ) ) {

    require_once AEM_PLUGIN_PATH.'/inc/class-autoload.php';
    require_once AEM_PLUGIN_PATH.'/inc/aem-functions.php';
    //TODO : detect in AE enviroment or stand alone
    AEM()->init();
    AEM_Setting_Page()->init();
}