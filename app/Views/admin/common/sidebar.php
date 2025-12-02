<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="<?php echo ADMIN_DASHBOARD_LINK; ?>" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="<?php echo ASSETS_DIR_LINK; ?>template/images/logo.png" srcset="<?php echo ASSETS_DIR_LINK; ?>template/images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="<?php echo ASSETS_DIR_LINK; ?>template/images/logo-dark.png" srcset="<?php echo ASSETS_DIR_LINK; ?>template/images/logo-dark2x.png 2x" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-cross"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_DASHBOARD_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_USER_LIST_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Users</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_COIN_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></em></span>
                            <span class="nk-menu-text">Coin Request</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_RELEASE_COIN_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></em></span>
                            <span class="nk-menu-text">Release Coin</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_SETTINGS_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                            <span class="nk-menu-text">Setting</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_CHANGE_PWD_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-lock"></em></span>
                            <span class="nk-menu-text">Change Password</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo ADMIN_LOGOUT_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li>
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->