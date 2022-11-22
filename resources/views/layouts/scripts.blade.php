<script type="text/javascript" src="{{ asset('toastr/build/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    function  logout() {
        event.preventDefault();
        $('#logout-form').submit()
    }
    // ===== CRUD Operations functions ==========
    let main_modal = $('#main_modal');
    function create(url) {
        createOrEdit(url, 'create');
    }
    function store(form) {
        storeOrUpdate(form);
    }
    function edit(url) {
        createOrEdit(url, 'edit');
    }
    function update(form) {
        storeOrUpdate(form);
    }
    // Ajax call to destroy a record
    function mainAjax(url, method) {
        $.ajax({
            url: url,
            type: method,
            beforeSend: function() {
                startSpinner();
            },
            success: function (data) {
                if ( typeof mainAjaxSuccess === 'function' ) {
                    mainAjaxSuccess();
                } else {
                    onAjaxSuccess(data);
                }
            },
            error: function (xhr, textStatus, error) {
                onAjaxError(xhr, textStatus, error);
            },
            complete: function() {
                stopSpinner();
            }
        });
    }

    function destroy(url) {
        // swal({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         type: "warning",
        //         showCancelButton: true,
        //         cancelButtonText: 'No, cancel!',
        //         confirmButtonText: "Yes, delete it!",
        //         confirmButtonColor: "#d33",
        //         closeOnConfirm: true,
        //         allowOutsideClick: true
        //     },
        //     function () {
        //         mainAjax(url, 'DELETE');
        //     });

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        })
            .then((willDelete) => {
                if (willDelete.value) {
                    // Swal.fire("Deleted ");
                    mainAjax(url, 'DELETE');
                } else {
                    // Swal.fire("Fail to delete");
                }
            });
    }

    // function confirmBeforeContinue(url) {
    //     swal({
    //             title: "Are you sure?",
    //             text: "You want to do this!",
    //             type: "warning",
    //             showCancelButton: true,
    //             cancelButtonText: 'No, cancel!',
    //             confirmButtonText: "Yes, continue!",
    //             confirmButtonColor: "#d33",
    //             closeOnConfirm: true,
    //             allowOutsideClick: true
    //         },
    //         function () {
    //             mainAjax(url, 'PUT');
    //         });
    // }

    function createOrEdit(url, action) {
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function () {
                startSpinner();
            },
            success: function (data) {
                onAjaxSuccess(data, action);
            },
            error: function (data, textStatus, error) {
                onAjaxError(data, textStatus, error);
            },
            complete: function() {
                stopSpinner();
            }
        });
    }
    function storeOrUpdate(form) {
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            beforeSend: function() {
                disableSubmitBtn();
                startSpinner();
            },
            success: function (data) {
                onAjaxSuccess(data);
            },
            error: function (xhr, textStatus, error) {
                onAjaxError(xhr, textStatus, error);
            },
            complete: function() {
                enableSubmitBtn();
                stopSpinner();
            }
        });
    }
    // Ajax Supporting functions =======================
    function onAjaxSuccess(data, action=null) {
        if(action === 'create' || action === 'edit') { // Loading a create/edit form

            if(data.state === 'Fail') {
                toastr.info(data.msg, data.title);
                return;
            }
            else if(data.state === 'Error') {
                toastr.error(data.msg, data.title);
                return;
            }

            main_modal.find('.modal-content').empty().append(data);
            main_modal.modal('show');
            onModalShown();

            var form = main_modal.find('form');
            form.on('submit', function(event) {
                event.preventDefault();
                form.attr('method', (action === 'create' ? 'POST' : 'PUT'));
                storeOrUpdate(form);
            });
        } else {
            if(data.state === 'Done') {
                toastr.success(data.msg, data.title);
                main_modal.modal('hide');
                stopSpinner();
                if ( typeof main_datatable !== 'undefined') {
                    main_datatable.draw();
                }
                stopSpinner();
            }
            else if(data.state === 'Fail') {
                toastr.info(data.msg, data.title);
            }
            else if(data.state === 'Error') {
                toastr.error(data.msg, data.title);
            }
            else {
                let num = 0;
                jQuery.each(data, function (k, v) {
                    if (num === 0) toastr.error(v);
                    num++;
                });
            }
        }
    }
    function onAjaxError(data, textStatus, error) {
        toastr.error(error, textStatus.toUpperCase());
        switch(error) {
            case 'Unauthorized': // Server respond: Unauthenticated
                break;
            case 'Forbidden': // Server respond: Unauthorized
                break;
            case 'Internal Server Error':
                break;
            case 'Method Not Allowed':
                break;
            case 'Unknown status':
                break;
            case 'Not Implemented':
                break;
            default:
                break;
        }
        console.log(data);
    }
    function onModalShown() {
        $('.select2s').select2({'width':'100%'});
        // $('input, textarea').focusin(function() {
        //     return $(this).select();
        // });

        if ( typeof modalScripts === 'function' ) {
            modalScripts();
        }
    }
    {{--// ===== CRUD Operations functions -  end  ==========--}}

    function startSpinner() {
        // $.showLoading({name: 'square-flip'});
    }
    function stopSpinner() {
        // $.hideLoading();
    }

    // Enable/Disable Submit buttons ===================
    function enableSubmitBtn() {
        let btn = main_modal.find('button[type=submit]');
        btn.prop('disabled', false).text(' Save ');
    }
    function disableSubmitBtn() {
        let btn = main_modal.find('button[type=submit]');
        btn.prop('disabled', true).text('Saving, Please wait...');
    }
</script>
