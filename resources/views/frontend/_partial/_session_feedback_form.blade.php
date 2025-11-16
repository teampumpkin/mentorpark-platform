<div class="feedback_box mt-3">
    <div class="row">
        <div class="col-md-5">
            <label class="form-label" for="feedback_type_{{ $number }}">Feedback Type</label>
            <select name="classes[{{ $number }}][feedback][{{ $feedback_number }}][feedback_type]"
                    class="form-control"
                    id="feedback_type">
                <option value="rating">Rating</option>
                <option value="text">Text</option>
                <option value="number">Number</option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label" for="feedback_question_{{ $number }}">Feedback Question</label>
            <input type="text" name="classes[{{ $number }}][feedback][{{ $feedback_number }}][feedback_question]"
                   id="feedback_question_{{ $number }}" class="form-control"/>
        </div>

        <div class="col-md-2 mt-3">
                <button type="button" class="btn btn-outline-danger remove-session-feedback-question">
                    Remove
                </button>
        </div>
    </div>
</div>


