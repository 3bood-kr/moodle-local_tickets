import ModalFactory from 'core/modal_factory';
import {call as ajaxCall} from 'core/ajax';
import Templates from 'core/templates';
import {add as addToast} from 'core/toast';
import {get_string as getString} from 'core/str';

const addNotification = (msg, type) => {
    addToast(msg, {type: type});
};

export const init = (linkSelector, title, own = true) => {
    document.querySelector(linkSelector).addEventListener('click', (e) => {
        e.preventDefault();
        ajaxCall([{
            methodname: 'local_tickets_get_tickets', 
            args: {'own': own},
            done: async function(response) {
                if(response.status == 200){
                    const tickets = JSON.parse(response.data);
                    const modal = await ModalFactory.create({
                        large: true,
                        title: title,
                        body: Templates.render('local_tickets/modaldialouge', {tickets: tickets}),
                    });
                    
                    require(['local_tickets/deletepopup'], function(deletepopup) {
                        deletepopup.init();
                    });

                    modal.show();
                }
                else{
                    addNotification(response.message, 'danger');
                }
            },
            fail: function(ex) {
                addNotification(`Failed to fetch ticket: ${ex}`, 'danger');
                console.log(ex);
            }
        }])
    });
};
