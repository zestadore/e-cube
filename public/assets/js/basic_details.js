function updateBasicDetails(dob,
    gender,
    alternate_mobile_number,
    alternate_email,
    whatsapp_number,
    aadhar_number,
    pan_number,
    passport_number,
    profession,
    experience,
    job_type,
    differently_abled,
    url,token) 
{
    return $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: token,
            dob:dob,
            gender:gender,
            alternate_mobile_number:alternate_mobile_number,
            alternate_email:alternate_email,
            whatsapp_number:whatsapp_number,
            aadhar_number:aadhar_number,
            pan_number:pan_number,
            passport_number:passport_number,
            profession:profession,
            experience:experience,
            Job_type:job_type,
            differently_abled:differently_abled,
        }
    })
}

function prefillBasicDetails(dob,
    gender,
    alternate_mobile_number,
    alternate_email,
    whatsapp_number,
    aadhar_number,
    pan_number,
    passport_number,
    profession,
    experience,
    job_type,
    differently_abled) {
    $('#dob').val(dob);
    $('#gender').val(gender);
    $('#alternate_mobile_number').val(alternate_mobile_number);
    $('#alternate_email').val(alternate_email);
    $('#whatsapp_number').val(whatsapp_number);
    $('#aadhar_number').val(aadhar_number);
    $('#pan_number').val(pan_number);
    $('#passport_number').val(passport_number);
    $('#profession').val(profession);
    $('#experience').val(experience);
    $('#job_type').val(job_type);
    $('#differently_abled').val(differently_abled);
}