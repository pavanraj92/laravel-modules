<?php

namespace Modules\AdminManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\AdminManager\App\Http\Requests\AdminCreateRequest;
use Modules\AdminManager\App\Http\Requests\AdminUpdateRequest;
use Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\AdminManager\App\Mail\WelcomeAdminMail;

class AdminManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $admins = Admin::
                where('id', '!=', 1)
                ->filter($request->query('keyword'))
                ->filterByStatus($request->query('status'))
                ->latest()
                ->paginate(5)
                ->withQueryString();

            return view('adminmanager::admin.index', compact('admins'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admins: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            return view('adminmanager::admin.createOrEdit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admins: ' . $e->getMessage());
        }
    }

    public function store(AdminCreateRequest $request)
    {
        try {
            $requestData = $request->validated();

            $plainPassword = \Str::random(8);
            $requestData['password'] = Hash::make($plainPassword);
    
            // Create admin
            $admin = Admin::create($requestData);
    
            // Send welcome mail
            Mail::to($admin->email)->send(new WelcomeAdminMail($admin, $plainPassword));
            return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admins: ' . $e->getMessage());
        }
    }

    /**
     * show admin details
     */
    public function show(Admin $admin)
    {
        try {
            return view('adminmanager::admin.show', compact('admin'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admins: ' . $e->getMessage());
        }
    }

    public function edit(Admin $admin)
    {
        try {
            return view('adminmanager::admin.createOrEdit', compact('admin'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admin for editing: ' . $e->getMessage());
        }
    }

    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        try {
            $requestData = $request->validated();

            $admin->update($requestData);
            return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load admin for editing: ' . $e->getMessage());
        }
    }

    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $admin = Admin::findOrFail($request->id);
            $admin->status = $request->status;
            $admin->save();

            // create status html dynamically        
            $dataStatus = $admin->status == '1' ? '0' : '1';
            $label = $admin->status == '1' ? 'Active' : 'InActive';
            $btnClass = $admin->status == '1' ? 'btn-success' : 'btn-warning';
            $tooltip = $admin->status == '1' ? 'Click to change status to inactive' : 'Click to change status to active';

            $strHtml = '<a href="javascript:void(0)"'
                . ' data-toggle="tooltip"'
                . ' data-placement="top"'
                . ' title="' . $tooltip . '"'
                . ' data-url="' . route('admin.admins.updateStatus') . '"'
                . ' data-method="POST"'
                . ' data-status="' . $dataStatus . '"'
                . ' data-id="' . $admin->id . '"'
                . ' class="btn ' . $btnClass . ' btn-sm update-status">' . $label . '</a>';

            return response()->json(['success' => true, 'message' => 'Status updated to '.$label, 'strHtml' => $strHtml]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete record.', 'error' => $e->getMessage()], 500);
        }
    }
}
