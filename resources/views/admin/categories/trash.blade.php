@extends('admin.layouts.app')

@section('title', 'Recycle Bin Kategori')

@section('page-title', 'Recycle Bin')

@section('content')

<div class="bg-white rounded-2xl shadow-md p-6">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-2xl font-bold">

                🗑️ Recycle Bin Kategori

            </h2>

            <p class="text-gray-500">

                Daftar kategori yang telah dihapus.

            </p>

        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="px-5 py-3 bg-gray-700 text-white rounded-xl">

            ← Kembali

        </a>

    </div>

    @if($categories->count())

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="border-b">

                    <tr>

                        <th class="text-left py-3">Nama</th>

                        <th class="text-left">Slug</th>

                        <th class="text-left">Dihapus</th>

                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($categories as $category)

                    <tr class="border-b">

                        <td class="py-4">

                            {{ $category->name }}

                        </td>

                        <td>

                            {{ $category->slug }}

                        </td>

                        <td>

                            {{ $category->deleted_at->diffForHumans() }}

                        </td>

                        <td class="text-center">

                            <div class="flex justify-center gap-2">

                                <form
                                    action="{{ route('admin.categories.restore',$category->id) }}"
                                    method="POST">

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        class="px-4 py-2 bg-green-500 text-white rounded-lg">

                                        Restore

                                    </button>

                                </form>

                                <form
                                    action="{{ route('admin.categories.forceDelete',$category->id) }}"
                                    method="POST"
                                    class="force-delete-form">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg">

                                        Hapus Permanen

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-6">

            {{ $categories->links() }}

        </div>

    @else

        <div class="text-center py-20">

            <i class="bi bi-trash text-6xl text-gray-300"></i>

            <h3 class="text-2xl font-bold mt-5">

                Recycle Bin Kosong

            </h3>

            <p class="text-gray-500 mt-2">

                Belum ada kategori yang dihapus.

            </p>

        </div>

    @endif

</div>

@push('scripts')

<script>

document.querySelectorAll('.force-delete-form').forEach(form=>{

    form.addEventListener('submit',function(e){

        e.preventDefault();

        Swal.fire({

            title:'Hapus Permanen?',

            text:'Data tidak bisa dikembalikan lagi.',

            icon:'warning',

            showCancelButton:true,

            confirmButtonColor:'#dc2626',

            cancelButtonText:'Batal',

            confirmButtonText:'Ya, Hapus'

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush

@endsection