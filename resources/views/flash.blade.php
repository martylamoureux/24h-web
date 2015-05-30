@if (Session::has('success'))
    <div class="alert alert-success">
        <i class="fa fa-check-circle"></i> {!! Session::get('success') !!}
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-danger">
        <i class="fa fa-times-circle"></i> {!!Session::get('error') !!}
    </div>
@endif
@if (Session::has('warning'))
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i> {!!Session::get('warning') !!}
    </div>
@endif
@if (Session::has('info'))
    <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> {!!Session::get('info') !!}
    </div>
@endif

@if ($errors->has())
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-triangle"></i>
        <b class="alert-title">Veuillez résoudre les problèmes suivants pour pouvoir poursuivre : </b>
        @foreach ($errors->all() as $error)
            <p class="m-l-md"><i class="fa fa-caret-right"></i> {!!$error !!}</p>
        @endforeach
    </div>
@endif