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
 * Local Tickets library code.
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_tickets;

use context_system;
use context_user;
use moodle_url;
use stdClass;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/mod/forum/lib.php');

/**
 * Local Tickets library code.
 *
 * Lib that contiains functions
 * for crud operations and some
 * other stuff
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class lib {

    /**
     * User Capabilities.
     *
     * @var bool[]
     */
    public static $caps;

    /**
     * Init function.
     *
     * should be called before using
     * this class
     *
     * @return \stdClass on success.
     */
    public static function init() {
        global $USER;
        $context = context_system::instance();
        self::$caps['canviewtickets'] = has_capability('local/tickets:viewtickets', $context);
        self::$caps['candeletetickets'] = has_capability('local/tickets:deletetickets', $context);
        self::$caps['cansubmittickets'] = has_capability('local/tickets:submittickets', $context);
        self::$caps['canedittickets'] = has_capability('local/tickets:edittickets', $context);
        self::$caps['canmanagetickets'] = self::canmanagetickets();
    }

    /**
     * Get all tickets.
     *
     * @return \stdClass on success.
     */
    public static function get_tickets($limitfrom = null, $conditions=null, $sort='created_at DESC') {
        global $DB, $USER;
        $tickets = array_values($DB->get_records('local_tickets', $conditions, $sort, '*', $limitfrom, 15));
        $tickets = self::format_tickets($tickets);
        $tickets = self::shortenticketscontent($tickets);
        return $tickets;
    }

    /**
     * Get the tickets for this userid.
     * @param userid.
     * @return \stdClass on success.
     */
    public static function get_tickets_by_user($userid) {
        global $DB;
        if (empty($userid)) {
            return;
        }
        $ticket = $DB->get_record('local_tickets', ['created_by' => $userid]);
        $ticket = self::format_tickets($ticket);
        return $ticket;
    }

    /**
     * Get the tickets for current authorized user.
     * @return \stdClass[] on success.
     */
    public static function get_own_tickets() {
        global $DB, $USER;
        $tickets = array_values($DB->get_records('local_tickets', ['created_by' => intval($USER->id)], 'created_at DESC'));
        $tickets = self::format_tickets($tickets);
        $tickets = self::shortenticketscontent($tickets);
        return $tickets;
    }

    /**
     * Get the ticket by ticket id.
     * @param $ticketid.
     * @return \stdClass on success.
     */
    public static function get_ticket($ticketid) {
        global $DB;
        if (empty($ticketid)) {
            return null;
        };
        $ticket = $DB->get_record('local_tickets', ['id' => $ticketid]);
        $ticket = self::format_tickets($ticket);
        return $ticket;
    }

    /**
     * Get count of all tickets.
     * @return integer on success.
     */
    public static function get_all_tickets_count() {
        global $DB;
        $count = $DB->count_records('local_tickets');
        return $count;
    }

    /**
     * Get tickets count with params.
     * @return integer on success.
     */
    public static function get_tickets_count($params) {
        global $DB;
        $count = $DB->count_records('local_tickets', $params);
        return $count;
    }

    /**
     * Get the own tickets count.
     * @return integer on success.
     */
    public static function get_own_tickets_count() {
        global $DB, $USER;
        $count = $DB->count_records('local_tickets', ['created_by' => $USER->id]);
        return $count;
    }

    /**
     * Submit ticket.
     * @param $fromdata.
     * @return boolean on success.
     */
    public static function changeticketstatus($fromdata) {
        if (!self::$caps['canedittickets']) {
            return false;
        }
        global $DB, $USER;
        $record = new stdClass();
        $record->id = $fromdata->id;
        $record->status = $fromdata->status;
        $record->updated_at = time();
        $record->updated_by = $USER->id;
        $success = $DB->update_record('local_tickets', $record);
        if (!$success) {
            return false;
        }
        return true;
    }

    /**
     * Delete ticket by ticket id.
     * @param $ticketid.
     * @return boolean on success.
     */
    public static function delete_ticket($ticketid) {
        if (empty($ticketid)) {
            return false;
        }
        global $DB, $USER;
        $ticket = $DB->get_record('local_tickets', ['id' => $ticketid], 'created_by');
        if($USER->id != $ticket->created_by && !self::$caps['candeletetickets']){
            return false;
        }
        $success = $DB->delete_records('local_tickets', ['id' => $ticketid]);
        return $success;
    }

    /**
     * Submit Ticket.
     * @param $formdata.
     * @return boolean on success.
     */
    public static function submit_ticket($formdata) {
        if (!self::$caps['cansubmittickets'] || !$formdata) {
            return false;
        }
        global $USER, $DB;
        $record = new stdClass();
        $record->title = $formdata->title;
        $record->mobile = $formdata->mobile;
        $record->email = $formdata->email;
        $record->description = $formdata->description;
        $record->created_by = $USER->id;
        $record->created_at = time();
        $record->updated_at = time();
        $record->updated_by = $USER->id;
        $ticketid = $DB->insert_record('local_tickets', $record, true);
        if($ticketid){
            // Save Files.
            $context = context_system::instance();
            file_save_draft_area_files($formdata->attachments, $context->id, 'local_tickets', 'attachment', $ticketid);
            // Notify Managers that a new ticket is submitted.
            self::send_notification($ticketid);
        }
        return $ticketid;
    }

    /**
     * Post a comment.
     * @param $formdata.
     * @return boolean on success.
     */
    public static function post_comment($formdata) {
        $ticketid = $formdata->id;
        if (!$ticketid || !self::canpostcomment($ticketid)) {
            return false;
        }

        global $USER, $DB;
        $record = new stdClass();
        $record->ticket_id = $ticketid;
        $record->created_by = $USER->id;
        $record->content = $formdata->comment;
        $record->created_at = time();

        $success = $DB->insert_record('local_tickets_comments', $record);

        return $success;
    }

    /**
     * Get the comment for certain ticket.
     * @param $ticketid.
     * @return \stdClass[] on success.
     */
    public static function get_comments($ticketid, $limitfrom, $conditions=null, $sort='created_at DESC') {
        global $DB;
        $comments = $DB->get_records('local_tickets_comments', ['ticket_id' => $ticketid] , $sort, '*', $limitfrom, COMMENTS_PAGE_SIZE);
        $comments = self::get_formatted_comments($comments);
        return $comments;
    }

        /**
     * Get count of ticket comments.
     * @return integer on success.
     */
    public static function get_comments_count($ticketid) {
        global $DB;
        $count = $DB->count_records('local_tickets_comments', ['ticket_id' => $ticketid]);
        return $count;
    }

    /**
     * Get comments but each with own user pic and name.
     * @param $comments.
     * @return \stdClass[] on success.
     */
    private static function get_formatted_comments($comments) {
        global $DB, $PAGE;
        $comments = array_values($comments);

        $usersids = [];
        for ($i = 0; $i < count($comments); $i++) {
            if (in_array($comments[$i]->created_by, $usersids)) {
                continue;
            }
            $usersids[] = $comments[$i]->created_by;
        }
        $users = $DB->get_records_list('user', 'id', $usersids, '', 'id,firstname,lastname,username,picture,imagealt');
        $users = array_values($users);

        $renderer = $PAGE->get_renderer('core');
        for ($i = 0; $i < count($comments); $i++) {
            for ($j = 0; $j < count($users); $j++) {
                if ($comments[$i]->created_by == $users[$j]->id) {
                    $comments[$i]->owner_profile_picture = $renderer->user_picture($users[$j], ['size' => 50]);
                    $comments[$i]->owner_name = fullname($users[$j]);
                    break;
                }
            }
            // Also format comment date.
            $comments[$i]->created_at = userdate($comments[$i]->created_at, '%a, %b %d,%Y, %I:%M %p');
        }
        return $comments;
    }

    /**
     * Get the tickets with formatted date.
     * @return \stdClass on success.
     */
    private static function format_tickets($tickets) {
        // Formdat Date.
        $format = '%d, %m, %Y, %I:%M %p';
        if ($tickets instanceof \stdClass) {
            // Get the current language
            $tickets->created_at = userdate($tickets->created_at, $format);
            $tickets->updated_at = userdate($tickets->updated_at, $format);

            // Add Localized status string.
            $tickets->localizedstatus = get_string($tickets->status, 'local_tickets');
        }
        if (is_array($tickets)) {
            for ($i = 0; $i < count($tickets); $i++) {
                $tickets[$i]->created_at = userdate($tickets[$i]->created_at, $format);
                $tickets[$i]->updated_at = userdate($tickets[$i]->updated_at, $format);
                $tickets[$i]->localizedstatus = get_string($tickets[$i]->status, 'local_tickets');
            }
        }
        return $tickets;
    }



    /**
     * Check if user can post comment to a certain ticket.
     * * @param $ticketid.
     * @return boolean.
     */
    public static function canpostcomment($ticketid) {
        global $DB;
        $ticket = $DB->get_record('local_tickets', ['id' => $ticketid]);
        if (self::$caps['canmanagetickets'] === true || $ticket->status == 'open'
        ) {
            return true;
        }
        return false;
    }

    /**
     * Shortens Ticket Title and Description for tables.
     * * @param $ticketid.
     * @return boolean.
     */
    public static function shortenticketscontent($tickets) {
        for ($i = 0; $i < count($tickets); $i++) {
            if (strlen($tickets[$i]->title) > 10) {
                $tickets[$i]->title = substr($tickets[$i]->title, 0, 10) . '...';
            }
            if (strlen($tickets[$i]->description) > 10) {
                $tickets[$i]->description = substr($tickets[$i]->description, 0, 10) . '...';
            }
        }
        return $tickets;
    }

    /**
     * Check if user manage tickets.
     * * @param $ticketid.
     * @return boolean.
     */
    public static function canmanagetickets() {
        foreach (self::$caps as $key => $cap) {
            if ($key != 'cansubmittickets' && $cap) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user is logged in.
     * *
     * @return boolean.
     */
    public static function is_logged_in() {
        global $USER;
        if ($USER->id == 0 || $USER->id == 1) {
            return false;
        }
        return true;
    }

    /**
     * Send Notification for admin.
     * *
     * @return boolean.
     */
    public static function send_notification($id){

        $capabilities = ['local/tickets:edittickets', 'local/tickets:deletetickets'];
        $users =  get_users_by_capability(context_system::instance(), $capabilities);

        $message = new \core\message\message();
        $message->component = 'moodle';
        $message->name = 'notices';
        $message->courseid = SITEID;
        $message->userfrom = \core_user::get_noreply_user();
        $message->subject = get_string('new_ticket_submitted', 'local_tickets');
        $message->fullmessage = get_string('new_ticket_submitted', 'local_tickets');
        $message->fullmessageformat = FORMAT_HTML;
        $message->fullmessagehtml = get_string('new_ticket_submitted', 'local_tickets');
        $message->smallmessage = get_string('new_ticket_submitted', 'local_tickets');
        $contexturl = new moodle_url('/local/tickets/view.php', ['id' => $id]);
        $message->contexturl = $contexturl->out();
        $message->contexturlname = 'Ticket';

        foreach($users as $user){
            $message->userto = $user;
            message_send($message);
        }

    }

    /**
     * Check if user is logged in.
     * *
     * .
     */
    public static function index_redirect() {
        global $USER;
        self::init();
        if (self::$caps['canmanagetickets']) {
            redirect(new moodle_url('/local/tickets/manage.php'));
        }
        redirect(new moodle_url('/local/tickets/mytickets.php'));
    }

}
