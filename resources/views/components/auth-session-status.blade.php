@props(['status'])

@if ($status)
<div {{ $attributes->merge(['class' => 'alert-message success ' . $state]) }}>
    <p class="status-title">
        <i class="bi bi-check-circle-fill"></i>
        Success!
    </p>

    <p class="status-message">
        {{ $message }}
    </p>

</div>
@endif