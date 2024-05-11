import DynamicForm from 'core_form/dynamicform';
import Notification from 'core/notification';
import ModalForm from 'core_form/modalform';
import {add as addToast} from 'core/toast';

const addNotification = msg => {
    addToast(msg);
    // eslint-disable-next-line no-console
    console.log(msg);
};

export const submitTicketForm= (linkSelector, formClass, addArgs = false) => {
    document.querySelector(linkSelector).addEventListener('click', (e) => {
        e.preventDefault();
        const form = new ModalForm({
            formClass,
            args: addArgs ? {hidebuttons: 1, option: ['green', 'yellow'], name: 'Test2'} : {hidebuttons: 1},
            modalConfig: {title: 'Submit Ticket'},
            returnFocus: e.currentTarget
        });
        // If necessary extend functionality by overriding class methods, for example:
        form.addEventListener(form.events.FORM_SUBMITTED, (e) => {
            const response = e.detail;
            addNotification('Form submitted...');
            document.querySelector(resultSelector).innerHTML = '<pre>' + JSON.stringify(response) + '</pre>';
        });

        // Demo of different events.
        form.addEventListener(form.events.LOADED, () => addNotification('Form loaded'));
        form.addEventListener(form.events.NOSUBMIT_BUTTON_PRESSED,
            (e) => addNotification('No submit button pressed ' + e.detail.getAttribute('name')));
        form.addEventListener(form.events.CLIENT_VALIDATION_ERROR, () => addNotification('Client-side validation error'));
        form.addEventListener(form.events.SERVER_VALIDATION_ERROR, () => addNotification('Server-side validation error'));
        form.addEventListener(form.events.ERROR, (e) => addNotification('Oopsie - ' + e.detail.message));
        form.addEventListener(form.events.SUBMIT_BUTTON_PRESSED, () => {
            addNotification('Submit button pressed')
            console.log(form.events.SUBMIT_BUTTON_PRESSED);
        });
        
        form.addEventListener(form.events.CANCEL_BUTTON_PRESSED, () => addNotification('Cancel button pressed'));

        form.show();
    });

};