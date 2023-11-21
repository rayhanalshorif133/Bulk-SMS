<div class="modal fade" id="createNewUser" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Create New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('user.create')}}">
                @csrf
                <div class="modal-body">
                    <div class="g-2">
                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="name" class="form-label required">Username</label>
                                <input class="form-control" id="name" required name="name" placeholder="Enter a name"/>
                            </div>
                            <div class="col mb-3">
                                <label for="email" class="form-label required">Email</label>
                                <input class="form-control" id="email" required name="email" placeholder="Enter a email"/>
                            </div>
                            <div class="col mb-3">
                                <label for="user_type" class="form-label required">Type</label>
                                <select class="form-select" required name="role">
                                    <option value="user" selected>User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="password" class="form-label required">Password</label>
                                <input class="form-control" id="password" required name="password" placeholder="Enter a password"/>
                            </div>
                            <div class="col mb-3">
                                <label for="password_confirmation" class="form-label required">Password Confirmation</label>
                                <input class="form-control" id="password_confirmation" required name="password_confirmation" placeholder="Enter a password"/>
                            </div>
                        </div> 
                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="user_api_key" class="form-label required">Api key</label>
                                <div class="d-flex">
                                    <input class="form-control" id="user_api_key" required name="api_key" placeholder="Enter api key" readonly/>
                                    <button type="button" class="mx-2 btn btn-sm btn-primary userApiKeyGenarateBtn" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" data-bs-original-title="Genarate Sender ID">
                                        <i class='bx bx-loader-circle'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label for="status" class="form-label required">Status</label>
                                <select class="form-select" required name="status" id="status">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
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