<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of support tickets and the creation form.
     */
    public function index()
    {
        $user = Auth::user();
        $tickets = SupportTicket::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('support.index', compact('tickets'));
    }

    /**
     * Store a newly created support ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // Max 5MB
        ], [
            'screenshot.max' => 'The screenshot size must not exceed 5MB.',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $screenshotPath = $request->file('screenshot')->store('support_screenshots', 'public');
        }

        SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'screenshot_path' => $screenshotPath,
            'status' => 'open',
        ]);

        return redirect()->route('support.index')->with('success', 'Support ticket created successfully. Our team will review and reply to it shortly.');
    }

    /**
     * Display the specified support ticket conversation.
     */
    public function show($id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())->findOrFail($id);
        return view('support.show', compact('ticket'));
    }
}
