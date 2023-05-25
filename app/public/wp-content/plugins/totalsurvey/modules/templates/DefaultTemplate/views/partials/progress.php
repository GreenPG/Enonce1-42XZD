<?php ! defined( 'ABSPATH' ) && exit(); ?><progress-status inline-template>
    <div class="survey-progress">
        <span class="survey-progress-done" :class="{'-done': isCompleted}"></span>
        <span class="survey-progress-bar" :style="{width: progressPercentage}"></span>
    </div>
</progress-status>
