@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Sender Information /</span> Sender list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mt-2">Sender's Information list</h5>
            @role('admin')
            <button class="btn btn-sm btn-outline-primary" 
            data-bs-toggle="modal" data-bs-target="#createNewSenderInfo">
              Add New
            </button>
            @endrole
        </div>
      </div>
      <div class="table-responsive text-nowrap p-3">
        @role('admin')
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
        @else
        <table class="table table-hover w-full" id="senderInfoTableIdUser">
          <thead>
            <tr>
              <th>#</th>
              <th>User Name</th>
              <th>Sender ID</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
        @endrole
      </div>
    </div>
    <!--/ Hoverable Table rows -->
</div>
@include('sender-info.create')
@include('sender-info.update')
@endsection
@push('script')
  	<script>
        $(function(){
          handleDataTable();
        });

        const handleDataTable = () =>{
            table = $('#senderInfoTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/sender-info',
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

            table = $('#senderInfoTableIdUser').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/sender-info',
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
                ]
            });

        };

        const handleItemEditBtn = (id) => {
          $("#sender-info-id").val(id);
          axios.get(`sender-info/${id}/fetch`)
            .then(function(res){
              const data = res.data.data;
              $("#update_user_id").val(data.user_id);
              $("#update_sender_id").val(data.sender_id);
              $("#update_api_key").val(data.api_key);
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
                axios.delete(`sender-info/${id}`)
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