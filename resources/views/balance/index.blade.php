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
        </div>
      </div>
      <div class="table-responsive text-nowrap p-3">
        @role('admin')
        <table class="table table-hover w-full" id="balanceTableId">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
              <th>Balance</th>
              <th>expired_at</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
        @else
        <table class="table table-hover w-full" id="balanceTableIdUser">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
              <th>Balance</th>
              <th>expired_at</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
        @endrole
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
            handleDataTable();
            handleCreateBalance();
          });


          const handleDataTable = () => {
            $('#balanceTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/balances',
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
                          // ${moment(row.expired_at).format('h:mm:ss a')} 
                          const expired_at = `<span> 
                            ${moment(row.expired_at).format('Do MMM, YYYY')} </span>`
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
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateBalance" 
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

            $('#balanceTableIdUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/balances',
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
                          // ${moment(row.expired_at).format('h:mm:ss a')} 
                          const expired_at = `<span> 
                            ${moment(row.expired_at).format('Do MMM, YYYY')} </span>`
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
                ]
            });
          };

          const handleCreateBalance = () => {
            $("#selected_user").on('change',function(){
              const id = $(this).val();
              $("#appendSenderOptions").html('');
              var html = "";
              axios.get(`/balances/fetch/sender-info/${id}/by-user`).then(function(res){
                const data = res.data.data;
                if(data.length > 0){
                  html +=  `<option disabled selected value="0">Select a sender ID</option>`;
                  data.map((item) => {
                    html += `<option value="${item.id}">${item.sender_id}</option>`;
                  });
                  $("#appendSenderOptions").append(html);
                }else{
                  
                  html = `<option disabled selected>No Sender ID</option>`;
                  $("#appendSenderOptions").append(html);
                }
              });
            });
          };

          const handleItemEditBtn = (id) => {
            axios.get(`/balances/fetch/${id}`).then(function(res){
              const balance = res.data.data?.balance;
              const senderInfo = res.data.data?.senderInfo;
              $("#updateBalanceID").val(id);             
              $("#selected_update_user").val(balance.user.name);
              $("#updateSmsBalance").val(balance.balance);
              $("#updateAmount").val(balance.amount);
              const date = moment(balance.expired_at).format('YYYY-MM-DD');
              $("#modifyExpiredDate").val(date);
              $("#modifyStatus").val(balance.status);
              var html = "";

              // html +=  `<option disabled selected value="0">Select a sender ID</option>`;
                senderInfo.map((item) => {
                  // sender_info_id
                  if(balance.sender_info_id == item.id){
                    html += `<option value="${item.id}" selected>${item.sender_id}</option>`;
                  }else{
                    html += `<option value="${item.id}">${item.sender_id}</option>`;
                  }
                  });
                $("#updateAppendSenderOptions").html(html);
            });
          };

          const handleItemDeleteBtn = (id) => {
             Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, delete it!"
            }).then((result) => {
              if (result.isConfirmed) {
                axios.delete(`balances/${id}`)
                  .then(function(res){
                    Swal.fire({
                      title: "Deleted!",
                      text: "Your file has been deleted.",
                      icon: "success"
                    });
                    location.reload();
                  });
              }
            });
        };
  	</script>
@endpush