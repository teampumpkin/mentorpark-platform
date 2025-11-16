$(document).ready(function () {
    // Load countries on page load
    const countrySelect = $('.countryList');
    const stateSelect = $('.stateList');
    const citySelect = $('.cityList');

    const selectedCountry = countrySelect.data('selected');
    const selectedState = stateSelect.data('selected');
    const selectedCity = citySelect.data('selected');

    $.ajax({
        url: '/api/countryList',
        type: 'GET',
        success: function (countries) {
            countries.forEach(function (country) {
                const selected = country.id == selectedCountry ? 'selected' : '';
                countrySelect.append(`<option value="${country.id}" ${selected}>${country.name}</option>`);
            });

            if (selectedCountry) {
                loadStates(selectedCountry);
            }
        }
    });

    // Load industry type on page load
    $.ajax({
        url: '/api/industryType', // this should return array of { id, name }
        type: 'GET',
        success: function (data) {
            const selectBox = $('.industry_type');
            const selectedValue = selectBox.data('selected'); // get data-selected attribute

            selectBox.empty();
            selectBox.append('<option value="">-- Select Industry --</option>');

            data.forEach(function (item) {
                const selected = item.id == selectedValue ? 'selected' : '';
                selectBox.append(`<option value="${item.id}" ${selected}>${item.name}</option>`);
            });
        },
        error: function (err) {
            console.error('Could not load industry types:', err);
        }
    });

    $('.multi-select').select2();

    /*    // On country change, load states
        $('#country').on('change', function () {
            var countryId = $(this).val();
            $('#state').empty().append('<option value="">-- Select State --</option>');
            $('#city').empty().append('<option value="">-- Select City --</option>');

            if (countryId) {
                $.ajax({
                    url: '/api/stateList/' + countryId,
                    type: 'GET',
                    success: function (data) {
                        $('#state').append(data.map(function (state) {
                            return `<option value="${state.id}">${state.name}</option>`;
                        }));
                    }
                });
            }
        });*/

    // On state change, load cities
    /*$('#state').on('change', function () {
        var stateId = $(this).val();
        $('#city').empty().append('<option value="">-- Select City --</option>');

        if (stateId) {
            $.ajax({
                url: '/api/cityList/' + stateId,
                type: 'GET',
                success: function (data) {
                    $('#city').append(data.map(function (city) {
                        return `<option value="${city.id}">${city.name}</option>`;
                    }));
                }
            });
        }
    });
*/

    function loadStates(countryId) {
        stateSelect.empty().append('<option value="">-- Select State --</option>');
        citySelect.empty().append('<option value="">-- Select City --</option>');

        $.ajax({
            url: '/api/stateList/' + countryId,
            type: 'GET',
            success: function (states) {
                states.forEach(function (state) {
                    const selected = state.id == selectedState ? 'selected' : '';
                    stateSelect.append(`<option value="${state.id}" ${selected}>${state.name}</option>`);
                });

                if (selectedState) {
                    loadCities(selectedState);
                }
            }
        });
    }

    // Load cities
    function loadCities(stateId) {
        citySelect.empty().append('<option value="">-- Select City --</option>');

        $.ajax({
            url: '/api/cityList/' + stateId,
            type: 'GET',
            success: function (cities) {
                cities.forEach(function (city) {
                    const selected = city.id == selectedCity ? 'selected' : '';
                    citySelect.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                });
            }
        });
    }

    // If user manually changes country
    countrySelect.on('change', function () {
        const countryId = $(this).val();
        loadStates(countryId);
    });

    // If user manually changes state
    stateSelect.on('change', function () {
        const stateId = $(this).val();
        loadCities(stateId);
    });

    $('#banner_image').on('change', function (event) {
        var preview = $('#banner_preview');
        preview.empty();
        var file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = $('<img>').attr('src', e.target.result);
                preview.append(img);
            };
            reader.readAsDataURL(file);
        }
    });


    $('#add_session_btn').on('click', function () {
        var count = $('.repetitive_box').length;

        $.ajax({
            url: '/master-class/add_sessions/' + count,
            type: 'GET',
            success: function (sessionForm) {
                var $newContent = $(sessionForm.view);
                $('#repetitive_container').append($newContent);
                // Initialize Select2 only on the newly added select.multi-select elements
                $newContent.find('select.multi-select').select2({ width: '100%' })
            }
        });
    });

    $(document).on('click', '.remove-session', function () {
        $(this).closest('.repetitive_box').remove();
    });

    /*$('#add_session_feedback_question').on('click', function () {
        var feedback_count = $('.feedback_box').length;

        $.ajax({
            url: '/master-class/add_sessions/feedback' + feedback_count,
            type: 'GET',
            success: function (sessionForm) {
                var $newContent = $(sessionForm.view);
                $('#repetitive_container').append($newContent);
                // Initialize Select2 only on the newly added select.multi-select elements
                $newContent.find('select.multi-select').select2({ width: '100%' })
            }
        });
    });*/


    // Initialize select2 for existing selects on page load
    $('select.multi-select').select2({width: '100%'});


    $(document).on('click', '.add-feedback-btn', function () {
        let number = $(this).data('number');
        // let feedback_count = $('.feedback_box').length;
        let feedback_count = $('#feedback_container_' + number + ' .feedback_box').length;
        add_session_feedback_question(number, feedback_count);
    });

    $(document).on('click', '.remove-session-feedback-question', function() {
        $(this).closest('.feedback_box').remove();
    });

    $(document).on('click', '.remove-session-speaker', function() {
        $(this).closest('.mentor_box').remove();
    });


    $(document).on('click', '.add-speaker-btn', function () {
        let number = $(this).data('number');
        // let feedback_count = $('.feedback_box').length;
        let count = $('#mentor_container_' + number + ' .mentor_box').length;
        add_session_speaker(number, count);
    });


});


