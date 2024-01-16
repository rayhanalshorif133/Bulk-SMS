<div class="modal fade" id="updateUser" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Update New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('user.update')}}">
                @csrf
                @method("PUT")
                <div class="modal-body">
                    <input name="id" id="user_id" class="d-none"/>
                    <div class="g-2">
                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="updateEmail" class="form-label required">Email</label>
                                <input class="form-control" id="updateEmail" required name="email" placeholder="Enter a email"/>
                            </div>
                            <div class="col mb-3">
                                <label for="updateUserRole" class="form-label required">Type</label>
                                <select class="form-select" id="updateUserRole" required name="role">
                                    <option value="user" selected>User</option>
                                    <option value="admin">Admin</option>
                                </select>

                            </div>
                        </div>
                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="password" class="form-label optional">Password</label>
                                <input class="form-control" id="password"  name="password" placeholder="Enter a password"/>
                            </div>
                            <div class="col mb-3">
                                <label for="password_confirmation" class="form-label optional">Password Confirmation</label>
                                <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter a password"/>
                            </div>
                        </div>

                        <div class="g-2 row">
                            <div class="col mb-3">
                                <label for="update_user_api_key" class="form-label required">Api key</label>
                                <div class="d-flex">
                                    <input class="form-control" id="update_user_api_key" required name="api_key" placeholder="Enter api key" readonly/>
                                    <button type="button" class="mx-2 btn btn-sm btn-primary updateUserApiKeyGenarateBtn" data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" data-bs-original-title="Genarate Sender ID">
                                        <i class='bx bx-loader-circle'></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <label for="status" class="form-label required">Status</label>
                                <select class="form-select" required name="status" id="update_user_status">
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
