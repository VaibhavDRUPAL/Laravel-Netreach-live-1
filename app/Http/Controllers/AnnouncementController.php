<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // ✅ List all announcements
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('announcement.index', compact('announcements'));
    }

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
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean'
        ]);

        $announcements = Announcement::create($validated);
        // dd($announcements);
          return view('announcement.index', compact('announcements'));

    }
        public function show($id)
        {
            $announcement = Announcement::findOrFail($id);
            return view('announcement.view', compact('announcement'));
        }

      public function edit($id)
        {
            $announcement = Announcement::findOrFail($id);
           return view('announcement.edit', compact('announcement'));

        }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'sometimes|required|string|max:255',
            'content'    => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'is_active'  => 'boolean'
        ]);

        $announcement->update($validated);

            return view('announcement.view', compact('announcement'));
    }

    // ✅ Delete announcement
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
            return view('announcement.index', compact('announcements'));
      
    }
}
