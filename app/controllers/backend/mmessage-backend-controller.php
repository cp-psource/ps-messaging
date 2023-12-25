<?php

/**
 * Autor: DerN3rd
 */
class MMessage_Backend_Controller extends IG_Request
{
    public function __construct()
    {
        add_action('admin_menu', array(&$this, 'admin_menu'));
        add_action('wp_loaded', array(&$this, 'process_request'));
        add_action('wp_ajax_mm_plugin_action', array(&$this, 'plugins_action'));
        $dismissed = explode(',', (string)get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        if (!array_search('mmg_pointer', $dismissed)) {
            add_action('admin_enqueue_scripts', array(&$this, 'scripts'));
            add_action('admin_footer', array(&$this, 'footer_scripts'));
        }
    }

    function footer_scripts()
    {
		//deaktiviert, hängt sonst und geht nimmer weg
        $pointer_content = "<p>" . __("Bitte besuche Einstellungen> Messaging, um Deine Posteingangsseite auszuwählen und die Einrichtung abzuschließen", mmg()->domain) . "</p>";
        ?>
        <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready(function ($) {
                //jQuery selector to point to
                var pointer = $('#toplevel_page_mm_main').pointer({
                    content: '<?php echo $pointer_content; ?>',
                    position: {
                        edge: 'left',
                        align: 'center'
                    },
                    pointerClass: 'mmg-pointer',
                    close: function () {
                        $.post(ajaxurl, {
                            pointer: 'mmg_pointer',
                            action: 'dismiss-wp-pointer'
                        });
                    }
                }).pointer('open');
            });
            //]]>
        </script>
    <?php
    }

    function scripts()
    {
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
    }

    function plugins_action()
    {
        $setting = mmg()->setting();
        $addons = $setting->plugins;
        if (!is_array($addons))
            $addons = array();
        $id = mmg()->post('id');
        $meta = get_file_data($id, array(
            'Name' => 'Name',
            'Autor' => 'Autor',
            'Beschreibung' => 'Beschreibung',
            'AutorURI' => 'Autor URI',
            'Network' => 'Netzwerk'
        ), 'component');

        if (!in_array($id, $addons)) {
            //activate it
            $addons[] = $id;
            $setting->plugins = $addons;
            $setting->save();
            wp_send_json(array(
                'noty' => __("Die Erweiterung <strong>{$meta['Name']}</strong> aktiviert", mmg()->domain),
                'text' => __("Deaktivieren", mmg()->domain)
            ));
            exit;
        } else {
            unset($addons[array_search($id, $addons)]);
            $setting->plugins = $addons;
            $setting->save();
            wp_send_json(array(
                'noty' => __("Die Erweiterung <strong>{$meta['Name']}</strong> deaktiviert", mmg()->domain),
                'text' => __("Aktivieren", mmg()->domain)
            ));
            exit;
        }
    }

    function admin_menu()
    {
        add_menu_page(__('Messaging', mmg()->domain), __('Messaging', mmg()->domain), 'manage_options', mmg()->prefix . 'main', array(&$this, 'main'), 'dashicons-email-alt');
        add_submenu_page(null, __('Nachrichten anzeigen', mmg()->domain), __('Nachrichten anzeigen', mmg()->domain), 'manage_options', mmg()->prefix . 'view', array(&$this, 'view'));
        add_submenu_page(mmg()->prefix . 'main', __('Einstellungen', mmg()->domain), __('Einstellungen', mmg()->domain), 'manage_options', mmg()->prefix . 'setting', array(&$this, 'setting'));
    }

    public function main()
    {
        wp_enqueue_style('mm_style_admin');
        include mmg()->plugin_path . 'app/components/mm-messages-table.php';
        $this->render('backend/main');
    }

    function process_request()
    {
        if (current_user_can('manage_options') && isset($_POST['MM_Setting_Model'])) {
            if (!wp_verify_nonce(mmg()->post('_mmnonce'), 'mm_settings')) {
                return;
            }

            $model = new MM_Setting_Model();
            $model->load();
            $model->import($_POST['MM_Setting_Model']);
            $model->save();
            $this->set_flash('setting_save', __("Einstellungen wurden erfolgreich aktualisiert.", mmg()->domain));
            wp_redirect($_SERVER['REQUEST_URI']);
            exit;
        }
    }

    function view()
    {
        wp_enqueue_style('mm_style_admin');
        wp_enqueue_script('ig-packed');
        $id = mmg()->get('id', 0);
        $model = MM_Conversation_Model::model()->find($id);
        if (is_object($model)) {
            $this->render('backend/view', array(
                'model' => $model
            ));
        } else {
            echo __("Gespräch nicht gefunden!", mmg()->domain);
        }
    }

    function setting()
    {
        wp_enqueue_style('mm_style');
        add_action('mm_setting_general', array(&$this, 'general_view'));
        add_action('mm_setting_email', array(&$this, 'email_view'));
        add_action('mm_setting_shortcode', array(&$this, 'shortcode_view'));
        add_action('mm_setting_attachment', array(&$this, 'attachment_view'));
        $model = new MM_Setting_Model();
        $model->load();

        $this->render('backend/setting', array(
            'model' => $model
        ));
    }

    function shortcode_view()
    {
        $this->render('backend/setting/shortcode');
    }

    function general_view($model)
    {
        $this->render('backend/setting/general', array(
            'model' => $model
        ));
    }

    function email_view($model)
    {
        $this->render('backend/setting/email', array(
            'model' => $model
        ));
    }

    function attachment_view($model)
    {
        if (!is_array($model->allow_attachment)) {
            $model->allow_attachment = array();
        }
        $this->render('backend/setting/attachment', array(
            'model' => $model
        ));
    }
}