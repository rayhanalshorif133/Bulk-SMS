@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            Send SMS
        </h4>

        <div class="card">
            <div class="card-header">
                <h5>Send Message</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('send-sms.send') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-2">
                        @role('admin')
                            <div class="col-12 mb-3">
                                <label for="phone" class="form-label required">Select User</label>
                                <select class="form-select" id="selected_user" required name="user_id">
                                    <option disabled selected value="0">Select a user</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input class="d-none" required name="user_id" value="{{ Auth::user()->id }}" />
                        @endrole
                        <div class="col-xl-12">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-pills mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link active nav-button single_sms_nav"
                                            role="tab" data-bs-toggle="tab" data-bs-target="#single_sms"
                                            aria-controls="single_sms" aria-selected="true">Single SMS</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button type="button" class="nav-link nav-button bulk_sms_nav" role="tab"
                                            data-bs-toggle="tab" data-bs-target="#bulk_sms" aria-controls="bulk_sms"
                                            aria-selected="false" tabindex="-1">Bulk SMS</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <input class="d-none" required name="sms_type" value="single" id="sms_type" />
                                    {{-- single --}}
                                    <div class="tab-pane fade active show" id="single_sms" role="tabpanel">
                                        <div class="col-12 mb-3">
                                            <label for="phone" class="form-label required">Phone Number</label>
                                            <span id="phone_input">
                                                <input class="form-control" id="phone" required name="phone"
                                                    value="8801" />
                                            </span>
                                        </div>
                                    </div>
                                    {{-- bulk --}}
                                    <div class="tab-pane fade" id="bulk_sms" role="tabpanel">
                                        <div class="col-12 mb-3">
                                            <label for="phone" class="form-label required">Phone Number (csv)</label>
                                            <span id="phone_csv_file_input"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="message" class="form-label required">Message</label>
                                        <textarea class="form-control" id="message" required name="message"></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('send-sms.confirm_modal')
@endsection
@push('script')
    <script>
        $(function() {
            handleSmsType();
            $(".nav-button").click(function() {
                const sms_type = $(this).attr("data-bs-target");
                if (sms_type == '#bulk_sms') {
                    bulkSMS();
                } else {
                    const html =
                        `<input class="form-control" id="phone" required name="phone" value="8801" />`;
                    $("#phone_input").html(html);
                    $("#phone_csv_file_input").html("");
                    $("#sms_type").val("single");
                }
            });
        });

        const handleSmsType = () => {
            const current_url = window.location.href;
            if (!current_url.includes("?type=")) {
                return;
            }
            $(".bulk_sms_nav").click();
            bulkSMS();
            hanldleCSVFileInfo();
        };


        const bulkSMS = () => {
            const html =
                `<input class="form-control" id="phone_csv_file" required type="file" name="phone_csv_file" accept=".csv"/>`;
            $("#phone_csv_file_input").html(html);
            $("#phone_input").html("");
            $("#sms_type").val("bulk");
        };

        const hanldleCSVFileInfo = () => {
            const current_url = window.location.href;
            if (!current_url.includes("bulk_sms_file_id=")) {
                return;
            }
            const bulk_sms_file_id = current_url.split("bulk_sms_file_id=")[1];
            console.log(bulk_sms_file_id);
            $("#sms_send_confrim").modal("show");
            axios.get(`/send-sms/csv-info/${bulk_sms_file_id}/fetch`)
                .then(function(response) {
                    const data = response.data.data;
                    console.log(data);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };
    </script>
@endpush
