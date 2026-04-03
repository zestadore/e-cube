<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status - E-Cube Careers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .status-card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 90%;
        }
        .icon-success { color: #28a745; }
        .icon-error { color: #dc3545; }
        .icon-pending { color: #ffc107; }
        .icon-unknown { color: #6c757d; }
        .status-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        .btn-custom {
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="status-card">
        @if($status === 'success')
            <i class="fas fa-check-circle status-icon icon-success"></i>
            <h2 class="mb-3">Payment Successful!</h2>
            <p class="text-muted">{{ $message }}</p>
            <a href="/employer/find-talent" class="btn btn-success btn-custom">
                <i class="fas fa-search me-2"></i>Continue to Find Talent
            </a>
        @elseif($status === 'error')
            <i class="fas fa-times-circle status-icon icon-error"></i>
            <h2 class="mb-3">Payment Failed</h2>
            <p class="text-muted">{{ $message }}</p>
            <a href="/employer/find-talent" class="btn btn-outline-danger btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Back to Find Talent
            </a>
        @elseif($status === 'pending')
            <i class="fas fa-clock status-icon icon-pending"></i>
            <h2 class="mb-3">Payment Pending</h2>
            <p class="text-muted">{{ $message }}</p>
            <a href="/employer/find-talent" class="btn btn-warning btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Back to Find Talent
            </a>
        @else
            <i class="fas fa-question-circle status-icon icon-unknown"></i>
            <h2 class="mb-3">Payment Status Unknown</h2>
            <p class="text-muted">{{ $message }}</p>
            <a href="/employer/find-talent" class="btn btn-secondary btn-custom">
                <i class="fas fa-arrow-left me-2"></i>Back to Find Talent
            </a>
        @endif
        
        <div class="mt-4 pt-3 border-top">
            <p class="small text-muted mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Please login to continue if you are not already logged in.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>