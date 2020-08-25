(function() {
    function passwordConfirmationAlertBox(submit_btn_jquery_element,form_jquery_element,confirmation_msg) {
        submit_btn_jquery_element.on('click', function (e) {
            e.preventDefault();
            bootbox.confirm({
                message: confirmation_msg,
                callback: function (result) {
                    if (result) {
                        form_jquery_element.submit();
                    }
                }
            });
        });
    }
})();
