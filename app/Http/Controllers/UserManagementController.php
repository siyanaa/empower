<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('backend.usermanagement.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // Fetch all available roles
        return view('backend.usermanagement.create', compact('roles'));
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $role = Role::where('name', $validatedData['role'])->first();

        if ($role) {
            $user->assignRole($role);
        }

        return redirect()->route('backend.usermanagement.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('backend.usermanagement.update', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'sometimes|min:8|confirmed',
            'role' => 'nullable|exists:roles,name',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        try {
            $userData = [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ];

            if (isset($validatedData['password'])) {
                $userData['password'] = Hash::make($validatedData['password']);
            }

            $user->update($userData);

            // Update the user's role (only one role)
            if (isset($validatedData['role'])) {
                $role = Role::where('name', $validatedData['role'])->first();
                if ($role) {
                    $user->syncRoles([$role->name]); // Use syncRoles to set a single role
                }
            }

            return redirect()->route('backend.usermanagement.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Handle the exception here, you can log it or return an error message
            return redirect()->back()->with('error', 'An error occurred during the update: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        try {
            // Delete the user
            $user->delete();

            return redirect()->route('backend.usermanagement.index')
                ->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception here, you can log it or return an error message
            return redirect()->route('backend.usermanagement.index')
                ->with('error', 'An error occurred during the delete: ' . $e->getMessage());
        }
    }
}
