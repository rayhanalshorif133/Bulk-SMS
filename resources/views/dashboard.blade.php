@extends('layouts.app')

@section('styles')
<style>
  .box{
    height: 35px;
    weight: 30px;
    border-radius: 4px;
    display:flex;
    justify-content: center; 
    place-items: center;
  }
  .box i{
    font-size: 25px;
  }

  .mail-send{
    background-color: #dbf7cc;
  }
  .mail-send i{
    color: #5bbc26;
  }

  .today_sent{
    background-color: #b6ddfc;
  }

  .today_sent i{
    color: #2186d9;
  }

  .last_transaction{
    background-color: #b6ddfc;
  }
  .last_transaction i{
    color: #2186d9;
  }
  

</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-6 col-md-4 order-1">
          <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <div class="box mail-send">
                        <i class='bx bx-mail-send'></i>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">SMS Balance</span>
                  <h3 class="card-title mb-2">{{$sms_balance}}</h3>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <div class="box today_sent">
                        <i class='bx bxs-send'></i>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Today's Sent</span>
                  <h3 class="card-title mb-2">{{$today_sent}}</h3>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <div class="box last_transaction">
                        <i class='bx bx-transfer-alt'></i>
                      </div>
                  </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Last Transaction</span>
                  <h3 class="card-title mb-2">{{$last_transaction}}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-4 order-1">
          <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <img
                        src="../assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      />
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Today's Portal Sent</span>
                  <h3 class="card-title mb-2">{{$today_portal_sent}}</h3>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                      <img
                        src="../assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      />
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Today's Api Sent</span>
                  <h3 class="card-title mb-2">{{$today_api_sent}}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
