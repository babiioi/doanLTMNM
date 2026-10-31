@extends('layouts.store')
@section('title', 'Đặt hàng | Mơ Màng')

@section('content')
<div class="mb-4">
    <a href="{{ route('cart.index') }}" class="text-decoration-none text-secondary">← Quay lại giỏ hàng</a>
    <h1 class="h2 fw-bold mt-3">Thông tin đặt hàng</h1>
    <p class="text-secondary">Kiểm tra thông tin nhận hàng và chọn phương thức thanh toán.</p>
</div>

<form method="POST" action="{{ route('checkout.store') }}">
    @csrf
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Thông tin người nhận</h2>

                <div class="mb-3">
                    <label class="form-label">Họ và tên *</label>
                    <input name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}"
                           class="form-control @error('customer_name') is-invalid @enderror" required maxlength="120">
                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Số điện thoại *</label>
                    <input name="customer_phone"
                        id="customer_phone"
                        value="{{ old('customer_phone', auth()->user()->phone) }}"
                        class="form-control @error('customer_phone') is-invalid @enderror"
                        required maxlength="30" placeholder="Ví dụ: 0901234567">
                    @error('customer_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                
                <div class="mb-3">
                    <label class="form-label">Tỉnh/Thành phố *</label>
                    <select id="province" class="form-select" required>
                        <option value="">Đang tải tỉnh/thành...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quận/Huyện *</label>
                    <select id="district" class="form-select" required disabled>
                        <option value="">Chọn tỉnh/thành trước</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phường/Xã *</label>
                    <select id="ward" class="form-select" required disabled>
                        <option value="">Chọn quận/huyện trước</option>
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Số nhà, tên đường *</label>
                    <input type="text"
                        id="street_address"
                        class="form-control"
                        value="{{ old('street_address', auth()->user()->street_address) }}"
                        placeholder="Ví dụ: 123 Nguyễn Trãi"
                        maxlength="300"
                        required>
                </div>


                <input type="hidden" name="shipping_address" id="shipping_address">


                <div class="mb-4">
                    <label class="form-label">Ghi chú đơn hàng (không bắt buộc)</label>
                    <textarea name="note" rows="2" class="form-control" maxlength="2000"
                              placeholder="Ví dụ: giao giờ hành chính">{{ old('note') }}</textarea>
                </div>

                <h2 class="h5 fw-bold mb-3">Phương thức thanh toán</h2>
                <label class="border rounded-3 p-3 d-flex gap-3 mb-2 w-100">
                    <input type="radio" name="payment_method" value="cod"
                           @checked(old('payment_method', 'cod') === 'cod') required>
                    <span><strong>Thanh toán khi nhận hàng (COD)</strong><br>
                        <small class="text-secondary">Thanh toán cho đơn vị giao hàng khi nhận được sản phẩm.</small></span>
                </label>
                <label class="border rounded-3 p-3 d-flex gap-3 w-100">
                    <input type="radio" name="payment_method" value="bank_transfer"
                           @checked(old('payment_method') === 'bank_transfer') required>
                    <span><strong>Chuyển khoản ngân hàng bằng QR</strong><br>
                        <small class="text-secondary">Sau khi đặt hàng, quét QR bằng ứng dụng ngân hàng để chuyển khoản. Cửa hàng sẽ đối soát và xác nhận thủ công.</small></span>
                </label>
                @error('payment_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="col-lg-5">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Đơn hàng của bạn</h2>
                @foreach($items as $item)
                    <div class="d-flex justify-content-between gap-3 mb-3">
                        <div>
                            <div class="fw-semibold">{{ $item['product']->name }}</div>
                            @if($item['variant'])<small class="text-secondary">Màu: {{ $item['variant']->color }}@if($item['size']) · Size: {{ $item['size'] }}@endif<br></small>@else<small class="text-secondary">@if($item['size'])Size: {{ $item['size'] }}@endif<br></small>@endif
                            <small class="text-secondary">Số lượng: {{ $item['quantity'] }}</small>
                        </div>
                        <div class="text-nowrap">{{ number_format($item['line_total'], 0, ',', '.') }}₫</div>
                    </div>
                @endforeach
                
                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Tiền hàng</span>
                    <span id="subtotal">{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Phí vận chuyển</span>
                    <span id="shipping-fee">Chưa tính</span>
                </div>

                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Tổng thanh toán</span>
                    <span id="grand-total" class="text-danger">
                        {{ number_format($total, 0, ',', '.') }}₫
                    </span>
                </div>

                <button type="button" id="calculate-shipping"
                        class="btn btn-outline-dark w-100 rounded-pill py-2 mt-3">
                    Tính phí vận chuyển
                </button>

                                
                <div id="shipping-message" class="small mt-2" role="status"></div>

                <button type="button" id="save-shipping-info"
                        class="btn btn-outline-secondary w-100 rounded-pill py-2 mt-2">
                    Lưu thông tin nhận hàng
                </button>

                <div id="save-message" class="small mt-2" role="status"></div>


                <button type="submit" class="btn btn-dark w-100 rounded-pill py-3 mt-4">Xác nhận đặt hàng</button>
                <p class="small text-secondary mt-3 mb-0">Tồn kho sẽ được kiểm tra lại trước khi đơn hàng được tạo.</p>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const province = document.getElementById('province');
    const district = document.getElementById('district');
    const ward = document.getElementById('ward');
    const street = document.getElementById('street_address');
    const address = document.getElementById('shipping_address');
    const fee = document.getElementById('shipping-fee');
    const total = document.getElementById('grand-total');
    const message = document.getElementById('shipping-message');
    const button = document.getElementById('calculate-shipping');
    const saveButton = document.getElementById('save-shipping-info');
    const saveMessage = document.getElementById('save-message');
    const customerName = document.querySelector('[name="customer_name"]');
    const customerPhone = document.getElementById('customer_phone');

    const savedProvinceId = @json(auth()->user()->shipping_province_id);
    const savedDistrictId = @json(auth()->user()->shipping_district_id);
    const savedWardCode = @json(auth()->user()->shipping_ward_code);
    const form = document.querySelector('form[action="{{ route('checkout.store') }}"]');

    const subtotal = Number(@json($total));
    let shippingFee = null;

    function resetFee() {
        shippingFee = null;
        fee.textContent = 'Chưa tính';
        total.textContent = subtotal.toLocaleString('vi-VN') + '₫';
        message.textContent = '';
    }

    
    async function getJson(url, options = {}) {
        const response = await fetch(url, options);
        const text = await response.text();

        let data;

        try {
            data = JSON.parse(text);
        } catch {
            throw new Error(
                'Máy chủ trả về HTML thay vì JSON. Hãy kiểm tra lỗi Laravel hoặc đoạn dd() trong CheckoutController.php.'
            );
        }

        if (!response.ok) {
            const detail = data.ghn_response
                ? JSON.stringify(data.ghn_response)
                : '';

            throw new Error(
                (data.message || 'Không tải được dữ liệu GHN.') +
                (detail ? ' Chi tiết: ' + detail : '')
            );
        }

        if (url.includes('/fee')) {
            return data;
        }

        if (data.code !== 200) {
            throw new Error(data.message || 'Không tải được dữ liệu GHN.');
        }

        return data.data;
    }


    function fillSelect(select, items, valueKey, labelKey, placeholder) {
        select.innerHTML = '';
        select.add(new Option(placeholder, ''));

        items.forEach(item => {
            select.add(new Option(item[labelKey], item[valueKey]));
        });

        select.disabled = false;
    }

    function updateAddress() {
        const provinceName = province.selectedOptions[0]?.text || '';
        const districtName = district.selectedOptions[0]?.text || '';
        const wardName = ward.selectedOptions[0]?.text || '';
        const streetName = street.value.trim();

        address.value = [
            streetName,
            ward.value ? wardName : '',
            district.value ? districtName : '',
            province.value ? provinceName : ''
        ].filter(Boolean).join(', ');
    }

    async function loadProvinces() {
        try {
            const data = await getJson(
                @json(route('checkout.ghn.provinces'))
            );

            fillSelect(province, data, 'ProvinceID', 'ProvinceName', 'Chọn tỉnh/thành');
        } catch (error) {
            province.innerHTML = '<option value="">Không tải được tỉnh/thành</option>';
            message.textContent = error.message;
        }
    }

    province.addEventListener('change', async function () {
        district.disabled = true;
        ward.disabled = true;
        district.innerHTML = '<option value="">Đang tải...</option>';
        ward.innerHTML = '<option value="">Chọn quận/huyện trước</option>';
        resetFee();

        if (!province.value) return;

        try {
            const data = await getJson(
                @json(url('/checkout/ghn/districts')) + '/' + province.value
            );

            fillSelect(district, data, 'DistrictID', 'DistrictName', 'Chọn quận/huyện');
        } catch (error) {
            message.textContent = error.message;
        }
    });

    district.addEventListener('change', async function () {
        ward.disabled = true;
        ward.innerHTML = '<option value="">Đang tải...</option>';
        resetFee();

        if (!district.value) return;

        try {
            const data = await getJson(
                @json(url('/checkout/ghn/wards')) + '/' + district.value
            );

            fillSelect(ward, data, 'WardCode', 'WardName', 'Chọn phường/xã');
        } catch (error) {
            message.textContent = error.message;
        }
    });

    ward.addEventListener('change', function () {
        resetFee();
        updateAddress();
    });

    street.addEventListener('input', function () {
        resetFee();
        updateAddress();
    });

    button.addEventListener('click', async function () {
        if (!province.value || !district.value || !ward.value || !street.value.trim()) {
            message.textContent = 'Vui lòng chọn đủ địa chỉ và nhập số nhà, tên đường.';
            return;
        }

        updateAddress();
        button.disabled = true;
        button.textContent = 'Đang tính phí...';

        try {
            const data = await getJson(
                @json(route('checkout.ghn.fee')),
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    body: JSON.stringify({
                        to_district_id: Number(district.value),
                        to_ward_code: ward.value
                    })
                }
            );

            shippingFee = Number(data.shipping_fee);
            fee.textContent = Number(shippingFee).toLocaleString('vi-VN') + '₫';
            total.textContent = (subtotal + shippingFee).toLocaleString('vi-VN') + '₫';
            message.textContent = 'Đã tính phí vận chuyển.';
        } catch (error) {
            resetFee();
            message.textContent = error.message;
        } finally {
            button.disabled = false;
            button.textContent = 'Tính phí vận chuyển';
        }
    });

    form.addEventListener('submit', function (event) {
        updateAddress();

        if (shippingFee === null) {
            event.preventDefault();
            message.textContent = 'Bà hãy tính phí vận chuyển trước khi đặt hàng nhé.';
        }
    });

    
    loadProvinces().then(async function () {
        if (!savedProvinceId) return;

        province.value = String(savedProvinceId);
        province.dispatchEvent(new Event('change'));

        try {
            const districts = await getJson(
                @json(url('/checkout/ghn/districts')) + '/' + savedProvinceId
            );

            fillSelect(district, districts, 'DistrictID', 'DistrictName', 'Chọn quận/huyện');

            if (!savedDistrictId) return;

            district.value = String(savedDistrictId);
            district.dispatchEvent(new Event('change'));

            const wards = await getJson(
                @json(url('/checkout/ghn/wards')) + '/' + savedDistrictId
            );

            fillSelect(ward, wards, 'WardCode', 'WardName', 'Chọn phường/xã');

            if (savedWardCode) {
                ward.value = String(savedWardCode);
            }

            updateAddress();
        } catch (error) {
            console.error('Không thể tải địa chỉ đã lưu:', error);
        }
    });

    saveButton.addEventListener('click', async function () {
        updateAddress();

        if (
            !customerName.value.trim() ||
            !customerPhone.value.trim() ||
            !province.value ||
            !district.value ||
            !ward.value ||
            !street.value.trim()
        ) {
            saveMessage.className = 'small mt-2 text-danger';
            saveMessage.textContent = 'Bà hãy nhập đủ thông tin nhận hàng trước khi lưu nhé.';
            return;
        }

        saveButton.disabled = true;
        saveButton.textContent = 'Đang lưu...';

        try {
            const response = await fetch(
                @json(route('checkout.save-shipping-info')),
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token())
                    },
                    body: JSON.stringify({
                        customer_name: customerName.value.trim(),
                        customer_phone: customerPhone.value.trim(),
                        street_address: street.value.trim(),
                        shipping_address: address.value,
                        province_id: Number(province.value),
                        district_id: Number(district.value),
                        ward_code: ward.value
                    })
                }
            );

            const result = await response.json();

            if (!response.ok) {
                throw new Error(
                    result.message || 'Không lưu được thông tin nhận hàng.'
                );
            }

            saveMessage.className = 'small mt-2 text-success';
            saveMessage.textContent = 'Đã lưu thông tin nhận hàng thành công!';
        } catch (error) {
            saveMessage.className = 'small mt-2 text-danger';
            saveMessage.textContent = error.message;
        } finally {
            saveButton.disabled = false;
            saveButton.textContent = 'Lưu thông tin nhận hàng';
        }
    });

});
</script>

@endsection
