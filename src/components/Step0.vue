<template>
    <form v-on:submit.prevent="submit" class="row d-flex justify-content-center mt-5 p-5">

        <div class="col-md-8 col-sm-12">
            <div class="form-group">
                <input name="company"
                       v-model="form.company"
                       type="text"
                       class="form-control input-lg"
                       placeholder="Название компании" required>
            </div>

            <div class="form-group">
                <input name="region"
                       v-model="form.region"
                       type="text"
                       class="form-control input-lg"
                       placeholder="Регион" required>
            </div>

            <div class="form-group">
                <input name="name"
                       v-model="form.name"
                       type="text"
                       class="form-control input-lg"
                       placeholder="ФИО" required>
            </div>

            <div class="form-group">
                <input name="phone"
                       v-model="form.phone"
                       pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                       maxlength="19"
                       v-mask="['+38 (###) ###-##-##']"
                       type="text"
                       class="form-control input-lg"
                       placeholder="Номер телефона" required>
            </div>


            <div class="form-group">
                <input name="email"
                       v-model="form.email"
                       type="email"
                       class="form-control input-lg"
                       placeholder="Email" required>
            </div>

            <div class="form-group">
                <label class="pull-left" for="invite">Код приглашения <span style="color:#f00;">(если отсутствует - пропустить)</span>:</label>
                <input name="invite"
                       v-model="form.invite"
                       type="text"
                       pattern="[AM0-9]{1,2}"
                       maxlength="19"
                       v-mask="['A ##']"
                       class="form-control input-lg"
                       id="invite" placeholder="">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">ШАГ 1: Расчет необходимого объема препарата «ЭКО-СП»</button>
    </form>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                form: {
                    company: '',
                    region: '',
                    name: '',
                    phone: '',
                    email: '',
                    invite: '',
                }
            }
        },
        methods: {
            submit() {
                this.$store.dispatch('setStepZero', this.form)
                this.$emit("next-step")
            }
        },
        directives: {mask}
    }
</script>