<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <!-- Sidebar Header -->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
                @if (Auth::check())
                    @if (Str::startsWith(Auth::user()->id_picture, 'http'))
                        <!-- If id_picture is a Google URL -->
                        <img src="{{ Auth::user()->id_picture }}" alt="Profile Picture" class="img-fluid rounded-circle">
                    @else
                        <!-- If id_picture is a local file stored in 'uploads/id_pictures/' -->
                        <img src="{{ asset(Auth::user()->id_picture) }}" alt="Profile Picture"
                            class="img-fluid rounded-circle">
                    @endif
                @else
                    <img src="{{ asset('uploads/default-avatar.jpg') }}" alt="Default Avatar"
                        class="img-fluid rounded-circle">
                @endif
            </div>


            <div class="title">
                @if (Auth::check())
                    <h1 class="h5" style="font-size: 15px; color: #123524;">{{ Auth::user()->name }}</h1>
                @else
                    <h1 class="h5">Guest</h1>
                @endif

                <h6 style="color: #47773f; text-align: center;">Administrator</h6>
            </div>
        </div>

        <!-- Sidebar Navidation Menus-->
        <span class="heading">Main</span>
        <ul class="list-unstyled">

            {{-- DASHBOARD --}}
            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"> <i class="fa fa-bar-chart"
                        style="font-size: 20px; padding-left: 4px;"></i>
                    Dashboard </a>
            </li>

            <li>
                <a href="#Account" aria-expanded="false" data-toggle="collapse">
                    <i class="material-icons" style="font-size: 25px;">account_box</i> Account
                </a>

                <ul id="Account" class="collapse list-unstyled {{ Route::is('admin.accounts') ? 'active' : '' }}">
                    <li><a href="{{ route('accounts') }}"><i class="material-icons"
                                style="font-size: 25px;">group</i>Professor</a></li>
                    <li><a href="{{ route('subjects.index') }}"><i class="fa fa-book"
                                style="font-size: 25px;"></i>Subject</a></li>
                    <li><a href="{{ route('show_admin_accounts') }}"><i class="material-icons"
                                style="font-size: 25px;">perm_identity</i>
                            Admin</a></li>
                    {{-- <li><a href="#">Page</a></li> --}}
                </ul>
            </li>


            {{-- CLASSROOM --}}
            <li>
                <a href="#Classroom" aria-expanded="false" data-toggle="collapse">
                    <i class="fa fa-building" style="font-size: 25px; padding-left: 5px;"></i>Classroom
                </a>
                <ul id="Classroom" class="collapse list-unstyled">
                    <li><a href="{{ route('show_floor') }}"><i class="fa-solid fa-stairs"
                                style="font-size: 25px;"></i>Floor</a></li>
                    <li><a href="{{ route('show_classroom') }}"><i class="fa-solid fa-building"
                                style="font-size: 25px; padding-left: 8px;"></i>Room</a></li>
                    <li><a href="{{ route('show_devices') }}"><i class="material-icons"
                                style="font-size: 25px;">devices_other</i>Device</a>
                    </li>
                    <li><a href="{{ route('show_schedule') }}"><i class="material-icons"
                                style="font-size: 25px;">add_box</i>Schedule</a>
                    </li>
                </ul>
            </li>



            {{-- REPORT --}}
            <li>
                <a href="#Report" aria-expanded="false" data-toggle="collapse">
                    <i class="material-icons" style="font-size: 25px;">folder</i>Report
                </a>
                
                <ul id="Report" class="collapse list-unstyled">
                    <li> <a href="{{ route('report.classroom') }}">
                                 <i class="fa fa-building" style="font-size:font-size: 25px; padding-left: 8px;"></i>Classroom</a>
                    </li>

                    <li><a href="#"><i class="material-icons" style="font-size: 25px;">devices</i>Device</a></li>
                </ul>
            </li>




            {{-- ARCHIVE --}}
            <li>
                <a href="#Archive" aria-expanded="false" data-toggle="collapse">
                    <i class="fa fa-archive" style="font-size: 25px;"></i>Archive
                </a>
                <ul id="Archive" class="collapse list-unstyled">
                    <li><a href="{{ route('show_archive_account') }}"><i class="material-icons"
                                style="font-size: 25px;">account_box</i></i>Account</a></li>

                    <li><a href="{{ route('show_archive_floor') }}"><i class="fa-solid fa-stairs"
                                style="font-size: 25px;"></i>Floor</a></li>
                    <li><a href="{{ route('show_archive_classroom') }}"><i class="fa-solid fa-building"
                                style="font-size: 25px; padding-left: 8px;"></i>Classroom</a></li>
                    <li><a href="{{ route('show_archive_device') }}"><i class="material-icons"
                                style="font-size: 25px;">devices</i>Device</a>
                    </li>

                </ul>
            </li>





            {{-- HOMEPAGE --}}
            <li>
                <a href="#Homepage" aria-expanded="false" data-toggle="collapse">
                    <i class="fa fa-gear" style="font-size: 25px; padding-left: 5px;"></i> Homepage
                </a>
                <ul id="Homepage" class="collapse list-unstyled">
                    <li><a href="{{ route('admin.slider.sliderchanger') }}"><i class="fa fa-file-image-o"
                                style="font-size: 25px; padding-left: 6px;"></i>Slider</a></li>
                    <li><a href="{{ route('admin.feedback.feedbackchanger') }}"><i class="fa fa-comments"
                                style="font-size: 25px;"></i>Feedback</a></li>
                    <li><a href="{{ route('admin.about.index') }}"><i class="fa fa-comments"
                                style="font-size: 25px;"></i>About Us </a></li>
                    <li>
                        <a href="{{ route('admin.footer.index') }}">
                            <i class="fa fa-window-maximize" style="font-size: 25px;"></i> Footer
                        </a>
                    </li>

                </ul>
            </li>





        </ul>

    </nav>
