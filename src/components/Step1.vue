<template>
    <form v-on:submit.prevent="submit" class="flex-wrap d-flex justify-content-center">

        <div class="row d-flex justify-content-center mt-5 w-100">

            <h2 class="col-md-12 col-sm-12">ШАГ 1: Расчет необходимого
                объема препарата «ЭКО-СП»</h2>


            <div class="col-md-6 col-sm-12">
                <div class="form-group need_vegetation">
                    <label class="checkbox-inline">
                        <input type="checkbox" v-model="form.prepare.need_seed_preparation">Не проводить
                        обработку
                        семян
                    </label>
                </div>
            </div>

            <div class="row d-flex justify-content-center part pb-2 mt-2" v-if="!form.prepare.need_seed_preparation">
                <h3 class="col-md-12 col-sm-12 upper ">Обработка
                    семян</h3>

                <div class="col-md-12 col-lg-8 col-sm-12 mt-2">

                    <div class="input-group mb-3">
                        <input name="seedssquare"
                               v-model="form.crop_area"
                               type="number"
                               min="0"
                               pattern="[0-9]{1,10}"
                               class="form-control input-lg"
                               placeholder="Площадь посевов" required>
                        <div class="input-group-append">
                            <span class="input-group-text">га</span>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input name="seedsnorm"
                               v-model="form.prepare.seeding_rate"
                               type="number"
                               min="0"
                               class="form-control input-lg"
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
                            <a href="#calc-about" v-b-modal.modal-1>
                                <div class="calc-about">?</div>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6 col-sm-4 col-md-4 col-lg-2 mb-2 d-flex justify-content-center flex-wrap"
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

                    <div class="volume">Необходимый объём «ЭКО-СП»:
                        <span>{{form.prepare.required_volume.toFixed(2)}}</span> л
                    </div>
                </div>
            </div>

        </div>

        <div class="row d-flex justify-content-center mt-2 part ">
            <h3 class="col-md-12 col-sm-12 upper part">Вегетация</h3>

            <div class="col-md-8 col-sm-10 mb-3 mt-3">

                <div class="input-group ">
                    <input class="form-control input-lg"
                           v-model="form.crop_area"
                           type="number"
                           placeholder="Площадь посевов" required>
                    <div class="input-group-append">
                        <span class="input-group-text">га</span>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center flex-wrap mt-2" v-for="(vegetation,index) in form.vegetation"
                 v-if="form.vegetation">

                <div class="col-md-12 d-flex justify-content-start w-100 mb-3">
                    <h4 class="label-veg">{{prepareTextNumber(index)}} обработка по вегетации
                    </h4>
                </div>

                <div class="col-md-8 col-sm-10">


                    <div class="input-group mb-3">
                        <input name="seedsnorm" type="text" class="form-control input-lg"
                               placeholder="Норма расхода рабочего раствора" v-model="vegetation.seeding_rate"
                               v-on:keyup="onChangeVegetation(index)" required>
                        <div class="input-group-append">
                            <span class="input-group-text">л/га</span>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12 col-lg-11">
                        <h4>Норма внесения препарата «ЭКО-СП» для обработки семян:</h4>
                    </div>
                    <div class="col-md-12 col-lg-1 d-flex justify-content-center">
                        <a href="#calc-about-2" v-b-modal.modal-2>
                            <div class="calc-about">?</div>
                        </a>
                    </div>
                </div>


                <div class="row flex-nowrap shkala-long justify-content-between">
                    <div class="col-xs-2" v-for="(rate,index) in application_rate_of_the_drug_vegetation">
                        <div class="shkala-circle active" v-if="vegetation.application_rate_selected===index"></div>
                        <div class="shkala-circle" v-else></div>
                        <span>{{rate}}л</span>
                    </div>
                </div>


                <div class="row w-100 justify-content-center d-flex">
                    <p class="text-center">Концентрация гумусовых веществ: <span>{{vegetation.concentration_of_humic_substances.toFixed(2)}}</span>
                        %
                    </p>
                </div>
                <div class="row w-100 d-flex justify-content-center">
                    <p class="volume">Необходимый объём «ЭКО-СП»: <span>{{vegetation.required_volume.toFixed(2)}}</span>
                        л
                    </p>
                </div>

            </div>

            <button type="button" class="btn btn-primary mb-2" @click="addVegetation"
                    v-if="this.form.vegetation.length<3">Добавить еще обработку
            </button>
        </div>


        <div class="row d-flex justify-content-center mt-2 part">
            <h3 class="col-md-12 col-sm-12 upper part m-0">Ваш общий необходимый объем<span>{{this.form.summary_required_volume.toFixed(2)}}</span>
                л</h3>
        </div>

        <div class="row d-flex justify-content-center mt-2 w-100 mb-5">
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary w-100 p-3" v-if="is_show"
                >ШАГ 2: Расчет стоимости препарата «ЭКО-СП»
                </button>
            </div>
        </div>


        <b-modal id="modal-1" title="Норма расхода рабочего раствора при обработке семян(л/т)">
            <p class="my-4">Hello from modal!</p>

            <template #modal-footer="{ cancel }">
                <b-button size="sm" variant="info" @click="cancel()">
                    Спасибо, прочитал!
                </b-button>
            </template>
        </b-modal>


        <b-modal id="modal-2" title="Норма внесения препарата «ЭКО-СП» для обработки семян">
            <p class="my-4">Hello from modal!</p>

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
                    need_seed_preparation: true,
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

            'form.crop_area': function (newVal) {
                this.calc()
            },
            'form.prepare.seeding_rate': function (newVal) {
                this.calc()
                this.$store.dispatch("setSeedingRate", newVal)

            }
        },
        methods: {
            calc() {
                this.form.prepare.required_volume = Math.round((this.form.crop_area * this.form.prepare.seeding_rate) /
                    (1000 * this.application_rate_of_the_drug_preparation[this.form.prepare.application_rate_selected]))

                this.form.summary_required_volume = this.form.prepare.required_volume;
                this.form.vegetation.forEach(item => {
                    this.form.summary_required_volume += item.required_volume
                })


            },
            onChangeVegetation(vegIndex) {


                this.form.vegetation.forEach(item => {
                    let rateFound = false;
                    for (let index in this.rate) {
                        let sub = this.rate[index]

                        if (sub.from <= item.seeding_rate && item.seeding_rate <= sub.to) {
                            this.form.vegetation[vegIndex].application_rate_selected = parseInt(index)
                            this.form.vegetation[vegIndex].required_volume = item.seeding_rate * this.application_rate_of_the_drug_vegetation[parseInt(index)]
                            this.form.vegetation[vegIndex].concentration_of_humic_substances = this.application_rate_of_the_drug_vegetation[parseInt(index)]*0.015 / this.form.vegetation[vegIndex].required_volume * 100;

                            rateFound = true;

                            break;
                        }
                    }

                    if (!rateFound)
                        this.form.vegetation[vegIndex].application_rate_selected = this.rate.length - 1

                })


                this.calc()
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
            addVegetation() {
                if (this.form.vegetation.length <= 2) {

                    this.form.vegetation.push({
                        seeding_rate: null,
                        application_rate_selected: 0,
                        concentration_of_humic_substances: 0.01,
                        required_volume: 0,
                    })

                    this.calc()
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
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
        padding: 20px;
        background: gray;
        text-transform: uppercase;
        font-size: 18px;
        font-weight: 800;
        color: white;
    }

    .calc-about {
        width: 025px;
        height: 25px;
        background: #007bff;
        color: white;
        border-radius: 50%;
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
        }
    }

    .shkala-long {
        max-width: 550px;
        @media (max-width: 769px) {
            max-width: 358px;
        }
    }

    .volume {
        padding: 20px;
        background: lightgray;
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
        padding: 10px 10px;
        background: #048b04;
        min-width: 200px;
        text-transform: uppercase;
        font-weight: 900;
        color: white;
        font-size: 14px;
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
        }
    }
</style>