@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        Send SMS
    </h4>

    <div class="card">
        <div class="card-header">
           <h5>Send Testing Message</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{route('send-sms.send')}}">
                @csrf
                <div class="row g-2">
                    @role('admin')
                    <div class="col-12 mb-3">
                        <label for="phone" class="form-label required">Select User</label>
                        <select class="form-select" id="selected_user" required name="user_id">
                            <option disabled selected value="0">Select a user</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input class="d-none" required name="user_id" value="{{Auth::user()->id}}"/>
                    @endrole
                    <div class="col-12 mb-3">
                        <label for="phone" class="form-label required">Phone Number</label>
                        <input class="form-control" id="phone" required name="phone" value="8801"/>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="message" class="form-label required">Message</label>
                        <textarea class="form-control" id="message" required name="message"></textarea>
                    </div>
                    <div class="col-12 mb-3">
                        <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div> 
@endsection
@push('script')
@endpush