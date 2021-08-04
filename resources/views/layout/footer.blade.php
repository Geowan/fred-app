
<footer id="footer-part">
    <div class="footer-top pt-40 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about mt-40">
                        <div class="logo">
                            <a href="index.html#"><img src="images/logo-2.png" alt="Logo"></a>
                        </div>
                        <p>Gravida nibh vel velit auctor aliquetn quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate.</p>
                    </div> <!-- footer about -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-link mt-40">
                        <div class="footer-title pb-25">
                            <h6>Sitemap</h6>
                        </div>
                        <ul>
                            <li><a href="index.html"><i class="fa fa-angle-right"></i>Home</a></li>
                            <li><a href="about.html"><i class="fa fa-angle-right"></i>About us</a></li>
                            <li><a href="courses.html"><i class="fa fa-angle-right"></i>Courses</a></li>
                            <li><a href="blog.html"><i class="fa fa-angle-right"></i>News</a></li>
                            <li><a href="events.html"><i class="fa fa-angle-right"></i>Event</a></li>
                        </ul>
                        <ul>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Gallery</a></li>
                            <li><a href="shop.html"><i class="fa fa-angle-right"></i>Shop</a></li>
                            <li><a href="teachers.html"><i class="fa fa-angle-right"></i>Teachers</a></li>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Support</a></li>
                            <li><a href="contact.html"><i class="fa fa-angle-right"></i>Contact</a></li>
                        </ul>
                    </div> <!-- footer link -->
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-link support mt-40">
                        <div class="footer-title pb-25">
                            <h6>Support</h6>
                        </div>
                        <ul>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>FAQS</a></li>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Privacy</a></li>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Policy</a></li>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Support</a></li>
                            <li><a href="index.html#"><i class="fa fa-angle-right"></i>Documentation</a></li>
                        </ul>
                    </div> <!-- support -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-address mt-40">
                        <div class="footer-title pb-25">
                            <h6>Contact Us</h6>
                        </div>
                        <ul>
                            <li>
                                <div class="icon">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="cont">
                                    <p>143 castle road 517 district, kiyev port south Canada</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="cont">
                                    <p>+3 123 456 789</p>
                                </div>
                            </li>
                            <li>
                                <div class="icon">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <div class="cont">
                                    <p>info@yourmail.com</p>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- footer address -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- footer top -->
</footer>








<!--====== jquery js ======-->
<script src="/assets/js/vendorjs/modernizr-3.6.0.min.js"></script>
<script src="/assets/js/vendorjs/jquery-1.12.4.min.js"></script>

<!--====== Bootstrap js ======-->
<script src="/assets/js/bootstrap.min.js"></script>

<!--====== Slick js ======-->
<script src="/assets/js/slick.min.js"></script>

<!--====== Magnific Popup js ======-->
<script src="/assets/js/jquery.magnific-popup.min.js"></script>

<!--====== Counter Up js ======-->
<script src="/assets/js/waypoints.min.js"></script>
<script src="/assets/js/jquery.counterup.min.js"></script>

<!--====== Nice Select js ======-->
<script src="/assets/js/jquery.nice-select.min.js"></script>

<!--====== Nice Number js ======-->
<script src="/assets/js/jquery.nice-number.min.js"></script>

<!--====== Count Down js ======-->
<script src="/assets/js/jquery.countdown.min.js"></script>

<!--====== Validator js ======-->
<script src="/assets/js/validator.min.js"></script>

<!--====== Ajax Contact js ======-->
<script src="/assets/js/ajax-contact.js"></script>

<!--====== Main js ======-->
<script src="/assets/js/main.js"></script>

<script type="text/javascript">
    $(document).ready(function (){
        user_loggedout();
        console.log("proceeding");
        $.ajax({
            method: "GET",
            url: "/api/auth/active-user",
            beforeSend: function(request) {
                request.setRequestHeader("authorization", localStorage.getItem("sona_movie_access_token"));
            },
        }).done(function( msg ) {
            user_loggedin();
        }) .fail( function() {
            user_loggedout();

        });

        function user_loggedin(){
            $("#sign_in").hide();
            $("#sign_up").hide();
            $("#my_account").show();
        }

        function user_loggedout(){
            $("#sign_in").show();
            $("#sign_up").show();
            $("#my_account").hide();
        }
    });

</script>


</body>

</html>
