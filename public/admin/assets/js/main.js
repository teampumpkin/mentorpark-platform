$(document).ready(function() {
    $('#userForm').validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            mobile: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 15
            },
            /*password: {
                required: true,
                minlength: 6
            },*/
            user_types: {
                required: true
            },
            about: {
                required: true
            },
            job_title: {
                required: true
            },
            total_experience: {
                required: true,
                digits: true
            },
            skills: {
                required: true
            },
            goal: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },
            checkmeout: {
                required: true
            }
        },
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            email: "Please enter a valid email",
            mobile: "Please enter a valid mobile number",
            // password: "Password must be at least 6 characters long",
            user_type: "Please select a user type",
            about: "Please provide a short description about yourself",
            job_title: "Please enter your job title",
            total_experience: "Please enter total experience",
            skills: "Please enter your skills",
            goal: "Please enter your goal",
            state: "Please enter your state",
            country: "Please enter your country",
            checkmeout: "You must accept the terms and conditions"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });


    $('#createGoalForm').on('submit', function(e) {
        e.preventDefault();

        var goalName = $('#newGoalName').val();
        if (goalName.trim() === '') {
            alert("Goal name is required");
            return;
        }
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        // Submit the new goal via AJAX (or regular form submission depending on your requirements)
        $.ajax({
            url: '/api/create-new-goal',
            method: 'POST',
            data: {
                name: goalName,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
            },
            success: function(response) {
                $('#createGoalModal').modal('hide');
                $('.goals-select').append(new Option(response.name, response.id, false, true));
                $('.goals-select').val(response.id).trigger('change');
            },
            error: function() {
                alert('Error creating new goal.');
            }
        });
    });

    // Load countries on page load

    const countrySelect = $('#country');
    const stateSelect = $('#state');
    const citySelect = $('#city');

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


});
