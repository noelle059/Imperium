<!-- FOOTER-->
<footer class="footer" style="color: #123524">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            <p class="no-margin-bottom">
                2025 &copy; Third Year College - University of Caloocan City.
                <a target="_blank" href="https://templateshub.net" style="color: #47773f "> Imperium </a>.
            </p>
        </div>
    </div>
</footer>

</div>
</div>



<!-- Add this script tag in the <head> or before closing </body> tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- SWEET ALERTS CDN LINK --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>

{{-- INCLUDE ADMIN MODAL FILE --}}
@include('admin.modal.subjectModals')
@include('admin.modal.accountModals')

{{-- SWEETALERT INCLUDE FILE --}}
@include('admin.sweetAlerts.subjectAlert')
@include('admin.sweetAlerts.accountAlert')


{{-- INCLUDE NOTIFICATION MODAL --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- JavaScript files -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/popper.js/umd/popper.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="/vendor/chart.js/Chart.min.js"></script>
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/js/charts-home.js"></script>
<script src="/js/front.js"></script>



</body>

</html>


<script>
    window.notificationsUrl = "{{ route('notifications.index') }}";
    window.markAllReadUrl = "{{ route('notifications.markAllRead') }}";
    window.csrfToken = "{{ csrf_token() }}";
</script>
<script src="/scripts/admin_notifications.js"></script>
