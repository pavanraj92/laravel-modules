<?php

namespace Modules\Setting\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\App\Http\Requests\SettingCreateRequest;
use Modules\Setting\App\Http\Requests\SettingUpdateRequest;
use Modules\Setting\App\Models\Setting;

class SettingManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admincan_permission:settings_manager_list')->only(['index']);
        $this->middleware('admincan_permission:settings_manager_create')->only(['create', 'store']);
        $this->middleware('admincan_permission:settings_manager_edit')->only(['edit', 'update']);
        $this->middleware('admincan_permission:settings_manager_view')->only(['show']);
        // $this->middleware('admincan_permission:settings_manager_delete')->only(['destroy']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $settings = Setting::
                filter($request->query('keyword'))
                ->sortable()
                ->latest()
                ->paginate(Setting::getPerPageLimit())
                ->withQueryString();

            return view('setting::admin.index', compact('settings'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load settings: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('setting::admin.createOrEdit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load settings: ' . $e->getMessage());
        }
    }

    public function store(SettingCreateRequest $request)
    {
        try {
            $requestData = $request->validated();

            Setting::create($requestData);
            return redirect()->route('admin.settings.index')->with('success', 'setting created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load settings: ' . $e->getMessage());
        }
    }

    /**
     * show setting details
     */
    public function show(Setting $setting)
    {
        try {
            return view('setting::admin.show', compact('setting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load settings: ' . $e->getMessage());
        }
    }

    public function edit(Setting $setting)
    {
        try {
            return view('setting::admin.createOrEdit', compact('setting'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load setting for editing: ' . $e->getMessage());
        }
    }

    public function update(SettingUpdateRequest $request, Setting $setting)
    {
        try {
            $requestData = $request->validated();

            $setting->update($requestData);
            return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load setting for editing: ' . $e->getMessage());
        }
    }
}
