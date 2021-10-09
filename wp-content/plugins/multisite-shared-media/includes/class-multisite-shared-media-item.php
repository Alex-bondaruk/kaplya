<?php
/**
 * Author:  Aikadesign Oy (JG) <tuki@aikadesign.fi>
 * Since:   2018/02
 */


/**
 * Class MSMMediaItem. Provides information about a specific MediaItem on a specific site.
 *
 * @author Aikadesign Oy (JG) <tuki@aikadesign.fi>
 *
 */
class MSMMediaItem {

	private $post;
	private $meta;
	private $network;
	private $blog_id;

	/**
	 * MSMMediaItem constructor. Load post and meta data.
	 *
	 * @param int|\WP_Post $attachment
	 */
	public function __construct( $attachment ) {

		if( is_a( $attachment, WP_Post::class ) ){
			$this->post = $attachment;
		} elseif( is_int( $attachment ) ){
			$this->post = get_post( (int) $attachment );
		}

		$this->meta = get_post_meta( $this->post->ID );
		$this->network = MSMNetwork::instance();
		$this->blog_id = get_current_blog_id();

	}


	/**
	 * Check if the attachment is the original one. Returns true if original, or false if it's a replication.
	 * (Attachment is original if it doesn't contain reference to original file)
	 *
	 * @return bool
	 *
	 */
	public function is_original() {
		return empty( $this->meta['msm_original_file'] );
	}


	/**
	 * Get the MediaItem post's ID.
	 * @return int
	 */
	public function get_id(){
		return $this->post->ID;
	}

	/**
	 * Get the MediaItem's *post*
	 * @return array|null|\WP_Post
	 */
	public function get_post(){
		return $this->post;
	}


	/**
	 * Get array of references to other sites and posts which are copies of this MediaItem.
	 * @return array|bool|mixed False, if called for not-original item.
	 */
	public function get_copies(){

		if( ! $this->is_original() ){
			return false;
		}

		$ret = isset( $this->meta['msm_replication_info'] ) ? unserialize( $this->meta['msm_replication_info'][0] ) : array();

		return $ret;
	}


	/**
	 * Mark item ignored by MSM. Items marked ignored are no longer being included in the "unsynced items" from the site.
	 */
	public function mark_ignored() {
		$this->meta['msm_ignored'] = '1';
		update_post_meta( $this->post->ID, 'msm_ignored', $this->meta['msm_ignored'] );
	}


	/**
	 * Check if item is marked as ignored. (typically ignored due to some 3rd party filter)
	 * @return bool
	 */
	public function is_ignored() {
		$ignored_meta = $this->meta['msm_ignored'];
		if(is_array( $ignored_meta) ){
			$ignored_meta = $ignored_meta[0];
		}

		$ignored = $already_ignored = ('1' === $ignored_meta);

		if( false === $already_ignored ){
			$ignored = apply_filters('msm_media_item_is_ignored', $already_ignored, $this );

			// If item is ignored, mark it as ignored for future. It's useful to have this information stored.
			//TODO: It couold be useful to have a button to "unignore" the item.
			if( $ignored ){
				$this->mark_ignored();
			}
		}

		return $already_ignored || $ignored;
	}

}