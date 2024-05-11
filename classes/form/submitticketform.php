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
 * Form to Submit Tickets
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_tickets\form;
require_once(__DIR__ . '/../../../../config.php');


/**
 * Form to Submit Tickets
 *
 * This form is To Submit Tickets
 * By Users
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class submitticketform extends \core_form\dynamic_form {
    
    protected function get_context_for_dynamic_submission(): \context {
        return \context_system::instance();
    }

    protected function check_access_for_dynamic_submission(): void {
           require_capability('local/tickets:submittickets', \context_system::instance());
    }

    public function set_data_for_dynamic_submission(): void {
        $this->set_data([
            'hidebuttons' => $this->optional_param('hidebuttons', false, PARAM_BOOL),
        ]);
    }

    public function process_dynamic_submission() {
        return $this->get_data();
    }

    protected function get_page_url_for_dynamic_submission(): \moodle_url {
        return new \moodle_url('/local/tickets');
    }

    /**
     * Form definition
     *
     * @return void
     */
    public function definition() {
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

        $mform->addElement('textarea', 'description', get_string('description'));
        $mform->setType('description', PARAM_NOTAGS);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');

        
        if (empty($this->_ajaxformdata['hidebuttons'])) {
            $this->add_action_buttons();
        }
    }
}
