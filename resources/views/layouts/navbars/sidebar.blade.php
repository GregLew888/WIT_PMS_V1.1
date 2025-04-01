<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
        <!-- <img src="{{asset($siteSetting->company_image_url)}}" alt="Profile Photo" style="
           
            max-width: 70px;
            height: auto;
            margin-left: 0px;
        "> -->
        <img src="{{ asset('white') }}/img/WIT-logo-2024.png" alt="Profile Photo" style="           
           max-width: 100%;
           height: auto;
           margin-left: 0px;
       ">
            <!-- <a href="#" class="simple-text logo-mini">{{ _($siteSetting->short_name) }}</a> -->
            <!-- <a href="#" class="simple-text text-center logo-normal">{{ _($siteSetting->name) }}</a> -->
        </div>
        <ul class="nav">
            <li @if (isset($pageSlug) && $pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>
            <!-- <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Laravel Examples') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li @if (isset($pageSlug) &&  $pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ _('User Profile') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->

    
            <li @if (isset($pageSlug) && $pageSlug == 'holdings') class="active " @endif>
                <a href="{{ route('holdings.index') }}">
                    <i class="tim-icons icon-coins"></i>
                    <p>{{ _('Holdings') }}</p>
                </a>
            </li>
            <li @if (isset($pageSlug) && $pageSlug == 'profile') class="active " @endif>
                <a href="{{ route('profile.edit')  }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ _('User Profile') }}</p>
                </a>
            </li>
            @role('user')
            <li @if (isset($pageSlug) && $pageSlug == 'createTickets') class="active " @endif>
                <a href="{{ route('tickets.create') }}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ _('Generate Ticket') }}</p>
                </a>
            </li>
            <li @if (isset($pageSlug) && $pageSlug == 'tickets') class="active " @endif>
                <a href="{{ route('tickets.index')  }}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ _('Tickets') }}</p>
                </a>
            </li>
            @endrole
            @role('admin')
            <li @if (isset($pageSlug) && $pageSlug == 'users') class="active " @endif>
                <a href="{{ route('users.index') }}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ _('In-Active Clients') }}</p>
                </a>
            </li>
            <li @if (isset($pageSlug) && $pageSlug == 'activeUsers') class="active " @endif>
                <a href="{{ route('users.active.index') }}">
                    <i class="tim-icons icon-satisfied"></i>
                    <p>{{ _('Active Clients') }}</p>
                </a>
            </li>
            <li @if (isset($pageSlug) && $pageSlug == 'settings') class="active " @endif>
                <a href="{{ route('settings')  }}">
                    <i class="tim-icons icon-molecule-40"></i>
                    <p>{{ _('Settings') }}</p>
                </a>
            </li>
            <!-- <li @if (isset($pageSlug) && $pageSlug == 'tickets') class="active " @endif>
                <a href="{{ route('tickets.index')  }}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ _('Tickets') }}</p>
                </a>
            </li> -->
            @endrole
        </ul>
    </div>
</div>
