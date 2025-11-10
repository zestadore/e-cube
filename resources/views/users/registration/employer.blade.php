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

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('hr_contact') ? 'is-invalid' : '' }}" 
                                title="HR Contact" 
                                name="hr_contact" 
                                id="hr_contact" 
                                type="number" 
                                required="True" />
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <x-InputBox class="form-control {{ $errors->has('no_of_employees') ? 'is-invalid' : '' }}" 
                                title="Number of Employees" 
                                name="no_of_employees" 
                                id="no_of_employees" 
                                type="number" 
                                min="1" required="False" />
                        </div>

                        <div class="col-md-6">
                            <label for="industry_id">Industry</label><span style="color:red;"> *</span>
                            <select class="form-select {{ $errors->has('industry_id') ? 'is-invalid' : '' }}" 
                                name="industry_id" 
                                id="industry_id" 
                                required>
                                @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->industry_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" style="float:right;">Submit</button>
                </form>
            </div>
        </div>
        
    </section>
@endsection
@section('scripts')
    <script>
        function getProfile() {
            let profile = {!! json_encode($profile) !!};
            $('#company_name').val(profile.company_name);
            $('#company_address').val(profile.company_address);
            $('#company_contact').val(profile.company_contact);
            $('#company_email').val(profile.company_email);
            $('#company_website').val(profile.company_website);
            $('#company_description').val(profile.company_description);
            $('#company_size').val(profile.company_size);
            $('#date_of_establishment').val(profile.date_of_establishment);
            $('#gst_number').val(profile.gst_number);
            $('#pan_number').val(profile.pan_number);
            $('#chairman_name').val(profile.chairman_name);
            $('#chairman_contact').val(profile.chairman_contact);
            $('#hr_name').val(profile.hr_name);
            $('#hr_contact').val(profile.hr_contact);
            $('#registration_type').val(profile.registration_type);
            $('#no_of_employees').val(profile.no_of_employees);
            $('#industry_id').val(profile.industry_id);
        }
        getProfile();
    </script>
@endsection