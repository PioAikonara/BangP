@extends('layouts.dashboard')

@section('title', 'Data Member')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Member</h1>
        <a href="{{ route('kasir.member.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg transition duration-200 shadow-sm">
            <i class="fas fa-plus mr-2"></i>Tambah Member
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <input type="text" id="searchInput" placeholder="Cari member..." 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NO</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">KODE MEMBER</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NAMA MEMBER</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NO. HP</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ALAMAT</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">DISKON</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($members as $index => $member)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $members->firstItem() + $index }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $member->kode_member }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->nama_member }}</div>
                                            @if($member->user)
                                                <div class="text-xs text-gray-500 mt-0.5">{{ $member->user->email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $member->no_hp }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ Str::limit($member->alamat ?? '-', 35) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $member->diskon }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('kasir.member.show', $member) }}" 
                                                    class="text-blue-600 hover:text-blue-800 transition duration-150" 
                                                    title="Detail">
                                                    <i class="fas fa-eye text-lg"></i>
                                                </a>
                                                <a href="{{ route('kasir.member.edit', $member) }}" 
                                                    class="text-yellow-600 hover:text-yellow-800 transition duration-150" 
                                                    title="Edit">
                                                    <i class="fas fa-edit text-lg"></i>
                                                </a>
                                                <form action="{{ route('kasir.member.destroy', $member) }}" 
                                                    method="POST" 
                                                    class="inline" 
                                                    onsubmit="return confirm('Yakin ingin menghapus member ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 transition duration-150" 
                                                        title="Hapus">
                                                        <i class="fas fa-trash text-lg"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-users text-gray-300 text-5xl mb-3"></i>
                                                <p class="text-gray-500 text-sm">Belum ada data member</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($members->hasPages())
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            {{ $members->links() }}
                        </div>
                    @endif
        </div>
    </div>
</div>

<script>
    // Enhanced search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let table = document.querySelector('table tbody');
        let tr = table.getElementsByTagName('tr');

        for (let i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    let txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            tr[i].style.display = found ? "" : "none";
        }
    });
</script>
@endsection
