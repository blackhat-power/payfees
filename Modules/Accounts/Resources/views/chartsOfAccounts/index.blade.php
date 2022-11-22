@extends('dashboard')


@section('alerts-ground')

@if(Session::has('message'))

<div class="toast fade show bg-primary text-white border-0 rounded p-2" role="alert" aria-live="assertive" aria-atomic="true" style="width: 100%; display:none">
    <div class="toast-header bg-primary text-white">
       <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
       <span aria-hidden="true">×</span>
       </button>
    </div>
    <div class="toast-body">
        {{ Session::get('message') }}
    </div>
 </div>

<p class="alert {{ Session::get('alert-class', 'alert-info') }}" style="width: 100%; display:none">{{ Session::get('message') }}</p>

@endif
@endsection

@section('content-heading')

          <nav aria-label="breadcrumb" style="width: 100%">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Reports</a></li>
              <li class="breadcrumb-item active" aria-current="page">Charts Of Accounts</a></li>
              <li class="ml-auto"> <a id="comment" style="color: #551a8b !important" href="{{route('configurations.users.manual')}}"><i class="fa fa-comments"></i> Support</a></li>
            </ol>
          </nav>
  

@endsection 


@section('content-body')

<div class="card"  style="width:100%">

<div class="card-header">

</div>

<div class="card-body">
<style>
ul[role="tree"] {
  margin: 0;
  padding: 0;
  list-style: none;
  font-size: 120%;
}

ul[role="tree"] li {
  margin: 0;
  padding: 0;
  list-style: none;
}

[role="treeitem"][aria-expanded="false"] + [role="group"] {
  display: none;
}

[role="treeitem"][aria-expanded="true"] + [role="group"] {
  display: block;
}

[role="treeitem"].doc::before {
  font-family: "Font Awesome 5 Free";
  content: "\f15c";
  display: inline-block;
  padding-right: 2px;
  padding-left: 5px;
  vertical-align: middle;
}

[role="treeitem"][aria-expanded="false"] > ul {
  display: none;
}

[role="treeitem"][aria-expanded="true"] > ul {
  display: block;
}

[role="treeitem"][aria-expanded="false"] > span::before {
  font-family: "Font Awesome 5 Free";
  content: "\f07b";
  display: inline-block;
  padding-right: 3px;
  vertical-align: middle;
  font-weight: 900;
}

[role="treeitem"][aria-expanded="true"] > span::before {
  font-family: "Font Awesome 5 Free";
  content: "\f07c";
  display: inline-block;
  padding-right: 3px;
  vertical-align: middle;
  font-weight: 900;
}

[role="treeitem"],
[role="treeitem"] span {
  width: 9em;
  margin: 0;
  padding: 0.125em;
  display: block;
}

/* disable default keyboard focus styling for treeitems
   Keyboard focus is styled with the following CSS */
[role="treeitem"]:focus {
  outline: 0;
}

[role="treeitem"][aria-selected="true"] {
  padding-left: 4px;
  border-left: 5px solid #005a9c;
}

[role="treeitem"].focus,
[role="treeitem"] span.focus {
  border-color: black;
  background-color: #eee;
}

[role="treeitem"].hover,
[role="treeitem"] span:hover {
  padding-left: 4px;
  background-color: #ddd;
  border-left: 5px solid #333;
}

</style>
   
    <style>
        .tree, .tree ul {
            margin:0;
            padding:0;
            list-style:none
        }
        .tree ul {
            margin-left:1em;
            position:relative
        }
        .tree ul ul {
            margin-left:.5em
        }
        .tree ul:before {
            content:"";
            display:block;
            width:0;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            border-left:1px solid
        }
        .tree li {
            margin:0;
            padding:0 1em;
            line-height:2em;
            color:#369;
            font-weight:700;
            position:relative
        }
        .tree ul li:before {
            content:"";
            display:block;
            width:10px;
            height:0;
            border-top:1px solid;
            margin-top:-1px;
            position:absolute;
            top:1em;
            left:0
        }
        .tree ul li:last-child:before {
            background:#fff;
            height:auto;
            top:1em;
            bottom:0
        }
        .indicator {
            margin-right:5px;
        }
        .tree li a {
            text-decoration: none;
            color:#369;
        }
        .tree li button, .tree li button:active, .tree li button:focus {
            text-decoration: none;
            color:#369;
            border:none;
            background:transparent;
            margin:0px 0px 0px 0px;
            padding:0px 0px 0px 0px;
            outline: 0;
        }
    </style>

<div class="row">
    <div class="col-md-12">
        <ul id="tree2">
            @foreach($accounts as $account)
                <li><a href="#">{{ $account->code ? $account->code .' - ' : '' }}{{ $account->name }}</a><a class="float-right" href="#">{!! $account->opening_balance_custom !!}</a>
                    {!! $account->drawAccountTree() !!}
                </li>
            @endforeach
        </ul>

    </div>
