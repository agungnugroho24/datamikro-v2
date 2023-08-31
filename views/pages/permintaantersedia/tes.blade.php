<!-- View template master -->
@extends('layouts.index') 
 
<!-- Konten -->
@section('konten')
<div class="container">
  <div class="row">
      <div class="col-md-10 offset-md-1">
          <div class="panel panel-default">
              <div class="panel-heading">Dashboard</div>
              <div class="panel-body">
                  <canvas id="canvas" height="280" width="600"></canvas>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script type="text/javascript">
  var month = {{$month}};
    var request_datas = {{$request_datas}};
    var barChartData = {
        labels: month,
        datasets: [{
            label: 'request_datas',
            backgroundColor: "pink",
            data: request_datas
        }]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Yearly User Joined'
                }
            }
        });
    };
  </script>
@endpush