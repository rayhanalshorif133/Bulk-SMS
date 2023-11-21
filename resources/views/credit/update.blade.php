<div class="modal fade" id="updateCredit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Update Credit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('credit.update')}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input name="id" id="updateCredit_id" class="d-none"/>
                    <div class="g-2 row">
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
                            <input class="form-control" id="updateSmsBalance" required placeholder="Enter a balance" name="balance" type="number"/>
                        </div>
                        <div class="col mb-3">
                            <label for="updateAmount" class="form-label required">Amount (<small class="text-danger">Taka</small>)</label>
                            <input class="form-control" id="updateAmount" required placeholder="Enter a amount" name="amount" type="number"/>
                        </div>
                    </div>
                    <div class="g-2 row">
                        
                        <div class="col mb-3">
                            <label for="fund" class="form-label required">Fund</label>
                            <select class="form-select" required name="fund_id" id="update_fund">
                                @foreach($funds as $fund)
                                    <option value="{{$fund->id}}">{{$fund->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="modifyTransection" class="form-label required">Transection ID</label>
                            <input class="form-control" id="modifyTransection" required placeholder="Enter a transection id" name="transection_id" type="text"/>
                        </div>
                    </div>
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="modifyStatus" class="form-label required">Status</label>
                            <select class="form-select" required name="status" id="modifyStatus">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="modifyNote" class="form-label optional">Note</label>
                            <textarea class="form-control" row="3" id="modifyNote" placeholder="Enter a note" name="note" type="text"></textarea>
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