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
                        <!-- If id_picture is a local upload -->
                        <img src="{{ asset('uploads/' . Auth::user()->id_picture) }}" alt="Profile Picture"
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


            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"> <i class="fa fa-bar-chart"></i> Dashboard </a>
            </li>

            <li>
                <a href="#Account" aria-expanded="false" data-toggle="collapse">
                    <i class="material-icons">account_box</i> Account
                </a>

                <ul id="Account" class="collapse list-unstyled {{ Route::is('admin.accounts') ? 'active' : '' }}">
                    <li><a href="{{ route('accounts') }}"><i class="material-icons">group</i>Professor</a></li>
                    <li><a href="{{ route('subjects.index') }}"><i class="fa fa-book"></i>Subject</a></li>
                    <li><a href="#"><i class="material-icons">perm_identity</i> Admin</a></li>
                    {{-- <li><a href="#">Page</a></li> --}}
                </ul>
            </li>


            <li>
                <a href="#Classroom" aria-expanded="false" data-toggle="collapse">
                    <i class="fa fa-building"></i>Classroom
                </a>
                <ul id="Classroom" class="collapse list-unstyled">
                    <li><a href="{{ route('classroom') }}"><i class="fa fa-eye"></i>Monitor</a></li>
                    <li><a href="#"><i class="material-icons">devices_other</i>Device</a></li>
                    {{-- <li><a href="#"><i class="material-icons">add_box</i>Add</a></li> --}}
                </ul>
            </li>

            <li>
                <a href="#Report" aria-expanded="false" data-toggle="collapse">
                    <i class="material-icons">folder</i>Report
                </a>
                <ul id="Report" class="collapse list-unstyled">
                    <li><a href="#"> <i class="fa fa-file-pdf-o"></i>Classroom</a></li>
                    <li><a href="#"><i class="material-icons">devices</i>Device</a></li>
                    <li><a href="#"><i class="fa fa-archive"></i>Archive</a></li>

                </ul>
            </li>


            <li>
                <a href="#Homepage" aria-expanded="false" data-toggle="collapse">
                    <i class="fa fa-gear"></i> Homepage
                </a>
                <ul id="Homepage" class="collapse list-unstyled">
                    <li><a href="{{ route('admin.slider.sliderchanger') }}"><i
                                class="fa fa-file-image-o"></i>Slider</a></li>
                    <li><a href="{{ route('admin.feedback.feedbackchanger') }}"><i
                                class="fa fa-comments"></i>Feedback</a></li>
                                <li>
    <a href="{{ route('admin.footer.index') }}">
        <i class="fa fa-window-maximize"></i> Footer
    </a>
</li>
                </ul>
            </li>

        </ul>

    </nav>
