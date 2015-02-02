<?php

/**
 * @project ae_mailing
 * @author  nguyenvanduocit
 * @date    01/29/2015
 */
class AEM_Module_Mailgun extends AEM_Module_Base
{
    private $client;

    function __construct ()
    {

    }

    function init_hook ()
    {
        add_action( 'wp_ajax_mailgun_test', array ( $this, 'ajax_mailgun_test' ) );
        wp_enqueue_script( 'mailgun_backend_script', plugins_url( "/inc/module/mailgun/js/mailgun-setting.js", AEM_PLUGIN_FILE ), array ( "appengine" ), NULL, TRUE );
    }

    /**
     * Send test email
     */
    function ajax_mailgun_test ()
    {
        if ( isset( $_POST["test_email"] ) ) {
            try {
                $send_result = wp_mail( $_POST["test_email"], __( "AE_Mail Test mail", AEM_DOMAIN ), __( "AE_Mail Test mail body", AEM_DOMAIN ) );
                wp_send_json( array ( 'sucess' => TRUE, 'message' => __( "function send success.", AEM_DOMAIN ) ) );
            } catch ( Exception $ex ) {
                wp_send_json( array ( 'sucess' => FALSE, 'message' => $ex->getMessage() ) );
            }
        } else {
            wp_send_json( array ( 'sucess' => FALSE, 'message' => __( "Test email is not provided ! Please fill the text box above.", AEM_DOMAIN ) ) );
        }
    }

    /**
     * This function using for override pluggable wp_mail
     *
     * @param        $to
     * @param        $subject
     * @param        $message
     * @param string $headers
     * @param array  $attachments
     *
     * @throws Exception
     */
    function wp_mail ( $to, $subject, $message, $headers = '', $attachments = array () )
    {
        try {
            $mgClient = $this->get_client();
            # Make the call to the client.

            $admin_email = get_option( 'admin_email' );

            $result = $mgClient->sendMessage(
                array (
                    'from'    => $admin_email,
                    'to'      => 'nguyenvanduocit@gmail.com',
                    'subject' => 'AE Mail : Test API',
                    'text'    => 'Awesome, you see this email, it\'s mean everything is ok. Email functions is work fine.'
                )
            );
        } catch ( Exception $ex ) {
            throw $ex;
        }
    }

    /**
     * Get mailgun client
     *
     * @return AEM_Module_Mailgun_Client
     */
    function get_client ()
    {
        if ( is_null( $this->client ) ) {
            $apiKey = ae_get_option( 'mailgun_apiKey' );
            $apiDomain = ae_get_option( 'mailgun_domain' );
            $this->client = new AEM_Module_Mailgun_Client( $apiKey, $apiDomain );
        }

        return $this->client;
    }

