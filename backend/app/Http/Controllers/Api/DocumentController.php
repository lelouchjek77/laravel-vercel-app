<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DocumentShare;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::where('owner_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($documents);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $document = Document::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? '',
            'owner_id' => $request->user()->id,
        ]);

        return response()->json($document, 201);
    }

    public function show(Document $document)
    {
        return response()->json($document);
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $document->update($validated);

        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return response()->json([
            'message' => 'Document deleted successfully'
        ]);
    }

    public function share(Request $request, Document $document)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        DocumentShare::firstOrCreate([
            'document_id' => $document->id,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Document shared successfully'
        ]);
    }

    public function sharedDocuments(Request $request)
    {
        $documents = Document::whereIn(
            'id',
            DocumentShare::where(
                'user_id',
                $request->user()->id
            )->pluck('document_id')
        )->get();

        return response()->json($documents);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt,md'
        ]);

        $file = $request->file('file');

        $content = File::get(
            $file->getRealPath()
        );

        $document = Document::create([
            'title' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
            'content' => nl2br($content),
            'owner_id' => auth()->id()
        ]);

        return response()->json([
            'message' => 'Document imported',
            'document' => $document
        ]);
    }
}