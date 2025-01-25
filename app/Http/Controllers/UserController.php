<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            User::create([
                'name' => $request->name,
                'npp' => $request->npp,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'department' => $request->department,
            ]);
        });
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'npp' => 'required|numeric|unique:users,npp,' . $user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:UK,Pegawai',
            'department' => 'required|in:PMU,YANFASKES,YANSER,KEPSER,PKP,SDMUK',
        ]);
        
        DB::transaction(function () use ($request, $user) {
            $user->update([
                'name' => $request->name,
                'npp' => $request->npp,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
                'department' => $request->department,
            ]);
        });

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
