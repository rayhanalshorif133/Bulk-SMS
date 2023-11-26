@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        Developer Settings
    </h4>
    <div class="card p-5">
        <h5>Send SMS Configuration</h5>
        <p>
            <b>API KEY: <span class="text-primary">{{auth()->user()->api_key}}</span></b>
        </p>

        <p>
            <b>API URL: <span class="text-primary">{{$base_url}}/api/sendsms</span></b>
        </p>
        <div class="py-2">
            <table class="table table-striped">
                <thead>
                    <th>Method</th>
                    <th>Parameters</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="badge bg-label-primary">GET</span> 
                            <br/>
                            or
                            <br/>
                            <span class="badge bg-label-success">POST</span>
                        </td>
                        <td>
                            api_key (<b class="required">required</b>) <br>
                            mobile_number (<b class="required">required</b>) {format : 8801*********}<br>
                            message (<b class="required">required</b>)
                        </td>
                    </tr>
                   
                    
                </tbody>
            </table>
        </div>      
    </div>
</div> 
@endsection
@push('script')
@endpush