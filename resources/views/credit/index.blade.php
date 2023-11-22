@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Credit /</span> Credit's list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">
        <div class="d-flex justify-content-between">
          <h5 class="mt-2">Credit's list</h5>
          <button class="btn btn-sm btn-outline-primary" 
          data-bs-toggle="modal" data-bs-target="#createCredit">
            Add New
          </button>
        </div>
      </h5>
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
              {{-- <th>Actions</th> --}}
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
      </div>
    </div>
    <!--/ Hoverable Table rows -->
</div>

@include('credit.create')
@include('credit.show')
@include('credit.update')
@endsection
@push('script')
  	<script>
        $(function(){
          handleDataTable();
          handleCreateCredit();
        });


        const handleDataTable = () =>{
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
                    // {
                    //     render: function(data, type, row) {
                    //       var actions = `<div class="btn-group" role="group" aria-label="Basic example">
                    //           <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#showCredit" 
                    //             onClick="handleItemShowBtn(${row.id})">
                    //             <i class='bx bxs-show' ></i>
                    //             </button>
                    //             <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateCredit" 
                    //             onClick="handleItemEditBtn(${row.id})">
                    //             <i class="bx bx-edit-alt"></i>
                    //             </button>
                    //             <button type="button" class="btn btn-outline-danger btn-sm" 
                    //             onClick="handleItemDeleteBtn(${row.id})">
                    //                 <i class="bx bx-trash"></i>
                    //             </button>
                    //         </div>`;
                    //         return actions;
                    //     },
                    //     targets: 0,
                    // },
                ]
            });
        };


        const handleCreateCredit = () => {
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
          $("#credit_id").val(id);
          axios.get(`/credit/${id}/fetch`).then(function(res){
            const data = res.data.data;
            const senderInfos = data.senderInfos;
            $("#updateCredit_id").val(id);             
            $("#selected_update_user").val(data.user.name);
            $("#updateSmsBalance").val(data.balance);
            $("#updateAmount").val(data.amount);
            $("#update_fund").val(data.fund_id);
            $("#modifyStatus").val(data.status);
            $("#modifyTransection").val(data.transaction_id);
            $("#modifyNote").val(data.note);
            var html = "";
            senderInfos.map((item) => {
                // sender_info_id
                if(data.sender_info_id == item.id){
                  html += `<option value="${item.id}" selected>${item.sender_id}</option>`;
                }else{
                  html += `<option value="${item.id}">${item.sender_id}</option>`;
                }
                });
              $("#updateAppendSenderOptions").html(html);
          });
        };

        const handleItemShowBtn = (id) => {
          axios.get(`/credit/${id}/fetch`)
            .then((res)=>{
              console.log(res.data.data);
              const data = res.data.data;
              $(".showUserName").text(data.user.name);
              $(".showUserSenderId").text(data.sender_info.sender_id);
              $(".showAmount").text(data.amount);
              $(".showBalance").text(data.balance);
              $(".showTransactionId").text(data.transaction_id);
              $(".showFundName").text(data.fund.name);
              $(".showNote").text(data.note);
            });
        };

        const handleItemDeleteBtn = (id) => {
          console.log(id);
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
              axios.delete(`credit/${id}`)
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