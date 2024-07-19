<!-- Waste no more time arguing what a good man should be, be one. - Marcus Aurelius -->
@props(['name'])

@error($name)
    <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px;">
        {{ $message }}
    </div>
@enderror
