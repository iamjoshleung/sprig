<template>
    <form class="form mt-5" data-parsley-validate>
        <div class="alert" v-if="msg.text" :class="classMessage">{{ msg.text }}</div>
        <div class="form-group">
            <label class="form-label" for="name">名字</label>
            <input type="text" class="form-control" id="name" name="name" v-model="data.name" required maxlength="255">
        </div>
        <div class="form-group">
            <label class="form-label" for="email">電郵地址</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" v-model="data.email" required maxlength="255">
            <small id="emailHelp" class="form-text text-muted">留下你的電郵地址方便我們進一步跟你聯系。</small>
        </div>
        <div class="form-group">
            <label class="form-label" for="comment">留言</label>
            <textarea class="form-control" id="comment" name="comment" rows="3" aria-describedby="commentHelp" v-model="data.comments" required maxlength="1000"></textarea>
            <small id="commentHelp" class="form-text text-muted">請盡量對問題或建議進行詳細的描述。</small>
        </div>
        <div class="form-group">
            <button type="submit" class="button button-primary" :disabled="isSubmitting">提交</button>
        </div>
    </form>
</template>

<script>
import 'parsleyjs';
import 'parsleyjs/dist/i18n/zh_tw';

export default {
    data() {
        return {
            data: {
                name: '',
                email: '',
                comments: '',
            },
            msg: {
                status: '',
                text: ''
            },
            isSubmitting: false,
        }
    },
    computed: {
        classMessage() {
            return {
                'alert-success': this.msg.status === 'success',
                'alert-danger': this.msg.status === 'error'
            }
        }
    },
    methods: {
        submitForm(url) {
            this.isSubmitting = true;
            axios.post(url, this.data)
                .then(res => {
                    this.msg.status = 'success';
                    this.msg.text = '我們已經收到你的反饋，并在積極處理中！';
                    this.resetForm();
                })
                .catch(err => {
                    this.msg.status = 'error';
                    this.msg.text = '伺服器錯誤';
                    console.log(err)
                })
                .finally(_ => {
                    this.isSubmitting = false;
                });
        },
        resetForm() {
            Object.keys(this.data).forEach((key, index) => {
                this.data[key] = '';
            });
        }
    },
    mounted() {
        window.Parsley.on('form:submit', () => {
            // This global callback will be called for any field that fails validation.
            this.submitForm('/feedback');
            return false;
        });
    }
};
</script>

<style lang="scss" scoped>
</style>
