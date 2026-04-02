<!DOCTYPE html>
<html lang="en">
<head>
    @include('fixed.head')
</head>
<body>
    @include('fixed.header')


    <div class="content">
        @yield('content')
    </div>

    @include('fixed.footer')

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="cartToast" class="toast align-items-center text-white bg-primary border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Product added to cart!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="confirmModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3" id="confirmModalIcon"></i>
                    <p class="mb-0" id="confirmModalMessage">Are you sure?</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4" id="confirmModalBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @include('fixed.script')

    <script>
        var confirmCallback = null;
        var confirmModal = null;

        window.showConfirm = function(message, callback, options) {
            options = options || {};
            document.getElementById('confirmModalLabel').textContent = options.title || 'Confirm Action';
            document.getElementById('confirmModalMessage').textContent = message;
            document.getElementById('confirmModalIcon').className = 'fas fa-3x mb-3 ' + (options.icon || 'fa-exclamation-triangle text-warning');
            var btn = document.getElementById('confirmModalBtn');
            btn.className = 'btn rounded-pill px-4 ' + (options.btnClass || 'btn-danger');
            btn.textContent = options.btnText || 'Confirm';
            confirmCallback = callback;
            confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
        }

        $(document).ready(function() {
            $('#confirmModalBtn').on('click', function() {
                if (confirmCallback) {
                    confirmCallback();
                    confirmCallback = null;
                }
                confirmModal.hide();
            });
        });
    </script>

    @yield('additional-scripts')
</body>
</html>
