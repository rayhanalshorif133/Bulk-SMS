<div class="modal fade" id="updateBalance" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Update Balance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('balance.update')}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="g-2 row">
                        <input id="updateBalanceID" name="id" class="d-none" />
                        <div class="col mb-3">
                            <label for="name" class="form-label required">User Name</label>
                            <input class="form-control" id="selected_update_user" name="user_id" readonly placeholder="Enter a balance" name="balance" type="text"/>
                        </div>
                        <div class="col mb-3">
                            <label for="updateAppendSenderOptions" class="form-label required">Sender ID</label>
                            <select class="form-select" required name="sender_info_id" id="updateAppendSenderOptions">
                                <option disabled selected value="0">First select a user</option>
                            </select>
                        </div>
                    </div>
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="updateSmsBalance" class="form-label required">Balance (<small class="text-danger">Count of SMS</small>)</label>
                            <input class="form-control" id="updateSmsBalance" placeholder="Enter a balance" name="balance" type="number"/>
                        </div>
                        {{-- <div class="col mb-3">
                            <label for="updateAmount" class="form-label required">Amount (<small class="text-danger">Taka</small>)</label>
                            <input class="form-control" id="updateAmount" placeholder="Enter a amount" name="amount" type="number"/>
                        </div> --}}
                        <div class="col mb-3">
                            <label for="modifyExpiredDate" class="form-label required">Expired Date</label>
                            <input class="form-control" id="modifyExpiredDate" name="expired_date" type="date"/>
                        </div>
                    </div>
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="modifyStatus" class="form-label required">Status</label>
                            <select class="form-select" required name="modifyStatus" id="modifyStatus">
                                <option disabled selected value="0">Select a status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>