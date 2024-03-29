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

                        <div class="row">
                            <div class="col-xl-9">
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
                                                <label for="phone" class="form-label required">Phone Number</label>
                                                <span id="phone_csv_file_input"></span>
                                                <small class="text-danger">Upload CSV, TXT or XLSX file</small>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label for="message" class="form-label required">
                                                Message (Total Character: <span id="total_character" style="color: #0644b8">0</span>)
                                            </label>
                                            <span style="margin-left: 10px">SMS Count: <span id="sms_count" class="badge bg-primary">0</span></span>
                                            <textarea class="form-control" rows="3" id="message" required name="message"></textarea>
                                            <input class="d-none" name="sms_count" id="sms_count_input_id" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            <button type="submit" class="btn btn-sm btn-primary">Send SMS</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="d-flex">
                                    <h4 class="mx-1 mt-1" style="color: #696CFF;font-size:16px">Bulk SMS File Example:</h4>
                                    <a class="mx-1" style="color: #b84806" title="Download Bulk SMS Example Txt File"
                                    href="{{ asset('assets/bulk_sms_example.txt') }}" download>
                                        <i class='bx bxs-download'></i>
                                    </a>
                                </div>
                                <hr/>
                                <p style="color: #000000;font-size:14px">Phone Number:</p>
                                <p style="color: #000000;font-size:14px">88017XXXXXXXX</p>
                                <p style="color: #000000;font-size:14px">88019XXXXXXXX</p>
                                <p style="color: #000000;font-size:14px">88018XXXXXXXX</p>
                                <p style="color: #000000;font-size:14px">88016XXXXXXXX</p>
                                <p style="color: #000000;font-size:14px">88015XXXXXXXX</p>
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
            countCharacter();
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

        const countCharacter = () => {
            $("#message").keyup(function() {
                const message = $(this).val();
                const total_character = message.length;
                $("#total_character").html(total_character);

                // count sms
                const sms_count = Math.ceil(total_character / 140);
                $("#sms_count").html(sms_count);
                $("#sms_count_input_id").val(sms_count);
            });
        };


        const bulkSMS = () => {
            const html =
                `<input class="form-control" id="phone_csv_file" required type="file" name="phone_csv_file" accept=".csv, .txt, .xlsx"/>`;
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
            $("#sms_send_confrim").modal("show");
            $("#phone_csv_file_id").val(bulk_sms_file_id);
            axios.get(`/send-sms/csv-info/${bulk_sms_file_id}/fetch`)
                .then(function(response) {
                    const data = response.data.data;
                    const is_confirmed = data.is_confirmed;
                    const numbers = data.numbers;
                    $("#sms_balance").html(data.sms_balance);
                    $("#sms_uploaded_number").html(data.sms_uploaded_number);
                    $("#sms_cost").html(data.sms_cost);
                    $("#sms_duplicates_number").html(data.sms_duplicates_number);
                    $("#sms_valid_number").html(data.sms_valid_number);
                    $("#sms_invalid_number").html(data.sms_invalid_number);

                    // get unique numbers
                    const unique_numbers = [...new Set(numbers)];
                    let html = "";
                    unique_numbers.forEach((item, index) => {
                        // find count of same item
                        const count = numbers.filter((number) => number == item).length;
                        if (count > 1) {
                            html += `<tr>
                                <td>${index + 1}</td>
                                <td>${item} (${count})</td>
                            </tr>`;
                        }

                    });
                    $("#sms_duplicates_number_list").html(html);

                    if(is_confirmed == true){
                        $("#confirmBtn").removeClass("d-none");
                        $("#alert_low_balance").addClass("d-none");
                    }else{
                        $("#confirmBtn").addClass("d-none");
                        $("#alert_low_balance").removeClass("d-none");
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        };
    </script>
@endpush
