<template>
    <form v-on:submit.prevent="submit" class="flex-wrap d-flex justify-content-center" id="step1">

        <div class="row d-flex justify-content-center w-100">

            <h2 class="col-md-12 col-sm-12">ШАГ 1: Расчет необходимого
                объема препарата «ЭКО-СП»</h2>


            <div class="col-md-6 col-sm-12">
                <div class="form-group need_vegetation">
                    <label class="checkbox-inline">
                        <input type="checkbox" v-model="form.need_seed_preparation" class="mr-2">Не проводить
                        обработку
                        семян
                    </label>
                </div>
            </div>

            <div class="row d-flex justify-content-center part pb-2 mt-2" v-if="!form.need_seed_preparation">
                <h3 class="col-md-12 col-sm-12 upper">Обработка
                    семян</h3>

                <div class="col-md-8 col-lg-8 col-sm-12 mt-2">

                    <div class="input-group mb-3">
                        <input name="seedssquare"
                               v-model="form.crop_area"
                               type="text"
                               maxlength="5"
                               v-mask="['#########']"
                               min="0"
                               pattern="[0-9]{1,9}"
                               class="form-control form-control-lg"
                               placeholder="Площадь посевов" required>
                        <div class="input-group-append">
                            <span class="input-group-text">га</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input name="seedsnorm"
                               v-model="form.prepare.seeding_rate"
                               type="text"
                               maxlength="5"
                               v-mask="['#########']"

                               pattern="[0-9]{1,9}"
                               class="form-control form-control-lg"
                               placeholder="Норма высева семян">
                        <div class="input-group-append">
                            <span class="input-group-text">кг/га</span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-11">
                            <h4>Норма расхода рабочего раствора при обработке семян(л/т):</h4>
                        </div>
                        <div class="col-md-1 d-flex justify-content-center">
                            <a href="#calc-about" class="d-flex justify-content-center align-items-center text-center"
                               v-b-modal.modal-1>
                                <div class="calc-about">?</div>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div
                            class="col-6 col-sm-4 col-md-4 col-lg-2 mb-2 d-flex justify-content-center flex-wrap preparation"
                            v-for="(rate,index) in consumption_rate_of_working_solution_preparation">

                            <div class="input-group  d-flex justify-content-center p-1">
                                <label class="input-group-append" :for="'optradio-c-r-'+index">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"
                                             style="background-color: white;border-radius: 5px 0px 0px 5px;">
                                            <input type="radio"
                                                   name="optradio_c_r"
                                                   v-bind:value="index"
                                                   :checked="form.prepare.consumption_rate_selected===index"
                                                   v-on:change="checkConsumptionRate(index)"
                                                   v-model="form.prepare.consumption_rate_selected"
                                                   :id="'optradio-c-r-'+index">
                                        </div>
                                    </div>

                                    <span class="input-group-text">{{rate}}л</span>
                                </label>
                            </div>


                        </div>

                    </div>

                    <h4>Норма внесения препарата «ЭКО-СП» для вегетационной обработки:</h4>

                    <div class="row flex-nowrap shkala justify-content-between">
                        <div class="col-xs-2" v-for="(rate,index) in application_rate_of_the_drug_preparation">
                            <div class="shkala-circle active"
                                 v-if="form.prepare.application_rate_selected===index"></div>
                            <div class="shkala-circle" v-else></div>
                            <span>{{rate}}л</span>
                        </div>
                    </div>

                    <div class="row w-100 d-flex justify-content-center">
                        <p class="volume">Необходимый объём «ЭКО-СП»:
                            <span>{{form.prepare.required_volume.toFixed(2)}}</span> л
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="row d-flex justify-content-center mt-2 part w-100">
            <h3 class="col-md-12 col-sm-12 upper part">Вегетация</h3>

            <div class="col-md-8 col-sm-10 col-12 mb-3 mt-3">

                <div class="input-group ">
                    <input class="form-control form-control-lg"
                           v-model="form.crop_area"
                           type="text"
                           maxlength="5"
                           v-mask="['#########']"
                           min="0"
                           pattern="[0-9]{1,9}"
                           v-on:keyup="onChangeAllVeg()"
                           placeholder="Площадь посевов" required>
                    <div class="input-group-append">
                        <span class="input-group-text">га</span>
                    </div>
                </div>
            </div>
            <transition-group name="smooth" tag="div">
                <div class="row d-flex justify-content-center flex-wrap mt-2 w-100"
                     v-for="(vegetation,index) in form.vegetation"
                     v-bind:key="index"
                     v-show="form.vegetation">

                    <div class="col-md-12 d-flex justify-content-start w-100 mb-3">
                        <h4 class="label-veg">{{prepareTextNumber(index)}} обработка по вегетации
                        </h4>
                        <a class="btn btn-link" v-if="index!==0" @click="removeVegetation(index)">Убрать</a>
                    </div>

                    <div class="col-md-8 col-sm-10 col-12 ">

                        <p class="alert-danger"
                           v-if="(vegetation.seeding_rate!=null&&vegetation.seeding_rate!=='')&&(vegetation.seeding_rate<90||vegetation.seeding_rate>270)">
                            Введите корректные данные нормы рабочего раствора!</p>

                        <div class="input-group mb-3">
                            <input name="seedsnorm"
                                   type="text"
                                   maxlength="5"
                                   v-mask="['#########']"
                                   min="90"
                                   max="270"
                                   pattern="[0-9]{1,9}"
                                   class="form-control form-control-lg"
                                   placeholder="Норма расхода рабочего раствора (от 90л до 270л)"
                                   v-model="vegetation.seeding_rate"
                                   v-on:keyup="onChangeAllVeg()" required>
                            <div class="input-group-append">
                                <span class="input-group-text">л/га</span>
                            </div>
                        </div>

                    </div>


                    <div class="row w-100">
                        <div class="col-md-12 col-lg-11">
                            <h4>Норма внесения препарата «ЭКО-СП» для обработки по вегетации:</h4>
                        </div>
                        <div class="col-md-12 col-lg-1 d-flex justify-content-center">
                            <a href="#calc-about-2" class="d-flex justify-content-center align-items-center text-center"
                               v-b-modal.modal-2>
                                <div class="calc-about">?</div>
                            </a>
                        </div>
                    </div>


                    <div class="row flex-nowrap shkala-long justify-content-between w-100">
                        <div v-for="(rate,index2) in application_rate_of_the_drug_vegetation">
                            <div class="shkala-circle active" v-if="vegetation.application_rate_selected==index2"></div>
                            <div class="shkala-circle" v-else></div>
                            <span>{{rate}}л</span>
                        </div>
                    </div>


                    <div class="row w-100 justify-content-center d-flex">
                        <p class="text-center">Концентрация гумусовых веществ: <span>{{vegetation.concentration_of_humic_substances.toFixed(4)}}</span>
                            %
                        </p>
                    </div>
                    <div class="row w-100 d-flex justify-content-center">
                        <p class="volume">Необходимый объём «ЭКО-СП»:
                            <span>{{vegetation.required_volume.toFixed(2)}}</span>
                            л
                        </p>
                    </div>

                </div>
            </transition-group>
            <button type="button" class="btn btn-primary primary-custom  mb-2" @click="addVegetation"
                    v-if="this.form.vegetation.length<3">Добавить еще обработку
            </button>
        </div>


        <div class="row d-flex justify-content-center mt-2 part">
            <h3 class="col-md-12 col-sm-12 upper part m-0">Ваш общий необходимый объем<span>{{this.form.summary_required_volume.toFixed(2)}}</span>
                л</h3>
        </div>

        <div class="row d-flex justify-content-center mt-2 w-100 mb-5">
            <div class="col-md-9">
                <button type="submit" class="btn btn-primary primary-custom w-100 p-3" v-if="is_show"
                >ШАГ 2: Расчет стоимости препарата «ЭКО-СП»
                </button>
            </div>
        </div>


        <b-modal id="modal-1" title="Норма расхода рабочего раствора при обработке семян(л/т)">
            <p class="my-4">При выборе нормы расхода рабочего раствора внесение препарата рассчитывается исходя из
                оптимальной концентрации гумусовых веществ в водном растворе(0,03%), при которой наблюдается наиболее
                эффективное воздействие на рост и развитие семени.</p>

            <template #modal-footer="{ cancel }">
                <b-button size="sm" variant="info" @click="cancel()">
                    Спасибо, прочитал!
                </b-button>
            </template>
        </b-modal>


        <b-modal id="modal-2" title="Норма внесения препарата «ЭКО-СП» по вегетации">
            <p class="my-4">При выборе нормы расхода рабочего раствора внесение препарата рассчитывается исходя из
                оптимальной концентрации гумусовых веществ в водном растворе (0,01%) баковой смеси, при которой
                наблюдается наиболее эффективное воздействие на рост и развитие растений.</p>
            <template #modal-footer="{ cancel }">
                <b-button size="sm" variant="info" @click="cancel()">
                    Спасибо, прочитал!
                </b-button>
            </template>
        </b-modal>


    </form>
