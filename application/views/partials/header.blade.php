<!-- Navigation -->
<div class="topbar-wrapper" style="z-index: 5;">
	<div class="topbar" data-dropdown="dropdown">
		<div class="topbar-inner">
			<div class="container">
				<h3><a href="#">Laravel Bundles</a></h3>
				<ul class="nav">
					<li class="active"><a href="{{URL::to()}}">Home</a></li>
					<li><a href="{{URL::to('bundle/add')}}">Add Bundle</a></li>
					<li><a href="">What are Bundles?</a></li>
				</ul>
				<form class="pull-left" action="">
					<input type="text" placeholder="Search Bundles">
				</form>
				<ul class="nav secondary-nav">
					@if (Auth::check())
					<li class="menu">
						<a class="menu" href="{{URL::to('user/profile')}}">Hello {{Auth::user()->name}}</a>
						<ul class="menu-dropdown">
							<li><a href="{{URL::to('user/bundles')}}">Your Bundles</a></li>
							<li><a href="#">Another Link</a></li>
							<li class="divider"></li>
							<li><a href="{{URL::to('user/logout')}}">Logout</a></li>
						</ul>
					</li>
					@else
					<li class="login">
						<a class="btn primary" href="<?php echo URL::to('user/login'); ?>">Login With GitHub</a>
					</li>
					@endif
				</ul>
			</div>
		</div><!-- /topbar-inner -->
	</div><!-- /topbar -->
</div>
<!-- End Navigation -->