<div class="form-group-col">
    <label for='title' class="form-label">{{__('messages.Title')}}</label>
    <input type='text' name='title' value='{{$title}}' required class="form-control" />
</div>

<div class="form-group-col">
    <label for='title' class="form-label">{{__('messages.URL')}}</label>
    <input type='url' name='link' value='{{$link}}' required class="form-control" />
</div>

<div class="form-group-row">
    <input type="checkbox" class="form-control" value='1' {{((isset($params->GetSiteIcon) ?
    boolval($params->GetSiteIcon) : false) ? 'checked': '') }} name='GetSiteIcon' id="GetSiteIcon" @if($button_id ==
    2)checked @endif>

    <label class="custom-control-label" for="GetSiteIcon">{{__('messages.Show website icon on button')}}</label>
</div>

{{-- <label for="title" class="form-label">
    {{ __('messages.Title') }}
</label>
<input type="text" name="title" value="{{ $title ?? '' }}" class="form-control" required />

<label for="link" class="form-label mt-3">
    {{ __('messages.URL') }}
</label>
<input type="url" name="link" id="customLinkInput" value="{{ $link ?? '' }}" class="form-control" required
    autocomplete="off" />

<div id="linkSafetyFeedback" class="mt-2 small"></div>

<input type="hidden" name="link_safety_status" id="linkSafetyStatus" />

<div class="custom-control custom-checkbox m-2">
    <input type="checkbox" class="custom-control-input" value="1" name="GetSiteIcon" id="GetSiteIcon" {{
        ((isset($params->GetSiteIcon) ? boolval($params->GetSiteIcon) : false) ? 'checked' : '') }}
    @if(isset($button_id) && $button_id == 2) checked @endif
    >
    <label class="custom-control-label" for="GetSiteIcon">
        {{ __('messages.Show website icon on button') }}
    </label>
</div>
<script>
    (function () {

    const input        = document.getElementById('customLinkInput');
    const feedback     = document.getElementById('linkSafetyFeedback');
    const statusInput  = document.getElementById('linkSafetyStatus');
    const submitButton = document.querySelector('button[type="submit"]');

    let debounceTimer = null;

    if (!input) return;

    input.addEventListener('input', function () {
        clearTimeout(debounceTimer);

        const url = this.value.trim();

        feedback.innerHTML = '';
        feedback.className = 'mt-2 small';
        statusInput.value = '';

        if (submitButton) {
            submitButton.disabled = false;
        }

        if (!url) return;

        debounceTimer = setTimeout(() => {

            fetch("{{ route('studio.link.validate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    link: url,
                })
            })
            .then(response => response.json())
            .then(data => {

                if (!data || !data.status) return;

                statusInput.value = data.status;
                if (data.status === 'blocked') {

                    feedback.innerHTML =
                        "❌ <strong>Link diblokir</strong><br>" +
                        (data.reasons ? data.reasons.join(', ') : '');

                    feedback.classList.add('text-danger');

                    if (submitButton) {
                        submitButton.disabled = true;
                    }
                }
                else if (data.status === 'warning') {

                    feedback.innerHTML =
                        "⚠️ <strong>Link mencurigakan</strong>. " +
                        "Pastikan URL benar dan aman.";

                    feedback.classList.add('text-warning');
                }
                else if (data.status === 'safe') {

                    feedback.innerHTML =
                        "✅ <strong>Link aman</strong>";

                    feedback.classList.add('text-success');
                }
            })
            .catch(() => {
                feedback.innerHTML =
                    "⚠️ Tidak dapat memeriksa link saat ini.";
                feedback.classList.add('text-warning');
            });

        }, 600);

    });

})();
</script> --}}