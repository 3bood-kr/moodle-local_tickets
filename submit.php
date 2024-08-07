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
 * Submit Ticket Page
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_tickets\form\submitticketform;
use local_tickets\lib;

require_once(__DIR__ . '/../../config.php');
require_login();

require_once($CFG->dirroot . '/local/tickets/classes/form/submitticketform.php');

$PAGE->set_url(new moodle_url('/local/tickets/submit.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Submit a ticket');

$renderer = $PAGE->get_renderer('local_tickets');

$mform = new submitticketform();

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/local/tickets/index.php');
}

if ($mform->is_submitted() && $formdata = $mform->get_data()) {
    if (lib::submit_ticket($formdata)) {
        redirect($CFG->wwwroot . '/local/tickets/mytickets.php', 'Ticket Submitted Successfully');
    }
}

echo $OUTPUT->header();
echo $renderer->render_submit_ticket_page($mform);
echo $OUTPUT->footer();
