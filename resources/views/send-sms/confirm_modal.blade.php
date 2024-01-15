  <!-- Modal -->
  <div class="modal fade" id="sms_send_confrim" tabindex="-1" style="display: none;" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header" style="border-bottom: 1px solid #c5c5c5;">
                  <h5 class="modal-title" id="sms_send_confrimTitle pb-1">
                    Confirmation Bulk SMS
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <h6 class="h6">SMS Balance: <span id="sms_balance"></span></h6>
                <h6 class="h6">Total Uploaded Number: <span id="sms_uploaded_number"></span></h6>
                {{-- <h6 class="h6">Total Valid Number: <span id="sms_valid_number"></span></h6>
                <h6 class="h6">Total Invalid Number: <span id="sms_invalid_number"></span></h6> --}}
                <h6 class="h6">Total Cost: <span id="sms_cost"></span></h6>
                <h6 class="h6">Total Duplicates Number: <span id="sms_duplicates_number"></span></h6>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                  </button>
                  <button type="button" class="btn btn-primary">
                    Confirm
                  </button>
              </div>
          </div>
      </div>
  </div>
