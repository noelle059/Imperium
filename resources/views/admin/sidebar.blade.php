<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <div class="avatar">
                <img src="/images/avatar-6.jpg" alt="..." class="img-fluid rounded-circle" />
            </div>
            <div class="title">
                <h1 class="h5">Vincent Davac</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus-->
        <span class="heading">Main</span>
        <ul class="list-unstyled">
           
           
            <li class="{{ (Route::is('admin.dashboard')) ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"> <i class="fa fa-bar-chart"></i> Dashboard </a>
            </li>

            <li>
                <a href="#Account" aria-expanded="false" data-toggle="collapse">
                    <i class="material-icons">account_box</i> Account
                </a>

                <ul id="Account" class="collapse list-unstyled {{ (Route::is('admin.accounts')) ? 'active' : '' }}">
                    <li><a  href="{{ route('accounts') }}"><i class="material-icons">group</i>Professor</a></li>
                    <li><a href="#"><i class="fa fa-book"></i>Subject</a></li>
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
                    <li><a href="#"><i class="material-icons">add_box</i>Add</a></li>
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
                    <li><a href="#"><i class="fa fa-file-image-o"></i>Slider</a></li>
                    <li><a href="#"><i class="fa fa-comments"></i>Feedback</a></li>
                    <li><a href="#"><i class="fa fa-window-maximize"></i>Footer</a></li>
                </ul>
            </li>
             
        </ul>

    </nav>



    


   