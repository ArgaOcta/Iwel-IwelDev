<x-app-layout>
    <div class="py-8 px-6">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('admin.complaints.index') }}" class="hover:text-gray-900">Pengaduan</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-semibold">{{ $complaint->ticket_no }}</span>
        </nav>

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Detail Pengaduan</h1>
            <a href="{{ route('admin.complaints.index') }}" class="rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">
                ← Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="grid gap-3 text-sm text-gray-700 sm:grid-cols-2">
                <div>
                    <p class="font-semibold">No Tiket</p>
                    <p>{{ $complaint->ticket_no }}</p>
                </div>

                <div>
                    <p class="font-semibold">Pelapor</p>
                    <p>{{ $complaint->user->name }}</p>
                </div>

                <div>
                    <p class="font-semibold">Kategori</p>
                    <p>{{ $complaint->category->name }}</p>
                </div>

                <div>
                    <p class="font-semibold">Prioritas</p>
                    <p>{{ $complaint->priority }}</p>
                </div>

                <div>
                    <p class="font-semibold">Status</p>
                    <p>{{ $complaint->status }}</p>
                </div>

                <div>
                    <p class="font-semibold">Anonim</p>
                    <p>{{ $complaint->is_anonymous ? 'Ya' : 'Tidak' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="font-bold mb-2">Deskripsi Pengaduan</h3>
                <p class="text-gray-800 whitespace-pre-line">{{ $complaint->description }}</p>
            </div>

            @if ($complaint->attachments->isNotEmpty())
                <div class="mt-6">
                    <h3 class="font-bold mb-2">Lampiran</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700">
                        @foreach ($complaint->attachments as $attachment)
                            <li>
                                <a href="{{ asset('storage/' . $attachment->path) }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $attachment->filename ?? basename($attachment->path) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Update Status -->
            <div class="mt-6 border-t pt-6">
                <h3 class="font-bold mb-4">Update Status Pengaduan</h3>
                <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST" class="flex flex-col gap-4 sm:flex-row sm:items-end">
                    @csrf
                    @method('PUT')

                    <div class="flex-1">
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status Baru</label>
                        <select name="status" id="status" class="w-full border rounded-lg p-2 text-gray-700" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Pending" {{ $complaint->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Reviewing" {{ $complaint->status === 'Reviewing' ? 'selected' : '' }}>Reviewing</option>
                            <option value="In Progress" {{ $complaint->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ $complaint->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="Rejected" {{ $complaint->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="Closed" {{ $complaint->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Simpan Status
                    </button>
                </form>
            </div>

            @if ($complaint->auditLogs->isNotEmpty())
                <div class="mt-6 border-t pt-6">
                    <h3 class="font-bold mb-4">Riwayat Perubahan</h3>
                    <div class="space-y-3 text-sm text-gray-700">
                        @foreach ($complaint->auditLogs as $log)
                            <div class="rounded-lg border border-gray-200 p-3">
                                <p class="font-semibold">{{ $log->user->name ?? 'Sistem' }}</p>
                                <p>{{ $log->old_status }} → {{ $log->new_status }}</p>
                                <p class="text-gray-500 text-xs">{{ $log->created_at->format('d M Y H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>