<?php

$functions = [
    'local_tickets_delete_ticket' => [
        'classname'   => 'local_tickets_external',
        'methodname'  => 'delete_ticket',
        'classpath'   => 'local/tickets/externallib.php',
        'description' => 'Delete a ticket.',
        'type'        => 'write',
        'ajax'        => true,
    ],
];
