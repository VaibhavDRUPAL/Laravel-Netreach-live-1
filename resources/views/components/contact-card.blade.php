<div class="col-12 col-sm-4 mx-auto">
    <div class="d-flex">
        <div class="img">
            <img src="{{ $imageUrl }}" style="height: 100px; widht:100px" />
        </div>
        <div class="mx-2"></div>
        <div class="content">
            <strong>{{ $name }}</strong>
            <p>{{ $region }}</p>
            <strong> <a href="tel:{{ $phone }}">{{ $phone }}</a> </strong>
            <div class="main-content d-flex mt-2">
                <div class="column">
                    <a href="{{ $whatsappUrl }}">
                        <img src="{{ asset('assets/img/web/whatsappbk.png') }}">
                    </a>
                </div>
                <div style="width: 10px"></div>
                <div class="column">
                    <a href="{{ $instagramUrl }}">
                        <img src="{{ asset('assets/img/web/instabk.png') }}">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr />
</div>
