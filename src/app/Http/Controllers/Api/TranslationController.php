<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;


/**
 * @OA\Info(
 *     title="Laravel Translation API",
 *     version="1.0.0",
 *     description="API documentation for the translation management system.",
 *     @OA\Contact(
 *         email="dev@example.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Server(
 *     url="http://localhost",
 *     description="Local Dev Server"
 * )
 */
class TranslationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/translations",
     *     summary="List all translations",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        return Translation::paginate(50);
    }

    /**
     * @OA\Post(
     *     path="/api/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"locale","key","content"},
     *             @OA\Property(property="locale", type="string"),
     *             @OA\Property(property="key", type="string"),
     *             @OA\Property(property="content", type="string"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'locale' => 'required|string',
            'key' => 'required|string',
            'content' => 'required|string',
            'tags' => 'array',
        ]);

        $translation = Translation::create($data);
        return response()->json($translation, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation)
    {
        return $translation;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Translation $translation)
    {
        $data = $request->validate([
            'locale' => 'string',
            'key' => 'string',
            'content' => 'string',
            'tags' => 'array',
        ]);

        $translation->update($data);
        return $translation;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation)
    {
        $translation->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/translations/export",
     *     summary="Export all translations grouped by locale",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Exported JSON")
     * )
     */
    public function export()
    {
        $translations = Translation::all();
        $formatted = [];

        foreach ($translations as $translation) {
            $formatted[$translation->locale][$translation->key] = $translation->content;
        }

        return response()->json($formatted);
    }


    /**
     * @OA\Get(
     *     path="/api/translations/search",
     *     summary="Search translations by key, content, or tag",
     *     tags={"Translations"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="key", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="content", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="tag", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Search results")
     * )
     */
    public function search(Request $request)
    {
        $query = Translation::query();

        if ($request->has('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }

        if ($request->has('content')) {
            $query->where('content', 'like', "%{$request->content}%");
        }

        if ($request->has('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        return $query->paginate(50);
    }
}
