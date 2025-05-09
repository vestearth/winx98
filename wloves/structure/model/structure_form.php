<?php
class Structure_Form
{
  public static function labelText($label, $text, $class = 'col-md-4')
  {
    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<p>' . $text . '</p>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputText($label, $name, $value = '', $placeholder = '', $options = [])
  {
    if (!$placeholder) {
      $placeholder = 'Enter ' . strtolower($label) . ' ..';
    }

    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $pattern     = isset($options['pattern']) ? 'pattern="' . $options['pattern'] . '"' : '';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="text" name="' . $name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . $value . '" ' . $pattern . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputDate($label, $name, $value = '', $options = [])
  {
    if (!$value) {
      $value = date('Y-m-d');
    }

    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';
    $min         = isset($options['min']) ? 'min="' . $options['min'] . '"' : '';
    $max         = isset($options['max']) ? 'max="' . $options['max'] . '"' : '';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="date" name="' . $name . '" class="' . $input_class . '" value="' . $value . '" ' . $min . ' ' . $max . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputTime($label, $name, $value = '', $options = [])
  {
    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';
    $min         = isset($options['min']) ? 'min="' . $options['min'] . '"' : '';
    $max         = isset($options['max']) ? 'max="' . $options['max'] . '"' : '';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="time" name="' . $name . '" class="' . $input_class . '" value="' . $value . '" ' . $min . ' ' . $max . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputDateTime($label, $name, $value = '', $options = [])
  {
    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';
    $min         = isset($options['min']) ? 'min="' . $options['min'] . '"' : '';
    $max         = isset($options['max']) ? 'max="' . $options['max'] . '"' : '';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="datetime-local" name="' . $name . '" class="' . $input_class . '" value="' . $value . '" ' . $min . ' ' . $max . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputNumber($label, $name, $value = 0, $placeholder = 0, $options = [])
  {
    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';
    $min         = isset($options['min']) ? 'min="' . $options['min'] . '"' : '';
    $max         = isset($options['max']) ? 'max="' . $options['max'] . '"' : '';
    $step        = isset($options['step']) ? $options['step'] : '0.01';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="number" name="' . $name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . $value . '" step="' . $step . '" ' . $min . ' ' . $max . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputEmail($label, $name, $value = '', $placeholder = 'Enter email ..', $options = [])
  {
    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $pattern     = isset($options['pattern']) ? 'pattern="' . $options['pattern'] . '"' : '';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="email" name="' . $name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . $value . '" ' . $pattern . ' ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInputTel($label, $name, $value = '', $placeholder = '', $options = [])
  {
    if (!$placeholder) {
      $placeholder = 'Enter ' . strtolower($label) . ' ..';
    }

    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : 'required';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="tel" name="' . $name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . $value . '" ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelTextarea($label, $name, $value = '', $placeholder = 'Type here ..', $options = [])
  {
    $class       = isset($options['class']) ? $options['class'] : 'col-12';
    $input_class = isset($options['input_class']) ? $options['input_class'] : 'form-control';
    $prop        = isset($options['prop']) ? $options['prop'] : '';

    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<textarea name="' . $name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" ' . $prop . '>' . $value . '</textarea>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelInput($input_name, $input_value, $label = 'label', $placeholder = '', $type = 'text', $input_class = 'form-control', $class = 'col-12', $prop = 'required')
  {
    $html = '';

    $html .= '<div class="form-group ' . $class . '">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<input type="' . $type . '" name="' . $input_name . '" class="' . $input_class . '" placeholder="' . $placeholder . '" value="' . $input_value . '" ' . $prop . '>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function labelTextInline($label, $text, $class_label = '', $class_text = '', $class_row = 'form-row', $class_col_label = 'col-md-3', $class_col_text = 'col-md-9')
  {
    $html = '';

    $html .= '<div class="' . $class_row . '">';
    $html .= '<div class="' . $class_col_label . '">';
    $html .= '<label class="' . $class_label . '">' . $label . '</label>';
    $html .= '</div>';
    $html .= '<div class="' . $class_col_text . '">';
    $html .= '<p class="' . $class_text . '">' . $text . '</p>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function imageUpload($data_input, $has_image, $image, $image_id, $type, $class, $name_upload, $name_delete, $name_input = 'image')
  {
    $image       = ($image) ? $image : '../../structure/image/placeholder/no_image_trans.png';
    $image_id    = ($image_id) ? $image_id : 'image_id';
    $type        = ($type) ? $type : 'has-form';
    $name_upload = ($name_upload) ? $name_upload : 'submit_upload';
    $name_delete = ($name_delete) ? $name_delete : 'submit_delete';

    $html = '';
    $html .= '<div class="manage_image ' . $class . ' ' . $type . '">';
    if ($type) {
      $html .= '<form method="post" enctype="multipart/form-data" class="upload_image">';
      foreach ($data_input as $key => $value) {
        $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
      }
      $html .= '<input type="hidden" name="' . $name_upload . '">';
    }

    $html .= '<div class="preview-image">';
    $html .= '<img src="' . $image . '">';
    $html .= '</div>';
    $html .= '<input type="hidden" name="id" value="' . $image_id . '">';
    $html .= '<input type="file" name="' . $name_input . '" class="file-input" id="' . $image_id . '">';
    $html .= '<label class="file-upload-btn" for="' . $image_id . '"></label>';
    $html .= '<button type="button" class="file-delete-btn ' . $has_image . '">' . file_get_contents("../../structure/image/placeholder/icon-delete-image.svg") . '</button>';
    $html .= '<input type="hidden" name="bg-image" value="' . $image . '">';
    if ($type && $type != 'no-form') {
      $html .= '</form>';
      $html .= '<form method="post" class="delete_image">';
      $html .= '<input type="hidden" name="id" value="' . $image_id . '">';
      foreach ($data_input as $key => $value) {
        $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
      }
      $html .= '<input type="hidden" name="' . $name_delete . '">';
      $html .= '</form>';
    }
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function selectForm($label, $name, $data = [], $value = '', $class = 'form-control')
  {
    // ข้อมูลส่งมาแบบนี้
    // $data = [
    //   [
    //     'name'  => '',
    //     'value' => ''
    //   ]
    // ];
    $html = '';
    $html .= '<div class="form-group">';
    $html .= '<label>' . $label . '</label>';
    $html .= '<select name="' . $name . '" class="' . $class . '">';
    foreach ($data as $option_data) {
      $selected = ($value == $option_data['value']) ? 'selected' : '';
      $html .= '<option value="' . $option_data['value'] . '" ' . $selected . '>' . $option_data['name'] . '</option>';
    }
    $html .= '</select>';
    $html .= '</div>';

    echo $html;
    return;
  }

  public static function imageNoAutoSubmit($image, $name_submit_upload = 'submit_upload', $name_submit_delete = 'submit_delete', $option = [])
  {
    $option['image_id']          = (isset($option['image_id'])) ? $option['image_id'] : '';
    $option['class']             = (isset($option['class'])) ? $option['class'] : '';
    $option['has_image']         = (isset($option['has_image'])) ? $option['has_image'] : '';
    $option['placeholder_image'] = (isset($option['placeholder_image'])) ? $option['placeholder_image'] : '';
    $option['no_delete']         = (isset($option['no_delete'])) ? $option['no_delete'] : '';
    $option['required']          = (isset($option['required']) && $option['required']) ? $option['required'] : '';

    $html = '';
    $html .= '<div class="manage_image ' . $option['class'] . '">';
    $html .= '<div class="preview-image">';
    $html .= '<img src="' . $image . '">';
    $html .= '</div>';
    $html .= '<input type="hidden" name="image_id_' . $option['image_id'] . '" value="' . $option['image_id'] . '">';
    $html .= '<input type="file" name="image_' . $option['image_id'] . '" class="file-input" id="image_' . $option['image_id'] . '" ' . $option['required'] . '>';
    $html .= '<label class="file-upload-btn" for="image_' . $option['image_id'] . '"></label>';
    if (!$option['no_delete']) {
      $html .= '<button type="button" class="file-delete-btn ' . $option['has_image'] . '">' . file_get_contents("../../structure/image/placeholder/icon-delete-image.svg") . '</button>';
    }
    $html .= '<input type="hidden" name="bg-image" value="' . $option['placeholder_image'] . '">';
    $html .= '</div>';

    echo $html;
    return;
  }
}
