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

use local_tickets\lib;

require_once(__DIR__ . '/../../../../config.php');
require_once($CFG->libdir . '/filelib.php');


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
           require_capability('local/tickets:submittickets', \context_system::instance());
    }

    /**
     * Load in existing data as form defaults
     *
     */
    public function set_data_for_dynamic_submission(): void {
        $this->set_data([
            'hidebuttons' => $this->optional_param('hidebuttons', false, PARAM_BOOL),
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
        $success = lib::submit_ticket($formdata);
        
        if ($success) {
            return [
                'status' => 200,
                'message' => get_string('ticket_submission_success', 'local_tickets'),
            ];
        }
        return [
            'status' => 500,
            'message' => get_string('ticket_submission_fail', 'local_tickets'),
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
        $mform->addHelpButton('mobile', 'mobile', 'local_tickets');

        $mform->addElement('textarea', 'description', get_string('description'));
        $mform->setType('description', PARAM_NOTAGS);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');
        
        $maxbytes = 10485760; // 10MB.
        $mform->addElement(
            'filemanager',
            'attachments',
            get_string('attachment', 'moodle'),
            null,
            [
                'subdirs' => 0,
                'maxbytes' => $maxbytes,
                'areamaxbytes' => 10485760,
                'maxfiles' => 50,
                'accepted_types' => ['.jpg', '.jpeg', '.png', '.mp4', '.avi', '.mov'],
                'return_types' => $CFG->FILE_INTERNAL | $CFG->FILE_EXTERNAL,
            ]
        );

        if (empty($this->_ajaxformdata['hidebuttons'])) {
            $this->add_action_buttons();
        }
    }
}
