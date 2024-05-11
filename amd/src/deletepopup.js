
import Notification from 'core/notification';

export const init = () => {
    Array.from(document.getElementsByClassName('delete-ticket')).forEach(element => {
        element.addEventListener('click', e => {
            e.preventDefault();
            Notification.confirm(
                'Confirm',
                'Are you sure you want to delete this Ticket?',
                'Yes', // Delete.
                'No', // Cancel.
                () => {
                    window.location.href = element.href
                }
            );  
        });
    });
}
