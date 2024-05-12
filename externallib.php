<?php

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;
use local_tickets\lib;

require_once($CFG->libdir . "/externallib.php");

class local_tickets_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_ticket_parameters() {
        return new external_function_parameters(
            [
                'id' => new external_value(PARAM_INT, 'The ticket id'),
            ]
        );
    }


    /**
     * Deletes a ticket
     * @return bool true on success
     */
    public static function delete_ticket($id)
    {
        if (!has_capability('local/tickets:deletetickets', context_system::instance())) {
            return [
                'status' => 403,
                'message' => 'Forbidden',
            ];;
        }
        $id = json_decode($id);
        lib::init();
        $success = lib::delete_ticket($id);
        if($success){
            return [
                'status' => 200,
                'message' => 'Ticket deleted successfully',
            ];
        }
        return [
            'status' => 400,
            'message' => 'Error Occured. Ticket not deleted.',
        ];
    }
    /**
    * Returns description of method result value
    * @return external_description
    */
    public static function delete_ticket_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_INT, 'The status of the result'),
                'message' => new external_value(PARAM_TEXT, 'A message related to the result'),
            )
        );
    }


}