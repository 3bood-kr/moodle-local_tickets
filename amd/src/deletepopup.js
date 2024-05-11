define('local_tickets/deletepopup', [], function() {
    return {
        init: function() {
            Array.from(document.getElementsByClassName('delete-ticket')).forEach(element => {
                element.addEventListener('click', e => {
                    e.preventDefault();
                    var confirmAction = confirm("Are you sure you want to delete this Ticket?");
                    if (confirmAction) {
                        window.location.href = element.href;
                    }
                });
            });
        }
    };
});
