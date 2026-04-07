<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::with('customer');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                  ->orWhere('nomor_telepon', 'like', '%' . $search . '%');
            });
        }

        $members = $query->latest()->paginate(10);
        
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::doesntHave('member')->get();
        
        return view('members.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id|unique:members,customer_id',
            'jenis_member' => 'required|in:silver,gold,platinum',
            'tanggal_bergabung' => 'required|date',
            'tanggal_expired' => 'nullable|date|after:tanggal_bergabung',
            'poin' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        try {
            DB::beginTransaction();
            
            Member::create($validated);
            
            DB::commit();
            
            return redirect()->route('members.index')
                ->with('success', 'Member berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan member: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load('customer');
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $customers = Customer::doesntHave('member')
            ->orWhere('id', $member->customer_id)
            ->get();
        
        return view('members.edit', compact('member', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id|unique:members,customer_id,' . $member->id,
            'jenis_member' => 'required|in:silver,gold,platinum',
            'tanggal_bergabung' => 'required|date',
            'tanggal_expired' => 'nullable|date|after:tanggal_bergabung',
            'poin' => 'nullable|integer|min:0',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        try {
            DB::beginTransaction();
            
            $member->update($validated);
            
            DB::commit();
            
            return redirect()->route('members.index')
                ->with('success', 'Member berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Gagal mengupdate member: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            
            return redirect()->route('members.index')
                ->with('success', 'Member berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus member: ' . $e->getMessage());
        }
    }

    public function cetakPdf()
    {
        $members = Member::orderBy('tanggal_bergabung', 'desc')->get();

        $pdf = Pdf::loadView('members.pdf', compact('members'))
                  ->setPaper('a4', 'landscape'); 

        return $pdf->stream('laporan-data-member.pdf');
    }

    public function cetakPdfByJenis($jenis)
    {
        $members = Member::where('jenis_member', $jenis)
                         ->orderBy('tanggal_bergabung', 'desc')->get();
    
        $pdf = Pdf::loadView('members.pdf', compact('members', 'jenis'))
                  ->setPaper('a4', 'landscape');
    
        return $pdf->stream('laporan-member-' . strtolower($jenis) . '.pdf');
    }
}