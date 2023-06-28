<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
	/**
	 * Display Records
	 *
	 * @return void
	 */
	public function index()
	{
		$breadcrumb = [
			["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
			["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

		];
		populate_breadcrumb($breadcrumb);
		return view('admin.settings.index');
	}

	/**
	 * Update Records
	 *
	 * @param Request $request
	 * @return void
	 */
	public function update(Request $request)
	{
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();

		foreach ($input as $key => $value) {
			if ($key == 'logo') {
				if ($request->hasFile('logo')) {
					$image = '';
					$uploadpath = public_path() . '/images/logo';
					if (!empty($request->file('logo'))) {
						$image_prefix = 'logo_' . rand(0, 999999999) . '_' . date('d_m_Y_h_i_s');
						$ext = $request->file('logo')->getClientOriginalExtension();

						$image = $image_prefix . '.' . $ext;
						$request->file('logo')->move($uploadpath, $image);
					}
					$value = $image;
				} else {
					$value = $request->image_bk;
				}
			}
			Settings::updateOrCreate(['option_name' => $key], [
				'option_name' => $key,
				'option_value' => $value,
			]);
		}
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
	}

	/**
	 * Header Setting
	 *
	 * @return void
	 */
	public function headerSetting()
	{
		$breadcrumb = [
			["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
			["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
		];
		populate_breadcrumb($breadcrumb);
		return view('admin.settings.headerSetting');
	}
	/**
	 * Header Setting Update Records
	 *
	 * @param Request $request
	 * @return void
	 */
	public function headerSettingUpdate(Request $request)
	{
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();
		foreach ($input as $key => $value) {
			Settings::updateOrCreate(['option_name' => $key], [
				'option_name' => $key,
				'option_value' => $value,
			]);
		}
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
	}

	/**
	 * Footer Setting Records
	 *
	 * @return void
	 */
	public function footerSetting()
	{
		$breadcrumb = [
			["name" => "Settings", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
			["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

		];
		populate_breadcrumb($breadcrumb);
		return view('admin.settings.footerSetting');
	}

	/**
	 * Footer Setting
	 *
	 * @param Request $request
	 * @return void
	 */
	public function footerSettingUpdate(Request $request)
	{
		$request->request->remove('_token'); // to remove property from $request
		$input = $request->all();

		foreach ($input as $key => $value) {

			$getData = Settings::updateOrCreate(['option_name' => $key], [
				'option_name' => $key,
				'option_value' => $value,
			]);
		}
		return back()->withInput(array('msg' => 'Setting Updated Successfully'));
	}
}
