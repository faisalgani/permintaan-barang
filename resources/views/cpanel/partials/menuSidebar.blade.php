<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('assets/template/adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
          {{ Session::get('first_name') }}
        </a>
      </div>
    </div>
    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				@if(isset($menu) === true)
					<?php 
						$childLevel = 1;
						function listChild($element, $childLevel){
							echo '
							<ul class="nav nav-treeview">';
							foreach ($element as $value) {
                $icon = "nav-icon far fa-circle";
                if($value['icon'] !== "" && $value['icon'] !== null){
                  $icon = "nav-icon ".$value['icon'];
                }

                $iconAngle = '';
                if(count($value['child']) > 0){
                  $iconAngle = '<i class="right fas fa-angle-left"></i>';
                }

                echo '<li class="nav-item">
                <a href="'.$value['link'].'"class="nav-link" >
                <i class="'.$icon.'"></i><p>'.$value['menu'].$iconAngle.'</p></a>';
                if(count($value['child']) > 0){
									listChild($value['child'], $childLevel+=1);
                }
                echo '</li>';
							}

							echo '</ul>
							';
						}

						foreach ($menu as $value) {
              $icon = "nav-icon far fa-circle";
              if($value['icon'] !== "" && $value['icon'] !== null){
                $icon = "nav-icon ".$value['icon'];
              }

              $iconAngle = '';
							if(count($value['child']) > 0){
                $iconAngle = '<i class="right fas fa-angle-left"></i>';
              }

							echo '<li class="nav-item">
							<a href="'.$value['link'].'"class="nav-link" >
							<i class="'.$icon.'"></i><p>'.$value['menu'].$iconAngle.'</p></a>';
							if(count($value['child']) > 0){
								listChild($value['child'], $childLevel);
							}
							echo '</li>';
						}
					?>
				@endif
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>