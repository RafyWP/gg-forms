<?php
defined('ABSPATH') || exit;

$link = get_option( 'gg_forms_affiliate_link' );
if ( empty( $link ) ) {
  $link = 'https://rafy.site/projects/gg-form';
}

$author_type  = get_option( 'review_author_type', 'Person' );
$author_name  = get_option( 'review_author_name', 'Anonymous' );
$published    = get_option( 'review_datePublished', date('Y-m-d') );
$rating       = floatval( get_option( 'reviewRating', 5 ) );
$body         = get_option( 'reviewBody', 'This is a great plugin!' );

$date_format  = get_option( 'date_format' );
?>

<!DOCTYPE html>
<html lang="<?php echo str_replace( '_', '-', get_locale() ); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php esc_html_e( 'GG Forms', 'gg-forms' ); ?> • <?php esc_html_e( get_bloginfo( 'name' ) ); ?> • <?php esc_html_e( 'Review', 'gg-forms' ); ?></title>
  <meta name="description" content="">
  <link rel="canonical" href="https://rafy.site/projects/gg-forms" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/css/styles-lp.css">
</head>
<body>
  <header>
    <div class="flexible">
      <div>
        <div class="flexy">
          <h1><?php esc_html_e( 'GG Forms', 'gg-forms' ); ?></h1>
          <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/file-check-2.svg" alt="GG Forms Icon" width="32" height="32" />
        </div>
        <p><?php esc_html_e( 'Guided & gamified forms that move users — and your business — forward.', 'gg-forms' ); ?></p>
        <a href="<?php echo esc_url( $link ); ?>" class="button" target="_blank">
          <?php esc_html_e( 'Install GG Forms now', 'gg-forms' ); ?> <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/download.svg" alt="GG Forms Icon" width="24" height="24" />
        </a>
      </div>

      <div class="review">
        <p>
          <?php echo esc_html( $author_name ); ?>
          <span style="font-size:.9rem;">⭐⭐⭐⭐⭐</span>
        </p>

        <blockquote>
          <?php echo esc_html( $body ); ?>
        </blockquote>

        <small><?php echo esc_html( date_i18n( $date_format, strtotime( $published ) ) ); ?></small>
      </div>
    </div>
  </header>

  <section class="section">
    <div class="center-block">
      <h2><?php esc_html_e( 'Why GG Forms?', 'gg-forms' ); ?></h2>
      <p class="spaced">
        <?php esc_html_e( 'Traditional forms can feel like chores.', 'gg-forms' ); ?> <?php esc_html_e( 'GG Forms turns them into conversations.', 'gg-forms' ); ?>
      </p>
    </div>
    <div class="features">
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/list-check.svg" alt="list check" width="32" height="32" />
        <h3><?php esc_html_e( 'Step-by-step guidance', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Forms flow like a guided path instead of a long list.', 'gg-forms' ); ?></p>
      </div>
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/git-branch.svg" alt="git branch" width="32" height="32" />
        <h3><?php esc_html_e( 'Smart branching', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Show different fields based on previous answers.', 'gg-forms' ); ?></p>
      </div>
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/dices.svg" alt="dices" width="32" height="32" />
        <h3><?php esc_html_e( 'Light gamification', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Engaging UI encourages completion and interaction.', 'gg-forms' ); ?></p>
      </div>
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/trending-up-down.svg" alt="trending-up-down" width="32" height="32" />
        <h3><?php esc_html_e( 'Built-in analytics', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Track form views, drop-off rates, and completions.', 'gg-forms' ); ?></p>
      </div>
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/tablet-smartphone.svg" alt="tablet-smartphone" width="32" height="32" />
        <h3><?php esc_html_e( 'Mobile-first experience', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Forms are designed to be fluid and delightful on any device.', 'gg-forms' ); ?></p>
      </div>
      <div class="feature">
        <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/toy-brick.svg" alt="toy brick" width="32" height="32" />
        <h3><?php esc_html_e( 'Made for WordPress', 'gg-forms' ); ?></h3>
        <p><?php esc_html_e( 'Seamless Gutenberg block and modern theme support.', 'gg-forms' ); ?></p>
      </div>
    </div>
  </section>

  <section class="section" style="text-align:center; background: var(--wp--preset--color--accent-1); padding: 3rem 2rem; max-width: 100%;">
    <div class="center-block">
      <h2 style="font-family: var(--wp--preset--font-family--space-grotesk); font-size: 2rem; margin-bottom: 1rem;">
        <?php esc_html_e( 'Ready to install?', 'gg-forms' ); ?>
      </h2>
      <p><?php esc_html_e( 'Start collecting data with guided & gamified forms today.', 'gg-forms' ); ?></p>
      <a href="<?php echo esc_url( $link ); ?>" class="button" target="_blank">
        <?php esc_html_e( 'Install GG Forms now', 'gg-forms' ); ?> <img src="<?php echo plugin_dir_url( __DIR__ ); ?>public/assets/icons/download.svg" alt="GG Forms Icon" width="24" height="24" />
      </a>
    </div>
  </section>

  <footer class="section" style="text-align:center;">
    <p>&copy; <?php echo date('Y'); ?> GG Forms • <?php esc_html_e( 'Crafted by', 'gg-forms' ); ?> 
    <a href="https://rafy.site" style="color:#1a87ef;" title="<?php esc_html_e( 'WordPress Expert Consultant', 'gg-forms' ); ?>">Rafy</a></p>
  </footer>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Review",
    "author": {
      "@type": "<?php echo esc_js( $author_type ); ?>",
      "name": "<?php echo esc_js( $author_name ); ?>"
    },
    "datePublished": "<?php echo esc_js( $published ); ?>",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "<?php echo esc_js( $rating ); ?>",
      "bestRating": "5"
    },
    "reviewBody": "<?php echo esc_js( $body ); ?>",
    "itemReviewed": {
      "@type": "SoftwareApplication",
      "name": "GG Forms",
      "applicationCategory": "WordPress Plugin",
      "operatingSystem": "All"
    }
  }
  </script>

</body>
</html>
