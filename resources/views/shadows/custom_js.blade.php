
<script>
/*  FLASH MESSAGES */

function flash(data){
        // new PNotify({
        //     text: data.msg,
        //     type: data.type,
        //     hide : data.type !== "danger"
        // });
    }


    function DateLimit(elem){

    var todaysDate = new Date(); // Gets today's date
    var year = todaysDate.getFullYear(); 
    var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);
    var day = ("0" + todaysDate.getDate()).slice(-2);  
    var maxDate = (year +"-"+ month +"-"+ day); 
    elem.attr('max',maxDate);

    }

    // $('.jqueryhover').hover(function(){
    //     alert('oooh yeah');
    // });


    // document.querySelector('.jqueryhover').mouseenter( function(){

    //     $('.menu-toggle').addClass('open');
    //     $('#toggle-flip').removeClass('sidebar-main');


    // } ).mouseleave( function(){

    //     $('.menu-toggle').removeClass('open');
    //     $('#toggle-flip').addClass('sidebar-main');

    // } );




    function disableBtn(btn){
        var btnText = btn.data('text') ? btn.data('text') : 'Submitting';
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>' + btnText);
    }



    function enableBtn(btn){
        var btnText = btn.data('text') ? btn.data('text') : 'Submit Form';
        btn.prop('disabled', false).html(btnText + '<i class="icon-paperplane ml-2"></i>');
    }

    function displayAjaxErr(errors){
        $('#ajax-alert').show().html(' <div class="alert alert-danger border-0 alert-dismissible" id="ajax-msg"><button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>');
        $.each(errors, function(k, v){
            $('#ajax-msg').append('<span><i class="icon-arrow-right5"></i> '+ v +'</span><br/>');
        });
        scrollTo('body');
    }


    function hideAjaxAlert(){
        $('#ajax-alert').hide();
    }


@if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.warning("{{ session('warning') }}");
  @endif

  @if(Session::has('success'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('success') }}");
  @endif


/* SCROLL */

// function scrollTo(el){
//         $('html, body').animate({
//             scrollTop:$(el).offset().top
//         }, 2000);
//     }


    /*  FORMS  */

function clearForm(form){
    form.find('.select,.select-search').val([]).select2({ placeholder: 'Select...'});
    form[0].reset();
}


function submitForm(form, formType, datatable){
    //  alert('woyoo');
    // console.log('ow');
        var btn = form.find('button[type=submit]');
        disableBtn(btn);
        var ajaxOptions = {
            url:form.attr('action'),
            type:'POST',
            cache:false,
            processData:false,
            dataType:'json',
            contentType:false,
            data:new FormData(form[0])
        };

      var req = $.ajax(ajaxOptions);

      /*   success: function(resp){
            console.log(resp);

        } */
        req.done(function(resp){
            
          if(resp.state == 'Done'){
              toastr.success(resp.msg,resp.title)
          } 
          else if( resp.state == 'Fail'){
              toastr.warning(resp.msg, resp.title)
          }
            hideAjaxAlert();
            enableBtn(btn);
            formType == 'store' ? clearForm(form) : '';
            scrollTo('body');
            datatable.ajax.reload();
            return resp;
        });
        req.fail(function(e){
            if (e.status == 422){

                var errors = e.responseJSON.errors;
                displayAjaxErr(errors);

            }
           if(e.status == 500){

               displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'])
           }
            if(e.status == 404){

               displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])

           }
            enableBtn(btn);
            return e.status;
        }); 
    }


    function confirmDelete(id) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function(willDelete){
            if (willDelete) {
             $('form#item-delete-'+id).submit();
            }
        });
    }

    function confirmReset(id) {
        swal({
            title: "Are you sure?",
            text: "This will reset this item to default state",
            icon: "warning",
            buttons: true,
            dangerMode: true
        }).then(function(willDelete){
            if (willDelete) {
             $('form#item-reset-'+id).submit();
            }
        });
    }


/*  */

</script>