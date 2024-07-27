import ModalFactory from 'core/modal_factory';
import {call as ajaxCall} from 'core/ajax';
import Templates from 'core/templates';
import fragment from 'core/fragment';
import {add as addToast} from 'core/toast';
import {get_string as getString} from 'core/str';

const addNotification = (msg, type) => {
    addToast(msg, {type: type});
};

export const init = (linkSelector, title, own = true) => {
    document.querySelector(linkSelector).addEventListener('click', (e) => {
        e.preventDefault();
        var filterForm = '';
        fragment.loadFragment('local_tickets', 'new_filter_form', M.cfg.contextid, {})
                .done(function(html, js) {
                    filterForm = html;
                })
                .fail(function(ex) {
                    // Handle errors here
                    console.error('Failed to load fragment:', ex);
                });

        ajaxCall([{
            methodname: 'local_tickets_get_tickets', 
            args: {'own': own},
            done: async function(response) {
                if(response.status == 200){
                    const tickets = JSON.parse(response.data);
                    const modal = await ModalFactory.create({
                        large: true,
                        title: title,
                        body: Templates.render('local_tickets/modaldialouge', {tickets: tickets, filterform: filterForm}),
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
            }
        }])
    });
};
