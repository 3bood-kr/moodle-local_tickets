<?php

use core_external\external_api;
use core_external\external_function_parameters;
use core_external\external_single_structure;
use core_external\external_value;

require_once($CFG->libdir . "/externallib.php");

class local_tickets_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function submit_ticket_parameters() {
        return new external_function_parameters(
            [
                'data' => new external_value(PARAM_TEXT, 'The ticket data in JSON format')
            ]
        );
    }


    /**
     * Submits a ticket
     * @return bool true on success
     */
    public static function submit_ticket($data)
    {
        if (!has_capability('local/tickets:submittickets', context_system::instance())) {
            return [
                'status' => 403,
                'message' => 'Forbidden',
            ];;
        }

        $data = json_decode($data);
        
        global $USER, $DB;
        $record = new stdClass();
        $record->title = $data->title;
        $record->mobile = $data->mobile;
        $record->email = $data->email;
        $record->description = $data->description;
        $record->created_by = $USER->id;
        $record->created_at = time();
        $record->updated_by = $USER->id;
        $record->updated_at = time();
        $success = $DB->insert_record('local_tickets', $record);

        if($success){
            return [
                'status' => 200,
                'message' => 'Ticket submitted successfully',
            ];
        }
        
        return [
            'status' => 400,
            'message' => 'Error Occured. Ticket not Submitted.',
        ];
    }
    /**
    * Returns description of method result value
    * @return external_description
    */
    public static function submit_ticket_returns() {
        return new external_single_structure(
            array(
                'status' => new external_value(PARAM_INT, 'The status of the result'),
                'message' => new external_value(PARAM_TEXT, 'A message related to the result'),
            )
        );
    }

    /**
     * Changes status of a ticket
     * @return bool true on success
     */
    public static function change_ticket_status($data)
    {
        if (!has_capability('local/tickets:edittickets', context_system::instance())) {
            return [
                'status' => 403,
                'message' => 'Forbidden',
            ];;
        }

        $data = json_decode($data);
        
        global $DB, $USER;
        $record = new stdClass();
        $record->id = $data->id;
        $record->status = $data->status;
        $record->updated_at = time();
        $record->updated_by = $USER->id;
        $success = $DB->update_record('local_tickets', $record);
        if($success){
            return [
                'status' => 200,
                'message' => 'Ticket submitted successfully',
            ];
        }
        
        return [
            'status' => 400,
            'message' => 'Error Occured. Ticket status not updated.',
        ];
    }

}