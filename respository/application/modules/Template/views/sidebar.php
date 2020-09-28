<?php 
  $assets_link=base_url('assets/backend'); 
?>
<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo base_url('Dashboard');?>"> <img alt="image" src="<?php echo $assets_link;?>/img/logo.png" class="header-logo" /> <span
        class="logo-name">Digitalidentity</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown active">
      <a href="<?php echo base_url('Dashboard');?>" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
    </li>
  </ul>
</aside>