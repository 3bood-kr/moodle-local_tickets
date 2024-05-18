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
 * Language Strings
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['all'] = 'All';
$string['closed'] = 'Closed';
$string['closed_comments_message'] = "Comments are closed, but you can post comments since you're an admin.";
$string['comment'] = 'Comment';
$string['comments'] = 'Comments';
$string['created_at'] = 'Created at';
$string['created_by'] = 'Created by';
$string['description'] = 'Description';
$string['failovertrackerurl_help'] = '
Using tracker inside Moodle may not address situation where Moodle itself is down or working improperly. When giving a failover tracker URL,
you provide users with information about an alternate URL they can use in case of major disease. Users will be invited to bookmark the URL in their
own data to get it when needed.
';
$string['failovertrackerurl_tpl'] = '
In case this tracker is not reachable or not available, you may post a signal into the <a href="{$a}">emergency tracker</a>.
You should bookmark this URL
to get the link available even if Moodle is down or not operable properly.
';
$string['filter_by_user_help'] = 'User Id';
$string['id'] = 'ID';
$string['invalidmobile'] = 'Invalid Mobile Number';
$string['last_updated_at'] = 'Last Updated at';
$string['last_updated_by'] = 'Last Updated by';
$string['manage_tickets'] = 'Manage Tickets';
$string['mobile'] = 'Mobile';
$string['mobile_help'] = '
Example:
+962555555555';
$string['modulename'] = 'Tickets Support';
$string['networkable_help'] = 'If enabled, this tracker will be openly exposed to remote site. Users from remote site will
be able to post even if they have no local account. A Mnet account will be created on the fly. This will though only
be possible if tracker Mnet services are properly configurated each side.';
$string['new_ticket_submitted'] = 'New Ticket Have Been Submitted';
$string['num_records'] = '{$a} Records';
$string['open'] = 'Open';
$string['operation'] = 'Operation';
$string['pending'] = 'Pending';
$string['pluginadministration'] = 'Tickets administration';
$string['pluginname'] = 'Tickets Support';
$string['post_comment'] = 'Post Comment';
$string['report_date'] = 'Reported Date';
$string['reported_by'] = 'Reported by';
$string['require_login'] = 'Require Login';
$string['require_login_desc'] = 'Allow only Logged in Users To Submit Tickets';
$string['send_email_on_comments_add'] = 'Comments Added';
$string['send_email_on_comments_add_desc'] = 'Send Email to Ticket Owner When the comments are added to their ticket.';
$string['send_email_on_status_change'] = 'Status Change';
$string['send_email_on_status_change_desc'] = 'Send Email to Ticket Owner When the status of a ticket changes.';
$string['show_widget'] = 'Show Widget';
$string['show_widget_desc'] = 'Show fixed widget wutton on bottom left of screen.';
$string['solved'] = 'Solved';
$string['status'] = 'Status';
$string['strictworkflow_help'] = '
When enabled, each specific internal role in tracker (reporter, developer, resolvers, manager) will only have access to his
accessible states against his role.
';
$string['submit_ticket'] = 'Submit Ticket';
$string['ticket_id'] = 'Ticket ID';
$string['title'] = 'Title';
$string['view_my_tickets'] = 'View My Tickets';
$string['you_have_num_tickets'] = 'You Have {$a} Tickets.';
$string['attachments'] = 'Attachments';
$string['ticket_submission_success'] = 'Ticket Submitted Succefully';
$string['ticket_submission_fail'] = 'Failed to Submit Ticket.';
$string['status_change_success'] = 'Status Changed Successfully.';
$string['status_change_fail'] = 'Failed to Change Status.';
$string['new_ticket_submitted'] = 'A New Ticket Have Been Submitted.';
$string['filter'] = 'Filter';