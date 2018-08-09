<template>
    <div class="alert alert-flash alert-success" role="alert" v-if="show">
        {{ msg }}
    </div>
</template>

<script>
import { eventBus } from '../app';

export default {
    data() {
        return {
            msg: '',
            show: false
        }
    },
    mounted() {
        eventBus.$on('flash', msg => {
            this.showMsg(msg);
        })
    },
    methods: {
        showMsg(msg) {
            this.msg = msg;
            this.show = true;

            setTimeout(_ => {
                this.msg = '';
                this.show = false;
            }, 3000);
        }
    }
}
</script>
