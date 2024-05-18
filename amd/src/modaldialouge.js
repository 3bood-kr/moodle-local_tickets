import ModalFactory from 'core/modal_factory';
import Templates from 'core/templates';

export const init = (linkSelector) => {
    document.querySelector(linkSelector).addEventListener('click', async (e) => {
        const modal = await ModalFactory.create({
            large: true,
            title: 'test title',
            body: '<p>Example body content</p>',
            footer: 'An example footer content',
        });
        modal.show();
    });
};