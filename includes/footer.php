<!-- ======= Footer ======= -->
<?php
$startYear = 2023;
$thisYear = date('Y');
if ($startYear == $thisYear) {
    $output = $thisYear;
} else {
    $output = "{$startYear}&ndash;{$thisYear}";
}

?>
<footer id="footer">
    <div class="container">
        <!-- <h3>LPPO</h3> -->
        <!-- <p>Et aut eum quis fuga eos sunt ipsa nihil. Labore corporis magni eligendi fuga maxime saepe commodi placeat.</p> -->
        <!-- <div class="social-links">
            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
            <a href="https://www.facebook.com/lagunaprobation" class="facebook"><i class="bx bxl-facebook"></i></a>
            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        </div> -->
        <div class="copyright">
            &copy; Copyright <strong><span>LPPO <?= $output ?></span></strong>. All Rights Reserved
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

<!-- jquery -->
<!-- <script src="../js/jquery-3.7.1.min.js"></script> -->

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<!-- custom swalfire -->
<script src="js/swal.js"></script>

</body>

</html>
<?php ob_end_flush(); ?>