<div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-content">
                <form method="post" action="{{ route('saveUserContact') }}" id="saveUserContact">
                    @csrf

                    <div class="form-group">
                        <label for="modal_name">Name <span class="mandatory">*</span></label>
                        <input type="text" class="form-control character" onkeypress="return /^[a-zA-Z\. ]*$/.test(event.key)" id="modal_name" name="name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                        <label for="modal_email">Email</label>
                        <input type="email" class="form-control" id="modal_email" name="email" placeholder="Email">
                    </div>

                    <div class="form-group">
                        <label for="modal_mobile">Mobile <span class="mandatory">*</span></label>
                        <input type="text" class="form-control numeric" id="modal_mobile" maxlength="10" minlength="10" name="mobile" placeholder="Mobile" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary save_button" name="save_and_list" value="save_and_list">Add User</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary cancel_button" data-dismiss="modal">Close</button>
                <!-- <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button> -->
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $(document).on("input", ".number", function() {
            this.value = this.value.replace(/\D/g,'');  
        });
    </script>
@endsection