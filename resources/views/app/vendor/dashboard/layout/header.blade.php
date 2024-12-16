<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo -->
        <div class="logo-mini text-center">
{{--            <h3 class="font-weight-bold text-light text-center">راسته فرش</h3>--}}
            <span class="light-logo"><img src="{{ asset('admin-asset/images/logo-light.png') }}" alt="logo"></span>
            <span class="dark-logo"><img src="{{ asset('admin-asset/images/logo-dark.png') }}" alt="logo"></span>
        </div>
        <!-- logo-->
        <div class="logo-lg">
            <span class="light-logo"><img src="{{ asset('admin-asset/images/logo-light-text.png') }}" alt="logo"></span>
            <span class="dark-logo"><img src="{{ asset('admin-asset/images/logo-dark-text.png') }}" alt="logo"></span>
        </div>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav d-flex justify-content-around">

                <li class="search-box">
                    <a class="nav-link hidden-sm-down" href="javascript:void(0)"><i class="mdi mdi-magnify"></i></a>
                    <form class="app-search" style="display: none;">
                        <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
                <!-- User Account-->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('admin-asset/images/avatar/7.jpg') }}" class="user-image rounded-circle" alt="User Image">
                    </a>
                    <ul class="dropdown-menu animated flipInY">

                        <!-- User image -->
                        <li class="user-header bg-img" style="background-image: url({{ asset('admin-asset/images/user-info.jpg') }})" data-overlay="3">
                            <div class="flexbox align-self-center">
                                <img src="{{ asset('admin-asset/images/avatar/7.jpg') }}" class="float-left rounded-circle" alt="User Image">
                                <span class="user-name align-self-center">
                                    <span>
                                        @auth()
                                            {{ auth()->user()->full_name ?? auth()->user()->email }}
                                        @endauth
                                        @guest()
                                                <a href="{{ route('vendor.auth-form') }}" class="btn btn-xs btn-primary">ورود به حساب کاربری</a>
                                        @endguest
                                    </span>

                                </span>
                            </div>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-person"></i> پروفایل من</a>
{{--                            <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-email-unread"></i> Inbox</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="javascript:void(0)"><i class="ion ion-settings"></i> Account Setting</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
                            <a class="dropdown-item" href="{{ route('customer.logout') }}"><i class="fa fa-power-off"></i> خروج</a>
                            <div class="dropdown-divider"></div>
                        </li>
                    </ul>
                </li>


                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle comments-dropdown-toggle" id="comments-dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-comments"></i>
                        <span id="comment-badge" class="badge badge-danger badge-sm badge-pill">5</span>

                    </a>
                    <ul class="dropdown-menu animated fadeInDown">

                        <li class="header">
                            <div class="bg-img text-white p-20" style="background-image: url({{ asset('admin-asset/images/user-info.jpg') }})" data-overlay="5">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">5 نظر جدید</h4>
{{--                                        <span class="font-light">Messages</span>--}}
                                    </div>
                                    <div class="font-size-40">
                                        <i class="mdi mdi-comment-alert"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">

                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="{{ asset('admin-asset/images/user2-160x160.jpg') }}" class="rounded-circle" alt="User Image">
                                            </div>
                                            <div class="mail-contnet">
                                                <h4>
                                                    <small><i class="fa fa-clock-o"></i>22 شهریور 1402</small>
                                                </h4>
                                                <span>متن تستی</span>
                                            </div>
                                        </a>
                                    </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#" class="text-white bg-info">مشاهده همه نظرات</a></li>
                    </ul>
                </li>


                <!-- Messages -->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" id="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bell"></i>
                        <span id="notification-badge" class="badge badge-danger badge-sm badge-pill">4</span>

                    </a>
                    <ul class="dropdown-menu animated fadeInDown">
                        <li class="header">
                            <div class="bg-img text-white p-20" style="background-image: url({{ asset('admin-asset/images/user-info.jpg') }})" data-overlay="5">
                                <div class="flexbox">
                                    <div>
                                        <h4 class="mb-0 mt-0">اطلاعیه جدید</h4>
                                    </div>
                                    <div class="font-size-40">
                                        <i class="fa fa-bell-o"></i>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">
                                    <li><!-- start message -->
                                        <a href="#" title="مشاهده" class="d-flex flex-col flex-wrap">
                                            <div class="mail-contnet">
                                                <span class="card">
                                                    <span class="detail">جزئیات</span>
                                                </span>
                                            </div>
                                            <span class="text-left"><small class="text-muted">22 اسفند 1402</small></span>
                                        </a>
                                    </li>

                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#" class="text-white bg-info">مشاهده همه اعلانات</a></li>
                    </ul>
                </li>
                <!-- Notifications -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bell"></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInDown">

                        <li class="header">
                            <div class="bg-img text-white p-20" style="background-image: url({{ asset('admin-asset/images/user-info.jpg') }})" data-overlay="5">
                                <div class="flexbox">
                                    <div>
                                        <h3 class="mb-0 mt-0">7 New</h3>
                                        <span class="font-light">Notifications</span>
                                    </div>
                                    <div class="font-size-40">
                                        <i class="mdi mdi-message-alert"></i>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-info"></i> Curabitur id eros quis nunc suscipit blandit.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-warning"></i> Duis malesuada justo eu sapien elementum, in semper diam posuere.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-danger"></i> Donec at nisi sit amet tortor commodo porttitor pretium a erat.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-success"></i> In gravida mauris et nisi
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-danger"></i> Praesent eu lacus in libero dictum fermentum.
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-primary"></i> Nunc fringilla lorem
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-success"></i> Nullam euismod dolor ut quam interdum, at scelerisque ipsum imperdiet.
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#" class="text-white bg-danger">View all</a></li>
                    </ul>
                </li>
                <!-- Tasks-->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bulletin-board"></i>
                    </a>
                    <ul class="dropdown-menu animated fadeInDown">

                        <li class="header">
                            <div class="bg-img text-white p-20" style="background-image: url({{ asset('admin-asset/images/user-info.jpg') }})" data-overlay="5">
                                <div class="flexbox">
                                    <div>
                                        <h3 class="mb-0 mt-0">6 New</h3>
                                        <span class="font-light">Tasks</span>
                                    </div>
                                    <div class="font-size-40">
                                        <i class="mdi mdi-bulletin-board"></i>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu sm-scrol">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Lorem ipsum dolor sit amet
                                            <small class="pull-right">30%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-danger" style="width: 30%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">30% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Vestibulum nec ligula
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-info" style="width: 20%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Donec id leo ut ipsum
                                            <small class="pull-right">70%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-success" style="width: 70%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">70% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Praesent vitae tellus
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-warning" style="width: 40%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Nam varius sapien
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-primary" style="width: 80%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Nunc fringilla
                                            <small class="pull-right">90%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-info" style="width: 90%" role="progressbar"
                                                 aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">90% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer"><a href="#" class="text-white bg-warning">View all tasks</a></li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
{{--                <li>--}}
{{--                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </nav>
</header>
