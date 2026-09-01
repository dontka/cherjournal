<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $stats = $user->journalEntries()
            ->selectRaw("COUNT(*) as total, SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as drafts, SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published, SUM(CASE WHEN status = 'archived' THEN 1 ELSE 0 END) as archived")
            ->first();

        return view('dashboard', [
            'total' => (int) $stats->total,
            'drafts' => (int) $stats->drafts,
            'published' => (int) $stats->published,
            'archived' => (int) $stats->archived,
            'latestEntry' => $user->journalEntries()->latest()->first(),
        ]);
    }
}
