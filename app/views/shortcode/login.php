<br/>
<div class="row">
    <div class="col-md-6 no-padding">
        <div class="mm_login_form">
            <div class="page-header">
                <h3><?php _e("Einloggen", mmg()->domain) ?></h3>
            </div>
            <?php mm_login_form(); ?>
        </div>
    </div>
    <div class="col-md-6 no-padding">
        <div class="mm_sign_up">
            <div class="page-header">
                <h3><?php _e("Konto erstellen", mmg()->domain) ?></h3>
            </div>
            <p><?php _e("Melden Dich an, um ein registriertes Mitglied der Website zu werden", mmg()->domain) ?></p>
            <a href="<?php echo wp_registration_url(); ?>" class="btn btn-primary mm_signup_btn"><?php _e("Konto anlegen", mmg()->domain) ?></a>
        </div>
    </div>
    <div class="clearfix"></div>
</div>