<!-- FOOTER-->
<footer class="footer" style="color: #123524">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
            <p class="no-margin-bottom">
                2025 &copy; Third Year College - University of Caloocan City. 
                <a target="_blank" href="https://templateshub.net" style="color: #47773f " >  Imperium  </a>.
            </p>
        </div>
    </div>
</footer>


</div>
</div>






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


<script>
    window.notificationsUrl = "{{ route('notifications.index') }}";
    window.markAllReadUrl = "{{ route('notifications.markAllRead') }}";
    window.csrfToken = "{{ csrf_token() }}";
</script>

<script src="/scripts/admin_notifications.js"></script>



 

</body>
</html>