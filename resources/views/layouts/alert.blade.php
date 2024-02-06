@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <p>{{ $message }}</p>
    </div>
</div>
@elseif ($message = Session::get('update'))
<div class="alert alert-warning alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <p>{{ $message }}</p>
    </div>
</div>
@elseif ($message = Session::get('destroy'))
<div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <p>{{ $message }}</p>
    </div>
</div>
@endif