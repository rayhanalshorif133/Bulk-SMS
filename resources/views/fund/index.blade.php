@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
            
            
    <h4 class="py-3 mb-4">
      <span class="text-muted fw-light">Fund Information /</span> Fund list
    </h4>
    
    
    <!-- Hoverable Table rows -->
    <div class="card">
      <h5 class="card-header">Fund's Information list</h5>
      <div class="table-responsive text-nowrap p-3">
        <table class="table table-hover w-full" id="fundTableId">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0"></tbody>
        </table>
      </div>
    </div>
    <!--/ Hoverable Table rows -->
</div>
@include('fund.create')
@include('fund.update')
@endsection
@push('script')
  	<script>
        $(function(){
            
            url = '/fund';
            table = $('#fundTableId').DataTable({
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
                          const name = row.name;
                            return name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                          var actions = `<div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateFund" 
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

            
        });



        const handleItemEditBtn = (id) => {
            $("#fund_id").val(id);             
            axios.get(`/fund/${id}/fetch`).then(function(res){
              const data = res.data.data;
              $("#updateFundName").val(data.name);
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