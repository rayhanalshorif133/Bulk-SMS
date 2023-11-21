@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Users /</span> User list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <div class="card-header">
        <div class="d-flex justify-content-between">
            <h5 class="mt-2">User's list</h5>
            <button class="btn btn-sm btn-outline-primary" 
              data-bs-toggle="modal" data-bs-target="#createNewUser">
              Add New
            </button>
        </div>
      </div>
      <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover w-full" id="userTableId">
          <thead>
            <tr>
              <th>#</th>
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
@include('user.create')
@include('user.update')
@endsection
@push('script')
  	<script>
        $(function(){
            handleDataTable();
            handleUserApiKeyGenarateBtn();
        });

        const handleDataTable = () => {
          url = '/users';
            table = $('#userTableId').DataTable({
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
                            return row.email;
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
                          const role = row.roles[0].name;
                            return role;
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
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateUser" 
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

        const handleUserApiKeyGenarateBtn = () => {
          $(".userApiKeyGenarateBtn").click(function(){
            $(this).find('i').toggleClass('fa-spin');
            axios.get('users/key-generate')
              .then(function(res){
                $("#user_api_key").val(res.data.data);
                $(".userApiKeyGenarateBtn").find('i').toggleClass('fa-spin');
              });   
          });

          $(".updateUserApiKeyGenarateBtn").click(function(){
            $(this).find('i').toggleClass('fa-spin');
            axios.get('users/key-generate')
              .then(function(res){
                $("#update_user_api_key").val(res.data.data);
                $(".updateUserApiKeyGenarateBtn").find('i').toggleClass('fa-spin');
              });
              
          });
        };  

        const handleItemEditBtn = (id) => {
          $("#user_id").val(id);
          axios.get(`users/${id}/fetch`)
            .then(function(res){
              const data = res.data.data;
              const role = data.roles[0].name;
              $("#updateEmail").val(data.email);
              $("#updateUserRole").val(role);
              $("#update_user_api_key").val(data.api_key);
              $("#update_user_status").val(data.status);
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
                axios.delete(`users/${id}`)
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