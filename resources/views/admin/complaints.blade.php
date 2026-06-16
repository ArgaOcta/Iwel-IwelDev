<x-app-layout>
    <div class="py-8 px-6">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-semibold">Pengaduan</span>
        </nav>

        <h1 class="text-3xl font-bold mb-6">Daftar Pengaduan</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.complaints.index') }}" class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid gap-4 grid-cols-1 md:grid-cols-4">
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-1">Cari Tiket/Judul</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        placeholder="No tiket atau judul..."
                        value="{{ request('search') }}"
                        class="w-full border rounded-lg p-2 text-gray-700"
                    >
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border rounded-lg p-2 text-gray-700">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Reviewing" {{ request('status') === 'Reviewing' ? 'selected' : '' }}>Reviewing</option>
                        <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="Resolved" {{ request('status') === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div>
                    <label for="sort" class="block text-sm font-semibold text-gray-700 mb-1">Urutkan</label>
                    <select name="sort" id="sort" class="w-full border rounded-lg p-2 text-gray-700">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Cari
                    </button>
                    <a href="{{ route('admin.complaints.index') }}" class="flex-1 text-center bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Tiket</th>
                        <th class="p-3">Mahasiswa</th>
                        <th class="p-3">Judul</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Tgl. Buat</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($complaints as $complaint)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3 font-semibold">{{ $complaint->ticket_no }}</td>
                            <td class="p-3">{{ $complaint->user->name }}</td>
                            <td class="p-3">{{ $complaint->title }}</td>
                            <td class="p-3">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $complaint->status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $complaint->status === 'Reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $complaint->status === 'In Progress' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $complaint->status === 'Resolved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $complaint->status === 'Rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $complaint->status === 'Closed' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                            <td class="p-3 text-sm text-gray-600">{{ $complaint->created_at->format('d M Y') }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.complaints.show', $complaint->id) }}" class="text-blue-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-3 text-center text-gray-500" colspan="6">
                                Tidak ada pengaduan untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($complaints->hasPages())
            <div class="mt-6">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</x-app-layout>