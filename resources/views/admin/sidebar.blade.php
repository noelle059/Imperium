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
           
           
            <li class="active">
                <a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i> Dashboard </a>
            </li>

            <li>
                <a href="#Account" aria-expanded="false" data-toggle="collapse">
                    <i class="icon-windows"></i>Account
                </a>
                <ul id="Account" class="collapse list-unstyled">
                    <li><a href="{{ route('accounts') }}"><i class="icon-grid"></i> Professor</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Admin</a></li>
                    {{-- <li><a href="#">Page</a></li> --}}
                </ul>
            </li>


            <li>
                <a href="#Classroom" aria-expanded="false" data-toggle="collapse">
                    <i class="icon-windows"></i>Classroom
                </a>
                <ul id="Classroom" class="collapse list-unstyled">
                    <li><a href="{{ route('classroom') }}"><i class="icon-grid"></i> Monitor</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Device</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Add</a></li>
                </ul>
            </li>
           
          
            <li>
                <a href="#Report" aria-expanded="false" data-toggle="collapse">
                    <i class="icon-windows"></i>Report
                </a>
                <ul id="Report" class="collapse list-unstyled">
                    <li><a href="#"><i class="icon-grid"></i> Classroom</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Device</a></li>
                    
                </ul>
            </li>


            <li>
                <a href="#Homepage" aria-expanded="false" data-toggle="collapse">
                    <i class="icon-windows"></i>Homepage
                </a>
                <ul id="Homepage" class="collapse list-unstyled">
                    <li><a href="#"><i class="icon-grid"></i> Slider</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Feedback</a></li>
                    <li><a href="#"><i class="icon-grid"></i> Footer</a></li>
                </ul>
            </li>
           
           
          

           
        </ul>


{{--         
        <span class="heading">Extras</span>
        <ul class="list-unstyled">
            <li>
                <a href="#"> <i class="icon-settings"></i>Demo </a>
            </li>
            <li>
                <a href="#"> <i class="icon-writing-whiteboard"></i>Demo </a>
            </li>
            <li>
                <a href="#"> <i class="icon-chart"></i>Demo </a>
            </li>
        </ul> --}}
    </nav>
    <!-- Sidebar Navigation end-->


   