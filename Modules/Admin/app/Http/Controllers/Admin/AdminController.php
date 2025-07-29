<?php

namespace Modules\Admin\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\App\Http\Requests\ProfileRequest;
use Modules\Admin\App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Modules\Category\App\Models\Category;
use Modules\Enquiry\Models\Enquiry;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $totalCategories = Category::whereStatus(1)->count();

            $enquiries = Enquiry::all();
            $totalEnquiries = Enquiry::count();
            $totalReply = $enquiries->where('status', 'replied')->count();
            $totalDraft = $enquiries->where('status', 'draft')->count();
            $totalClose = $enquiries->where('status', 'closed')->count();
            $totalNew = $enquiries->where('status', 'new')->count();

            $userRoles = DB::table('user_roles')
                ->leftJoin('users', 'user_roles.id', '=', 'users.role_id')
                ->select('user_roles.name', 'user_roles.slug', DB::raw('COUNT(users.id) as user_count'))
                ->groupBy('user_roles.name', 'user_roles.slug')
                ->get();
            return view('admin::admin.dashboard', compact('totalCategories', 'totalEnquiries', 'totalReply', 'totalDraft', 'totalNew', 'totalClose', 'userRoles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewProfile()
    {
        $admin = \DB::table('admins')->find(auth('admin')->user()->id);
        return view('admin::admin.profile.view', compact('admin'));
    }

    public function profileUpdate(ProfileRequest $request)
    {
        try {
            $admin = auth('admin')->user();

            $admin->first_name   = $request->first_name ?? '';
            $admin->last_name    = $request->last_name ?? '';
            $admin->email        = $request->email ?? '';
            $admin->website_name = $request->website_name ?? '';

            $admin->save();

            return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewChangePassword()
    {
        $admin = \DB::table('admins')->find(auth('admin')->user()->id);
        return view('admin::admin.change_password.view', compact('admin'));
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        try {
            $user = auth('admin')->user();

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function viewpackages()
    {
        try {
            $packages = config('constants.package_display_names');
            return view('admin::admin.packages.view', compact('packages'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
