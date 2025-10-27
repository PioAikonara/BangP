<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(15);
        return view('kasir.member.index', compact('members'));
    }

    public function create()
    {
        return view('kasir.member.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_member' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        Member::create($validated);

        return redirect()->route('kasir.member.index')
            ->with('success', 'Member berhasil ditambahkan');
    }

    public function show(Member $member)
    {
        $member->load('transaksi');
        return view('kasir.member.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('kasir.member.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nama_member' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $member->update($validated);

        return redirect()->route('kasir.member.index')
            ->with('success', 'Member berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('kasir.member.index')
            ->with('success', 'Member berhasil dihapus');
    }
}
