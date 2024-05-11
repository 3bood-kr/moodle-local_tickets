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
 * Form to Change Ticket Status
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
require_once($CFG->libdir . "/formslib.php");

/**
 * Form to Change Ticket Status
 *
 * This form is used in view ticket page
 * to change status of a ticket by someone
 * who has the privileges.
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class change_ticket_status extends moodleform {

    /**
     * Form definition
     *
     * @return void
     */
    protected function definition() {
        global $CFG;
        $mform = $this->_form;
        $options = [
            'open' => get_string('open', 'local_tickets'),
            'closed' => get_string('closed', 'local_tickets'),
            'pending' => get_string('pending', 'local_tickets'),
            'solved' => get_string('solved', 'local_tickets'),
        ];
        $mform->addElement(
            'select',
            'status',
            get_string('status', 'local_tickets'),
            $options);

        $ticketid = required_param('id', PARAM_INT);

        $mform->addElement('hidden', 'id', ''); // Hidden element for the ticket ID.
        $mform->setType('id', PARAM_INT);
        $mform->setDefault('id', $ticketid);
        $this->add_action_buttons();
    }
}
