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
 * Manage Tickets Page of
 * local tickets plugin
 *
 * This Page is for admins only
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_tickets\lib;
require_once(__DIR__ . '/../../config.php');
require_login();

require_once($CFG->dirroot . '/local/tickets/classes/form/filter_tickets.php');

define('TICKETS_PAGE_SIZE', 15);

$PAGE->set_url(new moodle_url('/local/tickets/manage.php'));
global $USER;

$PAGE->set_context(context_system::instance());
$PAGE->set_title('Manage Tickets');

$PAGE->requires->js_call_amd('local_tickets/deletepopup', 'init');

$filterform = new filter_tickets();

$action = optional_param('action', '', PARAM_NOTAGS);
if ($action == 'delete') {
    $ticketid = optional_param('id', '', PARAM_NOTAGS);
    lib::init();
    if (lib::delete_ticket($ticketid)) {
        redirect(new moodle_url($CFG->wwwroot . '/local/tickets/manage.php'), 'removed successfully');
    }
}

$PAGE->requires->js_call_amd(
    'local_tickets/modalforms',
    'changeStatusModalForms',
    ['[data-action=openchangestatusform]',
    \local_tickets\form\changeticketstatusform::class,
    ['hidebuttons' => 1]],
);

$PAGE->requires->js_call_amd(
    'local_tickets/filterform',
    'init',
);

$renderer = $PAGE->get_renderer('local_tickets');

echo $OUTPUT->header();

echo $renderer->render_manage_page($filterform);

echo $OUTPUT->footer();
