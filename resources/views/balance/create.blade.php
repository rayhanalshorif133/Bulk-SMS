<div class="modal fade" id="createNewBalance" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Create New Balance
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('sender-info.create')}}">
                @csrf
                <div class="modal-body">
                    <div class="g-2 row">
                        <div class="col mb-3">
                            <label for="name" class="form-label required">User Name</label>
                            <select class="form-select" required name="user_id">
                                <option disabled selected value="0">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="name" class="form-label required">Sender ID</label>
                            <select class="form-select" required name="user_id">
                                <option disabled selected value="0">Select a sender ID</option>
                                <span class="appendSenderOptions"></span>
                            </select>
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