@props(['name'])

@error($name)
    <div class="d-block text-danger" style="margin-top: -20px; margin-bottom: 15px;">
        {{ $message }}
    </div>
@enderror
