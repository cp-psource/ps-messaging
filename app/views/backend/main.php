<div class="wrap">
    <div class="ig-container">
        <div class="mmessage-container">

            <div class="row">
                <div class="col-md-12">
                    <div class="page-heading">
                        <h2><?php _e("Nachrichten", mmg()->domain) ?></h2>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
                            $table = new MM_Messages_Table();
                            $table->prepare_items();
                            $table->display();
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function ($) {
        $(document).on('click', '.lock-conv', function (e) {
            e.preventDefault();
            var that = $(this);
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'mm_lock_conversation',
                    type: that.data('type'),
                    id: that.data('id')
                },
                beforeSend: function () {
                    that.prop('disabled', true);
                },
                success: function (data) {
                    that.prop('disabled', false);
                    that.data('type', data.type);
                    that.html(data.text);
                }
            });
        });
    });
</script>
