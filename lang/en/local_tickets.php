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

$string['pluginname'] = 'Tickets Support';
$string['modulename'] = 'Tickets Support';
$string['pluginadministration'] = 'Ticckets administration';

// Capabilities.

$string['strictworkflow_help'] = '
When enabled, each specific internal role in tracker (reporter, developer, resolvers, manager) will only have access to his
accessible states against his role.
';

$string['networkable_help'] = 'If enabled, this tracker will be openly exposed to remote site. Users from remote site will
be able to post even if they have no local account. A Mnet account will be created on the fly. This will though only
be possible if tracker Mnet services are properly configurated each side.';

$string['failovertrackerurl_help'] = '
Using tracker inside Moodle may not address situation where moodle itself is down or working improperly. When giving a failover tracker url,
you provide users with an information about an alternate URL they can use in case of major desease. Users will be invited to bookmark the URL in their
own data to get it when needed.
';

$string['failovertrackerurl_tpl'] = '
In case this tracker is not reachable or not available, you may post a signal into the <a href="{$a}">emergency tracker</a>.
You should bookmark this URL
to get the link available even if Moodle is down or not operable properly.
';


$string['status'] = 'Status';
$string['ticket_id'] = 'Ticket ID';
$string['reported_by'] = 'Reported by';
$string['report_date'] = 'Reported Date';
$string['last_updated_by'] = 'Last Updated by';
$string['last_updated_at'] = 'Last Updated at';
$string['closed_comments_message'] = "Comments are closed, but you can post comments since you're an admin.";
$string['comment'] = 'Comment';
$string['comments'] = 'Comments';
$string['post_comment'] = 'Post Comment';
$string['open'] = 'Open';
$string['closed'] = 'Closed';
$string['pending'] = 'Pending';
$string['solved'] = 'Solved';
$string['view_my_tickets'] = 'View My Tickets';
$string['manage_tickets'] = 'Manage Tickets';
$string['id'] = 'ID';
$string['created_at'] = 'Created at';
$string['created_by'] = 'Created by';
$string['title'] = 'Title';
$string['description'] = 'Description';
$string['operation'] = 'Operation';
$string['num_records'] = '{$a} Records';
$string['you_have_num_tickets'] = 'You Have {$a} Tickets.';
$string['all'] = 'All';
$string['mobile'] = 'Mobile';
$string['invalidmobile'] = 'Invalid Mobile Number';

$string['filter_by_user_help'] = 'User Id';


