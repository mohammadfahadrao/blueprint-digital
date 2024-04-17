<?php
require_once 'head.php';
?>
<div class="success_msg bp-text-center bp-alert-success  bp-d-none"></div>
<div class="error_msg bp-text-center bp-alert-danger bp-d-none"></div>
<div class="bp-card wp-card-width-25 wp-card-padding-50">
    <div class="bp-card-content">
        <div class="bp-vertical-error-fetch bp-text-error"></div>
        <div class="bp-form-header">
            <div class="bp-form-header-text">Request a Quote</div>
            <div class="bp-form-header-stepper">
                <div class="bp-stepper-text">Step <span>1</span> of 1</div>

                <div class="bp-stepper-bar">
                    <div class="bp-bar-fill"></div>
                </div>
            </div>
        </div>
        <div class="bp-input-container">
        <form id="blueprintdigital-form" action="<?php echo BLUEPRINT_API_BASE_URL . '/users/create-user?hostname=' . get_permalink(); ?>" method="POST" id="demo-form" onsubmit="return validateBlueForm();" enctype="multipart/form-data">
            <?php
echo '<div class="bp-row">';
            foreach ($formVerticalFields as $field_name => $row) {
                $label = '';
                echo '<div class="bp-col-12">';
                if (str_contains($field_name, '_')) {
                    $res = explode('_', $field_name);
                    $label = ucfirst($res[0]);
                    echo '<div class="bp-input-field"><label class="bp-label" for="' . $field_name . '">' . ucfirst($res[0]) . " " . ucfirst($res[1]);
                    echo '</label>';
                } else {
                    $label = ucfirst($field_name);
                    echo '<div class="bp-input-field"><label class="bp-label" for="' . $field_name . '">' . ucfirst($field_name) . '</label>';
                }
                if ($row->type == 'select') {
                    echo '<select class="bp-select" id="' . $field_name . '" name="' . $field_name . '">';
                    foreach ($row->type_meta as $option) {
                        echo '<option value="' . $option . '">' . $option . '</option>';
                    }
                    echo '</select></div>';
                } else {
                    echo '<input type="' . $row->type . '" id="' . $field_name . '" name ="' . $field_name . '" placeholder="'.$label.'" class="bp-input-type"' . (($row->required) ? 'required' : '') . '/></div>';
                }
                echo '</div>';

            }
            ?>
            <div class="row bp-w-100">
                <div class="col-md-12"><input type="checkbox" id="term_and_conditions" name="terms_and_conditions"><span class="bp-chk-text"> I Agree Terms and Conditions. </span></div>
            </div>
            <div class="row bp-w-100">
                <div class="col-md-12"><i class="text-danger bp-error-checkbox bp-text-error bp-err-font-sm"></i></div>
            </div>
            <div class="g-recaptcha" id="rcaptcha" data-sitekey="6Lfk5l0iAAAAAEDXV6LndcUhPsVTHTvMioeDtaRX"></div>
            <span id="captcha" class="bp-text-error bp-err-font-sm bp-font-italic bp-err-text-captc"></span>
            <input class="btn btn-success btn-block bp-next-btn" value="Submit" type="submit" style="margin-top:15px;" />
            <?php
            echo '</div>';
            ?>
        </form>
        </div>
    </div>
</div>
</div>
