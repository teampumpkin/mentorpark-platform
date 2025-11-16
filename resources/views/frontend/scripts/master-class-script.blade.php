<script>
    document.getElementById('toSessionsBtn').addEventListener('click', function () {
        var tab = new bootstrap.Tab(document.querySelector('#sessions-tab'));
        tab.show();
    });
    document.getElementById('toDetailsBtn').addEventListener('click', function () {
        var tab = new bootstrap.Tab(document.querySelector('#details-tab'));
        tab.show();
    });

    /*const mentees = [
        "Rohan Patil", "Ritu Desai", "John Smith",
        "Roshan Joshi", "Priya Sharma", "Amit Verma",
        "Rachel Green", "Ross Geller"
    ];*/

    const mentees = {!! json_encode($mentees) !!};

    function showSuggestions(val) {
        const $suggestions = $('#suggestions');
        $suggestions.empty();
        if (!val) return;

        const filtered = mentees.filter(mentee =>
            mentee.name.toLowerCase().includes(val.toLowerCase())
        );

        filtered.forEach(mentee => {
            const $div = $('<div>')
                .addClass('list-group-item list-group-item-action')
                .text(mentee.name)
                .data('id', mentee.id)
                .on('click', function () {
                    addMentee(mentee.id, mentee.name);
                    $suggestions.empty();
                    $('#menteeInput').val('');
                });
            $suggestions.append($div);
        });
    }

    function addMentee(id, name) {
        if (!name) return;
        // Avoid duplicates by checking existing inputs with same mentee id
        if ($(`input[name="mentee_ids[]"][value="${id}"]`).length > 0) return;

        const $inputGroup = $('<div>').addClass('input-group mb-2').css('max-width', '350px');
        const $input = $('<input>')
            .attr({
                type: 'text',
                readonly: true,
                value: name,
                name: 'mentee_names[]',
            })
            .addClass('form-control');
        const $hiddenInput = $('<input>')
            .attr({
                type: 'hidden',
                name: 'mentee_ids[]',
                value: id
            });
        const $removeBtn = $('<button>')
            .attr('type', 'button')
            .addClass('btn btn-outline-danger')
            .html('&times;')
            .on('click', function () {
                $inputGroup.remove();
            });

        $inputGroup.append($input, $hiddenInput, $removeBtn);
        $('#selectedList').append($inputGroup);
    }

    // New mentee (email)
    function addNewMentee(id, email) {
        if (!email) return;
        if ($(`input[name="new_mentee_emails[]"][value="${email}"]`).length > 0) return;

        const $inputGroup = $('<div>').addClass('input-group mb-2').css('max-width', '350px');
        const $input = $('<input>')
            .attr({
                type: 'email',
                readonly: true,
                value: email,
                name: 'new_mentee_emails[]',
            })
            .addClass('form-control');

        const $hiddenInput = $('<input>')
            .attr({
                type: 'hidden',
                name: 'new_mentee_ids[]',
                value: id
            });

        const $removeBtn = $('<button>')
            .attr('type', 'button')
            .addClass('btn btn-outline-danger')
            .html('&times;')
            .on('click', function () {
                $inputGroup.remove();
            });

        $inputGroup.append($input, $hiddenInput, $removeBtn);
        $('#newMenteeList').append($inputGroup);
    }

    // Handle Add button click with manual input (if user types a valid mentee name)
    $('#addBtn').on('click', function () {
        const val = $('#menteeInput').val().trim();
        if (!val) return;

        // Check if input matches any mentee name exactly (case-insensitive)
        const mentee = mentees.find(m => m.name.toLowerCase() === val.toLowerCase());
        if (mentee) {
            addMentee(mentee.id, mentee.name);
        } else {
            // alert('Please select a valid mentee from the suggestions.');
            const newId = 'new_' + Date.now(); // unique temp ID

            addNewMentee(newId, val);
        }
        $('#suggestions').empty();
        $('#menteeInput').val('');
    });

    // Optionally hide suggestions on input blur with delay to allow click event
    $('#menteeInput').on('blur', function () {
        setTimeout(() => {
            $('#suggestions').empty();
        }, 200);
    });

    function addMenteeFromInput() {
        const val = $('#menteeInput').val().trim();
        if (!val) return;

        // Check if input matches any mentee
        const mentee = mentees.find(m => m.name.toLowerCase() === val.toLowerCase());
        if (mentee) {
            addMentee(mentee.id, mentee.name);   // existing mentee
        } else {
            const newId = 'new_' + Date.now();   // unique id
            addNewMentee(newId, val);            // new mentee
        }

        $('#suggestions').empty();
        $('#menteeInput').val('');
    }

    function toggleFaceToFace(number) {
        let virtual = document.getElementById("virtual_" + number);
        let faceToFace = document.getElementById("face_to_face_" + number);
        let details = document.getElementById("face_to_face_details_" + number);

        if (faceToFace.checked) {
            details.style.display = "";
        } else {
            details.style.display = "none";
        }
    }


</script>
