@if (Session::has('notification.message'))
<div class="alert alert-{{ Session::get('notification.type')}}">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @if (Session::get('notification.type') == 'success')
    <h4><i class="icon fa fa-check"></i> {{Session::get('notification.message')}}</h4>
    @else
    <h4><i class="fa fa-info-circle"></i> {{Session::get('notification.message')}}</h4>
    @endif
</div>
@endif
