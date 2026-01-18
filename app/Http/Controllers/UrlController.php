<?php
namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller {
    public function index(Request $request) {
        $user = $request->user();
        $query = Url::with(['user', 'company']);

        // Role-based filtering EXACTLY as specified
        if ($user->role === 'admin') {
            $query->where('company_id', $user->company_id);
        } elseif ($user->role === 'member') {
            $query->where('user_id', $user->id);
        } elseif (!$user->canCreateUrls()) {
            abort(403, 'You cannot view URLs.');
        }

        $urls = $query->latest()->paginate(15);
        return view('urls.index', compact('urls'));
    }

    public function create() {
        return view('urls.create');
    }

    public function store(Request $request) {
        $request->validate(['original_url' => 'required|url|max:2048']);
        
        $url = Url::create([
            'original_url' => $request->original_url,
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
        ]);

        return redirect()->route('urls.index')
            ->with('success', 'URL created! Short code: ' . $url->short_code);
    }

    public function redirect($short_code) {
        $url = Url::where('short_code', $short_code)->firstOrFail();
        $url->increment('clicks');
        return redirect()->away($url->original_url, 302);
    }
}
