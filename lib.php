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
 * 
 * 
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Add ticket widget to footer.
 */
function local_tickets_before_footer() {
    global $PAGE, $USER;
    if (!get_config('local_tickets', 'showwidget')) {
        return;
    }
    // Show widget for logged in users only.
    if ($USER->id == 1 || !isset($USER->id)){
        return;
    }


    $excludepages = ['embedded', 'frametop', 'popup', 'print', 'redirect', 'admin']; // Removed: 'maintenance', 'report'.
    if (!in_array($PAGE->pagelayout, $excludepages)) { // Do not show on pages that may use $OUTPUT.

        echo "<button class='tickets-widget' data-action='opensubmitticketform'>?</button>";
        
        $PAGE->requires->js_call_amd(
            'local_tickets/modalforms',
            'modalForm',
            ['[data-action=opensubmitticketform]',
            \local_tickets\form\submitticketform::class,
            'local_tickets_submit_ticket',
            get_string('submit_ticket', 'local_tickets'),
            ['hidebuttons' => 1]],
        );
    }
}
