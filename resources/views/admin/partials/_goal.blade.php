<div class="modal fade" id="createGoalModal" tabindex="-1" aria-labelledby="createGoalModalLabel" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGoalModalLabel">Create New Goal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createGoalForm">
                    <div class="mb-3">
                        <label for="newGoalName" class="form-label">Goal Name</label>
                        <input type="text" class="form-control" id="newGoalName" name="goal_name" placeholder="Enter new goal name" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Create Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
