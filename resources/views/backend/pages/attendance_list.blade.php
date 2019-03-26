@extends('backend.layouts.app',['title'=>'Attendance'])

@section('content')

    <!-- Main content -->
    <section class="content" style="padding-top: 50px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Attendance</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Date</th>
                  <th>Client Name</th>
                  <th>Checked In Location</th>
                  <th>Checked Out Location</th>
                  <th>Total Hours</th>
                  <th>Timing</th>
                </tr>
                @foreach($attendance_lists as $attendance_list)
                  @php  
                      $check_in = \Carbon\Carbon::parse($attendance_list->check_in);
                      $check_out = \Carbon\Carbon::parse($attendance_list->check_out);
                      $hours = $check_out->diffInHours($check_in);
                  @endphp
                  <tr>
                    <td>{{$attendance_list->created_at->format('d-m-Y')}}</td>
                    @foreach($user_lists as $user_list)
                        @if($user_list->id == $attendance_list->client_id)
                            <td>{{$user_list->name}}</td>
                        @endif
                    @endforeach
                    <td>
                        <button id="find_btn">Location</button>
                    </td>
                    <td>
                        <button id="find_btn">Location</button>
                    </td>
                    <td>{{$hours}} Hours</td>
                    <td>{{$check_in->format('H:i:s')}} - {{$check_out->format('H:i:s')}}</td>
                  </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->

    <section class="content" style="padding-top: 50px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Location History</h3>
                <div class="box-body table-responsive no-padding">
                  <div id="map"></div>
                </div>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>

@endsection
@push('scripts')
  <script type="text/javascript">
      function checkin(){
        var action = "{{route('attendance.checkin')}}";
        $('form').attr('action',action);
        $('form').submit();
      }
      function checkout(){
        var action = "{{route('attendance.checkout')}}";
        $('form').attr('action',action);
        $('form').submit();
      }
  </script>

  <script type="text/javascript">
  var map;
  function initMap() {
  var mapCenter = new google.maps.LatLng(47.6145, -122.3418); //Google map Coordinates
  map = new google.maps.Map($("#map")[0], {
      center: mapCenter,
      zoom: 8
      });
  }

  $("#find_btn").click(function (){
    if ("geolocation" in navigator){
        navigator.geolocation.getCurrentPosition(function(position){ 
            infoWindow = new google.maps.InfoWindow({map: map});
            var pos = {lat: position.coords.latitude, lng: position.coords.longitude};
            infoWindow.setPosition(pos);
            infoWindow.setContent("Found your location <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude);
            map.panTo(pos);
          });
      }else{
        console.log("Browser doesn't support geolocation!");
    }
  });
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
@endpush
     




























