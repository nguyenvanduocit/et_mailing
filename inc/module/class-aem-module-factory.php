<?php

/**
 * @project ae_mailing
 * @author  nguyenvanduocit
 * @date    01/30/2015
 */
class AEM_Module_Factory
{
    private $modules = array ();

    function get_current_module(){
        //TODO : get current module from database
        return $this->get_module("Mailgun");
    }
    function get_modules ()
    {
        $modules = array (
            "Mailgun"
        );

        $modules = apply_filters( "aem_get_module_names", $modules );

        foreach ( $modules as $module_name ) {
            $this->get_module( $module_name );
        }

        return $this->modules;
    }

    function get_module ( $module_name )
    {
        if ( !isset( $this->modules[$module_name] ) ) {

            $module_object = $this->get_module_class( $module_name );
            if(null!==$module_object) {
                $this->modules[$module_name] = $module_object;
            }
            return $module_object;
        }
        return $this->modules[$module_name];
    }

    function get_module_class ( $module_name )
    {
        $class_name = sprintf( "AEM_Module_%s", $module_name );
        $class_name = apply_filters( "aem_get_module_class", $class_name, $module_name );
        if ( class_exists( $class_name ) ) {
            return new $class_name;
        }

        return null;
    }
}