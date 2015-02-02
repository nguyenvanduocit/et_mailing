<?php

class AEM_Mailing
{
    static $_instance = NULL;
    private $module_factory = NULL;
    private $option = NULL;

    public static function instance ()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    function init ()
    {
        $this->init_hook();
    }

    function module_factory ()
    {
        if ( is_null( $this->module_factory ) ) {
            $this->module_factory = new AEM_Module_Factory();
        }

        return $this->module_factory;
    }

    function get_option ()
    {
        if ( is_null( $this->option ) ) {
            $this->option = new AEM_Mailing_Option();
        }

        return $this->option;
    }

    function init_hook ()
    {
        $modules = AEM()->module_factory()->get_modules();
        foreach ( $modules as $module ) {
            $module->init_hook();
        }

        if ( is_admin() ) {
            add_filter( 'et_get_translate_string', array ( $this, 'add_translate_string' ) );
        }

    }

    function add_translate_string ( $entries )
    {
        $lang_path = AEM_PLUGIN_PATH.'/lang/ae_mailing.po';
        if ( file_exists( $lang_path ) ) {
            $pot = new PO();
            $pot->import_from_file( $lang_path, TRUE );

            return array_merge( $entries, $pot->entries );
        }

        return $entries;
    }
}