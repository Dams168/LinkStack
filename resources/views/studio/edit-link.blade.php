@extends('layouts.sidebar')

@section('content')


<form action="{{ route('addLink') }}" method="post" id="my-form" class="main-section">
    @method('POST')
    @csrf

    <div class="main-header">
        <h2 class="main-title">@if($LinkID !== 0) Edit @else Add @endif Link</h2>
        <span class="main-divider"></span>
        <div class="main-action">
            <a class="btn btn-primary btn-outline" href="{{ url('studio/links') }}">Cancel</a>
            <button type="button" class="btn btn-primary btn-soft" onclick="submitFormWithParam('add_more')">Save &
                Add Another</button>
            <button type="submit" class="btn btn-primary">Add to Profile</button>
        </div>
    </div>

    <p class="main-desc">Select a content type and customize the details to add a new link or social block to
        your profile.</p>

    <input type='hidden' name='linkid' value="{{ $LinkID }}" />

    <div class="form-group-col">

        <label for="typename" class="form-label">
            {{ __('messages.Select Block') }}
        </label>

        <select name="typename" id="typename" class="form-control" required>
            @foreach ($LinkTypes as $lt)
            @php
            if(block_text_translation_check($lt['title'])) {
            $title = bt($lt['title']);
            } else {
            $title = __('messages.block.title.'.$lt['typename']);
            }
            @endphp

            <option value="{{ $lt['typename'] }}" {{ $typename===$lt['typename'] ? 'selected' : '' }}>
                {{ $title }}
            </option>
            @endforeach
        </select>
        <p>
            <i class="bi bi-info-circle-fill"></i>
            <span>Please choose block type</span>
        </p>
    </div>

    <div id='link_params' class="main-form-body"></div>

</form>
@endsection

<script>
    function submitFormWithParam(paramValue) {
        // get the form element
        var form = document.getElementById("my-form");

        // create a hidden input field with the parameter value
        var paramField = document.createElement("input");
        paramField.setAttribute("type", "hidden");
        paramField.setAttribute("name", "param");
        paramField.setAttribute("value", paramValue);
        // append the hidden input field to the form
        form.appendChild(paramField);
        // submit the form
        form.submit();
    }
</script>

@push('sidebar-stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/override.css') }}">
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
@endpush

@push("sidebar-scripts")
<script>
    $(function () {
    const $typeSelect = $("select[name='typename']");
    const $linkId = $("input[name='linkid']").val();

    LoadLinkTypeParams($typeSelect.val(), $linkId);

    $typeSelect.on('change', function () {
        LoadLinkTypeParams($(this).val(), $linkId);
    });

    function LoadLinkTypeParams(typeId, linkId) {
        var baseURL = "{{ url('') }}";
        $("#link_params")
            .html('<div class="spinner-border text-primary" role="status"></div>')
            .load(`${baseURL}/studio/linkparamform_part/${typeId}/${linkId}`);

        setTimeout(function () {
            document.dispatchEvent(new Event('contentLoaded'));
        }, 300);
    }
});
</script>
@endpush