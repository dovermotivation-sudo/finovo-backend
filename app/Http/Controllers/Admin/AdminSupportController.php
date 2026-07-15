<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    /**
     * Display a listing of all support tickets.
     */
    public function index(Request $request)
    {
        $query = SupportTicket::with('user')->orderBy('created_at', 'desc');

        // Optional search or status filter
        if ($request->has('status') && in_array($request->status, ['open', 'resolved'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $tickets = $query->paginate(15);
        return view('admin.support.index', compact('tickets'));
    }

    /**
     * Display the specified support ticket details.
     */
    public function show($id)
    {
        $ticket = SupportTicket::with('user')->findOrFail($id);
        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Save the admin reply and mark ticket as resolved.
     */
    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status' => 'resolved',
        ]);

        return redirect()->route('admin.support.show', $ticket->id)->with('success', 'Reply submitted and ticket marked as resolved.');
    }
}
