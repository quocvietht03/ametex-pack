<?php
use ScssPhp\ScssPhp\Compiler;

/**
 * Helpers
 *
 * @package Ametex Pack
 * @author Beplus
 */

if( ! function_exists( 'apack_scss_compiler' ) ) {
    /**
     * Scss Compiler
     *
     * @param string $in
     * @param string $out
     * @param string $import_path
     * @param string $formatter (default: ScssPhp\ScssPhp\Formatter\Compressed)
     * @param boolean $source_map (SOURCE_MAP_INLINE)
     *
     * @return void
     */
    function apack_scss_compiler( $scss_string, $out, $import_path = '', $formatter = 'ScssPhp\ScssPhp\Formatter\Compressed', $source_map = false ) {
        $scss = new Compiler();

        if( ! empty( $import_path ) ) $scss->setImportPaths( $import_path );
        if( ! empty( $formatter ) ) $scss->setFormatter( $formatter );
        if( true == $source_map ) $scss->setSourceMap( Compiler::SOURCE_MAP_INLINE );

        file_put_contents( $out, $scss->compile( apply_filters( 'apack/scss_compiler', $scss_string ) ) );
    }
}

if( ! function_exists( 'apack_get_mode' ) ) {
    /**
     * Get mode
     *
     */
    function apack_get_mode() {
        return carbon_get_theme_option( 'apack_dev_mode' );
    }
}

if( ! function_exists( 'apack_pagination' ) ) {
    /**
     * Pagination
     *
     */
    function apack_pagination() {
        global $wp_query;
        $big = 999999999; // need an unlikely integer

        $output = paginate_links( array(
        	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        	'format' => '?paged=%#%',
        	'current' => max( 1, get_query_var('paged') ),
        	'total' => $wp_query->max_num_pages,
            'prev_text' => '<i class="fa fa-angle-left"></i>',
            'next_text' => '<i class="fa fa-angle-right"></i>',
        ) );
        ?>
        <div class="apack-pagination-container">
            <nav class="bt-pagination" role="navigation">
                <?php echo $output; ?>
            </nav>
        </div>
        <?php
    }
}

if( ! function_exists( 'apack_share_post' ) ) {
    /**
     * Share post
     *
     */
    function apack_share_post() {
        global $post;

        $socials = apply_filters( 'apack/social_share', [
            'facebook' => [
                'title' => __( 'Facebook', 'amextex-pack' ),
                'url' => 'https://www.facebook.com/sharer.php?u={{URL}}',
                'svg_icon' => apack_svg_icon( 'facebook' ),
            ],
            'twitter' => [
                'title' => __( 'Twitter', 'amextex-pack' ),
                'url' => 'https://twitter.com/intent/tweet?url={{URL}}&text={{TITLE}}',
                'svg_icon' => apack_svg_icon( 'twitter' ),
            ],
            'pinterest' => [
                'title' => __( 'Pinterest', 'amextex-pack' ),
                'url' => 'http://pinterest.com/pin/create/link/?url={{URL}}',
                'svg_icon' => apack_svg_icon( 'pinterest' ),
            ],
            ] );

        set_query_var( 'socials', $socials );
        set_query_var( 'replace_url', apply_filters( 'apack/social_share/replace_link', [
            '{{URL}}' => get_the_permalink( $post->ID ),
            '{{TITLE}}' => get_the_title( $post->ID ),
            ] ) );

        load_template( APACK_DIR . '/templates/share.php' );
    }
}

