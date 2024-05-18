<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Functions for ajax
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_tickets\lib;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . "/externallib.php");

/**
 * Local Tickets Ajax Functions
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_tickets_external extends external_api{

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
     * @param id $id Ticket ID.
     * @return bool true on success
     */
    public static function delete_ticket($id) {
        if (!has_capability('local/tickets:deletetickets', context_system::instance())) {
            return [
                'status' => 403,
                'message' => 'Forbidden',
            ];;
        }
        $id = json_decode(strval($id));
        lib::init();
        $success = lib::delete_ticket($id);
        if ($success) {
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
            [
                'status' => new external_value(PARAM_INT, 'The status of the result'),
                'message' => new external_value(PARAM_TEXT, 'A message related to the result'),
            ]
        );
    }

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function get_tickets_parameters() {
        return new external_function_parameters(
            []
        );
    }


    /**
     * Fetch tickets
     * 
     * @return bool true on success
     */
    public static function get_tickets() {
        if (!has_capability('local/tickets:viewtickets', context_system::instance())) {
            return [
                'status' => 403,
                'message' => 'Forbidden',
                'data' => '',
            ];;
        }
        lib::init();
        $tickets = lib::get_tickets();
        $tickets = json_encode($tickets);
        if ($tickets) {
            return [
                'status' => 200,
                'message' => 'Ticket fetched successfully',
                'data' => $tickets,
            ];
        }
        return [
            'status' => 400,
            'message' => 'Error Occured. Tickets not fetched.',
            'data' => '',
        ];
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function get_tickets_returns() {
        return new external_single_structure(
            [
                'status' => new external_value(PARAM_INT, 'The status of the result'),
                'message' => new external_value(PARAM_TEXT, 'A message related to the result'),
                'data' => new external_value(PARAM_RAW, 'Tickets Data'),
            ]
        );
    }
}
