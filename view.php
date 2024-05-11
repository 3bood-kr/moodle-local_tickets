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
 * View Ticket Page
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


use local_tickets\lib;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/tickets/classes/form/change_ticket_status.php');
require_once($CFG->dirroot . '/local/tickets/classes/form/comments.php');
require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_title('View Ticket');

$renderer = $PAGE->get_renderer('local_tickets');
$ticketid = required_param('id', PARAM_INT);

$statusform = new change_ticket_status();
$commentform = new comments();

if ($statusform->is_cancelled()) {
    redirect(new moodle_url($CFG->wwwroot . '/local/tickets/manage.php'));
}
if ($statusform->is_submitted() && $formdata = $statusform->get_data()) {
    if (lib::changeticketstatus($formdata)) {
        redirect(new moodle_url($CFG->wwwroot . '/local/tickets/manage.php'), 'Status Changed Successfully');
    }
}

if ($commentform->is_submitted() && $commentdata = $commentform->get_data()) {
    if (lib::post_comment($commentdata)) {
        redirect(new moodle_url($CFG->wwwroot . '/local/tickets/view.php', ['id' => $commentdata->id]), 'Comment Added Succefully');
    }
}

echo $OUTPUT->header();

echo $renderer->render_viewticket_page($ticketid, $statusform, $commentform);

echo $OUTPUT->footer();
