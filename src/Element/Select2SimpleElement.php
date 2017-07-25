<?php

namespace Drupal\select2\Element;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Select;

/**
 * Provides a simple select2 form element.
 *
 * @FormElement("select2_simple_element")
 */
class Select2SimpleElement extends Select {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $info = parent::getInfo();
    $class = get_class($this);
    $info['#process'] = [
      [$class, 'processSelect2'],
    ];

    return $info;
  }

  /**
   * Processes a select2 form element.
   *
   * {@inheritdoc}
   */
  public static function processSelect2(
    &$element,
    FormStateInterface $form_state,
    &$complete_form
  ) {

    $element = parent::processSelect($element, $form_state, $complete_form);

    $class = 'select2-' . hash(
        'md5',
        Html::getUniqueId('select2-simple-element')
      );

    $base_url = \Drupal::request()->getSchemeAndHttpHost();
    $element['#attributes']['class'][] = $class;
    $select2_settings = [
      'selector' => '.' . $class,
      'placeholder_text' =>  $element['#placeholder_text'],
      'multiple' => $element['#multiple'],
      'base_url' => $base_url
    ];
    if(isset($element['#loadRemoteData'])) {
      $select2_settings['loadRemoteData'] = ['url'=>$base_url . $element['#loadRemoteData']];
    }

    $element['#attached']['drupalSettings']['select2'][$class] = $select2_settings;
    $element['#attached']['library'] = ['select2/select2.widget'];

    return $element;
  }


}