<?php
/**
 * Debug script to check gallery thumbnails after fix
 */
require('./wp-load.php');

echo "<h1>Debug de Galerías y Thumbnails (Después del Fix)</h1>";
echo "<style>
    body {font-family:Arial,sans-serif;max-width:800px;margin:0 auto;padding:20px;}
    .gallery-item{border:1px solid #ccc;padding:15px;margin-bottom:15px;border-radius:5px;}
    .thumbnail{max-width:200px;max-height:200px;}
    .error{color:red;}
    .success{color:green;}
    .content{background:#f8f8f8;padding:10px;margin:10px0;white-space:pre-wrap;word-wrap:break-word;}
    table {border-collapse: collapse; width: 100%; margin-bottom:15px;}
    th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}
    th {background-color: #f2f2f2;}
</style>";

// Query all galleries
$args = array(
    'post_type'      => 'cuerpolibre_gallery',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$gallery_query = new WP_Query( $args );

if ( $gallery_query->have_posts() ) :
    echo "<table>";
    echo "<tr><th>ID</th><th>Título</th><th>Featured Media (ID)</th><th>get_the_post_thumbnail_url</th><th>Contenido con apply_filters</th><th>Imagen del contenido</th></tr>";
    
    while ( $gallery_query->have_posts() ) : $gallery_query->the_post();
        $id = get_the_ID();
        $title = get_the_title();
        $thumb_id = get_post_thumbnail_id();
        $thumb_url = get_the_post_thumbnail_url( $id, 'large' );
        
        // Prueba con apply_filters
        $content = apply_filters( 'the_content', get_the_content() );
        $content_has_img = preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
        
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$title</td>";
        echo "<td>" . ( $thumb_id ? $thumb_id : '<span class="error">No</span>' ) . "</td>";
        echo "<td>" . ( $thumb_url ? '<a href="' . $thumb_url . '" target="_blank">' . $thumb_url . '</a>' : '<span class="error">No</span>' ) . "</td>";
        echo "<td>" . ( $content_has_img ? '<span class="success">Sí</span>' : '<span class="error">No</span>' ) . "</td>";
        echo "<td>" . ( $content_has_img ? '<img src="' . $matches[1] . '" class="thumbnail" alt="Imagen del contenido">' : '-' ) . "</td>";
        echo "</tr>";
        
    endwhile;
    wp_reset_postdata();
    echo "</table>";
else :
    echo "<p class='error'>No se encontraron galerías</p>";
endif;

echo "<h2>Post Type Supports</h2>";
$supports = get_all_post_type_supports( 'cuerpolibre_gallery' );
echo "<pre>";
print_r( $supports );
echo "</pre>";
