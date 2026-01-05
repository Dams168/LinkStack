<?php use App\Models\UserData; ?>

@extends('layouts.sidebar')

@section('content')
@foreach($pages as $page)
<form action="{{ route('editPage') }}" enctype="multipart/form-data" method="post" class="main-section page-form">
  @csrf

  <div class="main-header">
    <h2 class="main-title">My Profile</h2>
    <span class="main-divider"></span>
    <div class="main-action">
      {{-- <a href="{{ url('studio/page') }}" class="btn btn-primary btn-soft">Cancel</a> --}}
      <button type="submit" class="btn btn-primary">Save
        <i class="bi bi-check-lg"></i>
      </button>
    </div>
  </div>

  <p class="main-desc">Manage your personal details to keep your profile accurate and current.</p>

  @if($errors->any())
  <div class="alert alert-danger d-flex align-items-center mt-3" role="alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
      <use xlink:href="#exclamation-triangle-fill"></use>
    </svg>
    <div>
      @foreach ($errors->all() as $error)
      {{ $error }}
      @endforeach
    </div>
  </div>
  @endif

  <div class="flex flex-row gap-8 py-8">
    <div class="form-group-row">

      <div class="avatar-input">
        @if(file_exists(base_path(findAvatar(Auth::user()->id))))
        <img id="imagePreview" src="{{ url(findAvatar(Auth::user()->id)) }}" alt="" class="avatar-preview">
        @elseif(file_exists(base_path("assets/linkstack/images/").findFile('avatar')))
        <img id="imagePreview" src="{{ url("assets/linkstack/images/")."/".findFile('avatar') }}" alt=""
          class="avatar-preview">
        @else
        <img id="imagePreview" src="{{ asset('assets/linkstack/images/logo.svg') }}" alt="" class="avatar-preview">
        @endif

        <input type="file" name="image" id="fileInput" class="hidden" accept="image/jpeg,image/jpg,image/png,image/webp"
          onchange="previewImage(event)">

        @if(file_exists(base_path(findAvatar(Auth::user()->id))))
        <a href="{{ route('delProfilePicture') }}" class="btn btn-danger btn-soft" title="Delete profile picture">
          Delete <i class="bi bi-trash-fill"></i>
        </a>
        @else
        <button type="button" onclick="document.getElementById('fileInput').click()" class="btn btn-primary btn-soft">
          Upload <i class="bi bi-upload"></i>
        </button>
        @endif
      </div>

      <div class="form-group-col">
        <div class="form-group-col">
          <label class="form-label" for="littlelink_name">Page URL</label>
          <?php
            $url = $_SERVER['REQUEST_URI'];
            if( strpos( $url, "no_page_name" ) == true ) echo '<span style="color:#FF0000; font-size:120%;">You do not have a Page URL</span>'; 
          ?>
          <div class="input-group form-control">
            <span class="input-group-text">{{str_replace(['http://','https://'], '', url(''))}}/@</span>
            <input class="input-group-field form-control" type="text" name="littlelink_name" id="littlelink_name"
              placeholder="Insert your page URL" value="{{ $page->littlelink_name ?? '' }}" required autofocus>
          </div>
        </div>

        <div class="form-group-col">
          <label class="form-label" for="name">Display name</label>
          <input class="form-control" type="text" name="name" id="name" placeholder="Set your display name"
            value="{{ $page->name }}" required>
        </div>

        <div class="form-group-col">
          <label class="form-label" for="pageDescription">Page Description</label>
          <textarea class="form-control" name="pageDescription" id="pageDescription" {{--
            class="@if(env('ALLOW_USER_HTML') === true) ckeditor @endif" rows="3" --}}
            placeholder="Insert your page description">{{ $page->littlelink_description ?? '' }}</textarea>
        </div>
      </div>
    </div>
  </div>

  <div class="form-group-col">
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'vip')
    <div class="form-group-row">
      <input type="checkbox" name="checkmark" id="checkmark" class="form-control" <?php
        if(UserData::getData(Auth::user()->id,
      'checkmark') == true){echo 'checked';} ?>>

      <label for="checkmark" class="form-label">Show checkmark
        <span>{{__('messages.disableverified')}}</span>
      </label>
    </div>
    @endif

    <div class="form-group-row">
      <input type="checkbox" name="sharebtn" id="sharebtn" class="form-control" <?php
        if(UserData::getData(Auth::user()->id,
      'disable-sharebtn') != "true"){echo 'checked';} ?>>
      <label for="sharebtn" class="form-label">
        Show share button
        <span>This setting allows you to hide the share button on your page.</span>
      </label>
    </div>

    <div class="flex flex-row gap-4">
      <input type="checkbox" name="tablinks" id="tablinks" class="form-control" <?php
        if(UserData::getData(Auth::user()->id,
      'links-new-tab') != false){echo 'checked';} ?>>
      <label for="tablinks" class="form-label">
        Open links in new tab
        <span'>This setting determines if your links on your links page get opened in the same or a new tab.</span>
      </label>
    </div>
  </div>

</form>
@endforeach

@include('auth.url-validation')


<script>
  function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(file);
    }
  }
</script>

@if(env('ALLOW_USER_HTML') === true)
<script src="{{ asset('assets/external-dependencies/ckeditor.js') }}"></script>
<script>
  ClassicEditor
      .create(document.querySelector('.ckeditor'), {
          toolbar: {
              items: [
                  'exportPDF', 'exportWord', '|',
                  'findAndReplace', 'selectAll', '|',
                  'heading', '|',
                  'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                  'bulletedList', 'numberedList', 'todoList', '|',
                  'outdent', 'indent', '|',
                  'undo', 'redo',
                  'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                  'alignment', '|',
                  'link', 'blockQuote', '|',
                  'specialCharacters', 'horizontalLine', '|',
                  'textPartLanguage', '|',
              ],
              shouldNotGroupWhenFull: true
          },
          fontFamily: {
              options: [
                  'default',
                  'Arial, Helvetica, sans-serif',
                  'Courier New, Courier, monospace',
                  'Georgia, serif',
                  'Lucida Sans Unicode, Lucida Grande, sans-serif',
                  'Tahoma, Geneva, sans-serif',
                  'Times New Roman, Times, serif',
                  'Trebuchet MS, Helvetica, sans-serif',
                  'Verdana, Geneva, sans-serif'
              ],
              supportAllValues: true
          },
          fontSize: {
              options: [10, 12, 14, 'default', 18, 20, 22],
              supportAllValues: true
          },
          link: {
              addTargetToExternalLinks: true,
              defaultProtocol: 'http://',
              decorators: {
                  addTargetToExternalLinks: {
                      mode: 'manual',
                      label: 'Open in new tab',
                      attributes: {
                          target: '_blank',
                          rel: 'noopener noreferrer'
                      }
                  }
              }
          }
      })
      .catch(error => {
          console.error(error);
      });
</script>
@endif

@endsection

@push('sidebar-stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/override.css') }}">
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
@endpush