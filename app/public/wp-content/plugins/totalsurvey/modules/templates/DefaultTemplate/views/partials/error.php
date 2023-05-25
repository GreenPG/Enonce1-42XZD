<?php ! defined( 'ABSPATH' ) && exit(); ?><error-message inline-template>
    <div class="survey-error" v-show="error">
        <span v-text="error"></span>
        <span class="survey-error-button" @click.prevent="dismiss()"></span>
    </div>
</error-message>
