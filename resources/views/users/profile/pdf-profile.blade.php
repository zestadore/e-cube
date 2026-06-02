<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profile - {{ $user->full_name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4e73df;
        }
        .header h1 {
            color: #4e73df;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4e73df;
            margin-bottom: 15px;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 8px 12px;
            border: 1px solid #e3e6f0;
            vertical-align: top;
        }
        .info-table td:first-child {
            background: #f8f9fc;
            font-weight: bold;
            width: 30%;
            color: #4e73df;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table th, .table td {
            border: 1px solid #e3e6f0;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background: #4e73df;
            color: white;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background: #f8f9fc;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #1cc88a;
            color: white;
            border-radius: 15px;
            font-size: 10px;
            margin: 2px;
        }
        .signature-section {
            margin-top: 40px;
            text-align: center;
        }
        .signature-img {
            max-width: 200px;
            max-height: 80px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e3e6f0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .two-column {
            display: flex;
            gap: 20px;
        }
        .column {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($user->image_path)
            <img src="{{ public_path('storage/' . str_replace('storage/', '', $user->image_path)) }}" class="profile-photo" alt="Profile Photo">
        @else
            <div style="width: 120px; height: 120px; border-radius: 50%; background: #4e73df; color: white; display: inline-flex; align-items: center; justify-content: center; font-size: 40px; margin-bottom: 15px;">
                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
            </div>
        @endif
        <h1>{{ $user->full_name }}</h1>
        <p><strong>Email:</strong> {{ $user->email }} | <strong>Mobile:</strong> {{ $user->mobile }}</p>
        @if($user->basics?->profession)
            <p><strong>Profession:</strong> {{ $user->basics->profession }}</p>
        @endif
    </div>

    <!-- Basic Information -->
    <div class="section">
        <div class="section-title">Basic Information</div>
        <table class="info-table">
            <tr>
                <td>Date of Birth</td>
                <td>{{ $user->basics?->dob ? \Carbon\Carbon::parse($user->basics->dob)->format('d M Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>{{ $user->basics?->gender ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Marital Status</td>
                <td>{{ $user->basics?->marital_status ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Aadhar Number</td>
                <td>{{ $user->basics?->aadhar_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>PAN Number</td>
                <td>{{ $user->basics?->pan_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Passport Number</td>
                <td>{{ $user->basics?->passport_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Experience Level</td>
                <td>{{ $user->basics?->experience ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Job Type</td>
                <td>{{ $user->basics?->Job_type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Differently Abled</td>
                <td>{{ $user->basics?->differently_abled ?? 'No' }}</td>
            </tr>
        </table>
    </div>

    <!-- Contact Information -->
    <div class="section">
        <div class="section-title">Contact Information</div>
        <table class="info-table">
            <tr>
                <td>Primary Email</td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td>Primary Mobile</td>
                <td>{{ $user->mobile }}</td>
            </tr>
            <tr>
                <td>Alternate Email</td>
                <td>{{ $user->basics?->alternate_email_id ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Alternate Mobile</td>
                <td>{{ $user->basics?->alternate_mobile_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>WhatsApp Number</td>
                <td>{{ $user->basics?->whatsapp_number ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Addresses -->
    <div class="section">
        <div class="section-title">Address Details</div>
        <table class="info-table">
            <tr>
                <td>Present Address</td>
                <td>
                    @if($user->presentAddress)
                        {{ $user->presentAddress->address_1 }} {{ $user->presentAddress->address_2 }}<br>
                        {{ $user->presentAddress->city }}, {{ $user->presentAddress->state }} - {{ $user->presentAddress->zip }}<br>
                        {{ $user->presentAddress->country }}<br>
                        <strong>Police Station:</strong> {{ $user->presentAddress->police_station ?? 'N/A' }}<br>
                        <strong>Panchayat/Municipality:</strong> {{ $user->presentAddress->panchayat_municipality ?? 'N/A' }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <td>Permanent Address</td>
                <td>
                    @if($user->permanentAddress)
                        {{ $user->permanentAddress->address_1 }} {{ $user->permanentAddress->address_2 }}<br>
                        {{ $user->permanentAddress->city }}, {{ $user->permanentAddress->state }} - {{ $user->permanentAddress->zip }}<br>
                        {{ $user->permanentAddress->country }}<br>
                        <strong>Police Station:</strong> {{ $user->permanentAddress->police_station ?? 'N/A' }}<br>
                        <strong>Panchayat/Municipality:</strong> {{ $user->permanentAddress->panchayat_municipality ?? 'N/A' }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Qualifications -->
    @if($user->qualifications->isNotEmpty())
    <div class="section">
        <div class="section-title">Educational Qualifications</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Qualification</th>
                    <th>University/Institution</th>
                    <th>Duration</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->qualifications as $qual)
                <tr>
                    <td>
                        @php
                            $qualParts = [];
                            if($qual->level1Qualification) $qualParts[] = $qual->level1Qualification->degree;
                            if($qual->level2Qualification) $qualParts[] = $qual->level2Qualification->degree;
                            if($qual->level3Qualification) $qualParts[] = $qual->level3Qualification->degree;
                            if($qual->qualification) $qualParts[] = $qual->qualification->degree;
                            $qualDisplay = !empty($qualParts) ? implode(' -> ', $qualParts) : 'N/A';
                        @endphp
                        {{ $qualDisplay }}
                    </td>
                    <td>{{ $qual->university ?? 'N/A' }}</td>
                    <td>{{ $qual->from_year }} - {{ $qual->to_year }}</td>
                    <td>{{ $qual->percentage ? $qual->percentage . '%' : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Experience -->
    @if($user->experiences->isNotEmpty())
    <div class="section">
        <div class="section-title">Work Experience</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Duration</th>
                    <th>Current Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->experiences as $exp)
                <tr>
                    <td>{{ $exp->company ?? 'N/A' }}</td>
                    <td>
                        @php
                            $industryParts = [];
                            if($exp->industry) $industryParts[] = $exp->industry->industry_name;
                            if($exp->industryLevel2) $industryParts[] = $exp->industryLevel2->industry_name;
                            if($exp->industryLevel3) $industryParts[] = $exp->industryLevel3->industry_name;
                            $industryDisplay = !empty($industryParts) ? implode(' -> ', $industryParts) : 'N/A';
                        @endphp
                        {{ $industryDisplay }}
                    </td>
                    <td>{{ $exp->from_year }} - {{ $exp->to_year ?? 'Present' }}<br>{{ $exp->duration ?? '' }}</td>
                    <td>{{ $exp->is_current ? 'Current Job' : 'Previous' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Skills -->
    @if($user->skills->isNotEmpty())
    <div class="section">
        <div class="section-title">Skills & Expertise</div>
        @php
            $groupedSkills = $user->skills->groupBy(function($item) {
                return $item->skill->industry_id ?? 'unknown';
            });
        @endphp
        
        @foreach($groupedSkills as $roleId => $skills)
            <div style="margin-bottom: 15px;">
                <h4 style="color: #4e73df; font-size: 12px; margin-bottom: 8px;">
                    <strong>{{ $skills->first()->skill->industry->industry_name ?? 'Unknown Role' }}</strong>
                    @if($skills->first()->proficiency)
                        <span style="background: #1cc88a; color: white; padding: 2px 8px; border-radius: 10px; font-size: 10px; margin-left: 10px;">{{ $skills->first()->proficiency }}</span>
                    @endif
                </h4>
                <div>
                    @foreach($skills as $skill)
                        <span class="badge">{{ $skill->skill->skill ?? 'Unknown' }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @endif

    <!-- Hobbies -->
    @if($user->candidateHobby)
    <div class="section">
        <div class="section-title">Hobbies & Interests</div>
        @if($user->candidateHobby->description)
            <div style="margin-bottom: 10px;">{!! $user->candidateHobby->description !!}</div>
        @endif
        @if($user->candidateHobby->interests)
            <div>
                @foreach(explode(',', $user->candidateHobby->interests) as $interest)
                    <span class="badge" style="background: #e74a3b;">{{ trim($interest) }}</span>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    <!-- Digital Signature -->
    @if($user->signature_image)
    <div class="signature-section">
        <div class="section-title">Digital Signature</div>
        <img src="{{ public_path('storage/' . str_replace('storage/', '', $user->signature_image)) }}" class="signature-img" alt="Digital Signature">
    </div>
    @endif

    <div class="footer">
        <p>This profile was generated on {{ date('d M Y') }} from E-Cube Careers Portal</p>
        <p>For more information, please visit www.ecubecareers.com</p>
    </div>
</body>
</html>