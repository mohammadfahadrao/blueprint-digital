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
                <div class="bp-stepper-text">Step <span class="bp-counter-current-screen">1</span> of <span class="bp-counter-total">-</span></div>

                <div class="bp-stepper-bar">
                    <div class="bp-bar-fill"></div>
                </div>
            </div>
        </div>
        <div class="bp-input-container">
        <form id="blueprintdigital-form" action="<?php echo BLUEPRINT_API_BASE_URL . '/users/create-user?hostname=' . get_permalink(); ?>" method="POST" onsubmit="return validateBlueForm();" enctype="multipart/form-data">

            <?php
            $form_count = array_chunk((array)$formVerticalFields, 10, true);
            foreach ($form_count as $index => $form_columns) {
                $section_class = ($index != 0) ? "bp-d-none" : "";
            ?>

                <section id="step-<?php echo $index + 1; ?>" class="form-step <?php echo $section_class; ?>">
                <div class="bp-row">
                    <?php
                    foreach ($form_columns as $field_name => $row) {
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
                    ?>

                            <input type="<?= $row->type ?>" id="<?= $field_name ?>" name="<?= $field_name ?>" placeholder="<?=$label?>" class="bp-input-type" <?= (json_decode($row->required)) ? 'required' : '' ?> /></div>
                <?php
                        }
                        echo '</div>';
                    }
                    echo '<div class="bp-counter" current_step="' . $index . '" step_number="' . ($index + 2) . '" steps="' . count($form_count) . '"></div>';
                    echo '<div class="mt-3">';

                    ?>
                    <div class="bp-button-container">

                <?php
                echo '<button class="bp-clear-btn btn-navigate-back" style="display:none;" type="button" current_step_btn="' . ($index + 1) . '"  step_number="' . ($index) . '" >Back</button>';
                echo '<button class="bp-next-btn button btn-navigate-form-step btn btn-info" type="button" current_step_btn="' . ($index + 1) . '"  step_number="' . ($index + 2) . '" >Next</button>';
                ?>

            </div>
            <?php
                    echo '</div>';
                    echo '</div>';
                    echo '</section>';

                }
                ?>

                <div class="bp-submit-section bp-mt-5 bp-d-none">
                    <div class="row">
                        <div class="col-md-12"><input type="checkbox" id="term_and_conditions" name="terms_and_conditions"> <span class="bp-chk-text">I agree Terms and Conditions.</span></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><i class="text-danger bp-error-checkbox bp-text-error bp-err-font-sm"></i></div>
                    </div>
                    <div class="g-recaptcha" id="rcaptcha" data-sitekey="6Lfk5l0iAAAAAEDXV6LndcUhPsVTHTvMioeDtaRX"></div>
                    <span id="captcha" class="bp-text-error bp-err-font-sm bp-font-italic"></span>
                   <div class="bp-row  bp-mt-5">
                    <button class="bp-clear-last-btn btn-last-section bp-d-none" type="button" current_step_btn="1"  step_number="1" >Back</button>
                    <input class="btn btn-success btn-block bp-next-btn" value="Submit" type="submit" />
                    </div>
                </div>

        </form>
        </div>
    </div>
</div>
</div>
