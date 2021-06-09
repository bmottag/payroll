<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<?php
		if($topMenu){
		echo $topMenu;
		}
		?>
		<li class="nav-item">
			<a class="nav-link" data-widget="fullscreen" href="#" role="button">
				<i class="fas fa-expand-arrows-alt"></i>
			</a>
		</li>
	</ul>
</nav>
<!-- /.navbar -->


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
	<a href="index3.html" class="brand-link">
		<img src="<?php echo base_url("assets/bootstrap/dist/img/AdminLTELogo.png"); ?>" alt="LOGO" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">PayRoll</span>
    </a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<?php 
				if($this->session->photo){
					$urlPhoto = base_url($this->session->name);
				}else{
					$urlPhoto = base_url("images/avatar.png");
				} 
				?>
				<img src="<?php echo $urlPhoto; ?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block"><?php echo $this->session->name; ?></a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="pages/widgets.html" class="nav-link">
						<i class="nav-icon fas fa-th"></i>
						<p>Time Stamp</p>
					</a>
				</li>

				<li class="nav-item">
				<a href="#" class="nav-link">
				<i class="nav-icon fas fa-chart-pie"></i>
				<p>
				Charts
				<i class="right fas fa-angle-left"></i>
				</p>
				</a>
				<ul class="nav nav-treeview">
				<li class="nav-item">
				<a href="pages/charts/chartjs.html" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>ChartJS</p>
				</a>
				</li>
				<li class="nav-item">
				<a href="pages/charts/flot.html" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>Flot</p>
				</a>
				</li>
				<li class="nav-item">
				<a href="pages/charts/inline.html" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>Inline</p>
				</a>
				</li>
				<li class="nav-item">
				<a href="pages/charts/uplot.html" class="nav-link">
				<i class="far fa-circle nav-icon"></i>
				<p>uPlot</p>
				</a>
				</li>
				</ul>
				</li>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>