    /**
     * Get data togenerate setting in admin dashboard
     *
     * @return array
     */
    function get_setting_section ()
    {
        add_action( 'wp_enqueue_scripts', 'themeslug_enqueue_style' );
        $sections = array (
            'args'   => array (
                'title' => __( "Mailgun's settings", AEM_DOMAIN ),
                'id'    => 'mailgun-settings',
                'icon'  => "-",
                'class' => ''
            ),
            'groups' => array (
                array (
                    'args'   => array (
                        'title' => __( "Mailgun API", AEM_DOMAIN ),
                        'id'    => 'mailgun-api',
                        'class' => '',
                        'desc'  => __( "Enable this api to send email with MailGun service.", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'          => 'mailgin_domain',
                            'type'        => 'text',
                            'title'       => __( "Domain ", AEM_DOMAIN ),
                            'label'       => __( "Domain ", AEM_DOMAIN ),
                            'name'        => 'mailgun_domain',
                            'placeholder' => __( "Mailgun domain", AEM_DOMAIN ),
                            'class'       => ''
                        ),
                        array (
                            'id'          => 'mailgin_apiKey',
                            'type'        => 'text',
                            'title'       => __( "API Key ", AEM_DOMAIN ),
                            'label'       => __( "API Key ", AEM_DOMAIN ),
                            'name'        => 'mailgun_apiKey',
                            'placeholder' => __( "Mailgun api key", AEM_DOMAIN ),
                            'class'       => ''
                        )
                    ),
                ),
                array (
                    'args'   => array (
                        'title' => __( "Test API", AEM_DOMAIN ),
                        'id'    => 'mailgun-tag',
                        'class' => '',
                        'desc'  => __( "If added, this tag will exist on every outbound message. Statistics will be populated in the Mailgun Control Panel. Use a comma to define multiple tags..", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'    => 'test_email',
                            'type'  => 'text',
                            'title' => __( "Test email ", AEM_DOMAIN ),
                            'name'  => 'mailgun_test_email',
                            'class' => ''
                        ),
                        array (
                            'id'    => 'send_text_email',
                            'text'  => "Send Test Email",
                            'type'  => 'Custom_Type_Button',
                            'class' => 'bg-grey-button button btn-button'
                        ),
                    ),
                ),
                array(
                    'args'   => array (
                        'title' => __( "Email setting", AEM_DOMAIN ),
                        'id'    => 'mailgun-emailsetting',
                        'class' => ''
                    ),
                    'fields' => array (
                        array (
                            'id'    => 'from_email',
                            'type'  => 'text',
                            'title' => __( "From email ", AEM_DOMAIN ),
                            'name'  => 'mailgun_fromemail',
                            'class' => ''
                        ),
                    ),
                ),
                array (
                    'args'   => array (
                        'title' => __( "Click tracking", AEM_DOMAIN ),
                        'id'    => 'mailgun-tracking',
                        'class' => '',
                        'desc'  => __( "If enabled, Mailgun will  and track links. <a href='http://documentation.mailgun.com/user_manual.html#tracking-clicks' target='_blank'>Click Tracking Documentation</a>", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'    => 'click_tracking',
                            'type'  => 'switch',
                            'title' => __( "Click tracking ", AEM_DOMAIN ),
                            'name'  => 'mailgun_click_tracking',
                            'class' => ''
                        ),
                    ),
                ),
                array (
                    'args'   => array (
                        'title' => __( "Open Tracking", AEM_DOMAIN ),
                        'id'    => 'mailgun-open',
                        'class' => '',
                        'desc'  => __( "If enabled, HTML messages will include an open tracking beacon. <a href='http://documentation.mailgun.com/user_manual.html#tracking-opens' target='_blank'>Open Tracking Documentation</a>", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'    => 'open_tracking',
                            'type'  => 'switch',
                            'title' => __( "Open tracking ", AEM_DOMAIN ),
                            'name'  => 'mailgun_open_tracking',
                            'class' => ''
                        ),
                    ),
                ),
                array (
                    'args'   => array (
                        'title' => __( "Campaign ID", AEM_DOMAIN ),
                        'id'    => 'mailgun-campaignid',
                        'class' => '',
                        'desc'  => __( "If added, this campaign will exist on every outbound message. Statistics will be populated in the Mailgun Control Panel. Use a comma to define multiple campaigns.", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'    => 'campaign_id',
                            'type'  => 'text',
                            'title' => __( "Campaign id ", AEM_DOMAIN ),
                            'name'  => 'mailgun_campaignid',
                            'class' => ''
                        ),
                    ),
                ),
                array (
                    'args'   => array (
                        'title' => __( "Tag", AEM_DOMAIN ),
                        'id'    => 'mailgun-tag',
                        'class' => '',
                        'desc'  => __( "If added, this tag will exist on every outbound message. Statistics will be populated in the Mailgun Control Panel. Use a comma to define multiple tags..", AEM_DOMAIN )
                    ),

                    'fields' => array (
                        array (
                            'id'    => 'tag',
                            'type'  => 'text',
                            'title' => __( "Tag ", AEM_DOMAIN ),
                            'name'  => 'mailgun_tag',
                            'class' => ''
                        ),
                    ),
                )
            )
        );

        return $sections;
    }
}