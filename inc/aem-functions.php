<?php
/**
 * @project ae_mailing
 * @author  nguyenvanduocit
 * @date    01/30/2015
 */
function AEM ()
{
    return AEM_Mailing::instance();
}

function AEM_Setting_Page ()
{
    return AEM_Setting_Page::instance();
}

/**
 * @param        $to
 * @param        $subject
 * @param        $message
 * @param string $headers
 * @param array  $attachments
 *
 * @return bool
 */
function wp_mail ( $to, $subject, $message, $headers = '', $attachments = array () )
{
    AEM()->module_factory()->get_current_module()->wp_mail( $to, $subject, $message, $headers, $attachments );
}