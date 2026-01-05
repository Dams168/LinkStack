@extends("layouts.sidebar")

@section("content")

<?php use App\Models\Button;

// Check if the LinkCount cookie is set
if (isset($_COOKIE['LinkCount'])) {
  setcookie('LinkCount', '', time() - 3600);
}

if(!function_exists('strp')){
    function strp($urlStrp){
        return str_replace(array('http://', 'https://'), '', $urlStrp);
    }
}
?>

@push('sidebar-stylesheets')
<script src="{{ asset('assets/external-dependencies/fontawesome.js') }}" crossorigin="anonymous"></script>

@endpush

@include('components.favicon')
@include('components.favicon-extension')

<div class="main-section my-links">

    <div class="main-header">
        <h2 class="main-title">{{__('messages.My Links')}}</h2>
        <span class="main-divider"></span>
    </div>

    <p class="main-desc">Manage your links and set how they appear on your page.</p>

    <div class="my-links-main">
        <div>
            <div class="main-header">
                <h3 class="main-subtitle">{{__('messages.Links')}}</h3>
                <span class="main-divider"></span>
                {{-- <a class="btn btn-primary" href="{{ url('/studio/add-link') }}">
                    <i class="bi bi-plus-lg"></i> {{__('messages.Add new Link')}}
                </a> --}}
            </div>

            @if($links->total() == 0)
            <div class="my-links-content">
                <div class="modal">
                    <i class="modal-icon bi bi-plus-circle-fill"></i>

                    <p class="modal-text">{{__('messages.No Link Added')}} <br> {{__('messages.Add your link
                        now')}}</p>

                    <a href="{{ url('/studio/add-link') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i>
                        {{__('messages.Add Link')}}
                    </a>
                </div>
            </div>
            @endif

            @if($links->total() > 0)
            <div id="links-table-body" data-page="{{request('page', 1)}}" data-per-page="{{$pagePage ? $pagePage : 0}}"
                class="my-links-content">
                @foreach($links as $link)
                @php
                $button = Button::find($link->button_id);
                if(isset($button->name)){
                $buttonName = $button->name;
                }else{
                $buttonName = 0;
                }
                if($buttonName == "default email"){$buttonName = "email";}
                if($buttonName == "default email_alt"){$buttonName = "email_alt";}
                @endphp
                @if($button && $button->name !== 'icon')

                <div class="link-card" data-id="{{$link->id}}">
                    <button class="sortable-handle link-card-grip">
                        <i class="bi bi-grip-vertical"></i>
                    </button>

                    @if($button->name == "custom_website")
                    <img class="link-card-icon" src="@if(file_exists(base_path("
                        assets/favicon/icons/").localIcon($link->id))){{url('assets/favicon/icons/'.localIcon($link->id))}}@else{{getFavIcon($link->id)}}@endif"
                    onerror="this.onerror=null; this.src='{{asset('assets/linkstack/icons/website.svg')}}';"
                    alt="icon">
                    @elseif($button->name == "space")
                    <div class="link-card-icon">
                        <i class='bi bi-distribute-vertical text-gray-500'></i>
                    </div>
                    @elseif($button->name == "heading")
                    <div class="link-card-icon">
                        <i class='bi bi-card-heading text-gray-500'></i>
                    </div>
                    @elseif($button->name == "text")
                    <div class="link-card-icon">
                        <i class='bi bi-fonts text-gray-500'></i>
                    </div>
                    @elseif($link->custom_icon && $link->type && $link->type !== 'predefined')
                    <div class="link-card-icon">
                        <i class='fa {{$link->custom_icon}} text-gray-500'></i>
                    </div>
                    @else
                    <img class="link-card-icon" src="{{ asset('assets/linkstack/icons/' . $buttonName) }}.svg"
                        alt="{{$buttonName}}">
                    @endif

                    <div class="link-card-body">
                        <h4 class="link-card-title">
                            {{strip_tags($link->title)}}
                        </h4>
                        <div class="link-card-content">
                            @if(!empty($link->link) and $button->name != "vcard")
                            <a href="{{ $link->link}}" target="_blank" title="{{ $link->link}}">
                                {{Str::limit($link->link, 75 )}}
                            </a>
                            @elseif(!empty($link->link) and $button->name == "vcard")
                            <a href="{{ url('vcard/'.$link->id) }}" target="_blank">
                                {{__('messages.Download')}}
                            </a>
                            @endif
                        </div>
                    </div>

                    <div class="link-card-info">
                        <div class="link-card-action">
                            @if($link->safety_status === 'warning')
                            <p class="status status-warning">
                                <i class="bi bi-exclamation-triangle"></i> Warning
                            </p>
                            @elseif($link->safety_status === 'safe')
                            <p class="status status-success">
                                <i class="bi bi-check-circle"></i> Valid
                            </p>
                            @endif

                            {{-- @if(env('ENABLE_BUTTON_EDITOR') === true)
                            @if(($link->button_id == '1' || $link->button_id == '2') && $link->type == 'link')
                            <a href="{{ route('editCSS', $link->id ) }}" title="{{__('messages.Customize')}}"
                                class="btn-icon">
                                <i class="bi bi-gear"></i>
                            </a>
                            @endif
                            @endif --}}

                            <a href="{{ route('editLink', $link->id ) }}" class="btn-icon"
                                title="{{__('messages.Edit')}}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="{{ route('deleteLink', $link->id ) }}"
                                onclick="return confirm('{{ __('messages.confirm_delete', ['title' => addslashes($link->title)]) }}')"
                                title="{{__('messages.Delete')}}" class="btn-icon">
                                <i class="bi bi-trash3"></i>
                            </a>

                            <form action="{{ route('toggleEnableLink', $link->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                <input type="checkbox" name="is_enable" value="1" {{ $link->is_enable ? 'checked' :
                                '' }}
                                onchange="this.form.submit()"
                                class="toggle-switch form-control">
                            </form>
                        </div>
                        @if(!empty($link->link))
                        <span class="text-sm text-gray-600"><i class="bi bi-bar-chart"></i> {{ $link->click_number
                            }} {{__('messages.Clicks')}}</span>
                        @endif
                    </div>
                </div>

                @endif
                @endforeach
            </div>

            <ul class="pagination">
                {!! $links->links() !!}
            </ul>

            {{-- @if(count($links) > 3)
            <a class="btn btn-primary mt-4" href="{{ url('/studio/add-link') }}">{{__('messages.Add new Link')}}</a>
            @endif --}}
            @endif



            <a href="{{ url('/studio/add-link') }}" class="btn btn-primary" style="width: 75%; margin: auto">
                Add
                <i class="bi bi-plus-lg"></i>
            </a>
        </div>

        <div>
            <div class="main-header">
                <h3 class="main-subtitle">Preview</h3>
                <span class="main-divider"></span>
            </div>
            <div class="links-preview">
                <iframe allowtransparency="true" id="frPreview"
                    src="{{ url('') }}/@<?= Auth::user()->littlelink_name ?>">
                    {{__('messages.No compatible browser')}}
                </iframe>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/external-dependencies/jquery-1.12.4.min.js') }}"></script>
<script type="text/javascript">
    const linksTableOrders = "{{ implode(' | ', $links->pluck('id')->toArray()) }}"
    
    $("iframe").load(function() { 
        $("iframe").contents().find("a").each(function(index) { 
            $(this).on("click", function(event) { 
                event.preventDefault(); 
                event.stopPropagation(); 
            }); 
        }); 
    });
</script>

@endsection