<?php
// /path/to/osticket/include/plugins/feedback_after_close/config.php

require_once INCLUDE_DIR.'/class.plugin.php';

class FeedbackAfterCloseConfig extends PluginConfig {
    // Implement configuration options
    function getOptions() {
        return array(
            'general_settings' => new SectionBreakField(array(
                'label' => 'General Settings',
            )),
            'feedback_form_url_value' => new TextboxField(array(
                'label' => 'Feedback Form URL',
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            'smtp_settings' => new SectionBreakField(array(
                'label' => 'SMTP Settings',
            )),
            'smtp_host' => new TextboxField(array(
                'label' => 'SMTP Host',
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            'smtp_port' => new TextboxField(array(
                'label' => 'SMTP Port',
                'configuration' => array('size'=>5, 'length'=>5),
            )),
            'smtp_encryption' => new DropdownField(array(
                'label' => 'Encryption',
                'choices' => array(
                    'tls' => 'TLS',
                    'ssl' => 'SSL',
                ),
            )),
        );
    }
}
?>