if( ! function_exists( 'apack_svg_icon' ) ) {
    /**
     * Icons svg
     *
     */
    function apack_svg_icon( $name = '' ) {
        $icons =  apply_filters( 'apack/svg_icon', [
            'menu_square' => '<svg enable-background="new 0 0 512 512" viewBox="0 0 512 512"><path d="m10 144h124c5.523 0 10-4.477 10-10v-124c0-5.523-4.477-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10zm10-124h104v104h-104z"/><path d="m194 144h124c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10zm10-124h104v104h-104z"/><path d="m502 0h-124c-5.522 0-10 4.477-10 10v124c0 5.523 4.478 10 10 10h124c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10zm-10 124h-104v-104h104z"/><path d="m10 328h124c5.523 0 10-4.477 10-10v-124c0-5.523-4.477-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10zm10-124h104v104h-104z"/><path d="m502 184h-124c-5.522 0-10 4.477-10 10v124c0 5.523 4.478 10 10 10h124c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10zm-10 124h-104v-104h104z"/><path d="m10 512h124c5.523 0 10-4.477 10-10v-124c0-5.523-4.477-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10zm10-124h104v104h-104z"/><path d="m194 512h124c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10zm10-124h104v104h-104z"/><path d="m502 368h-124c-5.522 0-10 4.477-10 10v124c0 5.523 4.478 10 10 10h124c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10zm-10 124h-104v-104h104z"/><circle cx="256" cy="318" r="10"/><path d="m194 328h17c5.523 0 10-4.477 10-10s-4.477-10-10-10h-7v-104h104v104h-7c-5.522 0-10 4.477-10 10s4.478 10 10 10h17c5.522 0 10-4.477 10-10v-124c0-5.523-4.478-10-10-10h-124c-5.523 0-10 4.477-10 10v124c0 5.523 4.477 10 10 10z"/></svg>',

            'next_arrow' => '<svg x="0px" y="0px" viewBox="0 0 306 306" style="enable-background:new 0 0 306 306;" xml:space="preserve"> <g> <g> <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153 "/> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'prev_arrow' => '<svg x="0px" y="0px" viewBox="0 0 306 306" style="enable-background:new 0 0 306 306;" xml:space="preserve"><g transform="matrix(-1 0 0 1 306 0)"><g> <g> <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153 " data-original="#000000" class="active-path"/> </g> </g></g> </svg>',

            'bookmark_line' => '<svg x="0px" y="0px" viewBox="0 0 278.045 278.045" style="enable-background:new 0 0 278.045 278.045;" xml:space="preserve"> <g> <path d="M224.093,0H53.952c-4.971,0-9,4.029-9,9v260.045c0,3.592,2.136,6.839,5.433,8.263c3.298,1.425,7.126,0.75,9.74-1.713 l78.897-74.352l78.897,74.352c1.704,1.605,3.923,2.45,6.175,2.45c1.203,0,2.417-0.241,3.565-0.737 c3.297-1.423,5.433-4.671,5.433-8.263V9C233.093,4.029,229.064,0,224.093,0z M215.093,18v13.158H62.952V18H215.093z M145.196,182.326c-1.733-1.633-3.953-2.45-6.173-2.45s-4.439,0.817-6.173,2.45l-69.897,65.871V49.158h152.141v199.039 L145.196,182.326z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'bookmark' => '<svg viewBox="-121 0 511 511.99913" xmlns="http://www.w3.org/2000/svg"><path d="m.5 45v451.992188c0 6.066406 3.648438 11.542968 9.257812 13.859374 5.625 2.328126 12.039063 1.054688 16.347657-3.253906l109.394531-109.394531 109.390625 109.394531c4.332031 4.332032 10.820313 5.558594 16.347656 3.253906 5.613281-2.316406 9.257813-7.792968 9.257813-13.859374v-451.992188c0-24.8125-20.183594-45-44.996094-45h-180c-24.816406 0-45 20.1875-45 45zm0 0"/></svg>',

            'tag' => '<svg x="0px" y="0px" viewBox="0 0 486.982 486.982" style="enable-background:new 0 0 486.982 486.982;" xml:space="preserve"> <g> <path d="M131.35,422.969c14.6,14.6,38.3,14.6,52.9,0l181.1-181.1c5.2-5.2,9.2-11.4,11.8-18c18.2,5.1,35.9,7.8,51.5,7.7 c38.6-0.2,51.4-17.1,55.6-27.2c4.2-10,7.2-31-19.9-58.6c-0.3-0.3-0.6-0.6-0.9-0.9c-16.8-16.8-41.2-32.3-68.9-43.8 c-5.1-2.1-10.2-4-15.2-5.8v-0.3c-0.3-22.2-18.2-40.1-40.4-40.4l-108.5-1.5c-14.4-0.2-28.2,5.4-38.3,15.6l-181.2,181.1 c-14.6,14.6-14.6,38.3,0,52.9L131.35,422.969z M270.95,117.869c12.1-12.1,31.7-12.1,43.8,0c7.2,7.2,10.1,17.1,8.7,26.4 c11.9,8.4,26.1,16.2,41.3,22.5c5.4,2.2,10.6,4.2,15.6,5.9l-0.6-43.6c0.9,0.4,1.7,0.7,2.6,1.1c23.7,9.9,45,23.3,58.7,37 c0.2,0.2,0.4,0.4,0.6,0.6c13,13.3,14.4,21.8,13.3,24.4c-3.4,8.1-39.9,15.3-95.3-7.8c-16.2-6.8-31.4-15.2-43.7-24.3 c-0.4,0.5-0.9,1-1.3,1.5c-12.1,12.1-31.7,12.1-43.8,0C258.85,149.569,258.85,129.969,270.95,117.869z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'eye' => '<svg x="0px" y="0px" viewBox="0 0 488.85 488.85" style="enable-background:new 0 0 488.85 488.85;" xml:space="preserve"> <g> <path d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2 s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025 c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3 C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7 c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'facebook' => '<svg x="0px" y="0px" viewBox="0 0 26 26" style="enable-background:new 0 0 26 26;" xml:space="preserve"> <g> <path style="fill:#030104;" d="M21.125,0H4.875C2.182,0,0,2.182,0,4.875v16.25C0,23.818,2.182,26,4.875,26h16.25 C23.818,26,26,23.818,26,21.125V4.875C26,2.182,23.818,0,21.125,0z M20.464,14.002h-2.433v9.004h-4.063v-9.004h-1.576v-3.033h1.576 V9.037C13.969,6.504,15.021,5,18.006,5h3.025v3.022h-1.757c-1.162,0-1.238,0.433-1.238,1.243l-0.005,1.703h2.764L20.464,14.002z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'twitter' => '<svg x="0px" y="0px" viewBox="0 0 438.536 438.536" style="enable-background:new 0 0 438.536 438.536;" xml:space="preserve"> <g> <path d="M414.41,24.123C398.333,8.042,378.963,0,356.315,0H82.228C59.58,0,40.21,8.042,24.126,24.123 C8.045,40.207,0.003,59.576,0.003,82.225v274.084c0,22.647,8.042,42.018,24.123,58.102c16.084,16.084,35.454,24.126,58.102,24.126 h274.084c22.648,0,42.018-8.042,58.095-24.126c16.084-16.084,24.126-35.454,24.126-58.102V82.225 C438.532,59.576,430.49,40.204,414.41,24.123z M335.471,168.735c0.191,1.713,0.288,4.278,0.288,7.71 c0,15.989-2.334,32.025-6.995,48.104c-4.661,16.087-11.8,31.504-21.416,46.254c-9.606,14.749-21.074,27.791-34.396,39.115 c-13.325,11.32-29.311,20.365-47.968,27.117c-18.648,6.762-38.637,10.143-59.953,10.143c-33.116,0-63.76-8.952-91.931-26.836 c4.568,0.568,9.329,0.855,14.275,0.855c27.6,0,52.439-8.565,74.519-25.7c-12.941-0.185-24.506-4.179-34.688-11.991 c-10.185-7.803-17.273-17.699-21.271-29.691c4.947,0.76,8.658,1.137,11.132,1.137c4.187,0,9.042-0.76,14.56-2.279 c-13.894-2.669-25.598-9.562-35.115-20.697c-9.519-11.136-14.277-23.84-14.277-38.114v-0.571 c10.085,4.755,19.602,7.229,28.549,7.422c-17.321-11.613-25.981-28.265-25.981-49.963c0-10.66,2.758-20.747,8.278-30.264 c15.035,18.464,33.311,33.213,54.816,44.252c21.507,11.038,44.54,17.227,69.092,18.558c-0.95-3.616-1.427-8.186-1.427-13.704 c0-16.562,5.853-30.692,17.56-42.399c11.703-11.706,25.837-17.561,42.394-17.561c17.515,0,32.079,6.283,43.688,18.846 c13.134-2.474,25.892-7.33,38.26-14.56c-4.757,14.652-13.613,25.788-26.55,33.402c12.368-1.716,23.88-4.95,34.537-9.708 C357.458,149.793,347.462,160.166,335.471,168.735z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>',

            'pinterest' => '<svg x="0px" y="0px" viewBox="0 0 438.557 438.557" style="enable-background:new 0 0 438.557 438.557;" xml:space="preserve"> <g> <path d="M414.418,24.128C398.341,8.047,378.972,0.005,356.323,0.005V0H82.239C59.591,0,40.222,8.044,24.138,24.125 C8.057,40.209,0.015,59.578,0.015,82.226v274.089c0,22.647,8.042,42.018,24.123,58.095c16.084,16.084,35.454,24.126,58.102,24.126 h52.25c-3.239-29.304-2.573-53.481,1.997-72.512l27.978-118.198c-4.568-9.329-6.854-20.841-6.854-34.543 c0-15.796,4.045-29.075,12.137-39.827c8.086-10.757,17.937-16.134,29.547-16.134c9.326,0,16.512,3.092,21.554,9.276 c5.041,6.189,7.566,13.945,7.566,23.272c0,5.898-1.047,12.99-3.138,21.267c-2.098,8.285-4.9,17.99-8.422,29.126 c-3.521,11.135-6.042,19.934-7.566,26.404c-2.663,11.424-0.476,21.27,6.567,29.555c7.042,8.274,16.272,12.422,27.696,12.422 c20.177,0,36.686-11.231,49.539-33.694c12.847-22.456,19.267-49.676,19.267-81.649c0-24.551-7.946-44.54-23.846-59.955 c-15.886-15.418-38.013-23.128-66.376-23.128c-31.78,0-57.526,10.138-77.228,30.407c-19.701,20.271-29.552,44.684-29.552,73.233 c0,16.748,4.761,31.025,14.277,42.828c3.234,3.614,4.283,7.615,3.14,11.995c-0.953,3.237-2.38,9.041-4.283,17.412 c-0.763,2.669-2.141,4.473-4.141,5.428c-2.002,0.951-4.237,0.951-6.711,0c-14.655-6.088-25.747-16.563-33.263-31.409 c-7.517-14.842-11.276-31.977-11.276-51.387c0-12.564,2.047-25.179,6.14-37.831c4.093-12.66,10.422-24.841,18.986-36.545 c8.564-11.709,18.792-22.129,30.69-31.267c11.894-9.132,26.458-16.413,43.682-21.838c17.222-5.424,35.736-8.137,55.524-8.137 c20.181,0,38.927,3.48,56.25,10.426c17.319,6.945,31.833,16.175,43.544,27.69c11.703,11.516,20.889,24.744,27.545,39.687 c6.666,14.938,9.996,30.406,9.996,46.392c0,43.019-10.896,78.564-32.688,106.637c-21.793,28.075-49.916,42.116-84.363,42.116 c-11.43,0-22.128-2.666-32.124-7.994c-9.991-5.328-16.986-11.704-20.984-19.13c-8.374,33.312-13.417,53.197-15.131,59.669 c-4.377,16.751-14.655,36.733-30.833,59.956H356.32c22.647,0,42.017-8.042,58.095-24.126 c16.084-16.084,24.126-35.454,24.126-58.102v-274.1C438.541,59.582,430.499,40.212,414.418,24.128z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>'
            ] );

        if( ! empty( $name ) ) {
            return $icons[$name];
        } else {
            return $icons;
        }
    }
}

