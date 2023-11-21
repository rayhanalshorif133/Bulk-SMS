<div class="modal fade" id="updateFund" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">
                    Update Fund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('fund.update')}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input id="fund_id" name="id" class="d-none"/>
                    <div class="col mb-3">
                        <label for="updateFundName" class="form-label required">Name</label>
                        <input class="form-control" id="updateFundName" placeholder="Enter a name" name="name" type="text"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>