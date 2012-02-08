<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{{(isset($title) ? $title.' - ' : '')}}Laravel Bundles</title>
		<meta name="description" content="{{$description}}">
		{{Asset::styles()}}
		<!-- fonts -->
		<link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="{{URL::to_asset('img/favicon.ico')}}">
	</head>
	<body id="{{URI::segment(1, 'home')}}" class="{{URI::segment(2, 'index')}}">

		{{View::make('partials.header')->render()}}

		<div class="container">

			<div class="row">
				<div class="span8">
					<div class="main">
						{{View::make('partials.messages')->render()}}
						{{$content}}
					</div>
				</div>
				<div class="span4">
					<div class="well" style="padding: 8px 0;">
						<ul class="nav nav-list">
							<li class="nav-header">
								Categories
							</li>
						@foreach ($categories as $category)
							@if (isset($selected_cat) AND $selected_cat == $category->id)
							<li class="active"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a></li>
							@else
							<li class="{{Nav::cat('category/'.$category->uri)}}"><a href="{{URL::to('category/'.$category->uri)}}">{{$category->title}}</a>
							</li>
							@endif
						@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>

		{{View::make('partials.footer')->with('categories', $categories)->render()}}

	</body>
</html>