<?php
/**
 * @project ae_mailing
 * @author nguyenvanduocit
 * @date 01/30/2015
 */
class AEM_Util{

    public static function check_php_version(){
        if (version_compare(PHP_VERSION, '5.3.2') >= 0) {
            return true;
        }
        return new WP_Error( 'check_php_version', __( "Mailing AE require a minimum version of PHP 5.3.2, but ensure tenants PHP version you are using is less than 5.3.2. Please upgrade PHP to be able to use the plugin.", AEM_DOMAIN ) );

    }
    public static function check_installed_appengine(){
        //TODO:Check if appengine is installed using wp_get_themes or option
        if(true)
        {
            return true;
        }
        else
        {
            return new WP_Error( 'check_installed_appengine', __( "This plugin requires you to install a theme of EngineTheme. But you have not installed.", AEM_DOMAIN ) );
        }
    }
    public static function check_require(){
        $appengine_check_result = self::check_installed_appengine();
        if(is_wp_error($appengine_check_result)){
            add_action( 'admin_notices', array(__CLASS__, 'install_appengine_notice' ));
            return $appengine_check_result;
        }

        $php_check_result = self::check_php_version();
        if(is_wp_error($php_check_result)){
            add_action( 'admin_notices', array(__CLASS__, 'upgrade_php_notice' ));
            return $php_check_result;
        }

    }
    function upgrade_php_notice() {
        ?>
        <div class="error">
            <p><?php _e( "Mailing AE require a minimum version of PHP 5.3.2, but ensure tenants PHP version you are using is less than 5.3.2. Please upgrade PHP to be able to use the plugin.", AEM_DOMAIN ); ?></p>
        </div>
    <?php
    }
    function install_appengine_notice() {
        ?>
        <div class="error">
            <p><?php _e( "This plugin requires you to install a theme of EngineTheme. But you have not installed.", AEM_DOMAIN ); ?></p>
        </div>
    <?php
    }
}