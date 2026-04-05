@extends('layouts.app')

@section('styles')
<style>
    .guidelines-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .guideline-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
        margin-top: 30px;
    }
    .guideline-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .guideline-header i {
        font-size: 60px;
        color: #1cc88a;
        margin-bottom: 15px;
    }
    .guideline-header h2 {
        color: #333;
        font-weight: 600;
    }
    .guideline-section {
        margin-bottom: 30px;
        padding: 20px;
        background: #f8f9fc;
        border-radius: 10px;
        border-left: 4px solid #1cc88a;
    }
    .guideline-section h4 {
        color: #1cc88a;
        margin-bottom: 15px;
        font-weight: 600;
    }
    .guideline-section ul {
        padding-left: 20px;
    }
    .guideline-section ul li {
        margin-bottom: 10px;
        color: #555;
        line-height: 1.6;
    }
    .caution-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 10px;
        padding: 20px;
        margin: 20px 0;
    }
    .caution-box h5 {
        color: #856404;
        margin-bottom: 10px;
    }
    .caution-box ul {
        color: #856404;
    }
    .agreement-section {
        background: #e8f5e9;
        border: 2px solid #4caf50;
        border-radius: 10px;
        padding: 25px;
        margin-top: 30px;
    }
    .btn-agree {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        color: white;
        padding: 15px 50px;
        font-size: 18px;
        border-radius: 30px;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-agree:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.4);
        color: white;
    }
    .tip-box {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 15px 20px;
        border-radius: 0 10px 10px 0;
        margin: 20px 0;
    }
    .tip-box i {
        color: #2196f3;
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="container guidelines-container">
    <div class="guideline-card">
        <div class="guideline-header">
            <i class="fas fa-briefcase"></i>
            <h2>Work Experience – Instructions & Guidelines</h2>
            <p class="text-muted">Please provide accurate and complete details of your work experience</p>
        </div>

        <div class="guideline-section">
            <h4><i class="fas fa-info-circle me-2"></i>How to Fill Your Work Experience</h4>
            <ul>
                <li>Add your <strong>most recent or current job first</strong>, followed by previous roles in descending order.</li>
                <li>Include key details such as company name, location, duration (start and end dates), and key responsibilities.</li>
                <li>Select your Industry, Job roles, achievements, and skills gained in each position.</li>
            </ul>
        </div>

        <div class="guideline-section">
            <h4><i class="fas fa-clipboard-check me-2"></i>Important Guidelines</h4>
            <ul>
                <li>Ensure all information entered is <strong>true, accurate, and verifiable</strong>.</li>
                <li>Use clear and professional language when describing your responsibilities.</li>
                <li>Avoid gaps or overlaps in employment dates unless clearly explained.</li>
            </ul>
        </div>

        <div class="caution-box">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Caution & Responsibility</h5>
            <p>Providing false, misleading, or exaggerated work experience may result in:</p>
            <ul>
                <li>Rejection of job applications</li>
                <li>Suspension or removal of your profile</li>
                <li>Loss of trust and credibility with employers</li>
            </ul>
            <p class="mt-3 mb-0"><small>E Cube Careers serves as a platform connecting candidates with employers. The accuracy and authenticity of the work experience details provided are solely the responsibility of the candidate.</small></p>
        </div>

        <div class="tip-box">
            <i class="fas fa-lightbulb"></i>
            <strong>Tip:</strong> Highlighting relevant experience and achievements can significantly improve your chances of being shortlisted by employers.
        </div>

        <div class="agreement-section text-center">
            <form action="{{ route('experience.agree') }}" method="POST">
                @csrf
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="agreed" name="agreed" required style="transform: scale(1.5); margin-right: 10px;">
                    <label class="form-check-label" for="agreed" style="font-size: 16px; cursor: pointer;">
                        I have read and agree to the Work Experience Guidelines. I confirm that all work experience details I provide will be accurate and truthful.
                    </label>
                </div>
                @error('agreed')
                    <div class="text-danger mb-3">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-agree">
                    <i class="fas fa-check-circle me-2"></i>I AGREE
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add smooth scrolling and animation
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.guideline-section, .caution-box, .tip-box');
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            setTimeout(() => {
                section.style.transition = 'all 0.5s ease';
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection