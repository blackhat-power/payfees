@extends('layouts.app')

@section('alerts-ground')
@if ($notification = Session::get('dashboard'))
<div class="toast fade show bg-success text-white border-0 rounded p-2 mt-3" role="alert" aria-live="assertive" aria-atomic="true" style="width: 100%; display:none">
   <div class="toast-header bg-success text-white">
      <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">×</span>
      </button>
   </div>
   <div class="toast-body">
      <strong>{{ $notification }}</strong>
   </div>
</div>

@endif
@endsection
@section('head-page')
    @include('layouts.heading')
@endsection

@section('content-body')
<div class="col-md-6 col-lg-3">
    <div class="card card-block card-stretch card-height">
       <div class="card-body bg-primary-light rounded">
          <div class="d-flex align-items-center justify-content-between">
             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
             </div>
             @php
               $students = Modules\Registration\Entities\AccountStudentDetail::all()->count();
             @endphp
             <a href="{{ route('students.registration') }}">
              <div class="text-right">
                <h2 class="mb-0"><span class="counter" style="visibility: visible;">{{$students}}</span></h2>
                <h6 class="">TOTAL STUDENTS</h6>
             </div>
             </a>
          </div>
       </div>
    </div>
 </div>


 <div class="col-md-6 col-lg-3">
    <div class="card card-block card-stretch card-height">
       <div class="card-body bg-danger-light rounded">
          <div class="d-flex align-items-center justify-content-between">
             <div class="rounded iq-card-icon bg-danger"><i class="ri-group-fill"></i>
             </div>
             <div class="text-right">
                <h2 class="mb-0"><span class="counter" style="visibility: visible;">0</span></h2>
                <h6 class="">TOTAL TEACHERS</h6>
             </div>
          </div>
       </div>
    </div>
 </div>

 <div class="col-md-6 col-lg-3">
  <div class="card card-block card-stretch card-height bg-primary rounded">
     <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
           <div class="icon iq-icon-box rounded iq-bg-primary rounded shadow" data-wow-delay="0.2s"> <i class="las la-users"></i>
           </div>
           <div class="iq-text">
            <a href="{{route('accounts.debtors.list')}}" class="text-white">
              <h6 class="text-white">Debtors List</h6>
              <h3 class="text-white">{{ !empty($debtors_list) ?  $debtors_list : 0}}</h3>
            </a>
           </div>
        </div>
     </div>
  </div>
</div>

 <div class="col-md-6 col-lg-3">
  <div class="card card-block card-stretch card-height bg-danger rounded">
     <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
           <div class="icon iq-icon-box rounded iq-bg-danger rounded shadow" data-wow-delay="0.2s"> <i class="lab la-buffer"></i>
           </div>
           <div class="iq-text">
            <a href="{{route('accounts.student.payments.review.index')}}" class="text-white">
               <h6 class="text-white">Pending Payments Approval</h6>
               <h3 class="text-white">{{ !empty($pending_approval) ?  $pending_approval : 0}}</h3>
            </a>
             
           </div>
        </div>
     </div>
  </div>
</div>

</div>

 <div class="row">

 
   <div class="col-md-6">
      {{-- #00a65a --}}

      <div class="card" style="border-top: 3px solid #d2d6de">
         <div class="card-header">
            <span>Students Report</span> 
         </div>
         <div class="card-body">
            <canvas id="studentsChart"></canvas>

         </div>
      </div>
   </div>


   <div class="col-md-6">
    <div class="card" style="border-top: 3px solid #01a65a">
      <div class="card-header">
         <span>Accounts Report</span> 
      </div>
      <div class="card-body">
         <canvas id="studentsAccountChart"></canvas>

      </div>
   </div>
   </div>

 </div>

 <div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <span style="color:  #e64a19">
               <i  class="fa fa-exclamation-triangle blink" aria-hidden="true"></i> ToDo's
            </span>            
         </div>
         <div  class="card-body">
            <h5 class="todo-group-title"><i  class="text-red fa fa-exclamation"></i> Important Incomplete Tasks {{-- (<small class="num-of-tasks"></small>) --}}</h5>


         </div>
      </div>
   </div>
   
 </div>


@endsection

@section('scripts')



loadStudentsData();
function loadStudentsData(){

let class_labels = [];
let male_students_count = [];
let female_students_count = [];

$.ajax({

url:'{{ route('students.report.total.ratio')}}',
type:'GET',
dataType:'JSON',
success:function(response){

  $.each(response, function( index, elem ) {
    
    class_labels.push(elem.class_name);
    male_students_count.push(elem.male)
    female_students_count.push(elem.female);
    
  });

  
  const students_chart = $('#studentsChart');
const myChart = new Chart(students_chart, {
    type: 'bar',
    data: {
        labels: class_labels,
        datasets: [
          {
            label: 'Male',
            data: male_students_count,
            backgroundColor:'#2876dd',
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        },

        {
          label: 'Female',
          data: female_students_count,
          backgroundColor:'#0f283e',
          borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
      }
        
        ],
        
    },
    options: {
        scales: {
            x: {
              stacked: true,
            },
            y: {
              stacked: true,
              beginAtZero: true
            }
        }
    }
});

}

});
}

studentAccountsChart();

let total_billed_amount = [];
let total_paid_amount = [];
let total_balance = [];
let class_labels = [];


function studentAccountsChart(){

  $.ajax({

    url:'{{ route('students.report.account.total.ratio')}}',
    type:'GET',
    dataType:'JSON',
    success:function(response){
      $.each(response, function( index, elem ) {
       
        class_labels.push(elem.class_name);
        total_billed_amount.push(elem.billed_amount)
        total_paid_amount.push(elem.amount_paid);
        total_balance.push(elem.balance);
      });
      
      const students_chart = $('#studentsAccountChart');
    const myChart = new Chart(students_chart, {
        type: 'bar',
        data: {
            labels: class_labels,
            datasets: [
              {
                label: 'Billed',
                data: total_billed_amount,
                backgroundColor:'#9cd0f5',
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            },
    
            {
              label: 'Paid',
              data: total_paid_amount,
              backgroundColor:'#00a65a',
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          },

          {
            label: 'Due Balance',
            data: total_balance,
            backgroundColor:'#ffb1c1',
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }
            
            ],
            
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: false,
              {{-- text: 'Chart.js Bar Chart' --}}
            }
          }
  
  
      }
    });
  }
});
}


$(window).on('load', function() { 

   $(".toast").fadeTo(3000, 1,'swing',function(){
      $('.toast').slideUp(6000,'swing');
   });
   

});



     


@endsection