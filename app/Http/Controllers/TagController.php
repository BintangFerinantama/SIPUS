<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the tags.
     */
    public function index(Request $request): Response
    {
        $query = Tag::withCount('files');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tags = $query->orderBy('name')->paginate(15);

        return Inertia::render('Tags/Index', [
            'tags' => $tags,
            'canManage' => Auth::user()->isAdmin(),
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create(): Response
    {
        $this->authorize('create', Tag::class);

        return Inertia::render('Tags/Create');
    }

    /**
     * Store a newly created tag in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);

        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
        ]);

        return redirect()->route('tags.index')
            ->with('success', 'Tag berhasil ditambahkan.');
    }

    /**
     * Display the specified tag.
     */
    public function show(Tag $tag): Response
    {
        // Load file count for the tag
        $tag->loadCount('files');

        // Get files with this tag (with pagination)
        $files = $tag->files()
            ->with(['uploader', 'rack', 'subRack', 'tags'])
            ->latest()
            ->paginate(12);

        // Transform files to include formatted size
        $files->getCollection()->transform(function ($file) {
            $file->formatted_size = $this->formatFileSize($file->size);
            return $file;
        });

        return Inertia::render('Tags/Show', [
            'tag' => $tag,
            'files' => $files,
        ]);
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit(Tag $tag): Response
    {
        $this->authorize('update', $tag);

        return Inertia::render('Tags/Edit', [
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified tag in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tags', 'name')->ignore($tag->id),
            ],
        ]);

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tags.index')
            ->with('success', 'Tag berhasil diperbarui.');
    }

    /**
     * Remove the specified tag from storage.
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        // Check if tag is used by any files
        if ($tag->files()->count() > 0) {
            return back()->withErrors(['error' => 'Tag tidak dapat dihapus karena masih digunakan oleh file.']);
        }

        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag berhasil dihapus.');
    }

    /**
     * Format file size to human readable format
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
