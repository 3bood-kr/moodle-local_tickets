## Overview
This Moodle plugin provides a ticketing system that allows users to easily submit support tickets to share their concerns and get help from administrators.

## Features
- **Widget Feature**: Tickets can be submitted and managed from any page via a modal form, with pagination for easier navigation.
- **Comments**: Users and administrators can add comments on tickets.
- **Media**: Media can be uploaded with tickets.

## Compatibility

- **Moodle Version**: This plugin was created using Moodle 4.2 (Build: 20230424).


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
   
   I recommend adding a custom link to the plugin in the Moodle navigation bar, as the modal dialogue does not support ticket filtering yet, but the plugin works well otherwise.

## Authors

- **Abdulrahman Kr** - *Owner* - [3bood-kr](https://github.com/3bood-kr)

## License

Feel free to use and modify this plugin. It's under the GNU General Public License, which means it's free for everyone!