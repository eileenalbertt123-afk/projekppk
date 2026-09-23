<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Menampilkan daftar status laporan milik pengguna yang sedang login
     */
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
            ->with('facility')
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }

    /**
     * Menampilkan form pengajuan laporan kerusakan
     */
    public function create()
    {
        $facilities = Facility::all();
        return view('reports.create', compact('facilities'));
    }

    /**
     * Menyimpan data laporan kerusakan baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'category'    => 'required|string|max:100',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id'     => Auth::id(),
            'facility_id' => $request->facility_id,
            'category'    => $request->category,
            'description' => $request->description,
            'image_path'  => $imagePath,
            'status'      => 'baru',
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan kerusakan berhasil dikirim!');
    }
}