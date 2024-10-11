@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 class="mb-2"><i class="icon fas fa-check"></i> Sukses!</h4>
    <span>{{$message}}</span>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 class="mb-2"><i class="icon fas fa-exclamation-triangle"></i> Terjadi Kesalahan!</h4>
    <span>{{$message}}</span>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 class="mb-2"><i class="icon fas fa-exclamation-triangle"></i> Warning!</h4>
    <span>{{$message}}</span>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 class="mb-2"><i class="icon fas fa-info-circle"></i> Info!</h4>
    <span>{{$message}}</span>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4 class="mb-2"><i class="icon fas fa-exclamation-triangle"></i> Terjadi Kesalahan</h4>
    @foreach ($errors->all() as $error)
    <span class="text-capitalize">{{ $error }}<br /></span>
    @endforeach
</div>
@endif