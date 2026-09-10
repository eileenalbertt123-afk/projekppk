<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = Facility::query()
            ->when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->when($request->location, fn ($q) => $q->where('location', $request->location))
            ->when($request->capacity, fn ($q) => $q->where('capacity', '>=', $request->capacity))
            ->with(['reservations' => fn ($q) => $q->whereDate('start_time', today())])
            ->paginate(9)
            ->withQueryString();

        $types = Facility::distinct()->pluck('type');

        return view('dashboard.index', compact('facilities', 'types'));
    }
}