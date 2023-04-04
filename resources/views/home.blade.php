@extends('layout.newlayout')


@section('content')
    <!-- Flash Menu -->
    @if(session()->has('updated'))
          <div class="alert alert-success  alert-dismissible fade show"  role="alert">
              {{ session()->get('updated') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
    @endif

    @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show" id="getError" role="alert">
              {{ session()->get('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
    @endif

    <ul>    
    @if(count($errors) > 0)
         <div class = "alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </ul>
         </div>
    @endif
    </ul>

    <head>
    <title>Chart</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <style type="text/css">
        .content-header{
          padding-top:5px;
          padding-bottom: 5px;
        }
            span.b {
            display: inline-block;
            padding: 5px;
            border: 1px solid blue;    
            }
            
            .satux {
   font-size: 15px !IMPORTANT;
   color:blue !IMPORTANT;
   text-align: center !IMPORTANT;
   
   }
    
      .empat {
   font-size: 25px; 
   font-weight:500px;   
   color:red;
   background-color:#F0E68C;
   }  

   
      .dua {
   font-size: 15px !IMPORTANT;
   color:white !IMPORTANT;
   font-weight:500px;
   
   
   }
   
   #divpie{
     border:1px solid black;

          background-color:transparent;
		color:red !important;
	}
     
      #divpiex{

          background-color:#F5F5F5;
		color:red !important;
          
          
	}
     
     .divbutton{
			background: #A8E9FF;
		}
          
          .divbutton1{
			background: #66CDAA;
		}
          
          .divbutton2{
			background: #F5F5F5;
		}
    @media screen and (max-width: 992px) {
      .allchart{
        height:100% !important;
        width:100% !important;
      }
      
    }
        </style>

  <!-- <iframe width="100%" height="950" src="https://datastudio.google.com/embed/reporting/10AcjQX5oOui-cHXFL6B-k5YxcdMeFWqy/page/aY0VB" frameborder="0" style="border:0" allowfullscreen></iframe> -->
	
     
         
<div class="row">	  
      
       
</div>


</body>

@endsection
@section('scripts')
<script src="{{url('vendors\chart-js-datalabel\chartjs-plugin-datalabels-new.js')}}"></script>
<script>
function noexpitm(event, array){
        if(array[0]){
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/expitem";

                //console.log()
            }
        }
    }
    
    function belowStockClickEvent(event, array){
        if(array[0]){
            let element = this.getElementAtEvent(event);
            if (element.length > 0) {
                //var series= element[0]._model.datasetLabel;
                //var label = element[0]._model.label;
                //var value = this.data.datasets[element[0]._datasetIndex].data[element[0]._index];
                window.location = "/bstock";
                //console.log()
            }
        }
    }
</script>
<script>


    
</script>
@endsection