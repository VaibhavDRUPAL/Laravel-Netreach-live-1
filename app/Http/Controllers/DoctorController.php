<?php
namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // ✅ Must be here, outside the class

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('created_at', 'desc')->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:doctors,email',
            'phone'          => 'nullable|string|max:10',
            'specialization' => 'nullable|string|max:255',
            'qualification'  => 'nullable|string',
            'profile_photo'  => 'nullable|image|max:2048',
            'is_active'      => 'boolean',
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('doctors', 'public');
        }

        Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctors.edit', compact('doctor'));
    }



public function update(Request $request)
{
    // Find doctor by phone
    $doctor = Doctor::where('phone', $request->phone)->firstOrFail();

    // Validate data
    $validated = $request->validate([
        'name'           => 'required|string|max:255',
        'phone'          => [
            'required',
            'string',
            'max:15',
            Rule::unique('doctors')->ignore($doctor->id), // ✅ fixed
        ],
        'email'          => 'nullable|email|max:255',
        'specialization' => 'nullable|string|max:255',
        'qualification'  => 'nullable|string',
        'profile_photo'  => 'nullable|image|max:2048',
        'is_active'      => 'boolean',
    ]);

    if ($request->hasFile('profile_photo')) {
        $validated['profile_photo'] = $request->file('profile_photo')->store('doctors', 'public');
    }

    $doctor->update($validated);

    return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully!');
}


   public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully!');
    }

    
}
