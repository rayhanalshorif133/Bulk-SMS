@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Sender Information /</span> Sender list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">Sender's Information list</h5>
      <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover w-full" id="senderInfoTableId">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
              <th>API Key</th>
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
            
            url = '/sender-info';
            table = $('#senderInfoTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          const name = row.user.name;
                            return name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                           const sender_id = row.sender_id ? row.sender_id : "Not Set"; 
                            return sender_id;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                           const api_key = row.api_key ? row.api_key : "Not Set"; 
                            return api_key;
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