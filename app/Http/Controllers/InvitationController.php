<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationController extends Controller {
    public function index() {
        return view('invitations.index');
    }

    public function create() {
        $user = auth()->user();
        $allowedRoles = [];
        
        if ($user->isSuperAdmin()) {
            $allowedRoles = ['member', 'admin'];
        } elseif ($user->role === 'admin') {
            $allowedRoles = ['mamber'];
        }
        
        return view('invitations.create', compact('allowedRoles'));
    }

    public function store(Request $request) {
        $user = auth()->user();
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:member,admin'
        ]);

        // EXACT invitation restrictions
        if (!$user->canInviteRole($request->role)) {
            abort(403, 'You cannot invite this role.');
        }

        // Invitation logic here (email, token, etc.)
        return redirect()->back()->with('success', 'Invitation sent!');
    }
}
