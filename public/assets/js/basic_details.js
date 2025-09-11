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

function updateAddressDetails(token,url) {
    let permanent_address_1 = $('#permanent_address_1').val();
    let permanent_address_2 = $('#permanent_address_2').val();
    let permanent_landmark = $('#permanent_landmark').val();
    let permanent_city = $('#permanent_city').val();
    let permanent_state = $('#permanent_state').val();
    let permanent_zip = $('#permanent_zip').val();
    let permanent_country = $('#permanent_country').val();
    let permanent_police_station = $('#permanent_police_station').val();
    let permanent_panchayat_municipality = $('#permanent_panchayat_municipality').val();
    let present_address_1 = $('#present_address_1').val();
    let present_address_2 = $('#present_address_2').val();
    let present_landmark = $('#present_landmark').val();
    let same_as_permanent = $('#same_as_permanent').is(':checked');
    let present_city = $('#present_city').val();
    let present_state = $('#present_state').val();
    let present_zip = $('#present_zip').val();
    let present_country = $('#present_country').val();
    let present_police_station = $('#present_police_station').val();
    let present_panchayat_municipality = $('#present_panchayat_municipality').val();
    if(same_as_permanent){
        present_address_1 = permanent_address_1;
        present_address_2 = permanent_address_2;
        present_landmark = permanent_landmark;
        present_city = permanent_city;
        present_state = permanent_state;
        present_zip = permanent_zip;
        present_country = permanent_country;
        present_police_station = permanent_police_station;
        present_panchayat_municipality = permanent_panchayat_municipality;
    }
    if(permanent_address_1 && permanent_city && permanent_state && permanent_zip && permanent_country && permanent_police_station && permanent_panchayat_municipality && present_address_1 && present_city && present_state && present_zip && present_country && present_police_station && present_panchayat_municipality){
        return $.ajax({
            url: url,
            type: "POST",
            data: {
                _token: token,
                permanent_address_1:permanent_address_1,
                permanent_address_2:permanent_address_2,
                permanent_landmark:permanent_landmark,
                permanent_city:permanent_city,
                permanent_state:permanent_state,
                permanent_zip:permanent_zip,
                permanent_country:permanent_country,
                permanent_police_station:permanent_police_station,
                permanent_panchayat_municipality:permanent_panchayat_municipality,
                present_address_1:present_address_1,
                present_address_2:present_address_2,
                present_landmark:present_landmark,
                present_city:present_city,
                present_state:present_state,
                present_zip:present_zip,
                present_country:present_country,
                present_police_station:present_police_station,
                present_panchayat_municipality:present_panchayat_municipality
            }
        })
    }else{
        alert('Address line 1, City, State, Pincode, Country, Police Station, Panchayat/Municipality fields are required!');
        return false;
    }
    
}

function prefillAddressDetails(permanent_address_1,
    permanent_address_2,
    permanent_landmark,
    permanent_city,
    permanent_state,
    permanent_zip,
    permanent_country,
    permanent_police_station,
    permanent_panchayat_municipality,
    present_address_1,
    present_address_2,
    present_landmark,
    present_city,
    present_state,
    present_zip,
    present_country,
    present_police_station,
    present_panchayat_municipality) {
    $('#permanent_address_1').val(permanent_address_1);
    $('#permanent_address_2').val(permanent_address_2);
    $('#permanent_landmark').val(permanent_landmark);
    $('#permanent_city').val(permanent_city);
    $('#permanent_state').val(permanent_state);
    $('#permanent_zip').val(permanent_zip);
    $('#permanent_country').val(permanent_country);
    $('#permanent_police_station').val(permanent_police_station);
    $('#permanent_panchayat_municipality').val(permanent_panchayat_municipality);
    $('#present_address_1').val(present_address_1);
    $('#present_address_2').val(present_address_2);
    $('#present_landmark').val(present_landmark);
    $('#present_city').val(present_city);
    $('#present_state').val(present_state);
    $('#present_zip').val(present_zip);
    $('#present_country').val(present_country);
    $('#present_police_station').val(present_police_station);
    $('#present_panchayat_municipality').val(present_panchayat_municipality);
}