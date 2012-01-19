<div class="page-header clearfix">
	<h1 class="pull-left">Pages</h1>
	<div class="pull-right">
		<a href="{{URL::to('admin_pages/add')}}" class="btn success">Add Page</a>
	</div>
</div>
<div class="row">
	<div class="span14">
		@if (count($pages) > 0)
			<table class="table zebra-striped">
				<tr>
					<th>Title</th>
				</tr>
				@foreach ($pages as $page)
					<tr>
						<td>
							<h3><a href="{{URL::to('admin_pages/edit/'.$page->id)}}">{{$page->title}}</a></h3>
						</td>
					</tr>
				@endforeach
			</table>
		@else
			<p>No pages have been added yet.</p>
		@endif
	</div>
</div>

