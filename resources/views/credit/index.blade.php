@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Credit /</span> Credit's list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">Credit's list</h5>
      <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover w-full" id="creditTableId">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
              <th>Fund Name</th>
              <th>amount</th>
              <th>Balance</th>
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
            url = '/credit';
            table = $('#creditTableId').DataTable({
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
                            return row.user.name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          return row.sender_info.sender_id;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          return row.fund.name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          return row.amount;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          return row.balance;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          return row.status;
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