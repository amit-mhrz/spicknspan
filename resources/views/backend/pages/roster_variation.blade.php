@extends('backend.layouts.app',['title'=> 'Roster Variation'])

@section('content')

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      @if ($errors->any())
          <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                  {{ $error }}
              @endforeach
          </div>
      @endif
      @if (\Session::has('message'))
        <div class="alert alert-success custom_success_msg">
            {{ \Session::get('message') }}
        </div>
      @endif
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Roster Variation List</h3>
                    <p class="pull-right">
                        <label for="">Month-Year</label>
                        <input name="ctl00$contentSection$txtDOM" type="text" value="" id="contentSection_txtDOM" class="datepicker" placeholder="Select Month-Year">
                        <span id="contentSection_reqMonthPicker" style="color:Red;display:none;">Required</span>
                        <a id="contentSection_btnRefresh" class="btn btn-warning" href='javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions("ctl00$contentSection$btnRefresh", "", true, "validation", "", false, true))' style="margin-top: -7px !important;"><i class="fa fa-refresh"></i></a>
                    </p>
                </div>

                <table id="tblRoster" class="table table-hover dataTable no-footer order-list table-striped" role="grid" aria-describedby="tblRoster_info">
              <thead>
                  <tr role="row">
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Employee</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Client</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Employee</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Client</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Employee</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Client</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Employee</th>
                      <th style="width: 100px;" class="sorting_disabled" rowspan="1" colspan="1">Client</th>
                    </tr>
              </thead>

              <tbody class="roster-list">

              </tbody>

            </table>

            </div>
            <!-- /.box -->

        </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')

<script type="text/javascript">
  $(function () {

    $('#tblRoster').DataTable( {
        "scrollX": true
    } );

  })
</script>
  
@endpush