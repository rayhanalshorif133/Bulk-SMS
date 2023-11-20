@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Balance /</span> Balance list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mt-2">User's Balance list</h5>
            <button class="btn btn-sm btn-outline-primary" 
              data-bs-toggle="modal" data-bs-target="#createNewBalance">
              Add New
            </button>
        </div>
      </div>
      <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover w-full" id="balanceTableId">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
              <th>Balance</th>
              <th>amount</th>
              <th>expired_at</th>
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
@include('balance.create')
@include('balance.update')
@endsection

@push('script')
  	<script>
        $(function(){
            handeDataTable();
          });


          const handeDataTable = () => {
            url = '/balances';
            table = $('#balanceTableId').DataTable({
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
                          return row.balance;
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
                          const expired_at = `<span>${moment(row.expired_at).format('h:mm:ss a')} <br/> ${moment(row.expired_at).format('MMM Do YYYY')} </span>`
                          return expired_at;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          var status = "";
                          if(row.status == 'active'){
                            status = `<span class="badge bg-label-primary">${row.status}</span>`
                          }else{
                            status = `<span class="badge bg-label-danger">${row.status}</span>`
                          }
                          return status;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          var actions = `<div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateSenderInfo" 
                                onClick="handleItemEditBtn(${row.id})">
                                <i class="bx bx-edit-alt"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" 
                                onClick="handleItemDeleteBtn(${row.id})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>`;
                            return actions;
                        },
                        targets: 0,
                    },
                ]
            });
          };
  	</script>
@endpush