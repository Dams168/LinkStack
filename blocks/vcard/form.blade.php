<?php
use JeroenDesloovere\VCard\VCard;
use App\Models\Button;

$button = Button::find($button_id);
$buttonName = isset($button->name) ? $button->name : 0;
?>

<select style="display:none" name="button" class="form-control">
    <option class="button button-default email" value="vcard">
        {{ __('messages.Vcard') }}
    </option>
</select>

@php
try {
$data = json_decode($link);

$prefix = $data->prefix;
$firstName = $data->first_name;
$middleName = $data->middle_name;
$lastName = $data->last_name;
$suffix = $data->suffix;
$organization = $data->organization;
$vtitle = $data->vtitle;
$role = $data->role;
$workUrl = $data->work_url;
$email = $data->email;
$workEmail = $data->work_email;
$homePhone = $data->home_phone;
$workPhone = $data->work_phone;
$cellPhone = $data->cell_phone;
$homeAddressLabel = $data->home_address_label;
$homeAddressStreet = $data->home_address_street;
$homeAddressCity = $data->home_address_city;
$homeAddressState = $data->home_address_state;
$homeAddressZip = $data->home_address_zip;
$homeAddressCountry = $data->home_address_country;
$workAddressLabel = $data->work_address_label;
$workAddressStreet = $data->work_address_street;
$workAddressCity = $data->work_address_city;
$workAddressState = $data->work_address_state;
$workAddressZip = $data->work_address_zip;
$workAddressCountry = $data->work_address_country;
} catch (Exception $e) {}
@endphp

<div class="form-group-col">
    <label for="title" class="form-label">{{ __('messages.Custom Title') }}</label>
    <input type="text" name="link_title" class="form-control" value="{{ $title }}">
    <p>
        <i class="bi bi-info-circle-fill"></i>
        <span>{{ __('messages.Leave blank for default title') }}</span>
    </p>
</div>

<h4>{{ __('messages.Name') }}</h4>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Prefix') }}</label>
    <input type="text" name="prefix" class="form-control" value="{{ $prefix ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.First Name') }}</label>
    <input type="text" name="first_name" class="form-control" value="{{ $firstName ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Middle Name') }}</label>
    <input type="text" name="middle_name" class="form-control" value="{{ $middleName ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Last Name') }}</label>
    <input type="text" name="last_name" class="form-control" value="{{ $lastName ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Suffix') }}</label>
    <input type="text" name="suffix" class="form-control" value="{{ $suffix ?? '' }}">
</div>

<h4>{{ __('messages.Work') }}</h4>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Organization') }}</label>
    <input type="text" name="organization" class="form-control" value="{{ $organization ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Title') }}</label>
    <input type="text" name="vtitle" class="form-control" value="{{ $vtitle ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Role') }}</label>
    <input type="text" name="role" class="form-control" value="{{ $role ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Work URL') }}</label>
    <input type="url" name="work_url" class="form-control" value="{{ $workUrl ?? '' }}">
</div>

<h4>{{ __('messages.Emails') }}</h4>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Email') }}</label>
    <input type="email" name="email" class="form-control" value="{{ $email ?? '' }}">
    <span class="small text-muted">{{ __('messages.Enter your personal email') }}</span>
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Work Email') }}</label>
    <input type="email" name="work_email" class="form-control" value="{{ $workEmail ?? '' }}">
    <span class="small text-muted">{{ __('messages.Enter your work email') }}</span>
</div>

<h4>{{ __('messages.Phones') }}</h4>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Home Phone') }}</label>
    <input type="tel" name="home_phone" class="form-control" value="{{ $homePhone ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Work Phone') }}</label>
    <input type="tel" name="work_phone" class="form-control" value="{{ $workPhone ?? '' }}">
</div>

<div class="form-group-col">
    <label class="form-label">{{ __('messages.Cell Phone') }}</label>
    <input type="tel" name="cell_phone" class="form-control" value="{{ $cellPhone ?? '' }}">
</div>