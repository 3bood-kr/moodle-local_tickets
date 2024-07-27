import {call as ajaxCall} from 'core/ajax';
import Notification from 'core/notification';
import {add as addToast} from 'core/toast';
import {get_string as getString} from 'core/str';

const addNotification = (msg, type) => {
    addToast(msg, {type: type});
};

export const init = () => {
    Array.from(document.getElementsByClassName('delete-ticket')).forEach(element => {
        element.addEventListener('click', e => {
            e.preventDefault();
            const ticketId = element.dataset.ticketId;
            Notification.confirm(
                getString('confirm'),
                getString('confirm_ticket_delete', 'local_tickets'),
                getString('yes'), // Delete.
                getString('no'), // Cancel.
                () => {
                    e.preventDefault();
                    ajaxCall([{
                        methodname: 'local_tickets_delete_ticket', 
                        args: {id: ticketId},
                        done: function(response) {
                            console.log(ticketId);
                            console.log(response);
                            if(response.status == 200){
                                location.reload();
                            }
                            else{
                                addNotification(response.message, 'danger');
                            }
                        },
                        fail: function(ex) {
                            addNotification(`Failed to delete ticket: ${ex}`, 'danger');
                            console.log(ex);
                        }
                    }])
                },
            );  
        });
    });
}
