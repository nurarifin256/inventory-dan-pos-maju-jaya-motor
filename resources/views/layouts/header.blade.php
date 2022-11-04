<div class="shadow-header"></div>
<header class="header-navbar fixed">
    <div class="toggle-mobile action-toggle"><i class="fas fa-bars"></i></div>
    <div class="header-wrapper">
        <div class="header-left">
            <div class="theme-switch-icon"></div>
        </div>

        <div class="header-content">
            <div class="notification dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="far fa-bell"></i>
                    <span class="badge">12</span>
                </a>
                <ul class="dropdown-menu medium">
                    <li class="menu-header">
                        <a class="dropdown-item" href="#">Notification</a>
                    </li>
                    <li class="menu-content ps-menu">
                        <a href="#">
                            <div class="message-icon text-danger">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="message-content read">
                                <div class="body">
                                    There's incoming event, don't miss it!!
                                </div>
                                <div class="time">Just now</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-icon text-info">
                                <i class="fas fa-info"></i>
                            </div>
                            <div class="message-content read">
                                <div class="body">
                                    Your licence will expired soon
                                </div>
                                <div class="time">3 hours ago</div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="message-icon text-success">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="message-content">
                                <div class="body">
                                    Successfully register new user
                                </div>
                                <div class="time">8 hours ago</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropdown dropdown-menu-end">
                <a href="#" class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="label">
                        <span></span>
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <img class="img-user" src="../assets/images/avatar1.png" alt="user" srcset="">
                </a>
                <ul class="dropdown-menu small">
                    <!-- <li class="menu-header">
                                <a class="dropdown-item" href="#">Notifikasi</a>
                            </li> -->
                    <li class="menu-content ps-menu">
                        <a href="#">
                            <div class="description">
                                <i class="ti-user"></i> Profile
                            </div>
                        </a>
                        <a href="#">
                            <div class="description">
                                <i class="ti-settings"></i> Setting
                            </div>
                        </a>
                        <a href="#">
                            <div class="description">
                                <i class="ti-power-off"></i> Logout
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>