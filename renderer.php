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
 * Renderer for displaying local-tickets tickets as HTML.
 *
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_tickets\lib;

/**
 * The master renderer
 */
class local_tickets_renderer extends plugin_renderer_base {
    /**
     * Configuration data loaded from the config settings.
     *
     * @var 
     */
    private $cfg;

    /**
     * Database connection instance, used for database operations.
     *
     * @var \moodle_database
     */
    private $db;

    /**
     * Current user object containing user-specific data.
     *
     * @var \stdClass
     */
    private $user;

    /**
     * User Capabilities.
     *
     * @var bool[]
     */
    private $caps;

    /**
     * Constructor for the local_tickets_renderer class.
     */
    public function __construct(moodle_page $page, $target) {
        parent::__construct($page, $target);
        global $CFG, $DB, $USER;
        $this->cfg = $CFG;
        $this->db = $DB;
        $this->user = $USER;

        lib::init();
        $this->caps = lib::$caps;
    }

    /**
     * Display Index Page.
     * @return string HTML to output.
     */
    public function render_index_page() {
        $template = $this->inittemplate();

        $ownticketcount = lib::get_own_tickets_count();
        $template->ticketscount = $ownticketcount;
        return $this->output->render_from_template('local_tickets/index', $template);
    }

    /**
     * Display Manage Tickets Page.
     * @return string HTML to output.
     */
    public function render_manage_page($filterform) {

        if (!$this->caps['canmanagetickets']) {
            return 'You are not supposed to be here bro';
        }

        // Check for page param.
        $page = optional_param('page', 0, PARAM_INT);
        if ($page < 0) {
            $page = 0;
        }
        $limitfrom = ($page) * TICKETS_PAGE_SIZE;

        // Check for filter params.
        $params = [];
        $status = optional_param('status', '', PARAM_NOTAGS);
        $createdby = optional_param('created_by', '', PARAM_INT);
        if (!empty($status) && in_array($status, ['open', 'closed', 'solved', 'pending'])) {
            $params['status'] = $status;
        }
        if (!empty($createdby)) {
            $params['created_by'] = $createdby;
        }

        // Get tickets with params if params exist.
        $tickets = lib::get_tickets($limitfrom, $params);
        $tickets = lib::shortenticketscontent($tickets);

        $template = $this->inittemplate();

        // Send filtering form to template.
        $template->filterform = $filterform->render();
        if (!empty($tickets)) {
            // Send data to template.
            $template->hastickets = true;
            $template->tickets = $tickets;

            // Send pagination to template.
            $totalcount = lib::get_tickets_count($params);
            $template->ticketscount = $totalcount;
            if ($totalcount > TICKETS_PAGE_SIZE) {
                $pagedurl = new moodle_url('/local/tickets/manage.php', $params);
                $template->pager = $this->output->paging_bar($totalcount, $page , TICKETS_PAGE_SIZE, $pagedurl, 'page');
            }
        }
        return $this->output->render_from_template('local_tickets/manage', $template);
    }

    /**
     * Display View Ticket Page.
     * @return string HTML to output.
     */
    public function render_viewticket_page($ticketid, $ticketstatusform, $commentform) {
        $ticket = lib::get_ticket($ticketid);
        if (!$ticket) {
            return 'nah';
        }
        $canviewthisticket =
            $this->caps['canmanagetickets'] || $this->user->id == $ticket->created_by;
        if (!$canviewthisticket) {
            return "You Can't View This Ticket bro";
        }

        $userfields = 'id,firstname,lastname,username,picture,imagealt';
        $owner = \core_user::get_user($ticket->created_by, $userfields, MUST_EXIST);
        $updatedby = \core_user::get_user($ticket->updated_by, $userfields, MUST_EXIST);

        $template = $this->inittemplate();

        $template->ticket = $ticket;
        $template->updated_by_profile_img = $this->output->user_picture($updatedby);
        $template->updated_by_name = fullname($updatedby);

        $template->owner_profile_img = $this->output->user_picture($owner);
        $template->owner_name = fullname($owner);

        // Setting the default value for status to the one from the db record.
        if ($this->caps['canedittickets']) {
            $ticketstatusform->set_data(['status' => $ticket->status]);
            $template->statusform = $ticketstatusform->render();
        }

        $canpostcomments = lib::canpostcomment($ticketid);
        if ($canpostcomments) {
            $template->commentform = $commentform->render();
            if ($ticket->status == 'closed') {
                $template->commentformmessage = true;
            }
        }

        $comments = lib::get_comments($ticketid);
        $template->comments = $comments;

        return $this->output->render_from_template('local_tickets/viewticket', $template);
    }

    /**
     * Display Submit Ticket Page.
     * @return string HTML to output.
     */
    public function render_submit_ticket_page($submitticketform) {
        $template = $this->inittemplate();

        if ($this->caps['cansubmittickets']) {
            $template->submitticketform = $submitticketform->render();
        }
        return $this->output->render_from_template('local_tickets/submit', $template);
    }

    /**
     * Display My Tickets Page.
     * @return string HTML to output.
     */
    public function render_mytickets_page() {
        $tickets = lib::get_own_tickets();

        $template = $this->inittemplate();
        $template->mytickets = $tickets;
        $template->ticketscount = count($tickets);

        return $this->output->render_from_template('local_tickets/mytickets', $template);
    }

    /**
     * Initialize Submit Ticket Page.
     * @return stdClass
     */
    private function inittemplate() {
        $template = new stdClass();
        foreach ($this->caps as $key => $cap) {
            if ($cap) {
                $template->$key = true;
            }
        }
        return $template;
    }
}
