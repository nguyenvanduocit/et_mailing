<?php
/**
 * @project ae_mailing
 * @author nguyenvanduocit
 * @date 01/29/2015
 */
abstract class AEM_Module_Base{
    abstract function wp_mail( $to, $subject, $message, $headers = '', $attachments = array());
    abstract function get_setting_section();
    abstract function init_hook();
}