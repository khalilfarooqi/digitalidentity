<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="<?php echo BASE_URL;?>"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
                class="logo-name">Otika</span>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown <?php echo (false !== strpos($page, 'dashboard') ? 'active' : ''); ?>">
            <a href="<?php echo BASE_URL . 'index.php?page=dashboard' ;?>" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
        </li>
        <li class="dropdown <?php echo (false !== strpos($page, 'hospital') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-toggle nav-link has-dropdown">
                <i data-feather="briefcase"></i><span>Hospitals</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo BASE_URL . 'index.php?page=hospital&s=form' ;?>">Add New</a></li>
                <li><a class="nav-link" href="<?php echo BASE_URL . 'index.php?page=hospital&s=manage' ;?>">Manage</a></li>
            </ul>
        </li>
        <li class="dropdown <?php echo (false !== strpos($page, 'traffic') ? 'active' : ''); ?>">
            <a href="javascript:void(0);" class="menu-toggle nav-link has-dropdown">
                <i data-feather="briefcase"></i><span>Traffic Challance</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="<?php echo BASE_URL . 'index.php?page=traffic&s=form' ;?>">Add New</a></li>
                <li><a class="nav-link" href="<?php echo BASE_URL . 'index.php?page=traffic&s=manage' ;?>">Manage</a></li>
            </ul>
        </li>
    </ul>
</aside>
