<template>
    <form v-on:submit.prevent="submit" class="row d-flex justify-content-center m-0 p-2 w-100" id="step0">

        <img src="images/blue-block.png" class="d-none d-md-block img-fluid" alt=""/>
        <img src="images/blue-block-m.png" class="d-block d-md-none img-fluid" alt=""/>

        <h5 class="mb-5 mt-5 col-md-8">Уважаемый клиент, для более детального расчёта и дальнейшей более качественной
            коммуникации введите Ваши
            контактные данные.</h5>

        <h6 class="mb-5 col-md-8"><strong>Заполните контактные данные и получите 10 литров «ЭКО-СП» в
            подарок!</strong><br>
            (при покупке от 100 литров)</h6>

        <div class="col-md-8 col-sm-12 mb-2 d-flex justify-content-center" v-if="is_show">
            <div class="custom-control custom-switch" >
                <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="form.required">
                <label class="custom-control-label" for="customSwitch1" v-if="form.required">Не проходить
                    авторизацию</label>
                <label class="custom-control-label" for="customSwitch1" v-else>Пройти авторизацию</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-12" v-if="form.required">
            <div class="form-group">
                <input name="company"
                       v-model="form.company"
                       type="text"

                       class="form-control form-control-lg"
                       placeholder="Название компании" required>
            </div>

            <div class="form-group">
                <input name="region"
                       v-model="form.region"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="Регион" required>
            </div>

            <div class="form-group">
                <input name="name"
                       v-model="form.name"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="ФИО" required>
            </div>

            <div class="form-group">
                <input name="phone"
                       v-model="form.phone"
                       maxlength="19"
                       type="text"
                       class="form-control form-control-lg"
                       placeholder="Номер телефона" required>
            </div>


            <div class="form-group">
                <input name="email"
                       v-model="form.email"
                       type="email"
                       class="form-control form-control-lg"
                       placeholder="Email" required>
            </div>

            <div class="form-group">
                <label class="pull-left" for="invite">Код приглашения <span style="color:#f00;">(если отсутствует - пропустить)</span>:</label>
                <input name="invite"
                       v-model="form.invite"
                       type="text"
                       pattern="[AM].[0-9]{1,2}"
                       maxlength="19"
                       v-mask="['A ##']"
                       class="form-control form-control-lg"
                       id="invite" placeholder="">
            </div>
        </div>

        <button type="submit" class="btn btn-primary primary-custom" v-if="is_show">ШАГ 1: Расчет необходимого объема
            препарата
            «ЭКО-СП»
        </button>
    </form>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                is_show: true,
                form: {
                    required: true,
                    company: '',
                    region: '',
                    name: '',
                    phone: '',
                    email: '',
                    invite: '',
                }
            }
        },
        computed: {
            zero: function () {
                return this.$store.getters.Zero
            },
        },
        mounted() {
            if (this.zero)
                this.form = this.zero
            else
                this.form = {
                    required: true,
                    company: '',
                    region: '',
                    name: '',
                    phone: '',
                    email: '',
                    invite: '',
                }

        },
        methods: {
            submit() {
                this.$store.dispatch('setStepZero', this.form)
                this.is_show = false;
                this.$emit("next-step")

            }
        },
        directives: {mask}
    }
</script>

