<?php
	$calc_orders_query = new WP_Query(); 
	$calc_orders = $calc_orders_query->query(
		array(
			'posts_per_page' => -1, 
			'post_type' => 'calc_orders'
		)
	);

	$calc_orders = array();
	
	$orders_count = count($calc_orders);
	$order_id = $orders_count + 1000;
?>
<script>
function getRandomIndex(usedIndexs, maxIndex) {
	var result = 0;
	var min = 0;
	var max = maxIndex - 1;
	var index = Math.floor(Math.random()*(max-min+1)+min);

	while(usedIndexs.indexOf(index) > -1) {
	    if (index < max) {
	        index++;
	    } else {
	      index = 0;
	    }
	}

	return index;
}
if(localStorage.getItem('jqcart') != null) {
	jQuery(document).ready(function($){
		var lsItems = JSON.parse(localStorage.getItem('jqcart'));
		var lsItemsArr = [];
		var lsItemsCount = 0;
		for (var key of Object.keys(lsItems)) {
		    lsItemsArr[lsItemsCount] = lsItems[key].id;
		    lsItemsCount++;
		}
		$('.modal_calc').each(function(index) {
			lsItemsArr[lsItemsArr.length + index + 1] = $(this).find('input[name="id"]').val();
			var curId = getRandomIndex(lsItemsArr,10000);
			$(this).find('input[name="id"]').val(curId);
			$(this).find('.submit').attr('data-id', curId);
			lsItemsArr[lsItemsArr.length + index + 1] = curId;
		});
	});
}
</script>
<?php
	$calcs_query = new WP_Query(); 
	$calcs_query->query(
		array(
			'posts_per_page' => -1, 
			'post_type' => 'calcs_items'
		)
	); 
	while ($calcs_query->have_posts()) : $calcs_query->the_post();
