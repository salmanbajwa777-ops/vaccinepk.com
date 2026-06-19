<?php
$site_settings = pods( 'site_contact_settings' );

$phone     = $site_settings->field( 'phone_number' );
$whatsapp  = $site_settings->field( 'whatsapp_number' );
$email     = $site_settings->field( 'email_address' );
$address     = $site_settings->field( 'address' );
$facebook  = $site_settings->field( 'facebook_url' );
$instagram = $site_settings->field( 'instagram_url' );
$tiktok = $site_settings->field( 'tiktok_url' );
$youtube = $site_settings->field( 'youtube_url' );
?>

<?php if ($whatsapp): ?>
<a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>"
   class="floating-whatsapp"
   target="_blank"
   aria-label="Chat on WhatsApp">
   <i class="bi bi-whatsapp"></i>
</a>
<?php endif; ?>


<footer style="background: linear-gradient(135deg, #da7215, #d35324); color: white;">
    <div class="container">
        
        <!-- Main Footer Content -->
        <div class="footer-content py-5">
            <div class="row g-4">
                
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                   <h4 class="fw-bold mb-4"><i class="bi bi-heart-pulse-fill"></i> Vaccination Centre</h4>
                    <p style="color: rgba(255, 255, 255, 0.8); line-height: 1.8;">
                        Professional home vaccination services providing safe and convenient immunization 
                        for children and adults. WHO-compliant standards, expert care.
                    </p>
                    <div class="mt-4">
                        <a href="<?php echo esc_html($facebook); ?>" target="_blank" class="text-white me-3" style="font-size: 24px; text-decoration: none;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="<?php echo esc_html($instagram); ?>" target="_blank" class="text-white me-3" style="font-size: 24px; text-decoration: none;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="<?php echo esc_html($tiktok); ?>" target="_blank" class="text-white me-3" style="font-size: 24px; text-decoration: none;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="<?php echo esc_html($youtube); ?>" target="_blank" class="text-white me-3" style="font-size: 24px; text-decoration: none;">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank" class="text-white" style="font-size: 24px; text-decoration: none;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h4 class="fw-bold mb-4">Quick Links</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?php echo home_url(); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-house-fill"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo home_url('/about'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-info-circle-fill"></i> About Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo home_url('/vaccines'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-heart-pulse-fill"></i> Our Vaccines
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo home_url('/pricing'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-currency-dollar"></i> Pricing
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="<?php echo home_url('/contact'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-envelope-fill"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="fw-bold mb-4">Our Services</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-heart-fill"></i> Child Vaccination
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-person-fill"></i> Adult Immunization
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-airplane-fill"></i> Travel Vaccines
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-shield-fill-plus"></i> Flu Vaccination
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                                <i class="bi bi-chat-dots-fill"></i> Free Consultation
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="fw-bold mb-4">Contact Us</h4>
                    <ul class="list-unstyled" style="color: rgba(255, 255, 255, 0.8);">
                        <li class="mb-3">
                            <i class="bi bi-telephone-fill"></i> 
                            <a href="tel:<?php echo esc_attr($phone); ?>" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-envelope-fill"></i> 
                           <a href="mailto:<?php echo esc_attr($email); ?>" style="color: rgba(255, 255, 255, 0.9); text-decoration: none;">
    <?php echo esc_html($email); ?>
</a>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-geo-alt-fill"></i> <?php echo esc_html($address); ?>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-clock-fill"></i> 24/7 Service Available
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
        
        <!-- Bottom Footer -->
        <div class="footer-bottom py-4" style="border-top: 1px solid rgba(255, 255, 255, 0.2);">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0" style="color: rgba(255, 255, 255, 0.8);">
                        &copy; <?php echo date('Y'); ?> Vaccination Centre. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="<?php echo home_url('/privacy-policy'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; margin-right: 20px;">
                        <i class="bi bi-shield-lock-fill"></i> Privacy Policy
                    </a>
                    <a href="<?php echo home_url('/terms'); ?>" style="color: rgba(255, 255, 255, 0.8); text-decoration: none;">
                        <i class="bi bi-file-text-fill"></i> Terms & Conditions
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</footer>

<!-- Back to Top Button -->
<a href="#" id="backToTop" style="position: fixed; bottom: 30px; left: 30px; background: linear-gradient(135deg, #da7215, #d35324); color: white; width: 50px; height: 50px; border-radius: 50%; display: none; align-items: center; justify-content: center; text-decoration: none; font-size: 24px; box-shadow: 0 5px 20px rgba(218, 114, 21, 0.4); z-index: 999; transition: all 0.3s;">
    <i class="bi bi-arrow-up"></i>
</a>

<script>
// Back to Top functionality
const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', function() {
    if (window.scrollY > 300) {
        backToTopButton.style.display = 'flex';
    } else {
        backToTopButton.style.display = 'none';
    }
});

backToTopButton.addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>