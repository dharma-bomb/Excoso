<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    /**
     * Handle a "Get a Quote" submission from the homepage.
     *
     * The request is always saved to the database first — that part can't
     * fail because of mail configuration. Sending a copy to the sales inbox
     * is attempted afterwards and is best-effort: if MAIL_* isn't set up in
     * .env yet, the visitor still gets a success response and the request
     * is still sitting in /admin/quotes waiting to be read.
     */
    public function submitQuote(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:30',
            'location' => 'nullable|string|max:255',
            'product' => 'nullable|string|max:100',
            'quantity' => 'nullable|string|max:100',
        ]);

        $quote = QuoteRequest::create($data);

        $emailed = false;
        try {
            Mail::raw($this->emailBody($quote), function ($message) use ($quote) {
                $message->to('sales@expertcorporatesolutions.com')
                    ->subject('New Excoso quote request — ' . $quote->name)
                    ->replyTo($quote->email, $quote->name);
            });
            $emailed = true;
        } catch (\Throwable $e) {
            // Mail isn't configured yet, or the send failed for some other
            // reason. The request is already safely in the database and
            // visible at /admin/quotes, so we don't fail the visitor's
            // submission over this — just log it for whoever manages the
            // server to notice.
            Log::warning('Quote request email could not be sent: ' . $e->getMessage());
        }

        if ($emailed) {
            $quote->emailed = true;
            $quote->save();
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Thanks — we\'ll be in touch shortly.']);
        }

        return back()->with('status', 'Thanks — we\'ll be in touch shortly.');
    }

    private function emailBody(QuoteRequest $quote): string
    {
        return implode("\n", [
            'New quote request from the Excoso website:',
            '',
            'Name: ' . $quote->name,
            'Company: ' . ($quote->company ?: '-'),
            'Email: ' . $quote->email,
            'Phone: ' . $quote->phone,
            'Location: ' . ($quote->location ?: '-'),
            'Product: ' . ($quote->product ?: '-'),
            'Quantity: ' . ($quote->quantity ?: '-'),
        ]);
    }

    /**
     * Admin: list quote requests, newest first.
     */
    public function adminList()
    {
        $quotes = QuoteRequest::orderByDesc('created_at')->get();
        return view('admin.quotes', compact('quotes'));
    }

    /**
     * Admin: remove a quote request once it's been actioned.
     */
    public function deleteQuote($id)
    {
        QuoteRequest::findOrFail($id)->delete();
        return redirect()->route('admin.quotes')->with('status', 'Quote request removed.');
    }
}
