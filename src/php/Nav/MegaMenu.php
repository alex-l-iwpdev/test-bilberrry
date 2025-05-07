<?php
/**
 * Maga-menu class file.
 *
 * @package iwpdev/bilberrry
 */

namespace Iwpdev\Bilberrry\Nav;

use stdClass;
use Walker_Nav_Menu;
use WP_Post;

/**
 * Mega menu walker.
 */
class MegaMenu extends Walker_Nav_Menu {

	/**
	 * Start element.
	 *
	 * @param string        $output Output.
	 * @param WP_Post       $item   Item.
	 * @param int           $depth  Depth.
	 * @param stdClass|null $args   Args.
	 * @param int           $id     ID.
	 *
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$args->menu_item = $item;

		$is_mega_menu = get_field( 'enable_mega_menu', $item->ID );
		if ( $is_mega_menu ) {
			$item->classes[] = 'has-mega-menu';
		}
		$classes     = empty( $item->classes ) ? [] : (array) $item->classes;
		$class_names = implode( ' ', array_map( 'sanitize_html_class', $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= '<li' . $class_names . '>';

		$atts           = [];
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );

				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$output .= '<a' . $attributes . '>';
		$output .= esc_html( $title );
		$output .= '</a>';

		if ( $is_mega_menu ) {
			$column_content = get_field( 'mega_menu_columns', $item->ID );
			if ( ! empty( $column_content ) ) {
				$output .= '<div class="mega-menu-columns-wrapper">';
				$output .= '<div class="container">';
				$output .= '<div class="row">';
				foreach ( $column_content as $column ) {
					$output .= '<div class="col">';

					$output .= '<h5>' . $column['column_title'] . '</h5>';
					$output .= '<ul class="list-group">';
					if ( ! empty( $column['menu_items'] ) ) {
						foreach ( $column['menu_items'] as $menu_item ) {
							$output .= '<li>';
							$output .= '<a class="icon-link" href="' . esc_url( $menu_item['item_links'] ?? '#' ) . '">';
							if ( ! empty( $menu_item['menu_icon'] ) ) {

								$image = wp_get_attachment_image(
									$menu_item['menu_icon']['id'],
									'full',
									'',
									[
										'class' => 'object-fit-contain menu-icon',
										'alt'   => get_the_title( $menu_item['menu_icon']['id'] ),
									]
								);

								$output .= $image;
							}
							$output .= '<strong>' . esc_html( $menu_item['item_title'] ?? '' ) . '</strong>';
							$output .= '<span>Lorem ipsum dolor sit amet, consectetur.</span></a>';
							$output .= '</li>';
						}
					}
					$output .= '</ul>';
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '</div>';
				$output .= '</div>';
			}
		}

	}
}
