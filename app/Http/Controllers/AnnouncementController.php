<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    // ✅ List all announcements
    public function index(Request $request)
    {
        $query = Announcement::query();

        // optional search
        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('content', 'like', '%'.$request->search.'%');
        }

        $announcements = $query->orderBy('created_at', 'desc')->get();

        return view('announcement.index', compact('announcements'));
    }

    // ✅ Show create form
    public function create()
    {
        return view('announcement.create');
    }

    // ✅ Store new announcement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'content'    => 'nullable|string',
            'start_date' => 'nullable|date_format:Y-m-d\TH:i',
            'end_date'   => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_date',
            'is_active'  => 'boolean'
        ]);

        // convert to proper MySQL datetime
        $validated['start_date'] = $validated['start_date']
            ? Carbon::parse($validated['start_date'])->format('Y-m-d H:i:s')
            : null;

        $validated['end_date'] = $validated['end_date']
            ? Carbon::parse($validated['end_date'])->format('Y-m-d H:i:s')
            : null;

        Announcement::create($validated);

        // always redirect to index (not return view)
        return redirect()->route('announcements.index')
                         ->with('success', 'Announcement created successfully.');
    }

    // ✅ Show single announcement
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.view', compact('announcement'));
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('announcement.edit', compact('announcement'));
    }

    // ✅ Update announcement
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'sometimes|required|string|max:255',
            'content'    => 'nullable|string',
            'start_date' => 'nullable|date_format:Y-m-d\TH:i',
            'end_date'   => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:start_date',
            'is_active'  => 'boolean'
        ]);

        $validated['start_date'] = $validated['start_date']
            ? Carbon::parse($validated['start_date'])->format('Y-m-d H:i:s')
            : null;

        $validated['end_date'] = $validated['end_date']
            ? Carbon::parse($validated['end_date'])->format('Y-m-d H:i:s')
            : null;

        $announcement->update($validated);

        return redirect()->route('announcements.show', $announcement)
                         ->with('success', 'Announcement updated successfully.');
    }

    // ✅ Delete announcement
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcements.index')
                         ->with('success', 'Announcement deleted successfully.');
    }
}
