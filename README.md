## Overview
This simple moodle plugin allows users to submit support tickets to communicate their issues and receive assistance from administrators.

## Features
- **Ticket Submission**: Users can submit tickets to express their needs or report issues.
- **View Tickets**: Users can view all tickets they've submitted along with their current statuses.
- **Comments**: Users can comment on their own tickets, while admins can comment on any ticket.
- **Management**: Administrators can view all submitted tickets and change their statuses to Open, Pending, Closed, or Solved.

## Requirements
- Moodle 4.1.3 (Build: 20230424)


## Installation

1. **Clone the Repository to {your/moodle/dirroot}/local/tickets**
     ```
     git clone https://github.com/3bood-kr/local_tickets.git
     ```

2. **Install the Plugin**
   - Log in to your Moodle site as an administrator and navigate to Site Administration > Notifications to complete the installation. <br>

   Alternatively, you can run:
    ```bash
    $ php admin/cli/upgrade.php
    ```
   to complete the installation from the command line.



## Contributing

Any contributions for this plugin are welcome. If you would like to contribute, please fork the repository and submit a pull request.

## Authors

- **Abdulrahman Kr** - *Owner* - [3bood-kr](https://github.com/3bood-kr)

## License

This plugin is released under the [GNU General Public License](http://www.gnu.org/copyleft/gpl.html).


