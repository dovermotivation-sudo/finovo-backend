<?php

namespace App\Http\Controllers;

use App\Models\KycDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\KycStatusNotification;
use App\Services\ReferralService;
use App\Models\Referral;

class KycController extends Controller
{
    /**
     * Show KYC application form.
     */
    public function index()
    {
        $user = Auth::user();
        $kycDocument = KycDocument::where('user_id', $user->id)->latest()->first();
        
        return view('kyc.application', compact('kycDocument'));
    }

    /**
     * Store KYC document.
     */
    public function store(Request $request)
    {
        // Define validation rules based on document type
        $rules = [
            'document_type' => 'required|in:aadhaar,pan,driving_license,passport,voter_id',
            'document_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'document_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'selfie' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];

        // Add document number validation based on type
        switch ($request->document_type) {
            case 'aadhaar':
                $rules['document_number'] = ['required', 'regex:/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/'];
                break;
            case 'pan':
                $rules['document_number'] = ['required', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/'];
                break;
            case 'driving_license':
                $rules['document_number'] = ['required', 'regex:/^[A-Z]{2}[0-9]{2}[0-9]{11}$/'];
                break;
            case 'passport':
                $rules['document_number'] = ['required', 'regex:/^[A-Z]{1}[0-9]{7}$/'];
                break;
            case 'voter_id':
                $rules['document_number'] = ['required', 'regex:/^[A-Z]{3}[0-9]{7}$/'];
                break;
            default:
                $rules['document_number'] = 'required|string|max:50';
        }

        $messages = [
            'document_number.regex' => $this->getDocumentNumberErrorMessage($request->document_type),
        ];

        $request->validate($rules, $messages);

        $user = Auth::user();

        // Check if user already has a pending or verified KYC
        $existingKyc = KycDocument::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existingKyc) {
            return back()->with('error', 'You already have a ' . $existingKyc->status . ' KYC application.');
        }

        // Store document front
        $documentFrontPath = $request->file('document_front')->store('kyc_documents', 'public');

        // Store document back if provided
        $documentBackPath = null;
        if ($request->hasFile('document_back')) {
            $documentBackPath = $request->file('document_back')->store('kyc_documents', 'public');
        }

        // Store selfie if provided
        $selfiePath = null;
        if ($request->hasFile('selfie')) {
            $selfiePath = $request->file('selfie')->store('kyc_documents', 'public');
        }

        // Create KYC document
        KycDocument::create([
            'user_id' => $user->id,
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'document_front_path' => $documentFrontPath,
            'document_back_path' => $documentBackPath,
            'selfie_path' => $selfiePath,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Notify admin (you can implement this later)
        // Notification::send(User::where('role', 'super_admin')->get(), new NewKycSubmission($user));

        return redirect()->route('kyc.application')->with('success', 'KYC documents submitted successfully! We will review your application soon.');
    }

    /**
     * Show user's KYC status.
     */
    public function status()
    {
        $user = Auth::user();
        $kycDocument = KycDocument::where('user_id', $user->id)->latest()->first();
        
        return view('kyc.status', compact('kycDocument'));
    }

    /**
     * Admin: List all KYC applications.
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = KycDocument::with('user')->latest();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $kycDocuments = $query->paginate(20);
        $pendingCount = KycDocument::where('status', 'pending')->count();
        
        return view('admin.kyc.index', compact('kycDocuments', 'status', 'pendingCount'));
    }

    /**
     * Admin: View KYC document details.
     */
    public function adminShow($id)
    {
        $kycDocument = KycDocument::with('user')->findOrFail($id);
        
        return view('admin.kyc.show', compact('kycDocument'));
    }

    /**
     * Admin: Approve KYC document.
     */
    public function approve(Request $request, $id)
    {
        $kycDocument = KycDocument::findOrFail($id);
        
        $kycDocument->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'remarks' => $request->remarks,
        ]);

        // Send notification to user
        try {
            $kycDocument->user->notify(new KycStatusNotification($kycDocument));
        } catch (\Exception $e) {
            \Log::error('KYC notification failed: ' . $e->getMessage());
        }

        // Process referral rewards if user was referred
        if ($kycDocument->user->referred_by) {
            $referral = Referral::where('referred_user_id', $kycDocument->user->id)
                ->where('status', '!=', 'rewarded')
                ->first();
            
            if ($referral) {
                $referralService = new ReferralService();
                try {
                    $referralService->checkAndProcessReward($referral);
                } catch (\Exception $e) {
                    \Log::error('Referral reward processing failed: ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('admin.kyc.index')->with('success', 'KYC document approved successfully!');
    }

    /**
     * Admin: Reject KYC document.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:500',
        ]);

        $kycDocument = KycDocument::findOrFail($id);
        
        $kycDocument->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'remarks' => $request->remarks,
        ]);

        // Send notification to user
        try {
            $kycDocument->user->notify(new KycStatusNotification($kycDocument));
        } catch (\Exception $e) {
            \Log::error('KYC notification failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.kyc.index')->with('success', 'KYC document rejected.');
    }

    /**
     * Admin: Delete multiple KYC documents.
     */
    public function deleteKycDocuments(Request $request)
    {
        $request->validate([
            'kyc_documents' => 'required|array',
            'kyc_documents.*' => 'exists:kyc_documents,id',
        ]);

        $deletedCount = 0;
        $kycDocuments = KycDocument::whereIn('id', $request->kyc_documents)->get();

        foreach ($kycDocuments as $kycDocument) {
            // Delete associated files from storage
            if ($kycDocument->document_front_path) {
                Storage::disk('public')->delete($kycDocument->document_front_path);
            }
            if ($kycDocument->document_back_path) {
                Storage::disk('public')->delete($kycDocument->document_back_path);
            }
            if ($kycDocument->selfie_path) {
                Storage::disk('public')->delete($kycDocument->selfie_path);
            }

            // Delete the database record
            $kycDocument->delete();
            $deletedCount++;
        }

        return redirect()->route('admin.kyc.index')->with('success', $deletedCount . ' KYC document(s) deleted successfully.');
    }

    /**
     * Get custom error message for document number validation.
     */
    private function getDocumentNumberErrorMessage($documentType)
    {
        $messages = [
            'aadhaar' => 'Invalid Aadhaar number format. It must be 12 digits and cannot start with 0 or 1. Example: 234567891234',
            'pan' => 'Invalid PAN card format. It must be in format: ABCDE1234F (5 letters, 4 digits, 1 letter). Example: ABCDE1234F',
            'driving_license' => 'Invalid Driving License format. It must be in format: XX00 00000000000 (2 letters, 2 digits, 11 digits). Example: MH01 20200012345',
            'passport' => 'Invalid Passport format. It must be in format: A1234567 (1 letter followed by 7 digits). Example: A1234567',
            'voter_id' => 'Invalid Voter ID format. It must be in format: ABC1234567 (3 letters followed by 7 digits). Example: ABC1234567',
        ];

        return $messages[$documentType] ?? 'Invalid document number format.';
    }
}
