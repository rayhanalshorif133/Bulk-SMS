@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">
        Developer Settings
    </h4>
    <div class="card p-5">
        <h5>Send SMS Configuration</h5>
        <p>
            <b>Base Url: <span class="text-primary">{{$base_url}}</span></b>
        </p>
        <b>Mobile Number: <span class="text-primary">
        +8801*********    
        </span></b>
        <div class="py-2">
            <table class="table table-striped">
                <thead>
                    <th>Method</th>
                    <th>URL</th>
                    <th>Body</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <span class="badge bg-label-primary">GET</span>
                        </td>
                        <td>
                            {<b>base_url</b>}/api/sendsms?api_key={<b>api_key</b>}&mobile_number={<b>mobile_number</b>}&text={<b>message</b>}
                        </td>
                        <td>
                            None
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="badge bg-label-success">POST</span>
                        </td>
                        <td>
                            {<b>base_url</b>}/api/sendsms
                        </td>
                        <td>
                            api_key (<b class="required">required</b>) <br>
                            mobile_number (<b class="required">required</b>)<br>
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