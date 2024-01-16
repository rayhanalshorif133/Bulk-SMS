@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">User /</span> User Profile Update
        </h4>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h5 class="mt-2">User's Profile Update</h5>
                </div>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('user.profile-update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-Profile_info"
                                    aria-controls="navs-pills-top-Profile_info" aria-selected="true">Profile Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-pills-top-password" aria-controls="navs-pills-top-password"
                                    aria-selected="false" tabindex="-1">Password</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="navs-pills-top-Profile_info" role="tabpanel">
                                <div>
                                    <label for="name" class="form-label required">Name</label>
                                    <input type="text" class="form-control" id="name" required name="name"
                                        value="{{ Auth::user()->name }}" />
                                </div>
                                <div class="mt-2">
                                    <label for="logo" class="form-label optional">Your Company Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" />
                                </div>
                                <div class="mt-3">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" class="form-control" id="email" required name="email"
                                        value="{{ Auth::user()->email }}" />
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-pills-top-password" role="tabpanel">
                                <div class="mt-3">
                                    <label for="old_password" class="form-label optional">Old Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="old_password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            name="old_password" placeholder="Enter your old password"
                                            aria-describedby="old_password" autocomplete="current-old_password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="password" class="form-label optional">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="Enter your new password" aria-describedby="password"
                                            autocomplete="current-password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="password_confirmation" class="form-label optional">Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" placeholder="Enter your new password confirmation"
                                            aria-describedby="password_confirmation"
                                            autocomplete="current-password_confirmation" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
@endpush
