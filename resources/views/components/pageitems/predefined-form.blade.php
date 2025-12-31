<label for='button' class='form-label'>{{__('messages.Select a predefined site')}}</label>
<?php use App\Models\Button; $button = Button::find($button_id); if(isset($button->name)){$buttonName = $button->name;}else{$buttonName = 0;} ?>

<select name='button' class='form-control'>
        @if($buttonName != 0)<option value='{{$buttonName}}'>{{ucfirst($buttonName)}}</option>@endif
    @foreach ($buttons as $b)
        @if($b["exclude"] != true)
        <option class='button button-{{$b["name"]}}' value='{{$b["name"]}}' {{ $b["selected"] == true ? "selected" : ""}}>{{$b["title"]}}</option>
        @endif
    @endforeach
</select>

<label for='title' class='form-label'>{{__('messages.Custom Title')}}</label>
<input type='text' name='title' value='{{$title}}' class='form-control' />
<span class='small text-muted'>{{__('messages.Leave blank for default title')}}</span><br>

<label for='link' class='form-label'>{{__('messages.URL')}}</label>
<input type='url' name='link' value='{{$link}}' class='form-control' required />
<span class='small text-muted'>{{__('messages.Enter the link URL')}}</span>

<div id="url-error" class="text-danger small mt-1 d-none"></div>

<script>
if (!window.__linkRealtimeInit) {
    window.__linkRealtimeInit = true;

    // console.log('[INIT] realtime validator loaded');

    function initLinkRealtimeValidator() {

        const linkInput   = document.querySelector('input[name="link"]');
        const buttonInput = document.querySelector('select[name="button"]');
        const errorBox    = document.getElementById('url-error');

        if (!linkInput || !buttonInput) {
            // console.warn('[SKIP] element not found');
            return;
        }

        let timer = null;

        function validateRealtime() {
            clearTimeout(timer);

            const link   = linkInput.value.trim();
            const button = buttonInput.value;

            // console.log('[STATE]', { link, button });

            if (!link || !button) return;

            timer = setTimeout(() => {
                // console.log('[FETCH] validate');

                fetch("{{ route('studio.link.validate-url') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                    },
                    body: JSON.stringify({ link, button }),
                })
                .then(res => res.json().then(data => ({ ok: res.ok, data })))
                .then(({ ok, data }) => {
                    // console.log('[RESPONSE]', data);

                    if (!ok) {
                        errorBox.textContent = data.message;
                        errorBox.classList.remove('d-none');
                        linkInput.classList.add('is-invalid');
                        return;
                    }

                    errorBox.classList.add('d-none');
                    linkInput.classList.remove('is-invalid');
                });
            }, 400);
        }

        linkInput.addEventListener('input', validateRealtime);
        buttonInput.addEventListener('change', validateRealtime);

        // console.log('[READY] events attached');
    }

    window.initLinkRealtimeValidator = initLinkRealtimeValidator;
}

window.initLinkRealtimeValidator();
</script>
