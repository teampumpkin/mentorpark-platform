<form action="{{ route('frontend.master-classes.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="upper_section mb-4">


        <div class="mb-2">
            <label class="form-label" for="name">Masterclass Name</label>
            <input type="text" name="name" id="name" class="form-control" required/>
        </div>
        <div class="mb-2">
            <label class="form-label d-block">Masterclass Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter Description"
                      required></textarea>
        </div>


        <!-- Banner Image Upload Card -->
        <div class="banner-upload-card" onclick="document.getElementById('banner_image').click();">
            <!-- Example SVG icon -->
            <svg width="56" height="53" viewBox="0 0 56 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M55.6248 25.1666V42.1666C55.7912 43.6021 55.6308 45.0567 55.1557 46.4215C54.6806 47.7863 53.903 49.026 52.8811 50.0479C51.8592 51.0698 50.6195 51.8473 49.2547 52.3225C47.8899 52.7976 46.4353 52.958 44.9998 52.7916H10.9998C9.56424 52.958 8.10967 52.7976 6.74486 52.3225C5.38005 51.8473 4.14034 51.0698 3.11847 50.0479C2.09659 49.026 1.31901 47.7863 0.843887 46.4215C0.368761 45.0567 0.208393 43.6021 0.374778 42.1666V13.8332C0.208393 12.3977 0.368761 10.9431 0.843887 9.57831C1.31901 8.2135 2.09659 6.97379 3.11847 5.95192C4.14034 4.93004 5.38005 4.15246 6.74486 3.67733C8.10967 3.20221 9.56424 3.04184 10.9998 3.20823H33.6665C34.23 3.20823 34.7705 3.43211 35.1691 3.83062C35.5676 4.22914 35.7915 4.76964 35.7915 5.33323C35.7915 5.89681 35.5676 6.43731 35.1691 6.83583C34.7705 7.23434 34.23 7.45823 33.6665 7.45823H10.9998C6.53161 7.45823 4.62478 9.36506 4.62478 13.8332V40.0416L11.8214 32.8449C12.3564 32.3141 13.0795 32.0162 13.8331 32.0162C14.5867 32.0162 15.3098 32.3141 15.8448 32.8449L18.5081 35.5082C18.7729 35.7678 19.129 35.9132 19.4998 35.9132C19.8706 35.9132 20.2266 35.7678 20.4914 35.5082L34.4881 21.5116C35.0231 20.9807 35.7462 20.6829 36.4998 20.6829C37.2534 20.6829 37.9765 20.9807 38.5115 21.5116L51.3748 34.3749V25.1666C51.3748 24.603 51.5987 24.0625 51.9972 23.664C52.3957 23.2654 52.9362 23.0416 53.4998 23.0416C54.0634 23.0416 54.6039 23.2654 55.0024 23.664C55.4009 24.0625 55.6248 24.603 55.6248 25.1666ZM16.6466 15.9582C15.7059 15.9609 14.8047 16.3367 14.1409 17.0033C13.4771 17.6699 13.1051 18.5726 13.1064 19.5133C13.1077 20.454 13.4823 21.3558 14.1479 22.0205C14.8136 22.6852 15.7158 23.0586 16.6565 23.0586C17.5972 23.0586 18.4995 22.6852 19.1651 22.0205C19.8308 21.3558 20.2054 20.454 20.2067 19.5133C20.208 18.5726 19.8359 17.6699 19.1721 17.0033C18.5084 16.3367 17.6071 15.9609 16.6664 15.9582H16.6466ZM46.5015 8.25156L47.1248 7.63106V13.8332C47.1248 14.3968 47.3487 14.9373 47.7472 15.3358C48.1457 15.7343 48.6862 15.9582 49.2498 15.9582C49.8134 15.9582 50.3539 15.7343 50.7524 15.3358C51.1509 14.9373 51.3748 14.3968 51.3748 13.8332V7.63106L51.9981 8.25156C52.4009 8.62692 52.9338 8.83127 53.4843 8.82156C54.0348 8.81184 54.56 8.58883 54.9494 8.19949C55.3387 7.81015 55.5617 7.28489 55.5714 6.73437C55.5812 6.18385 55.3768 5.65106 55.0015 5.24823L50.7515 0.998225C50.3527 0.600973 49.8127 0.37793 49.2498 0.37793C48.6869 0.37793 48.1469 0.600973 47.7481 0.998225L43.4981 5.24823C43.1228 5.65106 42.9184 6.18385 42.9281 6.73437C42.9378 7.28489 43.1609 7.81015 43.5502 8.19949C43.9395 8.58883 44.4648 8.81184 45.0153 8.82156C45.5658 8.83127 46.0986 8.62692 46.5015 8.25156Z"
                    fill="#C8CED4"/>
            </svg>

            <span class="banner-upload-text">Upload a banner image</span>
        </div>
        <!-- Hidden File Input -->
        <input type="file" name="banner_image" id="banner_image" accept="image/*" style="display:none"/>
        <div id="banner_preview" class="mt-3"></div>
    </div>

    <div class="master_classes">
        <div id="repetitive_container">
            @include('frontend._partial._session_form', ['number' => 0])
        </div>



        <div class="col-12 mt-3">
            <button type="button" class="btn btn-outline-secondary rounded-pill" id="add_session_btn">+ Add more
                sessions
            </button>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label" for="mentees">Add Mentees</label>
        <select class="form-control select2 multi-select" name="mentees[]" id="mentees" multiple required>
            <option value="">Select</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label" for="attachments">Upload attachments</label>
            <input type="file" name="attachments[]" id="attachments" class="form-control" multiple/>
        </div>
        <div class="col-md-6">
            <label class="form-label d-block">Notifications</label>
            <div class="toggle-btn-group">
                <input type="radio" id="email" name="contact_method" value="email" checked/>
                <label for="email">Email</label>
                <input type="radio" id="whatsapp" name="contact_method" value="whatsapp"/>
                <label for="whatsapp">WhatsApp</label>
            </div>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="price">Pricing of masterclass</label>
            <input type="number" name="price" id="price" class="form-control"/>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="discount_type">Masterclass Discount Type</label>
            <select name="discount_type" class="form-control" id="discount_type">
                <option value="percent">Percent</option>
                <option value="amount">Amount</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label" for="session_price_discount">Masterclass Price Discount</label>
            <input type="number" name="session_price_discount"
                   id="session_price_discount" class="form-control" placeholder="(if available)"/>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Masterclass</button>
    </div>
</form>
