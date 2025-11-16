<div class="feedback_box mt-3">
    <div class="row">
        <div class="col-md-5">
            <label class="form-label" for="feedback_type_{{ $number }}_{{ $feedback_number }}">Feedback Type</label>
            <select name="classes[{{ $number }}][feedback][{{ $feedback_number }}][feedback_type]"
                    class="form-control"
                    id="feedback_type_{{ $number }}_{{ $feedback_number }}">
                <option value="rating"
                    {{ old("classes.$number.feedback.$feedback_number.feedback_type", $feedback->feedback_type ?? '') == 'rating' ? 'selected' : '' }}>
                    Rating
                </option>
                <option value="text"
                    {{ old("classes.$number.feedback.$feedback_number.feedback_type", $feedback->feedback_type ?? '') == 'text' ? 'selected' : '' }}>
                    Text
                </option>
                <option value="number"
                    {{ old("classes.$number.feedback.$feedback_number.feedback_type", $feedback->feedback_type ?? '') == 'number' ? 'selected' : '' }}>
                    Number
                </option>
            </select>
        </div>

        <div class="col-md-5">
            <label class="form-label" for="feedback_question_{{ $number }}_{{ $feedback_number }}">Feedback Question</label>
            <input type="text"
                   name="classes[{{ $number }}][feedback][{{ $feedback_number }}][feedback_question]"
                   id="feedback_question_{{ $number }}_{{ $feedback_number }}"
                   class="form-control"
                   value="{{ old("classes.$number.feedback.$feedback_number.feedback_question", $feedback->feedback_question ?? '') }}"/>
        </div>

        <div class="col-md-2 mt-3">
            <button type="button" class="btn btn-outline-danger remove-session-feedback-question">
                Remove
            </button>
        </div>
    </div>
</div>
