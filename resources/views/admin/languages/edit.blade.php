@extends('admin.layouts.app')

@section('title', 'Edit Bahasa')

@section('page-title', 'Edit Bahasa')

@section('content')

<div class="bg-white rounded-2xl shadow">

    <div class="border-b p-6">

        <h2 class="text-2xl font-bold">

            Edit Bahasa

        </h2>

    </div>

    <form
        method="POST"
        action="{{ route('admin.languages.update', $language) }}"
    >

        @csrf
        @method('PUT')

        <div class="p-6 space-y-5">

            {{-- Nama Bahasa --}}
            <div>

                <label class="block mb-2 font-medium">

                    Nama Bahasa

                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $language->name) }}"
                    class="w-full rounded-xl px-4 py-3 border
                    @error('name')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror">

                @error('name')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Native --}}
            <div>

                <label class="block mb-2 font-medium">

                    Nama Asli (Native)

                </label>

                <input
                    type="text"
                    name="native_name"
                    value="{{ old('native_name', $language->native_name) }}"
                    class="w-full rounded-xl px-4 py-3 border
                    @error('native_name')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror">

                @error('native_name')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Code --}}
            <div>

                <label class="block mb-2 font-medium">

                    Code

                </label>

                <input
                    type="text"
                    name="code"
                    value="{{ old('code', $language->code) }}"
                    class="w-full rounded-xl px-4 py-3 border
                    @error('code')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror">

                @error('code')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Flag --}}
            <div>

                <label class="block mb-2 font-medium">

                    Emoji Bendera

                </label>

                <input
                    type="text"
                    name="flag"
                    value="{{ old('flag', $language->flag) }}"
                    placeholder="🇮🇩"
                    class="w-full rounded-xl px-4 py-3 border
                    @error('flag')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror">

                @error('flag')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Urutan --}}
            <div>

                <label class="block mb-2 font-medium">

                    Urutan

                </label>

                <input
                    type="number"
                    name="sort_order"
                    value="{{ old('sort_order', $language->sort_order) }}"
                    class="w-full rounded-xl px-4 py-3 border
                    @error('sort_order')
                        border-red-500
                    @else
                        border-gray-300
                    @enderror">

                @error('sort_order')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            {{-- Status --}}
            <div>

                <label class="block mb-2 font-medium">

                    Status

                </label>

                <select
                    name="is_active"
                    class="w-full border rounded-xl px-4 py-3">

                    <option
                        value="1"
                        {{ old('is_active', $language->is_active) ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="0"
                        {{ !old('is_active', $language->is_active) ? 'selected' : '' }}
                    >
                        Nonaktif
                    </option>

                </select>

            </div>

            {{-- Default --}}
            <div class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="is_default"
                    value="1"
                    {{ old('is_default', $language->is_default) ? 'checked' : '' }}
                >

                <label>

                    Jadikan Bahasa Default

                </label>

            </div>

        </div>

        <div class="border-t p-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.languages.index') }}"
                class="px-5 py-3 border rounded-xl">

                Batal

            </a>

            <button
                class="px-5 py-3 bg-yellow-500 text-white rounded-xl">

                Update

            </button>

        </div>

    </form>

</div>

@endsection