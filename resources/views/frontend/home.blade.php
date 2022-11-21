@extends('layouts.app')
@section('title',"Home Page")
<!-- ................Add meta ................ -->


@section('meta')
@endsection

<!-- ................custom css................. -->

@section('customStyle')

<style>
    .nav-tabs{
        border-bottom:none !important;
    }
    .nav-tabs .nav-link.active {
        border-bottom: solid;
        border-top: none;
        border-left: none;
        border-right: none;
        color:#57c574 !important;
    }
    .nav-tabs .nav-link {
        color:gray !important;
        border-top: none;
        border-left: none;
        border-right: none;
        border: none;
    }
    
     /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>
@endsection

<!-- ................Add css link................. -->

@push('style')
       <link rel="stylesheet" href="{{asset('public/css/fullcalendar.min.css')}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

@endpush

@section('content')



<div class="container">
        @include('layouts.header')
        <div class="container-fluid">
            <div class="row">
                <div class="float-lg-end mt-5">
                    <button class="btn btn-success float-end mx-lg-5 px-lg-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Expense
                    </button>
                </div>
                <div class="col-md-9">
                    
                    
         <nav class="mb-5">
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
              
            <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Graph View</button>
            
            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Calendar View</button>
            
          </div>
        </nav>


<div class="tab-content" id="nav-tabContent">
    
  <div class="tab-pane fade me-lg-4" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      
      <canvas id="lineChart"></canvas>
  </div>
  
  
    <div class="tab-pane fade show active me-lg-5" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        {!! $calendar->calendar() !!}
        {!! $calendar->script() !!}
    </div>
 
</div>
                   
                    
                    <div class="">
                     
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="my-4">
                        <div class=" shadow p-3 mb-5 bg-body rounded">
                            <div class="m-auto text-center">
                                <h5><b> &#x20B9; </b> {{$total_balance_amount}}</h5>
                              <p>  <b>YOUR BALANCE</b></p>
                            </div>
                            <section>
                                <div class="circle-wrap">
                                    <div class="circle">
                                        <div class="mask full">
                                            <div class="fill"></div>
                                        </div>
                                        <div class="mask half">
                                            <div class="fill"></div>
                                        </div>
                                        <div class="inside-circle">&#x20B9;{{$total_income_amount}}</div>
                                    </div>
                                </div>
                            </section>

                            <div>
                              

                                        @foreach($expenses_records as $index=>$data)

 <div class="m-3 "> <i class="{{$data->category->category_icon}} text-success" aria-hidden="true"></i>
                                    {{$data->category->category_name}} <span class="float-end"><b> &#x20B9; </b> {{$data->expense_amount}}</span></div>
                                        @endforeach
                                <a href="{{url('expense')}}"><p class="text-center"><b>VIEW ALL</b></p></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>

        <!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

                 {!!Form::open(['url'=>['expense'],'files' => true, 'class' => ' form-bordered form-row-stripped','id' =>''])!!}

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  
          
          <div class="mb-3">
            <label for="" class="col-form-label">Select Categorie</label>
            {!!Form::select('category_id',$user_categories,null,array('class'=>'form-control','placeholder'=>'Select Category','autocomplete'=>'off','required')) !!}
          </div>

         

          <div class="mb-3">
            <label for="" class="col-form-label">Expense Amount</label>
            {!!Form::number('expense_amount',null,array('class'=>'form-control','placeholder'=>'Enter Amount','autocomplete'=>'off','required')) !!} 
          </div>


 <div class="mb-3">
            <label for="" class="col-form-label">Select Expense Date</label>
            {!!Form::date('expense_date',null,array('class'=>'form-control append_date','autocomplete'=>'off','required')) !!} 
          </div>


      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save Expense</button>
      </div>
      {{Form::close()}}
    </div>
  </div>
</div>

    </div>

    @endsection

<!-- ................push new js link................. -->

@push('js')
 <script src="{{asset('public/js/validation.js')}}"></script>
    <script src="{{ asset('public/js/Chart.min.js') }}"></script>


    <script src="{{ asset('public/js/moment.min.js') }}"></script>

      <script src="{{ asset('public/js/fullcalendar.min.js') }}"></script>

  <script>
   //line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
  type: 'line',
  data: {
    labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],


    datasets: [{
      label: "Monthly",
      data:@json($arrays),

      


      backgroundColor: [
        'rgb(199 242 255)',
      ],
      borderColor: [
        'rgb(131 230 251)',
      ],
      borderWidth: 2
    },
   
    ]
  },


  options: {
    responsive: true
  }
});

  </script>
@endpush
