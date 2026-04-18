<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display admin dashboard.
     */
    public function index()
    {
        $usersCount = User::count();
        $adminsCount = User::where('role', 'admin')->count();
        $regularUsersCount = User::where('role', 'user')->count();

        return view('admin.dashboard', [
            'usersCount' => $usersCount,
            'adminsCount' => $adminsCount,
            'regularUsersCount' => $regularUsersCount,
        ]);
    }

    /**
     * Display list of all users.
     */
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Promote user to admin.
     */
    public function promoteToAdmin(User $user)
    {
        $user->update(['role' => 'admin']);
        return redirect()->route('admin.users')->with('success', 'User promoted to admin');
    }

    /**
     * Demote admin to user.
     */
    public function demoteToUser(User $user)
    {
        $user->update(['role' => 'user']);
        return redirect()->route('admin.users')->with('success', 'Admin demoted to user');
    }
}
