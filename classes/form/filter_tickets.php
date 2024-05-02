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
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . "/formslib.php");


class filter_tickets extends moodleform {
    function definition() {
        global $CFG;
        $mform = $this->_form;
        $options = array(
            '' => get_string('all', 'local_tickets'),
            'open' => get_string('open', 'local_tickets'),
            'closed' => get_string('closed', 'local_tickets'),
            'pending' => get_string('pending', 'local_tickets'),
            'solved' => get_string('solved', 'local_tickets'),
        );


        $status = optional_param('status', '', PARAM_NOTAGS);
        $mform->addElement(
            'select',
            'status',
            get_string('status', 'local_tickets'),
            $options);
        $mform->setDefault('status', $status);


        $created_by = optional_param('created_by', '', PARAM_INT);
        $mform->addElement('text', 'created_by', get_string('created_by', 'local_tickets'));
        $mform->setType('created_by', PARAM_NOTAGS);
        $mform->setDefault('created_by', '');
        $mform->addHelpButton('created_by', 'filter_by_user', 'local_tickets');

        $this->add_action_buttons(false, 'Filter');
    }

}