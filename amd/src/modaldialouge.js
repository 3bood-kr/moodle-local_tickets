import ModalFactory from 'core/modal_factory';
import ModalEvents from 'core/modal_events';
import {call as ajaxCall} from 'core/ajax';
import Templates from 'core/templates';
import fragment from 'core/fragment';
import {add as addToast} from 'core/toast';
import {get_string as getString} from 'core/str';

const addNotification = (msg, type) => {
    addToast(msg, {type: type});
};


export const  init = (linkSelector, title) => {
    document.querySelector(linkSelector).addEventListener('click', (e) => {
        e.preventDefault();
        createAndShowModal(title); 
    });
};

async function createAndShowModal(title) {

    let modal;
    // Function to create and show modal
    async function showModal() {
        // Create the modal
        modal = await ModalFactory.create({
            large: true,
            title: title,
            body: await fragment.loadFragment('local_tickets', 'rerender_modal_dialouge', M.cfg.contextid, {page: 0}),
        });

        console.log(await fragment.loadFragment('local_tickets', 'rerender_modal_dialouge', M.cfg.contextid, {page: 0}));
        // Initialize delete popup
        require(['local_tickets/deletepopup'], function(deletepopup) {
            deletepopup.init();
        });

        // Destroy modal on hide
        modal.getRoot().on(ModalEvents.hidden, function() {
            modal.destroy();
        });

        // Show the modal
        modal.show();
    }

    // Function to handle pagination link clicks
    async function handlePaginationLinkClick(event, pageNum) {
        event.preventDefault();
        if(modal){
            await fragment.loadFragment('local_tickets', 'rerender_modal_dialouge', M.cfg.contextid, {page: pageNum-1}).then((html, js) => {
                modal.setBody(html);
                // Initialize delete popup
                require(['local_tickets/deletepopup'], function(deletepopup) {
                    deletepopup.init();
                });
            });
            //reattach pagination listeners
            attachPaginationListeners();
        }
    }

    // Function to attach event listeners to pagination links
    async function attachPaginationListeners() {
        const paginationLinks = document.querySelectorAll('.modal-body .page-link');
        paginationLinks.forEach(function(link) {
            link.removeEventListener('click', handlePaginationLinkClick); // Remove previous listener if any
            link.addEventListener('click', (event) => handlePaginationLinkClick(event, link.parentElement.getAttribute('data-page-number')));
        });
    }

    // Create and show the modal
    await showModal();
    attachPaginationListeners();
}


