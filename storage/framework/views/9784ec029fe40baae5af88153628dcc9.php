<style nonce="<?php echo e($cspNonce); ?>">
        .csp-admin-header-background{
            background-color:#d3e5e1;
        }
        .csp-admin-header-content{
            background-color:#d3e5e1;
        }
        .csp-admin-span{
            width:40px; height:40px;
        }
        .csp-admin-div-none{
            display: none;
        }


    </style>
<div class="nav-header">
    <a href="#" class="brand-logo">

        <text class="text-dark" id="Job_Admin_Dashboard" data-name="Job Admin Dashboard" transform="translate(134 85)"
            fill="#787878" font-size="12" font-family="Poppins-Light, Poppins" font-weight="300">
            <tspan x="0" y="0">NARTSR</tspan>
        </text>


    </a>
    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>

<div class="header csp-admin-header-background">
    <div class="header-content csp-admin-header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between text-center">
                <div class="header-left">
                    <div class="dashboard_bar">
                        National ART & Surrogacy Portal
                    </div>
                </div>
                <ul class="navbar-nav header-right">

                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-theme-mode p-0" href="javascript:void(0);">
                            <i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>

                        </a>
                    </li>

                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <span class="gap-2"><?php echo e(Session::get('email')); ?></span>&nbsp&nbsp <img src="<?php echo e(url('public/header_images/img.png')); ?>"
                                class="csp-admin-span">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="<?php echo e(route('ssa.ssaprofile')); ?>" class="dropdown-item ai-icon">
                                <svg id="icon-user2" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="10"
                                    height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ms-2">Profile </span>
                            </a>
                            <a href="<?php echo e(route('admin.ssapassword.change')); ?>" class="dropdown-item ai-icon">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <span class="ms-2">Change password</span>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="csp-admin-div-none">
                                <?php echo csrf_field(); ?>
                            </form>
                            
                            <a id="logout-link" href="#" class="dropdown-item ai-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ms-2">Logout</span>
                            </a>
                            
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <script nonce="<?php echo e($cspNonce); ?>">
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    </script>
</div>
<?php /**PATH C:\xampp\htdocs\national_art_souragacy\resources\views/layouts/admin/ssa_header.blade.php ENDPATH**/ ?>