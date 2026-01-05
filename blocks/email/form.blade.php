<?php use App\Models\Button; $button = Button::find($button_id); if(isset($button->name)){$buttonName = $button->name;}else{$buttonName = 0;} ?>

<select style="display:none" name="button" class="form-control">
    <option class="button button-default email" value="default email">{{__('messages.Default Email')}}</option>
</select>

<div class="form-group-col">
    <label for='title' class='form-label'>{{__('messages.Custom Title')}}</label>
    <input type='text' name='title' value='{{$title}}' class='form-control' />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>{{__('messages.Leave blank for default title')}}</span>
    </p>
</div>

<div class="form-group-col">
    <label for='link' class="form-label">{{__('messages.E-Mail address')}}</label>
    <input type='email' name='link' class="form-control" value='{{str_replace("mailto:", "", $link)}}' required />
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>{{__('messages.Enter your E-Mail')}}</span>
    </p>
</div>

<script>
    $(document).ready(function() {
    $('form').on('submit', function(e) {
        var linkInput = $(this).find('input[name="link"]');
        var linkValue = linkInput.val();
        if (!linkValue.toLowerCase().startsWith('mailto:')) {
            linkInput.val('mailto:' + linkValue);
        }
    });
});
</script>