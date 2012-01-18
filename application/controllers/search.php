<?php

class Search_Controller extends Controller {

	/**
	 * Tell Laravel we want this class restful. See:
	 * http://laravel.com/docs/start/controllers#restful
	 *
	 * @param bool
	 */
	public $restful = true;


	public function get_index()
	{
		$bundles = array();
		$term = '';
		if ($term = strip_tags(Input::get('q')))
		{
			$bundles = Listing::where_active('y')->or_where(function($query)
			{
				$query->where('title', 'LIKE', '%'.$term.'%');
				$query->or_where('summary', 'LIKE', '%'.$term.'%');
				$query->or_where('description', 'LIKE', '%'.$term.'%');
			})
			->paginate(Config::get('application.per_page'));
		}

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'term' => $term,
				'bundles' => $bundles
			));
	}

	/**
	 * Search by a tag
	 *
	 * @param string $tag
	 */
	public function get_tag($item = '')
	{
		// If they didn't give a tag then send them to the advanced search
		if ($item == '')
		{
			return Redirect::to('search');
		}

		$tag = Tag::where_tag($item)->first();
		$model = $tag->bundles();
		// need to reset select clause because eloquent sets select for many to
		// many relationships
		$model->query->selects = null;
		$bundles = $model->where_active('y')->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'tag' => $tag,
				'bundles' => $bundles
			));
	}

	public function get_user($item = '')
	{
		$user = User::where_username($item)->first();

		if ( ! $user)
		{
			return Redirect::to('search');
		}
		$bundles = Listing::where_active('y')->where_user_id($user->id)->paginate(Config::get('application.per_page'));

		return View::make('layouts.default')
			->nest('content', 'category.detail', array(
				'user' => $user,
				'bundles' => $bundles
			));
	}
}