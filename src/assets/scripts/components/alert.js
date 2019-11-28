// Remove item
function actionAlert() {
    $('body').on('click', '[data-alert]', function(e) {
        e.preventDefault();
        var btn                 = $(this);
        var url                 = btn.data('alert');
        var redirect            = btn.data('redirect');
        var module              = btn.data('module');
        var type                = btn.data('alertType');
        var text                = btn.data('alertText');
        var title               = btn.data('alertTitle');
        var titleSuccess        = btn.data('alertTitleSuccess');
        var textSuccess         = btn.data('alertTextSuccess');
        var button              = btn.data('alertButton');
        var color               = 'color-success';

        if (type == 'warning') {
            color = 'color-danger';
        }

        // check url
        if (checkAttr(url)) {

            // check redirect
            if (checkAttr(redirect)) { url = url+"?redirect=1"; }
            else { url = url+"?redirect=0"; }

            swal({
                title: title?title:'',
                text: text?text:'',
                type: type,
                showCancelButton: true,
                confirmButtonText: button,
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'pls_button '+color+'',
                cancelButtonClass: 'pls_button color-grey',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {

                if (result.value) {
                    $.getJSON(url, function(data) {

                        var form_message = $(".pls_form-message");
                        if (type == 'modal') {
                            var modal = btn.closest('.modal');
                            messageWrap = modal.find('.pls_form-message');
                        }

                        // success
                        if (data.message.status == "success") {

                            swal({
                                title: titleSuccess?titleSuccess:'Successfuly!',
                                text: textSuccess?textSuccess:'',
                                type: 'success',
                                buttonsStyling: false,
                                confirmButtonClass: 'pls_button color-info ico-check',
                            }).then((result) => {
                                // redirect
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                }
                            });

                            // without redirect
                            if (!data.redirect) {
                                if (module == "modal") {
                                    cardRemove(modal.data('id'));
                                    modalRemove(modal);
                                }
                                else if  (module == "basic-modal") {
                                    modal.modal('hide');
                                }
                                else if (module == "list") {
                                    pls_datatable.ajax.reload();
                                }
                                else if (module == "tag") {
                                    btn.closest('.pls_list-item').remove();
                                }
                            }
                        }
                        else if (data.message.status == "warning") {
                            swal({
                                title: 'Error',
                                html: data.message.text,
                                type: 'warning',
                                buttonsStyling: false,
                                confirmButtonClass: 'pls_button color-info',
                            });
                        }
                        // error
                        else {
                            messageWrap.html(data.message.text);
                        }
                    }).fail(function() {
                        swal({
                            title: 'Error',
                            html: 'Please try again',
                            type: 'warning',
                            buttonsStyling: false,
                            confirmButtonClass: 'pls_button color-info',
                        });
                    });
                }

            });
        }
    });
}


// Ajax remove alert
function remove_alert(btn, url, type) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'pls_button color-danger ico-color-white ico-remove',
        cancelButtonClass: 'pls_button color-grey',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {

        if (result.value) {
            $.getJSON(url, function(data) {

                var form_message = $(".pls_form-message");
                if (type == 'modal') {
                    var modal = btn.closest('.modal');
                    messageWrap = modal.find('.pls_form-message');
                }

                // success
                if (data.message.status == "success") {

                    swal({
                        title: 'Deleted!',
                        text: 'Your file has been deleted.',
                        type: 'success',
                        buttonsStyling: false,
                        confirmButtonClass: 'pls_button color-info ico-check',
                    }).then((result) => {
                        // redirect
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    });

                    // without redirect
                    if (!data.redirect) {
                        if (type == "modal") {
                            cardRemove(modal.data('id'));
                            modalRemove(modal);
                        }
                        else if (type == "list") {
                            pls_datatable.ajax.reload();
                        }
                        else if (type == "tag") {
                            btn.closest('.pls_list-item').remove();
                        }
                    }
                }
                // error
                else {
                    messageWrap.html(data.message.text);
                }
            });
        }

    });
}

// Remove tag alert
function remove_tag_alert(form, tag, tagID) {
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: 'Cancel',
        confirmButtonClass: 'pls_button color-danger ico-color-white ico-remove',
        cancelButtonClass: 'pls_button color-grey',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {

        if (result.value) {
            $.getJSON(url, function(data) {

                var form_message = $(".pls_form-message");

                // success
                if (data.message.status == "success") {
                    
                }
                // error
                else {
                    form_message.html(data.message.text);
                }
            });
        }

    });
}