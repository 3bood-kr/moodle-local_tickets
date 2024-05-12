export const init = () => {
    document.querySelector('#id_status').addEventListener('change', () => {
        // document.querySelector('.settingsform').classList.add('block_openai_chat')
        // document.querySelector('.settingsform').classList.add('disabled')
        document.querySelector('#id_submitbutton').click();
    });
};