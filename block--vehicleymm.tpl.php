<?php

/**
 * @file
 * Hierarchical display template file.
 */

  $items = array();
  $list = array();

  $query = new EntityFieldQuery();

  $query->entityCondition('entity_type', 'vehicle_make')
    ->fieldCondition('field_motorcycle', 'value', 1, '!=')
    ->propertyOrderBy('make_name');

  $make_query = $query->execute();

  if (isset($make_query['vehicle_make'])) {
    $make_nids = array_keys($make_query['vehicle_make']);
    $make_entities = entity_load('vehicle_make', $make_nids);
  }

  foreach ($make_entities as $make):    
    $model_items = array();

    $query = new EntityFieldQuery();

    $query->entityCondition('entity_type', 'vehicle_model')
      ->propertyCondition('make_id', $make->make_id)
      ->propertyOrderBy('model_name');

    $model_query = $query->execute();

    if (isset($model_query['vehicle_model'])) {
      $model_nids = array_keys($model_query['vehicle_model']);
      $model_entities = entity_load('vehicle_model', $model_nids);
    }

    foreach ($model_entities as $model):
      $model_items[$model->model_name][] = $model->model_trim;
    endforeach;

    foreach (array_keys($model_items) as $model_entity):
      $trim_items = array();

      foreach ($model_items[$model_entity] as $trim_entity):
        $trim_items[] = $trim_entity;
      endforeach;

      $model_list[] = array(
        'data' => '<a href="#">' . $model_entity . '</a>',
        'children' => $trim_items,
      );
    endforeach;

    $items[$make->make_id] = array(
      'data' => '<a href="#">' . $make->make_name . '</a>',
      'children' => $model_list,
    );
  endforeach;

  $list['title'] = '';
  $list['type'] = 'ul';
  $list['attributes'] = array('class' => 'vehicle-ymm-block');
  $list['items'] = $items;

  print theme_item_list($list);
?>
<script>
  (function ($) {
    // Hide all children.
    $('.vehicle-ymm-block li > div').hide();
    // Expand anything with the class "expanded."
    $('.vehicle-ymm-block li > .expanded + ul').show('normal');
    $('.vehicle-ymm-block li > a').bind("click", function() {
      // Hide all children.
      $(this).find('div').hide();
      // Toggle next UL.
      $(this).toggleClass('expanded').toggleClass('collapsed').next('div').toggle('normal');
      return false;
    });
  })(jQuery);
</script>
