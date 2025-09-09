<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorController extends Controller
{
    // Menampilkan daftar indikator
    public function index(Request $request)
    {
        $query = Indicator::query()
            ->select('var_id','title','sub_id','subcsa_id')
            ->with([
                'kategori:id,name',
                'subkategori:id,name',
            ]);

        if ($request->q) {
            $query->where('title', 'like', "%{$request->q}%");
        }

        if ($request->sort === 'latest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'az') {
            $query->orderBy('title', 'asc');
        } elseif ($request->sort === 'za') {
            $query->orderBy('title', 'desc');
        }

        $indicators = $query->paginate(10)->withQueryString();

        // transform agar hanya nama kategori & subkategori yang dikirim
        $indicators->getCollection()->transform(function ($indicator) {
            return [
                'var_id' => $indicator->var_id,
                'title' => $indicator->title,
                'kategori' => $indicator->kategori?->name,
                'subkategori' => $indicator->subkategori?->name,
            ];
        });

        return inertia('Indicators/List', [
            'indicators' => $indicators,
            'query' => $request->q,
            'sort' => $request->sort,
        ]);
    }

    // Menambah jumlah view
    public function show(Indicator $indicator)
    {
        $indicator->increment('total_views');

        return Inertia::render('Indicators/Show', [
            'indicator' => $indicator->loadCount('likes'),
        ]);
    }

    // Like indikator
    public function like(Indicator $indicator)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $indicator->likes()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        return back();
    }

    // Unlike indikator
    public function unlike(Indicator $indicator)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $indicator->likes()->where('user_id', $user->id)->delete();

        return back();
    }
}
