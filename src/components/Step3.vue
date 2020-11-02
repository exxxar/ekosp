<template>
    <form v-on:submit.prevent="submit" class="flex-wrap d-flex justify-content-center" id="step3">

        <h2>ШАГ 3: Расчет экономической эффективности применения препарата «ЭКО-СП»</h2>


        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.crop_area"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Площадь посевов">
                    <div class="input-group-append">
                        <span class="input-group-text">га</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.seeding_rate"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Норма высева">
                    <div class="input-group-append">
                        <span class="input-group-text">кг/га</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.planned_yield"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Планируемая урожайность">
                    <div class="input-group-append">
                        <span class="input-group-text">ц/га</span>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input name="seedssquare"
                           v-model="form.yield_cost"
                           type="number"
                           min="0"
                           class="form-control form-control-lg"
                           placeholder="Стоимость урожая">
                    <div class="input-group-append">
                        <span class="input-group-text">руб/т</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="container itog">
            <div class="row">
                <div class="col-md-5">Предпосевная обработка семян:</div>
                <div class="col-md-3"><span>{{one.prepare.required_volume}}</span> л</div>
                <div class="col-md-3"><span>{{(one.prepare.required_volume*basePrice).toFixed(2)}}</span> руб</div>
            </div>

            <div class="row" v-for="(vegetation, index) in one.vegetation">
                <div class="col-md-5">{{prepareTextNumber(index)}} обработка по вегетации:</div>
                <div class="col-md-3"><span>{{vegetation.required_volume.toFixed(2)}}</span> л</div>
                <div class="col-md-3"><span>{{(vegetation.required_volume*basePrice).toFixed(2)}}</span> руб</div>
            </div>


            <hr class="w-100"/>

            <div class="row itogblue">
                <div class="col-md-5">Итоговые инвестиции хозяйства:</div>
                <div class="col-md-3"><span>{{currentVolume.toFixed(2)}}</span> л</div>
                <div class="col-md-3"><span>{{(currentVolume*basePrice).toFixed(2)}}</span> руб</div>
            </div>
            <div class="row itogblue">
                <div class="col-md-5">Прирост урожайности:</div>
                <div class="col-md-3"><span>{{getIncraceRate()}}</span> %</div>
                <div class="col-md-3"><span>{{getIncreaseCentners()}}</span> ц/га</div>
                <div class="col-md-1 col-sm-12 d-flex justify-content-center align-items-center " v-b-modal.modal-4><a
                    href="#calc-about">
                    <div class="calc-about">?</div>
                </a></div>
            </div>
        </div>

        <div class="row d-flex align-items-center flex-column w-100 mt-5 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5>Прибавка в деньгах<strong class="text-danger">*</strong>: <span>{{getIncreaseMoney()}}</span> руб
                </h5>
            </div>

            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Дополнительная выручка от продажи дополнительного объема урожая полученного от увеличения
                    урожайности.</p>
            </div>
        </div>

        <div class="row d-flex align-items-center w-100 flex-column rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5 class="w-100">Чистая прибыль <strong class="text-danger">*</strong>: <span>{{getNetProfit()}}</span>
                    руб</h5>
            </div>

            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Расчетная «чистая прибыль» от использования ЭКО-СП: дополнительная выручка минус расходы на покупку и
                    использование «ЭКО-СП» совместно с СЗР.</p>
            </div>
        </div>

        <div class="row d-flex align-items-center w-100 flex-column w-100 rez-panel">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <h5>Рентабельность гектара <strong class="text-danger">*</strong>: <span>{{getProfitability()}}</span>
                    руб</h5>
            </div>

            <div class="col-lg-8 col-md-12 col-sm-12">
                <p>Экономическая эффективность использования ЭКО-СП на 1 га</p>
            </div>
        </div>


        <div class="dis-line"></div>


        <div class="row d-flex justify-content-center w-100 flex-wrap mb-5">
            <div class="col-lg-8 col-md-12 col-sm-12 mt-2">
                <button type="submit" class="btn success-custom w-100">Сохранить файл и выслать на почту</button>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12 mt-2">
                <button type="submit" class="btn btn-primary primary-custom w-100">Сгенерировать официальное
                    коммерческое предложение и
                    выслать на
                    почту
                </button>
            </div>
        </div>


        <b-modal id="modal-4" title="Информация">
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
                vegetation: [0, 7, 11, 12.4],

                form: {
                    crop_area: null,
                    seeding_rate: null,
                    planned_yield: null,
                    yield_cost: null
                }
            }
        },
        watch: {

            'form.seeding_rate': function (newVal) {
                this.$store.dispatch("setSeedingRate", newVal)
            }
        },
        computed: {
            zero: function () {
                return this.$store.getters.Zero
            },
            two: function () {
                return this.$store.getters.Two
            },
            one: function () {
                return this.$store.getters.One
            },
            cropArea: function () {
                return this.$store.getters.GetCropArea
            },
            seedingRate: function () {
                return this.$store.getters.GetSeedingRate
            },
            basePrice: function () {
                return this.$store.getters.GetBasePrice
            },
            currentVolume: function () {
                return this.$store.getters.GetCurrentVolume
            },
            vegetationCount: function () {
                return this.$store.getters.GetVegetationCount
            }
        },
        mounted() {
            this.form.crop_area = this.cropArea
            this.form.seeding_rate = this.seedingRate
        },
        methods: {
            prepareTextNumber(number) {
                let arr = ["Первая", "Вторая", "Третья"];
                return arr[number > 0 && number < arr.length ? number : 0]
            },
            getIncraceRate() {
                let preparation = this.one.need_seed_preparation ? 1.9 : 0;
                return this.vegetation[this.vegetationCount] + preparation
            },
            getIncreaseCentners() {
                if (this.form.planned_yield == null)
                    return 0;

                let preparation = this.one.need_seed_preparation ? 1.9 : 0;


                return (this.form.planned_yield / 100 * (this.vegetation[this.vegetationCount] + preparation)).toFixed(2)
            },
            getIncreaseMoney() {
                if (this.form.crop_area == null)
                    return 0;

                return ((this.form.crop_area * this.getIncreaseCentners() * this.form.yield_cost) / 10).toFixed(2)
            },
            getNetProfit() {
                // return (this.getIncreaseMoney() * (this.basePrice * this.currentVolume)).toFixed(2)
                return (Math.abs((this.basePrice * this.currentVolume) - this.getIncreaseMoney())).toFixed(2)
            },
            getProfitability() {
                if (this.form.crop_area == null)
                    return 0;
                return Math.abs((this.getNetProfit() / this.form.crop_area)).toFixed(2)
            },
            submit() {
                this.$store.dispatch("submitResult")
                this.notify("Заявка успешно отправлена! Спасибо что выбрали нас!")
            },
            notify(text) {
                this.$notify({
                    group: 'foo',
                    title: 'ЭКО-СП',
                    type: 'success',
                    text: text
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

    .input-group-text {
        padding: 0 15px 0 15px;
        min-width: 80px;
        display: flex;
        justify-content: center;
    }

    .rez-panel {

        h5 {
            padding: 10px;
            background: #eee;
            border: 1px lightgray solid;

            span {
                padding: 10px;
                border: 2px lightskyblue solid;
                background: white;
                border-radius: 5px;
                display: inline-block;
            }
        }
    }

    .calc-about {
        width: 025px;
        height: 25px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        font-weight: 100;

        &:focus {
            outline: none;
        }
    }

    .itog {
        padding: 20px;
        font-weight: 600;
        line-height: 200%;
        border-radius: 5px;
        border: 1px lightgray solid;

        .itogblue {
            color: deepskyblue;
        }
    }
</style>