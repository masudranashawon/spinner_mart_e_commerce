@if(request()->is('admin/*') || request()->is('admin'))
    @include('errors.admin-500')
@else
    @include('errors.frontend-500') 
@endif