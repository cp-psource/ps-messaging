<div class="page-header">
    <h3><?php _e('Shortcodes') ?></h3>
</div>
<div class="row">
    <div class="col-md-6 col-xs-6 col-sm-6 text-center">
        <p><strong><?php _e("Inbox Page", mmg()->domain) ?></strong></p>

        <div class="clearfix"></div>

        <div class="text-left">
            <p><code>[message_inbox]</code></p>
            <ul>
                <li>
                    <?php _e("Dieser Shortcode zeigt die Schnittstelle für private Nachrichten an. Für diesen Shortcode gibt es keine Parameter.", mmg()->domain) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 col-xs-6 col-sm-6 text-center">
        <p><strong><?php _e("PM User", mmg()->domain) ?></strong></p>

        <div class="clearfix"></div>

        <div class="text-left">
            <p><code>[pm_user]</code></p>
            <ul>
                <li>
                    <mark><?php _e("user_id", mmg()->domain) ?></mark>
                    : <?php _e("Die ID des Benutzers, der der Nachrichtenempfänger ist.", mmg()->domain) ?>
                </li>
                <li>
                    <mark><?php _e("user_name", mmg()->domain) ?></mark>
                    : <?php _e("Der Benutzername des Nachrichtenempfängers. Die Benutzer-ID erhält eine höhere Priorität als der Benutzername.", mmg()->domain) ?>
                </li>
                <li>
                    <mark><?php _e("in_the_loop", mmg()->domain) ?></mark>
                    : <?php _e("Verwende 1 für wahr, 0 für falsch. Dieser Shortcode wird verwendet, wenn keine Benutzer-ID oder kein Benutzername vorhanden ist. Dieser Shortcode zieht die Benutzer-ID des Autors, wenn sich der Shortcode in der Schleife befindet.", mmg()->domain) ?>
                </li>
                <li>
                    <mark><?php _e("text", mmg()->domain) ?></mark>
                    : <?php _e("Der anzuzeigende Schaltflächentext lautet standardmäßig: Nachricht an mich. ", mmg()->domain) ?>
                </li>
                <li>
                    <mark><?php _e("class", mmg()->domain) ?></mark>
                    : <?php _e("Wenn Du die Nachrichtenschaltfläche formatieren möchtest, verwende diesen Shortcodes-Parameter, um die Klasse der Nachrichtenschaltfläche zu definieren. ", mmg()->domain) ?>
                </li>
                <li>
                    <mark><?php _e("subject", mmg()->domain) ?></mark>
                    : <?php _e("Dies definiert den Betreff der gesendeten Nachricht, wenn der Benutzer keinen hinzufügt. ", mmg()->domain) ?>
                </li>
                <li class="text-info">
                    <?php _e("Bitte beachte, dass <strong>user_id</strong> oder <strong>user_name</strong> oder <strong>in_the_loop</strong> definiert werden muss.") ?>
                </li>
            </ul>

        </div>
    </div>
    <div class="clearfix"></div>
</div>