function add_session_feedback_question(number, feedback_count) {
    $.ajax({
        url: '/master-class/add_sessions/' + number + '/feedback/' + feedback_count,
        type: 'GET',
        success: function (sessionForm) {
            var $newContent = $(sessionForm.view);
            $('#feedback_container_' + number).append($newContent);
        }
    });
}

function add_session_speaker(number, count) {
    $.ajax({
        url: '/master-class/add_sessions/' + number + '/mentor/' + count,
        type: 'GET',
        success: function (sessionForm) {
            var $newContent = $(sessionForm.view);
            $('#mentor_container_' + number).append($newContent);
        }
    });
}

$(document).on('change', '.virtual_f2f_button', function () {
    let number = $(this).data('id');
    let value  = $(this).val();

    console.log("Number:", number, "Value:", value);

    // Show/Hide the div based on selection
    if (value === 'face_to_face') {
        $('#face_to_face_details_' + number).show();
    } else {
        $('#face_to_face_details_' + number).hide();
    }
});


$(document).ready(function () {

    // 🔹 When country changes -> load states
    $(document).on('change', '.countryName', function () {
        let number     = $(this).data('id');
        let countryId  = $(this).val();
        // let stateSelect = $('#classes\\[' + number + '\\]\\[state\\]');
        // let citySelect  = $('#classes\\[' + number + '\\]\\[city\\]');

        let stateSelect = $('#classes_' + number + '_state');
        let citySelect  = $('#classes_' + number + '_city');
        // console.log('#classes_' + number + '_state')
        stateSelect.empty().append('<option value="">-- Select State --</option>');
        citySelect.empty().append('<option value="">-- Select City --</option>');

        if (countryId) {
            $.ajax({
                url: '/api/stateList/' + countryId,
                type: 'GET',
                success: function (states) {
                    states.forEach(function (state) {
                        stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                    });
                }
            });
        }
    });

    $(document).on('change', '#org-country', function () {

        let countryId  = $(this).val();
        let stateSelect = $('#org-state');
        let citySelect  = $('#org-city');
        console.log(countryId)
        stateSelect.empty().append('<option value="">-- Select State --</option>');
        citySelect.empty().append('<option value="">-- Select City --</option>');

        if (countryId) {
            $.ajax({
                url: '/api/stateList/' + countryId,
                type: 'GET',
                success: function (states) {
                    states.forEach(function (state) {
                        stateSelect.append(`<option value="${state.id}">${state.name}</option>`);
                    });
                }
            });
        }
    });

    // 🔹 When state changes -> load cities
    $(document).on('change', '.stateName', function () {
        let number   = $(this).data('id');            // get dynamic number
        let stateId  = $(this).val();                 // selected state
        let citySelect  = $('#classes_' + number + '_city');

        citySelect.empty().append('<option value="">-- Select City --</option>');

        if (stateId) {
            $.ajax({
                url: '/api/cityList/' + stateId,
                type: 'GET',
                success: function (cities) {
                    cities.forEach(function (city) {
                        citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                }
            });
        }
    });

    $(document).on('change', '#org-state', function () {
        let stateId  = $(this).val();
        let citySelect  = $('#org-city');

        citySelect.empty().append('<option value="">-- Select City --</option>');

        if (stateId) {
            $.ajax({
                url: '/api/cityList/' + stateId,
                type: 'GET',
                success: function (cities) {
                    cities.forEach(function (city) {
                        citySelect.append(`<option value="${city.id}">${city.name}</option>`);
                    });
                }
            });
        }
    });

    $('.countryName').each(function () {
        let countrySelect = $(this);
        let countryVal = countrySelect.data('value'); // get pre-selected country value
        let number = countrySelect.attr('id').split('_')[1]; // extract number from id e.g. classes_0_country

        if (countryVal) {
            countrySelect.val(countryVal); // select country

            // Load states for this country
            $.ajax({
                url: '/api/stateList/' + countryVal,
                type: 'GET',
                success: function (states) {
                    let stateSelect = $('#classes_' + number + '_state');
                    stateSelect.empty().append('<option value="">-- Select State --</option>');

                    states.forEach(function (state) {
                        const selected = state.id == stateSelect.data('value') ? 'selected' : '';
                        stateSelect.append(`<option value="${state.id}" ${selected}>${state.name}</option>`);
                    });

                    // If state is pre-selected, load cities
                    let stateVal = stateSelect.data('value');
                    if (stateVal) {
                        $.ajax({
                            url: '/api/cityList/' + stateVal,
                            type: 'GET',
                            success: function (cities) {
                                let citySelect = $('#classes_' + number + '_city');
                                citySelect.empty().append('<option value="">-- Select City --</option>');

                                cities.forEach(function (city) {
                                    const selected = city.id == citySelect.data('value') ? 'selected' : '';
                                    citySelect.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                                });
                            }
                        });
                    }
                }
            });
        }
    });

});

function removeMentee(id) {
    if(!confirm("Are you sure you want to remove this mentee?")) {
        return;
    }

    $.ajax({
        url: '/remove-mentee/' + id,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                // Remove mentee row from table
                $("#mentee_row_" + id).remove();
                // alert(response.message);
            } else {
                alert("Failed: " + response.message);
            }
        },
        error: function(xhr) {
            alert("Something went wrong: " + xhr.responseText);
        }
    });
}

function removeAttachment(id)
{
    if(!confirm("Are you sure you want to remove this attachment?")) {
        return;
    }

    $.ajax({
        url: '/remove-attachment/' + id,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success) {
                // Remove mentee row from table
                $("#attachment_row_" + id).remove();
                // alert(response.message);
            } else {
                alert("Failed: " + response.message);
            }
        },
        error: function(xhr) {
            alert("Something went wrong: " + xhr.responseText);
        }
    });
}


