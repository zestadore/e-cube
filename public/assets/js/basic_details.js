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