if( ! function_exists( 'apack_comment_template' ) ) {
    /**
     *
     */
    function apack_comment_template() {

        if ( comments_open() || get_comments_number() ) {
            ?>
            <div class="apack-comment-container">
                <?php comments_template(); ?>
            </div> <!-- .apack-comment-container -->
            <?php
        }
    }
}

if( ! function_exists( 'apack_blog_custom_single_template' ) ) {
    /**
     * Custom single blog
     *
     */
    function apack_blog_custom_single_template( $single_template ) {
        global $post;

        if( true != carbon_get_theme_option( 'apack_blog_custom_enable' ) ) return $single_template;

    	if ( 'post' === $post->post_type ) {
    		$single_template = APACK_DIR . '/templates/blog/single.php';
    	}

    	return $single_template;
    }
}

if( ! function_exists( 'apack_blog_heading_bar' ) ) {
    /**
     * Blog heading bar
     *
     */
    function apack_blog_heading_bar() {
        global $post;

        set_query_var( 'title', get_the_title( $post->ID ) );
        set_query_var( 'background_layer', get_the_post_thumbnail_url( $post, 'full' ) );
        load_template( APACK_DIR . '/templates/blog/heading-bar.php' );
    }
}

if( ! function_exists( 'apack_blog_content' ) ) {
    /**
     * Blog content
     *
     */
    function apack_blog_content() {
        load_template( APACK_DIR . '/templates/blog/single-content.php' );
    }
}

if( ! function_exists( 'apack_get_posts_related' ) ) {
    /**
     * Get posts related
     *
     */
    function apack_get_posts_related( $current_post_id ) {
        $cats = get_the_category( $current_post_id );
        $first_cat_id = $cats[0]->term_id;

        $args = apply_filters( 'apack/query_related_posts/args', [
            'posts_per_page' => (int) carbon_get_theme_option( 'apack_blog_related_post_number' ),
            'exclude' => [$current_post_id],
            'category__in' => [$first_cat_id],
            ] );

        return get_posts( $args );
    }
}

if( ! function_exists( 'apack_blog_related' ) ) {
    /**
     * Blog related
     *
     */
    function apack_blog_related() {
        if( true != carbon_get_theme_option( 'apack_blog_related_posts' ) ) return;

        global $post;
        $loop = apack_get_posts_related( $post->ID );

        set_query_var( 'loop', $loop );
        load_template( APACK_DIR . '/templates/blog/related.php' );
    }
}
