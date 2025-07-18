<div class="modal fade" id="globalDynamicModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered custom-centered-modal">
        <form method="POST" id="globalDynamicForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="globalModalTitle">Assign Admins to Role</span></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="globalModalBody">
                    <!-- Modal content goes here -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="globalModalSubmit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>