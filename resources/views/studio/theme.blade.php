<?php use App\Models\UserData; ?>

@extends('layouts.sidebar')

@section('content')
@foreach($pages as $page)

<div class="main-section" x-data="{
        hasBackground: {{ file_exists(base_path('assets/img/background-img/' . findBackground(Auth::user()->id))) ? 'true' : 'false' }},
        editing: false,
        previewing: false,
        file: null
    }">


    <div class="main-header">
        <h2 class="main-title">Theme</h2>
        <span class="main-divider"></span>
    </div>

    <p class="main-desc">Customize your page appearance with themes and background images.</p>

    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-center" role="alert">
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

    <div class="themes-main">
        <div class="themes-section">
            <!-- Theme Selection Form -->
            <form action="{{ route('editTheme') }}" enctype="multipart/form-data" method="post" id="themeForm">
                @csrf
                <div>
                    <div class="main-header">
                        <h3 class="main-subtitle">Themes to use</h3>
                        <span class="main-divider"></span>
                    </div>

                    <input type="hidden" name="theme" id="theme-input" value="{{ $page->theme }}">

                    <div class="theme-grid">
                        <!-- Default Theme -->
                        <div class="theme-item @if($page->theme == '' or $page->theme == 'default') selected @endif"
                            onclick="selectTheme('default', this)">
                            <img src="{{asset('assets/linkstack/images/themes/default.png')}}" alt="Default Theme">
                            <div class="theme-name">Default Theme</div>
                        </div>

                        <!-- Custom Themes from themes folder -->
                        @php
                        if ($handle = opendir('themes')) {
                        while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                        if(file_exists(base_path('themes') . '/' . $entry . '/readme.md')){
                        $text = file_get_contents(base_path('themes') . '/' . $entry . '/readme.md');
                        $pattern = '/Theme Name:.*/';
                        preg_match($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
                        if(sizeof($matches) > 0) {
                        $themeName = substr($matches[0][0],12);
                        } else {
                        $themeName = $entry;
                        }
                        } else {
                        $themeName = $entry;
                        }

                        if(isset($themeName)):
                        @endphp
                        <div class="theme-item @if($page->theme == $entry) selected @endif"
                            onclick="selectTheme('{{$entry}}', this)">
                            <img src="{{url('themes/'.$entry.'/preview.png')}}" alt="{{$themeName}}">
                            <div class="theme-name">{{$themeName}}</div>
                        </div>
                        @php
                        endif;
                        unset($themeName);
                        }
                        }
                        closedir($handle);
                        }
                        @endphp
                    </div>
                </div>
            </form>

            <form action="{{ route('themeBackground') }}" enctype="multipart/form-data" method="post"
                id="backgroundForm">
                @csrf

                <div x-show="hasBackground && !editing && !previewing" x-transition x-cloak>
                    <div class="main-header">
                        <h3 class="main-subtitle">Custom Background</h3>
                        <span class="main-divider"></span>

                        <div class="main-action">
                            <button type="button" class="btn btn-primary btn-soft" @click="editing = true">
                                Upload New Background
                            </button>

                            <button type="button" class="btn btn-danger"
                                onclick="if(confirm('Remove background?')) window.location.href='{{ url('/studio/rem-background') }}'">
                                <i class="bi bi-trash-fill"></i> Remove
                            </button>
                        </div>
                    </div>

                    <div class="current-background">
                        <img src="{{ url('assets/img/background-img/' . findBackground(Auth::user()->id)) }}">
                    </div>
                </div>

                <div class="upload-area" x-show="(!hasBackground || editing) && !previewing" x-transition x-cloak>
                    <div class="main-header">
                        <h3 class="main-subtitle">Upload Background</h3>
                        <span class="main-divider"></span>
                    </div>

                    <div class="background-upload-area" @dragover.prevent @drop.prevent="
                        file = $event.dataTransfer.files[0];
                        if (!file) return;
                        previewing = true;
                    ">
                        <p>Drag and drop your background image here</p>
                        <span>or</span>

                        <label class="btn btn-primary btn-soft">
                            <i class="bi bi-arrow-up-circle-fill"></i> Browse Image
                            <input type="file" class="hidden" name="image" x-ref="fileInput"
                                accept="image/jpeg,image/jpg,image/png,image/webp,image/gif" @change="
                                file = $event.target.files[0];
                                if (!file) return;
                                previewing = true;
                            ">
                        </label>
                    </div>

                    <p class="info-message">
                        <i class="bi bi-exclamation-circle"></i>
                        Supported formats: JPEG, JPG, PNG, WEBP, GIF (Max 5MB)
                    </p>
                </div>

                <div x-show="previewing" x-transition x-cloak>
                    <div class="main-header">
                        <h3 class="main-subtitle">Custom Background</h3>
                        <span class="main-divider"></span>
                        <div class="main-action">
                            <button type="button" class="btn btn-primary btn-outline" @click="
                                previewing = false;
                                file = null;
                                $refs.fileInput.value = '';

                                if (hasBackground) {
                                    editing = false;
                                }
                            ">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Apply <i class="bi bi-check-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="preview-image">
                        <img :src="file ? URL.createObjectURL(file) : '{{ asset('assets/img/checker.png') }}'"
                            alt="Preview">
                    </div>

                </div>
            </form>
        </div>


        <!-- Preview Section -->
        <div>
            <div class="main-header">
                <h3 class="main-subtitle">Preview</h3>
                <span class="main-divider"></span>
            </div>
            <div class="links-preview">
                @if(env('USE_THEME_PREVIEW_IFRAME') === false or $page->littlelink_name == '')
                <img style="width:100%;max-width:700px;"
                    src="@if(file_exists(base_path() . '/themes/' . $page->theme . '/preview.png')){{url('/themes/' . $page->theme . '/preview.png')}}@elseif($page->theme === 'default' or empty($page->theme)){{url('/assets/linkstack/images/themes/default.png')}}@else{{url('/assets/linkstack/images/themes/no-preview.png')}}@endif"
                    alt="Theme Preview">
                @else
                <iframe allowtransparency="true" id="frPreview"
                    src="{{ url('') }}/@<?= Auth::user()->littlelink_name ?>">
                    {{__('messages.No compatible browser')}}
                </iframe>
                @endif
            </div>
        </div>
    </div>
