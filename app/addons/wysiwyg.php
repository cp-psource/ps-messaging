<?php

/**
 * Autor: PSOURCE
 * Name: WYISWYG
 * Beschreibung: Fügt dem Nachrichtenkomponisten einen WYSIWYG-Editor hinzu.
 */
if (!class_exists('MM_WYSIWYG')) {
    class MM_WYSIWYG extends IG_Request
    {
        public function __construct()
        {
            add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
            add_action('admin_enqueue_scripts', array(&$this, 'scripts'));
            add_action('wp_footer', array(&$this, 'footer_scripts'));
            add_action('admin_footer', array(&$this, 'footer_scripts'));
        }

        function text()
        {
            $string = array(
                'Bold' => __("Fett", mmg()->domain),
                'Italic' => __("Kursiv", mmg()->domain),
                'Underline' => __("Unterstreichen", mmg()->domain),
                'Strikethrough' => __("Durchgestrichen", mmg()->domain),
                'Subscript' => __("Subscript", mmg()->domain),
                'Superscript' => __("Hochgestellt", mmg()->domain),
                'Align left' => __("Linksbündig", mmg()->domain),
                'Center' => __("Zentriert", mmg()->domain),
                'Align right' => __("Rechtsbündig", mmg()->domain),
                'Justify' => __("Justify", mmg()->domain),
                'Font Name' => __("Schriftart", mmg()->domain),
                'Font Size' => __("Schriftgröße", mmg()->domain),
                'Font Color' => __("Schriftfarbe", mmg()->domain),
                'Remove Formatting' => __("Formatierung entfernen", mmg()->domain),
                'Cut' => __("Ausschneiden", mmg()->domain),
                'Your browser does not allow the cut command. Please use the keyboard shortcut Ctrl/Cmd-X' => __("Dein Browser lässt den Befehl Ausschneiden nicht zu. Bitte benutze die Tastenkombination Strg / Cmd-X", mmg()->domain),
                'Copy' => __("Copy", mmg()->domain),
                'Your browser does not allow the copy command. Please use the keyboard shortcut Ctrl/Cmd-C' => __("Dein Browser lässt den Kopierbefehl nicht zu. Bitte verwenden Sie die Tastenkombination Strg / Cmd-C", mmg()->domain),
                'Paste' => __("Paste", mmg()->domain),
                'Your browser does not allow the paste command. Please use the keyboard shortcut Ctrl/Cmd-V' => __("Dein Browser lässt den Einfügebefehl nicht zu. Bitte benutze die Tastenkombination Strg / Cmd-V", mmg()->domain),
                'Paste your text inside the following box' => __("Füge Deinen Text in das folgende Feld ein", mmg()->domain),
                'Paste Text' => __("Text einfügen", mmg()->domain),
                'Bullet list' => __("Aufzählung", mmg()->domain),
                'Numbered list' => __("Nummerierte Liste", mmg()->domain),
                'Undo' => __("Rückgängig machen", mmg()->domain),
                'Redo' => __("Wiederholen", mmg()->domain),
                'Rows' => __("Reihen", mmg()->domain),
                'Cols' => __("Colspan", mmg()->domain),
                'Insert a table' => __("Füge eine Tabelle ein", mmg()->domain),
                'Insert a horizontal rule' => __("Füge eine horizontale Reihe ein", mmg()->domain),
                'Code' => __("Code", mmg()->domain),
                'Width (optional)' => __("Breite (optional)", mmg()->domain),
                'Height (optional)' => __("Höhe (optional)", mmg()->domain),
                'Insert an image' => __("BIld einfügen", mmg()->domain),
                'E-mail' => __("E-Mail", mmg()->domain),
                'Insert an email' => __("Füge eine E-Mail ein", mmg()->domain),
                'URL' => __("URL", mmg()->domain),
                'Insert a link' => __("Füge einen Link ein", mmg()->domain),
                'Unlink' => __("Verknüpfung aufheben", mmg()->domain),
                'More' => __("Mehr", mmg()->domain),
                'Insert an emoticon' => __("Füge ein Emoticon ein", mmg()->domain),
                'Video URL' => __("Video URL", mmg()->domain),
                'Insert' => __("Einfügen", mmg()->domain),
                'Insert a YouTube video' => __("Füge ein YouTube-Video ein", mmg()->domain),
                'Insert current date' => __("Aktuelles Datum einfügen", mmg()->domain),
                'Insert current time' => __("Aktuelle Zeit einfügen", mmg()->domain),
                'Print' => __("Drucken", mmg()->domain),
                'View source' => __("Quelltext anzeigen", mmg()->domain),
                'Beschreibung (optional)' => __("Beschreibung (optional)", mmg()->domain),
                'Enter the image URL' => __("Gib die Bild-URL ein", mmg()->domain),
                'Enter the e-mail address' => __("Gib die E-Mail-Adresse ein", mmg()->domain),
                'Enter the displayed text' => __("Gib den angezeigten Text ein", mmg()->domain),
                'Enter URL' => __("URL eingeben", mmg()->domain),
                'Enter the YouTube video URL or ID' => __("Gib die YouTube-Video-URL oder -ID ein", mmg()->domain),
                'Insert a Quote' => __("Füge ein Angebot ein", mmg()->domain),
                'Invalid YouTube video' => __("Ungültiges YouTube-Video", mmg()->domain),
                'dateFormat' => __("Datumsformat", mmg()->domain),
            );

            return $string;
        }

        function footer_scripts()
        {
            $locale = str_replace('_', '-', get_locale());
            if (!class_exists('Mobile_Detect')) {
                include_once dirname(__FILE__) . '/wysiwyg/Mobile_Detect.php';
            }
            $detect = new Mobile_Detect();
            //because the viewport of mobile, so we minimize the toolbars on mobile
            if ($detect->isMobile()) {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        function load_editor() {
                            if ($('.mm_wsysiwyg').size() > 0) {
                                $('.mm_wsysiwyg').sceditor({
                                    plugins: "bbcode",
                                    autoUpdate: true,
                                    autoExpand: true,
                                    width: '98%',
                                    height: '80%',
                                    resizeMinWidth: '50%',
                                    resizeMaxWidth: '100%',
                                    resizeMaxHeight: '100%',
                                    resizeMinHeight: '50%',
                                    emoticonsEnabled: true,
                                    toolbar: "bold,italic,underline,strike|left,center,right,justify",
                                    emoticonsRoot: '<?php echo mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/'?>',
                                    style: '<?php echo mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/minified/jquery.sceditor.default.min.css'?>',
                                    locale: '<?php echo $locale ?>'
                                });
                            }
                        }

                        load_editor();
                        $('body').on('abc', function () {
                            load_editor();
                        });
                    })
                </script>
            <?php
            } else {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        function load_editor() {
                            if ($('.mm_wsysiwyg').size() > 0) {
                                var editors = $('.mm_wsysiwyg').sceditor({
                                    plugins: "xhtml",
                                    autoUpdate: true,
                                    width: '98%',
                                    resizeMinWidth: '-1',
                                    resizeMaxWidth: '100%',
                                    resizeMaxHeight: '100%',
                                    resizeMinHeight: '-1',
                                    readOnly: false,
                                    emoticonsEnabled: true,
                                    toolbar: "bold,italic,underline,strike|left,center,right,justify|font,size,color,removeformat|cut,copy,paste,pastetext|bulletlist,orderedlist,indent,outdent|link,unlink|date,time|emoticon",
                                    emoticonsRoot: '<?php echo mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/'?>',
                                    style: '<?php echo mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/minified/jquery.sceditor.default.min.css'?>',
                                    locale: '<?php echo $locale ?>'
                                });
                            }
                        }

                        load_editor();

                        $('body').on('abc', function () {
                            load_editor();
                        });
                    })
                </script>
            <?php
            }
        }

        function scripts()
        {
            wp_register_script('mm_sceditor', mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/minified/jquery.sceditor.min.js', array('jquery'));
            //load language
            $string = $this->text();
            $string = json_encode($string);
            //generate locale js for sceditor
            $translate = json_encode($string);
            $locale = explode('_', get_locale());
            //generate js file
            $template = '(function ($) {
	\'use strict\';

	$.sceditor.locale["' . strtolower($locale[0]) . '"] ={{json}};
})(jQuery);';
            $template = str_replace('{{json}}',$string,$template);

            if (mmg()->can_compress()) {
                $runtime_path = mmg()->plugin_path . 'framework/runtime';
                //write it
                $file_path = $runtime_path . '/sceditor-translate.js';
                file_put_contents($file_path, $template);
                //convert to url
                $url = mmg()->plugin_url . 'framework/runtime/sceditor-translate.js';
                wp_register_script('mm_sceditor_translate', $url);
            }

            wp_register_script('mm_sceditor_xhtml', mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/minified/plugins/bbcode.js', array('jquery', 'mm_sceditor'));
            //cause the adminbar needed from anywhere,so we bind it
            wp_enqueue_style('mm_sceditor', mmg()->plugin_url . 'app/addons/wysiwyg/sceditor/minified/themes/default.min.css');
        }
    }
}
new MM_WYSIWYG();