@extends('layouts.app')

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
                      <img
                        src="../assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      />
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
                      <img
                        src="../assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      />
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
                      <img
                        src="../assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      />
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
