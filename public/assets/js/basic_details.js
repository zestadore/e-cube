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

/**
 * Validate + submit ONLY the qualification rows
 * Returns jQuery promise (so caller can await it)
 */
function updateQualificationDetails(token, url) {
    const qualifications = [];

    /* ---- basic validation ---- */
    let isValid = true;
    $('#qualification_table tbody tr').each(function (idx) {
        const row = $(this);
        const q = {
            qualification: row.find('select[name*="[qualification]"]').val(),
            university   : row.find('input[name*="[university]"]').val(),
            from_year    : row.find('select[name*="[from_year]"]').val(),
            to_year      : row.find('select[name*="[to_year]"]').val(),
            percentage   : row.find('input[name*="[percentage]"]').val(),
            certificate  : row.find('input[type="file"][name*="[certificate]"]')[0]?.files?.[0] || null
        };

        /* ---- same rules you already had ---- */
        if (!q.qualification) { alert('Please select Qualification for row ' + (idx + 1)); isValid = false; return false; }
        if (!q.university)    { alert('Please enter University/School for row ' + (idx + 1)); isValid = false; return false; }
        if (!q.from_year)     { alert('Please select From Year for row ' + (idx + 1)); isValid = false; return false; }
        if (!q.to_year)       { alert('Please select To Year for row ' + (idx + 1)); isValid = false; return false; }
        if (parseInt(q.from_year) > parseInt(q.to_year)) { alert('From Year cannot be greater than To Year in row ' + (idx + 1)); isValid = false; return false; }
        if (q.percentage === '' || isNaN(q.percentage) || q.percentage < 0 || q.percentage > 100) {
            alert('Enter a valid percentage (0-100) for row ' + (idx + 1)); isValid = false; return false;
        }
        if (q.certificate) {
            const ext = q.certificate.name.substring(q.certificate.name.lastIndexOf('.')).toLowerCase();
            const allowed = ['.pdf','.jpg','.jpeg','.png','.doc','.docx'];
            if (!allowed.includes(ext)) { alert('Invalid certificate file type in row ' + (idx + 1)); isValid = false; return false; }
            if (q.certificate.size > 5 * 1024 * 1024) { alert('Certificate file must be ≤ 5 MB in row ' + (idx + 1)); isValid = false; return false; }
        }
        qualifications.push(q);
    });
    if (!isValid) return Promise.reject('validation failed');   // stop the chain

    /* ---- build FormData (keeps files intact) ---- */
    const fd = new FormData();
    fd.append('_token', token);
    qualifications.forEach((item, i) => {
        fd.append(`qualifications[${i}][qualification]`, item.qualification);
        fd.append(`qualifications[${i}][university]`, item.university);
        fd.append(`qualifications[${i}][from_year]`, item.from_year);
        fd.append(`qualifications[${i}][to_year]`, item.to_year);
        fd.append(`qualifications[${i}][percentage]`, item.percentage);
        if (item.certificate) fd.append(`qualifications[${i}][certificate]`, item.certificate);
    });

    /* ---- ajax call ---- */
    return $.ajax({
        url: url,
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false
    });
}

/**
 * Validate + submit skills ONLY if user started filling at least one skill row.
 * Returns resolved promise immediately if nothing was entered.
*/
function updateSkillDetails(token, url) {
    /* ---- quick scan: did user touch any skill row? ---- */
    let userStartedSkill = false;
    $('#skills_table tbody tr').each(function () {
        if ($(this).find('select[name*="[skill]"]').val()) {
            userStartedSkill = true;
            return false; // break each
        }
    });
    if (!userStartedSkill) {
        /* nothing entered – skip validation and ajax */
        return Promise.resolve(); // <-- wizard continues
    }

    /* ---- normal validation ---- */
    const skills = [];
    let isValid = true;
    $('#skills_table tbody tr').each(function (idx) {
        const row = $(this);
        const s = {
            skill       : row.find('select[name*="[skill]"]').val(),
            university  : row.find('input[name*="[university]"]').val(),
            from_year   : row.find('select[name*="[from_year]"]').val(),
            to_year     : row.find('select[name*="[to_year]"]').val(),
            percentage  : row.find('input[name*="[percentage]"]').val(),
            certificate : row.find('input[type="file"][name*="[certificate]"]')[0]?.files?.[0] || null
        };

        if (!s.skill)       { alert('Please select Skill for row ' + (idx + 1)); isValid = false; return false; }
        if (!s.university)  { alert('Please enter University/School for row ' + (idx + 1)); isValid = false; return false; }
        if (!s.from_year)   { alert('Please select From Year for row ' + (idx + 1)); isValid = false; return false; }
        if (!s.to_year)     { alert('Please select To Year for row ' + (idx + 1)); isValid = false; return false; }
        if (parseInt(s.from_year) > parseInt(s.to_year)) {
            alert('From Year cannot be greater than To Year in row ' + (idx + 1)); isValid = false; return false;
        }
        if (s.percentage === '' || isNaN(s.percentage) || s.percentage < 0 || s.percentage > 100) {
            alert('Enter a valid percentage (0-100) for row ' + (idx + 1)); isValid = false; return false;
        }
        if (s.certificate) {
            const ext = s.certificate.name.substring(s.certificate.name.lastIndexOf('.')).toLowerCase();
            const allowed = ['.pdf','.jpg','.jpeg','.png','.doc','.docx'];
            if (!allowed.includes(ext)) { alert('Invalid certificate file type in row ' + (idx + 1)); isValid = false; return false; }
            if (s.certificate.size > 5 * 1024 * 1024) { alert('Certificate file must be ≤ 5 MB in row ' + (idx + 1)); isValid = false; return false; }
        }
        skills.push(s);
    });
    if (!isValid) return Promise.reject('validation failed');

    /* ---- ajax identical to previous answer ---- */
    const fd = new FormData();
    fd.append('_token', token);
    skills.forEach((item, i) => {
        fd.append(`skills[${i}][skill]`, item.skill);
        fd.append(`skills[${i}][university]`, item.university);
        fd.append(`skills[${i}][from_year]`, item.from_year);
        fd.append(`skills[${i}][to_year]`, item.to_year);
        fd.append(`skills[${i}][percentage]`, item.percentage);
        if (item.certificate) fd.append(`skills[${i}][certificate]`, item.certificate);
    });

    return $.ajax({
        url: url,
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false
    });
}

