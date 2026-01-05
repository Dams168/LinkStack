<div class="form-group-col">
    <label for='button' class='form-label'>{{__('messages.Select a predefined site')}}</label>
    <?php use App\Models\Button; $button = Button::find($button_id); if(isset($button->name)){$buttonName = $button->name;}else{$buttonName = 0;} ?>

    <select name='button' required class="form-control">
        @if($buttonName != 0)<option value='{{$buttonName}}'>{{ucfirst($buttonName)}}</option>@endif
        @foreach ($buttons as $b)
        @if($b["exclude"] != true)
        <option class='button button-{{$b["name"]}}' value='{{$b["name"]}}' {{ $b["selected"]==true ? "selected" : ""
            }}>{{$b["title"]}}</option>
        @endif
        @endforeach
    </select>
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>Please choose a predefined site</span>
    </p>
</div>

<div class="form-group-col">
    <label for='title' class='form-label'>{{__('messages.Custom Title')}}</label>
    <input type='text' name='title' value='{{$title}}' class="form-control" />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>Leave blank for default title</span>
    </p>
</div>

<div class="form-group-col">
    <label for='link' class='form-label'>{{__('messages.URL')}}</label>
    <input type='url' name='link' value='{{$link}}' required class="form-control" />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>Please input the link</span>
    </p>
</div>