@extends('admin')

@section('title')
Dashboard |
@endsection

@section('content')
    <div class="row">
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-music"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Zumba <br> 10:00 AM - 11:00 AM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['10.00 AM - 11.00 AM'][0].'</span><span class="text-primary">/'.$allTimeslots['10.00 AM - 11.00 AM'][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-bicycle"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Adaptive Bike <br> 11:00 AM - 12:00 PM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['11.00 AM - 12.00 PM'][0].'</span><span class="text-primary">/'.$allTimeslots['11.00 AM - 12.00 PM'][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-bicycle"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Adaptive Bike <br> 12:00 PM - 01:00 PM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['12.00 PM - 01.00 PM'][0].'</span><span class="text-primary">/'.$allTimeslots['12.00 PM - 01.00 PM'][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-bicycle"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Adaptive Bike <br> 01:00 PM - 02:00 PM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['01.00 PM - 02.00 PM'][0].'</span><span class="text-primary">/'.$allTimeslots['01.00 PM - 02.00 PM'][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-group"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Zumba Familiar <br> 06:00 PM - 07:00 PM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['06.00 PM - 07.00 PM'][0][0].'</span><span class="text-primary">/'.$allTimeslots['06.00 PM - 07.00 PM'][0][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <span class="fa fa-life-buoy"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Gymkana Acuática <br> 06:00 PM - 07:00 PM</span>
            <span class="info-box-number">
              {!! '<span class="text-success">'.$allTimeslots['06.00 PM - 07.00 PM'][1][0].'</span><span class="text-primary">/'.$allTimeslots['06.00 PM - 07.00 PM'][1][1].'</span>' !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red">
            <span class="fa fa-flag-checkered"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Personas que han pagado</span>
            <span class="info-box-number">
              {!! $allTimeslots['total'] !!}
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red">
            <span class="fa fa-ticket"></span>
          </span>
          <div class="info-box-content">
            <span class="info-box-text">Billetes vendidos</span>
            <span class="info-box-number">
              {!! $allTickets->count()-1 !!}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      @include('admin.partials._registrationsTable', ['allRegistrations' => $allRegistrations])
      @include('admin.partials._raffleTable', ['allRaffle' => $allRaffle])
      @include('admin.partials._raffleTickets', ['allTickets' => $allTickets])
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#registrations, #raffle-data, #raffle-tickets').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": true,
              "responsive": true,
              "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
                }
            });

          $.ajaxSetup({
           headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
          });

          $('.approve-registration').on("submit", function(e) {
              var param = $(this).children('input').attr("value");
              e.preventDefault();
              $.ajax({
                  type        : 'POST',
                  url         : '{{ url("/admin/registrations/") }}'+'/'+param,
                  data : {_method : 'PUT'},
                  encode          : true,
                  error: function(xhr, textStatus, thrownError) {
                      alert('Se ha producido un error. Por favor, inténtelo más tarde..');
                  },
                  success: function(response) {
                      window.location.href = "{{ url('admin') }}";
                  }

              });
          });



          $('.approve-raffle').on("submit", function(e) {
              var param = $(this).children('input').attr("value");
              e.preventDefault();
              $.ajax({
                  type        : 'POST',
                  url         : '{{ url("/admin/raffle/") }}'+'/'+param,
                  data : {_method : 'PUT'},
                  encode          : true,
                  error: function(xhr, textStatus, thrownError) {
                      alert('Se ha producido un error. Por favor, inténtelo más tarde..');
                  },
                  success: function(response) {
                      window.location.href = "{{ url('admin') }}";
                  }

              });
          });


          $('.delete-raffle').on("submit", function(e) {
              var answer = confirm ("¿Seguro que desea eliminar esta inscripción?");
              var param = $(this).children('input').attr("value");
              e.preventDefault();
              if (answer)
              {
                  $.ajax({
                      type        : 'POST',
                      url         : '{{ url("/admin/raffle/") }}'+'/'+param,
                      data : {_method : 'DELETE'},
                      encode          : true,
                      error: function(xhr, textStatus, thrownError) {
                          alert('Se ha producido un error. Por favor, inténtelo más tarde..');
                      },
                      success: function(response) {
                          window.location.href = "{{ url('admin') }}";
                      }

                  });
              }

          });


          $('.delete-registration').on("submit", function(e) {
              var answer = confirm ("¿Seguro que desea eliminar esta inscripción?");
              var param = $(this).children('input').attr("value");
              e.preventDefault();
              if (answer)
              {
                  $.ajax({
                      type        : 'POST',
                      url         : '{{ url("/admin/registrations/") }}'+'/'+param,
                      data : {_method : 'DELETE'},
                      encode          : true,
                      error: function(xhr, textStatus, thrownError) {
                          alert('Se ha producido un error. Por favor, inténtelo más tarde..');
                      },
                      success: function(response) {
                          window.location.href = "{{ url('admin') }}";
                      }

                  });
              }

          });
        });
    </script>
@endsection