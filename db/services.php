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
    'local_tickets_change_ticket_status' => [
        'classname'   => 'local_tickets_external',
        'methodname'  => 'change_ticket_status',
        'classpath'   => 'local/tickets/externallib.php',
        'description' => 'Chane ticket status.',
        'type'        => 'write',
        'ajax'        => true,
    ],
];
