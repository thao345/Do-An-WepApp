<!-- Footer -->
<footer class="sticky-footer bg-white">
    <!-- <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; PACIFIC</span>
        </div>
    </div> -->
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

<script>

    // form validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    // tìm kiếm change text search
    $(document).ready(function () {
        $('.search-input').on('input', function () {
            var searchText = $(this).val().trim().toLowerCase();
            $('#myTable tbody tr').each(function () {
                var rowData = $(this).text().toLowerCase();
                if (rowData.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });


    // fullscreen
    var fullscreenButton = document.getElementById('fullscreenButton');
    var isFullscreen = false;

    fullscreenButton.addEventListener('click', function () {
        if (!isFullscreen) {
            enterFullscreen();
        } else {
            exitFullscreen();
        }
    });

    function enterFullscreen() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) { /* Firefox */
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) { /* IE/Edge */
            document.documentElement.msRequestFullscreen();
        }

        fullscreenButton.innerHTML = '<i class="fas fa-compress"></i>';
        isFullscreen = true;
    }
    function exitFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) { /* Firefox */
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE/Edge */
            document.msExitFullscreen();
        }

        fullscreenButton.innerHTML = '<i class="fas fa-expand"></i>';
        isFullscreen = false;
    }


</script>
</body>

</html>