/**
 * Prefill qualification & skill tables (keeps first row if nothing stored)
 */
function prefillQualificationsAndSkills(qualifications, skills) {
    /* ---------- QUALIFICATIONS ---------- */
    const $qtbody = $('#qualification_table tbody');
    $qtbody.empty();                                    // remove dummy row
    if (qualifications.length) {
        qualifications.forEach((q, idx) => {
            const row = qualRowTpl(idx, q.qualification_id, q.university, q.from_year, q.to_year, q.percentage);
            $qtbody.append(row);
        });
    } else {
        $qtbody.append(qualRowTpl(0));                  // keep one empty row
    }
    updateDeleteButtonVisibility();                     // your existing helper

    /* ---------- SKILLS ---------- */
    const $stbody = $('#skills_table tbody');
    $stbody.empty();
    if (skills.length) {
        skills.forEach((s, idx) => {
            const row = skillRowTpl(idx, s.skill_id, s.university, s.from_year, s.to_year, s.percentage);
            $stbody.append(row);
        });
    } else {
        $stbody.append(skillRowTpl(0));
    }
    updateSkillDeleteButtonVisibility();
}

/* -------- row templates (identical to your add-row code) -------- */
function qualRowTpl(idx, qualId = '', univ = '', fromY = '', toY = '', perc = '') {
    let opts = qualList.map(q => `<option value="${q.id}" ${qualId == q.id ? 'selected' : ''}>${q.degree}</option>`).join('');
    return `
    <tr class="qualification-row">
        <td>
            <select name="qualifications[${idx}][qualification]" class="form-control form-select qualification" required>
                <option value="">Select Qualification</option>${opts}
            </select>
        </td>
        <td><input type="text" name="qualifications[${idx}][university]" class="form-control" placeholder="University/School" value="${univ}" required></td>
        <td><select name="qualifications[${idx}][from_year]" class="form-control form-select" required>${yearOpts(fromY)}</select></td>
        <td><select name="qualifications[${idx}][to_year]"   class="form-control form-select" required>${yearOpts(toY)}</select></td>
        <td><input type="number" name="qualifications[${idx}][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" value="${perc}" required></td>
        <td><input type="file" name="qualifications[${idx}][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
        <td>
            <button type="button" class="btn btn-success btn-sm add-qualification-row"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-danger btn-sm remove-qualification-row" style="${idx ? '' : 'display:none;'}"><i class="fa fa-minus"></i></button>
        </td>
    </tr>`;
}

function skillRowTpl(idx, skillId = '', univ = '', fromY = '', toY = '', perc = '') {
    let opts = skillList.map(s => `<option value="${s.id}" ${skillId == s.id ? 'selected' : ''}>${s.skill}</option>`).join('');
    return `
    <tr class="skill-row">
        <td>
            <select name="skills[${idx}][skill]" class="form-control form-select skill" required>
                <option value="">Select Skill</option>${opts}
            </select>
        </td>
        <td><input type="text" name="skills[${idx}][university]" class="form-control" placeholder="University/School" value="${univ}" required></td>
        <td><select name="skills[${idx}][from_year]" class="form-control form-select" required>${yearOpts(fromY)}</select></td>
        <td><select name="skills[${idx}][to_year]"   class="form-control form-select" required>${yearOpts(toY)}</select></td>
        <td><input type="number" name="skills[${idx}][percentage]" class="form-control" placeholder="Percentage" min="0" max="100" step="0.01" value="${perc}" required></td>
        <td><input type="file" name="skills[${idx}][certificate]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"></td>
        <td>
            <button type="button" class="btn btn-success btn-sm add-skill-row"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-danger btn-sm remove-skill-row" style="${idx ? '' : 'display:none;'}"><i class="fa fa-minus"></i></button>
        </td>
    </tr>`;
}

/* -------- year helper (unchanged) -------- */
function yearOpts(selected = '') {
    let html = '';
    for (let y = new Date().getFullYear(); y >= new Date().getFullYear() - 50; y--) {
        html += `<option value="${y}" ${y == selected ? 'selected' : ''}>${y}</option>`;
    }
    return html;
}

/* ---------------- qualification table ---------------- */
function updateDeleteButtonVisibility() {
    const rows = $('#qualification_table tbody tr');
    if (rows.length === 1) {
        rows.find('.remove-qualification-row').hide();
    } else {
        rows.find('.remove-qualification-row').show();
    }
}

/* ---------------- skill table ---------------- */
function updateSkillDeleteButtonVisibility() {
    const rows = $('#skills_table tbody tr');
    if (rows.length === 1) {
        rows.find('.remove-skill-row').hide();
    } else {
        rows.find('.remove-skill-row').show();
    }
}