</div>

</div>

</div>


@endsection

@include('shadows.custom_js')
@section('scripts')



    let elem = $('.date');
    DateLimit(elem);

$('#from_date').on('change', function(){

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();
     
});


$('#to_date').on('change', function(){

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();

});


$('#clear').click(function(){
 let form = $('#filter_form');
    clearForm(form);

    startSpinnerOne();
    invoices_table .draw();  
    stopSpinnerOne();
});

totalFee();
function totalFee(){
    var total = 0;
    $("input[type=checkbox]:checked").each(function() {
        total += parseFloat($(this).val());
    });
 
    $(".totalSum").val(total);
}


 $('.checkboxes').each(function(){
     $(this).click(function(){
        totalFee();
     });
 })


 $('#academic_season').on('change',function(){

    let season_id = $(this).val();
    $.ajax({
        type: "POST",
        url: "{{ route('accounts.invoices.filter.fee_structure')  }}",
        data: {
            'season_id' :season_id
        },
        dataType: "JSON",
        success: function (response) {


            console.log(response.fee_structure_html);

            $('#fee_structure_tbody').html(response.fee_structure_html);
            totalFee();
        },
        error: function(response){
            
            $('#fee_structure_tbody').html(response);

        }
    });

 });





function generateFile($file_type){

    let class_id = $('#class_filter').val();
    let stream_id = $('#class_filter').val();
    let file_type = $file_type;


    let url = '{{ route('charts.of.accounts.printing') }}';
    url = url+"?file_type="+file_type+"&class_id="+class_id+"&stream_id="+stream_id;
    window.open(url,'_blank');   
    console.log(url);

}



$('#student_search').select2({
})


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

    invoices_table.draw();
});

$('#stream_filter').change(function(){
    invoices_table.draw();
});

$('#stream_filter').select2({width:'100%'})


var charts_of_account = $('#charts_of_account').DataTable({
     processing: false,
    serverSide: true,
     ajax:{
         url : '{{ route('charts.of.accounts.datatable') }}',

         data: function (d) {
            d.from_date = $('#from_date').val();
            d.to_date = $('#to_date').val();
            d.class_id = $('#class_filter').val(),
            d.stream_id = $('#stream_filter').val()
        }
     },

     columns:[
        {data: 'code', name:'code'},
        {data: 'account_name', name:'account_name'},
        {data: 'account_group', name:'account_group'},
        {data:'action', name:'action', orderable:false, searchable:false}
    ],
    "columnDefs": [
        {{-- { className: " text-right font-weight-bold", "targets": [ 3 ] }, --}}
        {{-- { className: "text-blue text-right font-weight-bold", "targets": [ 4 ] }, --}}
        {{-- { className: "text-danger text-right font-weight-bold", "targets": [ 5 ] } --}}
      ],

      "drawCallback":function(){
        $('.chartDltBtn').click(function(e){
            e.preventDefault();
            let chart_id = $(this).data('chart_id');
            let init_url = "{{ route('charts.of.accounts.delete', 'id') }}"
            let url = init_url.replace('id',chart_id);
           
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                
                        success: function (response) {
                            if(response.state == 'Done'){
                                charts_of_account.ajax.reload();
                                toastr.success(response.msg, response.title);  
                            }
                    
                            else if(response.state == ' Fail'){
                                toastr.warning(response.msg, response.title)
                    
                            }
                            else{
                                toastr.error(response.msg, response.title);
                            }
                    
                        },
                        error: function(response){
                            
                            toastr.error(response.msg, response.title);
                            
                        }
                
                    });
        
                }
              });
            });
        }
    })
        


{{-- FILTERS --}}


$("#filter_checkbox").change(function() {


    if(this.checked) {
        $('#toggleFilters').removeAttr('style','display:none').css({'margin-top':'2%'});
    }else{
        $('#toggleFilters').css({'display':'none'});
    }
 });

 $('#class_filter').select2({width:'100%'});


    


{{-- FOLDER   STRUCTURE --}}


$.fn.extend({

    treed: function (o) {

        var openedClass = 'glyphicon-minus-sign';
        var closedClass = 'glyphicon-plus-sign';

        {{-- console.log(o.openedClass); --}}

        if (typeof o != 'undefined'){
            if (typeof o.openedClass != 'undefined'){
                openedClass = o.openedClass;
            }
            if (typeof o.closedClass != 'undefined'){
                closedClass = o.closedClass;
            }
        };

        //initialize each of the top levels
        var tree = $(this);

        console.log(tree);

        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
        tree.find('.branch .indicator').each(function(){
            $(this).on('click', function () {
                $(this).closest('li').click();
            });
        });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews
$('#tree2').treed({openedClass:'fa fa-folder-open', closedClass:'fa fa-folder'});



@endsection




