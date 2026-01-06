@props(['errors'])

@if ($errors->any())
<div {{ $attributes }} class="alert-message error">

    <p class="status-title">
        <i class="bi bi-x-circle-fill"></i>
        Failed!
    </p>

    <ul class="status-message">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

</div>
@endif