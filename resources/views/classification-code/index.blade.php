@extends('layouts.app')

@section('title', 'Kode Klasifikasi')

@section('content')
<div class="container mx-auto p-8 bg-white shadow-md rounded-lg">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-4xl font-bold text-txtl">Kode Klasifikasi</h1>
        <div class="flex items-center">
            <a href="{{ route('classificationCode.create') }}" class="bg-btn hover:bg-btnh text-txtd px-4 py-2 mx-4 rounded">Tambah Kode Klasifikasi</a>
            <a href="{{ route('classificationCode.importV') }}" class="bg-green-600 hover:bg-green-500 text-txtd px-4 py-2 rounded">Import Kode Klasifikasi</a>
        </div>
    </div>

    <div class="mt-4">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Kode</th>
                    <th class="p-2 border">Judul</th>
                    <th class="p-2 border">Aktif</th>
                    <th class="p-2 border">Inaktif</th>
                    <th class="p-2 border">Keamanan</th>
                    <th class="p-2 border">Hak Akses</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classificationCodes as $classification)
                    <tr>
                        <td class="p-2 border">{{ $classification->code }}</td>
                        <td class="p-2 border">{{ $classification->title }}</td>
                        <td class="p-2 border">{{ $classification->active }} tahun {{ $classification->ket_active }}</td>
                        <td class="p-2 border">{{ $classification->inactive }} tahun {{ $classification->ket_inactive }}</td>
                        <td class="p-2 border">{{ $classification->security }}</td>
                        <td class="p-2 border">{{ $classification->hak_akses }}</td>
                        <td class="p-2 border border-b-0 flex gap-2 justify-center">
                            <a href="{{ route('classificationCode.edit', $classification->id) }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-400 text-txtd px-2 py-1 rounded">Edit</a>
                            <button type="button" 
                                    class="deleteButton inline-flex items-center justify-center bg-red-500 hover:bg-red-400 text-white px-3 py-1.5 rounded text-sm font-medium"
                                    data-id="{{ $classification->id }}" 
                                    data-name="{{ $classification->title }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $classificationCodes->links() }}
        </div>

        <!-- Modal -->
        <div id="confirmationModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Konfirmasi</h3>
                <p id="modalMessage">Apakah Anda yakin ingin menghapus data ini?</p>
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
                const classificationId = this.getAttribute("data-id");
                const classificationTitle = this.getAttribute("data-name");
                modalMessage.innerText = `Apakah Anda yakin ingin menghapus data "${classificationTitle}"?`;
                deleteForm.setAttribute("action", `/classificationCode/${classificationId}`);
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
