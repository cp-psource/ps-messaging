<?php
$message = array_shift($messages);
if (!isset($render_reply)) {
    $render_reply = true;
}
$conversation = MM_Conversation_Model::model()->find($message->conversation_id);
?>
<div class="ig-container">
    <section class="message-content">
        <div class="message-content-meta pull-left">
            <?php do_action('message_content_meta', $message) ?>
            <?php if ($conversation->is_lock()): ?>
                <div class="clearfix"></div>
                <span><?php _e("Dieses Gespräch wurde gesperrt", mmg()->domain) ?></span>
            <?php endif; ?>
        </div>
        <div class="message-content-actions pull-right">
            <?php if (mmg()->get('box') != 'sent' && $render_reply == true): ?>
                <?php
                $from_data = get_userdata($message->send_from);
                ?>
                <div class="btn-group btn-group-sm">
                    <?php if ($conversation->is_archive()): ?>
                        <a href="#" title="<?php echo esc_attr(__("Unarchiv", mmg()->domain)) ?>"
                           data-id="<?php echo esc_attr(mmg()->encrypt($message->conversation_id)) ?>"
                           data-type="<?php echo MM_Message_Status_Model::STATUS_READ ?>"
                           class="btn btn-sm btn-default mm-status"><i class="fa fa-undo"></i></a>
                        <a href="#" title="<?php echo esc_attr(__("Löschen", mmg()->domain)) ?>"
                           data-id="<?php echo esc_attr(mmg()->encrypt($message->conversation_id)) ?>"
                           data-type="<?php echo MM_Message_Status_Model::STATUS_DELETE ?>"
                           class="btn btn-sm btn-danger mm-status"><i class="fa fa-trash"></i></a>
                    <?php else: ?>
                        <?php if ($conversation->is_lock()): ?>
                            <button type="button" class="btn btn-info btn-sm" disabled>
                                <i class="fa fa-reply"></i>
                            </button>
                        <?php else: ?>
                            <a href="#reply-form-c"
                               data-username="<?php echo esc_attr($from_data->user_login) ?>"
                               data-parentid="<?php echo esc_attr(mmg()->encrypt($message->conversation_id)) ?>"
                               data-id="<?php echo esc_attr(mmg()->encrypt($message->id)) ?>" type="button"
                               class="btn btn-info btn-sm mm-reply">
                                <i class="fa fa-reply"></i>
                            </a>
                        <?php endif; ?>
                        <a href="#" title="<?php echo esc_attr(__("Archiv", mmg()->domain)) ?>"
                           data-id="<?php echo esc_attr(mmg()->encrypt($message->conversation_id)) ?>"
                           data-type="<?php echo MM_Message_Status_Model::STATUS_ARCHIVE ?>"
                           class="btn btn-sm btn-default mm-status"><i class="fa fa-archive"></i></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <!--<button type="button" class="btn btn-danger btn-sm">
                <i class="glyphicon glyphicon-trash"></i>
            </button>-->
        </div>
        <?php /*$this->render_partial('shortcode/_reply_form', array(
            'message' => $message
        )); */ ?>
        <div class="clearfix"></div>
        <div class="page-header">
            <h3 class="mm-message-subject"><?php echo apply_filters('mm_message_subject', $message->subject) ?></h3>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <img style="width: 100%;max-width: 100px" class="img-responsive img-circle center-block"
                                 src="<?php echo mmg()->get_avatar_url(get_avatar($message->send_from)) ?>">
                        </div>
                        <div class="col-md-9">
                            <strong><?php
                                if ($message->send_from == get_current_user_id()) {
                                    echo __("Ich", mmg()->domain) . ' (' . $message->get_name($message->send_from) . ')';
                                } else {
                                    echo $message->get_name($message->send_from);
                                } ?></strong>

                            <div class="clearfix"></div>
                            <span><?php echo date('F j, Y, g:i a', strtotime($message->date)) ?></span>

                            <div class="clearfix"></div>
                            <?php if (mmg()->get('box') == 'sent'): ?>
                                <small><?php _e("An:", mmg()->domain) ?> <?php echo $message->get_name($message->send_to); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="message-body">
            <?php echo mmg()->html_beautifier(apply_filters('mm_message_content', $message->content)) ?>
        </div>
        <?php $ids = explode(',', $message->attachment);
        $ids = array_filter($ids);
        if (count($ids)):?>
            <hr/>
            <div class="message-footer">
                <div class="row">
                    <?php foreach ($ids as $id): ?>
                        <?php $a_m = IG_Uploader_Model::model()->find($id); ?>
                        <div class="col-md-6 message-attachment">
                            <a class="load-attachment-info" data-target="<?php echo $id ?>" href="#">
                                <i class="fa fa-paperclip fa-2x pull-left"></i>
                                <?php echo $a_m->name ?> </a>

                            <div class="clearfix"></div>
                            <!-- Modal -->
                            <div class="modal" data-id="<?php echo $id ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo $a_m->name ?></h4>
                                        </div>
                                        <div class="modal-body sample-pop" style="max-height:450px;overflow-y:scroll">
                                            <?php
                                            $file = $a_m->file;
                                            //check does this file exist

                                            $file_url = '';
                                            $show_image = false;

                                            if ($file) {
                                                $file_url = wp_get_attachment_url($file);
                                                $mime = explode('/', get_post_mime_type($file));
                                                if (array_shift($mime) == 'image') {
                                                    $show_image = true;
                                                }
                                            }
                                            if ($show_image) {
                                                echo '<img src="' . $file_url . '"/>';
                                            } elseif ($file) {
                                                //show meta
                                                ?>
                                                <ul class="list-group">
                                                    <li class="list-group-item upload-item">
                                                        <i class="glyphicon glyphicon-floppy-disk"></i>
                                                        <?php _e('Größe', mmg()->domain) ?>:
                                                        <strong><?php
                                                            $tfile = get_attached_file($file);
                                                            //check does this files has deleted
                                                            if ($tfile) {
                                                                $size = @filesize($tfile);
                                                                echo $size === false ? 'N/A' : $size;
                                                            } else {
                                                                echo __("N/A", mmg()->domain);
                                                            }
                                                            ?></strong>
                                                    </li>
                                                    <li class="list-group-item upload-item">
                                                        <i class="glyphicon glyphicon-file"></i>
                                                        <?php _e('Typ', mmg()->domain) ?>:
                                                        <strong><?php echo ucwords(get_post_mime_type($file)) ?></strong>
                                                    </li>
                                                </ul>
                                            <?php
                                            } else {
                                                ?>
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <i class="glyphicon glyphicon-link"></i>
                                                        <strong><?php _e('Link', mmg()->domain) ?></strong>:
                                                        <?php echo $a_m->url ?>
                                                    </li>
                                                    <div class="clearfix"></div>
                                                </ul>
                                            <?php
                                            } ?>
                                        </div>
                                        <div class="modal-footer">
                                            <?php if ($a_m->url): ?>
                                                <a class="btn btn-info" rel="nofollow"
                                                   href="<?php echo esc_attr($a_m->url) ?>" target="_blank">
                                                    <?php _e("Besuche den Link", mmg()->domain) ?>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($a_m->file): ?>
                                                <a href="<?php echo $file_url ?>" download
                                                   class="btn btn-info"><?php _e('Download-Datei', mmg()->domain) ?></a>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-default attachment-close"
                                                    data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <!--render history-->
    <?php if (is_array($messages) && count($messages)): ?>
        <div class="well well-sm no-margin">
            <?php foreach ($messages as $key => $message): ?>
                <section class="message-content">

                    <div class="page-header">
                        <h3 class="mm-message-subject"><?php echo apply_filters('mm_message_subject', $message->subject) ?></h3>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img style="max-width:100px;width: 100%"
                                             class="img-responsive img-circle center-block"
                                             src="<?php echo mmg()->get_avatar_url(get_avatar($message->send_from)) ?>">
                                    </div>
                                    <div class="col-md-9">
                                        <strong><?php echo $message->get_name($message->send_from) ?></strong>

                                        <div class="clearfix"></div>
                                        <span><?php echo date('F j, Y, g:i a', strtotime($message->date)) ?></span>

                                        <div class="clearfix"></div>
                                        <?php if (mmg()->get('box') == 'sent'): ?>
                                            <small><?php _e("An:", mmg()->domain) ?> <?php echo $message->get_name($message->send_to) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="message-body">
                        <?php echo mmg()->html_beautifier(apply_filters('mm_message_content', $message->content)) ?>
                    </div>
                    <?php $ids = explode(',', $message->attachment);
                    $ids = array_filter($ids);
                    if (count($ids)):?>
                        <hr/>
                        <div class="message-footer">
                            <div class="row">
                                <?php foreach ($ids as $id): ?>
                                    <?php $a_m = IG_Uploader_Model::model()->find($id); ?>
                                    <div class="col-md-6 message-attachment">
                                        <a class="load-attachment-info" data-target="<?php echo $id ?>" href="#">
                                            <i class="fa fa-paperclip fa-2x pull-left"></i>
                                            <?php echo $a_m->name ?> </a>

                                        <div class="clearfix"></div>
                                        <!-- Modal -->
                                        <div class="modal" data-id="<?php echo $id ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $a_m->name ?></h4>
                                                    </div>
                                                    <div class="modal-body sample-pop"
                                                         style="max-height:450px;overflow-y:scroll">
                                                        <?php
                                                        $file = $a_m->file;
                                                        //check does this file exist

                                                        $file_url = '';
                                                        $show_image = false;

                                                        if ($file) {
                                                            $file_url = wp_get_attachment_url($file);
                                                            $mime = explode('/', get_post_mime_type($file));
                                                            if (array_shift($mime) == 'image') {
                                                                $show_image = true;
                                                            }
                                                        }
                                                        if ($show_image) {
                                                            echo '<img src="' . $file_url . '"/>';
                                                        } elseif ($file) {
                                                            //show meta
                                                            ?>
                                                            <ul class="list-group">
                                                                <li class="list-group-item upload-item">
                                                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                                                    <?php _e('Größe', mmg()->domain) ?>:
                                                                    <strong><?php
                                                                        $tfile = get_attached_file($file);
                                                                        //check does this files has deleted
                                                                        if ($tfile) {
                                                                            $size = @filesize($tfile);
                                                                            echo $size === false ? 'N/A' : $size;
                                                                        } else {
                                                                            echo __("N/A", mmg()->domain);
                                                                        }
                                                                        ?></strong>
                                                                </li>
                                                                <li class="list-group-item upload-item">
                                                                    <i class="glyphicon glyphicon-file"></i>
                                                                    <?php _e('Typ', mmg()->domain) ?>:
                                                                    <strong><?php echo ucwords(get_post_mime_type($file)) ?></strong>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        } else {
                                                            ?>
                                                            <ul class="list-group">
                                                                <li class="list-group-item">
                                                                    <i class="glyphicon glyphicon-link"></i>
                                                                    <strong><?php _e('Link', mmg()->domain) ?></strong>:
                                                                    <?php echo $a_m->url ?>
                                                                </li>
                                                                <div class="clearfix"></div>
                                                            </ul>
                                                        <?php
                                                        } ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <?php if ($a_m->url): ?>
                                                            <a class="btn btn-info" rel="nofollow"
                                                               href="<?php echo esc_attr($a_m->url) ?>" target="_blank">
                                                                <?php _e("Besuche den Link", mmg()->domain) ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if ($a_m->file): ?>
                                                            <a href="<?php echo $file_url ?>" download
                                                               class="btn btn-info"><?php _e('Download-Datei', mmg()->domain) ?></a>
                                                        <?php endif; ?>
                                                        <button type="button" class="btn btn-default attachment-close"
                                                                data-dismiss="modal">Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.mm-reply').leanModal({
            closeButton: ".compose-close",
            top: '5%',
            width: '90%',
            maxWidth: 659
        });
        /*$('.load-attachment-info').leanModal({
         closeButton: '.attachment-close',
         top: '5%',
         width: '90%',
         maxWidth: 659
         });*/
    })
</script>
