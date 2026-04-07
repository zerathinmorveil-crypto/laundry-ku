<?php

namespace App\Http\Controllers;

use App\Models\Serpice;
use Illuminate\Http\Request;

class SerpiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Serpice::query();
        
        if ($request->search) {
            $query->where('nama_layanan', 'like', '%' . $request->search . '%');
        }

        $serpices = $query->latest()->paginate(10);
        return view('serpices.index', compact('serpices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('serpices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        Serpice::create($validatedData);

        return redirect()->route('serpices.index')->with('success', 'Serpice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Serpice $serpice)
    {
        return view('serpices.show', compact('serpice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Serpice $serpice)
    {
        return view('serpices.edit', compact('serpice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Serpice $serpice)
    {
        $validatedData = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $serpice->update($validatedData);

        return redirect()->route('serpices.index')->with('success', 'Serpice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Serpice $serpice)
    {
        $serpice->delete();

        return redirect()->route('serpices.index')->with('success', 'Serpice deleted successfully.');
    }
}
