<?php ! defined( 'ABSPATH' ) && exit(); ?><article id="totalsurvey-entry" class="totalsurvey-entry">
    <?php
    use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;

    foreach ($entry->data->sections as $sectionIndex => $section) : ?>
        <section class="section">
            <h5 class="title"><?php echo esc_html($section->title); ?></h5>
            <?php foreach ($section->blocks as $block) : ?>
                <dl class="blocks">
                    <dt class="title"><?php echo nl2br(esc_html($block->title)); ?></dt>
                    <dd class="text"><?php echo nl2br(esc_html($block->text)); ?></dd>
                </dl>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>
    <footer class="footer">
        <?php if (isset($entry->data->scoring)) : ?>
            <div class="scoring">
                <div class="item grade"><strong><?php esc_html_e('Grade:', 'totalsurvey'); ?></strong> <?php echo esc_html($entry->data->scoring['grade']['label']); ?></div>
                <div class="item score"><strong><?php esc_html_e('Score:', 'totalsurvey'); ?></strong> <?php echo esc_html(Strings::template(__('{{score}} out of {{total}}', 'totalsurvey'), ['score' =>  $entry->data->scoring['score'], 'total' =>  $entry->data->scoring['total']])) ?></div>
                <div class="item result"><strong><?php esc_html_e('Result:', 'totalsurvey'); ?></strong> <?php echo esc_html($entry->data->scoring['percentage']); ?>%</div>
            </div>
        <?php endif ?>
        <time class="date">
            <?php
            echo esc_html(
                Strings::template(
                    esc_html__('Received on {{date}} at {{time}}', 'totalsurvey'),
                    [
                        'date' => mysql2date(get_option('date_format'), $entry->created_at),
                        'time' => mysql2date(get_option('time_format'), $entry->created_at)
                    ]
                )
            );
            ?>
        </time>
        <div class="share">
            <a class="button facebook" href="<?php echo esc_attr(add_query_arg(['u' => $entry->getUrl()], 'https://www.facebook.com/sharer.php')); ?>" target="blank" rel="noopener nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/></svg>
                Facebook
            </a>
            <a class="button twitter" href="<?php echo esc_attr(add_query_arg(['url' => $entry->getUrl()], 'https://twitter.com/intent/tweet')); ?>" target="blank" rel="noopener nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                Twitter
            </a>
            <a class="button whatsapp" href="<?php echo esc_attr(add_query_arg(['text' => $entry->getUrl()], 'whatsapp://send')); ?>" target="blank" rel="noopener nofollow">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24" y="0"/></g><g><g><g><path d="M19.05,4.91C17.18,3.03,14.69,2,12.04,2c-5.46,0-9.91,4.45-9.91,9.91c0,1.75,0.46,3.45,1.32,4.95L2.05,22l5.25-1.38 c1.45,0.79,3.08,1.21,4.74,1.21h0c0,0,0,0,0,0c5.46,0,9.91-4.45,9.91-9.91C21.95,9.27,20.92,6.78,19.05,4.91z M12.04,20.15 L12.04,20.15c-1.48,0-2.93-0.4-4.2-1.15l-0.3-0.18l-3.12,0.82l0.83-3.04l-0.2-0.31c-0.82-1.31-1.26-2.83-1.26-4.38 c0-4.54,3.7-8.24,8.24-8.24c2.2,0,4.27,0.86,5.82,2.42c1.56,1.56,2.41,3.63,2.41,5.83C20.28,16.46,16.58,20.15,12.04,20.15z M16.56,13.99c-0.25-0.12-1.47-0.72-1.69-0.81c-0.23-0.08-0.39-0.12-0.56,0.12c-0.17,0.25-0.64,0.81-0.78,0.97 c-0.14,0.17-0.29,0.19-0.54,0.06c-0.25-0.12-1.05-0.39-1.99-1.23c-0.74-0.66-1.23-1.47-1.38-1.72c-0.14-0.25-0.02-0.38,0.11-0.51 c0.11-0.11,0.25-0.29,0.37-0.43c0.12-0.14,0.17-0.25,0.25-0.41c0.08-0.17,0.04-0.31-0.02-0.43c-0.06-0.12-0.56-1.34-0.76-1.84 c-0.2-0.48-0.41-0.42-0.56-0.43C8.86,7.33,8.7,7.33,8.53,7.33c-0.17,0-0.43,0.06-0.66,0.31C7.65,7.89,7.01,8.49,7.01,9.71 c0,1.22,0.89,2.4,1.01,2.56c0.12,0.17,1.75,2.67,4.23,3.74c0.59,0.26,1.05,0.41,1.41,0.52c0.59,0.19,1.13,0.16,1.56,0.1 c0.48-0.07,1.47-0.6,1.67-1.18c0.21-0.58,0.21-1.07,0.14-1.18S16.81,14.11,16.56,13.99z"/></g></g></g></svg>
                WhatsApp
            </a>
            <button class="button print">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/></svg> <?php esc_html_e('Print', 'totalsurvey'); ?>
            </button>
        </div>
    </footer>
</article>
