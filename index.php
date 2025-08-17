<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <article>
      <h2><?php the_title(); ?></h2>
      <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('large');
        } else { ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/receta1.jpg" alt="Imagen de ejemplo">
        <?php } 
      ?>
      <div><?php the_content(); ?></div>
    </article>
  <?php endwhile; ?>
<?php else : ?>
  <article>
    <h2>Receta de ejemplo: Pancakes esponjosos</h2>
    <img src="<?php echo get_template_directory_uri(); ?>/images/receta2.jpg" alt="Pancakes">
    <h3>Ingredientes:</h3>
    <ul>
      <li>1 taza de harina</li>
      <li>1 huevo</li>
      <li>1 taza de leche</li>
      <li>2 cucharadas de azúcar</li>
      <li>1 cucharadita de polvo para hornear</li>
    </ul>
    <h3>Preparación:</h3>
    <p>Mezclar todos los ingredientes, cocinar en sartén caliente engrasado, voltear cuando salgan burbujas. ¡Listo!</p>
  </article>
<?php endif; ?>

<?php get_footer(); ?>
