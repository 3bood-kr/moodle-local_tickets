import ModalForm from 'core_form/modalform';
import {add as addToast} from 'core/toast';
import {call as ajaxCall} from 'core/ajax';

const addNotification = (msg, type) => {
    addToast(msg, {type: type});
    // eslint-disable-next-line no-console
    console.log(msg);
};

export const modalForm = (linkSelector, formClass, methodName, title, args = {hidebuttons: 1, ...args}) => {
    document.querySelector(linkSelector).addEventListener('click', (e) => {
        e.preventDefault();
        const form = new ModalForm({
            formClass,
            args: args,
            modalConfig: {title: title},
            returnFocus: e.currentTarget
        });
        
        form.addEventListener(form.events.FORM_SUBMITTED, (e) => {
            const formData = JSON.stringify(e.detail);
            ajaxCall([{
                methodname: methodName, 
                args: {data: formData},
                done: function(response) {
                    const type = response?.status === 200 ? 'success' : 'danger';
                    addNotification(response.message, type);
                },
                fail: function(ex) {
                    console.log(ex);
                    addNotification(`Failed to submit the form: ${ex.message}`, 'danger');
                }
            }]);

        });

        // Demo of different events.
        form.addEventListener(form.events.ERROR, (e) => addNotification('Oopsie - ' + e.detail.message));
        form.show();
    });

};