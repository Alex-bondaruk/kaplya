<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package beauty
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) {
		?>
		<div class="comentheader flex">
		<h2 class="comments-title">
		<span>Комментарии</span>
			<?php
			$beauty_comment_count = get_comments_number();
			if ( '1' === $beauty_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( '1', 'beauty' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf( 
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( ' %1$s', $beauty_comment_count, 'comments title', 'beauty' ) ),
					number_format_i18n( $beauty_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->
		<div class="iteim">
				<a href="#coment" class="to_call_m open_modal btn_click_custom"><em>Оставить комментарий</em></a>

		</div>
		</div>

		<?php the_comments_navigation(); ?>

		<li class="comment-list">
<?php
        wp_list_comments( array( 'callback' => 'my_comments' ) );
        $commentnumber = 0;
			?>
		</li><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'beauty' ); ?></p>
			<?php
		endif;

	}else{ ?>
		<div class="comentheader no">
		<p>Пока нет и одного комментария.</br> Добавьте комментарий первым</p>
		
		<div class="iteim">
				<a href="#coment" class="to_call_m open_modal btn_click_custom"><em>Оставить комментарий</em></a>

		</div>
		</div>
	<? } ?>
</div><!-- #comments -->
