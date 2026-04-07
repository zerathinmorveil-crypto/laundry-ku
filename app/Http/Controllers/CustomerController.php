<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Customer::query();

    if ($request->search) {
        $query->where('nama_pelanggan', 'like', '%' . $request->search . '%')
              ->orWhere('nomor_telepon', 'like', '%' . $request->search . '%');
    }

    $customers = $query->latest()->paginate(10);

    return view('customers.index', compact('customers'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal' => 'required|date',
            'alamat' => 'required|string',
        ]);

        Customer::create($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load('transactions');
        return view('customers.show', compact('customer')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal' => 'required|date',
            'alamat' => 'required|string',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }

    public function cetakPdf()
    {
        // Ambil semua data customer
        $customers = Customer::orderBy('tanggal', 'desc')->get();

        // Load view PDF
        $pdf = Pdf::loadView('customers.pdf', compact('customers'))
                  ->setPaper('a4', 'portrait');

        // Stream PDF
        return $pdf->stream('laporan-data-customer.pdf');
    }
}
