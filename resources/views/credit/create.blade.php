<div class="modal fade" id="createCredit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Create New Credit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('credit.store')}}">
                @csrf
                <div class="modal-body">
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="name" class="form-label required">User Name</label>
                            <select class="form-select" id="selected_user" required name="user_id">
                                <option disabled selected value="0">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="appendSenderOptions" class="form-label required">Sender ID</label>
                            <select class="form-select" required name="sender_info_id" id="appendSenderOptions">
                                <option disabled selected value="0">First select a user</option>
                            </select>
                        </div>
                    </div>
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="balance" class="form-label required">Balance (<small class="text-danger">Count of SMS</small>)</label>
                            <input class="form-control" id="balance" required placeholder="Enter a balance" name="balance" type="number"/>
                        </div>
                        <div class="col mb-3">
                            <label for="amount" class="form-label required">Amount (<small class="text-danger">Taka</small>)</label>
                            <input class="form-control" id="amount" required placeholder="Enter a amount" name="amount" type="number"/>
                        </div>
                    </div>
                    <div class="g-2 row">
                        
                        <div class="col mb-3">
                            <label for="fund" class="form-label required">Fund</label>
                            <select class="form-select" required name="fund_id" id="fund">
                                <option disabled selected value="0">Select a fund</option>
                                @foreach($funds as $fund)
                                    <option value="{{$fund->id}}">{{$fund->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="amount" class="form-label required">Transection ID</label>
                            <input class="form-control" id="amount" required placeholder="Enter a amount" name="transection_id" type="text"/>
                        </div>
                    </div>
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-select" required name="status" id="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="expired_date" class="form-label required">Expired Date</label>
                            <input class="form-control" id="expired_date" name="expired_date" type="date"/>
                        </div>
                    </div>
                    <div class="col mb-3">
                        <label for="note" class="form-label optional">Note</label>
                        <textarea class="form-control" row="3" id="note" placeholder="Enter a note" name="note" type="text"></textarea>
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