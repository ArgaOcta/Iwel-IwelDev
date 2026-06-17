<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\ComplaintResponse;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function show($id, Request $request)
    {
        $complaint = Complaint::with(['user', 'category', 'attachments', 'responses.user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('mahasiswa.complaintdetail', compact('complaint'));
    }

    public function index(Request $request)
    {
        $query = Complaint::with('category')->where('user_id', auth()->id());

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('ticket_no', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status') && $request->status !== 'All Statuses') {
            $query->where('status', $request->status);
        }

        if ($request->get('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $complaints = $query->paginate(10)->withQueryString();

        return view('mahasiswa.mycomplainthistory', compact('complaints'));
    }

    public function create()
    {
        // AMBIL KATEGORI DARI DATABASE
        $categories = Category::all();
        return view('mahasiswa.submitcomplaint', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'priority' => 'required|in:Rendah,Sedang,Tinggi',
            'attachment.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        $ticket_no = 'TCK-' . strtoupper(Str::random(6));

        $complaint = Complaint::create([
            'ticket_no' => $ticket_no,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'priority' => $request->priority,
            'status' => 'Pending',
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
        ]);

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $filePath = $file->store('attachments', 'public');
                $complaint->attachments()->create([
                    'file_path' => $filePath,
                    'file_type' => $file->getClientOriginalExtension(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil dikirim dengan Nomor Tiket: ' . $ticket_no);
    }

    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'response' => 'required|string',
        ]);

        $complaint = Complaint::where('user_id', auth()->id())->findOrFail($id);

        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'message' => $request->response,
            'is_internal' => false,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}