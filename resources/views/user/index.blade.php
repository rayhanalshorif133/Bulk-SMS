@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Users /</span> User list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">User's list</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover w-full" id="userTableId">
          <thead>
            <tr>
              <th>Email</th>
              <th>Api Key</th>
              <th>Type</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
      </div>
    </div>
    <!--/ Hoverable Table rows -->
</div>
@endsection
@push('script')
  	<script>
        $(function(){
            url = '/users';
            table = $('#userTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        render: function(data, type, row) {
                            return "name";
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return "Validity";
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return "Charge";
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return "Actions";
                        },
                        targets: 0,
                    },
                ]
            });
        });
  	</script>
@endpush