@extends('layouts.app')

@section('content-heading')
    

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accounts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Collection</a></li>
              </ol>
          </nav>
@endsection

@section('content-body')

<div class="card" style="width: 100%" >
 
    <div class="card-header border-bottom">
        <span>
            <input type="checkbox" id="filter_checkbox" class="checkbox-input float-left" style="width: 30px; height: 30px;">
           Filters
        </span>

        <span class="float-right">
            <a href="javascript:void(0)" title="excel" onclick="generateFile('excel')"  style="color:white" class="btn btn-success btn-sm"> <i class="fa fa-file-excel"></i>&nbsp;Excel</a>
            <a href="javascript:void(0)" title="pdf" onclick="generateFile('pdf')" style="color:white" class="btn btn-warning btn-sm"><i class="fa fa-print"></i>&nbsp;Pdf</a>
        </span>

<form action="#" id="filter_form">
        <div class="row" style="margin-top:2%; display:none" id="toggleFilters" >
            <div class="col-md-3">
                <select name="class_filter" id="class_filter" class="form-control form-control-sm">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                    <option value="{{  $class->id }}"> {{  $class->name }} </option>
                    @endforeach
                </select>   
        </div>

            <div class="col-md-3">
                <select name="stream_filter" id="stream_filter" class="form-control form-control-sm">
                    <option value="">Select Stream</option>
                </select>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-3" style="margin-top: 1%">
                <div class="form-group">
                    <label class="control-label text-right" for="From">FROM:</label>
                    <input type="date" name="from_date" id="from_date" class="form-control date form-control-sm">
                </div>
            </div>

            <div class="col-md-3" style="margin-top: 1%">
                <div class="form-group">
                    <label for="To">TO:</label>
                    <input type="date" name="to_date" id="to_date" class="form-control date  form-control-sm">
                </div>
            </div>
        
            <div class="col-md-1" style="margin-top: 3.5%">
                <a title="clear" href="javascript:void(0)" class="btn btn-info btn-sm" id="clear"><i class="fa fa-refresh"></i></a>
            </div>
        </div>
    </form>

        {{-- end form --}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="collection_index" class="table table-striped table-bordered table-xs" width="100%" style="table-layout: inherit">
                <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Class</th>
                  <th>Stream</th>
                  <th>Amount Paid</th>
                </tr>
                </thead>

                <tfoot>
                    <tr>
                        
                        <th  colspan="3" style="text-align: right">TOTAL</th>
                        <th id="total" style="padding: 10px 9px 6px !important;"></th>
                       
                    </tr>
                </tfoot>
            </table>
         </div>  
    </div>
 </div>


@endsection


@section('scripts')


$('#student_search').select2({
})


$('#from_date').on('change', function(){

startSpinnerOne();
collection_datatable.draw();  
stopSpinnerOne();
 
});


$('#to_date').on('change', function(){

startSpinnerOne();
collection_datatable.draw();  
stopSpinnerOne();

});


$('#clear').click(function(){
let form = $('#filter_form');
clearForm(form);

startSpinnerOne();
collection_datatable.draw();  
stopSpinnerOne();
});


let collection_datatable = $('#collection_index').DataTable({
     processing: true,
    serverSide: true,
     ajax:{
        url : '{{ route('accounts.collection.datatable') }}',

        data: function (d) {
           d.from_date = $('#from_date').val();
           d.to_date = $('#to_date').val();
           d.class_id = $('#class_filter').val(),
           d.stream_id = $('#stream_filter').val()
       }
    },

     columns:[
        {data: 'student_name', name:'student_name'},
        {data: 'class', name:'class'},
        {data: 'stream', name:'stream'},
        {data: 'amount_paid', name:'amount_paid'},
    ],
    "columnDefs": [
        { className: " text-left font-weight-bold", "targets": [ 1 ] },
        { className: "text-blue text-left font-weight-bold", "targets": [ 2 ] },
        { className: "text-danger text-right font-weight-bold", "targets": [ 3 ] }
      ],


    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // converting to interger to find total
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

            
    var Total = api
            .column( 3)
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );
        
            
        // Update footer by showing the total with the reference of the column index 
        $('#total').html(Total.toLocaleString());
    },

 
});



$('#class_filter').change(function(){
    let class_id  = $(this).val();

    $.ajax({
        url:'{{ route('students.to_class.filter') }}',
        data:{
            class_id : class_id
        },
        success: function(response){

             $('#stream_filter').html(response);

        }

    });

    collection_datatable.draw();
});

$('#stream_filter').change(function(){
    collection_datatable.draw();
});

$('#stream_filter').select2({width:'100%'})


$("#filter_checkbox").change(function() {
    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

 $('#class_filter').select2({width:'100%'})

 

 function generateFile($file_type){

    let class_id = $('#class_filter').val();
    let stream_id = $('#class_filter').val();
    let file_type = $file_type;

    let url = '{{ route('accounts.collection.print') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}


@endsection




