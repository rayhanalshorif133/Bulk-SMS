@extends('layouts.app')

@section('style')
<style>
    .w-full{
        width: 100%;
    }
</style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Send SMS /</span> Bulk SMS File Log list
        </h4>


        <!-- Hoverable Table rows -->
        <div class="card">
            <div class="card-header">
                <h5 class="mt-2">Bulk SMS File Log list</h5>
                <hr />
                <div class="row mx-auto w-full">
                    <div class="col-md-2 mx-auto">
                        <div class="card mb-3">
                            <div class="card-body text-center flex">
                                <h5 class="card-title">Total SMS:</h5>
                                <span class="badge bg-label-primary">{{ $total_send_sms }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mx-auto">
                        <div class="card mb-3">
                            <div class="card-body text-center flex">
                                <h5 class="card-title">Total Success:</h5>
                                <span class="badge bg-label-success">{{ $total_success_sms }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mx-auto">
                        <div class="card mb-3">
                            <div class="card-body text-center flex">
                                <h5 class="card-title">Total Failed:</h5>
                                <span class="badge bg-label-primary">{{ $total_failed_sms }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="table-responsive text-nowrap p-3">
                <table class="table table-hover w-full" id="smsBulkFileLogTableId">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sender ID</th>
                            <th>Sender Phone Number</th>
                            <th>Message</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0"></tbody>
                </table>

            </div>
        </div>
        <!--/ Hoverable Table rows -->
    </div>
@include('send-sms.showMessageModal')
@endsection
@push('script')
    <script>
        $(function() {
            handleDataTable();
        });
        const handleDataTable = () => {
            table = $('#smsBulkFileLogTableId').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [6, 'asc']
                ],
                ajax: '/send-sms/bulk-sms-file',
                columns: [{
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
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
                            return row.mobile_number;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            const message = row.message ? row.message : "Not Set";

                            // get 50 characters
                            var message_20 = message.substring(0, 20);
                            // get massage lenght
                            const length = message.length;
                            if (length > 20) {
                                message_20 = message_20 + " ...";
                                message_20 = message_20 +
                                    `<a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#showMessageModal"
                                    onclick="handleShowMessage(${row.id})">See More</a>`
                            }
                            return message_20;

                            if (row.message) {
                                return `<button type="button" class="btn btn-sm btn-primary" >See More</button>`;
                            }
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            var type = "";
                            if (row.type == 1) {
                                type = '<span class="badge bg-label-primary">Portal</span>';
                            } else {
                                type = '<span class="badge bg-label-info">API</span>';
                            }
                            return type;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            var status = "";
                            if (row.status == 1) {
                                status = '<span class="badge bg-label-success">Success</span>';
                            } else {
                                status = '<span class="badge bg-label-danger">Failed</span>';
                            }
                            return status;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            const created_date_time = `<span>
                                ${moment(row.created_date_time).format('HH:MM a')} </br>
                                ${moment(row.created_date_time).format('Do MMM, YYYY')}
                                </span>`;

                            return created_date_time;
                        },
                        targets: 0,
                    },
                ]
            });


        };


        const handleShowMessage = (id) => {
            axios.get(`/send-sms/bulk-sms-file/${id}/fetch`)
                .then(function(res) {
                    const data = res.data.data;
                    $('#message_details_show').text(data.message);
                });
        };
    </script>
@endpush
