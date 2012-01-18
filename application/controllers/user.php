<?php

class User_Controller extends Controller {

	public function action_index()
	{
		return View::make('layouts.default')
			->nest('content', 'user.login', array());
	}

	/**
	 * User Login
	 *
	 * This handles the oauth request with the provider
	 *
	 * @param string $provider
	 * @return void
	 */
	public function action_login($provider = 'github')
	{
		Bundle::start('laravel-oauth2');

		// @todo - Move these to config.
		$provider = OAuth2::provider($provider, array(
			'id' => Config::get('github.id'),
			'secret' => Config::get('github.secret'),
		));

		if ( ! isset($_GET['code']))
		{
			return $provider->authorize();
		}
		else
		{
			// After we have the access token we need to store it so we can make api calls later.
			try
			{
				$params = $provider->access($_GET['code']);
				$github_user = $provider->get_user_info($params);

				// Save or update the user data
				if ($existing = User::where('username', '=', $github_user['nickname'])->first())
				{
					$existing->name = $github_user['name'];
					$existing->email = $github_user['email'];
					$existing->ip_address = Request::ip();
					$existing->github_uid = $github_user['uid'];
					$existing->github_token = Crypter::encrypt($params->access_token);
					$existing->save();
				}
				else
				{
					$user = new User;
					$user->username = $github_user['nickname'];
					$user->name = $github_user['name'];
					$user->email = $github_user['email'];
					$user->ip_address = Request::ip();
					$user->github_uid = $github_user['uid'];
					$user->github_token = Crypter::encrypt($params->access_token);
					$user->save();
				}

				if (Auth::attempt($github_user['nickname'], $params->access_token))
				{
					return Redirect::to('/');
				}
			}
			catch (Exception $e)
			{
				// I am hiding the exception and will just redirect with a message
				return Redirect::to('/');
			}
		}
	}

	public function action_bundles()
	{
		$bundles = Listing::where_user_id(Auth::user()->id)->paginate(Config::get('application.per_page'));
		return View::make('layouts.default')
			->nest('content', 'user.listings', array(
				'category' => $category,
				'bundles' => $bundles
			));
	}

	public function action_logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}