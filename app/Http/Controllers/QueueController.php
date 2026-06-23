<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    // Halaman Publik (Layar Antrian)
    public function indexPublic() {
        $queues = Queue::whereDate('queue_date', date('Y-m-d'))
                    ->orderByRaw("FIELD(status, 'dipanggil', 'menunggu', 'selesai')")
                    ->orderBy('queue_number', 'asc')->get();
        return view('welcome', compact('queues'));
    }

    // Dashboard Admin
    public function dashboard() {
        $queues = Queue::with('admin')
                       ->whereDate('queue_date', date('Y-m-d'))
                       ->orderBy('queue_number', 'desc')
                       ->paginate(10);
        return view('admin.dashboard', compact('queues'));
    }

    // Tambah Antrian Baru
    public function store(Request $request) {
        $request->validate([
            'no_resep' => 'required', 
            'nama_pasien' => 'required'
        ]);
        
        $today = date('Y-m-d');
        $lastQueue = Queue::whereDate('queue_date', $today)->max('queue_number');
        $newNumber = $lastQueue ? $lastQueue + 1 : 1;

        Queue::create([
            'queue_date' => $today, 
            'queue_number' => $newNumber,
            'no_resep' => $request->no_resep, 
            'nama_pasien' => $request->nama_pasien, 
            'status' => 'menunggu'
        ]);
        
        return redirect()->back()->with('success', 'Antrian berhasil ditambahkan!');
    }

    // Edit/Update Antrian
    public function update(Request $request, $id) {
        $request->validate([
            'no_resep' => 'required', 
            'nama_pasien' => 'required',
            'status' => 'required|in:menunggu,dipanggil,selesai' 
        ]);
        
        $queue = Queue::findOrFail($id);

        // Kunci CRUD: Jika sudah dipegang admin lain, cegah edit (Kecuali Superadmin)
        if ($queue->admin_id !== null && $queue->admin_id !== Auth::id() && Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses ditolak! Antrian ini sedang ditangani oleh admin lain.');
        }
        
        $queue->update([
            'no_resep' => $request->no_resep,
            'nama_pasien' => $request->nama_pasien,
            'status' => $request->status 
        ]);

        return redirect()->back()->with('success', 'Data antrian berhasil diperbarui!');
    }

    // Hapus Antrian (Hanya Superadmin)
    public function destroy($id) {
        // Cek Role: Hanya superadmin yang bisa hapus
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak! Hanya Superadmin yang bisa menghapus data.');
        }

        $queue = Queue::findOrFail($id);
        $queue->delete();

        return redirect()->back()->with('success', 'Antrian berhasil dihapus!');
    }

    // Fungsi Panggil
    public function callQueue($id) {
        $queue = Queue::findOrFail($id);
        
        // Mencegah double handling jika antrian sedang dipegang admin lain
        if ($queue->admin_id !== null && $queue->admin_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian ini sedang ditangani oleh petugas lain!'
            ]);
        }
        
        // Reset status 'dipanggil' pada antrian lain yang dipegang admin ini
        Queue::where('status', 'dipanggil')
             ->where('admin_id', Auth::id())
             ->where('id', '!=', $id)
             ->update(['status' => 'selesai']); 
        
        // Update status antrian ini dan kunci ke admin yang memanggil
        $queue->update([
            'status' => 'dipanggil', 
            'admin_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'nomor' => str_pad($queue->queue_number, 3, '0', STR_PAD_LEFT), 
                'nama' => $queue->nama_pasien, 
                'loket' => Auth::user()->loket
            ]
        ]);
    }
}