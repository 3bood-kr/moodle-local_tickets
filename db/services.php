<?php

$functions = [
    'local_tickets_submit_ticket' => [
        'classname'   => 'local_tickets_external',
        'methodname'  => 'submit_ticket',
        'classpath'   => 'local/tickets/externallib.php',
        'description' => 'Submits a ticket.',
        'type'        => 'write',
        'ajax'        => true,
    ],
];
