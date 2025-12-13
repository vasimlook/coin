<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head bg-dark">
        <div class="nk-sidebar-brand">
            <a class="nk-profile-toggle border-0" href="<?php echo BASE_URL; ?>">                
                <div class="user-card">
                    <div class="user-avatar bg-primary">
                        <span>
                            <img src="<?php echo ASSETS_FOLDER; ?>template/images/avatar/<?php echo $_SESSION['user']['profile_img_no']; ?>.png" alt="<?php echo $_SESSION['user']['profile_img_no']; ?>">
                        </span>
                    </div>
                    <div class="user-info">
                        <span class="lead-text text-white"><?php echo $_SESSION['user']['name']; ?></span>
                        <span class="sub-text text-white">Mo:<?php echo $_SESSION['user']['phone']; ?></span>
                    </div>                            
                </div>
            </a>
        </div>
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none text-white" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex text-white" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>            
                <ul class="nk-menu">                    
                    <li class="nk-menu-item">
                        <a href="<?php echo USER_DASHBOARD_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                            <span class="nk-menu-text">Home</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo UPDATE_BANK_DETAILS_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon text-orange-tbg"><em class="icon ni ni-money"></em></span>
                            <span class="nk-menu-text text-light-skyblue-tbg">Update Bank Details</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo USER_CHANGE_PWD_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-lock"></em></span>
                            <span class="nk-menu-text">Change Password</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="<?php echo USER_LOGOUT_LINK; ?>" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-power"></em></span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li>
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->