<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Request Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .details {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌱 Turf Crew Alabama</h1>
        <p>Thank you for your service request!</p>
    </div>
    
    <div class="content">
        <h2>Hi {{ $serviceRequest->first_name }},</h2>
        
        <p>We've received your lawn care service request and will contact you soon to discuss your needs and provide a free estimate.</p>
        
        <div class="details">
            <h3>Request Details:</h3>
            <div class="detail-row">
                <span class="label">Request ID:</span>
                <span>#{{ $serviceRequest->id }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Name:</span>
                <span>{{ $serviceRequest->first_name }} {{ $serviceRequest->last_name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Address:</span>
                <span>{{ $serviceRequest->address }}<br>{{ $serviceRequest->city }}, {{ $serviceRequest->state }} {{ $serviceRequest->zip }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span>{{ $serviceRequest->phone }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span>{{ $serviceRequest->email }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Submitted:</span>
                <span>{{ $serviceRequest->created_at->format('F j, Y g:i A') }}</span>
            </div>
        </div>
        
        <p><strong>What happens next?</strong></p>
        <ul>
            <li>We'll review your request within 24 hours</li>
            <li>One of our team members will contact you to discuss your lawn care needs</li>
            <li>We'll schedule a convenient time for a free estimate</li>
            <li>No contracts required - just quality service!</li>
        </ul>
        
        <p>If you have any questions or need to make changes to your request, please don't hesitate to contact us:</p>
        <p>📞 Phone: <strong>Available Soon</strong><br>
        📧 Email: <strong>beau@turfcrewal.com</strong></p>
    </div>
    
    <div class="footer">
        <p>This is an automated confirmation email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} Turf Crew Alabama - Professional Lawn Care Services</p>
    </div>
</body>
</html>