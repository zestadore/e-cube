@php
    $qualifications = \App\Models\Qualification::whereDoesntHave('parents')->get();
    $skillsList = \App\Models\ComputerAndOtherSkill::get();
    $industries = \App\Models\Industry::get();
    $hobbiesData = \App\Models\CandidateHobby::where('user_id', Auth::id())->first();
@endphp

<!-- Basic Information Modal -->
<div class="modal fade" id="editBasicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Edit Basic Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBasicForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="dob" value="{{Auth::user()->basics->dob ?? ''}}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender <span class="text-danger">*</span></label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male" {{(Auth::user()->basics->gender ?? '') == 'Male' ? 'selected' : ''}}>Male</option>
                                <option value="Female" {{(Auth::user()->basics->gender ?? '') == 'Female' ? 'selected' : ''}}>Female</option>
                                <option value="Other" {{(Auth::user()->basics->gender ?? '') == 'Other' ? 'selected' : ''}}>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Aadhar Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="aadhar_number" value="{{Auth::user()->basics->aadhar_number ?? ''}}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">PAN Number</label>
                            <input type="text" class="form-control" name="pan_number" value="{{Auth::user()->basics->pan_number ?? ''}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Passport Number</label>
                            <input type="text" class="form-control" name="passport_number" value="{{Auth::user()->basics->passport_number ?? ''}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profession</label>
                            <input type="text" class="form-control" name="profession" value="{{Auth::user()->basics->profession ?? ''}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Experience Level <span class="text-danger">*</span></label>
                            <select class="form-select" name="experience" required>
                                <option value="Fresher" {{(Auth::user()->basics->experience ?? '') == 'Fresher' ? 'selected' : ''}}>Fresher</option>
                                <option value="Experienced" {{(Auth::user()->basics->experience ?? '') == 'Experienced' ? 'selected' : ''}}>Experienced</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Job Type <span class="text-danger">*</span></label>
                            <select class="form-select" name="Job_type" required>
                                <option value="Part Time" {{(Auth::user()->basics->Job_type ?? '') == 'Part Time' ? 'selected' : ''}}>Part Time</option>
                                <option value="Permanent" {{(Auth::user()->basics->Job_type ?? '') == 'Permanent' ? 'selected' : ''}}>Permanent</option>
                                <option value="Contract" {{(Auth::user()->basics->Job_type ?? '') == 'Contract' ? 'selected' : ''}}>Contract</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Differently Abled? <span class="text-danger">*</span></label>
                            <select class="form-select" name="differently_abled" required>
                                <option value="No" {{(Auth::user()->basics->differently_abled ?? '') == 'No' ? 'selected' : ''}}>No</option>
                                <option value="Yes" {{(Auth::user()->basics->differently_abled ?? '') == 'Yes' ? 'selected' : ''}}>Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alternate Mobile Number</label>
                            <input type="text" class="form-control" name="alternate_mobile_number" value="{{Auth::user()->basics->alternate_mobile_number ?? ''}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">WhatsApp Number</label>
                            <input type="text" class="form-control" name="whatsapp_number" value="{{Auth::user()->basics->whatsapp_number ?? ''}}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alternate Email</label>
                            <input type="email" class="form-control" name="alternate_email_id" value="{{Auth::user()->basics->alternate_email_id ?? ''}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveBasicInfo()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-map-marker-alt me-2"></i>Edit Addresses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm">
                    @csrf
                    <div class="row">
                        <!-- Permanent Address -->
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="fas fa-home me-2"></i>Permanent Address</h6>
                            <div class="mb-3">
                                <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="permanent_address_1" value="{{Auth::user()->permanentAddress->address_1 ?? ''}}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" name="permanent_address_2" value="{{Auth::user()->permanentAddress->address_2 ?? ''}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Landmark</label>
                                <input type="text" class="form-control" name="permanent_landmark" value="{{Auth::user()->permanentAddress->landmark ?? ''}}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_city" value="{{Auth::user()->permanentAddress->city ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_state" value="{{Auth::user()->permanentAddress->state ?? ''}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_zip" value="{{Auth::user()->permanentAddress->zip ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="permanent_country" value="{{Auth::user()->permanentAddress->country ?? 'India'}}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="permanent_police_station" value="{{Auth::user()->permanentAddress->police_station ?? ''}}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="permanent_panchayat_municipality" value="{{Auth::user()->permanentAddress->panchayat_municipality ?? ''}}" required>
                            </div>
                        </div>

                        <!-- Present Address -->
                        <div class="col-md-6">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="same_as_permanent_edit" onchange="copyPermanentToPresent()">
                                <label class="form-check-label" for="same_as_permanent_edit">
                                    Same as Permanent Address
                                </label>
                            </div>
                            <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Present Address</h6>
                            <div class="mb-3">
                                <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="present_address_1" id="edit_present_address_1" value="{{Auth::user()->presentAddress->address_1 ?? ''}}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address Line 2</label>
                                <input type="text" class="form-control" name="present_address_2" id="edit_present_address_2" value="{{Auth::user()->presentAddress->address_2 ?? ''}}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Landmark</label>
                                <input type="text" class="form-control" name="present_landmark" id="edit_present_landmark" value="{{Auth::user()->presentAddress->landmark ?? ''}}">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_city" id="edit_present_city" value="{{Auth::user()->presentAddress->city ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_state" id="edit_present_state" value="{{Auth::user()->presentAddress->state ?? ''}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_zip" id="edit_present_zip" value="{{Auth::user()->presentAddress->zip ?? ''}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="present_country" id="edit_present_country" value="{{Auth::user()->presentAddress->country ?? 'India'}}" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Police Station <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="present_police_station" id="edit_present_police_station" value="{{Auth::user()->presentAddress->police_station ?? ''}}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Panchayat/Municipality <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="present_panchayat_municipality" id="edit_present_panchayat_municipality" value="{{Auth::user()->presentAddress->panchayat_municipality ?? ''}}" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveAddress()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="editEducationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-graduation-cap me-2"></i>Edit Education & Qualifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEducationForm" enctype="multipart/form-data">
                    @csrf
                    <div id="education-container">
                        @foreach(Auth::user()->qualifications as $index => $qual)
                        <div class="dynamic-entry education-entry" data-index="{{$index}}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Education #{{$index + 1}}</h6>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeEducationEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Education Level <span class="text-danger">*</span></label>
                                    <select class="form-select edu-level-1" name="education[{{$index}}][level_1]" required onchange="loadEditLevel2(this)">
                                        <option value="">Select Education Level</option>
                                        @foreach($qualifications as $mainQual)
                                            <option value="{{ $mainQual->id }}" {{$qual->level_1_qualification_id == $mainQual->id ? 'selected' : ''}}>{{ $mainQual->degree }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Intermediate Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select edu-level-2" name="education[{{$index}}][level_2]" required disabled onchange="loadEditLevel3(this)">
                                        <option value="{{$qual->level_2_qualification_id}}">{{$qual->level2Qualification->degree ?? 'Select Level 1 First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Specific Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select edu-level-3" name="education[{{$index}}][level_3]" required disabled onchange="loadEditLevel4(this)">
                                        <option value="{{$qual->level_3_qualification_id}}">{{$qual->level3Qualification->degree ?? 'Select Level 2 First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Stream <span class="text-danger">*</span></label>
                                    <select class="form-select edu-level-4" name="education[{{$index}}][qualification_id]" required disabled>
                                        <option value="{{$qual->qualification_id}}">{{$qual->qualification->degree ?? 'Select Level 3 First'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">University/Board <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="education[{{$index}}][university]" value="{{$qual->university}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="education[{{$index}}][institution]" value="{{$qual->institution}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">College (if applicable)</label>
                                    <input type="text" class="form-control" name="education[{{$index}}][college]" value="{{$qual->college}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">From Year <span class="text-danger">*</span></label>
                                    <select class="form-select" name="education[{{$index}}][from_year]" required>
                                        <option value="">Select</option>
                                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                            <option value="{{ $i }}" {{$qual->from_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">To Year <span class="text-danger">*</span></label>
                                    <select class="form-select" name="education[{{$index}}][to_year]" required>
                                        <option value="">Select</option>
                                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                            <option value="{{ $i }}" {{$qual->to_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Percentage</label>
                                    <input type="number" class="form-control" name="education[{{$index}}][percentage]" value="{{$qual->percentage}}" min="0" max="100" step="0.01">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-primary" onclick="addEducationEntry()">
                            <i class="fas fa-plus me-2"></i>Add Education
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveEducation()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Skills Modal -->
<div class="modal fade" id="editSkillsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-tools me-2"></i>Edit Skills & Expertise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSkillsForm" enctype="multipart/form-data">
                    @csrf
                    <div id="skills-container">
                        @foreach(Auth::user()->skills as $index => $skill)
                        <div class="dynamic-entry skill-entry" data-index="{{$index}}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Skill #{{$index + 1}}</h6>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSkillEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Skill <span class="text-danger">*</span></label>
                                    <select class="form-select" name="skills[{{$index}}][skill_id]" required>
                                        <option value="">Select Skill</option>
                                        @foreach($skillsList as $s)
                                            <option value="{{ $s->id }}" {{$skill->skill_id == $s->id ? 'selected' : ''}}>{{ $s->skill }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Proficiency <span class="text-danger">*</span></label>
                                    <select class="form-select" name="skills[{{$index}}][proficiency]" required>
                                        <option value="">Select</option>
                                        <option value="Beginner" {{$skill->proficiency == 'Beginner' ? 'selected' : ''}}>Beginner</option>
                                        <option value="Intermediate" {{$skill->proficiency == 'Intermediate' ? 'selected' : ''}}>Intermediate</option>
                                        <option value="Advanced" {{$skill->proficiency == 'Advanced' ? 'selected' : ''}}>Advanced</option>
                                        <option value="Expert" {{$skill->proficiency == 'Expert' ? 'selected' : ''}}>Expert</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Certificate (Optional)</label>
                                    <input type="file" class="form-control" name="skills[{{$index}}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($skill->certificate)
                                        <small class="text-muted">Current: <a href="{{$skill->certificate}}" target="_blank">View</a></small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-primary" onclick="addSkillEntry()">
                            <i class="fas fa-plus me-2"></i>Add Skill
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveSkills()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Experience Modal -->
<div class="modal fade" id="editExperienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-briefcase me-2"></i>Edit Work Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editExperienceForm" enctype="multipart/form-data">
                    @csrf
                    <div id="experience-container">
                        @foreach(Auth::user()->experiences as $index => $exp)
                        <div class="dynamic-entry experience-entry" data-index="{{$index}}">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Experience #{{$index + 1}}</h6>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeExperienceEntry(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Industry Category <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-1" name="experience[{{$index}}][industry_level_1]" required onchange="loadIndustryLevel2(this)">
                                        <option value="">Select Category</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}" {{$exp->industry_level_1 == $industry->id ? 'selected' : ''}}>{{ $industry->industry_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Industry Sector <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-2" name="experience[{{$index}}][industry_level_2]" required disabled onchange="loadIndustryLevel3(this)">
                                        <option value="{{$exp->industry_level_2}}">{{$exp->industryLevel2->industry_name ?? 'Select Category First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Industry Type <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-3" name="experience[{{$index}}][industry_level_3]" required disabled onchange="loadIndustryLevel4(this)">
                                        <option value="{{$exp->industry_level_3}}">{{$exp->industryLevel3->industry_name ?? 'Select Sector First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Area of Work <span class="text-danger">*</span></label>
                                    <select class="form-select exp-industry-4" name="experience[{{$index}}][industry_id]" required disabled>
                                        <option value="{{$exp->industry_id}}">{{$exp->industry->industry_name ?? 'Select Type First'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Job Category <span class="text-danger">*</span></label>
                                    <select class="form-select exp-role-1" name="experience[{{$index}}][role_level_1]" required onchange="loadRoleLevel2(this)">
                                        <option value="">Select Category</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->id }}" {{$exp->role_level_1 == $industry->id ? 'selected' : ''}}>{{ $industry->industry_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Job Sector <span class="text-danger">*</span></label>
                                    <select class="form-select exp-role-2" name="experience[{{$index}}][role_level_2]" required disabled onchange="loadRoleLevel3(this)">
                                        <option value="{{$exp->role_level_2}}">{{$exp->roleLevel2->industry_name ?? 'Select Category First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                                    <select class="form-select exp-role-3" name="experience[{{$index}}][role_level_3]" required disabled onchange="loadRoleLevel4(this)">
                                        <option value="{{$exp->role_level_3}}">{{$exp->roleLevel3->industry_name ?? 'Select Sector First'}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Job Role <span class="text-danger">*</span></label>
                                    <select class="form-select exp-role-4" name="experience[{{$index}}][role_id]" required disabled>
                                        @php
                                            $roleIds = json_decode($exp->role_ids ?? '[]', true);
                                            $selectedRoleId = $roleIds[0] ?? null;
                                        @endphp
                                        <option value="{{$selectedRoleId}}">{{$exp->roleLevel4->industry_name ?? 'Select Type First'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company/Institution Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="experience[{{$index}}][company]" value="{{$exp->company}}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Location</label>
                                    <input type="text" class="form-control" name="experience[{{$index}}][location]" value="{{$exp->location}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">From Year <span class="text-danger">*</span></label>
                                    <select class="form-select exp-from-year" name="experience[{{$index}}][from_year]" required onchange="calculateExpDuration(this)">
                                        <option value="">Select</option>
                                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                            <option value="{{ $i }}" {{$exp->from_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">To Year <span class="text-danger">*</span></label>
                                    <select class="form-select exp-to-year" name="experience[{{$index}}][to_year]" required onchange="calculateExpDuration(this)">
                                        <option value="">Select</option>
                                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                                            <option value="{{ $i }}" {{$exp->to_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                        @endfor
                                        <option value="current" {{$exp->to_year == null ? 'selected' : ''}}>Present</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Duration</label>
                                    <input type="text" class="form-control exp-duration" name="experience[{{$index}}][duration]" value="{{$exp->duration}}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Experience Certificate</label>
                                    <input type="file" class="form-control" name="experience[{{$index}}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($exp->certificate)
                                        <small class="text-muted">Current: <a href="{{$exp->certificate}}" target="_blank">View</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Key Responsibilities</label>
                                <textarea class="form-control" name="experience[{{$index}}][responsibilities]" rows="3">{{$exp->responsibilities}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Achievements</label>
                                <textarea class="form-control" name="experience[{{$index}}][achievements]" rows="2">{{$exp->achievements}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Present Salary (Annual)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="experience[{{$index}}][present_salary]" value="{{$exp->present_salary}}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expected Salary (Annual)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" class="form-control" name="experience[{{$index}}][expected_salary]" value="{{$exp->expected_salary}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-outline-success" onclick="addExperienceEntry()">
                            <i class="fas fa-plus me-2"></i>Add Experience
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveExperience()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Hobbies Modal -->
<div class="modal fade" id="editHobbiesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-heart me-2"></i>Edit Hobbies & Interests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editHobbiesForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Describe your hobbies and interests</label>
                        <textarea class="form-control" name="hobbies[description]" id="edit_hobbies_description" rows="4">{{$hobbiesData->description ?? ''}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Areas of Interest (comma separated)</label>
                        <input type="text" class="form-control" name="hobbies[interests]" id="edit_hobbies_interests" value="{{$hobbiesData->interests ?? ''}}" placeholder="e.g., Reading, Traveling, Photography, Sports">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveHobbies()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
// Copy permanent address to present address
function copyPermanentToPresent() {
    if (document.getElementById('same_as_permanent_edit').checked) {
        document.getElementById('edit_present_address_1').value = document.querySelector('input[name="permanent_address_1"]').value;
        document.getElementById('edit_present_address_2').value = document.querySelector('input[name="permanent_address_2"]').value;
        document.getElementById('edit_present_landmark').value = document.querySelector('input[name="permanent_landmark"]').value;
        document.getElementById('edit_present_city').value = document.querySelector('input[name="permanent_city"]').value;
        document.getElementById('edit_present_state').value = document.querySelector('input[name="permanent_state"]').value;
        document.getElementById('edit_present_zip').value = document.querySelector('input[name="permanent_zip"]').value;
        document.getElementById('edit_present_country').value = document.querySelector('input[name="permanent_country"]').value;
        document.getElementById('edit_present_police_station').value = document.querySelector('input[name="permanent_police_station"]').value;
        document.getElementById('edit_present_panchayat_municipality').value = document.querySelector('input[name="permanent_panchayat_municipality"]').value;
    }
}

// Save Basic Information
function saveBasicInfo() {
    const form = document.getElementById('editBasicForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-basic") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Basic information updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}

// Save Address
function saveAddress() {
    const form = document.getElementById('editAddressForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-address") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Addresses updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}

// ==================== EDUCATION FUNCTIONS ====================
let educationCount = {{Auth::user()->qualifications->count()}};

function addEducationEntry() {
    const template = `
        <div class="dynamic-entry education-entry" data-index="${educationCount}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Education #${educationCount + 1}</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeEducationEntry(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Education Level <span class="text-danger">*</span></label>
                    <select class="form-select edu-main-parent" name="education[${educationCount}][main_parent]" required onchange="loadEducationChildren(this)">
                        <option value="">Select Education Level</option>
                        @foreach($qualifications as $mainQual)
                            <option value="{{ $mainQual->id }}">{{ $mainQual->degree }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Specific Qualification <span class="text-danger">*</span></label>
                    <select class="form-select edu-qualification" name="education[${educationCount}][qualification_id]" required disabled>
                        <option value="">Select Education Level First</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">University/Board <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="education[${educationCount}][university]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Institution Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="education[${educationCount}][institution]" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">College (if applicable)</label>
                    <input type="text" class="form-control" name="education[${educationCount}][college]">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">From Year <span class="text-danger">*</span></label>
                    <select class="form-select" name="education[${educationCount}][from_year]" required>
                        <option value="">Select</option>
                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">To Year <span class="text-danger">*</span></label>
                    <select class="form-select" name="education[${educationCount}][to_year]" required>
                        <option value="">Select</option>
                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Percentage</label>
                    <input type="number" class="form-control" name="education[${educationCount}][percentage]" min="0" max="100" step="0.01">
                </div>
            </div>
        </div>
    `;
    const container = document.getElementById('education-container');
    const div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div.firstElementChild);
    educationCount++;
}

function removeEducationEntry(btn) {
    btn.closest('.education-entry').remove();
}

function loadEducationChildren(select) {
    const parentId = select.value;
    const entry = select.closest('.education-entry');
    const qualSelect = entry.querySelector('.edu-qualification');
    
    qualSelect.innerHTML = '<option value="">Loading...</option>';
    qualSelect.disabled = true;
    
    if (!parentId) {
        qualSelect.innerHTML = '<option value="">Select Education Level First</option>';
        return;
    }

    fetch(`/api/qualifications/${parentId}/all-children`)
        .then(res => res.json())
        .then(data => {
            qualSelect.innerHTML = '<option value="">Select Specific Qualification</option>';
            if (data.length > 0) {
                data.forEach(item => {
                    let prefix = '';
                    for (let i = 0; i < item.level; i++) {
                        prefix += '- ';
                    }
                    qualSelect.innerHTML += `<option value="${item.id}">${prefix}${item.name}</option>`;
                });
                qualSelect.disabled = false;
            } else {
                qualSelect.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                qualSelect.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading qualifications:', error);
            qualSelect.innerHTML = '<option value="">Error loading options</option>';
        });
}

// ==================== 4-LEVEL CASCADING DROPDOWN FUNCTIONS ====================
function loadEditLevel2(select) {
    const parentId = select.value;
    const entry = select.closest('.education-entry');
    const level2Select = entry.querySelector('.edu-level-2');
    const level3Select = entry.querySelector('.edu-level-3');
    const level4Select = entry.querySelector('.edu-level-4');
    
    // Reset level 2, 3 and 4
    level2Select.innerHTML = '<option value="">Select Level 1 First</option>';
    level3Select.innerHTML = '<option value="">Select Level 2 First</option>';
    level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
    level2Select.disabled = true;
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level2Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/qualifications/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level2Select.innerHTML = '<option value="">Select Intermediate Qualification</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level2Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level2Select.disabled = false;
            } else {
                // If no children at level 2, use level 1 itself as the final qualification
                level2Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level2Select.disabled = false;
                // Also enable level 3 and 4 with the same value
                level3Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading level 2 qualifications:', error);
            level2Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadEditLevel3(select) {
    const parentId = select.value;
    const entry = select.closest('.education-entry');
    const level3Select = entry.querySelector('.edu-level-3');
    const level4Select = entry.querySelector('.edu-level-4');
    
    // Reset level 3 and 4
    level3Select.innerHTML = '<option value="">Select Level 2 First</option>';
    level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level3Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/qualifications/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level3Select.innerHTML = '<option value="">Select Specific Qualification</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level3Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level3Select.disabled = false;
            } else {
                // If no children at level 3, use level 2 itself as the final qualification
                level3Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                // Also enable level 4 with the same value
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading level 3 qualifications:', error);
            level3Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadEditLevel4(select) {
    const parentId = select.value;
    const entry = select.closest('.education-entry');
    const level4Select = entry.querySelector('.edu-level-4');
    
    // Reset level 4
    level4Select.innerHTML = '<option value="">Select Level 3 First</option>';
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level4Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/qualifications/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level4Select.innerHTML = '<option value="">Select Stream</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level4Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level4Select.disabled = false;
            } else {
                // If no children at level 4, use level 3 itself as the final qualification
                level4Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading level 4 qualifications:', error);
            level4Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function saveEducation() {
    const form = document.getElementById('editEducationForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-education") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Education updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}

// ==================== SKILLS FUNCTIONS ====================
let skillCount = {{Auth::user()->skills->count()}};

function addSkillEntry() {
    const template = `
        <div class="dynamic-entry skill-entry" data-index="${skillCount}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Skill #${skillCount + 1}</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeSkillEntry(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label class="form-label">Skill <span class="text-danger">*</span></label>
                    <select class="form-select" name="skills[${skillCount}][skill_id]" required>
                        <option value="">Select Skill</option>
                        @foreach($skillsList as $s)
                            <option value="{{ $s->id }}">{{ $s->skill }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Proficiency <span class="text-danger">*</span></label>
                    <select class="form-select" name="skills[${skillCount}][proficiency]" required>
                        <option value="">Select</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Expert">Expert</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Certificate (Optional)</label>
                    <input type="file" class="form-control" name="skills[${skillCount}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
        </div>
    `;
    const container = document.getElementById('skills-container');
    const div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div.firstElementChild);
    skillCount++;
}

function removeSkillEntry(btn) {
    btn.closest('.skill-entry').remove();
}

function saveSkills() {
    const form = document.getElementById('editSkillsForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-skills") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Skills updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}

// ==================== EXPERIENCE FUNCTIONS ====================
let experienceCount = {{Auth::user()->experiences->count()}};

function addExperienceEntry() {
    const template = `
        <div class="dynamic-entry experience-entry" data-index="${experienceCount}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Experience #${experienceCount + 1}</h6>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeExperienceEntry(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Industry Category <span class="text-danger">*</span></label>
                    <select class="form-select exp-industry-1" name="experience[${experienceCount}][industry_level_1]" required onchange="loadIndustryLevel2(this)">
                        <option value="">Select Category</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Industry Sector <span class="text-danger">*</span></label>
                    <select class="form-select exp-industry-2" name="experience[${experienceCount}][industry_level_2]" required disabled onchange="loadIndustryLevel3(this)">
                        <option value="">Select Category First</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Industry Type <span class="text-danger">*</span></label>
                    <select class="form-select exp-industry-3" name="experience[${experienceCount}][industry_level_3]" required disabled onchange="loadIndustryLevel4(this)">
                        <option value="">Select Sector First</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Area of Work <span class="text-danger">*</span></label>
                    <select class="form-select exp-industry-4" name="experience[${experienceCount}][industry_id]" required disabled>
                        <option value="">Select Type First</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Job Category <span class="text-danger">*</span></label>
                    <select class="form-select exp-role-1" name="experience[${experienceCount}][role_level_1]" required onchange="loadRoleLevel2(this)">
                        <option value="">Select Category</option>
                        @foreach($industries as $industry)
                            <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Job Sector <span class="text-danger">*</span></label>
                    <select class="form-select exp-role-2" name="experience[${experienceCount}][role_level_2]" required disabled onchange="loadRoleLevel3(this)">
                        <option value="">Select Category First</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Job Type <span class="text-danger">*</span></label>
                    <select class="form-select exp-role-3" name="experience[${experienceCount}][role_level_3]" required disabled onchange="loadRoleLevel4(this)">
                        <option value="">Select Sector First</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Job Role <span class="text-danger">*</span></label>
                    <select class="form-select exp-role-4" name="experience[${experienceCount}][role_id]" required disabled>
                        <option value="">Select Type First</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Company/Institution Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][company]" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="experience[${experienceCount}][location]">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">From Year <span class="text-danger">*</span></label>
                    <select class="form-select exp-from-year" name="experience[${experienceCount}][from_year]" required onchange="calculateExpDuration(this)">
                        <option value="">Select</option>
                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">To Year <span class="text-danger">*</span></label>
                    <select class="form-select exp-to-year" name="experience[${experienceCount}][to_year]" required onchange="calculateExpDuration(this)">
                        <option value="">Select</option>
                        @for($i = date('Y'); $i >= date('Y')-50; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                        <option value="current">Present</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Duration</label>
                    <input type="text" class="form-control exp-duration" name="experience[${experienceCount}][duration]" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Experience Certificate</label>
                    <input type="file" class="form-control" name="experience[${experienceCount}][certificate]" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Key Responsibilities</label>
                <textarea class="form-control" name="experience[${experienceCount}][responsibilities]" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Achievements</label>
                <textarea class="form-control" name="experience[${experienceCount}][achievements]" rows="2"></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Present Salary (Annual)</label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" class="form-control" name="experience[${experienceCount}][present_salary]">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Expected Salary (Annual)</label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number" class="form-control" name="experience[${experienceCount}][expected_salary]">
                    </div>
                </div>
            </div>
        </div>
    `;
    const container = document.getElementById('experience-container');
    const div = document.createElement('div');
    div.innerHTML = template;
    container.appendChild(div.firstElementChild);
    experienceCount++;
}

function removeExperienceEntry(btn) {
    btn.closest('.experience-entry').remove();
}

// ==================== 4-LEVEL CASCADING INDUSTRY DROPDOWNS ====================
function loadIndustryLevel2(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level2Select = entry.querySelector('.exp-industry-2');
    const level3Select = entry.querySelector('.exp-industry-3');
    const level4Select = entry.querySelector('.exp-industry-4');
    
    // Reset level 2, 3 and 4
    level2Select.innerHTML = '<option value="">Select Category First</option>';
    level3Select.innerHTML = '<option value="">Select Sector First</option>';
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level2Select.disabled = true;
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level2Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level2Select.innerHTML = '<option value="">Select Industry Sector</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level2Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level2Select.disabled = false;
            } else {
                // If no children at level 2, use level 1 itself as the final selection
                level2Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level2Select.disabled = false;
                // Also enable level 3 and 4 with the same value
                level3Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading industry level 2:', error);
            level2Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadIndustryLevel3(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level3Select = entry.querySelector('.exp-industry-3');
    const level4Select = entry.querySelector('.exp-industry-4');
    
    // Reset level 3 and 4
    level3Select.innerHTML = '<option value="">Select Sector First</option>';
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level3Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level3Select.innerHTML = '<option value="">Select Industry Type</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level3Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level3Select.disabled = false;
            } else {
                // If no children at level 3, use level 2 itself as the final selection
                level3Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                // Also enable level 4 with the same value
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading industry level 3:', error);
            level3Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadIndustryLevel4(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level4Select = entry.querySelector('.exp-industry-4');
    
    // Reset level 4
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level4Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level4Select.innerHTML = '<option value="">Select Area of Work</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level4Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level4Select.disabled = false;
            } else {
                // If no children at level 4, use level 3 itself as the final selection
                level4Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading industry level 4:', error);
            level4Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

// ==================== 4-LEVEL CASCADING JOB ROLE DROPDOWNS ====================
function loadRoleLevel2(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level2Select = entry.querySelector('.exp-role-2');
    const level3Select = entry.querySelector('.exp-role-3');
    const level4Select = entry.querySelector('.exp-role-4');
    
    // Reset level 2, 3 and 4
    level2Select.innerHTML = '<option value="">Select Category First</option>';
    level3Select.innerHTML = '<option value="">Select Sector First</option>';
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level2Select.disabled = true;
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level2Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level2Select.innerHTML = '<option value="">Select Job Sector</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level2Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level2Select.disabled = false;
            } else {
                // If no children at level 2, use level 1 itself as the final selection
                level2Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level2Select.disabled = false;
                // Also enable level 3 and 4 with the same value
                level3Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading role level 2:', error);
            level2Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadRoleLevel3(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level3Select = entry.querySelector('.exp-role-3');
    const level4Select = entry.querySelector('.exp-role-4');
    
    // Reset level 3 and 4
    level3Select.innerHTML = '<option value="">Select Sector First</option>';
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level3Select.disabled = true;
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level3Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level3Select.innerHTML = '<option value="">Select Job Type</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level3Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level3Select.disabled = false;
            } else {
                // If no children at level 3, use level 2 itself as the final selection
                level3Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level3Select.disabled = false;
                // Also enable level 4 with the same value
                level4Select.innerHTML = `<option value="${parentId}" selected>${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading role level 3:', error);
            level3Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadRoleLevel4(select) {
    const parentId = select.value;
    const entry = select.closest('.experience-entry');
    const level4Select = entry.querySelector('.exp-role-4');
    
    // Reset level 4
    level4Select.innerHTML = '<option value="">Select Type First</option>';
    level4Select.disabled = true;
    
    if (!parentId) {
        return;
    }

    // Show loading
    level4Select.innerHTML = '<option value="">Loading...</option>';

    // AJAX call to get direct children only
    fetch(`/api/industries/${parentId}/children`)
        .then(res => res.json())
        .then(data => {
            level4Select.innerHTML = '<option value="">Select Job Role</option>';
            
            if (data.length > 0) {
                data.forEach(item => {
                    level4Select.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
                level4Select.disabled = false;
            } else {
                // If no children at level 4, use level 3 itself as the final selection
                level4Select.innerHTML = `<option value="${parentId}">${select.options[select.selectedIndex].text}</option>`;
                level4Select.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error loading role level 4:', error);
            level4Select.innerHTML = '<option value="">Error loading options</option>';
        });
}

function loadJobRoles(select) {
    const industryId = select.value;
    const entry = select.closest('.experience-entry');
    const rolesSelect = entry.querySelector('.exp-roles');
    
    rolesSelect.innerHTML = '<option value="">Loading...</option>';
    rolesSelect.disabled = true;
    
    if (!industryId) {
        rolesSelect.innerHTML = '<option value="">Select Industry First</option>';
        return;
    }

    fetch(`/api/industries/${industryId}/roles`)
        .then(res => res.json())
        .then(data => {
            rolesSelect.innerHTML = '';
            if (data.length > 0) {
                data.forEach(role => {
                    rolesSelect.innerHTML += `<option value="${role.id}">${role.name}</option>`;
                });
                rolesSelect.disabled = false;
            } else {
                rolesSelect.innerHTML = '<option value="">No roles available</option>';
            }
        })
        .catch(error => {
            console.error('Error loading roles:', error);
            rolesSelect.innerHTML = '<option value="">Error loading roles</option>';
        });
}

function calculateExpDuration(element) {
    const entry = element.closest('.experience-entry');
    const fromYear = entry.querySelector('.exp-from-year').value;
    const toYear = entry.querySelector('.exp-to-year').value;
    const durationField = entry.querySelector('.exp-duration');
    
    if (fromYear && toYear) {
        let endYear = toYear === 'current' ? new Date().getFullYear() : parseInt(toYear);
        let startYear = parseInt(fromYear);
        
        if (endYear >= startYear) {
            let years = endYear - startYear;
            durationField.value = years + (years === 1 ? ' year' : ' years');
        } else {
            durationField.value = '';
        }
    }
}

function saveExperience() {
    const form = document.getElementById('editExperienceForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-experience") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Experience updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}

// ==================== HOBBIES FUNCTIONS ====================
function saveHobbies() {
    const form = document.getElementById('editHobbiesForm');
    const formData = new FormData(form);
    
    fetch('{{ route("employee.update-hobbies") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Hobbies updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving');
    });
}
</script>