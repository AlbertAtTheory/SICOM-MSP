<?php

/**
 * @file
 * Hierarchical display template file.
 */
  $path = explode('/', drupal_get_path_alias());

  $items = array();
  $list = array();

  $query = new EntityFieldQuery();

  $query->entityCondition('entity_type', 'vehicle_make')
    ->propertyOrderBy('make_name');
    
  if ($path[1] == 'cars') {
    $query->fieldCondition('field_motorcycle', 'value', '0');
  } else {
    $query->fieldCondition('field_motorcycle', 'value', '1');
  }

  $make_query = $query->execute();

  if (isset($make_query['vehicle_make'])):
    $make_nids = array_keys($make_query['vehicle_make']);
    $make_entities = entity_load('vehicle_make', $make_nids);
  endif;

  foreach ($make_entities as $make):
    $model_items = array();
    $model_list = array();

    $query = new EntityFieldQuery();

    $query->entityCondition('entity_type', 'vehicle_model')
      ->propertyCondition('make_id', $make->make_id)
      ->propertyOrderBy('model_name');

    $model_query = $query->execute();

    if (isset($model_query['vehicle_model'])):
      $model_nids = array_keys($model_query['vehicle_model']);
      $model_entities = entity_load('vehicle_model', $model_nids);

      foreach ($model_entities as $model):
        $model_items[$model->model_name][] = $model->model_trim;
      endforeach;

      foreach (array_keys($model_items) as $model_entity):
        $trim_items = array();

        // Compile the list of trim levels.
        foreach ($model_items[$model_entity] as $trim_entity):
          $year_items = array();

          if ($trim_entity):            
            $query = new EntityFieldQuery();

            $query->entityCondition('entity_type', 'vehicle_model')
              ->propertyCondition('model_trim', $trim_entity)
              ->propertyOrderBy('model_year_start');

            $year_query = $query->execute();
            
            if (isset($year_query['vehicle_model'])):
              $year_nids = array_keys($year_query['vehicle_model']);
              $year_entities = entity_load('vehicle_model', $year_nids);

              foreach ($year_entities as $years):
                if ($years->model_year_start == $years->model_year_end || !$years->model_year_end):
                  $year_print = $years->model_year_start;
                else:
                  $year_print = $years->model_year_start . '-' . $years->model_year_end;
                endif;
                $year_items[$years->model_id] = '<a href="' . drupal_get_path_alias('vehicle/model/' . $years->model_id) . '">' . $year_print . '</a>';
              endforeach;
            endif;

            $trim_items[] = array(
              'data' => '<a href="#" class="sublevels">' . $trim_entity . '</a>',
              'children' => $year_items,
            );
          else:
            $query = new EntityFieldQuery();

            $query->entityCondition('entity_type', 'vehicle_model')
              ->propertyCondition('model_name', $model_entity)
              ->propertyOrderBy('model_year_start');

            $year_query = $query->execute();

            if (isset($year_query['vehicle_model'])):
              $year_nids = array_keys($year_query['vehicle_model']);
              $year_entities = entity_load('vehicle_model', $year_nids);

              foreach ($year_entities as $years):
                if ($years->model_year_start == $years->model_year_end || !$years->model_year_end):
                  $year_print = $years->model_year_start;
                else:
                  $year_print = $years->model_year_start . '-' . $years->model_year_end;
                endif;
                $year_items[$years->model_id] = '<a href="' . drupal_get_path_alias('vehicle/model/' . $years->model_id) . '">' . $year_print . '</a>';
              endforeach;
            endif;

            $trim_items = $year_items;
          endif;
        endforeach;

        if ($trim_items):
          // There are trim levels so add these as children.
          $model_list[] = array(
            'data' => '<a href="#" class="sublevels">' . $model_entity . '</a>',
            'children' => $trim_items,
          );
        else:
          // There is no trim level so don't add children.
          $model_list[] = array(
            'data' => '<a href="#">' . $model_entity . '</a>',
          );
        endif;
      endforeach;

      $items[$make->make_id] = array(
        'data' => '<a href="#" class="sublevels">' . $make->make_name . '</a>',
        'children' => $model_list,
      );
    endif;
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
    $('.vehicle-ymm-block li > a.sublevels').bind("click", function() {
      // Hide all children.
      $(this).find('div').hide();
      // Toggle next UL.
      $(this).toggleClass('expanded').toggleClass('collapsed').next('div').toggle('normal');
      return false;
    });
  })(jQuery);
</script>
