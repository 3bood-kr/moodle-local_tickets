## Overview
This Moodle plugin provides a ticketing system that allows users to easily submit support tickets to share their concerns and get help from administrators.

## Features
- **Widget Feature**: Tickets can be submitted from any page via a modal form.
- **Comments**: Users and administrators can add comments on tickets.
- **Management**: Administrators can update ticket statuses to Open, Pending, Closed, or Solved.

## Compatibility

- **Moodle Version**: This plugin was created using Moodle 4.1.3 (Build: 20230424) and it works great there. If you try it on other versions and it works, please let me know!


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

Any contributions for this plugin are welcome. If you would like to contribute, here are a few tasks you might consider:
- [ ] **Add Pagination for Comments in View Ticket Page** 
- [ ] **Add Pagination for My Tickets Page** 
- [ ] **Create Events for logging**
- [ ] **Soft Deletes**
- [ ] **Automatic Ticket Closing**
- [ ] **Send Email Notifications**
- [ ] **PHPdoc and Code checker**

## Authors

- **Abdulrahman Kr** - *Owner* - [3bood-kr](https://github.com/3bood-kr)

## License

Feel free to use and modify this plugin. It's under the GNU General Public License, which means it's free for everyone!
