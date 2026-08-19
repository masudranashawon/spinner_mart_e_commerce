@if(request()->is('admin/*') || request()->is('admin'))
 {{-- if admin route --}}
@include('errors.admin-404')
@else
 {{-- if frontend route --}}
@include('errors.frontend-404')
@endif
