
                            </div>
                        </div>

                        {{-- Thành tiền --}}
                        <div class="fw-bold text-nowrap">
                            {{ number_format($item['line_total'], 0, ',', '.') }}₫
                        </div>

                    </div>
                @endforeach

            </div>
        </div>

        {{-- Tóm tắt đơn hàng --}}
        <div class="col-lg-4">
            <div class="bg-white border rounded-4 p-4">
                <h2 class="h5 fw-bold mb-3">Tóm tắt đơn hàng</h2>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Sản phẩm đã chọn</span>
                    <span id="selectedCount">0</span>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Tạm tính</span>
                    <strong id="selectedTotal">0₫</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Phí vận chuyển</span>
                    <span>Tính tại bước thanh toán</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                    <span>Tổng cộng</span>
                    <span class="text-danger" id="selectedGrandTotal">0₫</span>
                </div>

                <button type="submit"
                        form="selectedCheckoutForm"
                        id="checkoutButton"
                        class="btn btn-dark w-100 rounded-pill py-3"
                        disabled>
                    Thanh toán sản phẩm đã chọn
                </button>

                <p class="small text-secondary mt-3 mb-0">
                    Sản phẩm không được chọn vẫn sẽ nằm trong giỏ hàng.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const selectAll = document.getElementById('selectAll');
            const selectedCount = document.getElementById('selectedCount');
            const selectedTotal = document.getElementById('selectedTotal');
            const selectedGrandTotal = document.getElementById('selectedGrandTotal');
            const checkoutButton = document.getElementById('checkoutButton');

            function updateSummary() {
                let count = 0;
                let total = 0;

                checkboxes.forEach(function (checkbox) {
                    if (checkbox.checked) {
                        count++;
                        total += Number(checkbox.dataset.price) *
                                 Number(checkbox.dataset.quantity);
                    }
                });

                const formatted = total.toLocaleString('vi-VN') + '₫';

                selectedCount.textContent = count;
                selectedTotal.textContent = formatted;
                selectedGrandTotal.textContent = formatted;
                checkoutButton.disabled = count === 0;

                const allChecked = [...checkboxes].every(cb => cb.checked);

                selectAll.textContent = allChecked
                    ? 'Bỏ chọn tất cả'
                    : 'Chọn tất cả';
            }

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', updateSummary);
            });

            selectAll.addEventListener('click', function () {
                const allChecked = [...checkboxes].every(cb => cb.checked);

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = !allChecked;
                });

                updateSummary();
            });

            updateSummary();
        });
    </script>

@endif
@endsection
