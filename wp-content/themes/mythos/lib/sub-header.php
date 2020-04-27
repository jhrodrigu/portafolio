<?php
    global $post;
    $mythos_output = ''; 

    $attachment_id = attachment_url_to_postid(get_header_image());
    $mythos_banner_img = wp_get_attachment_image_url($attachment_id, 'mythos-large');
    $mythos_banner_color = get_theme_mod( 'sub_header_banner_color', '#01c3ca' );

    $mythos_output = ( $mythos_banner_img ) ? ( 'style="background-image:url('.esc_url( $mythos_banner_img ).');background-size: cover;background-position: 50% 50%;"' ) : ( 'style="background-color:'.esc_attr( $mythos_banner_color ).';"' );
?>

<div class="subtitle-cover sub-title" <?php print wp_kses_post($mythos_output);?>>
    <div class="container mythos">
        <div class="row mythos-row">
            <div class="col-12 text-left wrap">
                <?php
                    global $wp_query;
                    if(isset($wp_query->queried_object->name)){
                        if (get_theme_mod( 'header_title_enable', true )) {
                            if($wp_query->queried_object->name != ''){
                                if($wp_query->queried_object->name == 'product' ){
                                    echo '<h2>'.esc_html__('Shop','mythos').'</h2>';
                                }else{
                                    echo '<h2 class="page-leading">'.wp_kses_post($wp_query->queried_object->name).'</h2>'; 
                                }
                            }else{
                                echo '<h2 class="page-leading">'.esc_attr(get_the_title()).'</h2>';
                            }
                        }
                    }else{
                        if( is_search() ){
                            if (get_theme_mod( 'header_title_enable', true )) {
                                $mythos_text = '';
                                $mythos_first_char = esc_html__('Search','mythos');
                                if( isset($_GET['s'])){ 
                                    $mythos_text = sanitize_text_field(wp_unslash($_GET['s'])); 
                                }
                                echo '<h2 class="page-leading">'.wp_kses_post($mythos_first_char).':'.wp_kses_post($mythos_text).'</h2>';
                            }
                        }
                        else if( is_home() ){
                            if (get_theme_mod( 'header_title_enable', true )) {
                                if (get_theme_mod( 'header_title_text', 'Blog' )){
                                    echo '<h2 class="page-leading">'.esc_attr(get_the_title()).'</h2>';
                                }
                            }
                        }
                        else if( is_single()){
                            if (get_theme_mod( 'subtitle_enable', true )) {
                                if (get_theme_mod( 'header_subtitle_text', '' )){
                                    echo '<h2 class="page-leading">'. wp_kses_post(get_theme_mod( 'header_subtitle_text','' )).'</h2>';
                                }
                            }
                        }
                        else{
                            if (get_theme_mod( 'header_title_enable', true )) {
                                echo '<h2 class="page-leading">'.esc_attr(get_the_title()).'</h2>';
                            }
                        }
                    } 
                ?>
            </div>
        </div>
    </div>
</div><!--/.sub-title-->

