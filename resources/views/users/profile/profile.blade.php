@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <style>
        .profile-photo-container {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
        }
        .profile-photo-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #dee2e6;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .profile-photo-preview:hover {
            opacity: 0.8;
        }
        .change-photo-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            border: 3px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .change-photo-btn:hover {
            background: #0b5ed7;
            transform: scale(1.1);
        }
        /* Cropper Modal Styles - Fixed z-index issues */
        .modal {
            z-index: 99999 !important;
        }
        .modal-dialog {
            z-index: 100000 !important;
        }
        .modal-content {
            z-index: 100001 !important;
        }
        .modal-backdrop {
            z-index: 99998 !important;
        }
        /* Ensure body padding doesn't affect modal */
        body .modal-open {
            padding-right: 0 !important;
        }
        /* Fix for any fixed headers or sticky elements */
        header, .header, .navbar, .sticky-top, [class*="sticky"], [class*="fixed"] {
            z-index: 1000 !important;
        }
        .cropper-modal .modal-body {
            padding: 0;
        }
        .cropper-container {
            max-height: 500px;
            background: #f8f9fc;
        }
        .cropper-preview {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #e3e6f0;
            border-radius: 50%;
            margin: 0 auto;
        }
        #image-to-crop {
            max-width: 100%;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Profile</div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <p class="mb-0">{{ session('error') }}</p>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissable" role="alert">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        
                        <!-- Profile Photo Section -->
                        <div class="text-center mb-4">
                            <div class="profile-photo-container">
                                <img src="{{ Auth::user()->image ? asset('uploads/profiles/'.Auth::user()->image) : asset('assets/img/default-user.png') }}" 
                                     alt="Profile" class="profile-photo-preview" id="profile-image-preview">
                                <button type="button" class="change-photo-btn" onclick="openPhotoUpload()" title="Change Photo">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <p class="text-muted small">Click on the photo to change your profile picture</p>
                        </div>

                        <form action="{{route('profile.update')}}" method="post" id="addNewForm" enctype='multipart/form-data'>@csrf
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" title="First name" name="first_name" id="first_name" type="text" required="True"/>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" title="Last name" name="last_name" id="last_name" type="text" required="False"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-12 col-xs-12">
                                    <x-InputBox class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" title="Mobile" name="mobile" id="mobile" type="number" required="True"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info" style="float:right;">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Upload Modal -->
    <div class="modal fade cropper-modal" id="photoUploadModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-camera me-2"></i>Update Profile Photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Step 1: File Upload -->
                    <div id="upload-step" class="p-4">
                        <div class="text-center">
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt fa-4x text-primary"></i>
                            </div>
                            <h5>Upload Your Photo</h5>
                            <p class="text-muted">Select a clear photo of yourself. You can crop it in the next step.</p>
                            <input type="file" id="photo-input" accept="image/*" style="display: none;" onchange="handlePhotoSelect(this)">
                            <button type="button" class="btn btn-primary btn-lg" onclick="document.getElementById('photo-input').click()">
                                <i class="fas fa-folder-open me-2"></i>Choose Photo
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Crop Image -->
                    <div id="crop-step" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="cropper-container p-3">
                                    <img id="image-to-crop" src="" alt="Image to crop">
                                </div>
                            </div>
                            <div class="col-md-4 bg-light p-3">
                                <h6 class="mb-3">Preview</h6>
                                <div class="cropper-preview mb-3" id="cropper-preview"></div>
                                <p class="text-muted small mb-4">This is how your photo will appear on your profile.</p>
                                
                                <h6 class="mb-3">Adjust</h6>
                                <div class="btn-group-vertical w-100 mb-3">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="rotateImage(-90)">
                                        <i class="fas fa-undo me-2"></i>Rotate Left
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="rotateImage(90)">
                                        <i class="fas fa-redo me-2"></i>Rotate Right
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetCropper()">
                                        <i class="fas fa-sync-alt me-2"></i>Reset
                                    </button>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" onclick="saveCroppedPhoto()">
                                        <i class="fas fa-check me-2"></i>Save Photo
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="goBackToUpload()">
                                        <i class="fas fa-arrow-left me-2"></i>Choose Different Photo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Loading State -->
                    <div id="upload-loading" style="display: none;" class="p-5 text-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted">Uploading your photo...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
        <!-- jquery-validation -->
        <script src="{{asset('assets/admin/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/admin/plugins/jquery-validation/additional-methods.min.js')}}"></script>
        <!-- Cropper.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        <script>
             $(function () {
                $('#addNewForm').validate({
                    rules: {
                        first_name: {
                            required: true
                        },
                        email: {
                            required: true
                        },
                        mobile: {
                            required: true
                        },
                    },
                    messages: {
                        first_name: {
                            required: "Please enter the first name."
                        },
                        email: {
                            required: "Please enter your email id."
                        },
                        mobile: {
                            required: "Please enter your mobile number."
                        },
                    },
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                    }
                });
            });

            function prefillForm(){
                $('#first_name').val('{{Auth::user()->first_name}}');
                $('#last_name').val('{{Auth::user()->last_name}}');
                $('#email').val('{{Auth::user()->email}}');
                $('#mobile').val('{{Auth::user()->mobile}}');
            }
            prefillForm();
            $("#email").prop("readonly", true);

            // Profile Photo Cropping Functionality
            let cropper = null;
            let photoModal = null;
            
            // Initialize modal
            document.addEventListener('DOMContentLoaded', function() {
                photoModal = new bootstrap.Modal(document.getElementById('photoUploadModal'));
            });
            
            function openPhotoUpload() {
                // Reset modal state
                document.getElementById('upload-step').style.display = 'block';
                document.getElementById('crop-step').style.display = 'none';
                document.getElementById('upload-loading').style.display = 'none';
                document.getElementById('photo-input').value = '';
                
                // Destroy existing cropper
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                
                photoModal.show();
            }
            
            function handlePhotoSelect(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        return;
                    }
                    
                    // Validate file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size should not exceed 5MB.');
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Show crop step
                        document.getElementById('upload-step').style.display = 'none';
                        document.getElementById('crop-step').style.display = 'block';
                        
                        // Set image source
                        const image = document.getElementById('image-to-crop');
                        image.src = e.target.result;
                        
                        // Initialize cropper
                        initCropper();
                    };
                    reader.readAsDataURL(file);
                }
            }
            
            function initCropper() {
                const image = document.getElementById('image-to-crop');
                
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Square aspect ratio for profile picture
                    viewMode: 1,
                    preview: '#cropper-preview',
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            }
            
            function rotateImage(degree) {
                if (cropper) {
                    cropper.rotate(degree);
                }
            }
            
            function resetCropper() {
                if (cropper) {
                    cropper.reset();
                }
            }
            
            function goBackToUpload() {
                document.getElementById('upload-step').style.display = 'block';
                document.getElementById('crop-step').style.display = 'none';
                document.getElementById('photo-input').value = '';
                
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            }
            
            function saveCroppedPhoto() {
                if (!cropper) return;
                
                // Show loading
                document.getElementById('crop-step').style.display = 'none';
                document.getElementById('upload-loading').style.display = 'block';
                
                // Get cropped canvas
                const canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                // Convert to blob
                canvas.toBlob(function(blob) {
                    const formData = new FormData();
                    formData.append('profile_photo', blob, 'profile-photo.jpg');
                    formData.append('_token', '{{ csrf_token() }}');
                    
                    // Upload via AJAX
                    fetch('{{ route("employee.update-profile-photo") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update profile image on page
                            document.getElementById('profile-image-preview').src = data.image_url + '?t=' + new Date().getTime();
                            
                            // Close modal
                            photoModal.hide();
                            
                            // Show success message
                            alert('Profile photo updated successfully!');
                        } else {
                            alert('Error: ' + (data.message || 'Failed to upload photo'));
                            document.getElementById('upload-loading').style.display = 'none';
                            document.getElementById('crop-step').style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while uploading the photo. Please try again.');
                        document.getElementById('upload-loading').style.display = 'none';
                        document.getElementById('crop-step').style.display = 'block';
                    });
                }, 'image/jpeg', 0.9);
            }
        </script>
    @endsection