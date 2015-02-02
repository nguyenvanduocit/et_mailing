<?php

/**
 * @project ae_mailing
 * @author  nguyenvanduocit
 * @date    01/29/2015
 */
class AEM_Setting_Page
{
    static $_instance;

    public static function instance ()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function init ()
    {
        add_action( 'plugins_loaded', array ( $this, 'init_hook' ) );
    }

    function init_hook ()
    {
        add_filter( 'ae_admin_menu_pages', array ( $this, 'add_admin_menu_pages' ) );
        add_filter( 'admin_enqueue_scripts', array ( $this, 'enqueue_script' ) );

    }

    function enqueue_script ()
    {

    }

    /**
     * Add admin menu
     *
     * @param $pages
     */
    public function add_admin_menu_pages ( $pages )
    {
        $options = AE_Options::get_instance();

        $modules = AEM()->module_factory()->get_modules();

        $temp = array ();
        foreach ( $modules as $module ) {
            $section = $module->get_setting_section();
            $temp[] = new AE_section( $section['args'], $section['groups'], $options );
        }

        $mailing_setting = new AE_container( array (
            'class' => 'mailing-settings',
            'id'    => 'settings',
        ), $temp, $options );
        $pages[] = array (
            'args'      => array (
                'parent_slug' => 'et-overview',
                'page_title'  => __( 'Mailing', AEM_DOMAIN ),
                'menu_title'  => __( 'Mailing', AEM_DOMAIN ),
                'cap'         => 'administrator',
                'slug'        => 'aem-settings',
                'icon'        => 'M',
                'desc'        => __( "Email client manager", AEM_DOMAIN )
            ),
            'container' => $mailing_setting
        );

        return $pages;
    }
}