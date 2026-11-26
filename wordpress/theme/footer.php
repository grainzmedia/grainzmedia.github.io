<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="col-first">
        <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="GrainzMedia — home"><img src="<?php echo gm_assets(); ?>/img/logo.png" alt="GrainzMedia" width="320" height="158" loading="lazy"></a>
        <address>178 Paya Lebar Road,<br>#02-04, Singapore 409030</address>
        <ul>
          <li><a href="<?php echo esc_url( gm_url( 'about' ) ); ?>">About Us</a></li>
          <li><a href="<?php echo esc_url( gm_url( 'press' ) ); ?>">Press</a></li>
        </ul>
      </div>
      <nav aria-label="Capabilities">
        <h2 class="footer-h">Capabilities</h2>
        <ul>
          <li><a href="<?php echo esc_url( gm_url( 'retail-media' ) ); ?>">Retail Media</a></li>
          <li><a href="<?php echo esc_url( gm_url( 'performance-marketing' ) ); ?>">Performance Marketing</a></li>
        </ul>
      </nav>
      <nav aria-label="Insights">
        <h2 class="footer-h">Insights</h2>
        <ul>
          <li><a href="<?php echo esc_url( gm_category_url( 'retail' ) ); ?>">Retail Media Insights</a></li>
          <li><a href="<?php echo esc_url( gm_category_url( 'performance' ) ); ?>">Performance Insights</a></li>
        </ul>
      </nav>
      <div>
        <h2 class="footer-h">Contact</h2>
        <ul>
          <li><a href="mailto:hello@grainzmedia.com">hello@grainzmedia.com</a></li>
          <li><a href="tel:+6566450498">+65 6645 0498</a></li>
          <li><a href="<?php echo esc_url( gm_url( 'contact' ) ); ?>">Let’s Get Phygital</a></li>
        </ul>
      </div>
    </div>
    <p class="footer-legal">
      <a href="<?php echo esc_url( gm_url( 'privacy' ) ); ?>">Privacy Policy</a><span aria-hidden="true">•</span><a href="<?php echo esc_url( gm_url( 'cookies' ) ); ?>">Cookie Policy</a><span aria-hidden="true">•</span><a href="https://www.linkedin.com/company/briq-communications/" target="_blank" rel="noopener noreferrer">LinkedIn<span class="sr-only"> (opens in a new tab)</span></a><span aria-hidden="true">•</span><span>© <span data-year><?php echo esc_html( gmdate( 'Y' ) ); ?></span> GrainzMedia</span>
    </p>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
