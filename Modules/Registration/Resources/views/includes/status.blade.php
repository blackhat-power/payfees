
<!DOCTYPE html>
<html lang="en">
<body>
    <div class="">
        <input type="checkbox" class="checkbox statusChange"  @if ( $status ) checked  @endif id="checkbox" data-student_id ={{ $id }}  data-status = "{{$status}}">
        <label for="checkbox" class="label">
            @if ($status)
            <i class="fa fa-check-circle" aria-hidden="true" id="fa_tick"></i>
            <i class="fa fa-ban" aria-hidden="true" id="fa_ban" style="display: none"></i>

            @else
            <i class="fa fa-check-circle" aria-hidden="true" id="fa_tick" style="display:none"></i>
            <i class="fa fa-ban" aria-hidden="true" id="fa_ban"></i>
            @endif
            
            <div class="ball">
            </div>
        </label>
        </div>
</body>
</html>



{{-- 
    
    
$('body').on('click','.statusChange', function(){

  let checkbox =  $(this).parent().find('.checkbox');
  let student_id = checkbox.data('student_id');
  let isActive = checkbox.prop('checked') ? 1 : 0;
    console.log(isActive);

    $.ajax({

        url:'{{ route('student.update.status') }}',
        type:'POST',
        data:{
            student_id : student_id,
            status: isActive
        },

        success:function(res){
            console.log(res);
            if(res.state == 'DONE'){
                toastr.success(res.msg, res.title);
            }
            if(res.state == 'FAIL'){
                toastr.info(res.msg, res.title);
            }

            if(res.state == 'ERROR'){
                toastr.error(res.msg, res.title);
            }
        },

        error:function(res){
            console.log(res);

        }

    });

    if(isActive){
        $('#fa_ban').attr('style','display:none');
        $('#fa_tick').attr('style','display:block');
    }
    else{
        $('#fa_tick').attr('style','display:none');
        $('#fa_ban').attr('style','display:block');
    }

});
    
    
    
    
    --}}




