<?php

namespace App\Http\Controllers;

use App\Mail\ServiceRequestConfirmation;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServiceRequestController extends Controller
{
    /**
     * Store a new service request
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request with security measures
            $validator = Validator::make($request->all(), [
                'first_name' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[A-Za-z\s\-\'.]+$/',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/<[^>]*>/', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                    },
                ],
                'last_name' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[A-Za-z\s\-\'.]+$/',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/<[^>]*>/', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                    },
                ],
                'address' => [
                    'required',
                    'string',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/<[^>]*>/', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                        // Block common SQL injection patterns
                        if (preg_match('/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC)\b)/i', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                    },
                ],
                'city' => [
                    'required',
                    'string',
                    'max:50',
                    'regex:/^[A-Za-z\s\-\'.]+$/',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/<[^>]*>/', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                    },
                ],
                'state' => [
                    'required',
                    'string',
                    'size:2',
                    'in:AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY',
                ],
                'zip' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{5}(-[0-9]{4})?$/',
                ],
                'phone' => [
                    'required',
                    'string',
                    'regex:/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/',
                ],
                'email' => [
                    'required',
                    'email:rfc,dns',
                    'max:100',
                    function ($attribute, $value, $fail) {
                        if (preg_match('/<[^>]*>/', $value)) {
                            $fail('The '.$attribute.' contains invalid characters.');
                        }
                    },
                ],
            ], [
                'first_name.required' => 'First name is required.',
                'first_name.regex' => 'First name can only contain letters, spaces, hyphens, apostrophes, and periods.',
                'last_name.required' => 'Last name is required.',
                'last_name.regex' => 'Last name can only contain letters, spaces, hyphens, apostrophes, and periods.',
                'address.required' => 'Street address is required.',
                'city.required' => 'City is required.',
                'city.regex' => 'City can only contain letters, spaces, hyphens, apostrophes, and periods.',
                'state.required' => 'State is required.',
                'state.in' => 'Please select a valid state.',
                'zip.required' => 'Zip code is required.',
                'zip.regex' => 'Zip code must be in format 12345 or 12345-6789.',
                'phone.required' => 'Phone number is required.',
                'phone.regex' => 'Phone number must be in format 123-456-7890.',
                'email.required' => 'Email address is required.',
                'email.email' => 'Please enter a valid email address.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Sanitize input data
            $sanitizedData = [
                'first_name' => strip_tags(trim($request->first_name)),
                'last_name' => strip_tags(trim($request->last_name)),
                'address' => strip_tags(trim($request->address)),
                'city' => strip_tags(trim($request->city)),
                'state' => strtoupper(trim($request->state)),
                'zip' => trim($request->zip),
                'phone' => trim($request->phone),
                'email' => strtolower(trim($request->email)),
            ];

            // Additional security checks
            foreach ($sanitizedData as $key => $value) {
                // Check for potential XSS attempts
                if ($key !== 'state' && preg_match('/javascript:|data:|vbscript:|onload=|onerror=/i', $value)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid input detected.',
                    ], 400);
                }
            }

            // Rate limiting check (basic implementation)
            $clientIP = $request->ip();
            $cacheKey = 'service_request_'.$clientIP;
            $requestCount = cache($cacheKey, 0);

            if ($requestCount >= 5) { // Max 5 requests per hour
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests. Please try again later.',
                ], 429);
            }

            // Increment request count
            cache([$cacheKey => $requestCount + 1], now()->addHour());

            // Save to database
            $serviceRequest = ServiceRequest::create([
                'first_name' => $sanitizedData['first_name'],
                'last_name' => $sanitizedData['last_name'],
                'address' => $sanitizedData['address'],
                'city' => $sanitizedData['city'],
                'state' => $sanitizedData['state'],
                'zip' => $sanitizedData['zip'],
                'phone' => $sanitizedData['phone'],
                'email' => $sanitizedData['email'],
                'ip_address' => $clientIP,
                'user_agent' => $request->userAgent(),
            ]);

            // Log the service request for admin review
            Log::info('New service request received', [
                'id' => $serviceRequest->id,
                'customer' => $sanitizedData['first_name'].' '.$sanitizedData['last_name'],
                'ip' => $clientIP,
                'timestamp' => now(),
            ]);

            // Send confirmation email to customer
            try {
                Mail::to($serviceRequest->email)->send(new ServiceRequestConfirmation($serviceRequest));
                Log::info('Confirmation email sent successfully', ['request_id' => $serviceRequest->id]);
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation email: '.$e->getMessage());
                // Don't fail the request if email fails
            }

            // Send notification email to admin (if configured)
            try {
                $this->sendNotificationEmail($sanitizedData, $serviceRequest->id);
            } catch (\Exception $e) {
                Log::error('Failed to send notification email: '.$e->getMessage());
                // Don't fail the request if email fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you! We will contact you soon to discuss your lawn care needs.',
            ]);

        } catch (\Exception $e) {
            Log::error('Service request error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.',
            ], 500);
        }
    }

    /**
     * Send notification email to admin
     */
    private function sendNotificationEmail($data, $requestId = null)
    {
        // You can implement email sending here
        // This is a placeholder for the email functionality

        $subject = 'New Service Request #'.$requestId.' - '.$data['first_name'].' '.$data['last_name'];
        $message = "New lawn care service request:\n\n";
        $message .= "Request ID: #{$requestId}\n";
        $message .= "Name: {$data['first_name']} {$data['last_name']}\n";
        $message .= "Address: {$data['address']}\n";
        $message .= "City: {$data['city']}, {$data['state']} {$data['zip']}\n";
        $message .= "Phone: {$data['phone']}\n";
        $message .= "Email: {$data['email']}\n";
        $message .= 'Submitted: '.now()->format('F j, Y g:i A');

        // Uncomment and configure when ready to send emails
        /*
        Mail::raw($message, function ($mail) use ($subject, $data) {
            $mail->to('admin@turfcrewalalabama.com')
                 ->subject($subject)
                 ->replyTo($data['email'], $data['first_name'] . ' ' . $data['last_name']);
        });
        */
    }
}
