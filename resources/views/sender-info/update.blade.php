<div class="modal fade" id="updateSenderInfo" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Update New Sender Info
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('sender-info.update')}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input name="id" id="sender-info-id" class="d-none"/>
                    <div class="g-2">
                        <div class="col mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <select class="form-select" id="update_user_id" required name="user_id">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3">
                            <label for="updateSenderIDGenarateInput" class="form-label required">Sender ID</label>
                            <div class="d-flex">
                                <input class="form-control" required name="sender_id" id="updateSenderIDGenarateInput" readonly placeholder="Genarate Sender ID" value=""/>
                                <button type="button" class="mx-2 btn btn-sm btn-primary updateSenderIDGenarateBtn" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" data-bs-original-title="Genarate Sender ID">
                                    <i class='bx bx-loader-circle'></i>
                                </button>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <label for="update_api_key" class="form-label required">Api key</label>
                            <input class="form-control" id="update_api_key" required name="api_key" placeholder="Enter api key"/>
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