</template>
<script>
    export default {
        data() {
            return {

                is_show: true,
                rate: [
                    {from: 0, to: 90, val: 0.6},
                    {from: 91, to: 105, val: 0.7},
                    {from: 106, to: 120, val: 0.8},
                    {from: 121, to: 135, val: 0.9},
                    {from: 136, to: 150, val: 1.0},
                    {from: 151, to: 165, val: 1.1},
                    {from: 166, to: 180, val: 1.2},
                    {from: 181, to: 195, val: 1.3},
                    {from: 196, to: 210, val: 1.4},
                    {from: 211, to: 225, val: 1.5},
                    {from: 226, to: 240, val: 1.6},
                    {from: 241, to: 255, val: 1.7},
                    {from: 256, to: 270, val: 1.8},
                ],
                consumption_rate_of_working_solution_preparation: [10, 11, 12, 13, 14, 15],
                application_rate_of_the_drug_preparation: [0.2, 0.22, 0.24, 0.26, 0.28, 0.3],
                application_rate_of_the_drug_vegetation: [0.6, 0.7, 0.8, 0.9, 1.0, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8],

                form: {
                    crop_area: null,
                    need_seed_preparation: false,
                    prepare: {
                        seeding_rate: null,
                        consumption_rate_selected: 2,
                        application_rate_selected: 2,
                        required_volume: 0,
                    },

                    vegetation: [],
                    summary_required_volume: 0,
                }
            }
        },
        mounted() {
            this.addVegetation()

            this.form.prepare.seeding_rate = this.seedingRate
        },
        computed: {
            seedingRate: function () {
                return this.$store.getters.GetSeedingRate
            }
        },
        watch: {

            'form.need_seed_preparation': function () {
                this.calc()
            },
            'form.crop_area': function (newVal) {
                this.calc()
            },
            'form.prepare.seeding_rate': function (newVal) {
                this.calc()
                this.$store.dispatch("setSeedingRate", newVal)

            }
        },
        methods: {
            notify(text) {
                this.$notify({
                    group: 'foo',
                    title: 'ЭКО-СП',
                    type: 'success',
                    text: text
                });
            },
            calc() {

                this.form.summary_required_volume = 0

                if (!this.form.need_seed_preparation) {

                    let s1 = this.form.crop_area * this.form.prepare.seeding_rate / 1000;
                    let s2 = this.application_rate_of_the_drug_preparation[this.form.prepare.application_rate_selected]

                    this.form.prepare.required_volume = s1 * s2

                }


                if (this.form.need_seed_preparation) {
                    this.form.prepare.required_volume = 0;
                    this.form.prepare.seeding_rate = null
                }

                this.form.summary_required_volume = this.form.prepare.required_volume;

                for (let index in this.form.vegetation) {
                    let item = this.form.vegetation[index]

                    this.form.summary_required_volume += item.required_volume
                }


            },
            onChangeAllVeg() {

                for (let vegIndex in this.form.vegetation) {
                    let item = this.form.vegetation[vegIndex];

                    let rateFound = false;
                    for (let index in this.rate) {
                        let sub = this.rate[index]

                        if (sub.from <= item.seeding_rate && item.seeding_rate <= sub.to) {
                            this.form.vegetation[vegIndex].application_rate_selected = parseInt(index)

                            this.form.vegetation[vegIndex].required_volume = this.form.crop_area * this.application_rate_of_the_drug_vegetation[parseInt(index)]

                            let s1 = this.form.vegetation[vegIndex].seeding_rate;

                            this.form.vegetation[vegIndex].concentration_of_humic_substances = s1 > 0 ? this.application_rate_of_the_drug_vegetation[parseInt(index)] * 0.015 / s1 * 100 : 0;


                            rateFound = true;

                            break;
                        }
                    }

                    if (!rateFound)
                        this.form.vegetation[vegIndex].application_rate_selected = this.rate.length - 1

                }
                this.calc()
                this.$store.dispatch('setStepOne', this.form)

            },

            checkConsumptionRate(index) {

                this.form.prepare.application_rate_selected = index
                this.calc()


            },

            submit() {
                this.$store.dispatch('setStepOne', this.form)
                this.is_show = false;
                this.$emit("next-step")
            },
            prepareTextNumber(number) {
                let arr = ["Первая", "Вторая", "Третья"];
                return arr[number > 0 && number < arr.length ? number : 0]
            },
            removeVegetation(index) {
                if (index === 0)
                    return;

                this.form.vegetation.splice(index, 1)
                this.notify(this.prepareTextNumber(index) + " обработка по вегетации удалена!")
                this.calc()
            },
            addVegetation() {
                if (this.form.vegetation.length <= 2) {

                    this.form.vegetation.push({
                        seeding_rate: null,
                        application_rate_selected: 0,
                        concentration_of_humic_substances: 0.01,
                        required_volume: 0,
                    })
                    this.notify("Добавлена "+(this.prepareTextNumber(this.form.vegetation.length-1).toLowerCase())+" обработка по вегетации!")
                    this.calc()
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .fade-enter-active, .fade-leave-active {
        animation: bounce-in .5s;
    }

    .fade-enter, .fade-leave-active {
        animation: bounce-out .5s;
    }

    .smooth-enter-active, .smooth-leave-active {
        transition: opacity 1.5s;

    }

    .smooth-enter, .smooth-leave-to {
        opacity: 0;
    }

    @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }

    @keyframes bounce-out {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(0);
        }
    }

    .need_vegetation {
        border: 1px lightgray solid;
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 18px;

        & > label {
            margin-bottom: 0;
        }
    }

    h3 {

        text-transform: uppercase;
        background: #606060;
        color: #fff;
        padding: 20px 0px;
        font-size: 20px;
        font-weight: 600;
    }


    .shkala-long,
    .shkala {
        max-width: 358px;
        font-size: 12px;
        background: url('/images/shkala.png') no-repeat center 1px;
        background-size: contain;
        width: 100%;
        margin: 20px auto;

        .shkala-circle {
            background: #fff;
            border: 4px solid #e9e9e9;
            border-radius: 90px;
            width: 16px;
            height: 16px;

            &.active {
                background: red;
            }

            & + span {
                @media (max-width: 360px) {
                    display: inline-block;
                    transform: rotate(37deg) translate(10px, 10px);
                }
            }
        }
    }

    .shkala-long {
        max-width: 550px;
        @media (max-width: 769px) {
            max-width: 358px;
        }

        @media (max-width: 360px) {
            max-width: 300px;
        }
    }

    .volume {
        padding: 20px;
        background: #eee;
        border: 1px solid #ddd;
        text-transform: uppercase;

        span {
            background: white;
            padding: 10px;
            border: 2px red solid;
            border-radius: 5px;
            font-weight: 800;
            display: inline-block;
        }
    }

    .part {
        border: 1px lightgray solid;
        width: 100%;

        h3 > span {
            background: white;
            padding: 10px;
            border: 2px lightskyblue solid;
            border-radius: 5px;
            font-weight: 800;
            color: black;
            margin-left: 10px;
            display: inline-block;
        }
    }

    .label-veg {

        text-transform: uppercase;
        background: #15b833;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        margin-left: -16px;
    }

    p {
        span {
            background: white;
            padding: 10px;
            border: 2px lightskyblue solid;
            border-radius: 5px;
            font-weight: 800;
            color: black;
            margin-left: 10px;
            display: inline-block;
        }
    }

    .input-group-text {
        padding: 0 15px 0 15px;
        min-width: 80px;
        display: flex;
        justify-content: center;
    }

    .preparation {
        .input-group-text {
            min-width: 20px;
        }
    }
</style>