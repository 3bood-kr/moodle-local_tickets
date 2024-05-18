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

use local_tickets\lib;

/**
 * Add ticket widget to footer.
 */
function local_tickets_before_footer() {
    global $PAGE, $USER, $OUTPUT;
    lib::init();
    // Show widget for logged in users only.
    if (!lib::is_logged_in()) {
        return;
    }

    // Removed: 'maintenance', 'report'.
    $excludepages = ['embedded', 'frametop', 'popup', 'print', 'redirect'];
    if (!in_array($PAGE->pagelayout, $excludepages)) { // Do not show on pages that may use $OUTPUT.
        
        // If can manage tickets then open manage modal dialouge otherwise submit form.
        if (lib::$caps['canmanagetickets']) {
            $data = ['dataaction' => 'openmodaldialouge', 'title' => get_string('manage_tickets', 'local_tickets')];
            echo $OUTPUT->render_from_template(
                'local_tickets/widget',
                $data,
            );
            $PAGE->requires->js_call_amd(
                'local_tickets/modaldialouge',
                'init',
                ['[data-action=openmodaldialouge]'],
            );
            return;
        }
        $data = ['dataaction' => 'opensubmitticketform', 'title' => get_string('submit_ticket', 'local_tickets')];
        echo $OUTPUT->render_from_template('local_tickets/widget', $data);
        $PAGE->requires->js_call_amd(
            'local_tickets/modalforms',
            'modalForm',
            ['[data-action=opensubmitticketform]',
            \local_tickets\form\submitticketform::class,
            get_string('submit_ticket', 'local_tickets'),
            ['hidebuttons' => 1]],
        );
    }
}

function local_tickets_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $DB;

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false;
    }

    require_login();

    // Make sure the filearea is one of those used by local_tickets plugin.
    if ($filearea != 'attachment') {
        return false;
    }

    $itemid = (int)array_shift($args);


    $fs = get_file_storage();

    $filename = array_pop($args);
    if (empty($args)) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }

    $file = $fs->get_file($context->id, 'local_tickets', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false;
    }

    // finally send the file
    send_stored_file($file, 0, 0, true, $options); // download MUST be forced - security!
}
