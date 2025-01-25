@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-4xl font-bold">Daftar Users</h1>
        <a href="{{ route('users.create') }}" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 rounded">Tambah User</a>
    </div>
    <div class="mt-4">
        <table class="w-full border text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">NPP</th>
                    <th class="p-2 border">Role</th>
                    <th class="p-2 border">Department</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="p-2 border">{{ $users->firstItem() + $loop->index }}</td>
                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->npp }}</td>
                        <td class="p-2 border">{{ $user->role }}</td>
                        <td class="p-2 border">{{ $user->department }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('users.edit', $user->id) }}" 
                                class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-txtd px-3 py-1.5 rounded text-sm font-medium">
                                Edit
                            </a>
                            <button type="button" 
                                    class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $users->links() }}
            </div>

            <!-- Modal -->
            <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                    <p id="modalMessage">Apakah Anda yakin ingin menghapus user ini?</p>
                    <div class="flex justify-end mt-4">
                        <button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 hover:bg-gray-200 text-gray-700 rounded-md">Batal</button>
                        <form id="deleteForm" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white rounded-md">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

    </div>
</div>


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("confirmationModal");
        const cancelButton = document.getElementById("cancelButton");
        const modalMessage = document.getElementById("modalMessage");
        const deleteForm = document.getElementById("deleteForm");

        document.querySelectorAll(".deleteButton").forEach(button => {
            button.addEventListener("click", function () {
                const userId = this.getAttribute("data-id");
                const userName = this.getAttribute("data-name");
                modalMessage.innerText = `Apakah Anda yakin ingin menghapus user "${userName}"?`;
                deleteForm.setAttribute("action", `/users/${userId}`);
                modal.classList.remove("hidden");
            });
        });

        cancelButton.addEventListener("click", function () {
            modal.classList.add("hidden");
        });
    });
</script>
@endpush

@endsection
