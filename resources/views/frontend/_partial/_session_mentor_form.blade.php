<div class="mentor_box">
    <div class="row">
        <div class="col-md-5">
            <label class="form-label" for="mentor_name_{{ $number }}">Mentor Name</label>
            <input type="text" name="classes[{{ $number }}][mentors][{{ $mentor_number }}][name]" placeholder="Speaker Name"
                   id="mentor_name_{{ $number }}" class="form-control" required/>
        </div>

        <div class="col-md-5">
            <label class="form-label" for="mentor_email_{{ $number }}">Mentor Email</label>
            <input type="email" name="classes[{{ $number }}][mentors][{{ $mentor_number }}][email]" placeholder="Speaker Email"
                   id="mentor_email_{{ $number }}" class="form-control" required/>
        </div>

        <div class="col-md-2 mt-3">
            <button type="button" class="btn btn-outline-danger remove-session-speaker">
                Remove
            </button>
        </div>
    </div>
</div>


