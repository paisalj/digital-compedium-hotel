<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Language::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('native_name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status == 'active') {

                $query->where('is_active', true);

            }

            if ($request->status == 'inactive') {

                $query->where('is_active', false);

            }

        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $allowedSort = [

            'name',

            'code',

            'sort_order',

            'is_active',

            'created_at',

        ];

        $sort = $request->get('sort', 'sort_order');

        if (! in_array($sort, $allowedSort)) {

            $sort = 'sort_order';

        }

        $direction = $request->get('direction', 'asc');

        if (! in_array($direction, ['asc', 'desc'])) {

            $direction = 'asc';

        }

        $query->orderBy($sort, $direction);

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->get('per_page', 10);

        if (! in_array($perPage, [10, 25, 50, 100])) {

            $perPage = 10;

        }

        $languages = $query
            ->paginate($perPage)
            ->withQueryString();

        return view(
            'admin.languages.index',
            compact('languages')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.languages.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreLanguageRequest $request)
    {
        $data = $request->validated();

        if (! empty($data['is_default'])) {

            $data['is_active'] = true;

            Language::query()->update([
                'is_default' => false,
            ]);
        }

        Language::create($data);

        return redirect()
            ->route('admin.languages.index')
            ->with('success', 'Bahasa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    /**
     * Update the specified resource.
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        $data = $request->validated();

        if (! empty($data['is_default'])) {

            $data['is_active'] = true;

            Language::where('is_default', true)
                ->update([
                    'is_default' => false,
                ]);
        }

        if (
            isset($data['is_active']) &&
            ! $data['is_active']
        ) {

            $activeLanguages = Language::where(
                'is_active',
                true
            )->count();

            if (
                $language->is_active &&
                $activeLanguages <= 1
            ) {

                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Minimal harus ada satu bahasa aktif.'
                    );
            }
        }

        $language->update($data);

        return redirect()
            ->route('admin.languages.index')
            ->with(
                'success',
                'Bahasa berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Language $language)
    {
        if ($language->is_default) {

            return redirect()
                ->route('admin.languages.index')
                ->with(
                    'error',
                    'Bahasa default tidak dapat dihapus.'
                );
        }

        if (Language::count() <= 1) {

            return redirect()
                ->route('admin.languages.index')
                ->with(
                    'error',
                    'Minimal harus ada satu bahasa.'
                );
        }

        $language->delete();

        return redirect()
            ->route('admin.languages.index')
            ->with(
                'success',
                'Bahasa berhasil dihapus.'
            );
    }
}