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

class create_ticket_form extends moodleform {
    function definition() {
        global $CFG, $USER;
        $mform = $this->_form;

        $mform->addElement('text', 'title', get_string('title', 'local_tickets'));
        $mform->setType('title', PARAM_NOTAGS);
        $mform->addRule('title', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->setDefault('email', $USER->email);
        $mform->addRule('email', get_string('invalidemail'), 'email', null, 'client');


        $mform->addElement('text', 'mobile', get_string('mobile', 'local_tickets'));
        $mform->setType('mobile', PARAM_NOTAGS);
        $mform->addRule('mobile', get_string('invalidmobile', 'local_tickets'), 'regex', '/^\+?[1-9]{1,3} ?[0-9]{10}$/', 'client');

//        $mform->addElement('editor', 'description_editor', get_string('description'), null, $this->editor_options());
//        $mform->setType('description_editor', PARAM_RAW);

        $mform->addElement('textarea', 'description', get_string('description'));
        $mform->setType('description', PARAM_NOTAGS);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');


        $this->add_action_buttons();

    }
//    private function editor_options() {
//        return array(
//            'maxfiles' => EDITOR_UNLIMITED_FILES,
//            'maxbytes' => 1024*1024*10, // e.g., 10MB; adjust as necessary
//            'trusttext' => true,
//            'context' => $this->context,  // depending on where you are in Moodle, you might need to provide the context
//            'subdirs' => false
//        );
//    }
}