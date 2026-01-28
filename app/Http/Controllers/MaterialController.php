<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            \'topic_id\' => \'required|exists:topics,id\',
            \'type\' => \'required|string|in:Link,PDF,Video\',
            \'url\' => \'required|url\',
            \'description\' => \'nullable|string|max:255\',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        if ($topic->discipline->plan->user_id !== Auth::id()) abort(403);

        Material::create($request->all());

        return back()->with(\'success\', \'Material adicionado com sucesso!\');
    }

    public function destroy(Material $material)
    {
        if ($material->topic->discipline->plan->user_id !== Auth::id()) abort(403);
        $material->delete();
        return back()->with(\'success\', \'Material removido!\');
    }
}
