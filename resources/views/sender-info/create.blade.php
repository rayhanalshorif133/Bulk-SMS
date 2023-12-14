<div class="modal fade" id="createNewSenderInfo" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Create New Sender Info
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('sender-info.create')}}">
                @csrf
                <div class="modal-body">
                    <div class="g-2">
                        <div class="col mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <select class="form-select" required name="user_id">
                                <option disabled selected value="0">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="sender_id" class="form-label required">Sender ID</label>
                            <input class="form-control" id="sender_id" required name="sender_id" placeholder="Enter sender id"/>
                        </div>
                        <div class="col mb-3">
                            <label for="api_key" class="form-label required">Api key</label>
                            <input class="form-control" id="api_key" required name="api_key" placeholder="Enter api key"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>