</div>

{{--
<!-- Admin: Manage Themes Section -->
@if(auth()->user()->role == 'admin')
<div class="main-section manage-themes-section">
    <h3 class="main-subtitle">Manage Themes</h3>

    @if(env('ENABLE_THEME_UPDATER') == 'true')
    <div id="ajax-container">
        <div class="accordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="details-header">
                    <button class="accordion-button collapsed disabled" type="button" aria-expanded="false"
                        aria-controls="details-collapse">
                        <div style="max-height:20px;max-width:20px;" class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">{{__('messages.Loading...')}}</span>
                        </div>
                    </button>
                </h2>
                <div id="details-collapse" class="accordion-collapse collapse" aria-labelledby="details-header">
                    <div class="accordion-body"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="my-lazy-element"></div>
    @endif

    <form action="{{ route('editTheme') }}" enctype="multipart/form-data" method="post" style="margin-top: 2rem;">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{__('messages.Upload themes')}}</label>
            <input type="file" accept=".zip" name="zip" class="form-control form-control-lg">
        </div>

        <div class="theme-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload"></i> {{__('messages.Upload themes')}}
            </button>
            <button type="button" class="btn btn-danger">
                <a href="{{ url('/admin/theme') }}">
                    <i class="bi bi-trash-fill"></i> {{__('messages.Delete themes')}}
                </a>
            </button>
            <button type="button" class="btn btn-info">
                <a href="https://linkstack.org/themes/" target="_blank">
                    <i class="bi bi-download"></i> {{__('messages.Download themes')}}
                </a>
            </button>
        </div>
    </form>
</div>
@endif --}}

@endforeach

<!-- Scripts -->
<script src="{{ asset('assets/external-dependencies/jquery-1.12.4.min.js') }}"></script>
<script>
    function selectTheme(themeName, element) {
    document.querySelectorAll('.theme-item').forEach(item => {
        item.classList.remove('selected');
    });

    element.classList.add('selected');
    document.getElementById('theme-input').value = themeName;
    document.getElementById('themeForm').submit();
}
</script>


@endsection