<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="{{ route('home') }}" data-toggle="tooltip"
                data-original-title="{{ setting('company_name') }}">
                @if (setting('company_logo'))
                    <img alt="{{ setting('company_name') }}" height="45" class="navbar-brand-img"
                        src="{{ asset('assets/img/web/logo.png') }}">
                @else
                    {{ substr(setting('company_name'), 0, 15) }}...
                @endif
            </a>
            <div class=" ml-auto ">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block active" data-action="sidenav-unpin"
                    data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home*') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    @can('update-settings')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}"
                                href="{{ route('settings.index') }}">
                                <i class="ni ni-settings-gear-65 text-primary"></i>
                                <span class="nav-link-text">Manage Settings</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['view-category', 'create-category'])
                        <!--<li class="nav-item">                                                                                                                                                     @can('view-category')
        <li class="nav-item">                                                                                                                                                                                                                                                                         </li>
        @endcan                                                                                                                                                      @can('create-category')
        <li class="nav-item">                                                                                                                                                                                                                                                                         </li>
    @endcan                                                                                                                         </li>--->
                    @endcan
                    @canany(['view-post', 'create-post'])
                        <!--<li class="nav-item">                                                                                                      @can('view-post')
        <li class="nav-item">                                                                                                                                                                                                                                                                               </li>
        @endcan                                                                                                                                                    @can('create-post')
        <li class="nav-item">                                                                                                                                                                                                                                                                               </li>
    @endcan                                                                                                                                         </li>-->
                    @endcan
                    @canany(['view_survey', 'm-e-user-views', 'm-e-user-download'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('survey*') ? 'active' : '' }}" href="#navbar-survey"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage Survey</span>
                            </a>
                            <div class="collapse" id="navbar-survey">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['view_survey', 'm-e-user-views', 'm-e-user-download'])
                                        <li class="nav-item">
                                            <a href="{{ route('survey.displaysecond') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Survey</span></a>
                                        </li>
                                    @endcan
                                    @can('po-apporve-reject-data')
                                        <li class="nav-item">
                                            <a href="{{ route('survey.po.display') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">PO
                                                    Survey</span></a>
                                        </li>
                                    @endcan
                                    @can('credit-permission')
                                        <li class="nav-item">
                                            <a href="{{ route('survey.credit') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Credit
                                                    Survey</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @canany(['view-district', 'view-centre'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('district*') ? 'active' : '' }}" href="#navbar-district"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-district">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage Centre/State/District</span>
                            </a>
                            <div class="collapse" id="navbar-district">
                                <ul class="nav nav-sm flex-column">
                                    @can('view-district')
                                        <li class="nav-item">
                                            <a href="{{ route('state.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    State</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('district.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    District</span></a>
                                        </li>
                                    @endcan
                                    @can('view-centre')
                                        <li class="nav-item">
                                            <a href="{{ route('all.centre.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Centre</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @canany(['view-user', 'create-user'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="#navbar-users"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-tasks"></i>
                                <span class="nav-link-text">Manage Users</span>
                            </a>
                            <div class="collapse" id="navbar-users">
                                <ul class="nav nav-sm flex-column">
                                    @can('view-user')
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Users</span></a>
                                        </li>
                                    @endcan
                                    @can('create-user')
                                        <li class="nav-item">
                                            <a href="{{ route('users.create') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New
                                                    User</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @canany(['create-vm', 'update-vm', 'view-vm'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="#navbar-users-vm"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage PO/CO/VN</span>
                            </a>
                            <div class="collapse" id="navbar-users-vm">
                                <ul class="nav nav-sm flex-column">
                                    @can('view-vm')
                                        <li class="nav-item">
                                            <a href="{{ route('user.vms') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    PO/CO/VN</span></a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @canany(['view-permission', 'create-permission'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('permissions*') ? 'active' : '' }}"
                                href="{{ route('permissions.index') }}">
                                <i class="fas fa-lock-open text-primary"></i>
                                <span class="nav-link-text">Manage Permissions</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['e-shilp-permission'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('eslip*') ? 'active' : '' }}" href="#navbar-e-slip"
                                data-toggle="collapse" role="button" aria-expanded="true"
                                aria-controls="navbar-e-slip">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage E-Slip</span>
                            </a>












                            <div class="collapse" id="navbar-e-slip">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('survey.eslip.new') }}">
                                            <span class="sidenav-mini-icon">D </span>
                                            <span class="sidenav-normal">Manage E-Silp New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('survey.eslip') }}">
                                            <span class="sidenav-mini-icon">D </span>
                                            <span class="sidenav-normal">Manage E-Silp Old</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>













                    @endcan
                    @canany(['create-app-platform'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('platform*') ? 'active' : '' }}"
                                href="{{ route('platform.index') }}">
                                <i class="fas fa-lock-open text-primary"></i>
                                <span class="nav-link-text">Manage Platform</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['view-role', 'create-role'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}"
                                href="{{ route('roles.index') }}">
                                <i class="fas fa-lock text-primary"></i>
                                <span class="nav-link-text">Manage Roles</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['create-vn-link-genrate'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('genrate*') ? 'active' : '' }}"
                                href="{{ route('genrate.index') }}">
                                <i class="fas fa-images text-primary"></i>
                                <span class="nav-link-text">Manage Generate Link</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manually*') ? 'active' : '' }}"
                                href="/?vncode={{ md5(Auth::user()->id) }}" target="_blank">
                                <i class="fas fa-images text-primary"></i>
                                <span class="nav-link-text"> Manually Create Appoinments</span>
                            </a>
                        </li>
                    @endcan
                    @canany(['view-activity-log'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('activity-log*') ? 'active' : '' }}"
                                href="{{ route('activity-log.index') }}">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Activity Log</span>
                            </a>
                        </li>
                    @endcan
                    @can('manual-dashboard')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('manually-dashboard*') ? 'active' : '' }}"
                                href="{{ route('outreach.manually.dashboard') }}">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Manually Dashboard</span>
                            </a>
                        </li>
                    @endcan
                    @if (!App::isProduction())
                        @canany(['Center-user'])
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('center-appointments*') ? 'active' : '' }}"
                                    href="{{ route('center-appointments') }}">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="nav-link-text">Center Appointments</span>
                                </a>
                            </li>
                        @endcan
                        @canany(['web-center-user'])
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('web-center-appointments*') ? 'active' : '' }}"
                                    href="{{ route('web-center-appointments') }}">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="nav-link-text">Web Center Appointments</span>
                                </a>
                            </li>
                        @endcan
                    @endif
                    @canany(['admin-notification'])
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin-notification*') ? 'active' : '' }}"
                                href="{{ route('admin-notification') }}">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Admin Notification</span>
                            </a>
                        </li>
                    @endcan
                    {{-- @if (!App::isProduction()) --}}
                    @can('manage-outreach')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('outreach*') ? 'active' : '' }}" href="#navbar-outreach"
                                data-toggle="collapse" role="button" aria-expanded="true"
                                aria-controls="navbar-outreach">
                                <i class="fas text-primary fa-hand-holding-heart"></i>
                                <span class="nav-link-text">Outreach</span>
                            </a>
                            <div class="collapse" id="navbar-outreach">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('outreach.profile.index') }}" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span
                                                class="sidenav-normal">Profile</span></a>
                                    </li>
                                    {{-- <li class="nav-item">
                                            <a href="{{ route('outreach.risk-assessment.index') }}"
                                                class="nav-link"><span class="sidenav-mini-icon">D </span><span
                                                    class="sidenav-normal">Risk Assessment</span></a>
                                        </li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route('outreach.referral-service.index') }}" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span class="sidenav-normal">Referral
                                                and Services</span></a>
                                    </li>
                                    {{-- <li class="nav-item">
                                            <a href="{{ route('outreach.counselling.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span
                                                    class="sidenav-normal">Counselling Services</span></a>
                                        </li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route('outreach.plhiv.index') }}" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span class="sidenav-normal">PLHIV
                                                Tests</span></a>
                                    </li>
                                    {{-- <li class="nav-item">
                                            <a href="{{ route('outreach.sti.index') }}" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span
                                                    class="sidenav-normal">STI</span></a>
                                        </li> --}}
                                </ul>
                            </div>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('language*') ? 'active' : '' }}"
                            href="{{ route('language.all') }}">
                            <i class="fas fa-language text-primary"></i>
                            <span class="nav-link-text">Language</span>
                        </a>
                    </li>
                    {{-- @endif --}}
                    @can('manage-chatbot')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="#chatbot-nav"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Chatbot</span>
                            </a>
                            <div class="collapse" id="chatbot-nav">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.greetings.all') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Greetings</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.questionnaire.all') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Questionnaire</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.users.all') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Users</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.language.counter') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Language
                                                Counter</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.visitor.all') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Anonymous
                                                Visitors</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('chatbot.content.all') }}" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Other
                                                Content</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('manage-blog')
                        <li class="nav-item">
                            <a class="nav-link" href="#blog-nav" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Blogs</span>
                            </a>
                            <div class="collapse" id="blog-nav">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('blog_categories_all') ? 'active' : '' }}"
                                            href="{{ route('blog_categories_all') }}">
                                            <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Blog
                                                Categories</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->is('blogs_all') ? 'active' : '' }}"
                                            href="{{ route('blogs_all') }}">
                                            <span class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Blogs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endcan
                    @can('self-risk-assessment-tool')
                        <li class="nav-item">
                            <a class="nav-link" href="#self-risk-assessment" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Self-Risk Assessment</span>
                            </a>
                            <div class="collapse" id="self-risk-assessment">
                                <ul class="nav nav-sm flex-column">
                                    @can('view-sra-questionnaire')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('self-risk-assessment*') ? 'active' : '' }}"
                                                href="{{ route('admin.self-risk-assessment.questionnaire') }}">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Questionnaire</span></a>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-risk-assessments')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('self-risk-assessment*') ? 'active' : '' }}"
                                                href="{{ route('admin.self-risk-assessment.index') }}">
                                                <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Risk
                                                    Assessments</span></a>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-sra-appointments')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('self-risk-assessment*') ? 'active' : '' }}"
                                                href="{{ route('admin.self-risk-assessment.appointment') }}">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Appointments</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-sra-analytics')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('self-risk-assessment*') ? 'active' : '' }}"
                                                href="{{ route('admin.self-risk-assessment.analytics') }}">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Analytics</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('view-combine-list')
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->is('self-risk-assessment*') ? 'active' : '' }}"
                                                href="{{ route('admin.self-risk-assessment.combine') }}">
                                                <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Master
                                                    Line List</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('calendar*') ? 'active' : '' }}"
                            href="{{ route('calendar') }}">
                            <i class="fas fa-calendar text-primary"></i>
                            <span class="nav-link-text">Calendar</span>
                        </a>
                    </li>

                    @can('meet-counsellor')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('meet*') ? 'active' : '' }}"
                                href="{{ route('admin.meet-counsellor.index') }}">
                                <i class="far fa-handshake text-primary"></i>
                                <span class="nav-link-text">Meet Counsellor</span>
                            </a>
                        </li>
                    @endcan

                    <li class="nav-item">
                        <hr class="my-3">
                    </li>
                    <!--<li class="nav-item">
                            <a class="nav-link active active-pro" href="{{ route('components') }}">
                                <i class="ni ni-send text-primary"></i>
                                <span class="nav-link-text">Components</span>
                            </a>
                        </li>-->
                </ul>
            </div>
        </div>
    </div>
</nav>
