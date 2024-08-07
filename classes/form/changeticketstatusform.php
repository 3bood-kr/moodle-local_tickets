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

namespace local_tickets\form;

use local_tickets\lib;

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
class changeticketstatusform extends \core_form\dynamic_form {

    /**
     * Returns form context
     *
     * If context depends on the form data, it is available in $this->_ajaxformdata or
     * by calling $this->optional_param()
     *
     * @return \context
     */
    protected function get_context_for_dynamic_submission(): \context {
        return \context_system::instance();
    }

    /**
     * Check if current user has access to this form, otherwise throw exception
     *
     */
    protected function check_access_for_dynamic_submission(): void {
        require_capability('local/tickets:edittickets', \context_system::instance());
    }

    /**
     * Load in existing data as form defaults
     *
     */
    public function set_data_for_dynamic_submission(): void {
        // Ticket id.
        $id = $this->_ajaxformdata['id'];
        lib::init();
        $ticketstatus = lib::get_ticket($id)->status;
        // Set Default data for dynamic form.
        $this->set_data([
            'hidebuttons' => $this->optional_param('hidebuttons', true, PARAM_BOOL),
            'id' => $id,
            'status' => $ticketstatus,
        ]);
    }

    /**
     * Process the form submission, used if form was submitted via AJAX
     *
     * This method can return scalar values or arrays that can be json-encoded, they will be passed to the caller JS.
     *
     * Submission data can be accessed as: $this->get_data()
     *
     * @return ['status' => int, 'message'=> string]
     */
    public function process_dynamic_submission() {
        $formdata = $this->get_data();
        lib::init();
        $success = lib::changeticketstatus($formdata);
        if ($success) {
            return [
                'status' => 200,
                'message' => get_string('status_change_success', 'local_tickets'),
            ];
        }
        return [
            'status' => 500,
            'message' => get_string('status_change_fail', 'local_tickets'),
        ];
    }

    /**
     * Returns url to set in $PAGE->set_url() when form is being rendered or submitted via AJAX
     *
     * This is used in the form elements sensitive to the page url, such as Atto autosave in 'editor'
     *
     * @return \moodle_url
     */
    protected function get_page_url_for_dynamic_submission(): \moodle_url {
        return new \moodle_url('/local/tickets');
    }

    /**
     * Form definition
     *
     * @return void
     */
    protected function definition() {
        global $PAGE;
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

        // Hidden element for the ticket set in set_data_for_dynamic_submission().
        $mform->addElement('hidden', 'id', '');
        $mform->setType('id', PARAM_INT);
        
        if($this->_customdata['ticketid']){
            $mform->setDefault('id', $this->_customdata['ticketid']);
        }

        $mform->addElement('hidden', 'hidebuttons');
        $mform->setType('hidebuttons', PARAM_BOOL);
        if (!$this->_ajaxformdata['hidebuttons']) {
            $this->add_action_buttons();
        }
    }
}
