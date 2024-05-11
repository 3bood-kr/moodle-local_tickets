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
 * Add page to admin menu.
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_tickets', get_string('pluginname', 'local_tickets'));

    $settings->add(new admin_setting_configcheckbox(
        'local_tickets/requirelogin',
        get_string('require_login', 'local_tikcets'),
        get_string('require_login_desc', 'local_tickets'),
        '1'
    ));

    $settings->add(new admin_setting_heading(
        'local_yourplugin/emailnotifications',
        get_string('emailnotifications', 'local_tickets'),
        ''
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_tickets/sendemailonstatuschange',
        get_string('send_email_on_status_change', 'local_tikcets'),
        get_string('send_email_on_status_change_desc', 'local_tickets'),
        '1'
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_tickets/sendemailoncommentsadd',
        get_string('send_email_on_comments_add', 'local_tikcets'),
        get_string('send_email_on_comments_add_desc', 'local_tickets'),
        '1'
    ));

    $ADMIN->add('localplugins', $settings);
}
