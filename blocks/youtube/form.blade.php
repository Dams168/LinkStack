<label for='title' class='form-label'>{{__('messages.Title')}}</label>
<input type='text' name='title' value='{{$title ?? ''}}' class='form-control' required />

<label class="form-label">YouTube URL</label>
<input
    type="url"
    name="link"
    value="{{ $link }}"
    class="form-control"
    placeholder="https://www.youtube.com/watch?v=xxxx"
    required
/>
