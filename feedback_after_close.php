<?php
require_once(INCLUDE_DIR . 'class.plugin.php');
require_once(INCLUDE_DIR . 'class.ticket.php');
require_once(INCLUDE_DIR . 'class.email.php');

class FeedbackAfterClosePlugin extends Plugin {
    var $config_class = 'FeedbackAfterCloseConfig';

    function bootstrap() {
        // Connect to the ticket.closed signal
        Signal::connect('ticket.closed', array($this, 'onTicketClosed'));
    }

    function onTicketClosed($ticket) {
        if ($ticket instanceof Ticket) {
            $this->sendFeedbackEmail($ticket);
        }
    }

    function sendFeedbackEmail($ticket) {
        global $ost;

        // Retrieve necessary ticket information
        $ticketId = $ticket->getId();
        $ticketNumber = $ticket->getNumber();
        $ticketSubject = $ticket->getSubject();
        $userEmail = $ticket->getEmail();
        $ticketOwner = $ticket->getName();

        // Prepare email content
        $subject = "Feedback Request for Ticket #$ticketNumber: $ticketSubject";
        $message = "Dear $ticketOwner,\n\n";
        $message .= "Thank you for contacting us regarding your recent issue.\n";
        $message .= "We would appreciate it if you could take a moment to provide feedback about your experience with our support team.\n";
        $message .= "Please use the following link to fill out the feedback form:\n";
        $message .= $ost->getConfig()->getUrl() . "/feedback-form.php?ticket=$ticketId\n\n";
        $message .= "Thank you,\nThe Support Team";

        // Set additional headers if needed
        $headers = "From: support@example.com\r\n";
        $headers .= "Reply-To: support@example.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Attempt to send the email using PHP's mail function
        if (!mail($userEmail, $subject, $message, $headers)) {
            // Log error to PHP error log
            error_log("Failed to send feedback email for ticket #$ticketNumber");
        }
    }
}

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
            // You can remove OAuth2-related fields from here
        );
    }

    function pre_save(&$config, &$errors) {
        // Validate or process configuration data before saving
        return TRUE;
    }
}

return new FeedbackAfterClosePlugin();
?>
