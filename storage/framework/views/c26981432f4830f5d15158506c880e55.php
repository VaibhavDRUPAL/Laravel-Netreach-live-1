<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  d-flex  align-items-center">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>" data-toggle="tooltip"
                data-original-title="<?php echo e(setting('company_name')); ?>">
                <?php if(setting('company_logo')): ?>
                    <img alt="<?php echo e(setting('company_name')); ?>" height="45" class="navbar-brand-img"
                        src="<?php echo e(asset('assets/img/web/logo.png')); ?>">
                <?php else: ?>
                    <?php echo e(substr(setting('company_name'), 0, 15)); ?>...
                <?php endif; ?>
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
                        <a class="nav-link <?php echo e(request()->is('home*') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-settings')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('settings*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('settings.index')); ?>">
                                <i class="ni ni-settings-gear-65 text-primary"></i>
                                <span class="nav-link-text">Manage Settings</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-category', 'create-category'])): ?>
                        <!--<li class="nav-item">                                                                                                                                                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-category')): ?>
        <li class="nav-item">                                                                                                                                                                                                                                                                         </li>
        <?php endif; ?>                                                                                                                                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-category')): ?>
        <li class="nav-item">                                                                                                                                                                                                                                                                         </li>
    <?php endif; ?>                                                                                                                         </li>--->
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-post', 'create-post'])): ?>
                        <!--<li class="nav-item">                                                                                                      <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-post')): ?>
        <li class="nav-item">                                                                                                                                                                                                                                                                               </li>
        <?php endif; ?>                                                                                                                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-post')): ?>
        <li class="nav-item">                                                                                                                                                                                                                                                                               </li>
    <?php endif; ?>                                                                                                                                         </li>-->
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_survey', 'm-e-user-views', 'm-e-user-download'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('survey*') ? 'active' : ''); ?>" href="#navbar-survey"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage Survey</span>
                            </a>
                            <div class="collapse" id="navbar-survey">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view_survey', 'm-e-user-views', 'm-e-user-download'])): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('survey.displaysecond')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Survey</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po-apporve-reject-data')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('survey.po.display')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">PO
                                                    Survey</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('credit-permission')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('survey.credit')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Credit
                                                    Survey</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-announcement', 'create-announcement'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('announcement*') ? 'active' : ''); ?>" href="#navbar-announcement"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-announcement">
                                <i class="fas text-primary fa-tasks"></i>
                                <span class="nav-link-text">Manage Announcement</span>
                            </a>
                            <div class="collapse" id="navbar-announcement">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-announcement')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('announcements.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Announcement</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-announcement')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('announcements.create')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New
                                                    Announcement</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                     <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-doctor', 'create-doctor'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('doctor*') ? 'active' : ''); ?>" href="#navbar-doctor"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-doctor">
                                <i class="fas text-primary fa-tasks"></i>
                                <span class="nav-link-text">Manage doctor</span>
                            </a>
                            <div class="collapse" id="navbar-doctor">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-doctor')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('doctors.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    doctor</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-doctor')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('doctors.create')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New
                                                    doctor</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-district', 'view-centre'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('district*') ? 'active' : ''); ?>" href="#navbar-district"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-district">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage Centre/State/District</span>
                            </a>
                            <div class="collapse" id="navbar-district">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-district')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('state.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    State</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('district.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    District</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-centre')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('all.centre.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Centre</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-user', 'create-user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('users*') ? 'active' : ''); ?>" href="#navbar-users"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-tasks"></i>
                                <span class="nav-link-text">Manage Users</span>
                            </a>
                            <div class="collapse" id="navbar-users">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('users.index')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    Users</span></a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-user')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('users.create')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">Add New
                                                    User</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['create-vm', 'update-vm', 'view-vm'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('users*') ? 'active' : ''); ?>" href="#navbar-users-vm"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage PO/CO/VN</span>
                            </a>
                            <div class="collapse" id="navbar-users-vm">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-vm')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('user.vms')); ?>" class="nav-link"><span
                                                    class="sidenav-mini-icon">D </span><span class="sidenav-normal">All
                                                    PO/CO/VN</span></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-permission', 'create-permission'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('permissions*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('permissions.index')); ?>">
                                <i class="fas fa-lock-open text-primary"></i>
                                <span class="nav-link-text">Manage Permissions</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['e-shilp-permission'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('eslip*') ? 'active' : ''); ?>" href="#navbar-e-slip"
                                data-toggle="collapse" role="button" aria-expanded="true"
                                aria-controls="navbar-e-slip">
                                <i class="fas text-primary fa-heart"></i>
                                <span class="nav-link-text">Manage E-Slip</span>
                            </a>












                            <div class="collapse" id="navbar-e-slip">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('survey.eslip.new')); ?>">
                                            <span class="sidenav-mini-icon">D </span>
                                            <span class="sidenav-normal">Manage E-Silp New</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo e(route('survey.eslip')); ?>">
                                            <span class="sidenav-mini-icon">D </span>
                                            <span class="sidenav-normal">Manage E-Silp Old</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </li>













                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['create-app-platform'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('platform*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('platform.index')); ?>">
                                <i class="fas fa-lock-open text-primary"></i>
                                <span class="nav-link-text">Manage Platform</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-role', 'create-role'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('roles*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('roles.index')); ?>">
                                <i class="fas fa-lock text-primary"></i>
                                <span class="nav-link-text">Manage Roles</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['create-vn-link-genrate'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('genrate*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('genrate.index')); ?>">
                                <i class="fas fa-images text-primary"></i>
                                <span class="nav-link-text">Manage Generate Link</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('manually*') ? 'active' : ''); ?>"
                                href="/?vncode=<?php echo e(md5(Auth::user()->id)); ?>" target="_blank">
                                <i class="fas fa-images text-primary"></i>
                                <span class="nav-link-text"> Manually Create Appoinments</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view-activity-log'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('activity-log*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('activity-log.index')); ?>">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Activity Log</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manual-dashboard')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('manually-dashboard*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('outreach.manually.dashboard')); ?>">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Manually Dashboard</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(!App::isProduction()): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['Center-user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->is('center-appointments*') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('center-appointments')); ?>">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="nav-link-text">Center Appointments</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['web-center-user'])): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request()->is('web-center-appointments*') ? 'active' : ''); ?>"
                                    href="<?php echo e(route('web-center-appointments')); ?>">
                                    <i class="fas fa-history text-primary"></i>
                                    <span class="nav-link-text">Web Center Appointments</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['admin-notification'])): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('admin-notification*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('admin-notification')); ?>">
                                <i class="fas fa-history text-primary"></i>
                                <span class="nav-link-text">Admin Notification</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-outreach')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('outreach*') ? 'active' : ''); ?>" href="#navbar-outreach"
                                data-toggle="collapse" role="button" aria-expanded="true"
                                aria-controls="navbar-outreach">
                                <i class="fas text-primary fa-hand-holding-heart"></i>
                                <span class="nav-link-text">Outreach</span>
                            </a>
                            <div class="collapse" id="navbar-outreach">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('outreach.profile.index')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span
                                                class="sidenav-normal">Profile</span></a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('outreach.referral-service.index')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span class="sidenav-normal">Referral
                                                and Services</span></a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('outreach.plhiv.index')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon">D </span><span class="sidenav-normal">PLHIV
                                                Tests</span></a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('language*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('language.all')); ?>">
                            <i class="fas fa-language text-primary"></i>
                            <span class="nav-link-text">Language</span>
                        </a>
                    </li>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-chatbot')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('users*') ? 'active' : ''); ?>" href="#chatbot-nav"
                                data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Chatbot</span>
                            </a>
                            <div class="collapse" id="chatbot-nav">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.greetings.all')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Greetings</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.questionnaire.all')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Questionnaire</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.users.all')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Users</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.language.counter')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Language
                                                Counter</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.visitor.all')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Anonymous
                                                Visitors</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('chatbot.content.all')); ?>" class="nav-link"><span
                                                class="sidenav-mini-icon"></span><span class="sidenav-normal">Other
                                                Content</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-blog')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#blog-nav" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Blogs</span>
                            </a>
                            <div class="collapse" id="blog-nav">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request()->is('blog_categories_all') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('blog_categories_all')); ?>">
                                            <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Blog
                                                Categories</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo e(request()->is('blogs_all') ? 'active' : ''); ?>"
                                            href="<?php echo e(route('blogs_all')); ?>">
                                            <span class="sidenav-mini-icon"></span><span
                                                class="sidenav-normal">Blogs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('self-risk-assessment-tool')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#self-risk-assessment" data-toggle="collapse" role="button"
                                aria-expanded="true" aria-controls="navbar-users">
                                <i class="fas text-primary fa-comment"></i>
                                <span class="nav-link-text">Self-Risk Assessment</span>
                            </a>
                            <div class="collapse" id="self-risk-assessment">
                                <ul class="nav nav-sm flex-column">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-sra-questionnaire')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e(request()->is('self-risk-assessment*') ? 'active' : ''); ?>"
                                                href="<?php echo e(route('admin.self-risk-assessment.questionnaire')); ?>">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Questionnaire</span></a>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-risk-assessments')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e(request()->is('self-risk-assessment*') ? 'active' : ''); ?>"
                                                href="<?php echo e(route('admin.self-risk-assessment.index')); ?>">
                                                <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Risk
                                                    Assessments</span></a>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-sra-appointments')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e(request()->is('self-risk-assessment*') ? 'active' : ''); ?>"
                                                href="<?php echo e(route('admin.self-risk-assessment.appointment')); ?>">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Appointments</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-sra-analytics')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e(request()->is('self-risk-assessment*') ? 'active' : ''); ?>"
                                                href="<?php echo e(route('admin.self-risk-assessment.analytics')); ?>">
                                                <span class="sidenav-mini-icon"></span><span
                                                    class="sidenav-normal">Analytics</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-combine-list')): ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo e(request()->is('self-risk-assessment*') ? 'active' : ''); ?>"
                                                href="<?php echo e(route('admin.self-risk-assessment.combine')); ?>">
                                                <span class="sidenav-mini-icon"></span><span class="sidenav-normal">Master
                                                    Line List</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request()->is('calendar*') ? 'active' : ''); ?>"
                            href="<?php echo e(route('calendar')); ?>">
                            <i class="fas fa-calendar text-primary"></i>
                            <span class="nav-link-text">Calendar</span>
                        </a>
                    </li>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('meet-counsellor')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('meet*') ? 'active' : ''); ?>"
                                href="<?php echo e(route('admin.meet-counsellor.index')); ?>">
                                <i class="far fa-handshake text-primary"></i>
                                <span class="nav-link-text">Meet Counsellor</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <hr class="my-3">
                    </li>
                    <!--<li class="nav-item">
                            <a class="nav-link active active-pro" href="<?php echo e(route('components')); ?>">
                                <i class="ni ni-send text-primary"></i>
                                <span class="nav-link-text">Components</span>
                            </a>
                        </li>-->
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/includes/navbar.blade.php ENDPATH**/ ?>