?>
<?php if(get_field('calc_link') != '') { ?>
<?php $calcType = get_field('calc_type'); ?>
<?php $order_id++; ?>
<div class="modal_window modal_calc" id="<?php the_field('calc_link'); ?>">
	<div class="modal_close"></div>
	<div class="modal_inside">
		<div class="modal_title"><?php the_field('calc_title'); ?></div>
		<form id="form_<?php echo $calcType; ?>">
			<input type="hidden" name="id" value="<?php echo $order_id; ?>"/>
			<input type="hidden" name="title" value="<?php the_title(); ?>"/>
			<input type="hidden" name="price" value=""/>
			<input type="hidden" name="total" value=""/>
			<input type="hidden" name="quantity" value=""/>
			<input type="hidden" name="type_calc" value="<?php the_field('calc_type'); ?>"/>
			<?php if($calcType == 'stul') { ?>
				<input type="hidden" name="basic_price" value="<?php the_field('styl_basic_price'); ?>"/>
				<div class="calc_inside">
					<div class="calc_fields">
						<div class="calc_checkboxes">
							<div class="calc_title">Стул со спинкой?</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="checkbox" name="calc_stul_back" class="calc_checkbox_input" value="<?php the_field('styl_chair_price'); ?>"/>
										<span class="calc_checkbox_input_txt">Да</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_checkboxes">
							<div class="calc_title">Материал обивки</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_stul_type" class="calc_checkbox_input" value="<?php echo the_field('stul_text_multiplier'); ?>" checked/>
										<span class="calc_checkbox_input_txt">Текстиль</span>
									</label>
								</div>
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_stul_type" class="calc_checkbox_input" value="<?php echo the_field('stul_skin_multiplier'); ?>"/>
										<span class="calc_checkbox_input_txt">Кожа</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'divan') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<?php if( have_rows('divan_seats') ) { ?>
							<div class="calc_select">
								<div class="calc_title">Количество посадочных мест</div>
								<div class="calc_select_inside">
									<select name="divan_seats_select">
										<?php $i = 1; while( have_rows('divan_seats') ) : the_row();  ?>
											<option value="<?php the_sub_field('divan_seats_price_type_1'); ?>"><?php the_sub_field('divan_seats_title'); ?></option>
										<?php $i++; endwhile; ?>
									</select>
								</div>
							</div>
							<div class="calc_checkboxes">
								<div class="calc_title">Материал обивки</div>
								<div class="calc_checkboxes_inside">
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="radio" name="calc_divan_type" class="calc_checkbox_input" value="<?php the_field('divan_text_multiplier'); ?>" checked/>
											<span class="calc_checkbox_input_txt">Текстиль</span>
										</label>
									</div>
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="radio" name="calc_divan_type" class="calc_checkbox_input" value="<?php the_field('divan_skin_multiplier'); ?>"/>
											<span class="calc_checkbox_input_txt">Кожа</span>
										</label>
									</div>
								</div>
							</div>
							<div class="calc_checkboxes">
								<div class="calc_title">Нужно ли чистить спальное место?</div>
								<div class="calc_checkboxes_inside">
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="checkbox" name="calc_divan_clean" class="calc_checkbox_input" value="<?php the_field('divan_clean_price'); ?>"/>
											<span class="calc_checkbox_input_txt">Да</span>
										</label>
									</div>
								</div>
							</div>
							<div class="calc_checkboxes">
								<div class="calc_title">Нужно ли чистить съемные подушки?</div>
								<div class="calc_checkboxes_inside">
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="checkbox" name="calc_divan_pad" class="calc_checkbox_input" data-item="2" value="<?php the_field('divan_pod_price'); ?>"/>
											<span class="calc_checkbox_input_txt">Да</span>
										</label>
									</div>
								</div>
							</div>
							<div class="calc_checkboxes calc_checkboxes--small" data-item="2">
								<div class="calc_quantity">
									<div class="calc_title">Кол-во подушек:</div>
									<div class="calc_quantity_inside">
										<div class="calc_quantity_field">
											<span class="calc_quantity_control calc_quantity_control--minus">-</span>
											<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
											<span class="calc_quantity_control calc_quantity_control--plus">+</span>
										</div>
									</div>
								</div>
							</div>
							<div class="calc_checkboxes">
								<div class="calc_title">Нужно ли выводить запах мочи?</div>
								<div class="calc_checkboxes_inside">
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="checkbox" name="calc_divan_urina" class="calc_checkbox_input" value="<?php the_field('divan_urina'); ?>"/>
											<span class="calc_checkbox_input_txt">Да</span>
										</label>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'kreslo') { ?>
				<input type="hidden" name="basic_price" value="<?php the_field('kreslo_basic_price'); ?>"/>
				<div class="calc_inside">
					<div class="calc_fields">
						<div class="calc_checkboxes">
							<div class="calc_title">Есть ли выдвижная часть?</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="checkbox" name="calc_kreslo_sliding" class="calc_checkbox_input" value="<?php echo the_field('kreslo_sliding_price'); ?>"/>
										<span class="calc_checkbox_input_txt">Да</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_checkboxes">
							<div class="calc_title">Материал обивки</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_kreslo_type" class="calc_checkbox_input" value="<?php echo the_field('kreslo_text_multiplier'); ?>" checked/>
										<span class="calc_checkbox_input_txt">Текстиль</span>
									</label>
								</div>
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_kreslo_type" class="calc_checkbox_input" value="<?php echo the_field('kreslo_skin_multiplier'); ?>"/>
										<span class="calc_checkbox_input_txt">Кожа</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'pufik') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<div class="calc_checkboxes">
							<div class="calc_title">Материал обивки</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_pufik_type" class="calc_checkbox_input" value="<?php echo the_field('pufik_price_type_1'); ?>" checked/>
										<span class="calc_checkbox_input_txt">Текстиль</span>
									</label>
								</div>
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_pufik_type" class="calc_checkbox_input" value="<?php echo the_field('pufik_price_type_2'); ?>"/>
										<span class="calc_checkbox_input_txt">Кожа</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'office') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<?php if( have_rows('office_mebel') ) { ?>
							<div class="calc_select">
								<div class="calc_title">Что нужно чистить?</div>
								<div class="calc_select_inside">
									<select name="office_select">
										<?php $i = 1; while( have_rows('office_mebel') ) : the_row();  ?>
											<option value="<?php echo 'office_type_' . $i; ?>" data-price-txt="<?php the_sub_field('office_mebel_price_type_1'); ?>" data-price-skin="<?php the_sub_field('office_mebel_price_type_2'); ?>"><?php the_sub_field('office_mebel_title'); ?></option>
										<?php $i++; endwhile; ?>
									</select>
								</div>
							</div>
							<div class="calc_checkboxes">
								<div class="calc_title">Материал обивки</div>
								<div class="calc_checkboxes_inside">
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="radio" name="calc_office_type" class="calc_checkbox_input" value="0" checked/>
											<span class="calc_checkbox_input_txt">Текстиль</span>
										</label>
									</div>
									<div class="calc_checkbox">
										<label class="calc_checkbox_label">
											<input type="radio" name="calc_office_type" class="calc_checkbox_input" value="0"/>
											<span class="calc_checkbox_input_txt">Кожа</span>
										</label>
									</div>
								</div>
							</div>
							<div class="calc_quantity">
								<div class="calc_title">Кол-во:</div>
								<div class="calc_quantity_inside">
									<div class="calc_quantity_field">
										<span class="calc_quantity_control calc_quantity_control--minus">-</span>
										<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
										<span class="calc_quantity_control calc_quantity_control--plus">+</span>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'matras') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<?php if( have_rows('matras_sizes') ) { ?>
							<div class="calc_checkboxes">
								<div class="calc_title">Размер</div>
								<div class="calc_checkboxes_inside">
									<?php $i = 1; while( have_rows('matras_sizes') ) : the_row();  ?>
										<div class="calc_checkbox">
											<label class="calc_checkbox_label">
												<input type="radio" name="calc_matras_size" class="calc_checkbox_input" value="<?php echo the_sub_field('matras_size_price'); ?>" <?php if($i == 1) echo 'checked'; ?>/>
												<span class="calc_checkbox_input_txt"><?php echo the_sub_field('matras_size_title'); ?></span>
											</label>
										</div>
									<?php $i++; endwhile; ?>
								</div>
							</div>
						<?php } ?>
						<div class="calc_checkboxes">
							<div class="calc_title">Чистим с двух сторон?</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="checkbox" name="calc_matras_clean_both" class="calc_checkbox_input" value="2"/>
										<span class="calc_checkbox_input_txt">Да</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_checkboxes">
							<div class="calc_title">Нужна ли обработка от запаха?</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="checkbox" name="calc_matras_clean_smell" class="calc_checkbox_input" value="<?php the_field('matras_price_smell'); ?>"/>
										<span class="calc_checkbox_input_txt">Да</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'kovrik') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<div class="calc_inputs">
							<div class="calc_title">Размер</div>
							<div class="calc_inputs_inside">
								<div class="calc_inputs_item">
									<div class="calc_inputs_title">Длина (в см.)</div>
									<div class="calc_input_field modal_form_field">
										<input type="text" name="calc_kover_dlin" class="calc_input input_number" placeholder="Введите число" value="20"/>
									</div>
								</div>
								<div class="calc_inputs_item">
									<div class="calc_inputs_title">Ширина (в см.)</div>
									<div class="calc_input_field modal_form_field">
										<input type="text" name="calc_kover_shir" class="calc_input input_number" placeholder="Введите число" value="60"/>
									</div>
								</div>
							</div>
						</div>
						<div class="calc_checkboxes">
							<div class="calc_title">Материал</div>
							<div class="calc_checkboxes_inside">
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_kover_type" class="calc_checkbox_input" value="<?php echo the_field('kover_sint_price'); ?>" checked/>
										<span class="calc_checkbox_input_txt">Синтетика</span>
									</label>
								</div>
								<div class="calc_checkbox">
									<label class="calc_checkbox_label">
										<input type="radio" name="calc_kover_type" class="calc_checkbox_input" value="<?php echo the_field('kover_sherst_price'); ?>"/>
										<span class="calc_checkbox_input_txt">Шерсть</span>
									</label>
								</div>
							</div>
						</div>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
			<?php if($calcType == 'other') { ?>
				<div class="calc_inside">
					<div class="calc_fields">
						<?php if( have_rows('other_elements') ) { ?>
							<div class="calc_select">
								<div class="calc_title">Прочее</div>
								<div class="calc_select_inside">
									<select name="other_elements_select">
										<?php $i = 1; while( have_rows('other_elements') ) : the_row();  ?>
											<option value="<?php echo 'other_elements_type_' . $i; ?>"><?php the_sub_field('other_element_title'); ?></option>
										<?php $i++; endwhile; ?>
									</select>
								</div>
							</div>
						<?php } ?>
						<?php if( have_rows('other_elements') ) { ?>
							<?php $i = 1; while( have_rows('other_elements') ) : the_row();  ?>
								<div class="calc_checkboxes calc_checkboxes_other" data-item="<?php echo 'other_elements_type_' . $i; ?>">
									<div class="calc_title"><?php the_sub_field('other_element_subtitle'); ?></div>
									<?php if( have_rows('other_elements_inside') ) { ?>
										<div class="calc_checkboxes_inside">
											<?php $count = 1; while( have_rows('other_elements_inside') ) : the_row();  ?>
												<div class="calc_checkbox">
													<label class="calc_checkbox_label">
														<input type="radio" name="<?php echo 'other_elements_type_' . $i; ?>" class="calc_checkbox_input" value="<?php echo the_sub_field('other_elements_variant_price'); ?>" <?php if($count == 1) echo 'checked'; ?>/>
														<span class="calc_checkbox_input_txt"><?php echo the_sub_field('other_elements_variant_title'); ?></span>
													</label>
												</div>
											<?php $count++; endwhile; ?>
										</div>
									<?php } ?>
								</div>
							<?php $i++; endwhile; ?>
						<?php } ?>
						<div class="calc_quantity">
							<div class="calc_title">Кол-во:</div>
							<div class="calc_quantity_inside">
								<div class="calc_quantity_field">
									<span class="calc_quantity_control calc_quantity_control--minus">-</span>
									<input type="text" name="calc_quantity" class="calc_quantity_input input_number" data-min="0" data-max="9999" value="1"/>
									<span class="calc_quantity_control calc_quantity_control--plus">+</span>
								</div>
							</div>
						</div>
					</div>
					<div class="calc_price">
						Стоимость: <span>2 200</span> <em>₽</em>
					</div>
					<div class="calc_submit">
						<input type="submit" class="submit" name="calc_submit" value="Добавить в корзину"/>
					</div>
				</div>
			<?php } ?>
		</form>
	</div>
</div>
<?php } ?>
<?php endwhile; ?>
