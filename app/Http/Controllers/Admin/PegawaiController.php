<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::with('user')->latest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
    {
        return view('admin.pegawai.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'kasir',
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function show(Pegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.show', compact('pegawai'));
    }

    public function edit(Pegawai $pegawai)
    {
        $pegawai->load('user');
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($pegawai->user_id)],
            'password' => 'nullable|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:20',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $pegawai->user()->update($userData);
        $pegawai->update([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
        ]);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->user()->delete();
        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus');
    }
}
