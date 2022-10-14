<style>
    nav{
       background-color: #dcedff !important;
    }
    .navbar{
        margin-bottom:1px !important ;
    }
</style>



<nav class="navbar navbar-expand-md navbar-light  navbar-laravel " style = "z-index : 1; background-color: #dcedff !important;">

    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {!! config('app.name', trans('titles.app')) !!}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
           
        </button>
        <span class="dashboard-icon"><a href="/home"><i class="fas fa-home" style=' font-size:1.4rem;
        color: black;'></i></a></span>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="navbar-nav mr-auto">
                @role('admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {{--@permission('view.role')--}}
                                <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="{{ route('laravelroles::roles.index') }}">
                                    {!! trans('titles.laravelroles') !!}
                                </a>
                                <div class="dropdown-divider"></div>
                            {{--@endpermission--}}
                            <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}" href="{{ url('/users') }}">
                                {!! trans('titles.adminUserList') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            {{-- <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}" href="{{ url('/users/create') }}">
                                {!! trans('titles.adminNewUser') !!}
                            </a>
                            <div class="dropdown-divider"></div> --}}
                            <a class="dropdown-item {{ Request::is('department') ? 'active' : null }}" href="{{ url('/department') }}">
                                {!! trans('titles.departments') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('location') ? 'active' : null }}" href="{{ url('/location') }}">
                                {!! trans('titles.locations') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('vessel_details') ? 'active' : null }}" href="{{ url('/vessel_details') }}">
                                Vessel Details
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('crew_list') || Request::is('crew_list/create')   ? 'active' : null }}" href="{{ url('/crew_list') }}">
                                Crew List
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('rank') ? 'active' : null }}" href="{{ url('/crew_ranks') }}">
                                {!! trans('titles.ranks') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('rank') ? 'active' : null }}" href="{{ url('/company') }}">
                                {!! trans('titles.company') !!}
                            </a>

                            <!-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('themes','themes/create') ? 'active' : null }}" href="{{ url('/themes') }}">
                                {!! trans('titles.adminThemesList') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                                {!! trans('titles.adminLogs') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}" href="{{ url('/activity') }}">
                                {!! trans('titles.adminActivity') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}" href="{{ url('/phpinfo') }}">
                                {!! trans('titles.adminPHP') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}" href="{{ url('/routes') }}">
                                {!! trans('titles.adminRoutes') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}" href="{{ url('/active-users') }}">
                                {!! trans('titles.activeUsers') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}" href="{{ route('laravelblocker::blocker.index') }}">
                                {!! trans('titles.laravelBlocker') !!}
                            </a> -->
                        </div>

                    </li>

                @endrole
                @if(Auth::user())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reports
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @permission('view.template')
                            @role('admin')
                                <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="/template">
                                    Template
                                </a>
                                <div class="dropdown-divider"></div>
                            @endrole
                        @endpermission
                        
                        @permission('view.riskassessment') 
                            <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="/userRiskAssesment">
                                {!! trans('titles.b18') !!}
                            </a>
                        @endpermission
                        {{-- <div class="dropdown-divider"></div> --}}
                        <a class="dropdown-item ml-3 {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="/hazard-master">
                            {!! trans('titles.hazardMaster') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        @permission('view.nearmiss')
                            <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="{{route('Near_Miss')}}">
                                {!! trans('titles.near_mar') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                        @endpermission
                        @permission('view.incident')
                            <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="{{route('incident_reporting')}}">
                                {!! trans('titles.incident_report') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                        @endpermission
                        @permission('view.audit')
                        <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="/inspection-audit">
                            Inspection & Audits
                        </a>
                        <div class="dropdown-divider"></div>
                        @endpermission
                        @permission('view.moc')
                        <a class="dropdown-item {{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}" href="/moc">
                            Management of Change
                        </a>
                        @endpermission
                        
                    </div>
                </li>
                
                @endif
                
               </li>
            </ul>
            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                {{-- Authentication Links --}}
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}" style="font-weight: 800;">{{ trans('titles.login') }}</a></li>
                    @if (Route::has('register'))
                        <li><a class="nav-link" href="{{ route('register') }}" style="font-weight: 800;">{{ trans('titles.register') }}</a></li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                                <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}" class="user-avatar-nav">
                            @else
                                <div class="user-avatar-nav"></div>
                            @endif
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}" href="{{ url('/profile/'.Auth::user()->name) }}">
                                {!! trans('titles.profile') !!}
                            </a>

                            {{-- vessel Details Navlink --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
            <br>
              
        </div>
    </div>
</nav>
