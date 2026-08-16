<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ get_setting('store_name', config('app.name')) }} | Dashboard</title>
  <!-- core:css -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/core/core.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <!-- end plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('admin/assets/fonts/feather-font/css/iconfont.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/sweetalert2/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/assets/vendors/select2/select2.min.css') }}">
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/demo_1/style.css') }}">
  <!-- End layout styles -->
  <link rel="shortcut icon" type="image/png" href="{{ get_setting('site_favicon') }}">

  @stack('style')
</head>

<body>
  <div class="main-wrapper">

    <!-- partial:partials/_sidebar.html -->
    @include('admin.layouts.partials.sidebar')

    <nav class="settings-sidebar">
      <div class="sidebar-body">
        <a href="#" class="settings-sidebar-toggler">
          <i data-feather="settings"></i>
        </a>
        <h6 class="text-muted">Sidebar:</h6>
        <div class="form-group border-bottom">
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarLight"
                value="sidebar-light" checked>
              Light
            </label>
          </div>
          <div class="form-check form-check-inline">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="sidebarThemeSettings" id="sidebarDark"
                value="sidebar-dark">
              Dark
            </label>
          </div>
        </div>
        <div class="theme-wrapper">
          <h6 class="text-muted mb-2">Light Theme:</h6>
          <a class="theme-item active" href="../demo_1/dashboard-one.html">
            <img src="{{ asset('admin/assets/images/screenshots/light.jpg') }}" alt="light theme">
          </a>
          <h6 class="text-muted mb-2">Dark Theme:</h6>
          <a class="theme-item" href="../demo_2/dashboard-one.html">
            <img src="{{ asset('admin/assets/images/screenshots/dark.jpg') }}" alt="light theme">
          </a>
        </div>
      </div>
    </nav>
    <!-- partial -->

    <div class="page-wrapper">
      @include('admin.layouts.partials.header')
      <!-- partial:partials/_navbar.html -->

      <!-- partial -->
      <div class="page-content">
        @yield('content')
      </div>

      <!-- partial:partials/_footer.html -->
      @include('admin.layouts.partials.footer')
      <!-- partial -->

    </div>

    {{-- Delete Form --}}
    <form id="delete-form" method="POST" class="d-none">
      @csrf
      @method('DELETE')
    </form>
  </div>

  <!-- core:js -->
  <script src="{{ asset('admin/assets/vendors/core/core.js') }}"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="{{ asset('admin/assets/vendors/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
  <!-- end plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('admin/assets/vendors/feather-icons/feather.min.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('admin/assets/vendors/select2/select2.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/template.js') }}"></script>
  <!-- endinject -->
  <!-- custom js for this page -->
  <script src="{{ asset('admin/assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('admin/assets/js/datepicker.js') }}"></script>
  <!-- end custom js for this page -->

  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });

    @if (session('success'))
      Toast.fire({
        icon: "success",
        title: "{{ session('success') }}"
      });
    @endif

    @if (session('error'))
      Toast.fire({
        icon: "error",
        title: "{{ session('error') }}"
      });
    @endif

    @if (session('warning'))
      Toast.fire({
        icon: "warning",
        title: "{{ session('warning') }}"
      });
    @endif
  </script>

  <script>
    $(document).on('click', '.delete-confirm', function(e) {
      e.preventDefault();

      const url = $(this).attr('href');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $('#delete-form').attr('action', url).submit();
        }
      });
    });
  </script>

  <script>
    $(document).ready(function() {
      // Init feather icons
      feather.replace();

      $('.data-table').DataTable({
        "aLengthMenu": [
          [5, 10, 30, 50, -1],
          [5, 10, 30, 50, "All"]
        ],
        "iDisplayLength": 5,
        "language": {
          search: ""
        }
      });

      $('.data-table').each(function() {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
      });
    });
  </script>

  @stack('script')
</body>

</html>
