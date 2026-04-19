@extends('layouts.app')

@section('content')
    <section class="login-content container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Employer Registration</h4>
            </div>
            <div class="card-body">
                <form action="{{route('company.profile.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" 
                                title="Company Name" 
                                name="company_name" 
                                id="company_name" 
                                type="text" 
                                required="True" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('company_logo') ? 'is-invalid' : '' }}" 
                                title="Company Logo" 
                                name="company_logo" 
                                id="company_logo" 
                                type="file" required="False" />
                        </div>

                        <div class="col-md-12">
                            <x-InputBox class="form-control {{ $errors->has('company_address') ? 'is-invalid' : '' }}" 
                                title="Company Address" 
                                name="company_address" 
                                id="company_address" 
                                type="textarea" 
                                required="True" />
                        </div>

                        <div class="col-md-4">
                            <x-InputBox class="form-control {{ $errors->has('company_website') ? 'is-invalid' : '' }}" 
                                title="Company Website" 
                                name="company_website" 
                                id="company_website" 
                                type="url" required="false"/>
                        </div>

                        <div class="col-md-4">
                            <x-InputBox class="form-control {{ $errors->has('company_email') ? 'is-invalid' : '' }}" 
                                title="Company Email" 
                                name="company_email" 
                                id="company_email" 
                                type="email" 
                                required="True" />
                        </div>

                        <div class="col-md-4">
                            <x-InputBox class="form-control {{ $errors->has('company_phone') ? 'is-invalid' : '' }}" 
                                title="Company Phone" 
                                name="company_phone" 
                                id="company_phone" 
                                type="number" 
                                required="True" />
                        </div>

                        <div class="col-md-12">
                            <x-InputBox class="form-control {{ $errors->has('company_description') ? 'is-invalid' : '' }}" 
                                title="Company Description" 
                                name="company_description" 
                                id="company_description" 
                                type="textarea" 
                                required="false" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('date_of_establishment') ? 'is-invalid' : '' }}" 
                                title="Establishment Date" 
                                name="date_of_establishment" 
                                id="date_of_establishment" 
                                type="date" required="true" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('gst_number') ? 'is-invalid' : '' }}" 
                                title="GST Number" 
                                name="gst_number" 
                                id="gst_number" 
                                type="text" required="false" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('pan_number') ? 'is-invalid' : '' }}" 
                                title="PAN Number" 
                                name="pan_number" 
                                id="pan_number" 
                                type="text" required="false" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('chairman_name') ? 'is-invalid' : '' }}" 
                                title="Chairman Name" 
                                name="chairman_name" 
                                id="chairman_name" 
                                type="text" required="true" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('chairman_contact') ? 'is-invalid' : '' }}" 
                                title="Chairman Contact" 
                                name="chairman_contact" 
                                id="chairman_contact" 
                                type="number" required="true" />
                        </div>

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('hr_name') ? 'is-invalid' : '' }}" 
                                title="HR Name" 
                                name="hr_name" 
                                id="hr_name" 
                                type="text" 
                                required="True" />
                        </div>

                        <div class="col-md-4">
                            <x-InputBox class="form-control {{ $errors->has('hr_contact') ? 'is-invalid' : '' }}" 
                                title="HR Contact" 
                                name="hr_contact" 
                                id="hr_contact" 
                                type="number" 
                                required="True" />
                        </div>

                        <div class="col-md-4">
                            <label for="registration_type">Registration Type</label><span style="color:red;"> *</span>
                            <select class="form-select {{ $errors->has('registration_type') ? 'is-invalid' : '' }}" 
                                name="registration_type" 
                                id="registration_type" 
                                required>
                                <option value="pvt_ltd">Private Ltd</option>
                                <option value="public_ltd">Public Ltd</option>
                                <option value="others">Others</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <x-InputBox class="form-control {{ $errors->has('no_of_employees') ? 'is-invalid' : '' }}" 
                                title="Number of Employees" 
                                name="no_of_employees" 
                                id="no_of_employees" 
                                type="number" 
                                min="1" required="False" />
                        </div>

                        <div class="col-md-6">
                            <label for="industry_selection">Industry</label><span style="color:red;"> *</span>
                            <div class="input-group">
                                <input type="hidden" name="industry_id" id="industry_id" value="{{ $profile->industry_id ?? 0 }}">
                                <input type="text" 
                                    class="form-control {{ $profile && $profile->industry_id ? 'bg-light' : '' }} {{ $errors->has('industry_id') ? 'is-invalid' : '' }}" 
                                    id="industry_display" 
                                    value="{{ $profile && $profile->industry_id ? $profile->industry->industry_name : 'No industry selected' }}" 
                                    readonly 
                                    style="{{ $profile && $profile->industry_id ? 'cursor: not-allowed;' : '' }}">
                                
                                @if($profile && $profile->industry_id)
                                    {{-- Industry already selected - show locked icon --}}
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                @else
                                    {{-- No industry selected yet - show select button --}}
                                    <button type="button" class="btn btn-outline-primary" id="selectIndustryBtn">
                                        Select Industry
                                    </button>
                                @endif
                            </div>
                            @if($errors->has('industry_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('industry_id') }}
                                </div>
                            @endif
                            
                            @if($profile && $profile->industry_id)
                                <small class="text-muted">Industry cannot be changed after registration. Contact admin for changes.</small>
                            @else
                                <small class="text-muted">Please select an industry to complete registration.</small>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" style="float:right;" id="submitBtn" disabled>Submit</button>
                </form>
            </div>
        </div>
        
    </section>
@endsection
@section('scripts')
    <script>
        // Form field selectors for saving/restoring (excluding industry fields)
        const formFields = [
            '#company_name',
            '#company_address',
            '#company_website',
            '#company_email',
            '#company_phone',
            '#company_description',
            '#date_of_establishment',
            '#gst_number',
            '#pan_number',
            '#chairman_name',
            '#chairman_contact',
            '#hr_name',
            '#hr_contact',
            '#registration_type',
            '#no_of_employees'
        ];
        
        // Industry fields that should NOT be saved to localStorage
        // (they should always come from server)
        const industryFields = ['#industry_id', '#industry_display'];

        // Save form data to localStorage
        function saveFormData() {
            let formData = {};
            formFields.forEach(function(field) {
                let $field = $(field);
                if ($field.length) {
                    formData[field] = $field.val();
                }
            });
            localStorage.setItem('employerFormData', JSON.stringify(formData));
            localStorage.setItem('employerFormDataTimestamp', new Date().getTime().toString());
        }

        // Restore form data from localStorage
        function restoreFormData() {
            let savedData = localStorage.getItem('employerFormData');
            if (savedData) {
                let formData = JSON.parse(savedData);
                Object.keys(formData).forEach(function(field) {
                    let $field = $(field);
                    if ($field.length) {
                        // Restore the value (even if empty string)
                        $field.val(formData[field]);
                    }
                });
                return true; // Data was restored
            }
            return false; // No data to restore
        }

        // Clear saved form data
        function clearFormData() {
            localStorage.removeItem('employerFormData');
            localStorage.removeItem('employerFormDataTimestamp');
        }

        function getProfile() {
            let profile = {!! json_encode($profile) !!};
            
            // First try to restore saved form data (from localStorage - user returning from industry selection)
            // This restores all form fields EXCEPT industry fields
            let restored = restoreFormData();
            
            // If no saved data was restored, populate non-industry fields from profile (fresh page load)
            if (!restored && profile) {
                $('#company_name').val(profile.company_name || '');
                $('#company_address').val(profile.company_address || '');
                $('#company_phone').val(profile.company_phone || '');
                $('#company_email').val(profile.company_email || '');
                $('#company_website').val(profile.company_website || '');
                $('#company_description').val(profile.company_description || '');
                $('#date_of_establishment').val(profile.date_of_establishment || '');
                $('#gst_number').val(profile.gst_number || '');
                $('#pan_number').val(profile.pan_number || '');
                $('#chairman_name').val(profile.chairman_name || '');
                $('#chairman_contact').val(profile.chairman_contact || '');
                $('#hr_name').val(profile.hr_name || '');
                $('#hr_contact').val(profile.hr_contact || '');
                $('#registration_type').val(profile.registration_type || 'pvt_ltd');
                $('#no_of_employees').val(profile.no_of_employees || '');
            }
            
            // ALWAYS load industry fields from server (profile), never from localStorage
            // This ensures newly selected industry is always displayed
            if (profile) {
                if (profile.industry_id && profile.industry_id !== 0) {
                    $('#industry_id').val(profile.industry_id);
                    if (profile.industry) {
                        $('#industry_display').val(profile.industry.industry_name);
                    }
                } else {
                    $('#industry_id').val('0');
                    $('#industry_display').val('No industry selected');
                }
            }
        }

        // Function to check if industry is selected and update submit button state
        function updateSubmitButtonState() {
            let industryId = $('#industry_id').val();
            // Enable submit button only if industry_id is set and not 0 or empty
            if (industryId && industryId !== '0' && industryId !== '') {
                $('#submitBtn').prop('disabled', false);
            } else {
                $('#submitBtn').prop('disabled', true);
            }
        }

        $(document).ready(function() {
            // Clear old stale data (older than 1 hour) BEFORE attempting to restore
            // This prevents showing very old unsaved form data
            let savedTimestamp = localStorage.getItem('employerFormDataTimestamp');
            if (savedTimestamp) {
                let now = new Date().getTime();
                if ((now - parseInt(savedTimestamp)) > 3600000) { // 1 hour = 3600000 ms
                    clearFormData();
                }
            }
            
            // Now get profile and restore data if available
            // Note: Industry fields are ALWAYS loaded from server (in getProfile)
            // Form fields are restored from localStorage if available
            getProfile();

            // Check and update submit button state after loading profile
            updateSubmitButtonState();

            // Handle Select Industry button click
            $('#selectIndustryBtn').on('click', function() {
                // Save current form data before navigating
                saveFormData();
                // Navigate to industry selection page
                window.location.href = '{{ route("employer.select_industry") }}';
            });

            // Clear saved data when form is submitted successfully
            $('form').on('submit', function() {
                clearFormData();
            });
        });
    </script>
@endsection
