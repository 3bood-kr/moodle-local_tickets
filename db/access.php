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
 * Define capabilities
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'local/tickets:submittickets' => [
        'riskbitmask'               => RISK_SPAM,
        'captype'                   => 'write',
        'contextlevel'              => CONTEXT_SYSTEM,
        'archetypes' => [
            'user'                  => CAP_ALLOW,
        ],
    ],
    'local/tickets:deletetickets' => [
        'riskbitmask'               => RISK_DATALOSS,
        'captype'                   => 'delete',
        'contextlevel'              => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager'               => CAP_ALLOW,
            'coursecreator'         => CAP_PREVENT,
            'editingteacher'        => CAP_PREVENT,
            'teacher'               => CAP_PREVENT,
            'student'               => CAP_PREVENT,
            'user'                  => CAP_PREVENT,
        ],
    ],
    'local/tickets:edittickets' => [
        'riskbitmask'               => RISK_DATALOSS,
        'captype'                   => 'edit',
        'contextlevel'              => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager'               => CAP_ALLOW,
            'coursecreator'         => CAP_PREVENT,
            'editingteacher'        => CAP_PREVENT,
            'teacher'               => CAP_PREVENT,
            'student'               => CAP_PREVENT,
            'user'                  => CAP_PREVENT,
        ],
    ],
    'local/tickets:viewtickets' => [
        'riskbitmask'               => RISK_SPAM,
        'captype'                   => 'read',
        'contextlevel'              => CONTEXT_SYSTEM,
        'archetypes' => [
            'manager'               => CAP_ALLOW,
            'coursecreator'         => CAP_PREVENT,
            'editingteacher'        => CAP_PREVENT,
            'teacher'               => CAP_PREVENT,
            'student'               => CAP_PREVENT,
            'user'                  => CAP_PREVENT,
        ],
    ],
];
