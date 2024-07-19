<!-- The only way to do great work is to love what you do. - Steve Jobs -->
@props(['name', 'type' => 'info'])

@if(Session::get($name))
    <div class="alert alert-{{$type}}">
        {{ Session::get($name) }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
