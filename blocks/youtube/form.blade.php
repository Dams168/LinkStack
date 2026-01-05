<div class="form-group-col">
    <label class="form-label" for='title'>{{__('messages.Title')}}</label>
    <input class="form-control" type='text' name='title' value='{{$title ?? ''}}' />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>Leave blank for default video title</span>
    </p>
</div>


<div class="form-group-col">
    <label class="form-label">YouTube URL</label>
    <input class="form-control" type="url" name="link" value="{{ $link }}"
        placeholder="https://www.youtube.com/watch?v=xxxx" required />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>{{__('messages.URL to the video')}}</span>
    </p>
</div>