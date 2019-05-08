<? include $_SERVER['DOCUMENT_ROOT']."/header.php";?>
<div class="wrapper">
	<!-- top navbar-->
	<header class="topnavbar-wrapper">
		<!-- START Top Navbar-->
		<nav class="navbar topnavbar">
			<!-- START navbar header-->
			<div class="navbar-header">
				<a class="navbar-brand" href="#/">
					<div class="brand-logo">
						<img class="img-fluid" src="img/logo.png" alt="App Logo">
					</div>
					<div class="brand-logo-collapsed">
						<img class="img-fluid" src="img/logo-single.png" alt="App Logo">
					</div>
				</a>
			</div>
			<!-- END navbar header-->
			<!-- START Left navbar-->
			<ul class="navbar-nav mr-auto flex-row">
				<li class="nav-item">
					<!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
					<a class="nav-link d-none d-md-block d-lg-block d-xl-block"
					href="#" data-trigger-resize="" data-toggle-state="aside-collapsed">
						<em class="fas fa-bars"></em>
				</a> <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
					<a class="nav-link sidebar-toggle d-md-none" href="#"
					data-toggle-state="aside-toggled" data-no-persist="true"> <em
						class="fas fa-bars"></em>
				</a>
				</li>
				<!-- START User avatar toggle-->
				<li class="nav-item d-none d-md-block">
					<!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
					<a class="nav-link" id="user-block-toggle" href="#user-block"
					data-toggle="collapse"> <em class="icon-user"></em>
				</a>
				</li>
				<!-- END User avatar toggle-->
				<!-- START lock screen-->
				<li class="nav-item d-none d-md-block"><a class="nav-link"
					href="lock.html" title="Lock screen"> <em class="icon-lock"></em>
				</a></li>
				<!-- END lock screen-->
			</ul>
			<!-- END Left navbar-->
			<!-- START Right Navbar-->
			<ul class="navbar-nav flex-row">
				<!-- Search icon-->
				<li class="nav-item"><a class="nav-link" href="#"
					data-search-open=""> <em class="icon-magnifier"></em>
				</a></li>
				<!-- Fullscreen (only desktops)-->
				<li class="nav-item d-none d-md-block"><a class="nav-link"
					href="#" data-toggle-fullscreen=""> <em class="fas fa-expand"></em>
				</a></li>
				<!-- START Alert menu-->
				<li class="nav-item dropdown dropdown-list"><a
					class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
					data-toggle="dropdown"> <em class="icon-bell"></em> <span
						class="badge badge-danger">11</span>
				</a> <!-- START Dropdown menu-->
					<div class="dropdown-menu dropdown-menu-right animated flipInX">
						<div class="dropdown-item">
							<!-- START list group-->
							<div class="list-group">
								<!-- list item-->
								<div class="list-group-item list-group-item-action">
									<div class="media">
										<div class="align-self-start mr-2">
											<em class="fab fa-twitter fa-2x text-info"></em>
										</div>
										<div class="media-body">
											<p class="m-0">New followers</p>
											<p class="m-0 text-muted text-sm">1 new follower</p>
										</div>
									</div>
								</div>
								<!-- list item-->
								<div class="list-group-item list-group-item-action">
									<div class="media">
										<div class="align-self-start mr-2">
											<em class="fas fa-envelope fa-2x text-warning"></em>
										</div>
										<div class="media-body">
											<p class="m-0">New e-mails</p>
											<p class="m-0 text-muted text-sm">You have 10 new emails</p>
										</div>
									</div>
								</div>
								<!-- list item-->
								<div class="list-group-item list-group-item-action">
									<div class="media">
										<div class="align-self-start mr-2">
											<em class="fas fa-tasks fa-2x text-success"></em>
										</div>
										<div class="media-body">
											<p class="m-0">Pending Tasks</p>
											<p class="m-0 text-muted text-sm">11 pending task</p>
										</div>
									</div>
								</div>
								<!-- last list item-->
								<div class="list-group-item list-group-item-action">
									<span class="d-flex align-items-center"> <span
										class="text-sm">More notifications</span> <span
										class="badge badge-danger ml-auto">14</span>
									</span>
								</div>
							</div>
							<!-- END list group-->
						</div>
					</div> <!-- END Dropdown menu--></li>
				<!-- END Alert menu-->
				<!-- START Offsidebar button-->
				<li class="nav-item"><a class="nav-link" href="#"
					data-toggle-state="offsidebar-open" data-no-persist="true"> <em
						class="icon-notebook"></em>
				</a></li>
				<!-- END Offsidebar menu-->
			</ul>
			<!-- END Right Navbar-->
			<!-- START Search form-->
			<form class="navbar-form" role="search" action="search.html">
				<div class="form-group">
					<input class="form-control" type="text"
						placeholder="Type and hit enter ...">
					<div class="fas fa-times navbar-form-close" data-search-dismiss=""></div>
				</div>
				<button class="d-none" type="submit">Submit</button>
			</form>
			<!-- END Search form-->
		</nav>
		<!-- END Top Navbar-->
	</header>
	<?include $_SERVER['DOCUMENT_ROOT']."/asside.php"?>

	<section class="section-container">
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">Loading Spinners</div>
            <h4 class="page-header">Loaders.css
               <small class="text-muted">Delightful and performance-focused pure css loading animations.</small>
            </h4>
            <div class="row">
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Pulse</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-pulse">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Grid Pulse</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-grid-pulse">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Clip Rotate</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-clip-rotate">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Clip Rotate Pul</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-clip-rotate-pulse">
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Square Spin</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="square-spin">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Clip Rotate Mul</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-clip-rotate-multiple">
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Pulse Rise</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-pulse-rise">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Rotate</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-rotate">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Cube Transition</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="cube-transition">
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Zig Zag</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-zig-zag">
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Zig Zag Deflect</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-zig-zag-deflect">
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Triangle Path</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-triangle-path">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Scale</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-scale">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Line Scale</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="line-scale">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Line Scale Party</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="line-scale-party">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Scale Multiple</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-scale-multiple">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Pulse Sync</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-pulse-sync">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Beat</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-beat">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Line Scale Pulse Out</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="line-scale-pulse-out">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Line Scale Pulse Out</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="line-scale-pulse-out-rapid">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Scale Ripple</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-scale-ripple">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Scale Ripple Mu</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-scale-ripple-multiple">
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Spin Fade Loade</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-spin-fade-loader">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Line Spin Fade Loade</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="line-spin-fade-loader">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Triangle Skew Spin</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="triangle-skew-spin">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Pacman</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="pacman">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Ball Grid Beat</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="ball-grid-beat">
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">Semi Circle Spin</div>
                     <div class="card-body loader-demo d-flex align-items-center justify-content-center">
                        <div class="semi-circle-spin">
                           <div></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <h4 class="page-header">Spin Kit</h4>
            <div class="row">
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Rotating plane</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-rotating-plane"></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Double bounce</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-double-bounce">
                           <div class="sk-child sk-double-bounce1"></div>
                           <div class="sk-child sk-double-bounce2"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Wave</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-wave">
                           <div class="sk-rect sk-rect1"></div>
                           <div class="sk-rect sk-rect2"></div>
                           <div class="sk-rect sk-rect3"></div>
                           <div class="sk-rect sk-rect4"></div>
                           <div class="sk-rect sk-rect5"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Wandering cubes</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-wandering-cubes">
                           <div class="sk-cube sk-cube1"></div>
                           <div class="sk-cube sk-cube2"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Pulse</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-spinner sk-spinner-pulse"></div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Chasing dots</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-chasing-dots">
                           <div class="sk-child sk-dot1"></div>
                           <div class="sk-child sk-dot2"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Three bounce</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-three-bounce">
                           <div class="sk-child" id="sk-bounce1"></div>
                           <div class="sk-child" id="sk-bounce2"></div>
                           <div class="sk-child" id="sk-bounce3"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Circle</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-circle">
                           <div class="sk-circle1 sk-child"></div>
                           <div class="sk-circle2 sk-child"></div>
                           <div class="sk-circle3 sk-child"></div>
                           <div class="sk-circle4 sk-child"></div>
                           <div class="sk-circle5 sk-child"></div>
                           <div class="sk-circle6 sk-child"></div>
                           <div class="sk-circle7 sk-child"></div>
                           <div class="sk-circle8 sk-child"></div>
                           <div class="sk-circle9 sk-child"></div>
                           <div class="sk-circle10 sk-child"></div>
                           <div class="sk-circle11 sk-child"></div>
                           <div class="sk-circle12 sk-child"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Cube grid</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-cube-grid">
                           <div class="sk-cube sk-cube1"></div>
                           <div class="sk-cube sk-cube2"></div>
                           <div class="sk-cube sk-cube3"></div>
                           <div class="sk-cube sk-cube4"></div>
                           <div class="sk-cube sk-cube5"></div>
                           <div class="sk-cube sk-cube6"></div>
                           <div class="sk-cube sk-cube7"></div>
                           <div class="sk-cube sk-cube8"></div>
                           <div class="sk-cube sk-cube9"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="card card-default">
                     <div class="card-header">
                        <h5>Fading circle</h5>
                     </div>
                     <div class="card-body loader-demo loader-demo-sk d-flex align-items-center justify-content-center">
                        <div class="sk-fading-circle">
                           <div class="sk-circle1 sk-circle"></div>
                           <div class="sk-circle2 sk-circle"></div>
                           <div class="sk-circle3 sk-circle"></div>
                           <div class="sk-circle4 sk-circle"></div>
                           <div class="sk-circle5 sk-circle"></div>
                           <div class="sk-circle6 sk-circle"></div>
                           <div class="sk-circle7 sk-circle"></div>
                           <div class="sk-circle8 sk-circle"></div>
                           <div class="sk-circle9 sk-circle"></div>
                           <div class="sk-circle10 sk-circle"></div>
                           <div class="sk-circle11 sk-circle"></div>
                           <div class="sk-circle12 sk-circle"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <h4 class="page-header">Whirl Loaders
               <small class="text-muted">Based on modern CSS3 animations and ready to be used in Cards</small>
            </h4>
            <!-- START row-->
            <div class="row">
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">standard</div>
                     <div class="card-body whirl standard">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">traditional</div>
                     <div class="card-body whirl traditional">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">double-up</div>
                     <div class="card-body whirl double-up">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">duo</div>
                     <div class="card-body whirl duo">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">blade</div>
                     <div class="card-body whirl blade">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">ringed</div>
                     <div class="card-body whirl ringed">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">helicopter</div>
                     <div class="card-body whirl helicopter">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">line</div>
                     <div class="card-body whirl line">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">line grow</div>
                     <div class="card-body whirl line grow">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">line back-and-forth</div>
                     <div class="card-body whirl line back-and-forth">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">line back-and-forth grow</div>
                     <div class="card-body whirl line back-and-forth grow">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">sphere</div>
                     <div class="card-body whirl sphere">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">sphere vertical</div>
                     <div class="card-body whirl sphere vertical">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">bar</div>
                     <div class="card-body whirl bar">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">bar follow</div>
                     <div class="card-body whirl bar follow">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">shadow</div>
                     <div class="card-body whirl shadow">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">shadow oval</div>
                     <div class="card-body whirl shadow oval">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">shadow oval right</div>
                     <div class="card-body whirl shadow oval right">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
               <div class="col-lg-3">
                  <!-- START card-->
                  <div class="card card-default">
                     <div class="card-header text-truncate">no-overlay</div>
                     <div class="card-body whirl no-overlay">
                        <p>Suspendisse cursus, nisi eu aliquam ultricies, orci augue auctor mi, quis egestas nibh erat vitae justo.</p>
                     </div>
                  </div>
                  <!-- END card-->
               </div>
            </div>
            <!-- END row-->
         </div>
      </section>

	<footer class="footer-container">
		<span>&copy; 2019 - Angle</span>
	</footer>
</div>
<? include $_SERVER['DOCUMENT_ROOT']."/footer.php"?>