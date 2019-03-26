@extends('backend.layouts.app',['title'=>'Attendance'])

@section('content')

    <!-- Main content -->
    <section class="content attendance_history" style="padding-top: 50px;">
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

    <section class="content location_history" style="padding-top: 50px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Location History</h3>
                <div class="box-body table-responsive no-padding new_padding">
                  <div id="mapid"></div>
                  <?php
                      $map_lat = $attendance_list->latitude;
                      $map_long = $attendance_list->longitude;
                      ?>
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

  <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
  <script type="text/javascript">

      var geoCoords = '[' + <?php echo $map_lat;?> + ', ' + <?php echo $map_long;?> + ']';
      var map = L.map('mapid', {
      center: JSON.parse(geoCoords),
      zoom: 14
      });
      var marker = L.marker(JSON.parse(geoCoords)).addTo(map);
      marker.bindPopup("<b>You are Here</b>").openPopup();
      map.scrollWheelZoom.disable();

      L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoiYW1pdC1tYWhhcnhhbiIsImEiOiJjanJ1cGZxZ3UwNnhsNGFsNTAzcWtsanpsIn0.tnq36qhYA87WJb2nR7_KIw', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox.streets',
      accessToken: 'pk.eyJ1IjoiYW1pdC1tYWhhcnhhbiIsImEiOiJjanRwcjQwbWQwNnljM3lsbDlkcmFlNWVwIn0.BZXR3VF6Xdn7E1OLQaYRiw'
      }).addTo(map);

  </script>
@endpush
     




























