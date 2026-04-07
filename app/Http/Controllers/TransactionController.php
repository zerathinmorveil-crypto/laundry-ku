<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Serpice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['customer', 'serpice']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_nota', 'like', "%$search%")
                  ->orWhereHas('customer', fn ($q2) =>
                      $q2->where('nama', 'like', "%$search%")
                  );
            });
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create', [
            'customers' => Customer::all(),
            'serpices'  => Serpice::all(),
            'nomorNota' => $this->generateNomorNota(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'serpice_id'     => 'required|exists:serpices,id',
            'tanggal_masuk'  => 'required|date',
            'berat_kg'       => 'required|numeric|min:0.1',
            'jumlah_bayar'   => 'required|numeric|min:0',
            'catatan'        => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $serpice = Serpice::findOrFail($request->serpice_id);

            $totalHarga = $request->berat_kg * $serpice->harga_per_kg;

            $estimasiHari = ceil($serpice->estimasi_waktu / 24);
            $tanggalSelesai = date(
                'Y-m-d',
                strtotime($request->tanggal_masuk . " +{$estimasiHari} days")
            );

            $statusBayar =
                $request->jumlah_bayar >= $totalHarga ? 'Lunas' :
                ($request->jumlah_bayar > 0 ? 'DP' : 'Belum Lunas');

            Transaction::create([
                'nomor_nota'      => $this->generateNomorNota(),
                'customer_id'     => $request->customer_id,
                'serpice_id'      => $request->serpice_id,
                'tanggal_masuk'   => $request->tanggal_masuk,
                'tanggal_selesai' => $tanggalSelesai,
                'berat_kg'        => $request->berat_kg,
                'total_harga'     => $totalHarga,
                'status'          => 'Proses',
                'status_bayar'    => $statusBayar,
                'jumlah_bayar'    => $request->jumlah_bayar,
                'catatan'         => $request->catatan,
            ]);

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dibuat!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'serpice']);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', [
            'transaction' => $transaction,
            'customers'   => Customer::all(),
            'serpices'    => Serpice::all(),
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'serpice_id'    => 'required|exists:serpices,id',
            'tanggal_masuk' => 'required|date',
            'berat_kg'      => 'required|numeric|min:0.1',
            'jumlah_bayar'  => 'required|numeric|min:0',
            'status'        => 'required|in:Proses,Selesai,Diambil',
            'catatan'       => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $serpice = Serpice::findOrFail($request->serpice_id);

            $totalHarga = $request->berat_kg * $serpice->harga_per_kg;

            $statusBayar =
                $request->jumlah_bayar >= $totalHarga ? 'Lunas' :
                ($request->jumlah_bayar > 0 ? 'DP' : 'Belum Lunas');

            $tanggalAmbil =
                $request->status === 'Diambil' ? now() : $transaction->tanggal_ambil;

            $transaction->update([
                'customer_id'   => $request->customer_id,
                'serpice_id'    => $request->serpice_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'berat_kg'      => $request->berat_kg,
                'total_harga'   => $totalHarga,
                'status'        => $request->status,
                'status_bayar'  => $statusBayar,
                'jumlah_bayar'  => $request->jumlah_bayar,
                'tanggal_ambil' => $tanggalAmbil,
                'catatan'       => $request->catatan,
            ]);

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil diupdate!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal mengupdate transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    private function generateNomorNota()
    {
        $today = now()->format('Ymd');

        $last = Transaction::whereDate('created_at', today())
            ->latest('id')
            ->first();

        $number = $last
            ? ((int) substr($last->nomor_nota, -4) + 1)
            : 1;

        return 'TRX-' . $today . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function cetakPdf()
    {
        $transactions = Transaction::with(['customer', ])
                                   ->orderBy('tanggal_masuk', 'desc')->get();
 
        $pdf = Pdf::loadView('transactions.pdf', compact('transactions'))
                  ->setPaper('a4', 'landscape');
 
        return $pdf->stream('laporan-data-transaksi.pdf');
    }

    public function cetakInvoice($id)
    {
        $transaction = Transaction::with(['customer'])->findOrFail($id);
 
        $pdf = Pdf::loadView('transactions.invoice-pdf', compact('transaction'))
                  ->setPaper('a4', 'portrait');
 
        return $pdf->stream('invoice-' . $transaction->kode_invoice . '.pdf');
    }

    public function cetakStruk($id)
    {
        $transaction = Transaction::with(['customer', 'serpice'])
                                  ->findOrFail($id);
 
        return view('transactions.struk', compact('transaction'));
    }
 
    public function cetakStrukPdf($id)
    {
        $transaction = Transaction::with(['customer', 'member', 'details.service'])
                                  ->findOrFail($id);
  
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('transactions.struk', compact('transaction'))
                  ->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80mm x 200mm
 
        return $pdf->stream('struk-' . $transaction->kode_invoice . '.pdf');
    }
}