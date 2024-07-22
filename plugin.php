<?php

return [
    'id' => 'osticket:feedbackrequestplugin',
    'version' => '2.0',
    'name' => 'Feedback Request Plugin - v2',
    'author' => 'Isaias Santos',
    'description' => 'Envia um email solicitando feedback ao fechar um ticket.',
    'plugin' => 'feedback_after_close.php:FeedbackAfterClosePlugin'
];
