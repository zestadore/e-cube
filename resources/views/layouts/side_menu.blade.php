<aside class="sidebar sidebar-default sidebar-white sidebar-base navs-pill navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="Javascript:void(0);" class="navbar-brand">
            <!--Logo start-->
            <img src="{{ asset('admin_assets/images/logo/logo.png') }}" class="img-fluid" alt="E-Cube Logo">
            <!--logo End-->
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : (Auth::user()->role == 'employee' ? route('employee.dashboard') : route('employer.dashboard')) }}">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Dashboard</span>
                    </a>
                </li>
                @can('isAdmin')
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/users*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#horizontal-menu-users" role="button" aria-expanded="false" aria-controls="horizontal-menu">
                            <i class="icon">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                    <path opacity="0.4" d="M9.15257 21.5584C9.15257 21.5584 9.15257 21.5584 9.15257 21.5584C6.19502 21.5584 3.80029 19.1637 3.80029 16.2061V15.2717C3.80029 14.3844 4.46589 13.6046 5.34602 13.5053C6.81876 13.3379 8.53702 13.1779 9.15257 13.1779C9.76812 13.1779 11.4864 13.3379 12.9591 13.5053C13.8392 13.6046 14.5048 14.3844 14.5048 15.2717V16.2061C14.5048 19.1637 12.1101 21.5584 9.15257 21.5584Z" fill="currentColor"></path>
                                    <path opacity="0.4" d="M19.7601 18.1617V16.232C19.7601 15.6506 19.3853 15.1384 18.8359 14.9991C17.8506 14.7443 16.7816 14.5574 16.1486 14.5574C15.5156 14.5574 14.4465 14.7443 13.4613 14.9991C12.9119 15.1384 12.5371 15.6506 12.5371 16.232V18.1617C12.5371 20.2005 14.2039 21.8674 16.1486 21.8674C18.0932 21.8674 19.7601 20.2005 19.7601 18.1617Z" fill="currentColor"></path>
                                    <path d="M9.15261 11.4977C11.1889 11.4977 12.8379 9.84873 12.8379 7.81243C12.8379 5.77613 11.1889 4.12717 9.15261 4.12717C7.11631 4.12717 5.46735 5.77613 5.46735 7.81243C5.46735 9.84873 7.11631 11.4977 9.15261 11.4977Z" fill="currentColor"></path>
                                    <path d="M16.1486 13.0475C17.6392 13.0475 18.8476 11.8391 18.8476 10.3485C18.8476 8.85789 17.6392 7.64947 16.1486 7.64947C14.658 7.64947 13.4496 8.85789 13.4496 10.3485C13.4496 11.8391 14.658 13.0475 16.1486 13.0475Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Users</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="horizontal-menu-users" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/users'))? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/industry*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#horizontal-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
                            <i class="icon">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                    <path opacity="0.4" d="M2 7.5C2 6.43913 2.42143 5.42172 3.17157 4.67157C3.92172 3.92143 4.93913 3.5 6 3.5H10.5C11.5609 3.5 12.5783 3.92143 13.3284 4.67157C14.0786 5.42172 14.5 6.43913 14.5 7.5V12C14.5 13.0609 14.0786 14.0783 13.3284 14.8284C12.5783 15.5786 11.5609 16 10.5 16H6C4.93913 16 3.92172 15.5786 3.17157 14.8284C2.42143 14.0783 2 13.0609 2 12V7.5Z" fill="currentColor"></path>
                                    <path d="M17.5 8C17.5 7.17157 18.1716 6.5 19 6.5H21C21.8284 6.5 22.5 7.17157 22.5 8V20C22.5 20.8284 21.8284 21.5 21 21.5H9C8.17157 21.5 7.5 20.8284 7.5 20V18C7.5 17.1716 8.17157 16.5 9 16.5H15C15.8284 16.5 16.5 15.8284 16.5 15V9C16.5 8.17157 16.9142 8 17.5 8Z" fill="currentColor"></path>
                                    <path d="M6 6.5C5.17157 6.5 4.5 7.17157 4.5 8C4.5 8.82843 5.17157 9.5 6 9.5H9C9.82843 9.5 10.5 8.82843 10.5 8C10.5 7.17157 9.82843 6.5 9 6.5H6Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Industry/Roles</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="horizontal-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/industry'))? 'active' : '' }}" href="{{ route('admin.industry.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/industry/create'))? 'active' : '' }}" href="{{ route('admin.industry.create') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> C </i>
                                    <span class="item-name"> Create </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/qualification*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#qualification-menu" role="button" aria-expanded="false" aria-controls="qualification-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M12 2.5C10.0109 2.5 8.10322 3.29018 6.6967 4.6967C5.29018 6.10322 4.5 8.01088 4.5 10V16.25C4.5 17.2446 4.89509 18.1984 5.59835 18.9016C6.30161 19.6049 7.25544 20 8.25 20H8.5C9.05228 20 9.5 19.5523 9.5 19V15C9.5 14.4477 9.05228 14 8.5 14H8.25C7.836 14 7.5 13.664 7.5 13.25V10C7.5 8.80653 7.97411 7.66193 8.81802 6.81802C9.66193 5.97411 10.8065 5.5 12 5.5C13.1935 5.5 14.3381 5.97411 15.182 6.81802C16.0259 7.66193 16.5 8.80653 16.5 10V13.25C16.5 13.664 16.164 14 15.75 14H15.5C14.9477 14 14.5 14.4477 14.5 15V19C14.5 19.5523 14.9477 20 15.5 20H15.75C16.7446 20 17.6984 19.6049 18.4016 18.9016C19.1049 18.1984 19.5 17.2446 19.5 16.25V10C19.5 8.01088 18.7098 6.10322 17.3033 4.6967C15.8968 3.29018 13.9891 2.5 12 2.5Z" fill="currentColor"></path>
                                    <path d="M10.5 21.5H13.5C14.0523 21.5 14.5 21.0523 14.5 20.5V15.5C14.5 14.9477 14.0523 14.5 13.5 14.5H10.5C9.94772 14.5 9.5 14.9477 9.5 15.5V20.5C9.5 21.0523 9.94772 21.5 10.5 21.5Z" fill="currentColor"></path>
                                    <path d="M12 2.5V5.5C10.8065 5.5 9.66193 5.97411 8.81802 6.81802C7.97411 7.66193 7.5 8.80653 7.5 10H4.5C4.5 8.01088 5.29018 6.10322 6.6967 4.6967C8.10322 3.29018 10.0109 2.5 12 2.5Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Qualifications</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="qualification-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/qualification'))? 'active' : '' }}" href="{{ route('admin.qualification.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/computer-and-other-skill*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#skills-menu" role="button" aria-expanded="false" aria-controls="skills-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M3 6C3 4.34315 4.34315 3 6 3H18C19.6569 3 21 4.34315 21 6V14C21 15.6569 19.6569 17 18 17H6C4.34315 17 3 15.6569 3 14V6Z" fill="currentColor"></path>
                                    <path d="M6.5 20C6.5 19.4477 6.94772 19 7.5 19H16.5C17.0523 19 17.5 19.4477 17.5 20C17.5 20.5523 17.0523 21 16.5 21H7.5C6.94772 21 6.5 20.5523 6.5 20Z" fill="currentColor"></path>
                                    <path d="M8 7C8 6.44772 8.44772 6 9 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H9C8.44772 8 8 7.55228 8 7Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Computer/Other Skills</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="skills-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/computer-and-other-skill'))? 'active' : '' }}" href="{{ route('admin.computer-and-other-skill.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/background-question*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#question-menu" role="button" aria-expanded="false" aria-controls="question-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor"></path>
                                    <path d="M12 17.75C12.4142 17.75 12.75 17.4142 12.75 17C12.75 16.5858 12.4142 16.25 12 16.25C11.5858 16.25 11.25 16.5858 11.25 17C11.25 17.4142 11.5858 17.75 12 17.75Z" fill="currentColor"></path>
                                    <path d="M12 14.5C12.5523 14.5 13 14.0523 13 13.5V13C13 12.1716 13.6716 11.5 14.5 11.5C15.8807 11.5 17 10.3807 17 9C17 7.61929 15.8807 6.5 14.5 6.5H12C10.3431 6.5 9 7.84315 9 9.5C9 10.0523 9.44772 10.5 10 10.5C10.5523 10.5 11 10.0523 11 9.5C11 8.94772 11.4477 8.5 12 8.5H14.5C14.7761 8.5 15 8.72386 15 9C15 9.27614 14.7761 9.5 14.5 9.5C12.567 9.5 11 11.067 11 13V13.5C11 14.0523 11.4477 14.5 12 14.5Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Background Questions</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="question-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/background-question'))? 'active' : '' }}" href="{{ route('admin.background-question.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/subscription-packages*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#package-menu" role="button" aria-expanded="false" aria-controls="question-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M20 7L14.5 2.5C13.6716 1.67157 12.404 1.17157 11 1.17157H7C5.34315 1.17157 4 2.51472 4 4.17157V8.17157C4 9.82843 5.34315 11.1716 7 11.1716H10.5C11.8807 11.1716 13 10.0523 13 8.67157V7.17157C13 6.61929 13.4477 6.17157 14 6.17157H17C17.5523 6.17157 18 6.61929 18 7.17157V9.17157C18 9.72386 17.5523 10.1716 17 10.1716H12L12 22H20C21.1046 22 22 21.1046 22 20V9C22 8.17157 21.1716 7 20 7Z" fill="currentColor"></path>
                                    <path d="M7 13C5.34315 13 4 14.3431 4 16V20C4 21.6569 5.34315 23 7 23C8.65685 23 10 21.6569 10 20V16C10 14.3431 8.65685 13 7 13Z" fill="currentColor"></path>
                                    <path d="M10.5 6.5H7C6.44772 6.5 6 6.94772 6 7.5C6 8.05228 6.44772 8.5 7 8.5H10.5C11.0523 8.5 11.5 8.05228 11.5 7.5C11.5 6.94772 11.0523 6.5 10.5 6.5Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Subscription Packages</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="package-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/subscription-packages'))? 'active' : '' }}" href="{{ route('admin.subscription-packages.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/payment-methods*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#payment-method-menu" role="button" aria-expanded="false" aria-controls="payment-method-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M2 8C2 6.34315 3.34315 5 5 5H19C20.6569 5 22 6.34315 22 8V16C22 17.6569 20.6569 19 19 19H5C3.34315 19 2 17.6569 2 16V8Z" fill="currentColor"></path>
                                    <path d="M2 10C2 9.44772 2.44772 9 3 9H21C21.5523 9 22 9.44772 22 10C22 10.5523 21.5523 11 21 11H3C2.44772 11 2 10.5523 2 10Z" fill="currentColor"></path>
                                    <path d="M6 15C6 14.4477 6.44772 14 7 14H9C9.55228 14 10 14.4477 10 15C10 15.5523 9.55228 16 9 16H7C6.44772 16 6 15.5523 6 15Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Payment Methods</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="payment-method-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/payment-methods'))? 'active' : '' }}" href="{{ route('admin.payment-methods.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/payment-history'))? 'active' : '' }}" aria-current="page" href="{{ route('admin.payment-history') }}">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7V17C22 18.6569 20.6569 20 19 20H5C3.34315 20 2 18.6569 2 17V7Z" fill="currentColor"></path>
                                    <path d="M12 11C12.5523 11 13 11.4477 13 12V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V12C11 11.4477 11.4477 11 12 11Z" fill="currentColor"></path>
                                    <path d="M8 8C8.55228 8 9 8.44772 9 9V16C9 16.5523 8.55228 17 8 17C7.44772 17 7 16.5523 7 16V9C7 8.44772 7.44772 8 8 8Z" fill="currentColor"></path>
                                    <path d="M16 14C16.5523 14 17 14.4477 17 15V16C17 16.5523 16.5523 17 16 17C15.4477 17 15 16.5523 15 16V15C15 14.4477 15.4477 14 16 14Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Payment History</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/sliders*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#slider-menu" role="button" aria-expanded="false" aria-controls="slider-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M2 6C2 4.34315 3.34315 3 5 3H19C20.6569 3 22 4.34315 22 6V18C22 19.6569 20.6569 21 19 21H5C3.34315 21 2 19.6569 2 18V6Z" fill="currentColor"></path>
                                    <path d="M7 9C7 8.44772 7.44772 8 8 8H16C16.5523 8 17 8.44772 17 9V15C17 15.5523 16.5523 16 16 16H8C7.44772 16 7 15.5523 7 15V9Z" fill="currentColor"></path>
                                    <path d="M5 6C5 5.44772 5.44772 5 6 5H7C7.55228 5 8 5.44772 8 6C8 6.55228 7.55228 7 7 7H6C5.44772 7 5 6.55228 5 6Z" fill="currentColor"></path>
                                    <path d="M17 18C17 18.5523 17.4477 19 18 19H19C19.5523 19 20 18.5523 20 18C20 17.4477 19.5523 17 19 17H18C17.4477 17 17 17.4477 17 18Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Sliders</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="slider-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/sliders'))? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/events*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#event-menu" role="button" aria-expanded="false" aria-controls="event-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M2 9C2 7.34315 3.34315 6 5 6H19C20.6569 6 22 7.34315 22 9V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V9Z" fill="currentColor"></path>
                                    <path d="M5 4C5 3.44772 5.44772 3 6 3H7C7.55228 3 8 3.44772 8 4V6H5V4Z" fill="currentColor"></path>
                                    <path d="M16 4C16 3.44772 16.4477 3 17 3H18C18.5523 3 19 3.44772 19 4V6H16V4Z" fill="currentColor"></path>
                                    <path d="M2 10C2 9.44772 2.44772 9 3 9H21C21.5523 9 22 9.44772 22 10C22 10.5523 21.5523 11 21 11H3C2.44772 11 2 10.5523 2 10Z" fill="currentColor"></path>
                                    <path d="M7 14C7 13.4477 7.44772 13 8 13H16C16.5523 13 17 13.4477 17 14C17 14.5523 16.5523 15 16 15H8C7.44772 15 7 14.5523 7 14Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Events</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="event-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/events'))? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('admin/reviews*'))? 'collapsed' : '' }}" data-bs-toggle="collapse" href="#review-menu" role="button" aria-expanded="false" aria-controls="review-menu">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M12 17C16.4183 17 20 13.4183 20 9C20 4.58172 16.4183 1 12 1C7.58172 1 4 4.58172 4 9C4 13.4183 7.58172 17 12 17Z" fill="currentColor"></path>
                                    <path d="M12 14L13.5 17H10.5L12 14Z" fill="currentColor"></path>
                                    <path d="M12 4C12.5523 4 13 4.44772 13 5V9C13 9.55228 12.5523 10 12 10C11.4477 10 11 9.55228 11 9V5C11 4.44772 11.4477 4 12 4Z" fill="currentColor"></path>
                                    <path d="M22 19V20C22 21.6569 20.6569 23 19 23H5C3.34315 23 2 21.6569 2 20V19C2 17.3431 3.34315 16 5 16H19C20.6569 16 22 17.3431 22 19Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Reviews</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="review-menu" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/reviews'))? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
                                    <i class="icon">
                                        <svg class="icon-10" xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                                            <g>
                                            <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </i>
                                    <i class="sidenav-mini-icon"> L </i>
                                    <span class="item-name"> List </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('isEmployee')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('employee/background-questions') ? 'active' : '' }}" aria-current="page" href="{{ route('employee.background-questions') }}">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor"></path>
                                    <path d="M12 17.75C12.4142 17.75 12.75 17.4142 12.75 17C12.75 16.5858 12.4142 16.25 12 16.25C11.5858 16.25 11.25 16.5858 11.25 17C11.25 17.4142 11.5858 17.75 12 17.75Z" fill="currentColor"></path>
                                    <path d="M12 14.5C12.5523 14.5 13 14.0523 13 13.5V13C13 12.1716 13.6716 11.5 14.5 11.5C15.8807 11.5 17 10.3807 17 9C17 7.61929 15.8807 6.5 14.5 6.5H12C10.3431 6.5 9 7.84315 9 9.5C9 10.0523 9.44772 10.5 10 10.5C10.5523 10.5 11 10.0523 11 9.5C11 8.94772 11.4477 8.5 12 8.5H14.5C14.7761 8.5 15 8.72386 15 9C15 9.27614 14.7761 9.5 14.5 9.5C12.567 9.5 11 11.067 11 13V13.5C11 14.0523 11.4477 14.5 12 14.5Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Background Questions</span>
                        </a>
                    </li>
                @endcan
                @can('isEmployer')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('employer/company-profile') ? 'active' : '' }}" aria-current="page" href="{{ route('employer.company_profile') }}">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M12 2L2 7V9H22V7L12 2Z" fill="currentColor"></path>
                                    <path d="M4 10V19C4 20.1046 4.89543 21 6 21H9V14H15V21H18C19.1046 21 20 20.1046 20 19V10H4Z" fill="currentColor"></path>
                                    <path d="M9 16H11V21H9V16Z" fill="currentColor"></path>
                                    <path d="M13 16H15V21H13V16Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Company Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('employer/payment-history'))? 'active' : '' }}" aria-current="page" href="{{ route('employer.payment-history') }}">
                            <i class="icon">
                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M2 7C2 5.34315 3.34315 4 5 4H19C20.6569 4 22 5.34315 22 7V17C22 18.6569 20.6569 20 19 20H5C3.34315 20 2 18.6569 2 17V7Z" fill="currentColor"></path>
                                    <path d="M12 11C12.5523 11 13 11.4477 13 12V16C13 16.5523 12.5523 17 12 17C11.4477 17 11 16.5523 11 16V12C11 11.4477 11.4477 11 12 11Z" fill="currentColor"></path>
                                    <path d="M8 8C8.55228 8 9 8.44772 9 9V16C9 16.5523 8.55228 17 8 17C7.44772 17 7 16.5523 7 16V9C7 8.44772 7.44772 8 8 8Z" fill="currentColor"></path>
                                    <path d="M16 14C16.5523 14 17 14.4477 17 15V16C17 16.5523 16.5523 17 16 17C15.4477 17 15 16.5523 15 16V15C15 14.4477 15.4477 14 16 14Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Payment History</span>
                        </a>
                    </li>
                @endcan
            </ul>
            <!-- Sidebar Menu End -->        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>