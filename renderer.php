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
 * @package    local_tickets
 * @copyright  2024 3bood_kr
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_tickets\lib;

defined('MOODLE_INTERNAL') || die();



/**
 * The master renderer
 */

class local_tickets_renderer extends plugin_renderer_base {

    // A local, lighly modified Mustache engine.
    private $mustache;
    private $CFG, $DB, $USER, $context;
    private $caps;
    public function __construct(moodle_page $page, $target)
    {
        parent::__construct($page, $target);
        global $CFG, $DB, $USER;
        $this->CFG = $CFG;
        $this->DB = $DB;
        $this->USER = $USER;
        $this->context = context_system::instance();

        lib::init();
        $this->caps = lib::$caps;
    }

    public function render_index_page(){
        $template = $this->initTemplate();

        $ownticketcount = lib::get_own_tickets_count();
        $template->ticketscount = $ownticketcount;
        return $this->output->render_from_template('local_tickets/index', $template);
    }

    public function render_manage_page($filterform){

        if(!$this->caps['canmanagetickets']){
            return 'You are not supposed to be here bro';
        }

        // check for page param
        $page = optional_param('page', 0, PARAM_INT);
        if ($page < 0) {
            $page = 0;
        }
        $limitfrom = ($page) * TICKETS_PAGE_SIZE;

        //check for filter params
        $params = array();
        $status = optional_param('status', '', PARAM_NOTAGS);
        $created_by = optional_param('created_by', '', PARAM_INT);
        if(!empty($status) && in_array($status, ['open', 'closed', 'solved', 'pending'])){
            $params['status'] = $status;
        }
        if(!empty($created_by)){
            $params['created_by'] = $created_by;
        }

        // get tickets with params if params exist.
        $tickets = lib::get_tickets($limitfrom, $params);
        $tickets = lib::shortenticketscontent($tickets);

        $template = $this->initTemplate();

        // send filtering form to template
        $template->filterform = $filterform->render();
        if(!empty($tickets)){
            //send data to template
            $template->hastickets = true;
            $template->tickets = $tickets;

            // send pagination to template
            $totalcount = lib::get_tickets_count($params);
            $template->ticketscount = $totalcount;
            if ($totalcount > TICKETS_PAGE_SIZE) {
                $pagedurl = new moodle_url('/local/tickets/manage.php', $params);
                $template->pager = $this->output->paging_bar($totalcount, $page , TICKETS_PAGE_SIZE, $pagedurl, 'page');
            }
        }

        return $this->output->render_from_template('local_tickets/manage', $template);
    }

    public function render_viewticket_page($ticketid, $ticketstatusform, $commentform){
        $action = optional_param('action', '', PARAM_NOTAGS);

        if($action == 'delete'){
            if(lib::delete_ticket($ticketid)){
                redirect(new moodle_url($this->CFG->wwwroot . '/local/tickets/manage.php'), 'removed successfully');
            }
        }


        $ticket = lib::get_ticket($ticketid);
        if(!$ticket){
            return 'nah';
        }
        $canviewthisticket =
            $this->caps['canmanagetickets'] || $this->USER->id == $ticket->created_by;
        if(!$canviewthisticket){
            return "You Can't View This Ticket bro";
        }

        $userfields = 'id,firstname,lastname,username,picture,imagealt';
        $owner = \core_user::get_user($ticket->created_by, $userfields, MUST_EXIST);
        $updated_by = \core_user::get_user($ticket->updated_by, $userfields, MUST_EXIST);

        $template = $this->initTemplate();

        $template->ticket = $ticket;
        $template->updated_by_profile_img = $this->output->user_picture($updated_by);
        $template->updated_by_name = fullname($updated_by);

        $template->owner_profile_img = $this->output->user_picture($owner);
        $template->owner_name = fullname($owner);

        // setting the default value for status to the one from the db record
        if($this->caps['canedittickets']){
            $ticketstatusform->set_data(['status' => $ticket->status]);
            $template->statusform = $ticketstatusform->render();
        }

        //
        $canpostcomments = lib::canpostcomment($ticketid);
        if($canpostcomments){
            $template->commentform = $commentform->render();
            if($ticket->status == 'closed'){
                $template->commentformmessage = true;
            }
        }

        $comments = lib::get_comments($ticketid);
        $template->comments = $comments;

        return $this->output->render_from_template('local_tickets/viewticket', $template);
    }

    public function render_submit_ticket_page($submitticketform){
        $template = $this->initTemplate();

        if($this->caps['cansubmittickets']){
            $template->submitticketform = $submitticketform->render();
        }
        return $this->output->render_from_template('local_tickets/submit', $template);
    }

    public function render_mytickets_page(){
        $tickets = lib::get_own_tickets();

        $template = $this->initTemplate();
        $template->mytickets = $tickets;
        $template->ticketscount = count($tickets);

        return $this->output->render_from_template('local_tickets/mytickets', $template);
    }

    private function initTemplate(){
        $template = new stdClass();
        foreach ($this->caps as $key => $cap){
            if($cap){
                $template->$key = true;
            }
        }
        return $template;
    }

}